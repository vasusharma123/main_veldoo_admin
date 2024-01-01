<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        Auth::logout();
        return view('company.login');
    }

    public function doLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
            // 'user_type'=>'required'
        ];
        $request->validate($rules);
        $input = $request->all();
        $whereData = array('email' => $input['email'], 'password' => $input['password']);
        if (auth()->attempt($whereData)) {
            if (Auth::user()->company->status == 1) {
                if (in_array(Auth::user()->user_type, [4, 5])) {
                    Auth::user()->syncRoles('Company');
                    return redirect()->route('company.rides', 'month');
                }
                return redirect()->route('users.dashboard');
            } else {
                return redirect()->back()->withErrors(['message' => 'Your account is blocked. Please contact your service provider.']);
            }
        } else {
            Auth::logout();
            return redirect()->back()->withErrors(['message' => 'Please check your credentials and try again.']);
        }
    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect()->route("company_login");
    }
}
