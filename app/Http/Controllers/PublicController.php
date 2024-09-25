<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Simpanan;
use App\Models\Pembayaran;
use App\Models\Pinjaman;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return redirect(route('login'));
        $this->data['page'] = 'Front';
        return view('landing.index', $this->data);
    }

    public function input_simpanan($id)
    {
        $data = [
            'jumlah' => 10000,
            'keterangan' => 'Simpanan Wajib',
            'id_user' => $id,
            'created_at'
        ];

        for ($i = 5; $i <= 12; $i++) {
            if($i < 10) {
                $j = '0'.$i;
            } else {
                $j = $i;
            }

            $data['created_at'] = '2021-'.$j.'-01';

            Simpanan::create($data);
        }

        return print_r($data);
    }

    public function input_simpanan_2($id)
    {
        $data = [
            'jumlah' => 10000,
            'keterangan' => 'Simpanan Wajib',
            'id_user' => $id,
            'created_at'
        ];

        for ($i = 1; $i <= 5; $i++) {
            if($i < 10) {
                $j = '0'.$i;
            } else {
                $j = $i;
            }

            $data['created_at'] = '2022-'.$j.'-01';

            Simpanan::create($data);
        }

        return print_r($data);
    }


    public function input_pembayaran($id, $jumlah, $start, $end, $year)
    {
        $data = [
            'jumlah'  => $jumlah,
            'keterangan' => 'Pembayaran Pinjaman',
            'id_pinjam' => $id,
            'created_at'
        ];
        if($start >= $end) {
            for ($i = $start; $i <= 12; $i++) {
                if($i < 10) {
                    $j = '0'.$i;
                } else {
                    $j = $i;
                }

                $data['created_at'] = '2021-'.$j.'-01';

                Pembayaran::create($data);
            }
            for ($i = 1; $i <= $end; $i++) {
                if($i < 10) {
                    $j = '0'.$i;
                } else {
                    $j = $i;
                }

                $data['created_at'] = '2022-'.$j.'-01';

                Pembayaran::create($data);
            }
        } else {
            for ($i = $start; $i <= $end; $i++) {
                if($i < 10) {
                    $j = '0'.$i;
                } else {
                    $j = $i;
                }

                $data['created_at'] = $year.'-'.$j.'-01';

                Pembayaran::create($data);
            }
        }


        return print_r($data);
    }

    public function set_pembayaran($id)
    {
        $data = [
            'keterangan' => 'Pembayaran Pinjaman',
            'id_pinjam' => $id
        ];

        $p = Pinjaman::find($id);

        $pokok = $p->jumlah / $p->tenor;
        $bunga = $p->jumlah * 1.5 / 100;
        $cicilan = $pokok + $bunga;
        $data['jumlah'] = $cicilan;

        for($i = 1; $i <= $p->tenor; $i++) {
            $batas = strtotime('2022-06-01');
            $time = strtotime($p->created_at);
            $data['created_at'] =  date('Y-m-d', strtotime("+".$i." month", $time));

            if(date('Y-m-d', strtotime("+".$i." month", $time)) < date('Y-m-d', $batas)) {
                Pembayaran::create($data);
            }

        }

        print_r($data);
    }
}
