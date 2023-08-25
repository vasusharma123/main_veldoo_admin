<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ride;
use App\User;
use App\RideHistory;
use App\Notification;
use App\Helpers\Notifications;
use Illuminate\Support\Facades\Log;

class masterDriver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'masterDriver:Notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Master schedule rides to pendings if not accepted!';

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
         $rides= Ride::where('status',-4)->whereNull('alert_time')->whereNotNull('request_time')->get();
         
            if(!empty($rides) && count($rides)>0){
                foreach($rides as $ride){
                $ordertime=date('Hi',strtotime('+45 seconds',strtotime($ride->request_time)));
                $currentTime=date('Hi');
                if($currentTime>=$ordertime){         
                    $this->sendMasterDriverNotification($ride->id);
                }          
                 
                }  
            }
         
    }

    

    /***
        * send master driver notification to pending request if not accepted
     ***/
        public function sendMasterDriverNotification($rideID){
         $rideHistory=new rideHistory;
         $title = 'No Driver Found';
         $message = 'Sorry No driver found at this time for your booking';
         $type=9;
           $masterDriver=User::where('is_master',1)->whereNotNull('device_token')->whereNotNull('device_type')->where('user_type',2)->get();
          
            // \Log::info('Notification send pending master drivers: '. print_r($masterDriver, true)); 
               
            if(!empty($masterDriver)){
             foreach($masterDriver as $drivers){


               Notifications::sendDriversNotification($title,$message,$type,$rideID,$drivers->device_type,$drivers->device_token,$drivers->id,$drivers->user_type); 

                // \Log::```info('Notification send pending master drivers: '. print_r($rideID, true)); 
               
                 $rideHistory->saveData(['ride_id'=>$rideID,'driver_id'=>$drivers->id,'status'=>'3']);

              }
               Ride::where('id', $rideID)->update(['request_time' =>null]);
             }
        }

     

}
         