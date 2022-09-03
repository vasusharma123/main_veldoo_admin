<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class CompanyController extends Controller
{
    public function index(User $users){
        $userArr=$users->getDriverList();

// print_r($userArr);die;
            $currentData = array();
        foreach ($userArr as $value) {
            $data = $value->getCompanyResponseArr();
            array_push($currentData,(object)$data);
        }

        return $this->successResponse($currentData, 'Get company list successfully');  

    }
}
