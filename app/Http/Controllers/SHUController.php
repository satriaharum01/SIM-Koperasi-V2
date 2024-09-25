<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biaya;
use App\Models\Pembayaran;
use App\Models\Pinjaman;
use App\Models\Simpanan;
use App\Models\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class SHUController extends Controller
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
        $this->view = 'admin/shu/index';
        $this->page = '/admin/shu';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Sisa Hasil Usaha Koperasi';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/shu/index', $this->data);
    }

    public function cetak($start = 0, $end = 0)
    {
        $this->data['title'] = 'Sisa Hasil Usaha Periode ' . $start . ' s/d ' . $end;

        $this->data['load'] = (object)$this->load($start, $end);
        $this->data['anggota'] = $this->pembagian_anggota($start, $end);
        $this->view = 'admin/shu/cetak';
        $this->data['start'] = $start;
        $this->data['end'] = $end;
        //return($this->data['load']);
        return view($this->view, $this->data);
    }

    public function load($start = 0, $end = 0)
    {
        $x = Settings::select('*')->where('parameter', 'Bunga Koperasi')->first();
        $a = Settings::select('*')->where('parameter', 'SHU Jasa Anggota')->first();
        $b = Settings::select('*')->where('parameter', 'SHU Jasa Modal')->first();
        $c = Settings::select('*')->where('parameter', 'SHU Pengurus')->first();
        $d = Settings::select('*')->where('parameter', 'SHU Cadangan Modal Anggota')->first();
        $data = [];
        $start = date('Y-m-d', strtotime($start));
        $end = date('Y-m-d', strtotime($end));
        $data['biaya'] = Biaya::select('jumlah')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->sum('jumlah');
        $data['pinjaman'] = 0;
        $data['simpanan'] = Simpanan::select('jumlah')
                            ->where('created_at', '>=', $start)
                            ->where('created_at', '<=', $end)->sum('jumlah');
        $pendapatan = 0;

        $nasabah = User::select('*')->where('level', 'Anggota')->get();

        foreach($nasabah as $row) {
            $p = Pinjaman::select('*')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->where('id_user', $row->id)->orderBy('id_pinjam', 'ASC')->get();

            foreach($p as $low) {
                $data['pinjaman'] = $data['pinjaman'] + $low->jumlah ;
                $bunga = $low->jumlah * $x->value / 100;
                $bayar = Pembayaran::select('*')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->where('id_pinjam', $low->id_pinjam)->count();

                $pendapatan = $pendapatan + ($bayar * $bunga);
                $row->pendapatan = $row->pendapatan + ($bayar * $bunga);
                $row->bunga = $bunga;
            }
            $data['pendapatan'] = $pendapatan;
        }

        $data['shu'] = $data['pendapatan'] - $data['biaya'];
        $data['jasa_anggota'] = $data['shu'] * $a->value / 100;
        $data['jasa_modal'] = $data['shu'] * $b->value / 100;
        $data['pengurus'] = $data['shu'] * $c->value / 100;
        $data['modal'] = $data['shu'] * $d->value / 100;
        $data['a'] = $a->value .'%';
        $data['b'] = $b->value .'%';
        $data['c'] = $c->value .'%';
        $data['d'] = $d->value .'%';

        return $data;
    }

    public function pembagian_anggota($start, $end)
    {
        $shu = $this->load($start, $end);

        $start = date('Y-m-d', strtotime($start));
        $end = date('Y-m-d', strtotime($end));
        $nasabah = User::select('*')->where('level', 'Anggota')->get();
        $pinjaman = Pinjaman::select('jumlah')
                    ->where('created_at', '>=', $start)
                    ->where('created_at', '<=', $end)->sum('jumlah');
        $simpanan = Simpanan::select('jumlah')
                    ->where('created_at', '>=', $start)
                    ->where('created_at', '<=', $end)->sum('jumlah');

        foreach($nasabah as $row) {
            $p = Pinjaman::select('jumlah')
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)
                ->where('id_user', $row->id)->sum('jumlah');

            $a = Simpanan::select('jumlah')
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)
                ->where('id_user', $row->id)->sum('jumlah');

            $row->jasa_anggota = ($shu['jasa_anggota'] / $pinjaman) * $p;
            $row->jasa_modal = ($shu['jasa_modal'] / $simpanan) * $a;
            $row->modal = ($shu['modal'] / $simpanan) * $a;
        }

        return $nasabah;
    }
}
