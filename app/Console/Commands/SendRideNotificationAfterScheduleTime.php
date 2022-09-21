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

class SendRideNotificationAfterScheduleTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendRideNotification:AfterScheduleTime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send ride notification after schedule time';

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
        $rides = Ride::where('alert_notification_date_time', '<=', $currentTime)->where(['status' => 0, 'notification_sent' => 1, 'alert_send' => 0])->where(function($query){
            $query->where(['ride_type' => 1])
            ->orWhere(['ride_type' => 3]);
        })->whereNotNull('alert_notification_date_time')->get();
        if (!empty($rides) && count($rides) > 0) {
            $settings = Setting::first();
            $settingValue = json_decode($settings['value']);
            $driver_radius = $settingValue->radius;
            foreach ($rides as $ride) {
                $alreadySend = RideHistory::getRideHistoryData($ride->id);
                $query = User::select(
                    "users.*",
                    DB::raw("3959 * acos(cos(radians(" . $ride->pick_lat . "))
                        * cos(radians(users.current_lat))
                        * cos(radians(users.current_lng) - radians(" . $ride->pick_lng . "))
                        + sin(radians(" . $ride->pick_lat . "))
                        * sin(radians(users.current_lat))) AS distance")
                );
                $query->whereNotIn('id', $alreadySend)
                    ->whereNotNull('device_token')->where('device_token', '!=', '')
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
                    $user_data = User::select('id', 'first_name', 'last_name', 'image', 'country_code', 'phone')->find($ride['user_id']);
                    $title = 'New Booking';
                    $message = 'You Received new booking';
                    $ride['user_data'] = $user_data;
                    $ride['waiting_time'] = $settingValue->waiting_time;
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
                        $notification_data[] = ['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $driverid, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                        $ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $driverid, 'status' => '2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                    }
                    Notification::insert($notification_data);
                    RideHistory::insert($ridehistory_data);
                    $rideData = Ride::find($ride->id);
                    $rideData->alert_send = 1;
                    $rideData->alert_notification_date_time = date('Y-m-d H:i:s',strtotime('+'.$settingValue->waiting_time.' seconds ',strtotime($rideData->alert_notification_date_time)));
                    $rideData->save();
                } else {
                    $ride->alert_send = 1;
                    $ride->alert_notification_date_time = date('Y-m-d H:i:s',strtotime('+'.$settingValue->waiting_time.' seconds ',strtotime($ride->alert_notification_date_time)));
                    $ride->save();
                }
            }
        }
    }
}
