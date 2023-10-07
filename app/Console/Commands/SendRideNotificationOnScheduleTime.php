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

class SendRideNotificationOnScheduleTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendRideNotification:OnScheduleTime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send ride notification on schedule time';

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
        $rides = Ride::whereNull('driver_id')->where('alert_notification_date_time', '<=', $currentTime)->where(['status' => 0, 'notification_sent' => 0, 'alert_send' => 0])->where(function ($query) {
            $query->where(['ride_type' => 1])
                ->orWhere(['ride_type' => 3]);
        })->whereNotNull('alert_notification_date_time')->get();
        if (!empty($rides) && count($rides) > 0) {
            foreach ($rides as $ride) {
                $waitingTime = 30;
                $driverlimit = 2;
                $current_ride_distance_addition = 10;
                $waiting_ride_distance_addition = 15;
                if (!empty($ride->service_provider_id)) {
                    $settings = Setting::where(['service_provider_id' => $ride->service_provider_id])->first();
                    $settingValue = json_decode($settings['value']);
                    $waitingTime = $settingValue->waiting_time;
                    $driverlimit = $settingValue->driver_requests;
                    $current_ride_distance_addition = $settingValue->current_ride_distance_addition ?? 10;
                    $waiting_ride_distance_addition = $settingValue->waiting_ride_distance_addition ?? 15;
                }
                $query = User::select(
                    "users.*",
                    DB::raw("3959 * acos(cos(radians(" . $ride->pick_lat . "))
                        * cos(radians(users.current_lat))
                        * cos(radians(users.current_lng) - radians(" . $ride->pick_lng . "))
                        + sin(radians(" . $ride->pick_lat . "))
                        * sin(radians(users.current_lat))) AS distance")
                );
                $query->where(['user_type' => 2, 'availability' => 1])->whereNotNull('device_token')->where('device_token', '!=', '')->orderBy('distance', 'asc');
                if (!empty($ride->service_provider_id)) {
                    $query->where(['service_provider_id' => $ride->service_provider_id]);
                }
                $drivers = $query->get()->toArray();

                $driverids = array();

                if (!empty($drivers)) {
                    $rideObj = new Ride;
                    foreach ($drivers as $driver_key => $driver_value) {
                        if (!empty($driver_value['ride'])) {
                            if (!empty($driver_value['ride']['dest_lat'])) {
                                if ($driver_value['ride']['status'] == 1) {
                                    $drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($driver_value['current_lat'], $driver_value['current_lng'], $driver_value['ride']['pick_lat'], $driver_value['ride']['pick_lng']);
                                }
                                $drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($driver_value['ride']['pick_lat'], $driver_value['ride']['pick_lng'], $driver_value['ride']['dest_lat'], $driver_value['ride']['dest_lng']);
                            } else {
                                $drivers[$driver_key]['distance'] += $current_ride_distance_addition;
                            }
                        }
                        if (!empty($driver_value['all_rides'])) {
                            foreach ($driver_value['all_rides'] as $waiting_ride_key => $waiting_ride_value) {
                                if (!empty($driver_value['ride']['dest_lat'])) {
                                    $drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($driver_value['current_lat'], $driver_value['current_lng'], $waiting_ride_value['pick_lat'], $waiting_ride_value['pick_lng']);
                                    $drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($waiting_ride_value['pick_lat'], $waiting_ride_value['pick_lng'], $waiting_ride_value['dest_lat'], $waiting_ride_value['dest_lng']);
                                } else {
                                    $drivers[$driver_key]['distance'] += $waiting_ride_distance_addition;
                                }
                            }
                        }
                    }

                    usort($drivers, 'sortByDistance');

                    if (!empty($drivers)) {
                        for ($i = 0; $i < $driverlimit; $i++) {
                            if (!empty($drivers[$i])) {
                                $driverids[] = $drivers[$i]['id'];
                            }
                        }
                        $ride->all_drivers = implode(",", $driverids);
                    }
                    $ride->save();
                    $title = 'New Booking';
                    $message = 'You Received new booking';
                    $ride = new RideResource(Ride::find($ride->id));
                    $ride['waiting_time'] = $waitingTime;
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
                        $notification_data[] = ['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $driverid, 'additional_data' => json_encode($additional), 'service_provider_id' => $ride->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                        $ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $driverid, 'status' => '2', 'service_provider_id' => $ride->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                    }
                    Notification::insert($notification_data);
                    RideHistory::insert($ridehistory_data);
                }
                $overallDrivers = User::select(
                    "users.*",
                    DB::raw("3959 * acos(cos(radians(" . $ride->pick_lat . "))
                        * cos(radians(users.current_lat))
                        * cos(radians(users.current_lng) - radians(" . $ride->pick_lng . "))
                        + sin(radians(" . $ride->pick_lat . "))
                        * sin(radians(users.current_lat))) AS distance")
                )->where(['user_type' => 2, 'availability' => 1])->whereNotNull('device_token');
                if (!empty($ride->service_provider_id)) {
                    $overallDrivers->where(['service_provider_id' => $ride->service_provider_id]);
                }
                $overallDriversCount = $overallDrivers->get()->toArray();
                $rideData = Ride::find($ride->id);
                $rideData->notification_sent = 1;
                if (count($overallDriversCount) <= count($drivers)) {
                    $rideData->alert_send = 1;
                }
                $rideData->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('+' . $waitingTime . ' seconds ', strtotime($rideData->alert_notification_date_time)));
                $rideData->save();
            }
        }
    }
}
