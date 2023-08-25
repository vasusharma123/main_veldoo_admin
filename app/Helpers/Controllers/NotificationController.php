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
use Auth;

class NotificationController extends Controller
{
	public function __construct() {
		$this->table = '';
		$this->folder = 'push_notification';
		view()->share('route', 'notifications');
		$this->limit = Config::get('limit');
   }
    public function index(Request $request)
    {
	
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
	    $breadcrumb = array('title'=>'Send Important Alerts & Updates','action'=>'Send Important Alerts & Updates');
		
		$data = [];
		$data = array_merge($breadcrumb,$data);
		if ($request->ajax()) {
			return rand();
		}
	    return view("admin.{$this->folder}.create")->with($data);
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
			'message' => 'required',
			'users' => 'required',
			'notification_type' => 'required',
		];
		$request->validate($rules);
		if($request->users==1){
		$users=User::whereIn('user_type',['1','2','4'])->get();
			//$users=User::whereIn('id',['116','107'])->get();
		
		}elseif($request->users==2){
			$users=User::where('user_type',1)->get();
			//$users=User::where('id',116)->get();
			
		}if($request->users==3){
			$users=User::where('user_type',2)->get();
			//$users=User::where('user_type',107)->get();
		}
		if($request->users==4){
			$users=User::where('user_type',4)->get();
			//$users=User::where('user_type',107)->get();
		}
		
		foreach($users as $user){
			$data=array('data'=>$request->message,'user'=>$user->first_name.' '.$user->last_name);
			if($request->notification_type=="email"){
			//notification via email
			$res=Mail::send('admin.push_notification.email', $data, function($message) use ($user) {
					$message->to($user->email)->subject('New Updates');
				});
			}
			elseif($request->notification_type=="notification"){
				// notification via push notification
				$title = 'New Updates';
				$message = 'New Updates';
				$type=4;
				$additional = ['type'=>$type,'ride_id'=>0,'user_id'=>$user->id];
				$deviceToken=$user->device_token;
				$deviceType=$user->device_type;
				$res=send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
				$notification = new Notification();
				$notification->title = $title;
				$notification->description = $message;
				$notification->type = $type;
				$notification->user_id = $user->id;
				$notification->save();
			}elseif($request->notification_type=="sms"){
				// notification via sms
				$account_id = env('TWILIO_SID');
				$auth_token =env('TWILIO_AUTH_TOKEN');
				$from_phone_number = '+14156505709';
				$client = new Client($account_id, $auth_token);
				$messageContent=strip_tags($request->message);
				$client->messages->create('+'.$user->country_code.''.$user->phone,[
						"body" =>'Hi'.' '.$user->first_name.' '.$user->last_name.' '.$messageContent,
						"from" => $from_phone_number
					   ]);
			}
		}
		return back()->with('success', __('Notification Sent Successfully!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Posts $posts)
    public function update(Request $request, $id)
    {
		
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $posts)
    {
        //
    }
	
	public function promotionalOffer(Request $request){
		$breadcrumb = array('title'=>'Send Promotional Offers','action'=>'Send Promotional Offers');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		if ($request->ajax()) {
			return rand();
		}
	    return view("admin.{$this->folder}.promotional_offer")->with($data);
	}
	
	
	public function storePromotionalOffer(Request $request){
		$rules = [
			'message' => 'required',
			'users' => 'required',
		];
		$request->validate($rules);
		$title = 'New Offers';
		$message = 'New Offers';
		$type=5;
		if($request->users==1){
		$users=\App\User::where('user_type',['1','2','4'])->get();
		}elseif($request->users==2){
		$users=\App\User::where('user_type',1)->get();
		}elseif($request->users==3){
		$users=\App\User::whereIn('user_type',2)->get();
		}elseif($request->users==4){
		$users=\App\User::whereIn('user_type',4)->get();
		}
		foreach($users as $user){
		$additional = ['type'=>$type,'ride_id'=>0,'user_id'=>$user->id];
		$deviceToken=$user->device_token;
		$deviceType=$user->device_type;
		$res=send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $user->id;
		$notification->save();
		}
		return back()->with('success', __('Sent Successfully!'));
	}
	
	
		public function companyNotifications(Request $request){
			$breadcrumb = array('title'=>'Notification','action'=>'List Notification');
			$data = [];
			
			if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
            DB::table('notifications')->where([['id', $request->input('id')]])->delete();
			}

			$userId=Auth::user()->id;
			$notifications = \App\Notification::where('user_id',$userId);
			if(!empty($request->input('text'))){
				$notifications->where('title', 'like', '%'.$request->input('text').'%')
				->orWhere('description', 'like', '%'.$request->input('text').'%');
				}
		
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
            $notifications->orderBy($request->input('orderby'), $request->input('order'));
        } else {
            $notifications->orderBy('id', 'desc');
        }
		
		$data['notifications'] = $notifications->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('company.notification.index_element')->with($data);
        }
        return view('company.notification.index')->with($data);
		
	}
	
}
