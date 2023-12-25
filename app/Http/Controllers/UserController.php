<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;
//use App\UserData;
use App\UserData;
use App\Category;
use App\Setting;
use App\Voucher;
use Illuminate\Support\Str;
use Session;
use Config;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
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
use DataTables;
use App\DriverStayActiveNotification;
use App\DriverChooseCar;
use Exception;
use App\Price;
use App\Vehicle;
use App\SMSTemplate;
use App\ServiceProviderDriver;
use App\Page;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\GuestRegisterRequest;

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


	public function guestLogin(){
		$breadcrumb = array('title'=>'Home','action'=>'Login');
		$vehicle_types = Price::orderBy('sort')->get();


		$data = [];
		$data = array_merge($breadcrumb,$data);
		$data['vehicle_types'] = $vehicle_types;
		return view('guest.auth.login')->with($data);
	}

	public function guestRegister(){
		$breadcrumb = array('title'=>'Home','action'=>'Login');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		return view('guest.auth.register')->with($data);
	}

	public function login(){
		$data = array('page_title' => 'Login', 'action' => 'Login');
		return view('admin.login')->with($data);
	}


	/* Service provider Login */

	public function spLogin(Request $request)
	{
		$rules = [
			'email' => 'required|email',
			'password' => 'required|min:6'
		];
		$request->validate($rules);
		$input = $request->all();
		$remember_me = $request->has('remember') ? true : false;
		$whereData = array('email' => $input['email'], 'password' => $input['password'], 'user_type' => 3);
		if (auth()->attempt($whereData, $remember_me)) {
			Auth::user()->syncRoles('Administrator');
			return redirect()->route('users.dashboard');
		} else {
			Auth::logout();
			return redirect()->back()->withInput($input)->with('error', 'Please check your credentials and try again.');
			// return redirect()->back()->withErrors(['message' => 'Please check your credentials and try again.']);
		}
	}

	public function doLogin(Request $request){
		$rules = [
			'email' => 'required|email',
			'password' => 'required|min:6',
			// 'user_type'=>'required'
		];
		$request->validate($rules);
		$input = $request->all();
		$whereData = array('email' => $input['email'], 'password' => $input['password']);
        if(auth()->attempt($whereData)){
			if (in_array(Auth::user()->user_type,[4,5])) {
				Auth::user()->syncRoles('Company');
				return redirect()->route('company.rides','month');

			}
            return redirect()->route('users.dashboard');
        } else{
			Auth::logout();
			return redirect()->back()->withErrors(['message' => 'Please check your credentials and try again.']);
		}

	}

	public function doLoginGuest(Request $request){



		$rules = [
			'phone' => 'required',
			'country_code' => 'required',
			'password' => 'required|min:6',
		];
		$request->validate($rules);
		$input = $request->all();

		//$whereData = array('phone' => '7355551203', 'country_code' => '91', 'password' => '123456');
		//$whereData = array('email' => 'suryamishra20794@gmail.com', 'password' => '123456');
		$phone_number = str_replace(' ', '', ltrim($request->phone, "0"));

		$user = User::where('phone', $phone_number)->where('country_code', $request->country_code)->where('user_type', 1)->first();
		//dd(Hash::check($request->password, $user->password));
		if (!empty($user) && Hash::check($request->password, $user->password)) {
			\Auth::login($user);
			if (in_array(Auth::user()->user_type,[1])) {
				Auth::user()->syncRoles('Customer');
				return redirect()->route('guest.rides','month');
			}
			Auth::logout();
			return redirect()->back()->withInput(array('phone' => $request->phone, 'country_code' => $request->country_code))->withErrors(['message' => 'These credentials do not match our records.']);

		} else{
			Auth::logout();
			return redirect()->back()->withInput(array('phone' => $request->phone, 'country_code' => $request->country_code))->withErrors(['message' => 'Please check your credentials and try again.']);
		}
		
		
	}
	
	public function dashboard(){
		
		$breadcrumb = array('title'=>'Dashboard','action'=>'Dashboard');
		$data = [];
		$data = array_merge($breadcrumb, $data);
		
		return view('admin.dashboard')->with($data);
    }
	
	public function dashboardOld(){
		
		$breadcrumb = array('title'=>'Dashboard','action'=>'Dashboard');
		$data = [];
		$data = array_merge($breadcrumb,$data);

		if(Auth::user()->user_type==3)
		{
			$data['booking_count'] = Ride::where('service_provider_id',Auth::user()->id)->count();
			$data['rider_count'] = User::where('user_type',1)->where('service_provider_id',Auth::user()->id)->count();
			$data['driver_count'] = ServiceProviderDriver::where('service_provider_id',Auth::user()->id)->count();
			$data['past_booking_count']=Ride::whereDate('ride_time','<',Carbon::today())->where('service_provider_id',Auth::user()->id)->count();
			$data['companies_registered']=User::where('user_type',4)->where('service_provider_id',Auth::user()->id)->count();
			$data['current_booking_count']=Ride::whereDate('ride_time','=',Carbon::today())->where('service_provider_id',Auth::user()->id)->count();
			$data['upcoming_booking_count']=Ride::whereDate('ride_time','>',Carbon::today())->where('service_provider_id',Auth::user()->id)->count();
			$data['revenue']=Ride::where('status',3)->where('service_provider_id',Auth::user()->id)->sum('price');
			$data['company_users']=User::where('user_type',1)->where('service_provider_id',Auth::user()->id)->where('created_by','>',0)->count();
			Auth::user()->syncRoles('Administrator');
		}
		elseif(Auth::user()->user_type==4)
		{
			$data['booking_count'] = Ride::where('company_id',Auth::user()->company_id)->count();
			Auth::user()->syncRoles('Company');
            return redirect()->route("company.rides");
		}
		elseif(Auth::user()->user_type==5)
		{
			$data['booking_count'] = Ride::where('company_id',Auth::user()->company_id)->count();
			Auth::user()->syncRoles('Company');
            return redirect()->route("company.rides");
		}
		return view('dashboards.'.Auth::user()->user_role)->with($data);
	}
	
	public function index(Request $request) {
		
		$data = array();
		$data = array('title' => 'Users', 'action' => 'List Users');
		
		$records = DB::table('users');
		$records->selectRaw('id, first_name, last_name, email, phone, status, name, country_code, invoice_status');
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			
			DB::table('users')->where([['id', $request->input('id')],['user_type', 1]])->limit(1)->update(array('deleted' => $status));
		}
		
		if(!empty($request->input('text'))){
			$text = $request->input('text');
			$records->whereRaw("(first_name LIKE '%$text%' OR last_name LIKE '%$text%' OR phone LIKE '%$text%' OR email LIKE '%$text%') AND user_type=1 AND deleted=0");
		}
		
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}
		
		$data['records'] = $records->where(['user_type'=>1, 'deleted'=>0])->paginate($this->limit);
		
		/* echo '<pre>';
		print_r($data['array']->toArray());
		exit; */
		
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		
        if ($request->ajax()) {
            return view("admin.users.index_element")->with($data);
        }
		
		return view('admin.users.index')->with($data);
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function indexOld(Request $request)
	{
		$data = array();
		$data = array('title' => 'Users', 'action' => 'List Users');
		/*$data = [];
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
        */

		if ($request->ajax()) {

			$data = User::select(['id', 'first_name', 'last_name', 'email', 'phone', 'status', 'name', 'country_code', 'invoice_status'])->where('user_type', 1)->orderBy('id', 'DESC')->get();

			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function ($row) {
					$btn = '<div class="btn-group dropright">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">

                                <a class="dropdown-item" href="' . route('users.show', $row->id) . '">' . trans("admin.View") . '</a>
                                <a class="dropdown-item" href="' . route('users.edit', $row->id) . '">' . trans("admin.Edit") . '</a>
                                <a class="dropdown-item delete_record" data-id="' . $row->id . '">' . trans("admin.Delete") . '</a>
                            </div>
                        </div>';

					return $btn;
				})
				->addColumn('invoice_status', function ($row) {
					$status = ($row->invoice_status === 1) ? 'checked' : '';
					$btn = '<div class="switch">
                            <label>
                                <input type="checkbox" class="invoice_status" data-status="' . $row->invoice_status . '" data-id="' . $row->id . '" ' . $status . '><span class="lever" data-id="' . $row->id . '" ></span>
                            </label>
                        </div>';

					return $btn;
				})
				->addColumn('status', function ($row) {
					$status = ($row->status === 1) ? 'checked' : '';
					$btn = '<div class="switch">
                            <label>
                                <input type="checkbox" class="change_status" data-status="' . $row->status . '" data-id="' . $row->id . '" ' . $status . '><span class="lever" data-id="' . $row->id . '" ></span>
                            </label>
                        </div>';

					return $btn;
				})->addColumn('first_name', function ($row) {
					return ucfirst($row->first_name);
				})->addColumn('full_name', function ($row) {
					return ucfirst($row->first_name) . ' ' . ucfirst($row->last_name);
				})
				->addColumn('last_name', function ($row) {
					return ucfirst($row->last_name);
				})
				->addColumn('phone', function ($row) {
					return (!empty($row->country_code) ? "+".$row->country_code."-":"").$row->phone;
				})
				->rawColumns(['action', 'status', 'first_name', 'last_name', 'invoice_status'])
				->make(true);
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
		$this->validate($request, [
			'image_tmp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
			//'user_name' => 'required|regex:/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/u|unique:users',
			'first_name' => 'required',
			'last_name' => 'required',
			'password' => 'required|min:6',
			'country_code' => 'required',
			'phone' => 'required',
			'email' => 'email|unique:users,email,NULL,id,deleted_at,NULL',
			'addresses' => 'required',
			'zip' => 'required',
			'city' => 'required',
			'country' => 'required',
		]);

		$userData = User::where('country_code', str_replace('+', '', $request->country_code))->where('phone', ltrim($request->phone, "0"))->where('user_type', 2)->get()->count();
		if ($userData > 0) {
			$this->validate($request, ['phone' => 'unique:users,phone']);
		}

		try {
			$input = $request->all();
			if (Auth::user()->hasRole('Company') == true) {
				//rider
				$userData = User::where('phone', ltrim($request->phone, "0"))->first();
				if (!empty($userData)) {
					return redirect()->route("{$this->folder}.index")->with('warning', trans('admin.This phone number already exists!'));
				}
				$user_type = 1;
				$createdBy = Auth::user()->id;
				// $service_provider_id = "";
			} else {
				$userData = User::where('user_type', 2)->where('phone', ltrim($request->phone, "0"))->first();
				//driver
				if (!empty($userData)) {
					return redirect()->route("users.drivers")->with('warning', trans('admin.This phone number already exists!'));
				}
				$email_already_exist = User::where(['email' => $request->email])->withTrashed()->first();
				if(!empty($email_already_exist)){
					return back()->with('warning', "This email address is already used by another user.");
				}
				$user_type = 2;
				$createdBy = 0;
				// $service_provider_id = Auth::user()->id;
				if(!empty($request->phone)){
					if(substr($request->phone, 0, 1) == 0){
						$input['phone'] = substr_replace($request->phone,"",0,1);
					}
				}
			}
			//$input->request->add([ 'password' => Hash::make($request->input('password')),'user_type' => $user_type,'created_by'=>$createdBy]);
			$input['password'] = Hash::make($request->input('password'));
			$input['user_type'] = $user_type;
			$input['created_by'] = $createdBy;
			// $input['service_provider_id'] = $service_provider_id;
			// dd($input);
			$user  = \App\User::create($input);
			//SAVE IMAGE
			if ($request->image) {
				$path = 'users/' . $user->id . '/profile/';
				$imageName = 'profile-image'.time().'.' . $request->image->extension();

				$image = Storage::disk('public')->putFileAs(
					'user/' . $user->id,
					$request->image,
					$imageName
				);
				\App\User::where('id', $user->id)->update(['image' => $image]);
			}
			if (Auth::user()->hasRole('Company') == true) {
				$data = ['phone_number' => $user->phone, 'password' => $request->input('password')];
				$res = Mail::send('admin.users.email', $data, function ($message) use ($user) {
					$message->to($user->email)->subject('New Updates');
				});
				//DB::commit();
				return back()->with('success', 'User created!');
			} else {
				$serviceProviderDriver = new ServiceProviderDriver();
				$serviceProviderDriver->fill(['driver_id'=>$user->id,'service_provider_id'=>Auth::user()->id]);
				$serviceProviderDriver->save();
				return back()->with('success', 'Driver created!');
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			//DB::rollBack();
			return back()->with('error', $exception->getMessage());
		} catch (\Exception $exception) {
			//	DB::rollBack();
			return back()->with('error', $exception->getMessage());
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
	    $data = array();
	    $data = array('title'=>trans('admin.User'),'action'=>trans('admin.User Detail'));

        $where = array('id' => $id);
        $record = User::where($where)->first();

		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', trans('admin.Record not found!'));
		}
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
		// $data = array_merge($breadcrumb,$data);

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

			$imageName = 'profile-image'.time().'.'.$request->image_tmp->extension();
			if(!empty($haveUser->image)){
				Storage::disk('public')->delete($haveUser->image);
			}

			$input['image'] = Storage::disk('public')->putFileAs(
				'user/'.$haveUser->id, $request->image_tmp, $imageName
			);
		}
		// dd($input);
		User::where('id', $id)->update(collect($input)->forget('reset_password')->toArray());

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
		DB::beginTransaction();
		try {
			User::where('id', $id)->delete();
			DB::commit();
			return response()->json(['status' => 1, 'message' => 'User has been deleted.']);
		} catch (\Exception $exception) {
			DB::rollback();
			Log::info($exception->getMessage() . "--" . $exception->getLine());
			return response()->json(['status' => 0, 'message' => 'Something went wrong! Please try again.']);
		}
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

	public function myProfile(Request $request)
	{
		if ($request->isMethod('post'))
		{
			$data = ['name'=>$request->name,'email'=>$request->email];
			if ($request->has('password') && !empty($request->password))
			{
				$data['password'] = hash::make($request->password);
			}
			if ($request->hasFile('profile') && !empty($request->profile))
			{
				$path = 'user/'.Auth::user()->id;
				$imageName = 'profile-image-'.Auth::user()->id.'.'.$request->profile->extension();
				Storage::disk('public')->putFileAs(
					$path, $request->file('profile'), $imageName
				);
				$data['image'] = $path.'/'.$imageName;
			}
			$user = Auth::user();
			$user->fill($data);
			$user->update();
			return back()->with('success', __('Profile updated!'));
		}
		$data = array('title'=>'My Profile','action'=>'Information');
		return view('my-profile')->with($data);
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

			$imageName = 'profile-image'.time().'.'.$request->image->extension();

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

	public function changeForgetPassword(Request $request)
    {

	   $rules = [
			'password' => 'required|min:6',
			'confirm_password' => 'required|min:6|same:password',
		];
		$request->validate($rules);
		$userInfo = User::where(['country_code' => $request->country_code, 'phone' => (int) filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT)])->first();
		if(!$userInfo) {
			return redirect()->back()->withErrors(['message' => 'No such number exists in our record']);
		}	
		User::find($userInfo->id)->update(['password'=> $request->password]);
		return redirect()->route('guest.login')->with('success', __('Password updated successfully.'));
	
	}
	
    public function settings()
    {
	    $breadcrumb = array('title'=>'User','action'=>'Settings');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		$record = (object)[];
		$configuration =  Setting::where(['key' => '_configuration','service_provider_id'=>Auth::user()->id])->first()->value;
		$data['record'] = json_decode($configuration);
		
		/* echo '<pre>';
		print_r($data['record']);
		exit; */
		
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
 		$setting = Setting::where(['key'=>'_configuration'])->where(['service_provider_id'=>Auth::user()->id])->first();
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
				'setting', $request->admin_logo_tmp, $logoName
			);
		}
 		if(!empty($request->admin_favicon_tmp)){
			$favName = 'admin-favicon.'.$request->admin_favicon_tmp->extension();
			if(!empty($record->admin_favicon)){
				Storage::disk('public')->delete('setting'.$record->admin_favicon);
			}

			$setting["value->admin_favicon"] = Storage::disk('public')->putFileAs(
				'setting', $request->admin_favicon_tmp, $favName
			);
		}
 		if(!empty($request->admin_background_tmp)){
			$backgroundName = 'admin-background.'.$request->admin_background_tmp->extension();
			if(!empty($record->admin_background)){
				Storage::disk('public')->delete($record->admin_background);
			}

			$setting["value->admin_background"] = Storage::disk('public')->putFileAs(
				'setting', $request->admin_background_tmp, $backgroundName
			);
		}
 		if(!empty($request->admin_sidebar_logo_tmp)){
			$sidebarLogoName = 'admin-sidebar-logo.'.$request->admin_sidebar_logo_tmp->extension();
			if(!empty($record->admin_sidebar_logo)){
				Storage::disk('public')->delete('setting'.$record->admin_sidebar_logo);
			}

			$setting["value->admin_sidebar_logo"] = Storage::disk('public')->putFileAs(
				'setting', $request->admin_sidebar_logo_tmp, $sidebarLogoName
			);
		}

		$input['notification'] = $request->notification ?? 0;

		foreach($input as $key=>$value){
			$setting["value->$key"] = $value;
		}
		// $setting["value->want_send_sms_to_user_when_ride_accepted_by_driver"] = 0;
		// $setting["value->want_send_sms_to_user_when_driver_reached_to_pickup_point"] = 0;
		// $setting["value->want_send_sms_to_user_when_driver_cancelled_the_ride"] = 0;
		// if ($request->has('want_send_sms_to_user_when_ride_accepted_by_driver'))
		// {
		// 	$setting["value->want_send_sms_to_user_when_ride_accepted_by_driver"] = 1;
		// }
		// if ($request->has('want_send_sms_to_user_when_driver_reached_to_pickup_point'))
		// {
		// 	$setting["value->want_send_sms_to_user_when_driver_reached_to_pickup_point"] = 1;
		// }
		// if ($request->has('want_send_sms_to_user_when_driver_cancelled_the_ride'))
		// {
		// 	$setting["value->want_send_sms_to_user_when_driver_cancelled_the_ride"] = 1;
		// }
		// dd($input);
		$setting->save();
		return back()->with('success', __('Record updated!'));
	}
	
	public function vouchers()
    {
	    $breadcrumb = array('title'=>'User','action'=>'Vouchers');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		$record = (object)[];
		$configuration =  Voucher::where(['key' => '_configuration','service_provider_id'=>Auth::user()->id])->first();
		$data['record'] = json_decode($configuration->value);
		$data = array_merge($breadcrumb,$data);
	    return view('admin.users.voucher')->with($data);
    }
	
	public function createVoucher()
    {
	    $breadcrumb = array('title'=>'Vouchers','action'=>'Create');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		
		$record = (object)[];
		$configuration =  Voucher::where(['key' => '_configuration','service_provider_id'=>Auth::user()->id])->first();
		$data['record'] = json_decode($configuration->value);
		
	    return view('admin.users.createvoucher')->with($data);
    }
	
	
	public function vouchersUpdate(Request $request)
	{
		$matchThese = ['key'=>'_configuration','service_provider_id'=>Auth::user()->id];
		Voucher::updateOrCreate($matchThese,['value'=>json_encode(['mile_per_ride'=>$request->mile_per_ride,'mile_to_currency'=>$request->mile_to_currency,'mile_on_invitation'=>$request->mile_on_invitation])]);
		return back()->with('success', __('Record updated!'));
	}
	
	public function driver(Request $request)
	{
		$data = array();
		$data = array('title' => 'Drivers', 'action' => 'List Drivers');
		/*

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
        */
        // dd(Auth::user()->id);
		if ($request->ajax()) {
			$users = ServiceProviderDriver::where(['service_provider_id'=>Auth::user()->id])->with('user:id,first_name,is_master,last_name,email,phone,status,name,country_code')->get();
			$data = $users->pluck('user')->flatten();
            if(isset($data[0]) && empty($data[0]))
            {
                $data = [];
            }
			// $data = User::select(['id', 'first_name', 'is_master', 'last_name', 'email', 'phone', 'status', 'name', 'country_code'])->where('user_type', 2)->where('service_provider_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
			// <a class="dropdown-item" href="' . url('admin/driver/edit', $row->id) . '">' . trans("admin.Edit") . '</a>
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function ($row) {
					$btn = '<div class="btn-group dropright">
								<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Action
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="' . url('admin/driver', $row->id) . '">' . trans("admin.View") . '</a>
									<a class="dropdown-item delete_record" data-id="' . $row->id . '">' . trans("admin.Delete") . '</a>
									<a class="dropdown-item logout_driver" data-id="' . $row->id . '">Logout</a>
                                </div>
                            </div>';
					return $btn;
				})->addColumn('master_driver', function ($row) {
					$status = ($row->is_master === 1) ? 'checked' : '';
					$btn = '<div class="switch">
                            <label>
                                <input type="checkbox" class="master_status" data-status="' . $row->is_master . '" data-id="' . $row->id . '" ' . $status . '><span class="lever" data-id="' . $row->id . '" ></span>
                            </label>
                        </div>';
					return $btn;
				})

				->addColumn('status', function ($row) {
					$status = ($row->status === 1) ? 'checked' : '';
					$btn = '<div class="switch">
                            <label>
                                <input type="checkbox" class="change_status" data-status="' . $row->status . '" data-id="' . $row->id . '" ' . $status . '><span class="lever" data-id="' . $row->id . '" ></span>
                            </label>
                        </div>';
					return $btn;
				})->addColumn('first_name', function ($row) {
					return ucfirst($row->first_name);
				})
				->addColumn('last_name', function ($row) {
					return ucfirst($row->last_name);
				})
				->addColumn('full_name', function ($row) {
					return ucfirst($row->first_name).' '.ucfirst($row->last_name);
				})
				->addColumn('phone', function ($row) {
					return (!empty($row->country_code) ? "+".$row->country_code."-":"").$row->phone;
				})
				->rawColumns(['action', 'status', 'master_driver', 'first_name', 'last_name'])
				->make(true);
		}
		return view('admin.drivers.index')->with($data);
	}

	 public function editDriver($id)
    {
		return redirect()->route('showDriver',$id);
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
		$rules = [
			// 'user_name' =>  'required|'.(!empty($haveUser->id) ? 'unique:users,user_name,'.$haveUser->id : ''),
			// 'email' => 'required|'.(!empty($haveUser->id) ? 'unique:users,email,'.$haveUser->id : ''),
			'image_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
			//'gender' => 'required|integer|between:1,2',
			//'dob' => 'required',
		];
		if (!empty($request->reset_password)) {
			$rules['password'] = 'required|min:6';
		}
		$request->validate($rules);
		$haveUser = User::where(['id' => $id, 'user_type' => 2])->first();

		$user = \App\User::where('user_type', 2)->where('id', '!=', $id)->where('phone', ltrim($request->phone, "0"))->first();
		if (!empty($user)) {
			return redirect()->route("users.drivers")->with('warning', trans('This phone number already exists!'));
		}
		$email_already_exist = User::where('id', '!=', $id)->where(['email' => $request->email])->withTrashed()->first();
		if (!empty($email_already_exist)) {
			return back()->with('warning', "This email address is already used by another user.");
		}
		$input = $request->all();
		if (!empty($request->phone)) {
			$input['phone'] = str_replace(' ', '', $request->phone);
			if (substr($input['phone'], 0, 1) == 0) {
				$input['phone'] = substr_replace($input['phone'], "", 0, 1);
			}
		}
		if ($request->hasFile('image_tmp') && $request->file('image_tmp')->isValid()) {

			$imageName = 'profile-image' . time() . '.' . $request->image_tmp->extension();
			if (!empty($haveUser->image)) {
				Storage::disk('public')->delete($haveUser->image);
			}
			$input['image'] = Storage::disk('public')->putFileAs(
				'user/' . $id,
				$request->image_tmp,
				$imageName
			);
		}
		unset($input['_method'], $input['_token'], $input['image_tmp']);

		unset($input['reset_password']);
		$input['password'] = Hash::make($request->input('password'));
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

	public function forgetPassword()
	{
		$breadcrumb = array('title' => 'Forget', 'action' => 'ForgetPassword');
		$data = [];
		$data = array_merge($breadcrumb, $data);
		return view('guest.auth.forget-password')->with($data);
	}

	public function doRegisterGuest(GuestRegisterRequest $request)
	{
		try {
			if ($request->isMethod('post')) {
				DB::beginTransaction();
				$input = $request->all();
				$input['password'] = Hash::make($request->input('password'));
				$input['user_type'] = 1;

				$phone_number = str_replace(' ', '', ltrim($request->phone, "0"));
				$input['phone'] = $phone_number;
				//$otp = rand(1000,9999);
				unset($input['_token']);
				unset($input['confirm_password']);

				$user = User::where('phone', $phone_number)->where('country_code', $request->country_code)->where('user_type', 1)->first();
				if ($user) {
					return redirect()->back()->withErrors(['message' => 'Mobile number already has been taken']);
				}
				$user = User::updateOrCreate($input);

				// $expiryMin = config('app.otp_expiry_minutes');
				// $SMSTemplate = SMSTemplate::find(3);
				// $body = str_replace('#OTP#',$otp,$SMSTemplate->english_content);//"Dear User, your Veldoo verification code is ".$otp.". Use this password to complete your booking";
				// if (app()->getLocale()!="en")
				// {
				// 	$body = str_replace('#OTP#',$otp,$SMSTemplate->german_content);
				// }
				// $this->sendSMS("+".$request->country_code, ltrim($request->phone, "0"), $body);
				// $endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');
				// \App\OtpVerification::create(
				// 	['phone'=> ltrim($request->phone, "0"),
				// 	'otp' => $otp,
				// 	'expiry'=>$endTime,
				// 	'country_code'=>$request->country_code
				// 	]
				// );

				DB::commit();
				return redirect()->route('booking_taxisteinemann')->with('success', __('Register successfully!'));
				//return redirect()->to(url('verify-otp?phone='.$request->phone.'&code='.$request->country_code));
			}
			return view('guest.register');
		} catch (\Exception $e) {
			DB::rollback();
			echo $e->getMessage();
			die;
			// something went wrong
		}
	}

	public function otpVerification(Request $request)
	{

		try {
			$rules = ['otp' => 'required'];
			$request->validate($rules);
			$input = $request->all();
			$now = Carbon::now();
			$haveOtp = \App\OtpVerification::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'otp' => $request->otp, 'device_type' => 'web'])->first();
			if (empty($haveOtp)) {
				return redirect()->back()->withErrors(['message' => 'Verification code is incorrect, please try again']);
			}
			if ($now->diffInMinutes($haveOtp->expiry) < 0) {
				return redirect()->back()->withErrors(['message' => 'Verification code has expired']);
			}
			$user = User::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'user_type' => 1])->first();
			if ($user) {
				$user->verify = 1;
				$user->save();
				//\App\OtpVerification::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'otp' => $request->otp])->delete();
				return redirect()->route('guest.login')->with('success', __('Register successfully!'));
			} else {
				return redirect()->back()->withErrors(['message' => 'No such number exists in our record']);
			}
		} catch (Exception $e) {
			return response()->json(['status' => 0, 'message' => $e->getMessage()]);
		}
	}


	public function verifyOtpGuest(Request $request)
	{
		$breadcrumb = array('title' => 'Home', 'action' => 'Register');
		$data = [];
		$data['phone'] = $request->phone;
		$data['code'] = $request->code;
		$data = array_merge($breadcrumb, $data);
		return view('admin.verify-otp')->with($data);
	}


	public function verify($email)
	{
		$breadcrumb = array('title' => 'Home', 'action' => 'Register');
		$data = [];
		$data['email'] = $email;
		$data = array_merge($breadcrumb, $data);
		return view('admin.verify')->with($data);
	}


	// public function verifyOtp(Request $request){
	// $rules = [
	// 			'otp' => 'required'
	// 		];
	// 		$request->validate($rules);
	// 		$input = $request->all();
	// 		$user=\App\User::where('email',$request->email)->first();
	// 		$otpVerification=\App\OtpVerification::where('country_code',$user->country_code)->where('phone',$user->phone)->where('otp',$request->otp)->first();
	// 		if(!empty($otpVerification)){
	// 			Auth::login($user);
	// 		return redirect()->route('users.dashboard');
	// 		}
	// }


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

	/**
     * Created By Anil Dogra
     * Created At 09-08-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object with registered user id
     * This function use to  create contacts subject
     */
    public function driver_change_status(Request $request){

        $status = ($request->status)?0:1;
           $updateUser = User::where('id',$request->user_id)->update(['is_master'=>$status]);

        if ($updateUser) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
        exit;
    }

    /**
     * Created By Anil Dogra
     * Created At 09-08-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object with registered user id
     * This function use to  create contacts subject
     */
    public function invoice_change_status(Request $request){

        $status = ($request->status)?0:1;
           $updateUser = User::where('id',$request->user_id)->update(['invoice_status'=>$status]);

        if ($updateUser) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
        exit;
    }

	public function make_driver_logout(Request $request)
	{
		try {
			DB::beginTransaction();
			User::where(['id' => $request->driver_id])->update(['availability' => 0]);
			DB::table('oauth_access_tokens')
			->where(['user_id' => $request->driver_id])
			->delete();
			DriverStayActiveNotification::where(['driver_id' => $request->driver_id])->delete();
			DriverChooseCar::where(['user_id' => $request->driver_id])->where(['logout' => 0])->update(['logout' => 1]);
			DB::commit();
			return response()->json(['status' => 1, 'message' => "Driver has successfully logged out."], 200);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['status' => 0, 'message' => $e->getMessage()]);
		}
	}

	public function checkDriverByPhone(Request $request)
	{
		DB::beginTransaction();
		try {
			$rules = [
				'phone' => 'required',
				'country_code' => 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}
			$driver = User::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'user_type' => 2])->first();
			if ($driver)
			{
				$checkDriverAdded = ServiceProviderDriver::where(['driver_id'=>$driver->id,'service_provider_id'=>Auth::user()->id])->first();
				if ($checkDriverAdded) {
					DB::commit();
					return response()->json(['status' => 2, 'message' => 'Driver already added'], $this->successCode);
				}
				else
				{
					DB::commit();
					return response()->json(['status' => 1, 'message' => 'Driver Found','driver'=>$driver], $this->successCode);
				}
			}
			else
			{
				DB::commit();
				return response()->json(['status' => 0, 'message' => 'Driver not found'], $this->successCode);
			}
		} catch (\Exception $e) {
			DB::rollback();
			// something went wrong
			return response()->json(['status'=>2,'message' => $e->getMessage()], $this->warningCode);
		}
	}

	public function addDriverServiceProvider($id)
	{
		DB::beginTransaction();
		try {
			$checkDriverAdded = ServiceProviderDriver::where(['driver_id'=>$id,'service_provider_id'=>Auth::user()->id])->first();
			if (!$checkDriverAdded) {
				$driver =  new ServiceProviderDriver();
				$driver->fill(['driver_id'=>$id,'service_provider_id'=>Auth::user()->id]);
				$driver->save();
			}

			DB::commit();
			return back()->with('success', 'Driver added!');

		} catch (\Exception $e) {
			DB::rollback();
			// something went wrong
			return back()->with('error', $exception->getMessage());
		}
	}
}
