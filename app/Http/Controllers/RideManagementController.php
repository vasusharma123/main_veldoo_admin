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
use App\Ride;

class RideManagementController extends Controller
{
	public function __construct() {
		$this->table = 'rides';
		$this->folder = 'ride_management';
		view()->share('route', 'ride-management');
		$this->limit = Config::get('limit');
   }
   
    public function index(Request $request)
    {
	    $breadcrumb = array('title'=>'Ride','action'=>'List Rides');
		$data = [];
		$records =Ride::select('rides.*','users.first_name AS rider_first_name','users.last_name AS rider_last_name','d_user.first_name AS driver_first_name','d_user.last_name AS driver_last_name')
		->leftJoin('users','users.id','=','rides.user_id')->leftJoin('users AS d_user','rides.driver_id','=','d_user.id');
		
		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			\App\Ride::where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			\App\Ride::find($request->input('id'))->delete();
		}
		
		if(!empty($request->input('text'))){
			$records->where('users.first_name', 'like', '%'.$request->input('text').'%')
			->orWhere('users.last_name', 'like', '%'.$request->input('text').'%')
			->orWhere('pickup_address', 'like', '%'.$request->input('text').'%')
			 ->orWhere('dest_address', 'like', '%'.$request->input('text').'%');
		}
		
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}
		
		$data['array'] = $records->paginate($this->limit);
		
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view("admin.{$this->folder}.index_element")->with($data);
        }
	    return view("admin.{$this->folder}.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
	    $breadcrumb = array('title'=>'Category','action'=>'Add Category');
		
		$data = [];
		$data = array_merge($breadcrumb,$data);
		if ($request->ajax()) {
			return rand();
		}
	    return view("admin.{$this->folder}.create")->with($data);
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
			'name' => 'required',
		];
		$request->validate($rules);
		Category::create($request->all());
		return back()->with('success', __('Record created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {

	   $breadcrumb = array('title'=>'Ride','action'=>'Ride Detail');
		$data = [];
        $where = array('id' => $id);
        $record = Ride::where($where)->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
	
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
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
			'name' => 'required',
		];
		$request->validate($rules);
		$request = $request->except(['_method', '_token']);
		Category::where('id', $id)->update($request);
		return back()->with('success', __('Record updated!'));
		// return redirect()->route('posts.index')->with('success',__('Record updated!'));
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
	
	
  
}
