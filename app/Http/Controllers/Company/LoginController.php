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

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect()->route("company_login");
    }
}
