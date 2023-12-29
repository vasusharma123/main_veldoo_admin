<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Price;
use DataTables;
use Illuminate\Support\Facades\Auth;

class VehicleTypeController extends Controller
{

     public function __construct() {
        $this->table = 'prices';
        $this->folder = 'vehicle_type';
        view()->share('route', 'vehicle-type');
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
        $data = array();
        $data = array('title' => 'Vehicle', 'action' => 'List Vehicles');

        $records = Price::select('id', 'car_type', 'car_image', 'price_per_km', 'basic_fee', 'seating_capacity', 'alert_time', 'status')->where(['service_provider_id' => Auth::user()->id]);
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			
			#$price = Price::deleteData($request->input('id'));
			#$price->delete();
			Price::where(['id' => $request->input('id')])->limit(1)->delete();
		}
		
		if(!empty($request->input('text'))){
			$text = $request->input('text');
			$service_provider_id = Auth::user()->id;
			$records->whereRaw("(car_type LIKE '%$text%' OR basic_fee LIKE '%$text%' OR price_per_km LIKE '%$text%' OR seating_capacity LIKE '%$text%' OR alert_time LIKE '%$text%') AND service_provider_id=$service_provider_id");
		}
		
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}
		
		#$this->limit = 1;
		
		$data['records'] = $records->where(['service_provider_id'=>Auth::user()->id, 'deleted_at' => null])->paginate($this->limit);
		
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		
        if ($request->ajax()) {
            return view("admin.vehicle_type.index_element")->with($data);
        }
		
		return view('admin.vehicle_type.index')->with($data);
    }

    /**
     * Created By Anil Dogra
     * Created At 09-08-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object with registered user id
     * This function use to  create contacts subject
     */
    public function change_status(Request $request){
        DB::table('prices')->where('service_provider_id',Auth::user()->id)->update(['status'=>0]);
        $status = ($request->status)?0:1;
        $updateUser = Price::where('id',$request->vtype_id)->where('service_provider_id',Auth::user()->id)->update(['status'=>$status]);
       
        if ($updateUser) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
        exit;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $breadcrumb = array('title'=>'Vehicle Type','action'=>'Add Vehicle Type');
        $data = [];
        $data['car_types'] =\App\Category::where('status',1)->get();
        $data = array_merge($breadcrumb,$data);
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
			'car_type'=>'required',
			'basic_fee'=>'required',
			'price_per_km'=>'required',
			// 'commission'=>'required',
			'seating_capacity'=>'required',
			// 'pick_time_from'=>'required',
			//'pick_time_to'=>'required'
         ];

        $request->validate($rules);
        $input = $request->all();
        $input['service_provider_id'] = Auth::user()->id;
        unset($input['_method'],$input['_token'],$input['submit']);
		//  unset($input['basic_fee']);
        $result=\App\Price::create($input);
        if($request->hasFile('car_image') && $request->file('car_image')->isValid()){

            $imageName = 'image-'.time().'.'.$request->car_image->extension();
            $input['car_image'] = Storage::disk('public')->putFileAs(
                'car_type/'.$result->id, $request->car_image, $imageName
            );
            \App\Price::where('id', $result->id)->update($input);
        }

         return back()->with('success', __('Record created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breadcrumb = array('title'=>trans('admin.Vehicle Type'),'action'=>trans('admin.Vehicle Type Detail'));
        $data = [];
        $where = array('id' => $id,'service_provider_id'=>Auth::user()->id);
        $record = \App\Price::where($where)->first();

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
        $breadcrumb = array('title'=>'Vehicle Type','action'=>'Edit Vehicle Type');
        $data = [];
        $where = array('id' => $id);
        $record = \App\Price::where($where)->first();
        if(empty($record)){
            return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
        }

        $data['record'] = $record;
        $data['car_types'] =\App\Category::where('status',1)->get();
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
        $vehicle = \App\Price::where(['id'=>$id])->first();;

        $rules = [
			'car_type'=>'required',
			'basic_fee'=>'required',
			'price_per_km'=>'required',
			#'price_per_min_mile'=>'required',
			#'commission'=>'required',
			'seating_capacity'=>'required',
			#'pick_time_from'=>'required',
			#'pick_time_to'=>'required'
		];

		$request->validate($rules);
        $input = $request->all();
        unset($input['_method'], $input['_token'], $input['submit']);

        if($request->hasFile('car_image') && $request->file('car_image')->isValid()){

            $imageName = 'image-'.time().'.'.$request->car_image->extension();
            if(!empty($vehicle->car_image)){
                Storage::disk('public')->delete($vehicle->car_image);
            }
            $input['car_image'] = Storage::disk('public')->putFileAs(
                'car_type/'.$id, $request->car_image, $imageName
            );
        }
        \App\Price::where('id', $id)->update($input);
         return back()->with('success', __('Record updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $price = Price::deleteData($request->type_id);
        // $price->delete();


        echo json_encode(true);
        exit();
    }
}
