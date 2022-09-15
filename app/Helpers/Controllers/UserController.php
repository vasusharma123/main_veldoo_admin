<?php
namespace App\Http\Controllers;

use Auth;
use Validator;
use App\User;
//use App\UserData;
use App\UserData;
use App\Category;
use App\Setting;
use App\Voucher;
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
use App\Ride;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class UserController extends Controller
{
	protected $layout = 'layouts.admin';
	
	protected $roles = [3=>'Administrator',2=>'Driver',1=>'Customer',4=>'Company'];

	public function __construct() {
		$this->table = 'users';
		$this->folder = 'users';
		view()->share('route', 'users');
		$this->limit = config('app.record_limit_web');
		$this->successCode = 200;
		$this->errorCode = 401;
		$this->warningCode = 500;
	}
   
	public function guest_message(){
		 return view('admin.guest_message');
	}

	public function login(){
		$breadcrumb = array('title'=>'Home','action'=>'Login');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		return view('admin.login')->with($data);
	}
	
	public function doLogin(Request $request){
		$rules = [
			'email' => 'required|email',
			'password' => 'required|min:6',
			'user_type'=>'required'
		];
		$request->validate($rules);
		$input = $request->all();
		$whereData = array('email' => $input['email'], 'password' => $input['password'],'user_type'=>$request->user_type);
        if(auth()->attempt($whereData)){
            return redirect()->route('users.dashboard');
        } else{
       		 Auth::logout();
			return Redirect::to('admin')->withErrors(['message' => 'Please check your credentials and try again.']);
		}

	}
	
	public function dashboard(){
		$breadcrumb = array('title'=>'Home','action'=>'Dashboard');
		$data = [];
		if(Auth::user()->user_type==3){
		Auth::user()->syncRoles('Administrator');
		}elseif(Auth::user()->user_type==4){
			Auth::user()->syncRoles('Company');
		}
		$data['rider_count']=User::where('user_type',1)->count();
		$data['driver_count']=User::where('user_type',2)->count();
		$data['booking_count']=Ride::count();
		$data['past_booking_count']=Ride::whereDate('ride_time','<',Carbon::today())->count();
		$data['companies_registered']=\App\User::where('user_type',4)->count();
		$data['current_booking_count']=Ride::whereDate('ride_time','=',Carbon::today())->count();
		$data['upcoming_booking_count']=Ride::whereDate('ride_time','>',Carbon::today())->count();
		$data['revenue']=Ride::where('status',3)->sum('ride_cost');
		$data['company_users']=User::where('user_type',1)->where('created_by','>',0)->count();
		$data = array_merge($breadcrumb,$data);
		return view('admin.dashboard')->with($data);
	}
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	
	    $breadcrumb = array('title'=>'Users','action'=>'List Users');
		$data = [];
		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('users')->where([['id', $request->input('id')],['user_type', 1]])->limit(1)->update(array('status' => $status));
		}
		if($request->has('invoice_status') && !empty($request->input('id')) ){
			print_r($request->has('invoice_status'));
			$invoice_status = ($request->input('invoice_status')?0:1);
			DB::table('users')->where([['id', $request->input('id')],['user_type', 1]])->limit(1)->update(array('invoice_status' => $invoice_status));
	     	}
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			DB::table($this->table)->where([['id', $request->input('id')]])->delete();
		}
		
		$loggedInUser=\App\User::where('id',Auth::user()->id)->first();
		if($loggedInUser->hasRole('Company')){
			$users = DB::table('users')->where('created_by',Auth::user()->id);
		}else{
			$users = DB::table('users');
		}
		$users->where('user_type', '=', 1);
		if(!empty($request->input('text'))){
			$users->where('first_name', 'like', '%'.$request->input('text').'%')->orWhere('last_name', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$users->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$users->orderBy('id', 'desc');
		}
		
		$data['users'] = $users->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('admin.users.index_element')->with($data);
        }
	    return view('admin.users.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $breadcrumb = array('title'=>'Users','action'=>'Add User');
		
		$data = [];
		$data = array_merge($breadcrumb,$data);
	    return view('admin.users.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		//DB::beginTransaction();
		try {
	    $rules = [
			'image_tmp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
			//'user_name' => 'required|regex:/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/u|unique:users',
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6',
			'status' => 'required',
			'phone' => 'required',
		];
		
		$request->validate($rules);
		$input=$request->all();
		
		if(Auth::user()->hasRole('Company')==true){
			//rider
			$userData=\App\User::where('phone',$request->phone)->first();
			if(!empty($userData)){
			return redirect()->route("{$this->folder}.index")->with('warning', trans('admin.This phone number already exists!'));
		}
			$user_type=1;
			$createdBy=Auth::user()->id;
		}else{
			$userData=\App\User::where('user_type',2)->where('phone',$request->phone)->first();
			//driver
			if(!empty($userData)){
			return redirect()->route("users.drivers")->with('warning', trans('admin.This phone number already exists!'));
		}
			$user_type=2;
			$createdBy=0;
		}
		//$input->request->add([ 'password' => Hash::make($request->input('password')),'user_type' => $user_type,'created_by'=>$createdBy]);
		$input['password']=Hash::make($request->input('password'));
		$input['user_type']=$user_type;
		$input['created_by']=$createdBy;
		$user  = \App\User::create($input);
		//dd($user);
		//SAVE IMAGE
		$path = 'users/'.$user->id.'/profile/';
		$imageName = 'profile-image.'.$request->image_tmp->extension();
		
           $image=Storage::disk('public')->putFileAs(
				'user/'.$user->id, $request->image_tmp, $imageName);
      \App\User::where('id',$user->id)->update(['image'=>$image]);
		//$user->save();
		if(Auth::user()->hasRole('Company')==true){
			$data=['phone_number'=>$user->phone,'password'=>$request->input('password')];
			$res=Mail::send('admin.users.email', $data, function($message) use ($user) {
				$message->to($user->email)->subject('New Updates');
				});
		//DB::commit();
		return back()->with('success', 'User created!');
		}else{
			return back()->with('success', 'Driver created!');
		}
		} catch (\Illuminate\Database\QueryException $exception){
			//DB::rollBack();
			return back()->with('error',$exception->getMessage());
		}catch(\Exception $exception){
		//	DB::rollBack();
			return back()->with('error',$exception->getMessage());
		}
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
	    $breadcrumb = array('title'=>'Users','action'=>'Edit User');
		$data = [];
        $where = array('id' => $id,'user_type'=>1);
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
		$query = User::where(['id'=>$id,'user_type'=>1]);
		$haveUser = $query->first();
		$rules = [
           // 'user_name' =>  'required|'.(!empty($haveUser->id) ? 'unique:users,user_name,'.$haveUser->id : ''),
            'email' => 'required|'.(!empty($haveUser->id) ? 'unique:users,email,'.$haveUser->id : ''),
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
		
		$path = 'users/'.$haveUser->id.'/profile/';
		$pathDB = 'public/users/'.$haveUser->id.'/profile/';
		
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
	
    public function profile()
    {
	    $breadcrumb = array('title'=>'Users','action'=>'My Profile');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		
        $record = Auth::user();
		if(empty($record)){
			return redirect()->route('users.dashboard')->with('warning', 'Record not found!');
		}
		$record->admin_primary_color = UserData::firstOrNew(['user_id' => Auth::user()->id,'meta_key' => 'admin_primary_color'])->meta_value;
		$record->admin_logo = UserData::firstOrNew(['user_id' => Auth::user()->id,'meta_key' => 'admin_logo'])->meta_value;
		$record->admin_favicon = UserData::firstOrNew(['user_id' => Auth::user()->id,'meta_key' => 'admin_favicon'])->meta_value;
		$record->admin_background = UserData::firstOrNew(['user_id' => Auth::user()->id,'meta_key' => 'admin_background'])->meta_value;
		$record->admin_sidebar_logo = UserData::firstOrNew(['user_id' => Auth::user()->id,'meta_key' => 'admin_sidebar_logo'])->meta_value;
		$record->radius = UserData::firstOrNew(['user_id' => Auth::user()->id,'meta_key' => '_radius'])->meta_value;
		$record->site_name = UserData::firstOrNew(['user_id' => Auth::user()->id,'meta_key' => '_site_name'])->meta_value;
		$record->copyright = UserData::firstOrNew(['user_id' => Auth::user()->id,'meta_key' => '_copyright'])->meta_value;
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
		
	    return view('admin.users.my_profile')->with($data);
    }
	
    public function profileUpdate(Request $request)
    {

	   $rules = [
			'image' => 'image|mimes:jpeg,png,jpg|max:2048',
			'admin_logo_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
			'admin_favicon_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
			'admin_background_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
			'admin_sidebar_logo_tmp' => 'image|mimes:jpeg,png,jpg|max:2048|dimensions:width=128,height=19',
			'name' => 'required',
			'radius' => 'integer|min:1',
			'email' => 'required|email|unique:users,email,'.Auth::user()->id,
		];
		$message = ['admin_sidebar_logo_tmp.dimensions'=>'Sidebar Logo must be 128x19'];
		$request->validate($rules,$message);
		// $request = $request->except(['_method', '_token','logo_tmp','favicon_tmp','background_tmp','primary_color']);
		$input = $request->all();
		$updateUser['name'] = $request->name;
		$updateUser['email'] = $request->email;
		$user = User::find(Auth::user()->id);
		User::where('id', Auth::user()->id)->update($updateUser);
		$path = 'users/'.Auth::user()->id.'/profile/';
		$pathDB = 'public/users/'.Auth::user()->id.'/profile/';

		
		if($request->hasFile('image') && $request->file('image')->isValid()){
			
			$isImage = Auth::user()->image;
			if(!empty($isImage)){
				Storage::disk('public')->delete("$isImage");
			}
			
			$imageName = 'profile-image.'.$request->image->extension();
			
			$user->image = Storage::disk('public')->putFileAs(
				'user/'.Auth::user()->id, $request->file('image'), $imageName
			);
						
			$user->save();
		}
		return back()->with('success', __('Record updated!'));
    }
	
    public function changePassword(Request $request)
    {

	   $rules = [
			'oldpassword' => ['required', new MatchOldPassword],
			'password' => 'required|min:6',
			'confirm_password' => 'required|min:6|same:password',
		];
		$request->validate($rules);

		User::find(auth()->user()->id)->update(['password'=> $request->password]);
		return back()->with('success', __('Password updated successfully.'));
	}

	
    public function settings()
    {
	    $breadcrumb = array('title'=>'User','action'=>'Settings');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		$record = (object)[];
		$configuration =  Setting::firstOrNew(['key' => '_configuration'])->value;
		$data['record'] = json_decode($configuration);
		$data = array_merge($breadcrumb,$data);
	    return view('admin.users.settings')->with($data);
    }
	public function settingsUpdate(Request $request)
	{
		$rules = [
            'admin_logo_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
            'admin_favicon_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
            'admin_background_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
            'admin_sidebar_logo_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
          //  'facebook' => 'url',
          //  'twitter' => 'url',
          //  'instagram' => 'url',
            //'paypal_email' => 'email',
		];
		$message = [
			'admin_background_tmp.mimes'=> 'The Background Image failed to upload.'
		];
		$request->validate($rules,$message);
		$path = 'setting/';
		$pathDB = 'public/setting/';
		$record = [];
 		$setting = Setting::where(['key'=>'_configuration'])->first();
		if (empty($setting)) {
			$setting = new Setting;
		} else {
			$record = json_decode($setting->value);
		}
		
		$setting->key = '_configuration';
		$input = $request->all();
		unset($input['_token'],$input['_method'],$input['admin_logo_tmp'],$input['admin_favicon_tmp'],$input['admin_background_tmp'],$input['admin_sidebar_logo_tmp']);
		if(!empty($request->admin_logo_tmp)){
			$logoName = 'admin-logo.'.$request->admin_logo_tmp->extension();
			
			if(!empty($record->admin_logo)){
				Storage::disk('public')->delete($record->admin_logo);
				//Storage::disk('public')->delete("$isImage");
			}
			
			$setting["value->admin_logo"] = Storage::disk('public')->putFileAs(
				'setting/', $request->admin_logo_tmp, $logoName
			);
		}
 		if(!empty($request->admin_favicon_tmp)){
			$favName = 'admin-favicon.'.$request->admin_favicon_tmp->extension();
			if(!empty($record->admin_favicon)){
				Storage::disk('public')->delete('setting/'.$record->admin_favicon);
			}
			
			$setting["value->admin_favicon"] = Storage::disk('public')->putFileAs(
				'setting/', $request->admin_favicon_tmp, $favName
			);
		}
 		if(!empty($request->admin_background_tmp)){
			$backgroundName = 'admin-background.'.$request->admin_background_tmp->extension();
			if(!empty($record->admin_background)){
				Storage::disk('public')->delete($record->admin_background);
			}
			
			$setting["value->admin_background"] = Storage::disk('public')->putFileAs(
				'setting/', $request->admin_background_tmp, $backgroundName
			);
		}
 		if(!empty($request->admin_sidebar_logo_tmp)){
			$sidebarLogoName = 'admin-sidebar-logo.'.$request->admin_sidebar_logo_tmp->extension();
			if(!empty($record->admin_sidebar_logo)){
				Storage::disk('public')->delete('setting/'.$record->admin_sidebar_logo);
			}
			
			$setting["value->admin_sidebar_logo"] = Storage::disk('public')->putFileAs(
				'setting/', $request->admin_sidebar_logo_tmp, $sidebarLogoName
			);
		}

		if($request->notification==0 && $request->notification!=null){
			$input['notification']=1;
		}else{
			$input['notification']=0;
		}
		
		foreach($input as $key=>$value){
			$setting["value->$key"] = $value;
		}
		$setting->save();
		return back()->with('success', __('Record updated!'));
	}
	public function vouchers()
    {
	    $breadcrumb = array('title'=>'User','action'=>'Vouchers');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		$record = (object)[];
		$configuration =  Voucher::firstOrNew(['key' => '_configuration'])->value;
		$data['record'] = json_decode($configuration);
		$data = array_merge($breadcrumb,$data);
	    return view('admin.users.voucher')->with($data);
    }
	public function vouchersUpdate(Request $request)
	{
		
		$path = 'voucher/';
		$pathDB = 'public/voucher/';
		$record = [];
 		$voucher = Voucher::where(['key'=>'_configuration'])->first();
		if (empty($voucher)) {
			$voucher = new Voucher;
		} else {
			$record = json_decode($voucher->value);
		}
		
		$voucher->key = '_configuration';
		$input = $request->all();
		
		
		foreach($input as $key=>$value){
			/* echo $key;
			echo $value; */
			$voucher["value->$key"] = $value;
		}
		$voucher->save();
		return back()->with('success', __('Record updated!'));
	}
	  public function driver(Request $request)
    {
	    $breadcrumb = array('title'=>'Drivers','action'=>'List Drivers');
		$data = [];


		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('users')->where([['id', $request->input('id')],['user_type', 2]])->limit(1)->update(array('status' => $status));
		}

		if($request->has('is_master') && !empty($request->input('id')) ){
			$is_master = ($request->input('is_master')?0:1);
			DB::table('users')->where([['id', $request->input('id')],['user_type', 2]])->limit(1)->update(array('is_master' => $is_master));
		}
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			DB::table($this->table)->where([['id', $request->input('id')]])->delete();
		}
		$users = DB::table('users');
		$users->where('user_type', '=', 2);
		if(!empty($request->input('text'))){
			$users->where('first_name', 'like', '%'.$request->input('text').'%')->orWhere('last_name', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$users->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$users->orderBy('id', 'desc');
		}
		
		$data['users'] = $users->paginate($this->limit);
		$data['active_deriver'] = $users->where('availability',1)->count();
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('admin.drivers.index_element')->with($data);
        }
	    return view('admin.drivers.index')->with($data);
    }
	
	 public function editDriver($id)
    {
	    $breadcrumb = array('title'=>'Driver','action'=>'Edit Driver');
		$data = [];
        $where = array('id' => $id,'user_type'=>2);
        $record = User::where($where)->first();
	// print_r($record); die;
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
				  
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("admin.drivers.edit")->with($data);
    }
	
	public function updateDriver(Request $request, $id)
    {
		$query = User::where(['id'=>$id,'user_type'=>2]);
		$haveUser = $query->first();
		$rules = [
           // 'user_name' =>  'required|'.(!empty($haveUser->id) ? 'unique:users,user_name,'.$haveUser->id : ''),
            'email' => 'required|'.(!empty($haveUser->id) ? 'unique:users,email,'.$haveUser->id : ''),
            'image_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
            //'gender' => 'required|integer|between:1,2',
            //'dob' => 'required',
		];
		if(!empty($request->reset_password)){
			$rules['password'] = 'required|min:6';
		}
		$request->validate($rules);
		$user=\App\User::where('user_type',2)->where('id','!=',$id)->where('phone',$request->phone)->first();
		if(!empty($user)){
			return redirect()->route("users.drivers")->with('warning', trans('admin.This phone number already exists!'));

		}
		$input = $request->all();
		
		unset($input['_method'],$input['_token'],$input['image_tmp']);
		
		$path = 'users/'.$haveUser->id.'/profile/';
		$pathDB = 'public/users/'.$haveUser->id.'/profile/';
		
		if($request->hasFile('image_tmp') && $request->file('image_tmp')->isValid()){
			
			$imageName = 'profile-image.'.$request->image_tmp->extension();
			if(!empty($haveUser->image)){
				Storage::disk('public')->delete($haveUser->image);
			}
			
			$input['image'] = Storage::disk('public')->putFileAs(
				'user/'.$haveUser->id, $request->image_tmp, $imageName
			);
		}
		unset($input['reset_password']);
		$input['password']=Hash::make($request->input('password'));
		User::where('id', $id)->update($input);
		
		return back()->with('success', __('Record updated!'));
    }
	
	
	public function createDriver(Request $request){
		$breadcrumb = array('title'=>'Drivers','action'=>'Add Driver');
		$data = [];
		$data = array_merge($breadcrumb,$data);
	    return view('admin.drivers.create')->with($data); 
	}
	
	
	   public function showDriver(Request $request,$id)
	   {
		   $breadcrumb = array('title'=>trans('admin.Driver'),'action'=>trans('admin.Driver Detail'));
		   $data = [];
		   $where = array('id' => $id);
		   $record = User::where($where)->first();
		   if(empty($record)){
			   return redirect()->route("{$this->folder}.index")->with('warning', trans('admin.Record not found!'));
			   }
			   
			if ($request->ajax()) {
			if($request->has('type') && $request->input('type')=='approve' && !empty($request->input('id')) ){
				$driver = \App\User::where(['id'=>$id])->first();
			if(empty($driver)){
					// return response()->json(['message'=>"can't approve until bargain not finished."], $this->warningCode);
			}
				$driver->update(['verify'=>1]);
				return response()->json(['message'=>trans('admin.Approved Succesfuly')], $this->successCode);
			}
		}
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
		
	    return view("admin.drivers.show")->with($data);
    }
    
    public function userBooking(Request $request,$id){

		$breadcrumb = array('title'=>'User Booking','action'=>'List User Bookings');
		$data = [];


		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('rides')->where([['id', $request->input('id')],['user_type', 1]])->limit(1)->update(array('status' => $status));
		}
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			DB::table('rides')->where([['id', $request->input('id')]])->delete();
		}
		$users = DB::table('rides')->select('rides.*','users.first_name AS driver_first_name','users.last_name AS driver_last_name','riders.first_name AS rider_first_name','riders.last_name AS rider_last_name')->join('users','users.id','=','rides.driver_id')->join('users AS riders','rides.user_id','=','riders.id')->where('user_id',$id);
		if(!empty($request->input('text'))){
			$users->where('first_name', 'like', '%'.$request->input('text').'%')->orWhere('last_name', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$users->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$users->orderBy('id', 'desc');
		}
		$data['id']=$id;
		$data['array'] = $users->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('admin.users.bookings_element')->with($data);
        }
	    return view('admin.users.bookings')->with($data);

    }


    public function driverBooking(Request $request,$id){

		$breadcrumb = array('title'=>'Driver Booking','action'=>'List Driver Bookings');
		$data = [];


		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('rides')->where([['id', $request->input('id')],['user_type', 1]])->limit(1)->update(array('status' => $status));
		}
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			DB::table('rides')->where([['id', $request->input('id')]])->delete();
		}
		$users = DB::table('rides')->select('rides.*','users.first_name AS driver_first_name','users.last_name AS driver_last_name','riders.first_name AS rider_first_name','riders.last_name AS rider_last_name')->join('users','users.id','=','rides.driver_id')->join('users AS riders','rides.user_id','=','riders.id')->where('driver_id',$id);
		if(!empty($request->input('text'))){
			$users->where('first_name', 'like', '%'.$request->input('text').'%')->orWhere('last_name', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$users->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$users->orderBy('id', 'desc');
		}
		$data['id']=$id;
		$data['array'] = $users->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('admin.users.bookings_element')->with($data);
        }
	    return view('admin.users.bookings')->with($data);

    }

