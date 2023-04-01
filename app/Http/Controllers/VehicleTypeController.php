<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Price;
use DataTables;
use Auth;

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

        if ($request->ajax()) {

            $data = Price::select(['id', 'car_type', 'car_image', 'price_per_km', 'basic_fee', 'seating_capacity', 'alert_time', 'status'])->where('service_provider_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
            // print_r($data);die;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group dropright">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">
                              
                                <a class="dropdown-item" href="' . route('vehicle-type.show', $row->id) . '">' . trans("admin.View") . '</a>
                                <a class="dropdown-item" href="' . route('vehicle-type.edit', $row->id) . '">' . trans("admin.Edit") . '</a>
                                <a class="dropdown-item delete_record" data-id="' . $row->id . '">' . trans("admin.Delete") . '</a>
                            </div>
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
                })->addColumn('car_type', function ($row) {
                    return ucfirst($row->car_type);
                })
                ->rawColumns(['action', 'status', 'car_type'])
                ->make(true);
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
        unset($input['_method'],$input['_token']);
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
