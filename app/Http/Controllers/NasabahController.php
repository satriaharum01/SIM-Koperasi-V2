<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class NasabahController extends Controller
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
        $this->view = 'admin/nasabah/index';
        $this->page = '/admin/nasabah';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Nasabah';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/nasabah/index', $this->data);
    }


    public function json()
    {
        $data = User::select('*')
            ->where('level', 'Anggota')
            ->get();

        foreach($data as $row) {
            $row->no_hp = '0' . $row->no_hp;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = User::find($id);

        if($request->password == true) {
            $rows->update([
                'name' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'profesi' => $request->profesi,
                'alamat' => $request->alamat,
                'status' => 'Aktif',
                'level' => 'Anggota',
                'level_gaji' => $request->level_gaji,
                'password' => Hash::make($request->password),
                'updated_at' => now()
            ]);
        } else {
            $rows->update([
                'name' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'profesi' => $request->profesi,
                'alamat' => $request->alamat,
                'status' => 'Aktif',
                'level' => 'Anggota',
                'level_gaji' => $request->level_gaji,
                'last_login' => '',
                'updated_at' => now()
            ]);
        }
        return redirect(route('admin.pegawai'));
    }

    public function store(Request $request)
    {
        if($request->password == true) {
            DB::table('users')->insert([
                'name' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'profesi' => $request->profesi,
                'alamat' => $request->alamat,
                'status' => 'Aktif',
                'level' => 'Anggota',
                'level_gaji' => $request->level_gaji,
                'password' => Hash::make($request->password),
                'last_login' => now(),
                'updated_at' => now()
            ]);
        } else {
            DB::table('users')->insert([
                'name' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'profesi' => $request->profesi,
                'alamat' => $request->alamat,
                'status' => 'Aktif',
                'level' => 'Anggota',
                'level_gaji' => $request->level_gaji,
                'last_login' => now(),
                'updated_at' => now()
            ]);
        }
        return redirect(route('admin.nasabah'));
    }

    public function destroy($id)
    {
        $rows = User::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.nasabah'));
    }

    public function find($id)
    {
        $data = User::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }
}
