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

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $redirectTo = '/master-login';


    public function login(Request $request)
    {
        Auth::logout();
        $data = array('page_title' => 'Login', 'action' => 'Login');
        return view('master_admin.login')->with($data);
    }


    public function masterLogin(Request $request){
        
		$rules = [
			'email' => 'required|email',
			'password' => 'required|min:6',
		];
		$request->validate($rules);
		$input = $request->all();
       
		$whereData = array('email' => $input['email'], 'password' => $input['password'], 'user_type' => 6);
        if(auth()->attempt($whereData)){
			// if (in_array(Auth::user()->user_type,[4,5])) {
			// 	Auth::user()->syncRoles('Company');
			// 	return redirect()->route('company.rides','month');

			// }
            return redirect()->route('masterAdmin.dashboard');
        } else{
			Auth::logout();
			return redirect()->back()->withErrors(['message' => 'Please check your credentials and try again.']);
		}
	}

}
