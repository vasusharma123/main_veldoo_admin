<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ride;
use App\User;
use App\RideHistory;
use App\Notification;
use App\Helpers\Notifications;
use Illuminate\Support\Facades\Log;


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
              $alreadySend=RideHistory::getRideCancelData($ride->id,'2');
                 $allDrivers=User::whereNotIn('id',$alreadySend)->whereNotNull('device_token')->whereNotNull('device_type')->where('user_type',2)->where('availability',1)->get();
              
               $this->sendDriverNotification($allDrivers,$ride->id);

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
           
            if(!empty($driverIds)){
                foreach($driverIds as $drivers){
                    Notifications::sendDriversNotification($title,$message,$type,$rideID,$drivers->device_type,$drivers->device_token,$drivers->id,$drivers->user_type); 

                    $rideHistory->saveData(['ride_id'=>$rideID,'driver_id'=>$drivers->id,'status'=>'2']);
                   
                    Ride::where('id', $rideID)->update(['request_time' =>date('H:i:s')]);
                    Notification::saveData(['title'=>$title,'description' => $message,'type'=> $type,'user_id'=>$drivers->id]);
                             
                    }
                }    
              
            
        }   
    }



}
