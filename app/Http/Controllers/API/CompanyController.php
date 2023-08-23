<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Company;
use App\Http\Resources\RideCompanyResource;

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

    public function list_data(Request $request)
    {
        $companies = RideCompanyResource::collection(Company::all());

        return $this->successResponse($companies, 'List of Company');
    }

}
