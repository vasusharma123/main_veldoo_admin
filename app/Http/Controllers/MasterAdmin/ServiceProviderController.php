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
            $data = array('page_title' => 'Service Provider', 'action' => 'Service Provider');
            // $data['user'] =  User::where('user_type', 3)->get();
            return view('master_admin.service_provider.index', compact('data'))->with($data);
        } catch (Exception $e) {
            Log::info('Error in method getAllServiceProvider' . $e);
        }
    }

    public function getAllServiceProvider()
    {
        try {
            $data = PlanPurchaseHistory::groupBy('user_id')->orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('expire_at', function ($row) {
                    return date('d/m/Y', strtotime($row->expire_at));
                })->addColumn('service_provider_name', function ($row) {
                    return $row->service_provider->name;
                })->addColumn('phone_number', function ($row) {
                    return '+' . $row->service_provider->country_code . ' ' . $row->service_provider->phone;
                })->addColumn('email_address', function ($row) {
                    return $row->service_provider->email;
                })->addColumn('license_type', function ($row) {
                    return ucfirst($row->plan->plan_type);
                })
                ->addColumn('action', function ($row) {
                    if ($row->expire_at >= Carbon::now()->format('Y-m-d')) {
                        $actionBtn = '<a href="/plan-detail?id=' . Crypt::encrypt($row->plan_id) . '"  class="plan valid"> ' . $row->plan->plan_name . '</a>';
                    } else {
                        $actionBtn = '<a href="/plan-detail?id=' . Crypt::encrypt($row->plan_id) . '"  class="plan invalid">Inactive</a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['service_provider_name', 'phone_number', 'email_address', 'license_type', 'action'])
                ->make(true);
        } catch (Exception $e) {
            Log::info('Error in method getAllServiceProvider' . $e);
        }
    }

    public function getServiceProviderPlan()
    {
        return view('service_provider_plan');
    }
}
