<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use App\Models\Pembayaran;
use App\Models\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class PinjamanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //Start Controller Function
        $this->middleware('auth');
        $this->middleware('is_admin');
        $this->view = 'admin/pinjaman/index';
        $this->page = '/admin/pinjaman';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Pinjaman Nasabah';
        $bunga = Settings::select('*')->where('parameter', 'Bunga Koperasi')->first();
        $this->data['bunga'] = $bunga;
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/pinjaman/index', $this->data);
    }

    public function detail($id)
    {
        $pinjaman = Pinjaman::findorfail($id);
        $user = User::find($pinjaman->id_user);
        $this->data['user'] = $user;
        $this->data['id_pinjam'] = $id;
        $this->data[ 'title' ] = 'Data Pinjaman '. $user->name;
        return view('admin/pinjaman/detail', $this->data);
    }

    public function json()
    {
        $data = Pinjaman::select('*')->orderBy('created_at', 'DESC')->get();

        foreach($data as $row) {
            $row->telepon = '62' . $row->telepon;
            $row->name = $row->cari_user->name;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function json_detail($id)
    {
        $data = Pinjaman::select('*')->where('id_pinjam', $id)->get();
        $bunga = Settings::select('*')->where('parameter', 'Bunga Koperasi')->first();
        foreach($data as $row) {
            $date = strtotime($row->created_at);
            $row->tanggal = date('d-m-Y', $date);
            $bunga_pinjaman = $row->jumlah * $bunga->value / 100;
            $row->cicilan = ($row->jumlah / $row->tenor) + $bunga_pinjaman;
            $row->pembayaran = Pembayaran::select('*')->where('id_pinjam', $row->id_pinjam)->count(). ' / ' .$row->tenor;
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function json_pembayaran($id)
    {
        $data = Pembayaran::select('*')
            ->where('id_pinjam', $id)
            ->get();

        foreach($data as $row) {
            $date = strtotime($row->created_at);
            $row->tanggal = date('d-m-Y', $date);
            $row->nasabah = $row->cari_pinjaman->cari_user->name;
            $row->pinjaman = $row->cari_pinjaman->jumlah;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Pinjaman::find($id);

        $data = [
            'id_user' => $request->id_user,
            'tenor' => $request->tenor,
            'jumlah' => $request->jumlah,
            'status' => $request->status,
            'created_at' => $request->tanggal,
            'keterangan' => $request->keterangan
        ];
        $rows->update($data);

        return redirect(url('/admin/pinjaman/'));
    }

    public function store(Request $request)
    {
        $data = [
            'id_user' => $request->id_user,
            'tenor' => $request->tenor,
            'jumlah' => $request->jumlah,
            'status' => $request->status,
            'created_at' => $request->tanggal,
            'keterangan' => $request->keterangan
        ];

        DB::table('pinjaman')->insert($data);
        return redirect(url('/admin/pinjaman/'));
    }

    public function bayar(Request $request)
    {
        $data = [
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'created_at' => $request->tanggal,
            'id_pinjam' => $request->id_pinjam
        ];

        DB::table('pinjaman_bayar')->insert($data);
        return redirect(url('admin/pinjaman/detail/'.$request->id_pinjam));
    }

    public function update_bayar(Request $request, $id)
    {
        $rows = Pembayaran::find($id);

        $data = [
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'created_at' => $request->tanggal,
            'id_pinjam' => $request->id_pinjam
        ];

        $rows->update($data);

        return redirect(url('admin/pinjaman/detail/'.$request->id_pinjam));
    }

    public function destroy($id, $id_user)
    {
        $rows = Pinjaman::findOrFail($id);
        $rows->delete();

        return redirect(url('/admin/pinjaman/'));
    }

    public function find($id)
    {
        $data = Pinjaman::select('*')->where('id_pinjam', $id)->get();
        foreach($data as $row) {
            $date = strtotime($row->created_at);
            $row->tanggal = date('Y-m-d', $date);
        }
        return json_encode(array('data' => $data));
    }

    public function validasi(Request $request, $id)
    {
        $rows = Pinjaman::find($id);

        $data = [
            'status' => $request->status
        ];
        $rows->update($data);

        return redirect(url('/admin/pinjaman/'));
    }
}