public function register(){
		$breadcrumb = array('title'=>'Home','action'=>'Register');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		return view('admin.register')->with($data);

}

	public function doRegister(Request $request){
			$rules = [
				'email' => 'required|email|unique:users',
				'password' => 'required|min:6',
				'confirm_password' => 'required|min:6',
				'phone'=>'required',
				'country_code'=>'required',
				'first_name'=>'required',
				'last_name'=>'required'
			];
			$request->validate($rules);
			$input = $request->all();
			$input['password']=Hash::make($request->input('password'));
			$input['user_type']=4;
			$otp = rand(1000,9999);
			$user=User::create($input);
			$expiryMin = config('app.otp_expiry_minutes');
					$endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');
					\App\OtpVerification::create(
						['phone'=>$request->phone,
						'otp' => $otp,
						'expiry'=>$endTime,
						'country_code'=>$request->country_code
						]
					);
				
			return redirect()->to(url('verify/'.$request->email));
	}

	public function verify($email){
	$breadcrumb = array('title'=>'Home','action'=>'Register');
			$data = [];
			$data['email']=$email;
			$data = array_merge($breadcrumb,$data);
			return view('admin.verify')->with($data);
	}


	public function verifyOtp(Request $request){
	$rules = [
				'otp' => 'required'
			];
			$request->validate($rules);
			$input = $request->all();
			$user=\App\User::where('email',$request->email)->first();
			$otpVerification=\App\OtpVerification::where('country_code',$user->country_code)->where('phone',$user->phone)->where('otp',$request->otp)->first();
			if(!empty($otpVerification)){
				Auth::login($user);
			return redirect()->route('users.dashboard');
			}
	}
	

	public function updateLatLong(Request $request){
		$userId= Auth::user()->id;
		if(!empty($userId)){
			\App\User::where('id',$userId)->update(['current_lat'=>$request->lat,'current_lng'=>$request->lng]);
			return response()->json(['data'=>'success']);
		}
	}
	
	
	public function exportExcel(Request $request){
		$data=['type'=>$request->type];
		$dataModel=new UsersExport($data);
		if($request->type=="rider"){
			 return Excel::download($dataModel, 'riders.xlsx');
			 exit();
		}elseif($request->type=="driver"){
			 return Excel::download($dataModel, 'drivers.xlsx');
			 exit();
		}elseif($request->type=="company"){
			 return Excel::download($dataModel, 'companies.xlsx');
			 exit();
		}
	}
	
	public function logout(Request $request){
        Session::flush();
        Auth::logout();
        return Redirect('admin');
	}
}
