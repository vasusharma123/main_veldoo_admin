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
	public function __construct()
	{
		$this->table = 'categories';
		$this->folder = 'ride_management';
		view()->share('route', 'ride-management');
		$this->limit = Config::get('limit');
	}
	public function index(Request $request)
	{
		$breadcrumb = array('title' => 'Category', 'action' => 'List Categories');
		$data = [];
		$records = DB::table($this->table);
		if ($request->has('status') && !empty($request->input('id'))) {
			$status = ($request->input('status') ? 0 : 1);
			DB::table($this->table)->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}
		if ($request->has('type') && $request->input('type') == 'delete' && !empty($request->input('id'))) {
			\App\Category::find($request->input('id'))->delete();
		}
		if (!empty($request->input('text'))) {
			$records->where('name', 'like', '%' . $request->input('text') . '%');
		}
		if (!empty($request->input('orderby')) && !empty($request->input('order'))) {
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}

		$data['array'] = $records->paginate($this->limit);
		$data['i'] = (($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] = $request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb, $data);
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
	public function create(Request $request)
	{
		$breadcrumb = array('title' => 'Category', 'action' => 'Add Category');

		$data = [];
		$data = array_merge($breadcrumb, $data);
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
	public function show($id, Request $request)
	{
		$breadcrumb = array('title' => 'Category', 'action' => 'Category Detail');
		$data = [];
		$where = array('id' => $id);
		$record = Category::where($where)->first();
		if (empty($record)) {
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
		$records = \App\Ride::where('car_type', $record->id);
		if (!empty($request->day) && $request->day == "day") {
			$records = $records->where('created_at', '>=', Carbon::today());
		} elseif (!empty($request->day) && $request->day == "week") {
			$records = $records->where('created_at', '>=', Carbon::now()->subDays(7));
		} elseif (!empty($request->day) && $request->day == "month") {
			$records = $records->where('created_at', '>=', Carbon::now()->subDays(30));
		}
		$data['rides'] = $records->paginate($this->limit);
		$data['i'] = (($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] = $request->input('orderby');
		$data['order'] = $request->input('order');
		$data['status'] = array(1 => 'Active', 0 => 'In-active');
		$data['record'] = $record;
		$data = array_merge($breadcrumb, $data);
		if ($request->ajax()) {
			return view("admin.{$this->folder}.category_ride")->with($data);
			//return view("admin.{$this->folder}.show")->with($data);
		} else {
			return view("admin.{$this->folder}.show")->with($data);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Posts  $posts
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$breadcrumb = array('title' => 'Category', 'action' => 'Edit Category');
		$data = [];
		$where = array('id' => $id);
		$record = Category::where($where)->first();
		if (empty($record)) {
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
		$data['record'] = $record;
		$data = array_merge($breadcrumb, $data);
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


	public function bookRide(Request $request)
	{
		$user = Auth::user();
		$latitude=$user->current_lat;
		$longitude=$user->current_lng;

		$users=DB::table("users");

		$users=$users->select("*", DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                                * cos(radians(current_lat)) * cos(radians(current_lng) - radians(" . $longitude . "))
                                + sin(radians(" . $latitude . ")) * sin(radians(current_lat))) AS distance"));
		$users=$users->having('distance', '<', 20)->where('user_type', 2);
		$users=$users->orderBy('distance', 'asc');

		$users=$users->get();
		//	dd($users);
	}
}
