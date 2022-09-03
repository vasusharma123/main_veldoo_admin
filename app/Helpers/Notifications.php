<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use App\User;
use Config;
use App\Setting;
use Illuminate\Support\Facades\Log;
use App\Ride;
use App\RideHistory;
use Pushok\AuthProvider;
use Pushok\Client;
use Pushok\Notification;
use Pushok\Payload;
use Pushok\Payload\Alert;
use Edujugon\PushNotification\PushNotification;
use App\Http\Helpers;

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

    

}