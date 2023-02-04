<?php

namespace App\Http\Controllers\Company;

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

class RidesController extends Controller
{
    protected $successCode = 200;
    protected $errorCode = 401;
    protected $warningCode = 500;

    public function index(Request $request)
    {
        $data = array('page_title' => 'Rides', 'action' => 'Rides');
        $company = Auth::user();
        $data['rides'] = Ride::select('rides.id', 'rides.ride_time', 'rides.status')->where(['company_id' => Auth::user()->company_id])
                            ->where(function($query){
                                $query->where(['status' => 0])->orWhere(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                            })->where('company_id','!=',null)->orderBy('rides.id')->get();
        $data['users'] = User::where(['user_type' => 1, 'company_id' => Auth::user()->company_id])->orderBy('name')->get();
        $data['vehicle_types'] = Price::orderBy('sort')->get();
        return view('company.rides.index')->with($data);
    }

    public function ride_booking(Request $request)
    {
        // dd($request->all());
        $now = Carbon::now();
        $vehicle_type = Price::find($request->car_type);
        $request->car_type = $vehicle_type->car_type;
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
            $ride->user_id = $request->user_id??"";
            $ride->company_id = Auth::user()->company_id;
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
            $ride->created_by = Auth::user()->user_type;
            $ride->creator_id = Auth::user()->id;
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
            $ride_data = Ride::find($ride->id);

            $driverids = explode(",", $driverids);
            $user_data = User::select('id', 'first_name', 'last_name', 'image', 'country_code', 'phone')->find($ride_data['user_id']);
            $title = 'New Booking';
            $message = 'You Received new booking';
            $ride_data['user_data'] = $user_data;
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
            DB::commit();
            return response()->json(['status' => 1, 'message' => __('Instant ride created successfully.'), 'data' => $ride], $this->successCode);
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
            $ride = new Ride();
            $ride->user_id = $request->user_id??"";
            $ride->pickup_address = $request->pickup_address;
            $ride->dest_address = $request->dest_address??"";
            $ride->passanger = $request->passanger;
            $ride->note = $request->note;
            $ride->ride_type = 1;
            $ride->car_type = $request->car_type;
            $ride->created_by = Auth::user()->user_type;
            $ride->creator_id = Auth::user()->id;
            $ride->alert_time = 15;
            $ride->company_id = Auth::user()->company_id;
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
            DB::commit();
            return response()->json(['status' => 1, 'message' => __('Ride Booked successfully')], $this->successCode);
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
        $data['rides'] = Ride::where(['company_id' => Auth::user()->company_id])->where('ride_time','<',$now)->where(function($query){
                            $query->where('status', '!=', '1')->where('status', '!=', '2')->where('status', '!=', '4');
                        })->orderBy('rides.created_at','Desc')->where('company_id','!=',null)->with(['user','driver','vehicle','created_by'])->get();
        // dd(($data['rides']));
        return view('company.rides.history')->with($data);
    }

    public function ride_detail($id)
    {
        $now = Carbon::now();
        $ride = Ride::where(['company_id' => Auth::user()->company_id])->where('ride_time','<',$now)->where(function($query){
                            $query->where('status', '!=', '1')->where('status', '!=', '2')->where('status', '!=', '4');
                        })->orderBy('rides.created_at','Desc')->where('company_id','!=',null)->with(['user','driver','vehicle','created_by'])->find($id);
        // $ride->status = 2;
        return response()->json(['status'=>1,'data'=>$ride]);
    }

    public function edit(Request $request)
    {
        try {
            $ride_detail = Ride::find($request->ride_id);
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
            $ride_data = Ride::query()->find($ride->id);

            $driverids = explode(",", $driverids);
            $user_data = User::select('id', 'first_name', 'last_name', 'image', 'country_code', 'phone')->find($ride_data['user_id']);
            $title = 'New Booking';
            $message = 'You Received new booking';
            $ride_data['user_data'] = $user_data;
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
            DB::commit();
            return response()->json(['status' => 1, 'message' => 'Instant ride created successfully.', 'data' => $ride], $this->successCode);
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
            $ride->alert_notification_date_time = date('Y-m-d H:i:s', strtotime($request->ride_time));
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
            DB::commit();
            return response()->json(['status' => 1, 'message' => 'Ride Booked successfully'], $this->successCode);
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
				$ride_detail = Ride::select('id', 'accept_time', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'driver_id', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'status', 'user_id', 'driver_id')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image'])->find($ride_id);

				$settings = Setting::first();
				$settingValue = json_decode($settings['value']);
				$ride['waiting_time'] = $settingValue->waiting_time;
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
			return response()->json(['status' => 1, 'message' => __('The ride has been cancelled.')]);
		} catch (\Exception $exception) {
			DB::rollBack();
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}
	}

    public function ride_driver_detail(Request $request){
        $ride_detail = Ride::with(['driver', 'vehicle'])->find($request->ride_id);
        if($ride_detail->driver){
            $driver_detail = view('company.rides.driver_detail')->with(['ride_detail' => $ride_detail])->render();
        } else {
            $driver_detail = null;
        }
        return response()->json(['status' => 1, 'message' => "Ride Detail", 'data' => ["driver_detail" => $driver_detail]], $this->successCode);
    }
    
}
