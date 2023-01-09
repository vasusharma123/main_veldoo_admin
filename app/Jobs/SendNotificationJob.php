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
        $itemData = PushNotification::find($this->notification->id);
        $additional = ['type' => "", 'ride_id' => "", 'ride_data' => ""];
        $current_page = $itemData->current_page;

        $user_type = [$itemData->receiver];
        if ($itemData->receiver == 3) 
		{
			$user_type = [1,2];
		}
		$android_users = User::whereNotNull('device_token')->whereIn('user_type',$user_type)->where('device_type','android')->where('deleted',0)->whereNull('deleted_at')->paginate(100, ['*'], 'page', $current_page);
        $android_tokens = [];
        foreach ($android_users as $key => $android_user) 
        {
            $android_tokens[] = $android_user->device_token;
        }
        if (!empty($android_tokens)) 
        {
            bulk_firebase_android_notification($itemData->title, $itemData->description, $android_tokens, $additional);
        }
        
		$ios_users = User::whereNotNull('device_token')->whereIn('user_type',$user_type)->where('device_type','ios')->where('deleted',0)->whereNull('deleted_at')->paginate(100, ['*'], 'page', $current_page);
        $ios_tokens = [];
        foreach ($ios_users as $key => $ios_user) 
        {
            $ios_tokens[] = $ios_user->device_token;
        }
        
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

