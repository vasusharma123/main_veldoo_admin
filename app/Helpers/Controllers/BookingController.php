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
use App\Exports\RideExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Ride;
use App\Stopover;

class BookingController extends Controller
{
	public function __construct() {
		$this->table = 'rides';
		$this->folder = 'booking';
		view()->share('route', 'bookings');
		$this->limit = Config::get('limit');
   }
    public function index(Request $request)
    {
		// print_r($request->input()); 
		if(Auth::user()->hasRole(['Administrator'])){
	$breadcrumb = array('title'=>'Bookings','action'=>'List Bookings');
		$data = [];
		$records =\App\Ride::select('rides.*','users.first_name','users.last_name','categories.name','companies.name as company')->leftjoin('users','users.id','=','rides.user_id')->leftjoin('categories','rides.car_type','=','categories.id')->leftjoin('companies','rides.company_id','=','companies.id');
		// print_r($records); die;
		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table($this->table)->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id'))){
			\App\Topic::find($request->input('id'))->delete();
		}
		if(!empty($request->input('text'))){
			$records->where('users.first_name', 'like', '%'.$request->input('text').'%')->orWhere('pickup_address', 'like', '%'.$request->input('text').'%')->orWhere('dest_address', 'like', '%'.$request->input('text').'%')->orWhere('price', 'like', '%'.$request->input('text').'%')->orWhere('categories.name', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
			
		} else {
			$records->orderBy('rides.id', 'desc');
			
		}
		if(!empty($request->from_date)&& !empty($request->to_date)){
			$records=\App\Ride::where('created_at','>=',$request->from_date)->where('created_at','<=',$request->to_date);
		}
		if($request->export_type=="excel"){
			$data=['from_date'=>$request->from_date,'to_date'=>$request->to_date];
			$dataModel=new RideExport($data);
			 return Excel::download($dataModel, 'totalBooking.xlsx');
			 exit();
		}
		
		$data['array'] = $records->paginate($this->limit);
		//dd($data); die;
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view("admin.{$this->folder}.index_element")->with($data);
        }
	    return view("admin.{$this->folder}.index")->with($data);
	}else{
		abort(response()->json(['message' => 'Ooops!.User does not have any of the necessary access rights.'], 402));	
		}
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
			if(Auth::user()->hasRole(['Administrator'])){
	    $breadcrumb = array('title'=>'Category','action'=>'Add Category');
		
		$data = [];
		$data = array_merge($breadcrumb,$data);
		if ($request->ajax()) {
			return rand();
		}
	    return view("admin.{$this->folder}.create")->with($data);
		}else{
		abort(response()->json(['message' => 'Ooops!.User does not have any of the necessary access rights.'], 402));	
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		if(Auth::user()->hasRole(['Administrator'])){
		$rules = [
			'name' => 'required',
		];
		$request->validate($rules);
		Category::create($request->all());
		return back()->with('success', __('Record created!'));
		}else{
		abort(response()->json(['message' => 'Ooops!.User does not have any of the necessary access rights.'], 402));	
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
		$breadcrumb = array('title'=>'Booking','action'=>'Booking Detail');
		$data = [];
        $where = array('rides.id' => $id);
		$record = \App\Ride::select('rides.*','users.first_name','users.last_name','categories.name')->leftjoin('users','users.id','=','rides.user_id')->leftjoin('categories','rides.car_type','=','categories.id')->where($where)->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
		$stopovers = Stopover::query()->where([['ride_id', '=', $id]])->orderBy('id', 'asc')->get()->toArray();
		$data['stopovers'] = $stopovers;
		$data = array_merge($breadcrumb,$data);
	    return view("admin.{$this->folder}.show")->with($data);
		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {	
		if(Auth::user()->hasRole(['Administrator'])){
	    $breadcrumb = array('title'=>'Category','action'=>'Edit Category');
		$data = [];
        $where = array('id' => $id);
        $record = Category::where($where)->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("admin.{$this->folder}.edit")->with($data);
		}else{
		abort(response()->json(['message' => 'Ooops!.User does not have any of the necessary access rights.'], 402));	
		}
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
		if(Auth::user()->hasRole(['Administrator'])){
		$rules = [
			'name' => 'required',
		];
		$request->validate($rules);
		$request = $request->except(['_method', '_token']);
		Category::where('id', $id)->update($request);
		return back()->with('success', __('Record updated!'));
		}else{
		abort(response()->json(['message' => 'Ooops!.User does not have any of the necessary access rights.'], 402));	
		}
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $posts)
    {
        //
    }
	
	public function scheduledRide(Request $request){
		$breadcrumb = array('title'=>'Scheduled Rides','action'=>'List Scheduled Rides');
		$data = [];
		$whereRaw = '';
		$records =\App\Ride::select('rides.*','users.first_name','users.last_name','categories.name')->leftjoin('users','users.id','=','rides.user_id')->leftjoin('categories','rides.car_type','=','categories.id');
		
		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table($this->table)->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id'))){
			\App\Topic::find($request->input('id'))->delete();
		}
		
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('rides.id', 'desc');
		}
		if(!empty($request->from_date)&& !empty($request->to_date)){
			$records=\App\Ride::where('created_at','>=',$request->from_date)->where('created_at','<=',$request->to_date);
		}
		//$data['array'] = $records->where('schedule_ride',1)->where('ride_time','>=',Carbon::now()->format("Y-m-d"))->paginate($this->limit);
		$data['array'] = $records->where('ride_time','>=',date('Y-m-d H:i:s'))->paginate($this->limit);
		if(!empty($request->input('text'))){
			$records->where('users.first_name', 'like', '%'.$request->input('text').'%')->orWhere('pickup_address', 'like', '%'.$request->input('text').'%')->orWhere('dest_address', 'like', '%'.$request->input('text').'%')->orWhere('price', 'like', '%'.$request->input('text').'%')->orWhere('categories.name', 'like', '%'.$request->input('text').'%');
		}
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view("admin.{$this->folder}.schedule_ride_element")->with($data);
        }
		 return view("admin.{$this->folder}.scheduled_ride")->with($data);
	}
	
	  public function scheduledRideShow($id,Request $request)
    {
		$breadcrumb = array('title'=>'Scheduled Ride','action'=>'Scheduled Ride Detail');
		$data = [];
        $where = array('rides.id' => $id);
        $record = \App\Ride::select('rides.*','users.first_name','users.last_name','categories.name')->leftjoin('users','users.id','=','rides.user_id')->leftjoin('categories','rides.car_type','=','categories.id')->where($where)->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("admin.{$this->folder}.scheduled_ride_show")->with($data);
		
    }
  
  public function booking(Request $request){
	   $data = [];
	  $records =\App\Ride::select('rides.*','users.first_name','users.last_name','categories.name')->leftjoin('users','users.id','=','rides.user_id')->leftjoin('categories','rides.car_type','=','categories.id');
	  if($request->type=="past-bookings"){
		   $breadcrumb = array('title'=>'Past Bookings','action'=>'List Past Bookings');
		  $records=$records->whereDate('rides.ride_time','<',Carbon::today());
		}elseif($request->type=="current-bookings"){
			 $breadcrumb = array('title'=>'Current Bookings','action'=>'List Current Bookings');
			$records=$records->whereDate('rides.ride_time','=',Carbon::today());
		}elseif($request->type=="upcoming-bookings"){
			 $breadcrumb = array('title'=>'Upcoming Bookings','action'=>'List Upcoming Bookings');
			$records=$records->whereDate('rides.ride_time','>',Carbon::today());
		}
		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table($this->table)->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id'))){
			\App\Topic::find($request->input('id'))->delete();
		}
		if(!empty($request->input('text'))){
			$records->where('users.first_name', 'like', '%'.$request->input('text').'%')->orWhere('pickup_address', 'like', '%'.$request->input('text').'%')->orWhere('dest_address', 'like', '%'.$request->input('text').'%')->orWhere('price', 'like', '%'.$request->input('text').'%')->orWhere('categories.name', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('rides.id', 'desc');
		}
		if(!empty($request->from_date)&& !empty($request->to_date)){
			$records=\App\Ride::where('created_at','>=',$request->from_date)->where('created_at','<=',$request->to_date);
			
		}
		$data['array'] = $records->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view("admin.{$this->folder}.index_element")->with($data);
        }
	    return view("admin.{$this->folder}.bookings")->with($data);
  }


  public function bookingUserDetail(Request $request,$id){
  	    $breadcrumb = array('title'=>'User','action'=>'User Detail');
		$data = [];
        $where = array('rides.id' => $id);
		$record = \App\Ride::select('users.*')->leftjoin('users','users.id','=','rides.user_id')->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
		$data['id']=$id;
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("company.bookings.user_detail")->with($data);

  }
  

  public function pastBooking(Request $request){
  	$breadcrumb = array('title'=>'Past Bookings','action'=>'List Past Bookings');
		$data = [];
		$userId=Auth::user()->id;
		$records =\App\Ride::select('rides.*','users.first_name','users.last_name','categories.name')
		->leftjoin('users','users.id','=','rides.user_id')->leftjoin('categories','rides.car_type','=','categories.id')->where('company_id',$userId)->whereDate('rides.ride_time','<',Carbon::today());
		
		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table($this->table)->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}

		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id'))){
			\App\Topic::find($request->input('id'))->delete();
		}

		if(!empty($request->input('text'))){
			$records->where('users.first_name', 'like', '%'.$request->input('text').'%')->orWhere('pickup_address', 'like', '%'.$request->input('text').'%')->orWhere('dest_address', 'like', '%'.$request->input('text').'%')->orWhere('price', 'like', '%'.$request->input('text').'%')->orWhere('categories.name', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('rides.id', 'desc');
		}
		if(!empty($request->from_date)&& !empty($request->to_date)){
			$records=\App\Ride::where('created_at','>=',$request->from_date)->where('created_at','<=',$request->to_date);
		}
		$data['array'] = $records->paginate($this->limit);
		
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view("company.bookings.index_element")->with($data);
        }
	    return view("company.bookings.index")->with($data);

  }

  public function upcomingBooking(Request $request){

	$breadcrumb = array('title'=>'Upcoming Bookings','action'=>'List Upcoming Bookings');
		$data = [];
		$userId=Auth::user()->id;
		$records =\App\Ride::select('rides.*','users.first_name','users.last_name','categories.name')
		->leftJoin('users','users.id','=','rides.user_id')->leftJoin('categories','rides.car_type','=','categories.id')->where('company_id',$userId)->whereDate('rides.ride_time','>=',date('Y-m-d'));
		
		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table($this->table)->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}

		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id'))){
			\App\Topic::find($request->input('id'))->delete();
		}

		if(!empty($request->input('text'))){
			$records->where('users.first_name', 'like', '%'.$request->input('text').'%')->orWhere('pickup_address', 'like', '%'.$request->input('text').'%')->orWhere('dest_address', 'like', '%'.$request->input('text').'%')->orWhere('price', 'like', '%'.$request->input('text').'%')->orWhere('categories.name', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('rides.id', 'desc');
		}
		if(!empty($request->from_date)&& !empty($request->to_date)){
			$records=\App\Ride::where('created_at','>=',$request->from_date)->where('created_at','<=',$request->to_date);
		}
		$data['array'] = $records->paginate($this->limit);
		
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view("company.bookings.booking_element")->with($data);
        }
	    return view("company.bookings.booking")->with($data);
  }

 public function currentBooking(Request $request){

	$breadcrumb = array('title'=>'Current Bookings','action'=>'List Current Bookings');
		$data = [];
		$userId=Auth::user()->id;
		$records =\App\Ride::select('rides.*','users.first_name','users.last_name','categories.name')
		->leftjoin('users','users.id','=','rides.user_id')->leftjoin('categories','rides.car_type','=','categories.id')->where('company_id',$userId)->whereDate('rides.ride_time','=',Carbon::today());
			
		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table($this->table)->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}

		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id'))){
			\App\Topic::find($request->input('id'))->delete();
		}

		if(!empty($request->input('text'))){
			$records->where('users.first_name', 'like', '%'.$request->input('text').'%')->orWhere('pickup_address', 'like', '%'.$request->input('text').'%')->orWhere('dest_address', 'like', '%'.$request->input('text').'%')->orWhere('price', 'like', '%'.$request->input('text').'%')->orWhere('categories.name', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('rides.id', 'desc');
		}
		if(!empty($request->from_date)&& !empty($request->to_date)){
			$records=\App\Ride::where('created_at','>=',$request->from_date)->where('created_at','<=',$request->to_date);
		}
		$data['array'] = $records->paginate($this->limit);
		
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view("company.bookings.booking_element")->with($data);
        }
	    return view("company.bookings.booking")->with($data);
  }


	public function pastBookingDetail($id){
		$breadcrumb = array('title'=>'Booking','action'=>'Booking Detail');
		$data = [];
        $where = array('rides.id' => $id);
		$record = \App\Ride::select('rides.*','users.first_name','users.last_name','categories.name')->leftjoin('users','users.id','=','rides.user_id')->leftjoin('categories','rides.car_type','=','categories.id')->where($where)->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("company.bookings.past_booking_detail")->with($data);
	}
	
	public function upcomingBookingDetail($id){
		$breadcrumb = array('title'=>'Booking','action'=>'Booking Detail');
		$data = [];
        $where = array('rides.id' => $id);
		$record = \App\Ride::select('rides.*','users.first_name','users.last_name','categories.name')->leftjoin('users','users.id','=','rides.user_id')->leftjoin('categories','rides.car_type','=','categories.id')->where($where)->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("company.bookings.upcoming_booking_detail")->with($data);
	}
	
	  public function home(Request $request){
		$breadcrumb = array('title'=>'Home','action'=>'Home');
		$data = [];
		$data['drivers']=\App\User::where('user_type',2)->get();
		$data['customers']=\App\User::where('user_type',1)->get();
		$data['companies']=\App\User::where('user_type',4)->get();
		$data = array_merge($breadcrumb,$data);
	    return view('company.home')->with($data);
	}
	
	public function rideCreate(Request $request){
		$rules = [
			'ride_type' => 'required',
			'pickup_address' => 'required',
			'dest_address' => 'required',
			'additional_notes' => 'required',
			'driver' => 'required',
			'schedule_time'=>'required',
			'customer'=>'required',
			'company'=>'required',
		];
		
		$request->validate($rules);
		$input=$request->all();
		$input['company_id']=Auth::user()->id;
		$input['driver_id']=$request->driver;
		$input['user_id']=$request->customer;
		$test=Ride::create($input);
		return back()->with('success', __('Record created!'));
	}
	
	public function bookRide(Request $request){
		$currentUser=Auth::user();
		$users=DB::table("users")
            ->select("users.*"
                ,DB::raw("6371 * acos(cos(radians(" . $currentUser->current_lat . ")) 
                * cos(radians(users.current_lat)) 
                * cos(radians(users.current_lng) - radians(" . $currentUser->current_lng . ")) 
                + sin(radians(" .$currentUser->current_lat. ")) 
                * sin(radians(users.current_lat))) AS distance"))
				//->having('distance', '<', 1000)
                ->groupBy("users.id")->orderBy('distance','ASC')
                ->get();
 
		//dd($users);
	}
	
	public function exportExcel(Request $request,$id=''){
		$data=['id'=>$id];
		$dataModel=new RideExport($data);
		 return Excel::download($dataModel, 'totalBooking.xlsx');
			 exit();
		
	}

	public function userDetail(Request $request,$id){
		//dd($id);
	$breadcrumb = array('title'=>'User','action'=>'User Detail');
		$data = [];
        $where = array('rides.id' => $id);
		$record = \App\Ride::where('id',$id)->first();
		//dd($record);
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
		$data['id']=$id;
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("admin.booking.user")->with($data);

	}
}
