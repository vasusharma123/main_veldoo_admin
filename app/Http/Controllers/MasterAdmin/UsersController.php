<?php

namespace App\Http\Controllers\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ride;
use App\RideHistory;
use DataTables;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Exports\RideExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Auth;
use Hash;
use Storage;
use App\Price;
use Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $redirectTo = '/home';

     public function dashboard(){
        $data = array('page_title' => 'Dashboard', 'action' => 'Dashboard');
        return view('dashboards.master_admin')->with($data);

    }

    public function getSettings(){
        $data = array('page_title' => 'Settings', 'action' => 'Settings');
        return view('master_admin.setting')->with($data);

    }
	

    public function logout(Request $request){
        Session::flush();
        Auth::logout();
        return Redirect('master-login');
	}


        
}
