<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use File;
use App\Vehicle;
use App\Price;
use DataTables;
use App\DriverChooseCar;
use App\User;
use App\Exports\VehicleExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
  
    protected $limit;

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
        $data = array();
        $data = array('title' => 'Vehicle', 'action' => 'List Vehicles');
		
		$records = Vehicle::with(['last_driver_choosen', 'carType']);
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			
			Vehicle::where([['id', $request->input('id')]])->limit(1)->delete();
		}
		
		if(!empty($request->input('text'))){
			$text = $request->input('text');
			$service_provider_id = Auth::user()->id;
			$records->whereRaw("(year LIKE '%$text%' OR model LIKE '%$text%' OR color LIKE '%$text%' OR vehicle_number_plate LIKE '%$text%') AND service_provider_id=$service_provider_id");
		}
		
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}
		
		#$this->limit = 2;
		
		$data['records'] = $records->where(['service_provider_id'=>Auth::user()->id])->paginate($this->limit);
		
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		
        if ($request->ajax()) {
            return view("admin.vehicle.index_element")->with($data);
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
        $data['car_types']=\App\Price::where('service_provider_id',Auth::user()->id)->pluck('car_type', 'id');
        $data = array_merge($breadcrumb,$data);
        return view('admin.vehicle.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vehicle_number_plate' => 'required',
            'year' => 'required',
            'model' => 'required',
            'color' => 'required',
            'car_type' => 'required'
        ]);
        $input = $request->all();
        //SAVE IMAGE

        if (!empty($_FILES['image'])) {
            if (isset($_FILES['image']) && $_FILES['image']['name'] !== '' && !empty($_FILES['image']['name'])) {
                $ext = $request->image->extension();
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                if (!in_array($ext, $arr_ext)) {
                    return back()->with('error', 'Please upload a valid Image');
                }
            }
        }

        $input['category_id'] = $input['car_type'];
        $input['service_provider_id'] = Auth::user()->id;
        $vehicleObj = \App\Vehicle::create($input);

        if (!empty($_FILES['image'])) {
            if (isset($_FILES['image']) && $_FILES['image']['name'] !== '' && !empty($_FILES['image']['name'])) {

                $imageName = 'vehicle-image.' . $request->image->extension();
                $vehicleObj->vehicle_image = Storage::disk('public')->putFileAs(
                    'vehicle/' . $vehicleObj->id,
                    $request->image,
                    $imageName
                );
                $vehicleObj->save();
            }
        }
		
		if(isset($request->mileage)){
            $choosenVehicle = DriverChooseCar::where(['car_id' => $vehicleObj->id])->latest()->first();
            if(!empty($choosenVehicle)){
				
				if($choosenVehicle->logout_mileage != $request->mileage){
					$choosenVehicle->logout_mileage = $request->mileage;
					$choosenVehicle->save();
				}
			}
        }

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
        $record = \App\Vehicle::where($where)->where('service_provider_id',Auth::user()->id)->first();
        
        if(empty($record)){
            return redirect()->route("{$this->folder}.index")->with('warning', trans('admin.Record not found!'));
        }
        $dataCar=DriverChooseCar::where('car_id',$id)->where('logout',0)->first();

        $data['status'] = array(1=>'Active',0=>'In-active');
        $data['record'] = $record;
        $data['carDriver']=$dataCar;
        $data['driverDetails']=($dataCar)?User::where('id',$dataCar->user_id)->first():'';
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
        $record = \App\Vehicle::with(['last_driver_choosen'])->where('service_provider_id',Auth::user()->id)->where($where)->first();
		
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
        $data['car_types']=\App\Price::where('service_provider_id',Auth::user()->id)->pluck('car_type', 'id');
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
        $vehicle = \App\Vehicle::find($id);
		
        $rules = [
            'vehicle_number_plate' =>  'required',
            'vehicle_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'year' => 'required',
            'model' => 'required',
            'color' => 'required',
            'car_type' => 'required',
        ];
        if (!empty($request->reset_password)) {
            $rules['password'] = 'required|min:6';
        }
        $request->validate($rules);
        $input = $request->all();
        $input['category_id'] = $input['car_type'];
        
		unset($input['_method'], $input['_token'], $input['image_tmp'], $input['car_type'], $input['submit']);
        
        if (!empty($_FILES['vehicle_image'])) {
            if (isset($_FILES['vehicle_image']) && $_FILES['vehicle_image']['name'] !== '' && !empty($_FILES['vehicle_image']['name'])) {
                $ext = $request->vehicle_image->extension();
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
        
                if (in_array($ext, $arr_ext)) {
                    $imageName = 'vehicle-image.' . $request->vehicle_image->extension();
                    if (!empty($vehicle['vehicle_image'])) {
                        Storage::disk('public')->delete($vehicle['vehicle_image']);
                    }
                    $input['vehicle_image'] = Storage::disk('public')->putFileAs(
                        'vehicle/' . $vehicle->id,
                        $request->vehicle_image,
                        $imageName
                    );
                } else {
                    return back()->with('error', 'Please upload a valid Image');
                }
            }
        }

        \App\Vehicle::where('id', $id)->update($input);
		
        if(isset($request->mileage)){
            $choosenVehicle = DriverChooseCar::where(['car_id' => $id])->latest()->first();
            if(!empty($choosenVehicle)){
				if($choosenVehicle->logout_mileage != $request->mileage){
					$choosenVehicle->logout_mileage = $request->mileage;
					$choosenVehicle->save();
				}
			}
        }
        
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
       $updateUser=Vehicle::find($request->id)->delete();
        if ($updateUser) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
        exit; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function carFree(Request $request)
    {
        $users=DriverChooseCar::where('car_id',$request->id)->where('logout',0)->first();
       User::logoutUserByIdAllDevices($users->user_id);
       $updateUser=DriverChooseCar::where('car_id',$request->id)->update(['logout'=>1]);
        if ($updateUser) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
        exit; 
    }

    public function vehicleExport()
    {
        return Excel::download(new VehicleExport([]), 'Vehicle List Veldoo.xlsx');
    }
}
