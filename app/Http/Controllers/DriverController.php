<?php

namespace App\Http\Controllers;

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
		$serviceProvider = Auth::user();
		$this->limit = 20;
		
		$data = array();
		$data = array('title' => 'Drivers', 'action' => 'List Drivers');
		
		$records = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'status', 'name', 'country_code', 'invoice_status', 'is_master');
		
		if($request->has('status') && $request->input('type')=='status' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('users')->where([['id', $request->input('id')],['user_type', 2]])->limit(1)->update(array('is_master' => $status));
		}

		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			
			DB::table('users')->where([['id', $request->input('id')],['user_type', 2]])->limit(1)->update(array('deleted' => $status));
		}
		
		if(!empty($request->input('text'))){
			$text = $request->input('text');
			$records->whereRaw("(first_name LIKE '%$text%' OR last_name LIKE '%$text%' OR phone LIKE '%$text%' OR email LIKE '%$text%') AND user_type=2 AND deleted=0");
		}

		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}

		$data['records'] = $records->where(['user_type' => 2, 'deleted' => 0, 'service_provider_id' => Auth::user()->id])->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] = $request->input('orderby');
		$data['order'] = $request->input('order');
        if ($request->ajax()) {
            return view("admin.drivers.index_element")->with($data);
        }
		
		return view('admin.drivers.index')->with($data);
	}
	
	public function regularDriver(Request $request)
	{
		$this->limit = 20;
		
		$data = array();
		$data = array('title' => 'Drivers', 'action' => 'Regular Drivers');
		
		$records = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'status', 'name', 'country_code', 'invoice_status', 'is_master');
		
		if($request->has('status') && $request->input('type')=='status' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('users')->where([['id', $request->input('id')],['user_type', 2]])->limit(1)->update(array('is_master' => $status));
		}
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			
			DB::table('users')->where([['id', $request->input('id')],['user_type', 2]])->limit(1)->update(array('deleted' => $status));
		}
		
		if(!empty($request->input('text'))){
			$text = $request->input('text');
			$records->whereRaw("(first_name LIKE '%$text%' OR last_name LIKE '%$text%' OR phone LIKE '%$text%' OR email LIKE '%$text%') AND user_type=2 AND deleted=0 AND is_master=0");
		}

		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}

		$data['records'] = $records->where(['user_type' => 2, 'deleted' => 0, 'is_master' => 0, 'service_provider_id' => Auth::user()->id])->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] = $request->input('orderby');
		$data['order'] = $request->input('order');
        if ($request->ajax()) {
            return view("admin.drivers.index_element")->with($data);
        }
		
		return view('admin.drivers.index')->with($data);
	}
	
	public function masterDriver(Request $request)
	{
		$this->limit = 20;
		
		$data = array();
		$data = array('title' => 'Drivers', 'action' => 'Master Drivers');
		
		$records = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'status', 'name', 'country_code', 'invoice_status', 'is_master');
		
		if($request->has('status') && $request->input('type')=='status' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('users')->where([['id', $request->input('id')],['user_type', 2]])->limit(1)->update(array('is_master' => $status));
		}
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			
			DB::table('users')->where([['id', $request->input('id')],['user_type', 2]])->limit(1)->update(array('deleted' => $status));
		}
		
		if(!empty($request->input('text'))){
			$text = $request->input('text');
			$records->whereRaw("(first_name LIKE '%$text%' OR last_name LIKE '%$text%' OR phone LIKE '%$text%' OR email LIKE '%$text%') AND user_type=2 AND deleted=0 AND is_master=1");
		}
		
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}

		$data['records'] = $records->where(['user_type' => 2, 'deleted' => 0, 'is_master' => 1,  'service_provider_id' => Auth::user()->id])->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] = $request->input('orderby');
		$data['order'] = $request->input('order');
        if ($request->ajax()) {
            return view("admin.drivers.index_element")->with($data);
        }
		
		return view('admin.drivers.index')->with($data);
	}
	
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $breadcrumb = array('title'=>'Drivers','action'=>'Add Driver');

		$data = [];
		$data = array_merge($breadcrumb,$data);
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

		$input = $request->except(['_method', '_token', 'country_code', 'phone']);

		try {
			$userExists = User::where(['country_code' => $request->country_code, 'phone' => $this->phone_number_trim($request->phone, $request->country_code), 'user_type' => 2, 'service_provider_id' => Auth::user()->id])->first();

			if(!empty($userExists)){
				return back()->withErrors(['message' => 'Phone number already exists']);
			}

			$input['user_type'] = 2;
			$input['status'] = 1;
			$input['service_provider_id'] = Auth::user()->id;

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
		$salary = Salary::where('driver_id', $id)->where('service_provider_id', Auth::user()->service_provider_id)->first();
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
		$input = $request->except(['_method', '_token']);

		$input = $request->all();

		$isUser = User::where(['country_code' => $request->country_code, 'phone' => $request->phone, 'user_type' => 2, 'service_provider_id' => Auth::user()->id])->first();
		if (!empty($isUser) && $isUser->id != $id) {
			return back()->withErrors(['message' => 'Phone number already exists']);
		}

		$udata = User::find($id);
		$input['phone'] = $this->phone_number_trim($request->phone, $request->country_code);
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
		$input['is_active'] = $request->is_active??0;
		$udata->update($input);

		return back()->with('success', trans('admin.Record updated!'));
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
		Log:info('in saveSalary');
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
		Log::info($driverSalary);
		if(!$driverSalary){
			Log::info('in driver sal');
			$salaryObj = new Salary();
			$salaryObj->type = $request->type;
			$salaryObj->rate = $request->value;
			$salaryObj->driver_id = $request->driver_id;
			$salaryObj->service_provider_id = Auth::user()->service_provider_id;
			$saved = $salaryObj->save();
			if($saved){
				Log::info('salaryObj');
				DB::commit();
				return response()->json(['success' => true, 'message' => 'Salary saved successfully']);

			}
		}else{
			Log::info('in else driver');
			$updated= 	Salary::where('driver_id', $request->driver_id)->where('service_provider_id',Auth::user()->service_provider_id)->update(['type' => $request->type, 'rate' => $request->value]);
			if($updated){
				DB::commit();
				return response()->json(['success' => true, 'message' => 'Salary updated successfully']);

			}
		}
		
		} catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
		

		
	}


}
