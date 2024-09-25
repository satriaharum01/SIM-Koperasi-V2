<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengurusan;
use App\Models\TandaTangan;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use File;

class LoginPimpinan extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_pimpinan');
        $this->data['title'] = 'Dashboard Pimpinan';
        $this->data['path'] = url('/file');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->data['c_riwayat'] = $this->c_riwayat();
        $this->data['c_setuju'] = $this->c_setuju();
        $this->data['c_menunggu'] = $this->c_menunggu();
        $this->data['c_tolak'] = $this->c_tolak();
        $this->data['graph_area'] = $this->graph_area();
        $this->data['title'] = 'Dashboard Pimpinan';

        return view('pimpinan/dashboard/index', $this->data);
    }

    public function pengurusan()
    {
        $this->data[ 'title' ] = 'Data Pengurusan';
        $this->data[ 'link' ] = '/pimpinan/pengurusan';
        $this->page = '/pimpinan/pengurusan';
        $this->data['page'] = $this->page;
        return view('pimpinan/pengurusan/index', $this->data);
    }

    public function pengurusan_baru()
    {
        $this->data[ 'title' ] = 'Tambah Data Pengurusan';
        $this->data[ 'link' ] = '/pegawai/pengurusan/save';
        $this->page = '/pimpinan/pengurusan';
        $this->data['page'] = $this->page;
        return view('pimpinan/pengurusan/detail', $this->data);
    }

    public function pengurusan_edit($id)
    {
        $this->data[ 'title' ] = 'Ubah Data Pengurusan';
        $this->data[ 'link' ] = '/pimpinan/pengurusan/update/' . $id;
        $this->page = '/pimpinan/pengurusan';
        $this->data['page'] = $this->page;
        $this->data['load'] = Pengurusan::find($id);
        return view('pimpinan/pengurusan/detail', $this->data);
    }

    public function profil()
    {
        $this->data[ 'title' ] = 'Profil Pimpinan';
        $this->data[ 'link' ] = '/pimpinan/profil';
        $this->page = '/pimpinan/profil';
        $this->data['page'] = $this->page;
        $this->data['load'] = User::find(Auth::user()->id);
        return view('pimpinan/profil/index', $this->data);
    }

    public function c_riwayat()
    {
        $data = Pengurusan::select('*')->where('id_pimpinan', Auth::user()->id)->count();

        return $data;
    }

    public function c_setuju()
    {
        $data = Pengurusan::select('*')->where('id_pimpinan', Auth::user()->id)->where('status', 'Disetujui')->count();

        return $data;
    }

    public function c_menunggu()
    {
        $data = Pengurusan::select('*')->where('id_pimpinan', Auth::user()->id)->where('status', 'Menunggu')->count();

        return $data;
    }

    public function c_tolak()
    {
        $data = Pengurusan::select('*')->where('id_pimpinan', Auth::user()->id)->where('status', 'Ditolak')->count();

        return $data;
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
            $builder = Pengurusan::select('*')->where('id_pimpinan', Auth::user()->id)->where('tanggal', '>=', $finder . '-00')->where('tanggal', '<=', $finder . '-31');
            ;
            $data = $builder->count();

            $out[] = $data;
        }

        return json_encode($out);
    }
    //CRUD Pengurusan

    public function json()
    {
        $data = Pengurusan::select('*')
            ->where('id_pimpinan', Auth::user()->id)
            ->get();

        foreach($data as $row) {
            if(!empty($row->cari_pegawai->nip)) {
                $row->pegawai = $row->cari_pegawai->nip . ' - ' . $row->cari_pegawai->name;
            } else {
                $row->pegawai = 'Data Tidak Ditemukan';
            }
            if(!empty($row->cari_pimpinan->nip)) {
                $row->pimpinan = $row->cari_pimpinan->name . ' - ' . $row->cari_pimpinan->jabatan;
            } else {
                $row->pimpinan = 'Data Tidak Ditemukan';
            }
            if(!empty($row->cari_jenis->keterangan)) {
                $row->jenis = $row->cari_jenis->keterangan;
            } else {
                $row->jenis = 'Data Tidak Ditemukan';
            }
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Pengurusan::find($id);
        $data = [
            'status' => $request->status,
            'updated_at' => now()
        ];
        $rows->update($data);
        return redirect(route('pimpinan.pengurusan'));
    }


    public function find($id)
    {
        $data = Pengurusan::select('*')->where('id_pengurusan', $id)->get();
        foreach($data as $row) {
            if(!empty($row->cari_pegawai->nip)) {
                $row->pegawai = $row->cari_pegawai->nip . ' - ' . $row->cari_pegawai->name;
            } else {
                $row->pegawai = 'Data Tidak Ditemukan';
            }
            if(!empty($row->cari_pimpinan->nip)) {
                $row->pimpinan = $row->cari_pimpinan->name . ' - ' . $row->cari_pimpinan->jabatan;
            } else {
                $row->pimpinan = 'Data Tidak Ditemukan';
            }
        }
        return json_encode(array('data' => $data));
    }

}
