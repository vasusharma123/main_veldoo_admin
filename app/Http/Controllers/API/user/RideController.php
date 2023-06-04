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
use Config;
use Carbon\Carbon;
use App\Http\Resources\RideResource;

class RideController extends Controller
{

    protected $successCode = 200;
    protected $errorCode = 401;
    protected $warningCode = 500;
    protected $limit;

    public function __construct(Request $request = null)
    {
        $this->limit = Config::get('limit_api');
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
            $ride_detail = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])->find($request->ride_id);
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
                    $message = 'The user has cancelled the ride.';
                    $notification->title = 'Ride Cancelled';
                    $notification->description = 'Ride cancelled by you';
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

            $ride_detail = new RideResource(Ride::find($request->ride_id));
            $settings = Setting::first();
            $settingValue = json_decode($settings['value']);
            $ride_detail['waiting_time'] = $settingValue->waiting_time;
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
                    $driver_notification = new Notification();
					$driver_notification->title = $title;
					$driver_notification->description = $message;
					$driver_notification->type = $type;
					$driver_notification->user_id = $driverData['id'];
					$driver_notification->additional_data = json_encode($additional);
					$driver_notification->save();
                }

                if (!empty($userData)) {
                    $notification->type = $type;
                    $notification->user_id = $userData['id'];
                    $notification->additional_data = (!empty($additional)) ? json_encode($additional) : null;
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

    public function ride_list(Request $request)
    {
        try {
            $rules = [
                'type' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
            }
            $userId = Auth::user()->id;
            $user = \App\User::where('id', $userId)->first();
            // $userlogintime = $user->updated_at;
            if (!empty($user)) {
                if ($request->type == 1) {
                    $rides = Ride::where('user_id', $userId)->where(function ($query) {
                        $query->where([['status', '=', 0]])->orWhere([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
                    })->orderBy('ride_time', 'desc')->with('driver')->paginate($this->limit);
                } elseif ($request->type == 2) {
                    // $todayDate = Carbon::today()->format('Y-m-d H:i:s');
                    $rides = Ride::where('user_id', $userId)->where('status', 3)->orderBy('ride_time', 'desc')->with('user', 'driver', 'company_data')->paginate($this->limit);
                } elseif ($request->type == 3) {
                    //$rides=Ride::where('user_id',$userId)->orWhere([['status', '=', -1]])->orWhere([['status', '=', -2]])->orWhere([['status', '=', -3]])->orderBy('id', 'desc')->with('driver')->paginate($this->limit);
                    $rides = Ride::where('user_id', $userId)->where(function ($query) {
                        $query->where([['status', '=', -1]])->orWhere([['status', '=', -2]])->orWhere([['status', '=', -3]]);
                    })->orderBy('ride_time', 'desc')->with('driver')->paginate($this->limit);
                } else if ($request->type == 4) {
                    $rides = Ride::where('user_id', $userId)->where(function ($query) {
                        $query->where([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
                    })->orderBy('ride_time', 'desc')->with('driver')->paginate($this->limit);
                }

                if (!empty($rides)) {
                    foreach ($rides as $ride_key => $ridRow) {
                        if ($ridRow['driver']) {
                            // $rides[$ride_key]['driver']->car_data = $neRide->getCarData($ridRow['driver']->id);
                            $rides[$ride_key]['driver']->car_data = $ridRow['driver']->car_data;
                        }
                    }
                }

                return response()->json(['success' => true, 'message' => 'get successfully', 'data' => $rides], $this->successCode);
            } else {
                return response()->json(['message' => 'Record Not found'], $this->warningCode);
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            $errorCode = $exception->errorInfo[1];
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }
}
