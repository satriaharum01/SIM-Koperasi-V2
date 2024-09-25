<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Simpanan;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class SimpananController extends Controller
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
        $this->view = 'admin/simpanan/index';
        $this->page = '/admin/simpanan';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Simpanan Nasabah';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/simpanan/index', $this->data);
    }

    public function detail($id)
    {
        $user = User::find($id);
        $this->data['user'] = $user;
        $this->data[ 'title' ] = 'Data Simpanan '. $user->name;
        return view('admin/simpanan/detail', $this->data);
    }

    public function json()
    {
        $data = User::select('*')
            ->where('level', 'Anggota')
            ->get();

        foreach($data as $row) {
            $row->telepon = '62' . $row->telepon;
            $ss = Simpanan::select('jumlah')->where('id_user', $row->id)->get()->toArray();
            $row->simpanan =  array_sum(array_column($ss,'jumlah'));
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function json_detail($id)
    {
        $data = Simpanan::select('*')->where('id_user', $id)->get();
        
        foreach($data as $row)
        {
            $date = strtotime($row->created_at);
            $row->tanggal = date('d-m-Y', $date);
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Simpanan::find($id);

        $data = [
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'created_at' => $request->tanggal,
            'id_user' => $request->id_user
        ];
        $rows->update($data);

        return redirect(url('/admin/simpanan/detail/'. $request->id_user));
    }

    public function store(Request $request)
    {
        $data = [
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'created_at' => $request->tanggal,
            'id_user' => $request->id_user
        ];

        DB::table('simpanan')->insert($data);
        return redirect(url('/admin/simpanan/detail/'.$request->id_user));
    }

    public function destroy($id, $id_user)
    {
        $rows = Simpanan::findOrFail($id);
        $rows->delete();

        return redirect(url('/admin/simpanan/detail/'.$id_user));
    }

    public function find($id)
    {
        $data = Simpanan::select('*')->where('id_simpanan', $id)->get();
        foreach($data as $row){
            $date = strtotime($row->created_at);
            $row->tanggal = date('Y-m-d', $date);
        }
        return json_encode(array('data' => $data));
    }
}
