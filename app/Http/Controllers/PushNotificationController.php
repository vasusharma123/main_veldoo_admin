<?php

namespace App\Http\Controllers;
use Config;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Complaint;
use Mail;
use App\User;
use App\Notification;
use Helper;
use Twilio\Rest\Client;
use App\PushNotification;
use Storage;
use Auth;
use App\Jobs\SendNotificationJob;

class PushNotificationController extends Controller
{
	public function __construct() {
		$this->table = '';
		$this->folder = 'push_notification';
		view()->share('route', 'notifications');
		$this->limit = Config::get('limit');
   	}

    public function index(Request $request){
		
		$this->limit = 20;
		
		$data = array();
		$data = array('title' => 'Drivers', 'action' => 'List Drivers');
		
		$records = DB::table('push_notifications');
		
		$user_id = Auth::user()->id;
		if(!empty($request->input('text'))){
			$text = $request->input('text');
			$records->whereRaw("(title LIKE '%$text%' OR description LIKE '%$text%') AND service_provider_id=$user_id");
		}
		
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}
		
		$data['records'] = $records->where(['service_provider_id'=>$user_id])->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] = $request->input('orderby');
		$data['order'] = $request->input('order');
        if ($request->ajax()) {
            return view("admin.{$this->folder}.index_element")->with($data);
        }
		
		return view("admin.{$this->folder}.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
	    $breadcrumb = array('title'=>'Send Notification to driver or users','action'=>'Send Notification to driver or users');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		if ($request->ajax()) {
			return rand();
		}
	    return view("admin.{$this->folder}.push-create")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$rules = [
			'receiver' => 'required',
			'description' => 'required',
			'title' => 'required',
		];
		$request->validate($rules);
		$user_type = [$request->receiver];
		if ($request->receiver == 3) 
		{
			$user_type = [1,2];
		}
		$total_page = 0;
		if ($request->receiver==1 || $request->receiver==3) 
		{
			$total_page_users = DB::select("SELECT COUNT(users.id) as count FROM `users` JOIN rides on rides.user_id = users.id WHERE rides.service_provider_id = ".Auth::user()->id." AND deleted = 0 AND deleted_at is null and user_type = 1");
			$total_page += $total_page_users[0]->count;
		}
		if ($request->receiver==2 || $request->receiver==3) 
		{
			$total_page_driver = DB::select("SELECT COUNT(users.id) as count FROM `users` WHERE service_provider_id = ".Auth::user()->id." AND deleted = 0 AND deleted_at is null and user_type = 2");
			$total_page += $total_page_driver[0]->count;
		}
		$total_page = ceil($total_page/100);
		// dd($total_page);
		$data = collect($request->all())->forget(['image','_token','submit'])->put('total_page',$total_page)->put('current_page',1)->put('service_provider_id',Auth::user()->id)->toArray();
		$notification = new PushNotification;
		$notification->fill($data);
		$notification->save();

		if($request->hasFile('image') && $request->file('image')->isValid()){
					
			$imgName = Storage::disk('public')->putFileAs(
				'push-notifications/'.$notification->id, $request->file('image'),'notification-image.'.$request->image->extension()
			);
			$itemData = PushNotification::find($notification->id);
			$itemData->image = $imgName;
			$itemData->update();
		}
		// foreach($users as $user){
		// 	$data=array('data'=>$request->message,'user'=>$user->first_name.' '.$user->last_name);
		// 	if($request->notification_type=="email"){
		// 	//notification via email
		// 	$res=Mail::send('admin.push_notification.email', $data, function($message) use ($user) {
			// 			$message->to($user->email)->subject('New Updates');
			
		// 		});
		// 	}
		// 	elseif($request->notification_type=="notification"){
		// 		// notification via push notification
		// 		//$user=\App\User::where('id',111)->first();
		// 		$title = 'New Updates';
		// 		$message = strip_tags($request->message);
		// 		$type=1;
		// 		$additional = ['type'=>$type,'ride_id'=>0,'user_id'=>$user->id];
		// 		$deviceToken=$user->device_token;
		// 		$deviceType=$user->device_type;
		// 		if($deviceType=="android"){
		// 		$res=send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		// 		}elseif($deviceType=="ios"){
		// 			$res=send_iosnotification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		// 		}
		// 		$notification = new Notification();
		// 		$notification->title = $title;
		// 		$notification->description = $message;
		// 		$notification->type = $type;
		// 		$notification->user_id = $user->id;
		// 		$notification->save();
		// 	}elseif($request->notification_type=="sms"){
		// 		// notification via sms
		// 		$account_id = env('TWILIO_SID');
		// 		$auth_token =env('TWILIO_AUTH_TOKEN');
		// 		$from_phone_number = '+14156505709';
		// 		$client = new Client($account_id, $auth_token);
		// 		$messageContent=strip_tags($request->message);
		// 		$client->messages->create('+'.$user->country_code.''.$user->phone,[
		// 				"body" =>'Hi'.' '.$user->first_name.' '.$user->last_name.' '.$messageContent,
		// 				"from" => $from_phone_number
		// 			   ]);
		// 	}
		// }
		// dd($notification);
		dispatch(new SendNotificationJob($notification))->onQueue('push_notifications');
		return redirect()->route('push-notifications.index')->with('success', __('Notification Sent Successfully!'));
    }
}
