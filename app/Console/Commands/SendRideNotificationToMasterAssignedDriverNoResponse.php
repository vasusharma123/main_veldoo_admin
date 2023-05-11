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
        $rides = Ride::where('check_assigned_driver_ride_acceptation', '<=', $currentTime)->where(['status' => 0])->whereNotNull('driver_id')->get();
        if (!empty($rides) && count($rides) > 0) {
            $settings = Setting::first();
            $settingValue = json_decode($settings['value']);
            foreach ($rides as $ride) {
                $masterDriverIds=User::whereNotNull('device_token')->whereNotNull('device_type')->where(['user_type' => 2, 'is_master' => 1])->pluck('id')->toArray();
                if(!empty($masterDriverIds)){
                    $title = 'No Driver Found';
                    $message = 'Sorry No driver found at this time for your booking';
                    $ride = new RideResource(Ride::find($ride->id));
                    $ride['waiting_time'] = $settingValue->waiting_time;
                    $additional = ['type' => 9, 'ride_id' => $ride->id, 'ride_data' => $ride];
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
                        $ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $driverid, 'status' => '3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                    }
                    RideHistory::insert($ridehistory_data);
                    $rideData = Ride::find($ride->id);
                    $rideData->driver_id = null;
                    $rideData->check_assigned_driver_ride_acceptation = null;
                    $rideData->status = -4;
                    $rideData->save();
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
