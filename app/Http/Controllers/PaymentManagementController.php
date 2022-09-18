<?php
namespace App\Http\Controllers;

use Auth;
use Validator;
use App\User;
//use App\UserData;
use App\UserData;
use App\Category;
use App\Setting;
use Session;
use Config;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Mail;
use App\Price;

class PaymentManagementController extends Controller
{
	protected $layout = 'layouts.admin';
	
	public function __construct() {
		$this->table = 'payment_managements';
		$this->folder = 'payment_management';
		view()->share('route', 'payment_management');
		$this->limit = config('app.record_limit_web');
	}
   
	public function guest_message(){
		 return view('admin.guest_message');
	}
	

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	    $breadcrumb = array('title'=>'Payment Fees','action'=>'List Payment Fees');
		$data = [];


		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('payment_managements')->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			DB::table($this->table)->where([['id', $request->input('id')]])->delete();
		}
		$payment_managements = DB::table('payment_managements');
		if(!empty($request->input('text'))){
			$payment_managements->where('first_name', 'like', '%'.$request->input('text').'%')->orWhere('last_name', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$payment_managements->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$payment_managements->orderBy('id', 'desc');
		}
		
		$data['payment_managements'] = $payment_managements->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('admin.payment_management.index_element')->with($data);
        }
	    return view('admin.payment_management.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $breadcrumb = array('title'=>'Payment Management','action'=>'Add To Payment Charges');
		
		$data = [];
		$data['record']=\App\PaymentManagement::first();
		$data = array_merge($breadcrumb,$data);
	    return view('admin.payment_management.create')->with($data);
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
			'fee' => 'required',
		];
		$request->validate($rules);
		//$request=$request()->except(['_token']);
		$paymentManagementData=\App\PaymentManagement::first();
		if(!empty($paymentManagementData)){
		 \App\PaymentManagement::where('id',$paymentManagementData->id)->update(['fee'=>$request->fee,'status'=>1]);
		}else{
		 \App\PaymentManagement::create(['fee'=>$request->fee,'status'=>1]);
		}
			$data = [];
		$data['record']=\App\PaymentManagement::first();
		return Redirect::back()->with('message','Successful !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    $breadcrumb = array('title'=>trans('admin.User'),'action'=>trans('admin.User Detail'));
		$data = [];
        $where = array('id' => $id);
        $record = User::where($where)->first();
		
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', trans('admin.Record not found!'));
		}
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
		
	    return view("admin.{$this->folder}.show")->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $breadcrumb = array('title'=>'payment_managements','action'=>'Edit User');
		$data = [];
        $where = array('id' => $id);
        $record = User::where($where)->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
				  
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("admin.{$this->folder}.edit")->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$query = User::where(['id'=>$id]);
		$haveUser = $query->first();
		$rules = [
          'email' => 'required|'.(!empty($haveUser->id) ? 'unique:payment_managements,email,'.$haveUser->id : ''),
            'image_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
       ];
		if(!empty($request->reset_password)){
			$rules['password'] = 'required|min:6';
		}
		$request->validate($rules);
		$input = $request->all();
		
		unset($input['_method'],$input['_token'],$input['image_tmp']);
		
		$path = 'payment_managements/'.$haveUser->id.'/profile/';
		$pathDB = 'public/payment_managements/'.$haveUser->id.'/profile/';
		
		if($request->hasFile('image_tmp') && $request->file('image_tmp')->isValid()){
			
			$imageName = 'profile-image.'.$request->image_tmp->extension();
			if(!empty($haveUser->image)){
				Storage::disk('public')->delete($haveUser->image);
			}
			
			$input['image'] = Storage::disk('public')->putFileAs(
				'user/'.$haveUser->id, $request->image_tmp, $imageName
			);
		}
		
		User::where('id', $id)->update($input);
		
		return back()->with('success', __('Record updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


public function vehicleType(Request $request)
    {
         $breadcrumb = array('title'=>'Vehicle Type','action'=>'List Vehicle Type');
		$data = [];


		/*if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('prices')->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}*/
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			DB::table('prices')->where([['id', $request->input('id')]])->delete();
		}
		$vehicleTypes = DB::table('prices');
		if(!empty($request->input('text'))){
			$vehicleTypes->where('car_type', 'like', '%'.$request->input('text').'%')->orWhere('price_per_km', 'like', '%'.$request->input('text').'%')
				->orWhere('price_per_min_mile', 'like', '%'.$request->input('text').'%')
				->orWhere('commission', 'like', '%'.$request->input('text').'%')
				->orWhere('ride_cancel_time_limit', 'like', '%'.$request->input('text').'%')
				->orWhere('ride_cancel_price', 'like', '%'.$request->input('text').'%')
				->orWhere('seating_capacity', 'like', '%'.$request->input('text').'%')
				->orWhere('pick_time', 'like', '%'.$request->input('text').'%')
				->orWhere('night_charges', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$vehicleTypes->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$vehicleTypes->orderBy('id', 'desc');
		}
		
		$data['vehicleTypes'] = $vehicleTypes->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('admin.vehicle_type.index_element')->with($data);
        }
	    return view('admin.vehicle_type.index')->with($data);

    }

    public function editVehicleType(Request $request,$id){
    	$breadcrumb = array('title'=>'Vehicle Type','action'=>'Edit Vehicle Type');
		$data = [];
        $where = array('id' => $id);
        $record = Price::where($where)->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
		$data['car_types']=['1'=>'Go','4'=>'Pool'];	  
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("admin.vehicle_type.edit")->with($data);
    }


    public function updateVehicleType(Request $request, $id)
    	{
			$query = Price::where(['id'=>$id]);
			$haveUser = $query->first();
			$rules = [
		          'car_type' => 'required',
		          'price_per_km' => 'required',
		        //  'price_per_min_mile' => 'required',
	              'commission' => 'required',
	              'ride_cancel_time_limit' => 'required',
	              'ride_cancel_price' => 'required',
	              //'seating_capacity' => 'required',
	              //'pick_time' => 'required',
	              //'night_charges' => 'required',
	       ];
			
			$request->validate($rules);
			$input = $request->all();
			
			if(empty($request->night_charges) && $request->night_charges==null){
			$input['night_charges']=0;
			}else{
				$input['night_charges']=1;
			}
			$input['updated_at']=date('Y-m-d H:i:s');
			unset($input['_method'],$input['_token']);
				\App\Price::where('id',$id)->update($input);
			return back()->with('success', __('Record updated!'));
	}

	public function showVehicleType($id)
    {
	    $breadcrumb = array('title'=>trans('admin.Vehicle Type Detail'),'action'=>trans('admin.Vehicle Type Detail'));
		$data = [];
        $where = array('id' => $id);
        $record = Price::where($where)->first();
		
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', trans('admin.Record not found!'));
		}
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
		
	    return view("admin.vehicle_type.show")->with($data);
    }
  
}
