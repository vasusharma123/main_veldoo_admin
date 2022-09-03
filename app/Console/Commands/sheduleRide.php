<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ride;

class sheduleRide extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sheduleRide:Notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       
        if(!empty($rides) && count($rides)>0){
            foreach($rides as $ride){
                $ordertime=date('Hi',strtotime('+1 minutes',strtotime($ride->request_time)));
                $currentTime=date('Hi');
                if($currentTime>=$ordertime){         
                    Ride::where('id', $ride->id)->update(['status' =>-4]);
                }
            }  
        }

        
    }
}
