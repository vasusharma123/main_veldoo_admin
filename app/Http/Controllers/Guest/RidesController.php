<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ride;
use App\RideHistory;
use DataTables;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Exports\RideExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Price;
use Carbon\Carbon;
use App\Setting;
use App\Notification;
use App\Http\Resources\RideResource;
use App\SMSTemplate;

class RidesController extends Controller
{
    protected $successCode = 200;
    protected $errorCode = 401;
    protected $warningCode = 500;

    public function index(Request $request, $type=null)
    {

        $type = ($type?$type:'list').'View';
        $type = !in_array($type,['listView','monthView','weekView'])?'listView':$type;
        $data['user'] = '';
        if($request->token){
            $data['token'] = $request->token;
            $data['user'] = User::where('random_token', $request->token)->first();
        }
        $userId = (Auth::user()) ? Auth::user()->id : (($data['user'])  ? $data['user']->id : "");

        if($userId){
            $data['users'] = User::where(['user_type' => 1, 'id' => $userId])->orderBy('name')->get();
        } 
       
        $data['vehicle_types'] = Price::orderBy('sort')->get();
        return $this->$type($data,$request->all());
    }




    public function listView($data,$request)
    {


        $company = Auth::user();
        $data['page_title'] = 'Rides';
        $data['action'] = 'Rides';
        $data['user'] = '';
        if(!empty($request['token'])) {
            $data['user'] = User::where('random_token', $request['token'])->first();
        }
        $userId = (Auth::user()) ? Auth::user()->id : (($data['user'])  ? $data['user']->id : "");
        $data['rides'] = '';
        if($userId) {
            $data['rides'] = Ride::select('rides.id', 'rides.ride_time', 'rides.status','rides.pickup_address','rides.vehicle_id','rides.user_id')
            ->where(function ($query) use ($userId){
                if($userId) {
                    $query->where(['user_id' => $userId]);
                }
                $query->where('status', '!=', -2);
            })->where('user_id','!=',null)
            ->orderBy('rides.ride_time', 'DESC')
            ->with(['vehicle','user:id,first_name,last_name'])
            ->paginate(20);
        }
        

    // dd($data);
        return view('guest.rides.index')->with($data);
    }

    public function monthView($data,$request)
    {
        
        $date = date('Y-m-d');
        if(isset($request['m']) && !empty($request['m']))
        {
            $date = $request['m'];
        }
        $month = date('m',strtotime($date));
        $year = date('Y',strtotime($date));

        $data['page_title'] = 'Rides';
        $data['action'] = 'Rides';
        $company = Auth::user();
        $data['user'] = '';
        if(!empty($request['token'])) {
            $data['user'] = User::where('random_token', $request['token'])->first();
        }
        $userId = (Auth::user()) ? Auth::user()->id : (($data['user'])  ? $data['user']->id : "");
        $data['rides'] = '';
        if($userId) {
            $data['rides'] = Ride::select('rides.id', 'rides.ride_time', 'rides.status','rides.pickup_address','rides.vehicle_id','rides.user_id')
            ->where(function ($query) use ($userId){
                if($userId) {
                    $query->where(['user_id' => $userId]);
                }
            $query->where('status', '!=', -2);
        })->where('user_id','!=',null)->orderBy('rides.id')
        ->whereMonth('ride_time',$month)
        ->whereYear('ride_time', $year)
        ->with(['vehicle','user:id,first_name,last_name'])->get();
        }
        
        if($userId) {                
            $data['users'] = User::where(['user_type' => 1, 'id' => $userId])->orderBy('name')->get();
        }
        $data['vehicle_types'] = Price::orderBy('sort')->get();
        $data['date'] = $date;
        return view('guest.rides.month')->with($data);
    }

