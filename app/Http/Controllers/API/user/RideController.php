<?php

namespace App\Http\Controllers\API\user;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Ride;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RideController extends Controller
{

    public function __construct(Request $request = null)
    {
        $this->successCode = 200;
        $this->errorCode = 401;
        $this->warningCode = 500;
    }

    public function ride_detail(Request $request)
    {
        try {
            $rules = [
                'ride_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
            }
            $ride_detail = Ride::select('id', 'accept_time', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'driver_id', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'status', 'user_id', 'driver_id', 'payment_type')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng'])->find($request->ride_id);
            if ($ride_detail) {
                if (!empty($ride_detail->driver)) {
                    $ride_detail->driver->car_data = $ride_detail->driver->car_data;
                    $ride_detail->driver->avg_rating = $ride_detail->getAvgRating($ride_detail->driver->id);
                }
                return response()->json(['success' => true, 'message' => 'Ride Detail', 'data' => $ride_detail], $this->successCode);
            } else {
                return response()->json(['message' => "Ride doesn't exist"], $this->warningCode);
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }

    public function statusChange(Request $request)
    {
        $logged_in_user = Auth::user();
        $rules = [
            'status' => 'required',
            'ride_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
        }
        try {
            $ride = Ride::find($request->ride_id);

            if (!empty($request->note)) {
                $ride->note = $request->note;
            }

            if (!empty($ride)) {
                if (!empty($ride['driver_id'])) {
                    $driverData = User::find($ride['driver_id']);
                }
                if (!empty($ride['user_id'])) {
                    $userData = User::find($ride['user_id']);
                }
                $deviceToken = $driverData['device_token'] ?? "";
                $deviceType = $driverData['device_type'] ?? "";
                $notification = new Notification();
                if ($request->status == -3) {
                    if ($ride['status'] == -3) {
                        return response()->json(['success' => true, 'message' => "Ride Cancelled already"], $this->successCode);
                    }
                    $title = 'Ride Cancelled';
                    $message = 'Ride Cancelled by User';
                    $notification->title = 'Ride Cancelled';
                    $notification->description = 'Ride Cancelled by you';
                    $type = 6;
                    $ride->status = -3;
                    if (!empty($request->cancel_reason)) {
                        $ride->cancel_reason = $request->cancel_reason;
                    }
                }
            } else {
                return response()->json(['success' => false, 'message' => "No such ride exist"], $this->warningCode);
            }

            $ride->save();

            $ride_detail = Ride::select('id', 'accept_time', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'driver_id', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'status', 'user_id', 'driver_id')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng'])->find($request->ride_id);

            $settings = Setting::first();
            $settingValue = json_decode($settings['value']);
            $ride['waiting_time'] = $settingValue->waiting_time;
            if ($request->status != -1) {
                if (!empty($driverData)) {
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
                    $notification->type = $type;
                    $notification->user_id = $userData['id'];
                    $notification->additional_data = (!empty($additional))?json_encode($additional):null;
                    $notification->save();
                }
            }
            return response()->json(['success' => true, 'message' => $message, 'data' => $ride], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            Log::info($exception->getMessage() . "--" . $exception->getLine());
            return response()->json(['success' => false, 'message' => $exception->getMessage() . "--" . $exception->getLine()], $this->warningCode);
        } catch (\Exception $exception) {
            Log::info($exception->getMessage() . "--" . $exception->getLine());
            return response()->json(['success' => false, 'message' => $exception->getMessage() . "--" . $exception->getLine()], $this->warningCode);
        }
    }
}
