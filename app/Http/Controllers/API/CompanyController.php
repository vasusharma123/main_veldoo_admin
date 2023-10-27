<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Company;
use App\Http\Resources\RideCompanyResource;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{

    protected $successCode = 200;
    protected $errorCode = 401;
    protected $warningCode = 500;

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

    public function user_list(Request $request)
    {
        $rules = [
            'company_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' =>  $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
        }
        $dataArray = [];
        $dataArray['users'] = User::where(['user_type' => 1, 'company_id' => $request->company_id])->orderBy('first_name')->get();
        if(!empty($request->user_id)){
            $userExists = User::where(['id' => $request->user_id, 'user_type' => 1, 'company_id' => $request->company_id])->exists();
            $dataArray['is_user_exist'] = $userExists?1:0;
        }

        return $this->successResponse($dataArray, 'List of Users');
    }
}
