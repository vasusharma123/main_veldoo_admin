<?php

namespace App\Http\Controllers;

use App\DriverChooseCar;
use App\DriverStayActiveNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Ride;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Salary;
use App\Expense;
use App\Exports\DriversExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;

class DriverController extends Controller
{
	protected $limit;
	protected $successCode = 200;
    protected $errorCode = 401;
    protected $warningCode = 500;


    public function __construct()
    {
    }
	
	public function index(Request $request)
	{
		$this->limit = 20;
		
		$data = array('title' => 'Drivers', 'action' => 'List Drivers');
		
		$records = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'status', 'name', 'country_code', 'invoice_status', 'is_master','is_admin');
		
		if($request->has('status') && $request->input('type')=='status' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('users')->where([['id', $request->input('id')],['user_type', 2]])->limit(1)->update(array('is_master' => $status));
		}

		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){			
			User::where([['id', $request->input('id')],['user_type', 2]])->delete();
		}
		
		if(!empty($request->input('text'))){
			$records->where(function ($query) use ($request) {
				$query->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $request['text'] . '%');
				$query->orWhere(DB::raw('CONCAT_WS(" ", country_code, phone)'), 'like', '%' . $request['text'] . '%');
				$query->orWhere('email', 'like', '%' . $request['text'] . '%');

            });
		}

		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}
		if(Auth::user()->user_type == 3){
			$sp_id = Auth::user()->id;
		}else{
			$sp_id = Auth::user()->service_provider_id;
		}
		$data['records'] = $records->where(['user_type' => 2, 'service_provider_id' => $sp_id])->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] = $request->input('orderby');
		$data['order'] = $request->input('order');
        if ($request->ajax()) {
			return view("admin.drivers.index_element")->with($data);
        }
		
		$data['regular_master_filter'] = 'all';
		return view('admin.drivers.index')->with($data);
	}
	
	public function regularDriver(Request $request)
	{
		if (Auth::user()->user_type == 3) {
			$sp_id = Auth::user()->id;
		} else {
			$sp_id = Auth::user()->service_provider_id;
		}
		$this->limit = 20;
		
		$data = array('title' => 'Drivers', 'action' => 'Regular Drivers');
		
		$records = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'status', 'name', 'country_code', 'invoice_status', 'is_master');
		
		if($request->has('status') && $request->input('type')=='status' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('users')->where([['id', $request->input('id')],['user_type', 2]])->limit(1)->update(array('is_master' => $status));
		}
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			User::where([['id', $request->input('id')],['user_type', 2]])->delete();
		}
		
		if(!empty($request->input('text'))){
			$records->where(function ($query) use ($request) {
				$query->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $request['text'] . '%');
				$query->orWhere(DB::raw('CONCAT_WS(" ", country_code, phone)'), 'like', '%' . $request['text'] . '%');
				$query->orWhere('email', 'like', '%' . $request['text'] . '%');

            });
		}

		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}
		$data['records'] = $records->where(['user_type' => 2, 'is_master' => 0, 'service_provider_id' => $sp_id])->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] = $request->input('orderby');
		$data['order'] = $request->input('order');
        if ($request->ajax()) {
			return view("admin.drivers.index_element")->with($data);
        }
		
		$data['regular_master_filter'] = 'regular';
		return view('admin.drivers.index')->with($data);
	}
	
	public function masterDriver(Request $request)
	{
		if (Auth::user()->user_type == 3) {
			$sp_id = Auth::user()->id;
		} else {
			$sp_id = Auth::user()->service_provider_id;
		}
		$this->limit = 20;
		
		$data = array('title' => 'Drivers', 'action' => 'Master Drivers');
		
		$records = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'status', 'name', 'country_code', 'invoice_status', 'is_master');
		
		if($request->has('status') && $request->input('type')=='status' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('users')->where([['id', $request->input('id')],['user_type', 2]])->limit(1)->update(array('is_master' => $status));
		}
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			User::where([['id', $request->input('id')],['user_type', 2]])->delete();
		}
		
		if(!empty($request->input('text'))){
			$records->where(function ($query) use ($request) {
				$query->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $request['text'] . '%');
				$query->orWhere(DB::raw('CONCAT_WS(" ", country_code, phone)'), 'like', '%' . $request['text'] . '%');
				$query->orWhere('email', 'like', '%' . $request['text'] . '%');

            });
		}
		
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}

		$data['records'] = $records->where(['user_type' => 2, 'is_master' => 1, 'service_provider_id' => $sp_id])->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] = $request->input('orderby');
		$data['order'] = $request->input('order');
        if ($request->ajax()) {
            return view("admin.drivers.index_element")->with($data);
        }
		$data['regular_master_filter'] = 'master';
		return view('admin.drivers.index')->with($data);
	}
	
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{
		if (Auth::user()->user_type == 3) {
			$sp_id = Auth::user()->id;
		} else {
			$sp_id = Auth::user()->service_provider_id;
		}

		$data = array('title' => 'Drivers', 'action' => 'Add Driver');

		$data['driverCount'] = User::where(['user_type' => 1, 'service_provider_id' => $sp_id])->count();
		return view('admin.drivers.create')->with($data);
	}
	
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function store(Request $request)
	{
		$rules = [
			'first_name' => 'required',
			'last_name' => 'required',
			'country_code' => 'required',
			'phone' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:6',
			'confirm_password' => 'required|min:6|same:password',
		];

		$request->validate($rules);

		$input = $request->except(['_method', '_token']);

		try {
			if (Auth::user()->user_type == 3) {
				$sp_id = Auth::user()->id;
			} else {
				$sp_id = Auth::user()->service_provider_id;
			}
			$userExists = User::where(['country_code' => $request->country_code, 'phone' => $this->phone_number_trim($request->phone, $request->country_code), 'user_type' => 2, 'service_provider_id' => $sp_id])->first();

			if(!empty($userExists)){
				return back()->withErrors(['message' => 'Phone number already exists']);
			}

			$input['phone'] = $this->phone_number_trim($request->phone, $request->country_code);
			$input['user_type'] = 2;
			$input['status'] = 1;

			$input['service_provider_id'] = $sp_id;

			$isuser = User::create($input);

			if (!empty($request->image_tmp)) {
				$imgname = 'img-' . time() . '.' . $request->image_tmp->extension();

				$isuser->image = Storage::disk('public')->putFileAs(
					'drivers/' . $isuser->id ,
					$request->image_tmp,
					$imgname
				);

				$isuser->save();
			}

			return back()->with('success', __('Driver created successfully!'));
		} catch (\Illuminate\Database\QueryException $exception) {
			return back()->with('error', $exception->getMessage());
		} catch (\Exception $exception) {
			return back()->with('error', $exception->getMessage());
		}
	}
	
	/**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
	    $breadcrumb = array('title'=>'Drivers','action'=>'Edit Driver');
		$data = [];
        $record = User::find($id);
		if(empty($record)){
			return redirect()->route("drivers.index")->with('warning', 'Record not found!');
		}
		
		$data['record'] = $record;
		if (Auth::user()->user_type == 3) {
			$sp_id = Auth::user()->id;
		} else {
			$sp_id = Auth::user()->service_provider_id;
		}
		$salary = Salary::where('driver_id', $id)->where('service_provider_id', $sp_id)->first();
		$data['salary'] = $salary;
		$data = array_merge($breadcrumb,$data);
	    return view("admin.drivers.edit")->with($data);
    }
	
	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
	// public function update(Request $request, Posts $posts)
	public function update(Request $request, $id)
	{
		$rules = [
				'first_name' => 'required',
				'last_name' => 'required',
				'country_code' => 'required',
				'phone' => 'required',
				'email' => 'required|email',
			];

		if (!empty($request->password)) {
			$rules['password'] = 'required|min:6';
			$rules['confirm_password'] = 'required|min:6|same:password';
		}

		$request->validate($rules);

		DB::beginTransaction();
		try {
			$input = $request->except(['_method', '_token']);

			$input = $request->all();

			if(Auth::user()->user_type){
				if(Auth::user()->user_type == 8){
					$sp_id = Auth::user()->service_provider_id;
				}elseif(Auth::user()->user_type == 3){
					$sp_id = Auth::user()->id;
				}else{
					$sp_id = Auth::user()->id;
				}
			}

			$isUser = User::where(['country_code' => $request->country_code, 'phone' => $request->phone, 'user_type' => 2, 'service_provider_id' => $sp_id])->first();
			if (!empty($isUser) && $isUser->id != $id) {
				return back()->withErrors(['message' => 'Phone number already exists']);
			}

			$udata = User::find($id);
			$input['phone'] = $this->phone_number_trim(
				$request->phone,
				$request->country_code
			);
			if (!empty($request->image_tmp)) {

				if (!empty($udata->image)) {
					Storage::disk('public')->delete($udata->image);
				}

				$imgname = 'img-' . time() . '.' . $request->image_tmp->extension();

				$input['image'] = Storage::disk('public')->putFileAs(
					'drivers/' . $udata->id,
					$request->image_tmp,
					$imgname
				);
			}
			if ($request->is_active) {
				$input['is_active'] = $request->is_active;
				DriverStayActiveNotification::where(['driver_id' => $id])->delete();
				$driverhoosecar = DriverChooseCar::where([
					'user_id' => $id, 'service_provider_id' => $sp_id, 'logout' => 0
				])->orderBy('id', 'desc')->first();
				if ($driverhoosecar) {
					$driverhoosecar->logout_mileage = $driverhoosecar->mileage;
					$driverhoosecar->logout = 1;
					$driverhoosecar->save();
				}
				$input['device_token'] = "";
				$input['availability'] = 0;
			} else {
				$input['is_active'] = 0;
			}

			if($request->status){

				if($request->status == 1){
					$input['is_active'] = 0;
				}else{
					$input['is_active'] = 1;
				}

			}

			$udata->update($input);
			foreach (User::find($id)->tokens as $token) {
				$token->revoke();
			}
			DB::commit();
			return back()->with('success', 'Record updated!');
		} catch (\Exception $exception) {
			DB::rollBack();
			return back()->with('error', $exception->getMessage());
		}
	}
	
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $currentTime = Carbon::now();
            User::where('id', $request->user_id)->delete();
            Ride::where(['driver_id' => $request->user_id])->where('ride_time', '>', $currentTime)->update(['driver_id' => null]);
            DB::commit();
            return response()->json(['status' => 1, 'message' => __('The driver has been deleted.')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
    }

	public function saveSalary(Request $request){

		try{
		DB::beginTransaction();
		$rules = [
			'type' => 'required',
			'value' => 'required|integer',
			'driver_id' => 'required|integer'

		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		} 

		$driverSalary = 	Salary::where('driver_id',$request->driver_id)->first();
		if(!$driverSalary){
			$salaryObj = new Salary();
			$salaryObj->type = $request->type;
			$salaryObj->rate = $request->value;
			$salaryObj->driver_id = $request->driver_id;
			$salaryObj->service_provider_id = Auth::user()->id;
			$saved = $salaryObj->save();
			if($saved){
				DB::commit();
				$this->updateRideForDriver($request->driver_id, Auth::user()->id);
				return response()->json(['success' => true, 'message' => 'Salary saved successfully']);

			}
		}else{
			$updated= 	Salary::where('driver_id', $request->driver_id)->where('service_provider_id', Auth::user()->id)->update(['type' => $request->type, 'rate' => $request->value]);
			if($updated){
				DB::commit();
				$this->updateRideForDriver($request->driver_id, Auth::user()->id);
				return response()->json(['success' => true, 'message' => 'Salary updated successfully']);

			}
		}
		
		} catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
		

		
	}
	public function updateRideForDriver($driver_id,$sp_id){

		try{
			DB::beginTransaction();
			$salary = Salary::where('driver_id',$driver_id)->where('service_provider_id',$sp_id)->first();
			if($salary){
				$type = $salary->type;
				$percentage = $salary->rate;
				$now = Carbon::now();
				$carbonDate = Carbon::parse($now)->format('Y-m-d');
				if($type == 'revenue'){
					
					$data = Expense::where('driver_id',$driver_id)->where('service_provider_id',$sp_id)->where('type','salary')->where('type_detail','revenue')->where('date',$carbonDate)->get();
					foreach($data as $single){
						$ride_id = $single->ride_id;
						$rideDetail = Ride::where('id',$ride_id)->select('id','ride_cost')->first();
						if($rideDetail){
							$ride_cost  = $rideDetail->ride_cost;
							$percentageAmount = ($percentage * $ride_cost) / 100;
							$update = Expense::where('id',$single->id)->update(['salary' => $percentageAmount]);
							if($update){
								DB::Commit();
							}
						}
					
					}
				}else{
					$data = Expense::where('driver_id',$driver_id)->where('service_provider_id',$sp_id)->where('type','salary')->where('type_detail','!=','revenue')->where('date',$carbonDate)->get();
					if($data){
						
						foreach($data as $single){
							$hoursData = 	json_decode($single->type_detail);
							$hoursAmount = $hoursData->hours * $percentage;
							$update = Expense::where('id',$single->id)->update(['salary' => $hoursAmount]);
							if($update){
								DB::Commit();
							}
						}
					}
					
				}
			}

		} catch (\Exception $exception) {
			DB::rollBack();
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}
	}

	public function exportDrivers(Request $request){
		$req_params = $request->all();
		
		$file_name = 'drivers_'.date('Y_m_d_H_i_s').'.csv';
		return Excel::download(new DriversExport($req_params), $file_name);
    }

	public function updateAdminStatus(Request $request){
		try{
			$id = Crypt::decrypt($request->id);
			if($request->status == 0){
				$status = 1;
			}else{
				$status = 0;
			}
			User::where('id',$id)->update(['is_admin' => $status]);

		} catch (\Exception $exception) {
			DB::rollBack();
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}
	}

}
