<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Hash;

class SettingController extends Controller
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
        $this->view = 'admin/pengaturan/index';
        $this->page = '/admin/pengaturan';
        $this->data['page'] = $this->page;
        $this->data[ 'title' ] = 'Pengaturan Website';
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/pengaturan/index', $this->data);
    }

    public function json()
    {
        $data = Settings::select('*')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Settings::find($id);

        $data = [
            'value' => $request->value
        ];

        $rows->update($data);

        return redirect(route('admin.pengaturan'));
    }

    public function find($id)
    {
        $data = Settings::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }
}
