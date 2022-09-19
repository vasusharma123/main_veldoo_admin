<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\User;
//use App\UserData;
use App\UserData;
use App\Category;
use App\Setting;
use App\PaymentMethod;
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

class PaymentManagementController extends Controller
{
	protected $layout = 'layouts.admin';

	public function __construct()
	{
		$this->table = 'payment_methods';
		$this->folder = 'payment_method';
		view()->share('route', 'payment-method');
		$this->limit = config('app.record_limit_web');
	}

	public function guest_message()
	{
		return view('admin.guest_message');
	}



	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$breadcrumb = array('title' => 'Payment Method', 'action' => 'List Payment Method');
		$data = [];

		if ($request->has('status') && !empty($request->input('id'))) {
			$status = ($request->input('status') ? 0 : 1);
			\App\PaymentMethod::where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}
		if ($request->has('type') && $request->input('type') == 'delete' && !empty($request->input('id'))) {
			\App\PaymentMethod::where([['id', $request->input('id')]])->delete();
		}
		$payment_methods = \App\PaymentMethod::query();
		if (!empty($request->input('text'))) {
			$payment_methods->where('name', 'like', '%' . $request->input('text') . '%');
		}
		if (!empty($request->input('orderby')) && !empty($request->input('order'))) {
			$payment_methods->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$payment_methods->orderBy('id', 'desc');
		}

		$data['payment_methods'] = $payment_methods->paginate($this->limit);
		$data['i'] = (($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] = $request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb, $data);
		if ($request->ajax()) {
			return view('admin.payment_method.index_element')->with($data);
		}
		return view('admin.payment_method.index')->with($data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$breadcrumb = array('title' => 'Payment Method', 'action' => 'Add Payment Method');
		$data = [];
		$data['record'] = \App\PaymentMethod::first();
		$data = array_merge($breadcrumb, $data);
		return view('admin.payment_method.create')->with($data);
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
			'name' => 'required|unique:payment_methods,name',
		];
		$request->validate($rules);
		//$request=$request()->except(['_token']);
		$data = [];
		$data['record'] = \App\PaymentMethod::create(['name' => $request->name, 'status' => 1]);
		return Redirect::back()->with('success', __('Payment method added successfully'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$breadcrumb = array('title' => trans('admin.User'), 'action' => trans('admin.User Detail'));
		$data = [];
		$where = array('id' => $id);
		$record = User::where($where)->first();

		if (empty($record)) {
			return redirect()->route("{$this->folder}.index")->with('warning', trans('admin.Record not found!'));
		}
		$data['status'] = array(1 => 'Active', 0 => 'In-active');
		$data['record'] = $record;
		$data = array_merge($breadcrumb, $data);

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
		$breadcrumb = array('title' => 'Payment Method', 'action' => 'Edit Payment Method');
		$data = [];
		$where = array('id' => $id);
		$record = \App\PaymentMethod::where($where)->first();
		if (empty($record)) {
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}

		$data['record'] = $record;
		$data = array_merge($breadcrumb, $data);
		return view("admin.payment_method.edit")->with($data);
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
		$query = User::where(['id' => $id]);
		$haveUser = $query->first();
		$rules = [
			'name' => 'required|unique:payment_methods,name,' . $id,
		];
		$request->validate($rules);
		\App\PaymentMethod::where('id', $id)->update(['name' => $request->name, 'status' => 1]);

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