    public function weekView($data,$request)
    {
        $data['page_title'] = 'Rides';
        $data['action'] = 'Rides';
        $data['year'] = Carbon::now()->startOfWeek()->format('Y');
        $data['month'] = Carbon::now()->startOfWeek()->format('m')-1;
        $data['day'] = Carbon::now()->startOfWeek()->format('d');
        if(isset($request['w']) && !empty($request['w']))
        {
            $data['year'] = date('Y',strtotime($request['w']));
            $data['month'] = date('m',strtotime($request['w']))-1;
            $data['day'] = date('d',strtotime($request['w']));
        }

        $startOfWeek = $data['year'].'-'.($data['month']+1).'-'.$data['day']; // Example start date of the week
        // Convert the start date to a Carbon instance
        $startOfWeekDate = Carbon::parse($startOfWeek)->startOfDay();

        // Calculate the end date of the week by adding 6 days to the start date
        $endOfWeekDate = $startOfWeekDate->copy()->addDays(6)->endOfDay();
        // dd($endOfWeekDate);
        $data['user'] = '';
        if(!empty($request['token'])) {
            $data['user'] = User::where('random_token', $request['token'])->first();
        }
        $userId = (Auth::user()) ? Auth::user()->id : (($data['user'])  ? $data['user']->id : "");
        $data['rides'] = '';
        if($userId) {
            $data['rides'] = Ride::select('rides.id', 'rides.ride_time', 'rides.status','rides.pickup_address','rides.vehicle_id','rides.user_id')
            ->where(function ($query) use ($userId){
                if($userId) {
                    $query->where(['user_id' => $userId]);
                }
            $query->where('status', '!=', -2);
        })->where('user_id','!=',null)->orderBy('rides.id')->whereDate('ride_time', '>=', $startOfWeekDate->toDateString())
        ->whereDate('ride_time', '<=', $endOfWeekDate->toDateString())
        ->with(['vehicle','user:id,first_name,last_name'])->get();
        }
        

        if($userId) {                
            $data['users'] = User::where(['user_type' => 1, 'id' => $userId])->orderBy('name')->get();
        }
        $data['vehicle_types'] = Price::orderBy('sort')->get();
        // dd($data['rides']);
        return view('guest.rides.week')->with($data);
    }

    public function user_exist(Request $request) {

        try
		{
			// if (!$request->has('g-recaptcha-response'))
			// {
			// 	return response()->json(['status' => 0, 'message' => 'Invalid Request']);
			// }
			// $captcha = $request['g-recaptcha-response'];

			// $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".env('RECAPTCHA_SITE_KEY')."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);

			// if(!is_array($response) && isset($response) && $response['success'] == false)
			// {
			// 	return response()->json(['status' => 0, 'message' => 'Invalid Request']);
			// }
			$userExit = Ride::where(['user_country_code' => $request->country_code, 'user_phone' => (int) filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT)])->first();
			$userData = User::where(['country_code' => $request->country_code, 'phone' => (int) filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT)])->first();

