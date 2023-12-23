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
use Config;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\RideResource;

class RideController extends Controller
{
   /**
     * @var $request object of request class
     * @var $user object of user class
     * @return object after send reset password token
     * This function use to get on going ride
     */

    protected $successCode = 200;
    protected $errorCode = 401;
    protected $warningCode = 500;
    protected $limit;
    protected $calendar_rides_limit = 80;
    protected $calendar_rides_limit_exceed = 160;

    public function __construct(Request $request = null)
	{
		$this->limit = Config::get('limit_api');
	}

    public function latest_ride_detail(Request $request)
    {
        $userObj = Auth::user();
        if (!$userObj) {
            return $this->notAuthorizedResponse('User is not authorized');
        }
        $ride = Ride::with(['user', 'driver', 'company_data'])
        ->where('driver_id', $userObj->id)
            ->where(function ($query) {
                $query->where(['status' => 1])
                    ->orWhere(['status' => 2])
                    ->orWhere(['status' => 4]);
            })->where('service_provider_id', $userObj->service_provider_id)->orderBy('ride_time')->get();
        return $this->successResponse($ride, 'Get latest ride successfully');
    }

    /* This function is used to get the latest ongoing ride details on behalf of the user */

    public function onGoingRide(Request $request)
    {
        try {
            $userObj = Auth::user();
            $rides = Ride::where('user_id', $userObj->id)
                ->where(function ($query) {
                    $query->where(['status' => 1])
                        ->orWhere(['status' => 2])
                        ->orWhere(['status' => 4]);
                })->orderBy('ride_time')
                ->first();
            if ($rides) {
                $ride = new RideResource(Ride::find($rides->id));
                return $this->successResponse($ride, 'On-going ride detail');
            } else {
                return $this->successResponse($rides, 'No on-going ride was found');
            }
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
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
        $updateUser['last_driver_location_update_time']= Carbon::now();

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
        $rides_count = Ride::whereIn('status', [0,1,2,4])->whereBetween('ride_time', [$current_time, $after12Hours]);
        if($userObj->service_provider_id)
        {
            $rides_count->where('service_provider_id',$userObj->service_provider_id);
        }
        $rides_count = $rides_count->count();
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
        // DB::beginTransaction();

        $ride = Ride::find($request->ride_id);
        if ($ride->driver_id != $userObj->id) {
            return response()->json(['message' => "This ride doesn't belong to you"], $this->warningCode);
        }

        $ride->driver_id = null;
        $ride->status = 0;
        $ride->all_drivers = 0;
        $ride->save();

        RideHistory::where(['ride_id' => $ride->id])->delete();

        try {
            $settings = Setting::where('service_provider_id',$userObj->service_provider_id)->first();
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
            }])->where([['user_type', '=', 2], ['availability', '=', 1]])->where('service_provider_id',$userObj->service_provider_id)->orderBy('distance', 'asc');
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
            $ride_data = new RideResource(Ride::find($ride->id));

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
            $rideData->alert_send = 0;
            if (count($overallDriversCount) <= count($drivers)) {
                $rideData->alert_send = 1;
            }
            $rideData->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('+' . $settingValue->waiting_time . ' seconds ', strtotime(Carbon::now()->toDateTimeString())));
            $rideData->save();
            DB::commit();
            $ride_detail = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])->find($request->ride_id);
            return response()->json(['success' => true, 'message' => 'Ride rejected successfully', 'data' => $ride_detail], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            return response()->json(['message' => $exception->getMessage()], 401);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['message' => $exception->getMessage()], 401);
        }
    }

    public function RideList(Request $request)
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
            $user = User::find($userId);
            $todayDate = Carbon::today()->format('Y-m-d H:i:s');
            if (!empty($user)) {
                if ($request->type == 1) {
                    if ($user->is_master == 1) {
                        // $ownrideswaiting = Ride::where(['driver_id' => $userId, 'waiting' => 1])->where(function ($query) {
                        //     $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                        // })->whereDate('rides.ride_time', '>=', $todayDate)->orderBy('ride_time', 'asc')->orderBy('status', 'asc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);

                        $globalRideswaiting = Ride::where(['waiting' => 1])->where(function ($query) {
                            $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                        })->where(function($query){
                            $query->whereNotNull('driver_id')->orWhere('driver_id','!=','');
                        })->whereDate('rides.ride_time', '>=', $todayDate)->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'asc')->orderBy('status', 'asc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);

                        $globalridespending = Ride::where(['status' => -4])->whereDate('rides.ride_time', '>=', $todayDate)->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'asc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);

                        $overallPendingRides = Ride::where(['status' => 0])->where(function ($query) use ($user) {
                            $query->whereNull('driver_id')
                            ->orWhere(['driver_id' => $user->id]);
                        })->whereDate('rides.ride_time', '>=', $todayDate)->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'asc')->orderBy('status', 'asc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);

                        $othersFuturePendingRides = Ride::where(['status' => 0])->where(function ($query) use ($user) {
                            $query->where('driver_id', '!=', $user->id);
                        })->whereDate('rides.ride_time', '>=', $todayDate)->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'asc')->orderBy('status', 'asc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);

                        $rides = array();
                        $newarray = array();
                        $rides[0] = $globalRideswaiting;
                        $rides[1] = $globalridespending;
                        $rides[2] = $overallPendingRides;
                        $rides[3] = $othersFuturePendingRides;
                        foreach ($rides as $ridedata) {
                            if (!empty($ridedata)) {
                                foreach ($ridedata as $datanew) {
                                    $newarray[] = $datanew;
                                }
                            }
                        }
                        $rides = $newarray;
                    } else {
                        $rides = Ride::whereDate('rides.ride_time', '>=', $todayDate)->where(function ($query) use ($userId) {
                            $query->where([['status', '=', 0]]);
                            $query->orWhere(function ($query1) use ($userId) {
                                $query1->where('driver_id', $userId);
                                $query1->where(['status' => 1, 'waiting' => 1]);
                            });
                            $query->orWhere(function ($query1) use ($userId) {
                               // $query1->where('creator_id', $userId);
                                $query1->where(['status' => -4]);
                            });
                        })->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'asc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);
                    }
                } elseif ($request->type == 2) {
                    if ($user->is_master == 1) {
                        $rides = Ride::where('status', 3)->whereDate('rides.ride_time', '>=', $todayDate)->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'desc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);
                    } else {
                        $rides = Ride::where('driver_id', $userId)->whereDate('rides.ride_time', '>=', $todayDate)->where('status', 3)->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'desc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);
                    }
                } elseif ($request->type == 3) {
                    if ($user->is_master == 1) {
                        // if ($request->master_driver == 1) {
                        //     $rides = Ride::whereDate('rides.ride_time', '>=', $todayDate)
                        //         ->where(function ($query) use ($userId) {
                        //             $query->where(function ($query1) use ($userId) {
                        //                 $query1->where('driver_id', $userId);
                        //                 $query1->whereIn('status', [-2]);
                        //             });
                        //             $query->orWhere(function ($query1) {
                        //                 $query1->where(['status' => -3]);
                        //             });
                        //         })->orderBy('ride_time', 'desc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);
                        // } else {
                            $rides = Ride::whereDate('rides.ride_time', '>=', $todayDate)->where(function ($query) {
                                $query->whereIn('status', [-2]);
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })->where(['service_provider_id' => $user->service_provider_id])->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);
                        // }
                    } else {
                        //$rides=Ride::where('driver_id',$userId)->orWhere([['status', '=', -1]])->orWhere([['status', '=', -2]])->orWhere([['status', '=', -3]])->orderBy('id', 'desc')->with('user')->paginate($this->limit);
                        $rides = Ride::whereDate('rides.ride_time', '>=', $todayDate)
                            ->where(function ($query) use ($userId) {
                                $query->where(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->whereIn('status', [-2]);
                                });
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'desc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);
                    }
                } else if ($request->type == 4) {
                    if ($user->is_master == 1) {
                        // $myOngoingRides = Ride::where(['driver_id' => $userId, 'waiting' => 0])->where(function ($query) {
                        //     $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                        // })->orderBy('ride_time', 'desc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);

                        $overallOngoingRides = Ride::whereNotNull('driver_id')->where(['waiting' => 0])->where(function ($query) {
                            $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                        })->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'desc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);

                        $rides = array();
                        $newarray = array();
                        // if ($request->master_driver == 1) {
                        //     $rides[0] = $myOngoingRides;
                        // } else {
                            $rides[0] = $overallOngoingRides;
                        // }
                        foreach ($rides as $ridedata) {
                            if (!empty($ridedata)) {
                                foreach ($ridedata as $datanew) {
                                    $newarray[] = $datanew;
                                }
                            }
                        }
                        $rides = $newarray;
                    } else {
                        $rides = Ride::where('driver_id', $userId)->whereDate('rides.ride_time', '>=', $todayDate)->where(function ($query) {
                            $query->where([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
                        })->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'desc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->paginate($this->limit);
                    }
                } elseif ($request->type == 5) {
                    if ($user->is_master == 1) {
                        if ($request->master_driver == 1) {
                            $rides = Ride::query()->whereDate('rides.ride_time', '>=', $todayDate)->where([['status', '=', 0], ['ride_type', '>', 1]])->whereRaw('FIND_IN_SET(?,driver_id)', [$userId])->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'desc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->limit(1)->paginate(1);
                        } else {
                            $rides = Ride::query()->whereDate('rides.ride_time', '>=', $todayDate)->where([['status', '=', -4], ['ride_type', '>', 1]])->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'desc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->limit(1)->paginate(1);
                        }
                    } else {
                        $rides = Ride::query()->whereDate('rides.ride_time', '>=', $todayDate)->where([['status', '=', 0], ['ride_type', '>', 1]])->whereRaw('FIND_IN_SET(?,driver_id)', [$userId])->where(['service_provider_id' => $user->service_provider_id])->orderBy('ride_time', 'desc')->with(['user', 'driver', 'company_data', 'vehicle_category:id,car_type,car_image'])->limit(1)->paginate(1);
                    }
                }
                if (!empty($rides)) {
                    foreach ($rides as $ride_key => $ridRow) {
                        if ($ridRow['driver']) {
                            $rides[$ride_key]['driver']->car_data = $ridRow['driver']->car_data;
                        }
                    }
                }
                if ($request->type == 1 || $request->type == 4) {
                    if ($user->user_type == 2 && $user->is_master == 1) {
                        $datarides['current_page'] = 1;
                        $total = count($rides);
                        $datarides['data'] = $rides;
                        $datarides['per_page'] = 20;
                        $datarides['last_page'] = 1;
                        $datarides['total'] = $total;

                        return response()->json(['success' => true, 'message' => 'get successfully', 'data' => $datarides], $this->successCode);
                    } else {
                        return response()->json(['success' => true, 'message' => 'get successfully', 'data' => $rides], $this->successCode);
                    }
                } else {
                    return response()->json(['success' => true, 'message' => 'get successfully', 'data' => $rides], $this->successCode);
                }
            } else {
                return response()->json(['message' => 'Record Not found'], $this->warningCode);
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }

    public function delete(Request $request)
    {
        $rules = [
            'ride_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
        }
        try {
            $user = Auth::user()->id;
            $rideDetail = Ride::find($request->ride_id);
            $rideObj = new Ride;
            if (!empty($request->delete_for_all) && $request->delete_for_all == 1 && !empty($rideDetail->parent_ride_id)) {
                $rideObj = $rideObj->where(['parent_ride_id' => $rideDetail->parent_ride_id])->where('ride_time', '>', Carbon::now())->whereNotIn('status', [1, 2, 3, 4]);
            } else {
                $rideObj = $rideObj->where('id', $request->ride_id);
            }
            $rideObj->delete();
            return response()->json(['success' => true, 'message' => 'Ride deleted successfully.'], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }

    /* FInalise API for android calendar */

    public function calendarBasedRides(Request $request)
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
            $user = User::find($userId);
            if (!empty($request->date)) {
                $startDate = $request->date . " 00:00:00";
            } else {
                $startDate = Carbon::today()->format('Y-m-d H:i:s');
            }
            $rides = [];
            $previous_available_ride = 0;
            $next_available_ride = 0;
            $take = $this->calendar_rides_limit;
            if (!empty($request->page) && $request->page > 0) {
                $skip = ($request->page) * $this->calendar_rides_limit;
                $nextskip = ($request->page+1) * $this->calendar_rides_limit;
                $prevSkip = ($request->page-1) * $this->calendar_rides_limit;
                $compareVariable = ">=";
                $nextCompareVariable = ">=";
                $prevCompareVariable = ">=";
                $ride_order = "asc";
            } else if (!empty($request->page) && $request->page < 0) {
                $skip = (abs($request->page)-1) * $this->calendar_rides_limit;
                $prevSkip = (abs($request->page)) * $this->calendar_rides_limit;
                $compareVariable = "<";
                $prevCompareVariable = "<";
                $ride_order = "desc";
                if($request->page == -1){
                    $nextskip = 0;
                    $nextCompareVariable = ">=";
                } else {
                    $nextskip = (abs($request->page)-2) * $this->calendar_rides_limit;
                    $nextCompareVariable = "<";
                }
            } else {
                $skip = 0;
                $nextskip = $this->calendar_rides_limit;
                $prevSkip = 0;
                $compareVariable = ">=";
                $nextCompareVariable = ">=";
                $prevCompareVariable = "<";
                $ride_order = "asc";
            }

            if (!empty($user)) {
                if ($request->type == 1) {
                    if ($user->is_master == 1) {
                        $rides = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where(function ($query) use ($user) {
                                $query->where(['status' => -4])->orWhere(['status' => 0]);
                                $query->orWhere(function ($query1) use ($user) {
                                    $query1->whereNotNull('driver_id')->where(['waiting' => 1])->where(function ($query2) {
                                        $query2->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                                    });
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                        $futureRides = Ride::whereDate('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where(function ($query) use ($user) {
                                $query->where(['status' => -4])->orWhere(['status' => 0]);
                                $query->orWhere(function ($query1) use ($user) {
                                    $query1->whereNotNull('driver_id')->where(['waiting' => 1])->where(function ($query2) {
                                        $query2->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                                    });
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->get();
                        $next_available_ride = (!empty($futureRides) && count($futureRides) > 0) ? 1 : 0;
                        $pastRides = Ride::whereDate('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where(function ($query) use ($user) {
                                $query->where(['status' => -4])->orWhere(['status' => 0]);
                                $query->orWhere(function ($query1) use ($user) {
                                    $query1->whereNotNull('driver_id')->where(['waiting' => 1])->where(function ($query2) {
                                        $query2->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                                    });
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->get();
                        $previous_available_ride = (!empty($pastRides) && count($pastRides) > 0) ? 1 : 0;
                    } else {
                        $rides = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                               // $query->where([['status', '=', 0]])->orwhere([['status', '=', -4]]);
                                $query->whereIn('status', [0,-4]);
                                $query->orWhere(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->where(['status' => 1, 'waiting' => 1]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        $futureRides = Ride::whereDate('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->where([['status', '=', 0]]);
                                $query->orWhere(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->where(['status' => 1, 'waiting' => 1]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->count();
                        $next_available_ride = $futureRides ? 1 : 0;
                        $pastRides = Ride::whereDate('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->where([['status', '=', 0]]);
                                $query->orWhere(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->where(['status' => 1, 'waiting' => 1]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->count();
                        $previous_available_ride = $pastRides ? 1 : 0;
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                    }
                } elseif ($request->type == 2) {
                    if ($user->is_master == 1) {
                        $rides = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                        $futureRides = Ride::whereDate('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->get();
                        $next_available_ride = (!empty($futureRides) && count($futureRides) > 0) ? 1 : 0;
                        $pastRides = Ride::whereDate('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->get();
                        $previous_available_ride = (!empty($pastRides) && count($pastRides) > 0) ? 1 : 0;
                    } else {
                        $rides = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where('driver_id', $userId)->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        $futureRides = Ride::whereDate('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where('driver_id', $userId)->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->count();
                        $next_available_ride = $futureRides ? 1 : 0;
                        $pastRides = Ride::whereDate('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where('driver_id', $userId)->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->count();
                        $previous_available_ride = $pastRides ? 1 : 0;
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                    }
                } elseif ($request->type == 3) {
                    if ($user->is_master == 1) {
                        $rides = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where(function ($query) {
                                $query->whereIn('status', [-2]);
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                        $futureRides = Ride::whereDate('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where(function ($query) {
                                $query->whereIn('status', [-2]);
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->get();
                        $next_available_ride = (!empty($futureRides) && count($futureRides) > 0) ? 1 : 0;
                        $pastRides = Ride::whereDate('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where(function ($query) {
                                $query->whereIn('status', [-2]);
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->get();
                        $previous_available_ride = (!empty($pastRides) && count($pastRides) > 0) ? 1 : 0;
                    } else {
                        $rides = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->where(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->whereIn('status', [-2]);
                                });
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        $futureRides = Ride::whereDate('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->where(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->whereIn('status', [-2]);
                                });
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->count();
                        $next_available_ride = $futureRides ? 1 : 0;
                        $pastRides = Ride::whereDate('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->where(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->whereIn('status', [-2]);
                                });
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->count();
                        $previous_available_ride = $pastRides ? 1 : 0;
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                    }
                } else if ($request->type == 4) {
                    if ($user->is_master == 1) {
                        $rides = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->whereNotNull('driver_id')->where(['waiting' => 0])->where(function ($query) {
                                $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                        $futureRides = Ride::whereDate('rides.ride_time', $nextCompareVariable, $startDate)
                            ->whereNotNull('driver_id')->where(['waiting' => 0])->where(function ($query) {
                                $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->get();
                        $next_available_ride = (!empty($futureRides) && count($futureRides) > 0) ? 1 : 0;
                        $pastRides = Ride::whereDate('rides.ride_time', $prevCompareVariable, $startDate)
                            ->whereNotNull('driver_id')->where(['waiting' => 0])->where(function ($query) {
                                $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->get();
                        $previous_available_ride = (!empty($pastRides) && count($pastRides) > 0) ? 1 : 0;
                    } else {
                        $rides = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where('driver_id', $userId)->where(['waiting' => 0])->where(function ($query) {
                                $query->where([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        $futureRides = Ride::whereDate('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where('driver_id', $userId)->where(['waiting' => 0])->where(function ($query) {
                                $query->where([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->count();
                        $next_available_ride = $futureRides ? 1 : 0;
                        $pastRides = Ride::whereDate('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where('driver_id', $userId)->where(['waiting' => 0])->where(function ($query) {
                                $query->where([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->count();
                        $previous_available_ride = $pastRides ? 1 : 0;
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                    }
                } else if ($request->type == 5) {
                    if ($user->is_master == 1) {
                        $rides = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                        ->where(['service_provider_id' => $user->service_provider_id])
                        ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                        $futureRides = Ride::whereDate('rides.ride_time', $nextCompareVariable, $startDate)
                        ->where(['service_provider_id' => $user->service_provider_id])    
                        ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->get();
                        $next_available_ride = (!empty($futureRides) && count($futureRides) > 0) ? 1 : 0;
                        $pastRides = Ride::whereDate('rides.ride_time', $prevCompareVariable, $startDate)
                        ->where(['service_provider_id' => $user->service_provider_id])    
                        ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->get();
                        $previous_available_ride = (!empty($pastRides) && count($pastRides) > 0) ? 1 : 0;
                    } else {
                        $rides = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                        ->where(function ($query) use ($userId) {
                            $query->where(function ($query) use ($userId) {
                                $query->orWhere('status', 0);
                                $query->orWhere('driver_id', $userId);
                            })
                            ->orWhere('status', -4);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        $futureRides = Ride::whereDate('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->orWhere('status', 0);
                                $query->orWhere('driver_id', $userId);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->count();
                        $next_available_ride = $futureRides ? 1 : 0;
                        $pastRides = Ride::whereDate('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->orWhere('status', 0);
                                $query->orWhere('driver_id', $userId);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->count();
                        $previous_available_ride = $pastRides ? 1 : 0;
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                    }
                }
                if(!empty($rides)){
                    foreach ($rides as $ride_key => $ride_value) {
                        if(!empty($rides[$ride_key]->driver)){
                            $rides[$ride_key]->driver->car_data = $ride_value->driver->car_data;
                        }
                    }
                }
                return response()->json(['success' => true, 'message' => 'Rides List', 'data' => $rides, 'next_available_ride' => $next_available_ride, 'previous_available_ride' => $previous_available_ride], $this->successCode);
            } else {
                return response()->json(['message' => 'Record Not found'], $this->warningCode);
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }

    public function cancel_ride(Request $request)
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
            $previousRideData = Ride::find($request->ride_id);
            $ride = Ride::find($request->ride_id);

            if (!empty($ride)) {
                $userdata = User::find($ride['user_id']);
                $driverData = User::find($ride['driver_id']);
                $deviceToken = $userdata['device_token'] ?? "";
                $deviceType = $userdata['device_type'] ?? "";
                $title = 'Ride Cancelled';
                $message = "Ride Cancelled Successfully";
                $type = 5;
                if ($request->status == -2) {
                    if ($ride['status'] == -2) {
                        return response()->json(['success' => true, 'message' => "Ride Cancelled already"], $this->successCode);
                    }
                    if (!empty($request->delete_for_all) && $request->delete_for_all == 1 && !empty($ride->parent_ride_id)) {
                        Ride::where(['parent_ride_id' => $ride->parent_ride_id])->where('ride_time', '>', Carbon::now())->update(['note' => $request->note ?? "", 'status' => '-2', 'updated_at' => Carbon::now()]);
                    } else {
                        $rideObj = Ride::find($request->ride_id);
                        $rideObj->note = $request->note ?? "";
                        $rideObj->status = -2;
                        $rideObj->save();
                    }
                    $ride_detail = new RideResource(Ride::find($request->ride_id));
                    $settings = Setting::where('service_provider_id',$ride->service_provider_id)->first();
                    if($settings)
                    {
                        $settingValue = json_decode($settings['value']);
                        $ride_detail['waiting_time'] = $settingValue->waiting_time;
                        if (!empty($userdata)) {
                            $additional = ['type' => $type, 'ride_id' => $ride->id, 'ride_data' => $ride_detail];
                            if (!empty($deviceToken)) {
                                if ($deviceType == 'android') {
                                    bulk_firebase_android_notification($title, $message, [$deviceToken], $additional);
                                }
                                if ($deviceType == 'ios') {
                                    bulk_pushok_ios_notification($title, $message, [$deviceToken], $additional, $sound = 'default', $userdata['user_type']);
                                }
                            }

                            $notification = new Notification();
                            $notification->title = $title;
                            $notification->description = $message;
                            $notification->type = $type;
                            $notification->user_id = $userdata['id'];
                            $notification->additional_data = json_encode($additional);
                            $notification->save();
                        }
                        if (!empty($driverData) && $previousRideData->status != 0) {
                            $deviceToken = $driverData['device_token'] ?? "";
                            $deviceType = $driverData['device_type'] ?? "";
                            $title = 'Ride Cancelled';
                            $message = "Your ride has been cancelled.";
                            $type = 5;

                            $additional = ['type' => $type, 'ride_id' => $ride->id, 'ride_data' => $ride_detail];
                            if (!empty($deviceToken)) {
                                if ($deviceType == 'android') {
                                    bulk_firebase_android_notification($title, $message, [$deviceToken], $additional);
                                }
                                if ($deviceType == 'ios') {
                                    bulk_pushok_ios_notification($title, $message, [$deviceToken], $additional, $sound = 'default', $driverData['user_type']);
                                }
                            }

                            $notification = new Notification();
                            $notification->title = $title;
                            $notification->description = $message;
                            $notification->type = $type;
                            $notification->user_id = $driverData->id;
                            $notification->additional_data = json_encode($additional);
                            $notification->save();
                        }
                    }
                    return response()->json(['success' => true, 'message' => $message, 'data' => $ride_detail], $this->successCode);
                }
            } else {
                return response()->json(['success' => false, 'message' => "No such ride exist"], $this->warningCode);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            Log::info('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $e->getLine(). ' --- ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], $this->warningCode);
        } catch (\Exception $e) {
            Log::info('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $e->getLine(). ' --- ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], $this->warningCode);
        }
    }

    public function update_ride_address(Request $request)
    {
        $logged_in_user = Auth::user();
        $rules = [
            'ride_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
        }
        try {
            DB::beginTransaction();
            $rideDetail = Ride::find($request->ride_id);

            if (!empty($rideDetail)) {
                if (!empty($request->pick_lat)) {
                    $rideDetail->pick_lat = $request->pick_lat;
                }
                if (!empty($request->pick_lng)) {
                    $rideDetail->pick_lng = $request->pick_lng;
                }
                if (!empty($request->pickup_address)) {
                    $rideDetail->pickup_address = $request->pickup_address;
                }
                if (!empty($request->dest_lat)) {
                    $rideDetail->dest_lat = $request->dest_lat;
                }
                if (!empty($request->dest_lng)) {
                    $rideDetail->dest_lng = $request->dest_lng;
                }
                if (!empty($request->dest_address)) {
                    $rideDetail->dest_address = $request->dest_address;
                }
                $rideDetail->save();
                DB::commit();
                $userdata = User::find($rideDetail['driver_id']);
                $deviceToken = $userdata['device_token'] ?? "";
                $deviceType = $userdata['device_type'] ?? "";
                $title = 'Pickup Location Changed';
                $message = "The pickup location for your ride has been changed";
                $type = 16;
                if (!empty($request->dest_address)) {
                    $title = 'Destination Location Changed';
                    $message = "The destination location for your ride has been changed.";
                    $type = 16;
                }
                $rideResponse = new RideResource(Ride::find($request->ride_id));
                if (!empty($userdata)) {
                    $settings = Setting::where(['service_provider_id' => $rideDetail->service_provider_id])->first();
                    $settingValue = json_decode($settings['value']);
                    $rideResponse['waiting_time'] = $settingValue->waiting_time;

                    $additional = ['type' => $type, 'ride_id' => $request->ride_id, 'ride_data' => $rideResponse];
                    if (!empty($deviceToken)) {
                        if ($deviceType == 'android') {
                            bulk_firebase_android_notification($title, $message, [$deviceToken], $additional);
                        }
                        if ($deviceType == 'ios') {
                            bulk_pushok_ios_notification($title, $message, [$deviceToken], $additional, $sound = 'default', $userdata['user_type']);
                        }
                    }

                    $notification = new Notification();
                    $notification->title = $title;
                    $notification->description = $message;
                    $notification->type = $type;
                    $notification->user_id = $userdata['id'];
                    $notification->additional_data = json_encode($additional);
                    $notification->service_provider_id = $rideDetail->service_provider_id;
                    $notification->save();
                }
                return response()->json(['success' => true, 'message' => $message, 'data' => $rideResponse], $this->successCode);
            } else {
                return response()->json(['success' => false, 'message' => "No such ride exist"], $this->warningCode);
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();
            Log::info($exception->getMessage() . "--" . $exception->getLine());
            return response()->json(['success' => false, 'message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            DB::rollback();
            Log::info($exception->getMessage() . "--" . $exception->getLine());
            return response()->json(['success' => false, 'message' => $exception->getMessage()], $this->warningCode);
        }
    }

    public function calendarViewRidesUpDownLimited(Request $request)
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
            $user = User::find($userId);
            if (!empty($request->date)) {
                if (!empty($request->time)) {
                    $startDate = $request->date . " " . $request->time;
                } else {
                    $startDate = $request->date . " 00:00:00";
                }
            } else {
                $startDate = Carbon::today()->format('Y-m-d H:i:s');
            }
            $rides = [];
            $previous_available_ride = 0;
            $next_available_ride = 0;
            $take = $this->calendar_rides_limit_exceed;
            if (!empty($request->page) && $request->page > 1) {
                $skip = ($request->page-1) * $this->calendar_rides_limit_exceed;
                $nextskip = ($request->page) * $this->calendar_rides_limit_exceed;
                $prevSkip = ($request->page-2) * $this->calendar_rides_limit_exceed;
                $compareVariable = ">=";
                $nextCompareVariable = ">=";
                $prevCompareVariable = ">=";
                $ride_order = "asc";
            } else if (!empty($request->page) && $request->page < 0) {
                $skip = (abs($request->page)-1) * $this->calendar_rides_limit_exceed;
                $prevSkip = (abs($request->page)) * $this->calendar_rides_limit_exceed;
                $compareVariable = "<";
                $prevCompareVariable = "<";
                $ride_order = "desc";
                if($request->page == -1){
                    $nextskip = 0;
                    $nextCompareVariable = ">=";
                } else {
                    $nextskip = (abs($request->page)-2) * $this->calendar_rides_limit_exceed;
                    $nextCompareVariable = "<";
                }
            } else {
                $skip = 0;
                $nextskip = $this->calendar_rides_limit_exceed;
                $prevSkip = 0;
                $compareVariable = ">=";
                $nextCompareVariable = ">=";
                $prevCompareVariable = "<";
                $ride_order = "asc";
            }

            if (!empty($user)) {
                if ($request->type == 1) {
                    if ($user->is_master == 1) {
                        $rides = Ride::select('id', 'pickup_address', 'dest_address', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'driver_id', 'payment_type', 'parent_ride_id', 'created_at', 'note', 'car_type')->with(['driver:id,first_name,last_name,country_code,phone,image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where(function ($query) use ($user) {
                                $query->where(['status' => -4])->orWhere(['status' => 0]);
                                $query->orWhere(function ($query1) use ($user) {
                                    $query1->whereNotNull('driver_id')->where(['waiting' => 1])->where(function ($query2) {
                                        $query2->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                                    });
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                        $futureRides = Ride::where('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where(function ($query) use ($user) {
                                $query->where(['status' => -4])->orWhere(['status' => 0]);
                                $query->orWhere(function ($query1) use ($user) {
                                    $query1->whereNotNull('driver_id')->where(['waiting' => 1])->where(function ($query2) {
                                        $query2->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                                    });
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->get();
                        $next_available_ride = (!empty($futureRides) && count($futureRides) > 0) ? 1 : 0;
                        $pastRides = Ride::where('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where(function ($query) use ($user) {
                                $query->where(['status' => -4])->orWhere(['status' => 0]);
                                $query->orWhere(function ($query1) use ($user) {
                                    $query1->whereNotNull('driver_id')->where(['waiting' => 1])->where(function ($query2) {
                                        $query2->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                                    });
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->get();
                        $previous_available_ride = (!empty($pastRides) && count($pastRides) > 0) ? 1 : 0;
                    } else {
                        $rides = Ride::select('id', 'pickup_address', 'dest_address', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'driver_id', 'payment_type', 'parent_ride_id', 'created_at', 'note', 'car_type')->with(['driver:id,first_name,last_name,country_code,phone,image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->whereIn('status', [0,-4]);
                               // $query->where([['status', '=', 0]])->orWhere(['status', '=', -4]);
                                $query->orWhere(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->where(['status' => 1, 'waiting' => 1]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        $futureRides = Ride::where('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->where([['status', '=', 0]]);
                                $query->orWhere(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->where(['status' => 1, 'waiting' => 1]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->count();
                        $next_available_ride = $futureRides ? 1 : 0;
                        $pastRides = Ride::where('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->where([['status', '=', 0]]);
                                $query->orWhere(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->where(['status' => 1, 'waiting' => 1]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->count();
                        $previous_available_ride = $pastRides ? 1 : 0;
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                    }
                } elseif ($request->type == 2) {
                    if ($user->is_master == 1) {
                        $rides = Ride::select('id', 'pickup_address', 'dest_address', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'driver_id', 'payment_type', 'parent_ride_id', 'created_at', 'note', 'car_type')->with(['driver:id,first_name,last_name,country_code,phone,image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                        $futureRides = Ride::where('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->get();
                        $next_available_ride = (!empty($futureRides) && count($futureRides) > 0) ? 1 : 0;
                        $pastRides = Ride::where('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->get();
                        $previous_available_ride = (!empty($pastRides) && count($pastRides) > 0) ? 1 : 0;
                    } else {
                        $rides = Ride::select('id', 'pickup_address', 'dest_address', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'driver_id', 'payment_type', 'parent_ride_id', 'created_at', 'note', 'car_type')->with(['driver:id,first_name,last_name,country_code,phone,image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where('driver_id', $userId)->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        $futureRides = Ride::where('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where('driver_id', $userId)->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->count();
                        $next_available_ride = $futureRides ? 1 : 0;
                        $pastRides = Ride::where('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where('driver_id', $userId)->where('status', 3)
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->count();
                        $previous_available_ride = $pastRides ? 1 : 0;
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                    }
                } elseif ($request->type == 3) {
                    if ($user->is_master == 1) {
                        $rides = Ride::select('id', 'pickup_address', 'dest_address', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'driver_id', 'payment_type', 'parent_ride_id', 'created_at', 'note', 'car_type')->with(['driver:id,first_name,last_name,country_code,phone,image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where(function ($query) {
                                $query->whereIn('status', [-2]);
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                        $futureRides = Ride::where('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where(function ($query) {
                                $query->whereIn('status', [-2]);
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->get();
                        $next_available_ride = (!empty($futureRides) && count($futureRides) > 0) ? 1 : 0;
                        $pastRides = Ride::where('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where(function ($query) {
                                $query->whereIn('status', [-2]);
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->get();
                        $previous_available_ride = (!empty($pastRides) && count($pastRides) > 0) ? 1 : 0;
                    } else {
                        $rides = Ride::select('id', 'pickup_address', 'dest_address', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'driver_id', 'payment_type', 'parent_ride_id', 'created_at', 'note', 'car_type')->with(['driver:id,first_name,last_name,country_code,phone,image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->where(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->whereIn('status', [-2]);
                                });
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        $futureRides = Ride::where('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->where(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->whereIn('status', [-2]);
                                });
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->count();
                        $next_available_ride = $futureRides ? 1 : 0;
                        $pastRides = Ride::where('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->where(function ($query1) use ($userId) {
                                    $query1->where('driver_id', $userId);
                                    $query1->whereIn('status', [-2]);
                                });
                                $query->orWhere(function ($query1) {
                                    $query1->where(['status' => -3]);
                                });
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->count();
                        $previous_available_ride = $pastRides ? 1 : 0;
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                    }
                } else if ($request->type == 4) {
                    if ($user->is_master == 1) {
                        $rides = Ride::select('id', 'pickup_address', 'dest_address', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'driver_id', 'payment_type', 'parent_ride_id', 'created_at', 'note', 'car_type')->with(['driver:id,first_name,last_name,country_code,phone,image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->whereNotNull('driver_id')->where(['waiting' => 0])->where(function ($query) {
                                $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                        $futureRides = Ride::where('rides.ride_time', $nextCompareVariable, $startDate)
                            ->whereNotNull('driver_id')->where(['waiting' => 0])->where(function ($query) {
                                $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->get();
                        $next_available_ride = (!empty($futureRides) && count($futureRides) > 0) ? 1 : 0;
                        $pastRides = Ride::where('rides.ride_time', $prevCompareVariable, $startDate)
                            ->whereNotNull('driver_id')->where(['waiting' => 0])->where(function ($query) {
                                $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->get();
                        $previous_available_ride = (!empty($pastRides) && count($pastRides) > 0) ? 1 : 0;
                    } else {
                        $rides = Ride::select('id', 'pickup_address', 'dest_address', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'driver_id', 'payment_type', 'parent_ride_id', 'created_at', 'note', 'car_type')->with(['driver:id,first_name,last_name,country_code,phone,image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where('driver_id', $userId)->where(['waiting' => 0])->where(function ($query) {
                                $query->where([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        $futureRides = Ride::where('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where('driver_id', $userId)->where(['waiting' => 0])->where(function ($query) {
                                $query->where([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->count();
                        $next_available_ride = $futureRides ? 1 : 0;
                        $pastRides = Ride::where('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where('driver_id', $userId)->where(['waiting' => 0])->where(function ($query) {
                                $query->where([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->count();
                        $previous_available_ride = $pastRides ? 1 : 0;
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                    }
                } else if ($request->type == 5) {
                    if ($user->is_master == 1) {
                        $rides = Ride::select('id', 'pickup_address', 'dest_address', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'driver_id', 'payment_type', 'parent_ride_id', 'created_at', 'note', 'car_type')->with(['driver:id,first_name,last_name,country_code,phone,image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                        ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                        $futureRides = Ride::where('rides.ride_time', $nextCompareVariable, $startDate)
                        ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->get();
                        $next_available_ride = (!empty($futureRides) && count($futureRides) > 0) ? 1 : 0;
                        $pastRides = Ride::where('rides.ride_time', $prevCompareVariable, $startDate)
                        ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->get();
                        $previous_available_ride = (!empty($pastRides) && count($pastRides) > 0) ? 1 : 0;
                    } else {
                        $rides = Ride::select('id', 'pickup_address', 'dest_address', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'driver_id', 'payment_type', 'parent_ride_id', 'created_at', 'note', 'car_type')->with(['driver:id,first_name,last_name,country_code,phone,image'])
                        ->whereDate('rides.ride_time', $compareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->where(function ($query) use ($userId) {
                                    $query->orWhere('status', 0);
                                    $query->orWhere('driver_id', $userId);
                                })
                                ->orWhere('status', -4);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($skip)->get();
                        $futureRides = Ride::where('rides.ride_time', $nextCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->orWhere('status', 0);
                                $query->orWhere('driver_id', $userId);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($nextskip)->count();
                        $next_available_ride = $futureRides ? 1 : 0;
                        $pastRides = Ride::where('rides.ride_time', $prevCompareVariable, $startDate)
                            ->where(function ($query) use ($userId) {
                                $query->orWhere('status', 0);
                                $query->orWhere('driver_id', $userId);
                            })
                            ->where(['service_provider_id' => $user->service_provider_id])
                            ->orderBy('ride_time', $ride_order)->take($take)->skip($prevSkip)->count();
                        $previous_available_ride = $pastRides ? 1 : 0;
                        if (!empty($request->page) && $request->page < 0) {
                            $rides = array_reverse($rides->toArray());
                        }
                    }
                }
                if(!empty($rides)){
                    foreach ($rides as $ride_key => $ride_value) {
                        if(!empty($rides[$ride_key]->driver)){
                            $rides[$ride_key]->driver->car_data = $ride_value->driver->car_data;
                        }
                    }
                }
                return response()->json(['success' => true, 'message' => 'Rides List', 'data' => $rides, 'next_available_ride' => $next_available_ride, 'previous_available_ride' => $previous_available_ride], $this->successCode);
            } else {
                return response()->json(['message' => 'Record Not found'], $this->warningCode);
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }

}
