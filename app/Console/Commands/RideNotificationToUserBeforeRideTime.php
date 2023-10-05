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

class RideNotificationToUserBeforeRideTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RideNotificationToUser:BeforeRideTime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the user a notification 15 minutes before the ride begins.';

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
        $after13Mins = Carbon::now()->addMinutes(13)->toDateTimeString();
        $after15Mins = Carbon::now()->addMinutes(15)->toDateTimeString();
        $rides = Ride::whereHas('user')
        ->whereNotNull('user_id')->whereIn('status', [0,1])->where(['is_notified_user_before_ride' => 0])
        ->whereBetween('ride_time', [$after13Mins, $after15Mins])->get();
        if (!empty($rides) && count($rides) > 0) {
            foreach ($rides as $ride) {
                $ride = new RideResource(Ride::find($ride->id));
                $title = 'Hey '.$ride->user->first_name;
                $message = 'You ride is about to start';
                $additional = ['type' => 14, 'ride_id' => $ride->id, 'ride_data' => $ride];
                if (!empty($ride->user->device_token)) {
                    if ($ride->user->device_type == 'ios') {
                        bulk_pushok_ios_notification($title, $message, [$ride->user->device_token], $additional, $sound = 'default', 1);
                    } else if ($ride->user->device_type == 'android') {
                        bulk_firebase_android_notification($title, $message, [$ride->user->device_token], $additional);
                    }
                }
                Notification::create(['title' => $title, 'description' => $message, 'type' => 14, 'user_id' => $ride->user_id, 'additional_data' => json_encode($additional), 'service_provider_id' => $ride->service_provider_id]);
                $rideData = Ride::find($ride->id);
                $rideData->is_notified_user_before_ride = 1;
                $rideData->save();
            }
        }
    }
}
