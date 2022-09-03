<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
	
		public function __construct() {
		$this->table = 'vouchers';
		$this->folder = 'voucher';
		view()->share('route', 'voucher');
		$this->limit = config('app.record_limit_web');
		$this->successCode = 200;
		$this->errorCode = 401;
		$this->warningCode = 500;
	}
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $breadcrumb = array('title'=>'Vouchers and Offers','action'=>'List Vouchers and Offers');
		$data = [];
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			DB::table($this->table)->where([['id', $request->input('id')]])->delete();
		}
		$vouchers =\App\Voucher::select('vouchers.*','users.first_name','users.last_name')->join('users','users.id','=','vouchers.user_id');
		if(!empty($request->input('text'))){
			$vouchers->where('first_name', 'like', '%'.$request->input('text').'%')
			->orWhere('last_name', 'like', '%'.$request->input('text').'%')
			->orWhere('title', 'like', '%'.$request->input('text').'%')
			->orWhere('message', 'like', '%'.$request->input('text').'%')
			->orWhere('mileage', 'like', '%'.$request->input('text').'%')
			->orWhere('start_date', 'like', '%'.$request->input('text').'%')
			->orWhere('end_date', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$vouchers->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$vouchers->orderBy('id', 'desc');
		}
		
		$data['vouchers'] = $vouchers->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('admin.voucher.index_element')->with($data);
        }
	    return view('admin.voucher.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $breadcrumb = array('title'=>'Voucher','action'=>'Add Voucher and Offers');
		
		$data = [];
		$data['users']=\App\User::where('user_type',1)->get();
		$data = array_merge($breadcrumb,$data);
	    return view('admin.voucher.create')->with($data);
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
			'user'=>'required',
			'title'=>'required',
			'message'=>'required',
			'mileage'=>'required',
			'start_date'=>'required',
			'end_date'=>'required',
		];
		$request->validate($rules);
		$input=$request->all();
		$input['user_id']=$request->user;
		$voucher  = \App\Voucher::create($input);
		return back()->with('success', 'Record created!');
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $breadcrumb = array('title'=>trans('admin.Voucher'),'action'=>trans('admin.Voucher Detail'));
		$data = [];
        $record =\App\Voucher::select('vouchers.*')->where('id',$id)->first();

		if(empty($record)){
			return redirect()->route("vouchers-offers.index")->with('warning', trans('admin.Record not found!'));
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
        //
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
        //
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
