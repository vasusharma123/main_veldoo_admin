<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Ride;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Setting;
use App\Notification;
use App\RideHistory;
use Illuminate\Support\Facades\DB;

class RideController extends Controller
{
   /**
     * Created By Anil Dogra
     * Created At 28-07-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object after send reset password token
     * This function use to list of latest ride detail
     */

    protected $successCode = 200;
    protected $errorCode = 401;
    protected $warningCode = 500;

    public function latest_ride_detail(Request $request)
    {
        $userObj = Auth::user();
        if (!$userObj) {
            return $this->notAuthorizedResponse('User is not authorized');
        }
        $ride = Ride::with(['user', 'driver', 'company_data'])->where('driver_id', $userObj->id)->where(function ($query) {
            $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
        })->orderBy('ride_time')->get();
        return $this->successResponse($ride, 'Get latest ride successfully');
    }
    /**
     * Created By Anil Dogra
     * Created At 28-07-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object after send reset password token
     * This function use to list of latest ride detail
     */
 
    public function driverUpdateLocation(Request $request){
      
        $userObj = Auth::user();
         
        if (!$userObj) {
            return $this->notAuthorizedResponse('User is not authorized');
        }
         
         $rules = [
            'latitude' => 'required',
            'longitude' => 'required',
          
        ];
        
        $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $validateerror = $validator->errors()->all();
            return $this->validationErrorResponse($validateerror[0]);
        }

          $updateUser['current_lat']=($inputArr['latitude'])?$inputArr['latitude']:null;
          $updateUser['current_lng']=($inputArr['longitude'])?$inputArr['longitude']:null;
              
        $hasUpdate = $userObj->updateUser($userObj->id, $updateUser);  
          
          if($hasUpdate){

              return $this->successResponse([], 'Location updated successfully!');
            }
        
