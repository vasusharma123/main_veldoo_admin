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
use Auth;

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
        $data = array();
        $data = array('title' => 'Vehicle', 'action' => 'List Vehicles');

        if ($request->ajax()) {
            $data = Vehicle::with(['last_driver_choosen', 'carType'])->where('service_provider_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $dataCar = DriverChooseCar::where('car_id', $row->id)->where('logout', 0)->first();
                    $btn = '<div class="btn-group dropright">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' . route('vehicle.show', $row->id) . '">' . trans("admin.View") . '</a>
                                <a class="dropdown-item" href="' . route('vehicle.edit', $row->id) . '">' . trans("admin.Edit") . '</a>
                                <a class="dropdown-item delete_record" data-id="' . $row->id . '">' . trans("admin.Delete") . '</a>';
                    if (!empty($dataCar)) {
                        $btn .= '<a class="dropdown-item car_free" data-id="' . $row->id . '">Free Now</a>';
                    }
                    $btn .= '</div></div>';
                    return $btn;
                })
                ->addColumn('car_type', function ($row) {
                    return (!empty($row->carType))?ucfirst($row->carType->car_type):"";
                })->addColumn('vehicle_image', function ($row) {
                    return (!empty($row->vehicle_image)) ? '<img src="' .  asset('storage/'.$row->vehicle_image) . '" height="50px" width="80px">' : '<img src="' . asset('no-images.png') . '" height="50px" width="80px">';
                })
                ->addColumn('mileage', function ($row) {
                    return (!empty($row->last_driver_choosen))?$row->last_driver_choosen->logout_mileage:"";
                })
                ->rawColumns(['action', 'car_type', 'vehicle_image'])
                ->make(true);
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
        $data['car_types']=\App\Price::where('service_provider_id',Auth::user()->id)->get();
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
        $vehicle = \App\Vehicle::find($id);

        $rules = [
            // 'user_name' =>  'required|'.(!empty($haveUser->id) ? 'unique:users,user_name,'.$haveUser->id : ''),
            'vehicle_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            //'gender' => 'required|integer|between:1,2',
            //'dob' => 'required',
        ];
        if (!empty($request->reset_password)) {
            $rules['password'] = 'required|min:6';
        }
        $request->validate($rules);
        $input = $request->all();
        $input['category_id'] = $input['car_type'];
        unset($input['_method'], $input['_token'], $input['image_tmp'], $input['car_type'], $input['mileage']);
        // dd($_FILES['vehicle_image']);
        
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
            if($choosenVehicle->logout_mileage != $request->mileage){
                $choosenVehicle->logout_mileage = $request->mileage;
                $choosenVehicle->save();
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