			if(Auth::user()) {
                return response()->json(['status' => 1, 'route' => route('guest.ride_booking'), ]);
            } 
            // else if ($userExit) {
            //     return response()->json(['status' => 1, 'route' => route('without_otp_ride_booking'), ]);
            // } else if ($userData) {
            //     return response()->json(['status' => 1, 'route' => route('without_otp_ride_booking'), ]);
            // }
            else {
                return response()->json(['status' => 1, 'route' => route('send_otp_before_ride_booking')]);
            }
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		} catch (\Exception $exception) {
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}


    }

    public function ride_booking(Request $request)
    {

       // dd($request->all());


        $now = Carbon::now();
        $vehicle_type = Price::find($request->car_type);
        $request->car_type = $vehicle_type->car_type;
        $request['ride_time'] = ($request->ride_date.' '.$request->ride_time.":00");
        if ($now->diffInMinutes($request->ride_time) <= 15) {
            $jsonResponse = $this->create_ride_driver($request);
        } else {
            $jsonResponse = $this->book_ride($request);
        }
        return $jsonResponse;
    }

    public function create_ride_driver(Request $request)
    {
        $rules = [
            'pick_lat' => 'required',
            'pick_lng' => 'required',
            'pickup_address' => 'required',
            'car_type' => 'required',
            'ride_time' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first(), 'error' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $ride = new Ride();
            $ride->user_id = $request->user_id??null;
            $rideUser = User::find($request->user_id);
            if ($rideUser)
            {
                $ride->user_country_code = $rideUser->country_code;
                $ride->user_phone = $rideUser->phone;
            }
            $ride->user_id = Auth::user() ? Auth::user()->id : NULL;
            $ride->pickup_address = $request->pickup_address;
            if (!empty($request->dest_address)) {
                $ride->dest_address = $request->dest_address;
            }
            if (!empty($request->pick_lat)) {
                $ride->pick_lat = $request->pick_lat;
            }
            if (!empty($request->pick_lng)) {
                $ride->pick_lng = $request->pick_lng;
            }
            if (!empty($request->dest_lat)) {
                $ride->dest_lat = $request->dest_lat;
            }
            if (!empty($request->dest_lng)) {
                $ride->dest_lng = $request->dest_lng;
            }
            if (!empty($request->passanger)) {
                $ride->passanger = $request->passanger;
            }
            if (!empty($request->payment_type)) {
                $ride->payment_type = $request->payment_type;
            }
            $ride->ride_type = 3;
            $ride->created_by =  Auth::user() ? Auth::user()->user_type : 1; 
            $ride->creator_id = Auth::user() ? Auth::user()->id : NULL; 
            $ride->platform = "web";
            if (!empty($request->ride_time)) {
                $ride->ride_time = date("Y-m-d H:i:s", strtotime($request->ride_time));
            } else {
                $ride->ride_time = date("Y-m-d H:i:s");
            }
            if (!empty($request->ride_cost)) {
                $ride->ride_cost = $request->ride_cost;
            }
            if (!empty($request->note)) {
                $ride->note = $request->note;
            }
            if (!empty($request->car_type)) {
                $ride->car_type = $request->car_type;
            }
            if (!empty($request->distance)) {
                $ride->distance = $request->distance;
            }
            if (!empty($request->pick_lat) && !empty($request->pick_lng)) {
                $lat = $request->pick_lat;
                $lon = $request->pick_lng;
                $settings = Setting::first();
                $settingValue = json_decode($settings['value']);
                $driverlimit = $settingValue->driver_requests;
                $query = User::select(
                    "users.*",
                    DB::raw("3959 * acos(cos(radians(" . $lat . "))
                        * cos(radians(users.current_lat))
                        * cos(radians(users.current_lng) - radians(" . $lon . "))
                        + sin(radians(" . $lat . "))
                        * sin(radians(users.current_lat))) AS distance")
                );
                $query->where([['user_type', '=', 2], ['availability', '=', 1]])->orderBy('distance', 'asc')->limit($driverlimit);
                $drivers = $query->get()->toArray();
            }

            $driverids = array();

            if (!empty($drivers)) {
                foreach ($drivers as $driver) {
                    $driverids[] = $driver['id'];
                }
            } else {
                return response()->json(['status' => 0, 'message' => __("No Driver Found")]);
            }
            if (!empty($driverids)) {
                $driverids = implode(",", $driverids);
            } else {
                return response()->json(['status' => 0, 'message' => __("No Driver Found")]);
            }

            $ride->driver_id = null;
            $ride->all_drivers = $driverids;
            $ride->save();
            $ride_data = new RideResource(Ride::find($ride->id));
            $driverids = explode(",", $driverids);
            $title = 'New Booking';
            $message = 'You Received new booking';
            $ride_data['waiting_time'] = $settingValue->waiting_time;
            $additional = ['type' => 1, 'ride_id' => $ride->id, 'ride_data' => $ride_data];
            if (!empty($driverids)) {
                $ios_driver_tokens = User::whereIn('id', $driverids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'ios'])->pluck('device_token')->toArray();
                if (!empty($ios_driver_tokens)) {
                    bulk_pushok_ios_notification($title, $message, $ios_driver_tokens, $additional, $sound = 'default', 2);
                }
                $android_driver_tokens = User::whereIn('id', $driverids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'android'])->pluck('device_token')->toArray();
                if (!empty($android_driver_tokens)) {
                    bulk_firebase_android_notification($title, $message, $android_driver_tokens, $additional);
                }
                $notification_data = [];
                $ridehistory_data = [];
                foreach ($driverids as $driverid) {
                    $notification_data[] = ['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $driverid, 'additional_data' => json_encode($additional), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                    $ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $driverid, 'status' => '2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                }
                Notification::insert($notification_data);
                RideHistory::insert($ridehistory_data);
            }
            $overallDriversCount = User::select(
                "users.*",
                DB::raw("3959 * acos(cos(radians(" . $ride->pick_lat . "))
				* cos(radians(users.current_lat))
				* cos(radians(users.current_lng) - radians(" . $ride->pick_lng . "))
				+ sin(radians(" . $ride->pick_lat . "))
				* sin(radians(users.current_lat))) AS distance")
            )->where(['user_type' => 2, 'availability' => 1])->whereNotNull('device_token')->get()->toArray();
            $rideData = Ride::find($ride->id);
            $rideData->notification_sent = 1;
            if (count($overallDriversCount) <= count($drivers)) {
                $rideData->alert_send = 1;
            }
            $rideData->alert_notification_date_time = Carbon::now()->addseconds($settingValue->waiting_time)->format("Y-m-d H:i:s");
            $rideData->save();

            $ride_detail = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at', 'creator_id', 'route')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])->find($rideData->id);
            $ride_detail['is_newly_created'] = 1;


           // dd($ride_detail);
           /// Log::info('socket error', $ride_detail);
            // if (!empty($ride_detail)) {
			// 	$settings = \App\Setting::first();
			// 	$settingValue = json_decode($settings['value']);
			// 	$ride_detail['waiting_time'] = $settingValue->waiting_time;
			// } 

            DB::commit();
            if (!empty($rideData->user) && empty($rideData->user->password) && !empty($rideData->user->phone)) {
                $message_content = "";
                $SMSTemplate = SMSTemplate::find(2);
                if ($rideData->user->country_code == "41" || $rideData->user->country_code == "43" || $rideData->user->country_code == "49") {
                    $message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#TIME#', date('d M, Y h:ia', strtotime($rideData->ride_time)), $SMSTemplate->german_content));
                } else {
                    $message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#TIME#', date('d M, Y h:ia', strtotime($rideData->ride_time)), $SMSTemplate->english_content));
                }
                $this->sendSMS("+" . $rideData->user->country_code, ltrim($rideData->user->phone, "0"), $message_content);
            }
            return response()->json(['status' => 1, 'booking_status' => 'direct', 'message' => __('Instant ride created successfully.'), 'data' => $ride_detail], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
    }

    public function book_ride(Request $request)
    {
        $rules = [
            'pick_lat' => 'required',
            'pick_lng' => 'required',
            'pickup_address' => 'required',
            'car_type' => 'required',
            'ride_time' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first(), 'error' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {

            // for multipal booking

            $ride = new Ride();
            $ride->user_id = $request->user_id??null;
            $rideUser = User::find($request->user_id);
            if ($rideUser)
            {
                $ride->user_country_code = $rideUser->country_code;
                $ride->user_phone = $rideUser->phone;
            }

            $ride->pickup_address = $request->pickup_address;
            $ride->dest_address = $request->dest_address??"";
            $ride->passanger = $request->passanger;
            $ride->note = $request->note;
            $ride->ride_type = 1;
            $ride->car_type = $request->car_type;
            $ride->created_by =  Auth::user() ? Auth::user()->user_type : 1; 
            $ride->creator_id = Auth::user() ? Auth::user()->id : NULL; 
            $ride->alert_time = 15;
            $ride->user_id = Auth::user() ? Auth::user()->id : NULL; 
            $ride->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('-15 minutes', strtotime($request->ride_time)));
            if (!empty($request->pick_lat)) {
                $ride->pick_lat = $request->pick_lat;
            }
            if (!empty($request->pick_lng)) {
                $ride->pick_lng = $request->pick_lng;
            }
            if (!empty($request->dest_lat)) {
                $ride->dest_lat = $request->dest_lat;
            }
            if (!empty($request->dest_lng)) {
                $ride->dest_lng = $request->dest_lng;
            }
            if (!empty($request->payment_type)) {
                $ride->payment_type = $request->payment_type;
            }
            if (!empty($request->ride_cost)) {
                $ride->ride_cost = $request->ride_cost;
            }
            $ride->ride_time = date("Y-m-d H:i:s", strtotime($request->ride_time));
            if (!empty($request->distance)) {
                $ride->distance = $request->distance;
            }
            $ride->status = 0;
            $ride->platform = "web";
            $ride->save();

            $ride_detail = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at','creator_id', 'route')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])->find($ride->id);
            $ride_detail['is_newly_created'] = 1;

            DB::commit();
            if (!empty($ride->user) && empty($ride->user->password) && !empty($ride->user->phone)) {
                $message_content = "";
                $SMSTemplate = SMSTemplate::find(2);
                if ($ride->user->country_code == "41" || $ride->user->country_code == "43" || $ride->user->country_code == "49") {
                    $message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#TIME#', date('d M, Y h:ia', strtotime($ride->ride_time)), $SMSTemplate->german_content));
                } else {
                    $message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#TIME#', date('d M, Y h:ia', strtotime($ride->ride_time)), $SMSTemplate->english_content));
                }
                $this->sendSMS("+" . $ride->user->country_code, ltrim($ride->user->phone, "0"), $message_content);
            }

            return response()->json(['status' => 1, 'booking_status' => 'direct', 'message' => __('Ride Booked successfully'), 'data' => $ride_detail], $this->successCode);

        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
    }

    public function history()
    {
        $data = array('page_title' => 'History', 'action' => 'History');
        $now = Carbon::now();
        $data['rides'] = Ride::where('ride_time','<',$now)->where(function($query){
                            if(Auth::user()) {
                                $query->where(['user_id' => Auth::user()->id]);
                            }
                            $query->where('status', '!=', '1')->where('status', '!=', '2')->where('status', '!=', '4');
                        })->orderBy('rides.created_at','Desc')->where('user_id','!=',null)->with(['user','driver','vehicle','creator'])->get();
        // dd(($data['rides']));
        return view('guest.rides.history')->with($data);
    }

    public function ride_detail($id)
    {
        $now = Carbon::now();
        $ride = Ride::where(function($query){
                                if(Auth::user()) {
                                    $query->where(['user_id' => Auth::user()->id]);
                                }
                            // $query->where('status', '!=', '1')->where('status', '!=', '2')->where('status', '!=', '4');
                        })->orderBy('rides.created_at','Desc')
                        //->where('user_id','!=',null)
                        ->with(['user','driver','vehicle','creator'])->find($id);
                        //dd($ride);

        // $ride->status = 2;
        return response()->json(['status'=>1,'data'=>$ride]);
    }

    public function edit(Request $request)
    {
        try
        {
            $ride_detail = Ride::find($request->ride_id);
            $ride_detail->ride_date_new_modified_n = date('Y-m-d',strtotime($ride_detail->ride_time));
            $ride_detail->ride_time_new_modified_n = date('H:i',strtotime($ride_detail->ride_time));
            return response()->json(['status' => 1, 'message' => "Ride Detail", 'data' => ["ride_detail" => $ride_detail]], $this->successCode);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
    }

    public function ride_booking_update(Request $request)
	{
		$now = Carbon::now();
        $vehicle_type = Price::find($request->car_type);
        $request->car_type = $vehicle_type->car_type;
        $request['ride_time'] = ($request->ride_date.' '.$request->ride_time.":00");
		if ($now->diffInMinutes($request->ride_time) <= 15) {
			$jsonResponse = $this->create_ride_driver_edit($request);
		} else {
			$jsonResponse = $this->book_ride_edit($request);
		}
		return $jsonResponse;
	}

    protected function create_ride_driver_edit(Request $request)
    {
        $rules = [
            'ride_id' => 'required',
            'pick_lat' => 'required',
            'pick_lng' => 'required',
            'pickup_address' => 'required',
            'car_type' => 'required',
            'ride_time' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first(), 'error' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $ride = Ride::find($request->ride_id);
            $ride->pickup_address = $request->pickup_address;
            $ride->dest_address = $request->dest_address ??"";
            $ride->pick_lat = $request->pick_lat ?? "";
            $ride->pick_lng = $request->pick_lng ?? "";
            $ride->dest_lat = $request->dest_lat ?? "";
            $ride->dest_lng = $request->dest_lng ?? "";
            $ride->passanger = $request->passanger ?? "";
            if (!empty($request->payment_type)) {
                $ride->payment_type = $request->payment_type;
            }
            $ride->ride_type = 3;
            $ride->platform = "web";
            if (!empty($request->ride_time)) {
                $ride->ride_time = date("Y-m-d H:i:s", strtotime($request->ride_time));
            } else {
                $ride->ride_time = date("Y-m-d H:i:s");
            }
            $ride->ride_cost = $request->ride_cost ?? "";
            $ride->note = $request->note ?? "";
            $ride->car_type = $request->car_type ?? "";
            $ride->distance = $request->distance ?? "";
            if (!empty($request->pick_lat) && !empty($request->pick_lng)) {
                $lat = $request->pick_lat;
                $lon = $request->pick_lng;
                $settings = Setting::first();
                $settingValue = json_decode($settings['value']);
                $driverlimit = $settingValue->driver_requests;
                $query = User::select(
                    "users.*",
                    DB::raw("3959 * acos(cos(radians(" . $lat . "))
                        * cos(radians(users.current_lat))
                        * cos(radians(users.current_lng) - radians(" . $lon . "))
                        + sin(radians(" . $lat . "))
                        * sin(radians(users.current_lat))) AS distance")
                );
                $query->where([['user_type', '=', 2], ['availability', '=', 1]])->orderBy('distance', 'asc')->limit($driverlimit);
                $drivers = $query->get()->toArray();
            }

            $driverids = array();

            if (!empty($drivers)) {
                foreach ($drivers as $driver) {
                    $driverids[] = $driver['id'];
                }
            } else {
                return response()->json(['status' => 0, 'message' => "No Driver Found"]);
            }
            if (!empty($driverids)) {
                $driverids = implode(",", $driverids);
            } else {
                return response()->json(['status' => 0, 'message' => "No Driver Found"]);
            }

            $ride->driver_id = null;
            $ride->all_drivers = $driverids;

            $ride->save();
            $ride_data = new RideResource(Ride::find($ride->id));
            $driverids = explode(",", $driverids);
            $title = 'New Booking';
            $message = 'You Received new booking';
            $ride_data['waiting_time'] = $settingValue->waiting_time;
            $additional = ['type' => 1, 'ride_id' => $ride->id, 'ride_data' => $ride_data];
            if (!empty($driverids)) {
                $ios_driver_tokens = User::whereIn('id', $driverids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'ios'])->pluck('device_token')->toArray();
                if (!empty($ios_driver_tokens)) {
                    bulk_pushok_ios_notification($title, $message, $ios_driver_tokens, $additional, $sound = 'default', 2);
                }
                $android_driver_tokens = User::whereIn('id', $driverids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'android'])->pluck('device_token')->toArray();
                if (!empty($android_driver_tokens)) {
                    bulk_firebase_android_notification($title, $message, $android_driver_tokens, $additional);
                }
                $notification_data = [];
                $ridehistory_data = [];
                foreach ($driverids as $driverid) {
                    $notification_data[] = ['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $driverid, 'additional_data' => json_encode($additional), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                    $ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $driverid, 'status' => '2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                }
                Notification::insert($notification_data);
                RideHistory::insert($ridehistory_data);
            }
            $overallDriversCount = User::select(
                "users.*",
                DB::raw("3959 * acos(cos(radians(" . $ride->pick_lat . "))
				* cos(radians(users.current_lat))
				* cos(radians(users.current_lng) - radians(" . $ride->pick_lng . "))
				+ sin(radians(" . $ride->pick_lat . "))
				* sin(radians(users.current_lat))) AS distance")
            )->where(['user_type' => 2, 'availability' => 1])->whereNotNull('device_token')->get()->toArray();
            $rideData = Ride::find($ride->id);
            $rideData->notification_sent = 1;
            if (count($overallDriversCount) <= count($drivers)) {
                $rideData->alert_send = 1;
            }
            $rideData->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('+' . $settingValue->waiting_time . ' seconds ', strtotime($rideData->ride_time)));
            $rideData->save();

            $ride_detail = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at', 'creator_id', 'route')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])->find($rideData->id);
            
            $ride_detail['change_for_all'] = 1;

            DB::commit();
            return response()->json(['status' => 1, 'message' => 'Instant ride created successfully.', 'data' => $ride_detail], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
    }

    protected function book_ride_edit(Request $request)
    {
        $rules = [
            'ride_id' => 'required',
            'pick_lat' => 'required',
            'pick_lng' => 'required',
            'pickup_address' => 'required',
            'car_type' => 'required',
            'ride_time' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first(), 'error' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $ride = Ride::find($request->ride_id);
            $ride->pickup_address = $request->pickup_address;
            $ride->dest_address = $request->dest_address??"";
            $ride->passanger = $request->passanger;
            $ride->note = $request->note;
            $ride->ride_type = 1;
            $ride->car_type = $request->car_type;
            $ride->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('-15 minutes', strtotime($request->ride_time)));
            if ((!empty($request->ride_time)) && $request->ride_time >= Carbon::now()->format("Y-m-d H:i:s")) {
				$ride->notification_sent = 0;
				$ride->alert_send = 0;
			}
            $ride->pick_lat = $request->pick_lat ?? "";
            $ride->pick_lng = $request->pick_lng ?? "";
            $ride->dest_lat = $request->dest_lat ?? "";
            $ride->dest_lng = $request->dest_lng ?? "";
            $ride->payment_type = $request->payment_type ?? "";
            if (!empty($request->ride_cost)) {
                $ride->ride_cost = $request->ride_cost;
            }
            $ride->ride_time = date("Y-m-d H:i:s", strtotime($request->ride_time));
            $ride->distance = $request->distance ?? "";
            $ride->status = 0;
            $ride->platform = "web";
            $ride->save();

            $ride_detail = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at', 'creator_id', 'route')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])->find($ride->id);
            $ride_detail['change_for_all'] = 1;

            DB::commit();
            return response()->json(['status' => 1, 'message' => 'Ride Booked successfully', 'data' => $ride_detail], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
    }

	public function cancel_booking(Request $request)
	{
		try {
			DB::beginTransaction();
			$ride_id = $request->ride_id;
			$ride = Ride::find($ride_id);
			if (!empty($ride)) {
				if (!empty($ride['driver_id'])) {
					$driverData = User::find($ride['driver_id']);
				}
				if (!empty($ride['user_id'])) {
					$userData = User::find($ride['user_id']);
				}

				if ($ride['status'] == -3) {
					return response()->json(['status' => 0, 'message' => "Ride Cancelled already"]);
				}
				$title = 'Ride Cancelled';
				$message = 'Ride Cancelled by User';

				$type = 6;
				$ride->status = -3;
				// if (!empty($request->cancel_reason)) {
				// 	$ride->cancel_reason = $request->cancel_reason;
				// }
				$ride->save();
                
                $ride_detail_socket = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at', 'creator_id', 'route')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])->find($ride->id);

                $ride_detail = new RideResource(Ride::find($ride->id));
				$settings = Setting::first();
				$settingValue = json_decode($settings['value']);
				$ride_detail['waiting_time'] = $settingValue->waiting_time;
				if (!empty($driverData)) {
					$deviceToken = $driverData['device_token'] ?? "";
					$deviceType = $driverData['device_type'] ?? "";
					$additional = ['type' => $type, 'ride_id' => $ride_detail->id, 'ride_data' => $ride_detail];
					if (!empty($deviceToken)) {
						if ($deviceType == 'android') {
							bulk_firebase_android_notification($title, $message, [$deviceToken], $additional);
						}
						if ($deviceType == 'ios') {
							bulk_pushok_ios_notification($title, $message, [$deviceToken], $additional, $sound = 'default', $driverData['user_type']);
						}
					}
				}

				if (!empty($userData)) {
					$notification = new Notification();
					$notification->title = 'Ride Cancelled';
					$notification->description = 'Ride Cancelled by you';
					$notification->type = $type;
					$notification->user_id = $userData['id'];
					$notification->additional_data = (!empty($additional)) ? json_encode($additional) : null;
					$notification->save();
				}
			}
			DB::commit();
			return response()->json(['status' => 1, 'message' => __('The ride has been cancelled.'), 'data' => $ride_detail_socket]);
		} catch (\Exception $exception) {
			DB::rollBack();
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}
	}

    public function delete_booking(Request $request)
    { 
        try {
            DB::beginTransaction();

            Ride::where(['id' => $request->ride_id])->delete();
            RideHistory::where(['ride_id' => $request->ride_id])->delete();

            $ride_detail_socket['id'] = $request->ride_id;
            $ride_detail_socket['is_ride_deleted'] = 1;

            DB::commit();
			return response()->json(['status' => 1, 'message' => __('The ride has been deleted.'), 'data' => $ride_detail_socket]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $e->getMessage()], 400);
        }
    }

    public function ride_driver_detail(Request $request){
        $ride_detail = Ride::with(['driver', 'vehicle', 'creator'])->find($request->ride_id);
        if($ride_detail->driver){
            $driver_detail = view('guest.rides.driver_detail')->with(['ride_detail' => $ride_detail])->render();
        } else {
            $driver_detail = null;
        }
        return response()->json(['status' => 1, 'message' => "Ride Detail", 'data' => ["driver_detail" => $driver_detail]], $this->successCode);
    }

}
