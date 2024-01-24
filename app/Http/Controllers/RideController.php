<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Ride;
use App\RideHistory;
use DataTables;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Exports\RideExport;
use App\PaymentMethod;
use App\Price;
use Illuminate\Support\Facades\Route;

class RideController extends Controller
{

    protected $limit;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	public function __construct() {
		
		$this->limit = 20;
    }
	
	public function exportRides(Request $request){

        if(empty($request->start_date) && empty($request->end_date)){
			return back()->with('error', __('Start Date and End Date are required!'));
		}
		
		$req_params = $request->all();
		
		$file_name = 'rides_'.date('Y_m_d_H_i_s').'.csv';
		return Excel::download(new RideExport($req_params), $file_name);
    }

    // public function index(Request $request,$type=null)
    // {
    //     $type = ($type?$type:'list').'View';
    //     $type = !in_array($type,['listView','monthView','weekView'])?'listView':$type;
    //     $data['users'] = User::where(['user_type' => 1, 'company_id' => Auth::user()->company_id])->orderBy('first_name', 'ASC')->get();
    //     $data['vehicle_types'] = Price::where(['service_provider_id' => Auth::user()->service_provider_id])->orderBy('sort')->get();
    //     $data['payment_types'] = PaymentMethod::where(['service_provider_id' => Auth::user()->service_provider_id])->get();
    //     return $this->$type($data,$request->all());
    // }

