<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $breadcrumb = array('title'=>'Vehicle','action'=>'List Vehicles');
        $data = [];


        if($request->has('status') && !empty($request->input('id')) ){
            $vehicleType=\App\Price::where('status',1)->first();
            if(!empty($vehicleType)){
            \App\Price::where('id',$vehicleType->id)->update(['status'=>0]);
        }
            $status = ($request->input('status')?0:1);
            DB::table('prices')->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
        }
        if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
            DB::table($this->table)->where([['id', $request->input('id')]])->delete();
        }
        $vehicles =\App\Price::query();
        if(!empty($request->input('text'))){
            $vehicles->where('price_per_km', 'like', '%'.$request->input('text').'%')->orWhere('seating_capacity', 'like', '%'.$request->input('text').'%');
        }
        if(!empty($request->input('orderby')) && !empty($request->input('order'))){
            $vehicles->orderBy($request->input('orderby'), $request->input('order'));
        } else {
            $vehicles->orderBy('id', 'desc');
        }
        
        $data['vehicleTypes'] = $vehicles->paginate($this->limit);
        $data['i'] =(($request->input('page', 1) - 1) * $this->limit);
        $data['orderby'] =$request->input('orderby');
        $data['order'] = $request->input('order');
        $data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('admin.vehicle_type.index_element')->with($data);
        }
        return view('admin.vehicle_type.index')->with($data);
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
        unset($input['_method'],$input['_token']);
      //  unset($input['basic_fee']);
		$result=\App\Price::create($input);
		if($request->hasFile('car_image') && $request->file('car_image')->isValid()){
			
			$imageName = 'profile-image.'.$request->car_image->extension();
			if(!empty($haveUser->car_image)){
				Storage::disk('public')->delete($vehicle->car_image);
			}
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
        $where = array('id' => $id);
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
         // 'price_per_min_mile'=>'required',
         // 'commission'=>'required',
          'seating_capacity'=>'required',
        //  'pick_time_from'=>'required',
         // 'pick_time_to'=>'required'
         ];
        
        $request->validate($rules);
        $input = $request->all();
        unset($input['_method'],$input['_token']);
		
		if($request->hasFile('car_image') && $request->file('car_image')->isValid()){
			
			$imageName = 'profile-image.'.$request->car_image->extension();
			if(!empty($haveUser->car_image)){
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
    public function destroy($id)
    {
        //
    }
}
