<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
       Commands\RideBeginNotify::class,
       'App\Console\Commands\DatabaseBackUp',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('driver:rideNotification')->everyMinute()->withoutOverlapping()->after(function() use($schedule) {
        //    $schedule->command('masterDriver:Notification')->everyMinute()->withoutOverlapping();
        // });
        // $schedule->command('inspire')
        //          ->hourly();
       
        // $schedule->command('sheduleRide:Notitification')
        //    ->everyMinute();
        // $schedule->command('driver:rideNotification')
        //    ->everyMinute();  
        // $schedule->command('sheduleRide:Notification')
        //    ->everyMinute();
        // $schedule->command('masterDriver:Notification')
        //    ->everyMinute()->withoutOverlapping();
        $schedule->command('SendRideNotificationToDriver:OnScheduleTime')->everyMinute();
        $schedule->command('SendRideNotification:OnScheduleTime')->everyMinute();
        $schedule->command('SendRideNotification:AfterScheduleTime')->everyMinute();
        $schedule->command('SendRideNotification:ToMasterAfterScheduleTime')->everyMinute();
        $schedule->command('DriverActiveState:FirstReminder')->everyMinute();
        $schedule->command('MakeUnactiveDriver:Unavailable')->everyMinute();
        $schedule->command('DriverActiveState:SecondReminder')->everyMinute();
        $schedule->command('MakeUnactiveDriver:Logout')->everyMinute();
        $schedule->command('SendRideNotificationToMaster:AssignedDriverNoResponse')->everyMinute();
        $schedule->command('RideNotificationToUser:BeforeRideTime')->everyMinute();
		// $schedule->command('ride_begin:notify')->everyFiveMinutes();
        
        $schedule->command('delete_temp_users:only_last_name')->daily();
        $schedule->command('delete_temp_users:only_phone_number')->daily();
        $schedule->command('database:backup')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
