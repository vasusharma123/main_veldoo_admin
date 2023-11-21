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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;


class ServiceProviderController extends Controller

{
    public function __construct()
    {
        
    }


    public function showServiceProvider(){

        try{
            $data = array('page_title' => 'Service Provider', 'action' => 'Service Provider');
            $data['user'] =  User::where('user_type', 3)->get();
            return view('service_provider', compact('data'))->with($data);

        }catch(Exception $e){
            Log::info('Error in method getAllServiceProvider'. $e);
        }
        

    }

    public function getAllServiceProvider(){

        try{
            // $data = array('page_title' => 'Service Provider', 'action' => 'Service Provider');
            // $data['user'] =  User::where('user_type', 3)->get();
            // return view('service_provider', compact('data'))->with($data);

            $data = User::where('user_type',2)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn ='<a href="/plan-detail?id='.Crypt::encrypt($row->id).'"  class="plan valid"> Silver</a>';
                   // $actionBtn = '<a class="tableAnchor wordWrapText" href="/getAuthorDetails/' . Crypt::encrypt($data->id) . '" ><span class="user_full_name_span">' . $data->fullName . '</span></a>';
                    // <td class="text-center"><a href="/plan-detail?id={{ encrypt($item->id) }}"  class="plan valid">Silver</a></td>
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);

                

        }catch(Exception $e){
            Log::info('Error in method getAllServiceProvider'. $e);
        }
        

    }

    public function getServiceProviderPlan(){
        return view('service_provider_plan');

    }

    
}
