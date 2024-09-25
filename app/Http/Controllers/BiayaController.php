<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biaya;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class BiayaController extends Controller
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
        $this->view = 'admin/biaya/index';
        $this->page = '/admin/biaya';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Biaya Koperasi';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/biaya/index', $this->data);
    }

    public function json()
    {
        $data = Biaya::select('*')
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach($data as $row) {
            $row->tanggal = date('d F Y', strtotime($row->created_at));
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Simpanan::find($id);

        $data = [
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'created_at' => $request->tanggal
        ];

        $rows->update($data);

        return redirect(route('admin.biaya'));
    }

    public function store(Request $request)
    {
        $data = [
           'jumlah' => $request->jumlah,
           'keterangan' => $request->keterangan,
           'created_at' => $request->tanggal
        ];

        Biaya::create($data);

        return redirect(route('admin.biaya'));
    }

    public function destroy($id, $id_user)
    {
        $rows = Biaya::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.biaya'));
    }

    public function find($id)
    {
        $data = Biaya::select('*')->where('id', $id)->get();

        foreach($data as $row) {
            $row->tanggal = date('Y-m-d', strtotime($row->created_at));
        }

        return json_encode(array('data' => $data));
    }
}
