<?php

namespace App\Console\Commands;

use App\Notification;
use App\Ride;
use App\RideHistory;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RideResource;
use Illuminate\Support\Facades\Log;

class SendRideNotificationToMasterAssignedDriverNoResponse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendRideNotificationToMaster:AssignedDriverNoResponse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send ride notification to master after the assign driver gives no response';

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
        $currentTime = Carbon::now()->format('Y-m-d H:i:s');
        $rides = Ride::where('check_assigned_driver_ride_acceptation', '<=', $currentTime)->where(['status' => 0])->whereNotNull('driver_id')->where(function($query){
            $query->whereNotNull('service_provider_id')->where('service_provider_id','!=','');
        })->get();
        if (!empty($rides) && count($rides) > 0) {
            foreach ($rides as $ride) {
                $settings = Setting::where(['service_provider_id' => $ride->service_provider_id])->first();
                $settingValue = json_decode($settings['value']);
                $masterDriverIds=User::whereNotNull('device_token')->whereNotNull('device_type')->where(['user_type' => 2, 'is_master' => 1, 'service_provider_id' => $ride->service_provider_id])->pluck('id')->toArray();
                if(!empty($masterDriverIds)){
                    $ride->driver_id = null;
                    $ride->check_assigned_driver_ride_acceptation = null;
                    $ride->status = -4;
                    $ride->save();
                    $title = 'No Driver Found';
                    $message = 'Sorry No driver found at this time for your booking';
                    $rideData = new RideResource(Ride::find($ride->id));
                    $rideData['waiting_time'] = $settingValue->waiting_time;
                    $additional = ['type' => 9, 'ride_id' => $rideData->id, 'ride_data' => $rideData];
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
                        $ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $driverid, 'status' => '3', 'service_provider_id' => $ride->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                    }
                    RideHistory::insert($ridehistory_data);
                } else {
                    $ride->driver_id = null;
                    $ride->check_assigned_driver_ride_acceptation = null;
                    $ride->status = -4;
                    $ride->save();
                }
            }
        }
    }
}
