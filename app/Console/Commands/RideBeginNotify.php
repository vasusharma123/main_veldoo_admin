<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Helper;

class RideBeginNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ride_begin:notify';

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
       /* $rides=\App\Ride::get();
	$rides->map(function ($ride){
		
		$additional = [];
				$title = 'About Ride';
				$message ="Your ride will be start in 5 minutes";
				$user=$ride->user;
				$userDeviceToken = [$user->device_token];
				$reponse= Helper::send_notification($title, $message, $userDeviceToken, '',$additional,true,false,$user->device_type,['user_id'=>1,'user_id_op'=>$user->id,'operation_id'=>$ride->id,'title'=>$title,'description'=>$message,'type'=>18,'status'=>1]);
				/*$driver=$ride->driver;
				$userDeviceToken = [$driver->device_token];
				$reponse= Helper::send_notification($title, $message, $userDeviceToken, '',$additional,true,false,$driver->device_type,['user_id'=>1,'user_id_op'=>$driver->id,'operation_id'=>$ride->id,'title'=>$title,'description'=>$message,'type'=>18,'status'=>1]);
				
	});*/
    }
}
