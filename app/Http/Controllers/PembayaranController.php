<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Pinjaman;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class PembayaranController extends Controller
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
        $this->view = 'admin/pembayaran/index';
        $this->page = '/admin/pembayaran';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Pembayaran Nasabah';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/pembayaran/index', $this->data);
    }

    public function detail($id)
    {
        $user = User::find($id);
        $this->data['user'] = $user;
        $this->data[ 'title' ] = 'Data Pembayaran ' . $user->name;
        return view('admin/pembayaran/detail', $this->data);
    }

    public function json()
    {
        $data = Pembayaran::select('*')
            ->get();

        foreach($data as $row) {
            $row->nasabah = $row->cari_pinjaman->cari_user->name;
            $row->pinjaman = $row->cari_pinjaman->jumlah;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function json_pinjaman()
    {
        $data = Pinjaman::select('*')
                ->where('status', 'Disetujui')
                ->get();

        foreach($data as $row) {
            $row->nasabah = $row->cari_user->name;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function json_detail($id)
    {
        $data = Simpanan::select('*')->where('id_user', $id)->get();

        foreach($data as $row) {
            $date = strtotime($row->created_at);
            $row->tanggal = date('d-m-Y', $date);
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Pembayaran::find($id);

        $data = [
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'created_at' => $request->tanggal,
            'id_pinjam' => $request->id_pinjam
        ];

        $rows->update($data);

        return redirect(route('admin.pembayaran'));
    }

    public function store(Request $request)
    {
        $data = [
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'created_at' => $request->tanggal,
            'id_pinjam' => $request->id_pinjam
        ];

        DB::table('pinjaman_bayar')->insert($data);
        return redirect(route('admin.pembayaran'));
    }

    public function destroy($id)
    {
        $rows = Pembayaran::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.pembayaran'));
    }

    public function find($id)
    {
        $data = Pembayaran::select('*')->where('id_bayar', $id)->get();
        foreach($data as $row) {
            $date = strtotime($row->created_at);
            $row->tanggal = date('Y-m-d', $date);
        }
        return json_encode(array('data' => $data));
    }

    //Filter
    public function pinjaman_aktif()
    {
        $data = Pinjaman::select('*')->where('status', 'Disetujui')->orderBy('created_at', 'DESC')->get();

        foreach($data as $row) {
            $row->telepon = '62' . $row->telepon;
            $row->nasabah = $row->cari_user->name;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
