<?php

namespace App\Http\Controllers\API\user;

use App\Http\Controllers\Controller;
use App\Rating;
use App\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $ride_detail = Ride::select('id', 'accept_time', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'driver_id', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'status', 'user_id', 'driver_id')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng'])->find($request->ride_id);
            if ($ride_detail) {
                if(!empty($ride_detail->driver)){
                    $ride_detail->driver->car_data = $ride_detail->driver->car_data;
                    $avgrating = Rating::where(['to_id' => $ride_detail->driver->id])->avg('rating');
                    $ride_detail->driver->avg_rating = (!empty($avgrating)) ? round($avgrating, 2) : 0;
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
}
