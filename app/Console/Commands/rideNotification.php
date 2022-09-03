<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ride;
use App\User;
use App\RideHistory;
use App\Notification;
use App\Helpers\Notifications;
use Illuminate\Support\Facades\Log;
use DB;
use App\Setting;


class rideNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'driver:rideNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send notification remaining driver';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       
       $rides= Ride::where('status',0)->whereNull('alert_time')->get();
       // \Log::info('Notification send pending master drivers: '. date('H:i:s')); 
       if(!empty($rides) && count($rides)>0){
           foreach($rides as $ride){
              $alreadySend=RideHistory::getRideHistoryData($ride->id);

                   $settings =Setting::first();
                   $settingValue = json_decode($settings['value']);
                  
                    $driver_radius = $settingValue->radius;

                    $sqlDistanceUsers=DB::raw('( 3959  * acos( cos( radians(' . $ride->pick_lat . ') ) 
       * cos( radians( users.current_lat ) ) 
       * cos( radians( users.current_lng ) 
       - radians(' . $ride->pick_lng . ') ) 
       + sin( radians(' . $ride->pick_lat . ') ) 
       * sin( radians( users.current_lat ) ) ) )');

                    

                    $query =User::select(['*'])
                    ->selectRaw(\DB::raw("ROUND({$sqlDistanceUsers},2)  AS distance"))
                    ->whereNotIn('id',$alreadySend)
                    ->whereNotNull('device_token')
                    ->whereNotNull('device_type')
                    ->where('user_type',2)
                    ->where('availability',1)
                    ->having('distance', '<', $driver_radius)
                    ->orderBy('distance', 'asc');
                    $driverList= $query->get();
               // \Log::info('Curl out put: '. print_r( $driverList, true));              
               $this->sendDriverNotification($driverList,$ride->id);

         }  
       }

        
    }

    /***
         * send notification for remaining driver
        ***/
    public function sendDriverNotification($driverIds,$rideID){
        $rideHistory=new rideHistory;
        $title = 'New Booking';
        $message = 'You Received new booking!';
        $type=1;
        
         
        if(!empty($driverIds) && count($driverIds)>0){
             
             
             // print_r($masterDriver);die;
             $rideData=Ride::where('id',$rideID)->first();
             // print_r($additionalPushData);die;
           
            
                foreach($driverIds as $drivers){
                    Notifications::sendDriversNotification($title,$message,$type,$rideID,$drivers->device_type,$drivers->device_token,$drivers->id,$drivers->user_type); 

                    $rideHistory->saveData(['ride_id'=>$rideID,'driver_id'=>$drivers->id,'status'=>'2']);
                   
                    Ride::where('id', $rideID)->update(['request_time' =>date('H:i:s')]);
                    Notification::saveData(['title'=>$title,'description' => $message,'type'=> $type,'user_id'=>$drivers->id]);
                             
                    }
           
              
            
        }else{
            Ride::where('id', $rideID)->update(['status' =>-4]); 
        }   
    }



}
