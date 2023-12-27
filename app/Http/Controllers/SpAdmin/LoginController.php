<?php

namespace App\Http\Controllers\SpAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('adminLogin');
    }
}