    public function listView(Request $request)
    {
        $data['page_title'] = 'Rides';
        $data['action'] = 'list';
        $records = Ride::where(['service_provider_id' => Auth::user()->id]);
        if(!empty($request['start_date'])){
            $records = $records->whereDate('ride_time', '>=', $request['start_date']);
        }
        if(!empty($request['end_date'])){
            $records = $records->whereDate('ride_time', '<=', $request['end_date']);
        }
        if(!empty($request['search'])){
            $records = $records->where(function ($query) use ($request) {
                $query->where('pickup_address', 'like', '%' . $request['search'] . '%');
                $query->orWhereHas('driver', function($query1) use ($request) {
                    $query1->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $request['search'] . '%');
                });
                $query->orWhereHas('user', function($query1) use ($request) {
                    $query1->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $request['search'] . '%');
                });
                $query->orWhereHas('company', function($query1) use ($request) {
                    $query1->where('name', 'like', '%' . $request['search'] . '%');
                });
            });
        }
        $data['rides'] = $records->orderBy('rides.ride_time', 'DESC')->paginate(20);
        $data['start_date'] = $request['start_date']??"";
        $data['end_date'] = $request['end_date']??"";
        $data['search'] = $request['search']??"";
        $data['users'] = User::where(['user_type' => 1])->orderBy('first_name', 'ASC')->get();
        $data['vehicle_types'] = Price::where(['service_provider_id' => Auth::user()->id])->orderBy('sort')->get();
        $data['payment_types'] = PaymentMethod::where(['service_provider_id' => Auth::user()->id])->get();
        $data['companies'] = Company::select('id','name')->where(['status' => 1, 'service_provider_id' => Auth::user()->id])->orderBy('id','desc')->get();
        return view('admin.rides.list')->with($data);
    }

    public function monthView(Request $request)
    {
        $date = date('Y-m-d');
        if(isset($request['m']) && !empty($request['m']))
        {
            $date = $request['m'];
        }
        $month = date('m',strtotime($date));
        $year = date('Y',strtotime($date));

        $data['page_title'] = 'Rides';
        $data['action'] = 'month';
        $data['rides'] = Ride::select('rides.id', 'rides.ride_time', 'rides.status','rides.pickup_address','rides.vehicle_id','rides.user_id')->where(['service_provider_id' => Auth::user()->id])
                            ->orderBy('rides.id')->whereMonth('ride_time',$month)->whereYear('ride_time', $year)->with(['vehicle','user:id,first_name,last_name'])->get();
        $data['date'] = $date;
        $data['users'] = User::where(['user_type' => 1])->orderBy('first_name', 'ASC')->get();
        $data['vehicle_types'] = Price::where(['service_provider_id' => Auth::user()->id])->orderBy('sort')->get();
        $data['payment_types'] = PaymentMethod::where(['service_provider_id' => Auth::user()->id])->get();
        $data['companies'] = Company::select('id','name')->where(['status' => 1, 'service_provider_id' => Auth::user()->id])->orderBy('id','desc')->get();
        return view('admin.rides.month')->with($data);
    }

    public function weekView(Request $request)
    {
        $data['page_title'] = 'Rides';
        $data['action'] = 'week';
        $data['year'] = Carbon::now()->startOfWeek()->format('Y');
        $data['month'] = Carbon::now()->startOfWeek()->format('m')-1;
        $data['day'] = Carbon::now()->startOfWeek()->format('d');
        if(isset($request['w']) && !empty($request['w']))
        {
            $data['year'] = date('Y',strtotime($request['w']));
            $data['month'] = date('m',strtotime($request['w']))-1;
            $data['day'] = date('d',strtotime($request['w']));
        }

        $startOfWeek = $data['year'].'-'.($data['month']+1).'-'.$data['day']; // Example start date of the week
        // Convert the start date to a Carbon instance
        $startOfWeekDate = Carbon::parse($startOfWeek)->startOfDay();

        // Calculate the end date of the week by adding 6 days to the start date
        $endOfWeekDate = $startOfWeekDate->copy()->addDays(6)->endOfDay();
        // dd($endOfWeekDate);

        $data['rides'] = Ride::select('rides.id', 'rides.ride_time', 'rides.status','rides.pickup_address','rides.vehicle_id','rides.user_id')->where(['service_provider_id' => Auth::user()->id])->orderBy('rides.id')->whereDate('ride_time', '>=', $startOfWeekDate->toDateString())->whereDate('ride_time', '<=', $endOfWeekDate->toDateString())->with(['vehicle','user:id,first_name,last_name'])->get();
        $data['users'] = User::where(['user_type' => 1])->orderBy('first_name', 'ASC')->get();
        $data['vehicle_types'] = Price::where(['service_provider_id' => Auth::user()->id])->orderBy('sort')->get();
        $data['payment_types'] = PaymentMethod::where(['service_provider_id' => Auth::user()->id])->get();
        $data['companies'] = Company::select('id','name')->where(['status' => 1, 'service_provider_id' => Auth::user()->id])->orderBy('id','desc')->get();
        return view('admin.rides.week')->with($data);
    }
	
    // public function index(Request $request) {
		
    //     $data = array('title' => 'Ride', 'action' => 'Ride Lists');
    //     $rides = Ride::select(['rides.id', 'rides.user_id', 'rides.pickup_address', 'rides.dest_address', 'rides.ride_time', 'rides.distance', 'rides.status', 'rides.note', 'rides.ride_cost', 'rides.payment_type', 'users.first_name', 'users.last_name','guest.first_name as guest_first_name', 'guest.last_name as guest_last_name', 'vehicles.vehicle_number_plate', 'prices.seating_capacity', 'payment_methods.name AS payment_name', 'rides.created_by', 'rides.platform', 'rides.user_country_code', 'rides.user_phone'])
    //             ->leftJoin('users', 'users.id', 'rides.driver_id')
    //             ->leftJoin('users as guest', 'guest.id', 'rides.user_id')
    //             ->leftJoin('vehicles', 'vehicles.id', 'rides.vehicle_id')
    //             ->leftJoin('prices', function ($join) {
    //                 $join->on('vehicles.category_id', '=', 'prices.id')->where('prices.deleted_at', null);
    //             })
    //             ->leftJoin('payment_methods', 'payment_methods.id', 'rides.payment_type')
    //             ->where('rides.service_provider_id',Auth::user()->id)
    //             ->orderBy('rides.id', 'DESC');
       
	// 	if ($request->has('text') && !empty($request->text)) {
    //         $rides->where(function($query) use ($request){
    //             $query->orWhere('rides.id','LIKE','%'.$request->text.'%');
    //             $query->orWhereRaw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) LIKE '%".$request->text."%'");
    //             $query->orWhereRaw("CONCAT(`guest`.`first_name`,' ',`guest`.`last_name`) LIKE '%".$request->text."%'");
    //             $query->orWhere('vehicles.vehicle_number_plate','LIKE','%'.$request->text.'%');
    //             $query->orWhere('rides.pickup_address','LIKE','%'.$request->text.'%');
    //             $query->orWhere('rides.dest_address','LIKE','%'.$request->text.'%');
    //             $query->orWhere('payment_type','LIKE','%'.$request->text.'%');
    //         });
    //     }
		
    //     $data['start_date'] = "";
    //     $data['end_date'] = "";
    //     if (($request->has('start_date') && !empty($request->start_date)) && ($request->has('end_date') && !empty($request->end_date))) {
    //         $data['start_date'] = $request->start_date;
    //         $data['end_date'] = $request->end_date;
			
    //         #$startDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
    //         #$endDate = Carbon::createFromFormat('d/m/Y', $request->end_date);
			
	// 		$startDate = $request->start_date;
    //         $endDate = $request->end_date;
			
    //         $rides->whereRaw('date(ride_time) between date("'.$startDate.'") and date("'.$endDate.'")');
    //     }
		
	// 	#$this->limit = 5;
    //     $data['rides'] = $rides->paginate($this->limit);
    //     $data['i'] =(($request->input('page', 1) - 1) * $this->limit);
	// 	#$data['orderby'] = $request->input('orderby');
	// 	#$data['order'] = $request->input('order');
		
	// 	if ($request->ajax()) {
    //         return view("admin.rides.index_element")->with($data);
    //     }
		
    //     return view('admin.rides.index')->with($data);
    // }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Ride::where(['id' => $id])->delete();
            RideHistory::where(['ride_id' => $id])->delete();
            DB::commit();
            return response()->json(['status' => 1, 'message' => "Ride has been deleted."], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $e->getMessage()], 400);
        }
    }

    public function delete_multiple(Request $request)
    {
        $rules = [
            'selected_ids' => 'required|array'
        ];
        $messages = [
            'selected_ids.required' => "Select atleast one checkbox"
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()]);
        }
        try {
            DB::beginTransaction();
            Ride::whereIn('id', $request->selected_ids)->delete();
            RideHistory::whereIn('ride_id', $request->selected_ids)->delete();
            DB::commit();
            return response()->json(['status' => 1, 'message' => "Selected rides are deleted."], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $e->getMessage()], 400);
        }
    }
}
