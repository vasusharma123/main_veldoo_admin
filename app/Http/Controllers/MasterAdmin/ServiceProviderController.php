<?php

namespace App\Http\Controllers\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PlanPurchaseHistory;
use App\RideHistory;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class ServiceProviderController extends Controller

{
    public function __construct()
    {
    }


    public function showServiceProvider()
    {
        try {
            $data = array('page_title' => 'Service Provider', 'action' => 'Service Provider','page' => 'service-provider');
            $userData =  User::where('user_type', 3)->with(['plans', 'plans.plan'])->orderBy('created_at','DESC')->get();
            $data['user'] = $userData->toArray();
           // dd($data);
            return view('master_admin.service_provider.index', compact('data'))->with($data);
        } catch (Exception $e) {
            Log::info('Error in method getAllServiceProvider' . $e);
        }
    }

    public function getAllServiceProvider(Request $request)
    {
        try {

            $searchTerm = $request->input('search');

            if($searchTerm){
                Log::info('in if');
                $results =     User::select('users.name','users.email','users.phone','users.country_code','plan_purchase_history.id as plan_purchase_id', 'plan_purchase_history.license_type','plan_purchase_history.expire_at','plans.plan_name' )
                                ->leftJoin('plan_purchase_history', function ($join) {
                                    $join->on('users.id', '=', 'plan_purchase_history.user_id')
                                         ->whereRaw('plan_purchase_history.id = (select max(id) from plan_purchase_history where user_id = users.id)');
                                })
                                ->leftJoin('plans', 'plan_purchase_history.plan_id', '=', 'plans.id')
                                ->where('users.user_type', 3)
                                ->where(function ($query) use ($searchTerm) {
                                    $query->where('users.name', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('users.email', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('users.phone', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('users.country_code', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('plan_purchase_history.license_type', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('plan_purchase_history.expire_at', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('plans.plan_name', 'like', '%' . $searchTerm . '%');
                                })->orderBy('users.created_at','DESC')->get();
            }else{
                $results =     User::select('users.name','users.email','users.phone','users.country_code','plan_purchase_history.id as plan_purchase_id', 'plan_purchase_history.license_type','plan_purchase_history.expire_at','plans.plan_name' )
                ->leftJoin('plan_purchase_history', function ($join) {
                    $join->on('users.id', '=', 'plan_purchase_history.user_id')
                         ->whereRaw('plan_purchase_history.id = (select max(id) from plan_purchase_history where user_id = users.id)');
                })
                ->leftJoin('plans', 'plan_purchase_history.plan_id', '=', 'plans.id')
                ->where('users.user_type', 3)
                ->orderBy('users.created_at','DESC')->get();
                Log::info('in else');
            }
            

            $results = $results->map(function ($result) {
                $result->encrypted_plan_attribute = $this->computeAttribute($result);
                return $result;
            });
            return response()->json($results);


        } catch (Exception $e) {
            Log::info('Error in method getAllServiceProvider' . $e);
        }
    }

    private function computeAttribute($result)
{
    // Your logic to compute the attribute value based on $result
    // For example, concatenate values from different columns
    return Crypt::encrypt($result->plan_purchase_id);
}


    public function getServiceProviderPlan()
    {
        return view('service_provider_plan');
    }

    public function current_plan(Request $request)
    {
        $data = array('page_title' => 'Service Provider Plan', 'action' => 'current_plan','page' => 'service-provider');
        $latest_plan_id = decrypt($request->id);
        $data['latest_plan'] = PlanPurchaseHistory::find($latest_plan_id);
        return view('master_admin.service_provider.current_plan')->with($data);
    }

    public function profile_detail(Request $request){
        try{
            $data = array('page_title' => 'Service Provider Detail', 'action' => 'profile_detail','page' => 'service-provider');
            $latest_plan_id = decrypt($request->id);
            $data['latest_plan'] = PlanPurchaseHistory::find($latest_plan_id);
            $data['user'] = User::find($data['latest_plan']->user_id);
            return view('master_admin.service_provider.profile_detail',  compact('data'))->with($data);
        }catch(Exception $e){
            Log::info('In getPlanDetail method'. $e);
        }
    }

    public function billing_detail(Request $request)
    {
        $data = array('page_title' => 'Billing', 'action' => 'billing_detail', 'page' => 'service-provider');
        $latest_plan_id = decrypt($request->id);
        $data['latest_plan'] = PlanPurchaseHistory::find($latest_plan_id);
        $data['all_purchases'] = PlanPurchaseHistory::where(['user_id' => $data['latest_plan']->user_id])->orderBy('purchase_date', 'desc')->get();
        return view('master_admin.service_provider.billing_detail')->with($data);
    }

    public function show_plan_expiry(Request $request)
    {
        $data = array('page_title' => 'Service Provider Plan', 'action' => 'billing_detail','page' => 'service-provider');
        $latest_plan_id = decrypt($request->id);
        $data['latest_plan'] = PlanPurchaseHistory::find($latest_plan_id);
        return view('master_admin.service_provider.show_plan_expiry')->with($data);
    }

    public function update_expiry(Request $request)
    {
        $input = $request->all();
        $request->validate(
            [
                'plan_purchase_id' => 'required',
                'expiration_date' => 'required'
            ]
        );
        try {
            $planHistoryObj = PlanPurchaseHistory::find($request->plan_purchase_id);
            $planHistoryObj->expire_at = $request->expiration_date;
            $planHistoryObj->save();
            return redirect()->back()->with('success', __('The expiration date of the plan was updated successfully.'));
        } catch (Exception $e) {
            Log::info('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $e->getLine() . ' --- ' . $e->getMessage());
            return redirect()->back()->withInput($input)->with('error', $e->getMessage());
        }
    }

    public function addManager()
    {
        try {
            $data = array('page_title' => 'Manager', 'action' => 'Manager','page' => 'manager');
            // $userData =  User::where('user_type', 3)->with(['plans', 'plans.plan'])->orderBy('created_at','DESC')->get();
            // $data['user'] = $userData->toArray();
           // dd($data);
            return view('master_admin.managers.index', compact('data'))->with($data);
        } catch (Exception $e) {
            Log::info('Error in method getAllServiceProvider' . $e);
        }
    }

}
