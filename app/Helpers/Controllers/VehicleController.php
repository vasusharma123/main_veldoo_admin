<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use File;

class VehicleController extends Controller
{
  


   public function __construct() {
        $this->table = 'vehicles';
        $this->folder = 'vehicle';
        view()->share('route', 'vehicle');
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


       /* if($request->has('status') && !empty($request->input('id')) ){
            $status = ($request->input('status')?0:1);
            DB::table('vehicles')->where([['id', $request->input('id')],['user_type', 1]])->limit(1)->update(array('status' => $status));
        }*/
        if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			$driverChooseCar=\App\DriverChooseCar::where('car_id',$request->input('id'))->first();
			if(!empty($driverChooseCar)){
				 return response()->json(['message'=>'warning']);
			}
            DB::table($this->table)->where([['id', $request->input('id')]])->delete();
        }
        $vehicles = \App\Vehicle::query();
        //$users->where('user_type', '=', 1);
        if(!empty($request->input('text'))){
            $vehicles->where('year', 'like', '%'.$request->input('text').'%')->orWhere('model', 'like', '%'.$request->input('text').'%')->orWhere('color', 'like', '%'.$request->input('text').'%');
        }
        if(!empty($request->input('orderby')) && !empty($request->input('order'))){
            $vehicles->orderBy($request->input('orderby'), $request->input('order'));
        } else {
            $vehicles->orderBy('id', 'desc');
        }
        
        $data['vehicles'] = $vehicles->paginate($this->limit);
        $data['i'] =(($request->input('page', 1) - 1) * $this->limit);
        $data['orderby'] =$request->input('orderby');
        $data['order'] = $request->input('order');
        $data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('admin.vehicle.index_element')->with($data);
        }
        return view('admin.vehicle.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumb = array('title'=>'Vehicle','action'=>'Add Vehicle');
        
        $data = [];
        $data['car_types']=\App\Price::get();
        $data = array_merge($breadcrumb,$data);
        return view('admin.vehicle.create')->with($data);
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
            'vehicle_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'vehicle_number_plate' => 'required',
            'year' => 'required',
            'model' => 'required',
            'color' => 'required',
            'car_type'=>'required'
        ];
        $request->validate($rules);
        $input=$request->all();
       
        //SAVE IMAGE

        if(!empty($_FILES['vehicle_image'])){
                if(isset($_FILES['vehicle_image']) && $_FILES['vehicle_image']['name'] !== '' && !empty($_FILES['vehicle_image']['name'])){
                    $file = $_FILES['vehicle_image'];
                    $file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
                    $filename = time().'-'.$file;
                    $ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif','png'); //set allowed extensions
                    
                    if(in_array($ext, $arr_ext))
                    {
                    $path="public/images/user_image/";
                    if(move_uploaded_file($_FILES['vehicle_image']['tmp_name'],$path.$filename)){
                        $url = URL::to('/');
                        $input['vehicle_image'] = $url."/".$path.$filename;
                    }
                    }else{
                         return response()->json(['message'=>'Upload valid image'], $this->warningCode);
                    }
                }
            }

            $input['category_id']=$input['car_type'];
        \App\Vehicle::create($input);
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
        $breadcrumb = array('title'=>trans('admin.Vehicle'),'action'=>trans('admin.Vehicle Detail'));
        $data = [];
        $where = array('id' => $id);
        $record = \App\Vehicle::where($where)->first();
        
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
    public function edit(Request $request,$id)
    {
         $breadcrumb = array('title'=>'Vehicle','action'=>'Edit Vehicle');
        $data = [];
        $where = array('id' => $id);
        $record = \App\Vehicle::where($where)->first();
        if(empty($record)){
            return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
        }
         if(!empty($request->type) && $request->type=="remove_image"){
			  $filename1 = parse_url($record->vehicle_image);
			 $filename2 = public_path($filename1['path']);
			 ///if( File::exists($filename1['path']) ) {
			\App\Vehicle::where('id',$id)->update(['vehicle_image'=>'']);
			 return response()->json(['message'=>'success']);
		 }
        $data['record'] = $record;
        $data['car_types']=\App\Price::get();
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
        $vehicle = \App\Vehicle::where(['id'=>$id])->first();;
        
        $rules = [
           // 'user_name' =>  'required|'.(!empty($haveUser->id) ? 'unique:users,user_name,'.$haveUser->id : ''),
            'vehicle_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            //'gender' => 'required|integer|between:1,2',
            //'dob' => 'required',
        ];
        if(!empty($request->reset_password)){
            $rules['password'] = 'required|min:6';
        }
        $request->validate($rules);
        $input = $request->all();
        $input['category_id']=$input['car_type'];
        unset($input['_method'],$input['_token'],$input['image_tmp'],$input['car_type']);
       // dd($_FILES['vehicle_image']);
          if(!empty($_FILES['vehicle_image'])){

                if(isset($_FILES['vehicle_image']) && $_FILES['vehicle_image']['name'] !== '' && !empty($_FILES['vehicle_image']['name'])){
                    $file = $_FILES['vehicle_image'];
                    $file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
                    $filename = time().'-'.$file;
                    $ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif','pqueryng'); //set allowed extensions
                    
                    if(in_array($ext, $arr_ext))
                    {
                    $path="public/images/user_image/";
                    if(move_uploaded_file($_FILES['vehicle_image']['tmp_name'],$path.$filename)){
                        $url = URL::to('/');
                        $input['vehicle_image'] = $url."/".$path.$filename;
                    }
                    }else{
                         return response()->json(['message'=>'Upload valid image'], $this->warningCode);
                    }
                }
            }

              
        
        \App\Vehicle::where('id', $id)->update($input);
        
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
