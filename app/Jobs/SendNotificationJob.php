<?php
namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendEmailTest;
use Mail;
use DB;
use App\PushNotification;
use App\Jobs\SendNotificationJob;
use App\User;
use Auth;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $notification;
    /**
    * Create a new job instance.
    *
    * @return void
    */


    public function __construct($notification)
    {
        $this->notification = $notification;
    }
    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        // dd('d');
        $itemData = PushNotification::find($this->notification->id);
        $additional = ['type' => "", 'ride_id' => "", 'ride_data' => ""];
        $current_page = $itemData->current_page;

        $user_type = [$itemData->receiver];
        if ($itemData->receiver == 3) 
		{
			$user_type = [1,2];
		}
        $android_tokens = [];
		if ($itemData->receiver==1 || $itemData->receiver==3) 
        {
            $android_users = User::whereNotNull('device_token')->whereIn('user_type',$user_type)->where('device_type','android')->whereHas('user_ride',function($user_ride)
            {
                $user_ride->where('service_provider_id',Auth::user()->id);

            })->where('deleted',0)->whereNull('deleted_at')->paginate(50, ['*'], 'page', $current_page);
            foreach ($android_users as $key => $android_user) 
            {
                $android_tokens[] = $android_user->device_token;
            }
        }

		if ($itemData->receiver==2 || $itemData->receiver==3) 
        {
            $android_driver = User::whereNotNull('device_token')->whereIn('user_type',$user_type)->where('device_type','android')->where('service_provider_id',Auth::user()->id)->where('deleted',0)->whereNull('deleted_at')->paginate(50, ['*'], 'page', $current_page);

            foreach ($android_driver as $key => $android_drive) 
            {
                $android_tokens[] = $android_drive->device_token;
            }
        }
        // dd($android_tokens);
        if (!empty($android_tokens)) 
        {
            bulk_firebase_android_notification($itemData->title, $itemData->description, $android_tokens, $additional);
        }
        
        $ios_tokens = [];

        if ($itemData->receiver==1 || $itemData->receiver==3) 
        {
            $ios_users = User::whereNotNull('device_token')->whereIn('user_type',$user_type)->where('device_type','ios')->whereHas('user_ride',function($user_ride)
            {
                $user_ride->where('service_provider_id',Auth::user()->id);

            })->where('deleted',0)->whereNull('deleted_at')->paginate(50, ['*'], 'page', $current_page);
            foreach ($ios_users as $key => $ios_user) 
            {
                $ios_tokens[] = $ios_user->device_token;
            }
        }

		if ($itemData->receiver==2 || $itemData->receiver==3) 
        {
            $ios_drivers = User::whereNotNull('device_token')->whereIn('user_type',$user_type)->where('device_type','ios')->where('service_provider_id',Auth::user()->id)->where('deleted',0)->whereNull('deleted_at')->paginate(50, ['*'], 'page', $current_page);

            foreach ($ios_drivers as $key => $ios_driver) 
            {
                $ios_tokens[] = $ios_driver->device_token;
            }
        }

		// $ios_users = User::whereNotNull('device_token')->whereIn('user_type',$user_type)->where('device_type','ios')->where('deleted',0)->whereNull('deleted_at')->paginate(100, ['*'], 'page', $current_page);
        // foreach ($ios_users as $key => $ios_user) 
        // {
        //     $ios_tokens[] = $ios_user->device_token;
        // }
        
        if (!empty($ios_tokens)) 
        {
            bulk_pushok_ios_notification($itemData->title, $itemData->description, $ios_tokens, $additional, $sound = 'default', $itemData->receiver);
        }

        // DB::table('test_jobs')->insert(['data'=>$itemData->current_page]);
        if ($current_page!=$itemData->total_page) 
        {
            $itemData->current_page = $itemData->current_page+1;
            $itemData->update();
            dispatch(new SendNotificationJob($itemData))->onQueue('push_notifications');
        }
    }
}

