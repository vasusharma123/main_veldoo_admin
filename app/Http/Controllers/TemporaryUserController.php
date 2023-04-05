<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Expense;
use App\ExpenseAttachment;
use App\ExpenseType;
use App\User;

class TemporaryUserController extends Controller
{

    public function __construct()
    {
    }

    public function only_phone()
    {
        $users = User::where(['user_type' => 1, 'app_installed' => 0])->where(function($query){
            $query->where(function($query1){
                $query1->whereNull('first_name')->orWhere(['first_name' => '']);
            })->where(function($query1){
                $query1->whereNull('last_name')->orWhere(['last_name' => '']);
            })->where(function($query1){
                $query1->whereNull('email')->orWhere(['email' => '']);
            })->where(function($query1){
                $query1->whereNotNull('phone')->where('phone', '!=', '');
            });
        })->whereHas('creator', function ($query) {
            $query->where('user_type', 2);
        })->get();
        return view('admin.temporary_user.only_phone')->with(['title' => 'Temporary Guest User', 'action' => '', 'users' => $users]);
    }

    public function only_last_name()
    {
        $users = User::where(['user_type' => 1, 'app_installed' => 0])->where(function($query){
            $query->where(function($query1){
                $query1->whereNull('first_name')->orWhere(['first_name' => '']);
            })->where(function($query1){
                $query1->whereNull('phone')->orWhere(['phone' => '']);
            })->where(function($query1){
                $query1->whereNull('email')->orWhere(['email' => '']);
            })->where(function($query1){
                $query1->whereNotNull('last_name')->where('last_name', '!=', '');
            });
        })->whereHas('creator', function ($query) {
            $query->where('user_type', 2);
        })->get();
        return view('admin.temporary_user.only_last_name')->with(['title' => 'Temporary Guest User', 'action' => '', 'users' => $users]);
    }

}
