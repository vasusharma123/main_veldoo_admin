<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Ride;
use App\User;
use App\Setting;
use App\Notification;
use App\RideHistory;
use Illuminate\Support\Facades\DB;

class UserWebController extends Controller
{

    public function __construct(Request $request = null)
    {
        $this->successCode = 200;
        $this->errorCode = 401;
        $this->warningCode = 500;
    }

    public function book_ride(Request $request)
    {
        $rules = [
            'country_code' => 'required',
            'phone' => 'required',
            'first_name' => 'required',
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
            $user = User::where(['country_code' => $request->country_code, 'phone' => $request->phone])->first();
            if (!$user) {
                $user = User::create(['country_code' => $request->country_code, 'phone' => $request->phone, 'first_name' => $request->first_name]);
            }

            $ride = new Ride();

            $ride->user_id = $user->id;
            $ride->pickup_address = $request->pickup_address;
            $ride->dest_address = $request->dest_address??"";
            $ride->passanger = $request->passanger;
            $ride->note = $request->note;
            $ride->ride_type = 1;
            $ride->car_type = $request->car_type;
            if (!empty($request->alert_time)) {
                $ride->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('-' . $request->alert_time . ' minutes', strtotime($request->ride_time)));
            }
            $ride->alert_time = $request->alert_time;
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

    public function create_ride_driver(Request $request)
    {
        $rules = [
            'country_code' => 'required',
            'phone' => 'required',
            'first_name' => 'required',
            'pick_lat' => 'required',
            'pick_lng' => 'required',
            'pickup_address' => 'required',
            'car_type' => 'required',
            'ride_time' => 'required',
            'dest_address' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first(), 'error' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $user = User::where(['country_code' => $request->country_code, 'phone' => $request->phone])->first();
            if (!$user) {
                $user = User::create(['country_code' => $request->country_code, 'phone' => $request->phone, 'first_name' => $request->first_name]);
            }
            $ride = new Ride();
            $ride->user_id = $user->id;
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
            $ride->created_by = $user->id;
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
                    $notification_data[] = ['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $driverid, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
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
}