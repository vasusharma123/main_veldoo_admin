<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\DriverStayActiveNotification;
use App\Setting;
use Illuminate\Support\Facades\DB;
use App\DriverChooseCar;
use App\User;

class MakeUnactiveDriverLogout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MakeUnactiveDriver:Logout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make the unactive driver logout';

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
        $overallSettings = Setting::get();
        if (!empty($overallSettings) && count($overallSettings) > 0) {
            foreach ($overallSettings as $setting) {
                $settingValue = json_decode($setting['value']);
                $alertTime = Carbon::now()->subSeconds($settingValue->waiting_time)->format('Y-m-d H:i:s');
                $unactive_driver_ids = DriverStayActiveNotification::where('last_activity_time', '<=', $alertTime)->where(['is_availability_alert_sent' => 1, 'is_availability_changed' => 1, 'is_logout_alert_sent' => 1, 'service_provider_id' => $setting->service_provider_id])->pluck('driver_id')->toArray();
                if (count($unactive_driver_ids) > 0) {
                    DB::table('oauth_access_tokens')
                        ->whereIn('user_id', $unactive_driver_ids)
                        ->update([
                            'revoked' => true
                        ]);
                    User::whereIn('id', $unactive_driver_ids)->update(['availability' => 0, 'fcm_token' => '', 'device_token' => '']);
                    DriverStayActiveNotification::whereIn('driver_id', $unactive_driver_ids)->delete();
                    DriverChooseCar::whereIn('user_id', $unactive_driver_ids)->where(['logout' => 0])->update(['logout' => 1]);
                }
            }
        }
    }
}
