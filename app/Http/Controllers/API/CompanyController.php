<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Company;
use App\Http\Resources\RideCompanyResource;
use Illuminate\Support\Facades\DB;
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

    public function company_list(Request $request)
    {
        $query = new Company();
        if (!empty($request->user_id)) {
            $company_list = User::where(['id' => $request->user_id])->pluck('company_id')->toArray();
            if (!empty($company_list)) {
                $query = $query->whereIn('id', $company_list);
            } else {
                $query = $query->where('id', 0);
            }
        }
        $company_query = $query->get();
        $companies = RideCompanyResource::collection($company_query);

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
