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
use Illuminate\Support\Facades\Auth;
use App\Price;
use Carbon\Carbon;
use App\Setting;
use App\Notification;
use App\Http\Resources\RideResource;
use App\SMSTemplate;


class ServiceProviderController extends Controller

{
    public function __construct()
    {
        
    }


    public function getAllServiceProvider(){

        $data =  User::where('user_type', 3)->paginate(5);
        return view('service_provider', compact('data'));

    }

    public function getServiceProviderPlan(){
        return view('service_provider_plan');

    }

    
}
