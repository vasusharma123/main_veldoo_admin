<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Ride;
use App\ServiceProviderDriver;
use Carbon\Carbon;
use Auth;

class DriverController extends Controller
{

    public function __construct()
    {
    }
	
	public function index(Request $request)
	{
		$this->limit = 20;
		
		$data = array();
		$data = array('title' => 'Drivers', 'action' => 'List Drivers');
		
		$records = DB::table('users');
		$records->selectRaw('id, first_name, last_name, email, phone, status, name, country_code, invoice_status, is_master');
		
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
		
		$data['records'] = $records->where(['user_type'=>2, 'deleted'=>0])->paginate($this->limit);
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
		
		$records = DB::table('users');
		$records->selectRaw('id, first_name, last_name, email, phone, status, name, country_code, invoice_status, is_master');
		
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
		
		$data['records'] = $records->where(['user_type'=>2, 'deleted'=>0, 'is_master' => 0])->paginate($this->limit);
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
		
		$records = DB::table('users');
		$records->selectRaw('id, first_name, last_name, email, phone, status, name, country_code, invoice_status, is_master');
		
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
		
		$data['records'] = $records->where(['user_type'=>2, 'deleted'=>0, 'is_master' => 1])->paginate($this->limit);
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
    public function store(Request $request){
		
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
		
		try{
			
			$isUser = User::where(['country_code' => $request->country_code, 'phone' => $request->phone, 'user_type' => 2])->first();
			if(!empty($request->email)){
				$userQuery2 = User::where(['email' => $request->email, 'user_type' => 2]);
				$isUserEmail = $userQuery2->first();
			}
			
			if(!empty($isUser)){
				return back()->withErrors(['message' => 'Phone number already exists']);
			}
			
			if(!empty($isUserEmail)){
				return back()->withErrors(['message' => 'Email already exists']);
			}
			
			$input['user_type'] = 2;
			$input['status'] = 1;
			
			$isuser = User::create($input);
			
			if(!empty($request->image_tmp)){
				$imgname = 'img-'.time().'.'.$request->image_tmp->extension();
				
				$isuser->image = Storage::disk('public')->putFileAs(
					'drivers/'.$isuser->id.'/', $request->image_tmp, $imgname
				);
				
				$isuser->save();
			}
			
			return back()->with('success', __('Created successfully!'));
		}catch (\Illuminate\Database\QueryException $exception){
			return back()->with('success', $exception->getMessage());
		} catch(\Exception $exception){
			return back()->with('success', $exception->getMessage());
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
        $where = array('id' => $id);
        $record = User::where($where)->first();
		if(empty($record)){
			return redirect()->route("drivers.index")->with('warning', 'Record not found!');
		}
		
		$data['record'] = $record;
		
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
    public function update(Request $request, $id){
		
		$rules = [
			'first_name' => 'required',
			'last_name' => 'required',
			'country_code' => 'required',
			'phone' => 'required',
			'email' => 'required|email',
		];
		
		if(!empty($request->password)){
			$rules['password'] = 'required|min:6';
			$rules['confirm_password'] = 'required|min:6|same:password';
		}
		
		$request->validate($rules);
		$input = $request->except(['_method', '_token']);
		
		$input = $request->all();
		
		$isUser = User::where(['country_code' => $request->country_code, 'phone' => $request->phone, 'user_type' => 2])->first();
		if(!empty($isUser) && $isUser->id != $id){
			return back()->withErrors(['message' => 'Phone number already exists']);
		}
		
		$userQuery2 = User::where(['email' => $input['email'], 'user_type' => 2]);
		$isUserEmail = $userQuery2->first();
		
		if(!empty($isUserEmail) && $isUserEmail->id != $id){
			return back()->withErrors(['message' => 'Email already exists']);
		}
		
		$udata = User::where('id', $id)->first();
		
		if(!empty($request->image_tmp)){
			
			if(!empty($udata->image)){
				Storage::disk('public')->delete($udata->image);
			}
			
			$imgname = 'img-'.time().'.'.$request->image_tmp->extension();
			
			$input['image'] = Storage::disk('public')->putFileAs(
				'drivers/'.$udata->id.'/', $request->image_tmp, $imgname
			);
		}
		
		$udata->update($input);
		
		return back()->with('success', trans('admin.Record updated!'));
    }
	
    public function destroy(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            // $currentTime = Carbon::now();
            // User::where('id', $request->user_id)->delete();
            // Ride::where(['driver_id' => $request->user_id])->where('ride_time', '>', $currentTime)->update(['driver_id' => null]);
            ServiceProviderDriver::where(['service_provider_id'=>Auth::user()->id,'driver_id'=>$request->user_id])->delete();
            DB::commit();
            return response()->json(['status' => 1, 'message' => __('The driver has been deleted.')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
    }

}
