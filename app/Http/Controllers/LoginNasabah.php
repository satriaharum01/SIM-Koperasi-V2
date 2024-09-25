<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use App\Models\Pembayaran;
use App\Models\Simpanan;
use App\Models\Settings;

use Exception;
use DNS2D;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use File;

class LoginNasabah extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_pegawai');
        $this->data['title'] = 'Dashboard Nasabah';
        $this->data['path'] = url('/file');
        $bunga = Settings::select('*')->where('parameter', 'Bunga Koperasi')->first();
        $this->data['bunga'] = $bunga->value;
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->data['c_pinjaman'] = $this->c_pinjaman();
        $this->data['c_simpanan'] = $this->c_simpanan();
        $this->data['graph_area'] = $this->graph_area();
        $this->data['title'] = 'Dashboard Nasabah';

        return view('nasabah/dashboard/index', $this->data);
    }

    public function simpanan()
    {
        $this->data[ 'title' ] = 'Data Simpanan';
        $this->data[ 'link' ] = '/nasabah/simpanan';
        $this->page = '/nasabah/simpanan';
        $this->data['page'] = $this->page;
        return view('nasabah/simpanan/index', $this->data);
    }

    public function pembayaran()
    {
        $this->data[ 'title' ] = 'Data Pembayaran Pinjaman';
        $this->data[ 'link' ] = '/nasabah/pembayaran';
        $this->page = '/nasabah/pembayaran';
        $this->data['page'] = $this->page;
        return view('nasabah/pembayaran/index', $this->data);
    }

    public function pinjaman()
    {
        $this->data[ 'title' ] = 'Data Pinjaman';
        $this->data[ 'link' ] = '/nasabah/pinjaman';
        $this->page = '/nasabah/pinjaman';
        $this->data['page'] = $this->page;
        return view('nasabah/pinjaman/index', $this->data);
    }

    public function profil()
    {
        $this->data[ 'title' ] = 'Profil Nasabah';
        $this->data[ 'link' ] = '/nasabah/profil';
        $this->page = '/nasabah/profil';
        $this->data['page'] = $this->page;
        $this->data['load'] = User::find(Auth::user()->id);
        return view('nasabah/profil/index', $this->data);
    }


    public function graph_area()
    {
        $out = array();
        $date = date('Y-');
        for($i = 1; $i <= 12 ; $i++) {
            if($i < 10) {
                $finder = $date . '0' . $i;
            } else {
                $finder = $date . $i;
            }
            $builder = Simpanan::select('*')->where('id_user', Auth::user()->id)->where('created_at', '>=', $finder . '-00')->where('created_at', '<=', $finder . '-31');
            ;
            $data = $builder->count();

            $out[] = $data;
        }

        return json_encode($out);
    }
    //CRUD Pengurusan

    public function json_pinjaman()
    {
        $data = Pinjaman::select('*')
            ->where('id_user', Auth::user()->id)
            ->get();

        foreach($data as $row) {
            $row->telepon = '62' . $row->telepon;
            $row->name = $row->cari_user->name;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function json_simpanan()
    {
        $data = Simpanan::select('*')->where('id_user', Auth::user()->id)->get();

        foreach($data as $row) {
            $date = strtotime($row->created_at);
            $row->tanggal = date('d-m-Y', $date);
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update_pinjaman(Request $request, $id)
    {
        $rows = Pinjaman::find($id);

        $data = [
            'id_user' => Auth::user()->id,
            'tenor' => $request->tenor,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan
        ];
        $rows->update($data);

        return redirect(url('/nasabah/pinjaman/'));
    }

    public function update(Request $request, $id)
    {
        $rows = User::find($id);
        $data = [
            'name' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'updated_at' => now()
        ];
        if($request->password == true) {
            $data['password'] = Hash::make($request->password);
        }

        $rows->update($data);


        return redirect(route('nasabah.profil'));
    }

    public function store_pinjaman(Request $request)
    {
        $data = [
            'id_user' => Auth::user()->id,
            'tenor' => $request->tenor,
            'jumlah' => $request->jumlah,
            'status' => 'Menunggu',
            'keterangan' => $request->keterangan
        ];

        DB::table('pinjaman')->insert($data);
        return redirect(url('/nasabah/pinjaman/'));
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

    public function barcode($id)
    {
        $data = Pengurusan::select('*')->where('id_pengurusan', $id)->get();
        foreach($data as $row) {
            if(!empty($row->cari_pimpinan->nip)) {
                $row->generate = 'Disetujui ' . $row->tanggal . ' Oleh ' . $row->cari_pimpinan->name . ' - ' . $row->cari_pimpinan->jabatan;
            } else {
                $row->generate = 'Barcode Invalid';
            }
            $row->barcode = DNS2D::getBarcodeHTML($row->generate, 'QRCODE');
        }

        return json_encode(array('data' => $data));
    }

    public function file_destroy($filename)
    {
        if (File::exists(public_path('/file' . $filename . ''))) {
            File::delete(public_path('/file' . $filename . ''));
        }
    }

    public function json_pembayaran()
    {
        $data = Pinjaman::select('*')
            ->whereIn('status', ['Disetujui','Lunas'])
            ->where('id_user', Auth::user()->id)
            ->get();

        foreach($data as $row) {
            $row->telepon = '62' . $row->telepon;
            $row->name = $row->cari_user->name;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find_pembayaran($id)
    {
        $data = Pinjaman::select('*')->where('id_pinjam', $id)->first();

        try {
            $load = Pembayaran::select('*')->where('id_pinjam', $data->id_pinjam)->get();
        } catch (Exception $e) {
            $load = Pembayaran::select('*')->where('id_pinjam', 0)->get();
        }

        return Datatables::of($load)
            ->addIndexColumn()
            ->make(true);
    }

    //For Dashboard
    public function c_pinjaman()
    {
        $data = Pinjaman::select('*')->where('id_user', Auth::user()->id)->where('status', 'Disetujui')->first();
        if(!empty($data)) {
            return $data->jumlah;
        } else {
            return 0;
        }
    }

    public function c_simpanan()
    {
        $data = Simpanan::select('*')->where('id_user', Auth::user()->id)->get()->toArray();

        if(!empty($data)) {
            $result = array_sum(array_column($data, 'jumlah'));
            return $result;
        } else {
            return 0;
        }
    }
}
