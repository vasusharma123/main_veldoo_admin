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

class AdminControlController extends Controller
{
	protected $layout = 'layouts.admin';
	
	public function __construct() {
		$this->table = 'admin_controls';
		$this->folder = 'admin_control';
		view()->share('route', 'admin-control');
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
    public function indexs(Request $request)
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
	    $breadcrumb = array('title'=>'Payment Management','action'=>'Add Payment Fee');
		
		$data = [];
		$data['record']=\App\AdminControl::first();
		$data = array_merge($breadcrumb,$data);
	    return view('admin.admin_control.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		//dd($request->driver_cancel_time);
	 $rules = [
		/*'driver_cancel_time' => 'required',
		'max_rides_cancelled' => 'required',
		'emergency_contact' => 'required'
		'minimum_price_per_km' => 'required'
		'rush_hours_price' => 'required'*/
		];
		$request->validate($rules);
		//$request=$request()->except(['_token']);
		$adminControl=\App\AdminControl::first();
		if(!empty($adminControl)){
		 \App\AdminControl::where('id',$adminControl->id)->update(['driver_cancel_time'=>$request->driver_cancel_time,'max_rides_cancelled'=>$request->max_rides_cancelled,'emergency_contact'=>$request->emergency_contact,'minimum_price_per_km'=>$request->minimum_price_per_km,'rush_hours_price'=>$request->rush_hours_price,'status'=>1]);
		}else{
		 \App\AdminControl::create(['driver_cancel_time'=>$request->driver_cancel_time,'max_rides_cancelled'=>$request->max_rides_cancelled,'emergency_contact'=>$request->emergency_contact,'minimum_price_per_km'=>$request->minimum_price_per_km,'rush_hours_price'=>$request->rush_hours_price,'status'=>1]);
		}
		$data = [];
		$data['record']=\App\AdminControl::first();
		//return view('admin.payment_management.create')->with($data);
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
           // 'user_name' =>  'required|'.(!empty($haveUser->id) ? 'unique:payment_managements,user_name,'.$haveUser->id : ''),
            'email' => 'required|'.(!empty($haveUser->id) ? 'unique:payment_managements,email,'.$haveUser->id : ''),
            'image_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
            //'gender' => 'required|integer|between:1,2',
            //'dob' => 'required',
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

  
}
