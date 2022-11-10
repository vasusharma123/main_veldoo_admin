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

class SendRideNotificationToDriverOnScheduleTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendRideNotificationToDriver:OnScheduleTime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send ride notification to driver on schedule time';

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
        $rides = Ride::whereNotNull('driver_id')->where('alert_notification_date_time', '<=', $currentTime)->where(['status' => 0, 'notification_sent' => 0, 'alert_send' => 0])->where(function ($query) {
            $query->where(['ride_type' => 1])
                ->orWhere(['ride_type' => 3]);
        })->whereNotNull('alert_notification_date_time')->get();
        if (!empty($rides) && count($rides) > 0) {
            $settings = Setting::first();
            $settingValue = json_decode($settings['value']);
            foreach ($rides as $ride) {
                $ride->all_drivers = $ride->driver_id;
                $ride->save();
                $user_data = User::select('id', 'first_name', 'last_name', 'image', 'country_code', 'phone')->find($ride['user_id']);
                $title = 'New Booking';
                $message = 'You Received new booking';
                $ride['user_data'] = $user_data;
                $ride['waiting_time'] = $settingValue->waiting_time;
                $additional = ['type' => 1, 'ride_id' => $ride->id, 'ride_data' => $ride];
                if (!empty($ride->driver->device_token)) {
                    if ($ride->driver->device_type == 'ios') {
                        bulk_pushok_ios_notification($title, $message, [$ride->driver->device_token], $additional, $sound = 'default', 2);
                    } else if ($ride->driver->device_type == 'android') {
                        bulk_firebase_android_notification($title, $message, [$ride->driver->device_token], $additional);
                    }
                }
                Notification::create(['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $ride->driver_id, 'additional_data' => json_encode($additional)]);
                RideHistory::insert(['ride_id' => $ride->id, 'driver_id' => $ride->driver_id, 'status' => '2']);
                $rideData = Ride::find($ride->id);
                $rideData->driver_id = null;
                $rideData->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('+' . $settingValue->waiting_time . ' seconds ', strtotime($rideData->alert_notification_date_time)));
                $rideData->save();
            }
        }
    }
}
