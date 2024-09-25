<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biaya;
use App\Models\Pembayaran;
use App\Models\Pinjaman;
use App\Models\Simpanan;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
        $this->data['title'] = 'Dashboard Admin';
        $this->data['path'] = url('/file');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->data['c_nasabah'] = $this->get_nasabah();
        $this->data['c_pinjaman'] = $this->get_pinjaman_aktif();
        $this->data['c_tagihan'] = $this->get_tagihan();
        $this->data['c_kas'] = $this->sisa_kas();
        $this->data['title'] = 'Dashboard Admin';

        return view('admin/dashboard/index', $this->data);
    }

    public function graph_area($tahun)
    {
        $out = array();
        $date = $tahun;
        for($i = 1; $i <= 12 ; $i++) {
            if($i < 10) {
                $finder = $date . '-0' . $i;
            } else {
                $finder = $date . '-'.$i;
            }
            $builder = $this->load_periode($finder.'-00', $finder.'-31');
            $saldo = $this->saldo_periode($finder.'-31');

            $data = $builder['pinjaman'];
            $data2 = $saldo['saldo'];
            $out['pinjaman'][] = $data;
            $out['kas'][] = $data2 ;
            $out['saldo'][] = - $out['kas'][$i - 1];
        }

        return json_encode($out);
    }

    //Monitor
    public function get_nasabah()
    {
        $data = User::select('*')
                ->where('level', 'Anggota')->count();

        return $data;
    }

    public function get_pinjaman_aktif()
    {
        $data = Pinjaman::select('*')
                ->where('status', 'Disetujui')->count();

        return $data;
    }

    public function get_tagihan()
    {
        $tagihan = 0;
        $data = Pinjaman::select('*')
                ->where('status', 'Disetujui')->get();

        foreach($data as $row) {
            $pokok = $row->jumlah / $row->tenor;
            $bunga = $row->jumlah * 1.5 / 100;
            $cicilan = $pokok + $bunga;
            $total_bayar = $cicilan * $row->tenor;
            $bayar = Pembayaran::select('jumlah')->where('id_pinjam', $row->id_pinjam)->sum('jumlah');

            $tagihan -= $total_bayar - $bayar;
        }

        return number_format($tagihan);
    }

    public function sisa_kas()
    {
        $debit = 0;
        $kredit = 0;

        //Debit
        $tagihan = 0;
        $simpanan = 0;

        $data = Pinjaman::select('*')->get();

        foreach($data as $row) {
            $pokok = $row->jumlah / $row->tenor;
            $bunga = $row->jumlah * 1.5 / 100;
            $cicilan = $pokok + $bunga;
            $total_bayar = $cicilan * $row->tenor;
            $bayar = Pembayaran::select('jumlah')->where('id_pinjam', $row->id_pinjam)->sum('jumlah');

            $tagihan -=  $bayar;
        }

        $simpanan = Simpanan::select('jumlah')->sum('jumlah');

        //Kredit
        $pinjaman = 0;
        $biaya = 0;

        $pinjaman = Pinjaman::select('jumlah')->sum('jumlah');
        $biaya = Biaya::select('jumlah')->sum('jumlah');

        //Sisa Kas
        $debit = abs($tagihan) + $simpanan;
        $kredit = $pinjaman + $biaya;
        $kas = abs($debit) - abs($kredit);

        return number_format($kas);
    }

    public function load_periode($start, $end)
    {
        $data = array();

        $pembayaran = Pembayaran::select('*')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->sum('jumlah');
        $simpanan = Simpanan::select('*')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->sum('jumlah');

        $pinjaman = Pinjaman::select('*')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('id_pinjam', 'ASC')->sum('jumlah');
        $biaya = Biaya::select('*')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->sum('jumlah');

        $debit = $pembayaran + $simpanan;
        $kredit = $pinjaman + $biaya;
        $kas = abs($debit) - abs($kredit);
        $data['pinjaman'] = round(abs($pinjaman), 0);
        $data['saldo'] = round($kas, 0);

        return $data;
    }
    public function saldo_periode($end)
    {
        $data = array();

        $pembayaran = Pembayaran::select('*')->where('created_at', '<=', $end)->sum('jumlah');
        $simpanan = Simpanan::select('*')->where('created_at', '<=', $end)->sum('jumlah');
        $pinjaman = Pinjaman::select('*')->where('created_at', '<=', $end)->sum('jumlah');
        $biaya = Biaya::select('*')->where('created_at', '<=', $end)->sum('jumlah');

        $debit = $pembayaran + $simpanan;
        $kredit = $pinjaman + $biaya;
        $kas = abs($debit) - abs($kredit);
        $data['saldo'] = round($kas, 0);

        return $data;
    }
}
