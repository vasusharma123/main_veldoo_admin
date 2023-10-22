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
            foreach ($rides as $ride) {
                $waitingTime = 30;
                if(!empty($ride->service_provider_id)){
                    $settings = Setting::where(['service_provider_id' => $ride->service_provider_id])->first();
                    $settingValue = json_decode($settings['value']);
                    $waitingTime = $settingValue->waiting_time;
                    $driver_radius = $settingValue->radius;
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
                if(!empty($ride->service_provider_id)){
                    $query->where(['service_provider_id' => $ride->service_provider_id]);
                }
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
                    $title = 'New Booking';
                    $message = 'You Received new booking';
                    $ride = new RideResource(Ride::find($ride->id));
                    $ride['waiting_time'] = $waitingTime;
                    $additional = ['type' => 1, 'ride_id' => $ride->id, 'ride_data' => $ride];
                    if (!empty($ride->service_provider_id)) {
                        $ios_driver_tokens = User::whereIn('id', $driverids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'ios', 'service_provider_id' => $ride->service_provider_id])->pluck('device_token')->toArray();
                        if (!empty($ios_driver_tokens)) {
                            bulk_pushok_ios_notification($title, $message, $ios_driver_tokens, $additional, $sound = 'default', 2);
                        }
                        $android_driver_tokens = User::whereIn('id', $driverids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'android', 'service_provider_id' => $ride->service_provider_id])->pluck('device_token')->toArray();
                        if (!empty($android_driver_tokens)) {
                            bulk_firebase_android_notification($title, $message, $android_driver_tokens, $additional);
                        }
                        $notification_data = [];
                        $ridehistory_data = [];
                        foreach ($driverids as $driverid) {
                            $notification_data[] = ['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $driverid, 'additional_data' => json_encode($additional), 'service_provider_id' => $ride->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                            $ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $driverid, 'status' => '2', 'service_provider_id' => $ride->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                        }
                    } else {
                        $all_available_users = User::select('id','device_token','device_type','service_provider_id')->whereIn('id', $driverids)->whereNotNull('device_token')->where('device_token', '!=', '')->get();
                        if(!empty($all_available_users) && count($all_available_users) > 0){
                            $notification_data = [];
                            $ridehistory_data = [];
                            foreach($all_available_users as $user_key => $user_value){
                                if($user_value->device_type == "ios"){
                                    bulk_pushok_ios_notification($title, $message, [$user_value->device_token], $additional, $sound = 'default', 2);
                                } else if($user_value->device_type == "android"){
                                    bulk_firebase_android_notification($title, $message, [$user_value->device_token], $additional);
                                }
                                $notification_data[] = ['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $user_value->id, 'additional_data' => json_encode($additional), 'service_provider_id' => $ride->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                                $ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $user_value->id, 'status' => '2', 'service_provider_id' => $ride->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                            }
                            Notification::insert($notification_data);
                            RideHistory::insert($ridehistory_data);
                        }
                    }

                    $rideData = Ride::find($ride->id);
                    $rideData->alert_send = 1;
                    $rideData->alert_notification_date_time = date('Y-m-d H:i:s',strtotime('+'.$waitingTime.' seconds ',strtotime($rideData->alert_notification_date_time)));
                    $rideData->save();
                } else {
                    $ride->alert_send = 1;
                    $ride->alert_notification_date_time = date('Y-m-d H:i:s',strtotime('+'.$waitingTime.' seconds ',strtotime($ride->alert_notification_date_time)));
                    $ride->save();
                }
            }
        }
    }
}
