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

class PlansController extends Controller

{

    protected $redirectTo = '/master-login';

    public function __construct()
    {
        
    }


    public function getServiceProviderPlan(){
        return view('service_provider_plan');

    }

    public function getPlanDetail(){
        return view('plan_detail');

    }

    public function getBillingDetail(){
        return view('billing_detail');

    }


    


    
}
