<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\DriverStayActiveNotification;
use App\Setting;
use App\User;

class MakeUnactiveDriverUnavailable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MakeUnactiveDriver:Unavailable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make the unactive driver unavailable';

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
        $alertTime = Carbon::now()->subSeconds($settingValue->waiting_time)->format('Y-m-d H:i:s');
        $unactive_driver_ids = DriverStayActiveNotification::where('last_activity_time', '<=', $alertTime)->where(['is_availability_alert_sent' => 1, 'is_availability_changed' => 0, 'is_logout_alert_sent' => 0])->pluck('driver_id')->toArray();
        if (count($unactive_driver_ids) > 0) {
            User::whereIn('id', $unactive_driver_ids)->update(['availability' => 0]);
            DriverStayActiveNotification::whereIn('driver_id', $unactive_driver_ids)->update(['is_availability_alert_sent' => 1, 'is_availability_changed' => 1, 'last_activity_time' => Carbon::now()]);
        }
    }
}
