<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\DriverStayActiveNotification;
use App\Setting;
use App\User;

class DriverActiveStateFirstReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DriverActiveState:FirstReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Driver is still active, first reminder';

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
        $settings = Setting::first();
        $settingValue = json_decode($settings['value']);
        $max_driver_idle_time = (!empty($settingValue->driver_idle_time)) ? $settingValue->driver_idle_time : 60;
        $alertTime = Carbon::now()->subMinute($max_driver_idle_time)->format('Y-m-d H:i:s');
        $unactive_driver_ids = DriverStayActiveNotification::whereHas('driver' , function($query){
            $query->where(['availability' => 1]);
        })->where('last_activity_time', '<=', $alertTime)->where(['is_availability_alert_sent' => 0, 'is_logout_alert_sent' => 0])->whereNotNull('last_activity_time')->pluck('driver_id')->toArray();
        if (count($unactive_driver_ids) > 0) {
            $title = 'Are you still active ?';
            $message = '';
            $additional = ['type' => 12, 'waiting_time' => $settingValue->waiting_time];
            $ios_driver_tokens = User::whereIn('id', $unactive_driver_ids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'ios'])->pluck('device_token')->toArray();
            if (!empty($ios_driver_tokens)) {
                bulk_pushok_ios_notification($title, $message, $ios_driver_tokens, $additional, $sound = 'default', 2);
            }
            $android_driver_tokens = User::whereIn('id', $unactive_driver_ids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'android'])->pluck('device_token')->toArray();
            if (!empty($android_driver_tokens)) {
                bulk_firebase_android_notification($title, $message, $android_driver_tokens, $additional);
            }
            DriverStayActiveNotification::whereIn('driver_id', $unactive_driver_ids)->update(['is_availability_alert_sent' => 1, 'last_activity_time' => Carbon::now()]);
        }
    }
}