        return $this->notAuthorizedResponse('Something went wrong.');


    }

    public function getRideList(Request $request,Ride $rides){
        $userObj = Auth::user();
         // print_r($userObj);die;
        if (!$userObj) {
            return $this->notAuthorizedResponse('User is not authorized');
        }
                 
         $rules = [
            'type' => 'required',
            // 'longitude' => 'required',
          
        ];
        
        $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $validateerror = $validator->errors()->all();
            return $this->validationErrorResponse($validateerror[0]);
        }
         $inputArr = $request->all();
        $typeArr=array(1,2,3);
        if(!in_array($inputArr['type'],$typeArr)){
            return $this->validationErrorResponse('Please enter valid type.');
        }
       
        $limit = 10;  //set  Number of entries to show in a page.
            // Look for a GET variable page if not found default is 1.        
            if (isset($inputArr["page"])) {    
            $page  = $inputArr["page"];    
            }    
            else { $page=1;    
            }
          //determine the sql LIMIT starting number for the results on the displaying page  
            $inputArr['page_index'] = ($page-1) * $limit;      // 0
             $inputArr['limit'] = $limit;
            $queryData=$rides->getRideHistory($userObj,$inputArr);

            $currentData = array();
        foreach ($queryData as $value) {
            $data = $value->getRideList();
            array_push($currentData,(object)$data);
        }

        $user_count=count($currentData); 
                
            $total_records = $user_count;   //9
            $total_pages = ceil($total_records / $limit); 
        $arrayData=array('data_count'=>$user_count,'total'=>$total_pages,'per_page'=>$limit,'current_page'=>$page,'data'=>$currentData);   

             return $this->successResponse($arrayData, 'Get ride list successfully');  
    }

    public function upcoming_rides_count(){
        $userObj = Auth::user();
        $current_time = Carbon::now()->toDateTimeString();
        $after12Hours = Carbon::now()->addHours(12)->toDateTimeString();
        $rides_count = Ride::whereIn('status', [0,1,2,4])->whereBetween('ride_time', [$current_time, $after12Hours])->count();
        return response()->json(['message' => 'Count of upcoming rides in next 12 hrs', 'data' => ['rides_count' => $rides_count]], $this->successCode);
    }

    public function unassign_current_ride(Request $request)
    {
        $userObj = Auth::user();
        $rules = [
            'ride_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
        }
        $ride = Ride::find($request->ride_id);
        if ($ride->driver_id != $userObj->id) {
            return response()->json(['message' => "This ride doesn't belong to you"], $this->warningCode);
        }

        DB::beginTransaction();
        $ride->driver_id = null;
        $ride->driver_id = null;
        $ride->save();

        try {
            $settings = Setting::first();
            $settingValue = json_decode($settings['value']);
            $driverlimit = $settingValue->driver_requests;
            $driver_radius = $settingValue->radius;
            if (!empty($ride->pick_lat) && !empty($ride->pick_lng)) {
                $lat = $ride->pick_lat;
                $lon = $ride->pick_lng;
                $query = User::select(
                    "users.*",
                    DB::raw("3959 * acos(cos(radians(" . $lat . ")) 
                        * cos(radians(users.current_lat)) 
                        * cos(radians(users.current_lng) - radians(" . $lon . ")) 
                        + sin(radians(" . $lat . ")) 
                        * sin(radians(users.current_lat))) AS distance")
                );
            } else {
                $query = new User;
            }

            $query = $query->with(['ride' => function ($query1) {
                $query1->where(['waiting' => 0]);
                $query1->where(function ($query2) {
                    $query2->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                });
            }])->with(['all_rides' => function ($query3) {
                $query3->where(['status' => 1, 'waiting' => 1]);
            }])->where([['user_type', '=', 2], ['availability', '=', 1]])->orderBy('distance', 'asc');
            $drivers = $query->get()->toArray();

            $rideObj = new Ride;
            foreach ($drivers as $driver_key => $driver_value) {
                if (!empty($driver_value['ride'])) {
                    if (!empty($driver_value['ride']['dest_lat'])) {
                        if ($driver_value['ride']['status'] == 1) {
                            $drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($driver_value['current_lat'], $driver_value['current_lng'], $driver_value['ride']['pick_lat'], $driver_value['ride']['pick_lng']);
                        }
                        $drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($driver_value['ride']['pick_lat'], $driver_value['ride']['pick_lng'], $driver_value['ride']['dest_lat'], $driver_value['ride']['dest_lng']);
                    } else {
                        $drivers[$driver_key]['distance'] += $settingValue->current_ride_distance_addition ?? 10;
                    }
                }
                if (!empty($driver_value['all_rides'])) {
                    foreach ($driver_value['all_rides'] as $waiting_ride_key => $waiting_ride_value) {
                        if (!empty($driver_value['ride']['dest_lat'])) {
                            $drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($driver_value['current_lat'], $driver_value['current_lng'], $waiting_ride_value['pick_lat'], $waiting_ride_value['pick_lng']);
                            $drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($waiting_ride_value['pick_lat'], $waiting_ride_value['pick_lng'], $waiting_ride_value['dest_lat'], $waiting_ride_value['dest_lng']);
                        } else {
                            $drivers[$driver_key]['distance'] += $settingValue->waiting_ride_distance_addition ?? 15;
                        }
                    }
                }
            }

            usort($drivers, 'sortByDistance');

            $driverids = array();

            if (!empty($drivers)) {
                for ($i = 0; $i < $driverlimit; $i++) {
                    if (!empty($drivers[$i])) {
                        $driverids[] = $drivers[$i]['id'];
                    }
                }
            } else {
                return response()->json(['message' => "No Driver Found"], $this->warningCode);
            }

            $ride->driver_id = null;
            $ride->all_drivers = implode(",", $driverids);
            $ride->platform = Auth::user()->device_type;
            $ride->save();
            $ride_data = Ride::query()->find($ride->id);

            $user_data = User::select('id', 'first_name', 'last_name', 'image', 'country_code', 'phone', 'user_type')->find($ride_data['user_id']);
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
            $rideData->alert_send = 0;
            if (count($overallDriversCount) <= count($drivers)) {
                $rideData->alert_send = 1;
            }
            $rideData->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('+' . $settingValue->waiting_time . ' seconds ', strtotime(Carbon::now()->toDateTimeString())));
            $rideData->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Ride rejected successfully', 'data' => $ride], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            return response()->json(['message' => $exception->getMessage()], 401);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['message' => $exception->getMessage()], 401);
        }
    }

}
