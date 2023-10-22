<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use App\User;
use Config;
use App\Setting;
use Illuminate\Support\Facades\Log;
use App\Ride;
use App\Notification as Notification_Model;
use App\RideHistory;
use Pushok\AuthProvider;
use Pushok\Client;
use Pushok\Notification;
use Pushok\Payload;
use Pushok\Payload\Alert;
use Edujugon\PushNotification\PushNotification;
use App\Http\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RideResource;

class Notifications
{


     /**
     * Created By Anil Dogra
     * Created At 24-05-2021
     * @var $request object of request class
     * @var $user object of user class
     * @return object with registered user id
     * This function use to sendNotification 
     */
   
   
    public static function sendDriversNotification($title,$message,$types,$rideId,$device_type,$deviceToken,$driver_id,$user_type) {  
       

            $ride_data=Ride::where('id',$rideId)->first();

            if (!empty($ride_data['ride_cost'])) {
                $ride_data['price'] = $ride_data['ride_cost'];
            }

            // $title = 'No Driver Found!';
            // $message = 'This is no driver exist! for this ride.';
            $user_data = User::select('id', 'first_name', 'last_name', 'image', 'country_code', 'phone')->where('id', $ride_data['user_id'])->first();
           
            $ride_data['user_data'] = $user_data;
            $settings = Setting::first();
            $settingValue = json_decode($settings['value']);
            $ride_data['waiting_time'] = $settingValue->waiting_time;

            $additional = ['type' => $types, 'ride_id' => $rideId, 'ride_data' => $ride_data];


            $deviceType = $device_type;
            $result='';
            if ($deviceType === 'android') {

                send_notification($title, $message, $deviceToken, '', $additional, true, false, $deviceType, []);
              
            }
            if ($deviceType === 'ios') {

                
                ios_notification($title, $message, $deviceToken, $additional, $sound = 'default', $user_type);
                
            }
            
          // \Log::info('Curl out put: '. print_r($result, true));
        return true;
    }


    public static function checkAllDriverCancelRide($rideId){
            $title = 'No Driver Found!';
            $message = 'This is no driver exist! for this ride.';
            $types = 1;
           $allDrivers=Ride::getRideDriverList($rideId);
           $cancelRideDriver=RideHistory::getRideCancelData($rideId,'0');
           // print_r($allDrivers);die;
        if(array_diff($allDrivers,$cancelRideDriver) == array_diff($cancelRideDriver,$allDrivers)) {
            $masterDriver=User::where('is_master',1)->whereNotNull('device_token')->get();
             // print_r($masterDriver);die;
            $additionalPushData=Ride::where('id',$rideId)->first()->toArray();
             // print_r($additionalPushData);die;
            
            if(!empty($masterDriver)){
             foreach($masterDriver as $drivers){


               self::sendDriversNotification($title,$message,$types,$rideId,$drivers->device_type,$drivers->device_token,$drivers->id,$drivers->user_type); 

                 
               
              }
             }
              
            
            }else{
              return true;
            }

    }

