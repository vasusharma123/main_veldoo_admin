<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ride;
use App\RideHistory;
use DataTables;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Exports\RideV1Export;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;

class RideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	public function __construct() {
		
		$this->limit = 20;
    }
	 
    public function index(Request $request) {
		
        $data = array('title' => 'Ride', 'action' => 'Ride Lists');
        $rides = Ride::select(['rides.id', 'rides.user_id', 'rides.pickup_address', 'rides.dest_address', 'rides.ride_time', 'rides.distance', 'rides.status', 'rides.note', 'rides.ride_cost', 'rides.payment_type', 'users.first_name', 'users.last_name','guest.first_name as guest_first_name', 'guest.last_name as guest_last_name', 'vehicles.vehicle_number_plate', 'prices.seating_capacity', 'payment_methods.name AS payment_name', 'rides.created_by', 'rides.platform', 'rides.user_country_code', 'rides.user_phone'])
                ->leftJoin('users', 'users.id', 'rides.driver_id')
                ->leftJoin('users as guest', 'guest.id', 'rides.user_id')
                ->leftJoin('vehicles', 'vehicles.id', 'rides.vehicle_id')
                ->leftJoin('prices', function ($join) {
                    $join->on('vehicles.category_id', '=', 'prices.id')->where('prices.deleted_at', null);
                })
                ->leftJoin('payment_methods', 'payment_methods.id', 'rides.payment_type')
                ->where('rides.service_provider_id',Auth::user()->id)
                ->orderBy('rides.id', 'DESC');
       
		if ($request->has('text') && !empty($request->text)) {
            $rides->where(function($query) use ($request){
                $query->orWhere('rides.id','LIKE','%'.$request->text.'%');
                $query->orWhereRaw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) LIKE '%".$request->text."%'");
                $query->orWhereRaw("CONCAT(`guest`.`first_name`,' ',`guest`.`last_name`) LIKE '%".$request->text."%'");
                $query->orWhere('vehicles.vehicle_number_plate','LIKE','%'.$request->text.'%');
                $query->orWhere('rides.pickup_address','LIKE','%'.$request->text.'%');
                $query->orWhere('rides.dest_address','LIKE','%'.$request->text.'%');
                $query->orWhere('payment_type','LIKE','%'.$request->text.'%');
            });
        }
		
        $data['start_date'] = "";
        $data['end_date'] = "";
        if (($request->has('start_date') && !empty($request->start_date)) && ($request->has('end_date') && !empty($request->end_date))) {
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
            $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date);
            $rides->whereRaw('date(ride_time) between date("'.$startDate.'") and date("'.$endDate.'")');
        }
		
		#$this->limit = 5;
        $data['rides'] = $rides->paginate($this->limit);
        $data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		#$data['orderby'] = $request->input('orderby');
		#$data['order'] = $request->input('order');
		
		if ($request->ajax()) {
            return view("admin.rides.index_element")->with($data);
        }
		
        return view('admin.rides.index')->with($data);
    }

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

    public function rideExport(Request $request)
    {
        
        return Excel::download(new RideV1Export($request->all()), 'Rides List Veldoo.xlsx');
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
