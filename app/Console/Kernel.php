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
            
		// $schedule->command('ride_begin:notify')->everyFiveMinutes();
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