    public static function sendRideNotificationToRemainingDrivers($ride_id)
    {
        $ride = Ride::find($ride_id);
        $waiting_time = 30;
        if (!empty($ride->service_provider_id)) {
            $settings = Setting::where(['service_provider_id' => $ride->service_provider_id])->first();
            $settingValue = json_decode($settings['value']);
            $waiting_time = $settingValue->waiting_time;
        }

        $alreadySend = RideHistory::getRideHistoryData($ride->id);
        $query = User::select(
            "users.*",
            DB::raw("3959 * acos(cos(radians(" . $ride->pick_lat . "))
                        * cos(radians(users.current_lat))
                        * cos(radians(users.current_lng) - radians(" . $ride->pick_lng . "))
                        + sin(radians(" . $ride->pick_lat . "))
                        * sin(radians(users.current_lat))) AS distance")
        );
        if (!empty($ride->service_provider_id)) {
            $query->where(['service_provider_id' => $ride->service_provider_id]);
        }
        $query->whereNotIn('id', $alreadySend)
            ->whereNotNull('device_token')
            ->whereNotNull('device_type')
            ->where('user_type', 2)
            ->where('availability', 1)
            ->orderBy('distance', 'asc');
        $drivers = $query->get();

        $driverids = array();

        if (!empty($drivers)) {
            foreach ($drivers as $driver) {
                $driverids[] = $driver['id'];
            }
            $ride->all_drivers = implode(",", $driverids);
            $ride->save();
            $title = 'New Booking';
            $message = 'You Received new booking';
            $ride = new RideResource(Ride::find($ride->id));
            $ride['waiting_time'] = $waiting_time;
            $additional = ['type' => 1, 'ride_id' => $ride->id, 'ride_data' => $ride];
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
                $notification_data[] = ['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $driverid, 'service_provider_id' => $ride->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                $ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $driverid, 'status' => '2', 'service_provider_id' => $ride->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
            }
            Notification_Model::insert($notification_data);
            RideHistory::insert($ridehistory_data);
            $rideData = Ride::find($ride->id);
            $rideData->alert_send = 1;
            $rideData->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('+' . $waiting_time . ' seconds ', strtotime($rideData->alert_notification_date_time)));
            $rideData->save();
        } else {
            $ride->alert_send = 1;
            $ride->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('+' . $waiting_time . ' seconds ', strtotime($ride->alert_notification_date_time)));
            $ride->save();
        }
    }

    public static function sendRideNotificationToMasters($ride_id)
    {
        $ride = Ride::find($ride_id);
        $ride->request_time = null;
        $ride->alert_notification_date_time = null;
        $ride->status = -4;
        $ride->save();

        if (!empty($ride->service_provider_id)) {
            $masterDriverIds = User::whereNotNull('device_token')->whereNotNull('device_type')->where(['user_type' => 2, 'is_master' => 1, 'service_provider_id' => $ride->service_provider_id])->pluck('id')->toArray();
            if (!empty($masterDriverIds)) {
                $title = 'No Driver Found';
                $message = 'Sorry No driver found at this time for your booking';

                $rideData = new RideResource(Ride::find($ride_id));
                $settings = Setting::where(['service_provider_id' => $ride->service_provider_id])->first();
                $settingValue = json_decode($settings['value']);
                $rideData['waiting_time'] = $settingValue->waiting_time;
                $additional = ['type' => 9, 'ride_id' => $ride_id, 'ride_data' => $rideData];
                $ios_driver_tokens = User::whereIn('id', $masterDriverIds)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'ios'])->pluck('device_token')->toArray();
                if (!empty($ios_driver_tokens)) {
                    bulk_pushok_ios_notification($title, $message, $ios_driver_tokens, $additional, $sound = 'default', 2);
                }
                $android_driver_tokens = User::whereIn('id', $masterDriverIds)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'android'])->pluck('device_token')->toArray();
                if (!empty($android_driver_tokens)) {
                    bulk_firebase_android_notification($title, $message, $android_driver_tokens, $additional);
                }
                $ridehistory_data = [];
                foreach ($masterDriverIds as $driverid) {
                    $ridehistory_data[] = ['ride_id' => $ride_id, 'driver_id' => $driverid, 'status' => '3', 'service_provider_id' => $ride->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                }
                RideHistory::insert($ridehistory_data);
            }
        }
    }

    public static function SendRideNotificationToDriverOnScheduleTime($ride_id)
    {
        $ride = Ride::find($ride_id);
        $driverlimit = 3;
        if (!empty($ride->service_provider_id)) {
            $settings = Setting::where(['service_provider_id' => $ride->service_provider_id])->first();
            $settingValue = json_decode($settings['value']);
            $driverlimit = $settingValue->driver_requests;
        }
        $alreadySend = RideHistory::getRideHistoryData($ride->id);
        $query = User::select(
                "users.*",
                DB::raw("3959 * acos(cos(radians(" . $ride->pick_lat . ")) 
					* cos(radians(users.current_lat)) 
					* cos(radians(users.current_lng) - radians(" . $ride->pick_lat . ")) 
					+ sin(radians(" . $ride->pick_lat . ")) 
					* sin(radians(users.current_lat))) AS distance")
            );
        if (!empty($alreadySend)) {
            $query->whereNotIn('id', $alreadySend);
        }
        if (!empty($ride->service_provider_id)) {
            $query->where(['service_provider_id' => $ride->service_provider_id]);
        }
        $query->where([['user_type', '=', 2], ['availability', '=', 1]])->orderBy('distance', 'asc')->limit($driverlimit);
        $drivers = $query->get()->toArray();

        $driverids = array();

        if (!empty($drivers)) {
            foreach ($drivers as $driver) {
                $driverids[] = $driver['id'];
            }
        } else {
            return response()->json(['message' => "No Driver Found"]);
        }
        if (!empty($driverids)) {
            $driverids = implode(",", $driverids);
        } else {
            return response()->json(['message' => "No Driver Found"]);
        }
        $ride->driver_id = null;
        $ride->all_drivers = $driverids;
        $ride->save();

        $ride_data = new RideResource(Ride::find($ride->id));

        $driverids = explode(",", $driverids);
        $user_data = User::select('id', 'first_name', 'last_name', 'image', 'country_code', 'phone')->find($ride_data['user_id']);
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
                $notification_data[] = ['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $driverid, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                $ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $driverid, 'status' => '2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
            }
            Notification_Model::insert($notification_data);
            RideHistory::insert($ridehistory_data);
        }
        $overallDriversCountQuery = User::select(
            "users.*",
            DB::raw("3959 * acos(cos(radians(" . $ride->pick_lat . "))
				* cos(radians(users.current_lat))
				* cos(radians(users.current_lng) - radians(" . $ride->pick_lng . "))
				+ sin(radians(" . $ride->pick_lat . "))
				* sin(radians(users.current_lat))) AS distance")
        )->where(['user_type' => 2, 'availability' => 1])->whereNotNull('device_token');
        if (!empty($ride->service_provider_id)) {
            $overallDriversCountQuery->where(['service_provider_id' => $ride->service_provider_id]);
        }
        $overallDriversCount = $overallDriversCountQuery->get()->toArray();
        $rideData = Ride::find($ride->id);
        $rideData->notification_sent = 1;
        if (count($overallDriversCount) <= count($drivers)) {
            $rideData->alert_send = 1;
        }
        $rideData->alert_notification_date_time = Carbon::now()->addseconds($settingValue->waiting_time)->format("Y-m-d H:i:s");
        $rideData->save();
    }

}