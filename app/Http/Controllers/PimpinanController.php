<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class PimpinanController extends Controller
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
        $this->view = 'admin/pimpinan/index';
        $this->page = '/admin/pimpinan';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Data Pimpinan';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/pimpinan/index', $this->data);
    }


    public function json()
    {
        $data = User::select('*')
            ->where('level', 'Pimpinan')
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
                'nip' => $request->nip,
                'no_hp' => $request->no_hp,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'password' => Hash::make($request->password),
                'updated_at' => now()
            ]);
        } else {
            $rows->update([
                'name' => $request->nama,
                'email' => $request->email,
                'nip' => $request->nip,
                'no_hp' => $request->no_hp,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'updated_at' => now()
            ]);
        }
        return redirect(route('admin.pimpinan'));
    }

    public function store(Request $request)
    {
        if($request->password == true) {
            DB::table('users')->insert([
                'name' => $request->nama,
                'email' => $request->email,
                'nip' => $request->nip,
                'no_hp' => $request->no_hp,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'password' => Hash::make($request->password),
                'level' => 'Pimpinan',
                'updated_at' => now()
            ]);
        } else {
            DB::table('users')->insert([
                'name' => $request->nama,
                'email' => $request->email,
                'nip' => $request->nip,
                'no_hp' => $request->no_hp,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'password' => '',
                'level' => 'Pimpinan',
                'updated_at' => now()
            ]);
        }
        return redirect(route('admin.pimpinan'));
    }

    public function destroy($id)
    {
        $rows = User::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.pimpinan'));
    }

    public function find($id)
    {
        $data = User::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }
}
