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
        $data = array('page_title' => 'Service Provider Plan', 'action' => 'Service Provider Plan');
        return view('service_provider_plan')->with($data);

    }

    public function getPlanDetail(Request $request){
        try{
            $data = array('page_title' => 'Plan Detail', 'action' => 'Plan Detail');
            $serviceProviderId = decrypt($request->id);
            $data['user'] = User::where('id', $serviceProviderId)->first();
            return view('plan_detail',  compact('data'))->with($data);

        }catch(Exception $e){
            Log::info('In getPlanDetail method'. $e);
        }
        

    }

    public function getBillingDetail(){
        $data = array('page_title' => 'Billing', 'action' => 'Billing');
        return view('billing_detail')->with($data);

    }


    


    
}
