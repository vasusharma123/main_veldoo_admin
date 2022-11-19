<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = User::where(['user_type' => 4])->orderBy('name')->get();
        $currentData = array();
        foreach ($companies as $value) {
            $currentData[] = $value->getCompanyResponseArr();
        }

        return $this->successResponse($currentData, 'List of Company');
    }
}
