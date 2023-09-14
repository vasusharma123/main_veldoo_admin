<?php

namespace App\Http\Controllers;

use Config;
use App\Page;
use App\Ride;
use App\User;
use App\Price;
use App\OtpVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\API\UserWebController;
use Exception;
use App\Notification;
use App\RideHistory;
use App;
use App\SMSTemplate;
use App\Setting;
use Log;
use Pushok\AuthProvider;
use Pushok\Client;
use Pushok\Notification as P_Notification;
use Pushok\Payload;
use Pushok\Payload\Alert;
use Edujugon\PushNotification\PushNotification;
use App\Http\Resources\RideResource;
use Auth;

class PageController extends Controller
{
	public function __construct() {
		$this->table = 'pages';
		$this->folder = 'pages';
		view()->share('route', 'page');
		$this->limit = Config::get('limit');
   }
	public function phpinfo(Request $request)
	{
		phpinfo();
	}
	public function home(Request $request)
	{
	   return view("frontend.pages.home");

	}
	public function about(Request $request)
	{
	    $breadcrumb = array('title'=>'Pages','action'=>'About Us');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		$type = 1;
		$data['record'] = Page::where(['type'=>$type])->where('service_provider_id',Auth::user()->id)->first();
		$data['record']['type'] = $type;
		$data['previewRoute'] = 'about';
	    return view("admin.{$this->folder}.page")->with($data);
	}
	public function terms(Request $request)
	{
	    $breadcrumb = array('title'=>'Pages','action'=>'Terms & Conditions');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		$type = 3;
		$data['record'] = Page::where(['type'=>$type])->where('service_provider_id',Auth::user()->id)->first();
		$data['record']['type'] = $type;
		$data['previewRoute'] = 'terms';
	    return view("admin.{$this->folder}.page")->with($data);
	}
	public function policy(Request $request)
	{
	    $breadcrumb = array('title'=>'Pages','action'=>'Privacy Policy');
		$data = [];
		$data = array_merge($breadcrumb,$data);
		$type = 2;
		$data['record'] = Page::where(['type'=>$type])->where('service_provider_id',Auth::user()->id)->first();
		$data['record']['type'] = $type;
		$data['previewRoute'] = 'policy';
	    return view("admin.{$this->folder}.page")->with($data);
	}
	public function about_front()
	{
	    $breadcrumb = array('title'=>'Home','action'=>'About Us');

		$data = [];
		$data = array_merge($breadcrumb,$data);
		$data['record'] = Page::where(['type'=>1])->first();
	    return view("frontend.{$this->folder}.page")->with($data);
	}
	public function terms_front()
	{
	    $breadcrumb = array('title'=>'Pages','action'=>'Terms & Conditions');

		$data = [];
		$data = array_merge($breadcrumb,$data);
		$data['record'] = Page::where(['type'=>3])->first();
	    return view("frontend.{$this->folder}.page")->with($data);
	}
	public function policy_front()
	{
		echo "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>";
		die;
	   /*  $breadcrumb = array('title'=>'Pages','action'=>'Privacy Policy');

		$data = [];
		$data = array_merge($breadcrumb,$data);
		$data['record'] = Page::where(['type'=>2])->first();
	    return view("frontend.{$this->folder}.page")->with($data); */
	}
    public function store(Request $request)
    {

		$rules = [
			'title' => 'required',
			'content' => 'required',
			'type' => 'required',
		];
		$request->validate($rules);
		$request = $request->except(['_method', '_token']);
		// dd($request);
		Page::updateOrCreate(
			['type'=>$request['type'],'service_provider_id'=>Auth::user()->id],
			['title' => $request['title'],'content' => $request['content'],'service_provider_id'=>Auth::user()->id ]
		);
		return back()->with('success', __('Record updated!'));
    }
	public function scheduleRide(Request $request){
		echo date_default_timezone_get();
	echo $from = date("Y-m-d H:i:s");
	$to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +10 minutes"));
			$rides = Ride::query()->where([['schedule_ride', '=', 1],['status', '=', 0],['notification_send', '=', 0]])->whereBetween('schedule_time', [$from, $to])->get()->toArray();
			/* echo "<pre>";
		print_r($rides); die;
		echo "</pre>"; */
		try {

			if(!empty($rides))
			{
          foreach($rides as $ride)
		  {
			  $pick_lat = $ride['pick_lat'];
            $pick_lng = $ride['pick_lng'];
			$dest_lat = $ride['dest_lat'];
            $dest_lng = $ride['dest_lng'];

			$query = User::select("users.*"
                    ,DB::raw("3959 * acos(cos(radians(" . $pick_lat . "))
                    * cos(radians(users.current_lat))
                    * cos(radians(users.current_lng) - radians(" . $pick_lng . "))
                    + sin(radians(" .$pick_lat. "))
                    * sin(radians(users.current_lat))) AS distance"));
					$query->where('user_type', '=',2)->having('distance', '<', 20)->orderBy('distance','asc');
					$drivers = $query->get()->toArray();
	 $driverids = array();
			if(!empty($drivers))
			{
				foreach($drivers as $driver)
				{
					$driverids[] = $driver['id'];
				$title = __('New Booking');
		$message = __('You Received new booking');


		$deviceToken = $driver['device_token'];
		$additional = ['type'=>1,'ride_id'=>0];
		//$additional = ['type'=>1];
	//echo $deviceToken; die;

		$deviceType = $driver['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
			}
				}
				$driverids = implode(",",$driverids);
			}
			echo $ride['id'];
			print_r($driverids);
			$ridedata = Ride::where(['id'=>$ride['id']])->first();
			$ridedata->driver_id = $driverids;
			$ridedata->notification_send = 1;
			$ridedata->save();
		  }
		}



			//	return response()->json(['message'=>'Booking Created successfully','data'=>$ride], $this->successCode);


		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	}
		public function successpayment() {
			echo "success"; die;
		// send email
/* $msg = "Results: " . print_r( $_REQUEST, true );
mail("lalitattri.orem@gmail.com","My subject",$msg); */
/* $booking_id = $_REQUEST['item_number'];
	$transid = $_REQUEST['tx'];
if($_REQUEST['cm'] == 1)
{


							$bookingupdate = $this->Booking->updateAll( array('Booking.status' => 0,'PendingAmount.paid' => 1),array('Booking.id' => $booking_id));
						$getuser = $this->User->find('first', array('conditions' =>array('User.id'=> $booking['Booking']['saloon_id'])));
						$getwalletamount = $getuser['User']['wallet'];
						$finalwallet = $getwalletamount+$_REQUEST['amt'];
						$walletupdate = $this->User->updateAll( array('User.wallet' => $finalwallet),array('User.id' => $booking['Booking']['saloon_id']));
						$this->request->data['Wallet']['booking_id'] = $booking_id;
						 $this->request->data['Wallet']['saloon_id'] = $booking['Booking']['saloon_id'];
						 $this->request->data['Wallet']['price'] = $booking['Booking']['price'];
						 $this->request->data['Wallet']['type'] = 1;

						 $this->Wallet->create();
						 $this->Wallet->save($this->request->data);
						 $customeruserdata = $this->User->find("first", array('conditions' => array('User.id' => $booking['Booking']['user_id'])));
						 $saloonuserdata = $this->User->find("first", array('conditions' => array('User.id' => $booking['Booking']['saloon_id'])));

						 $usertoken = $saloonuserdata['User']['deviceToken'];
							$devicetype = $saloonuserdata['User']['deviceType'];

							 // user Type 1 => customer, 2 => saloon
							//notification  type 1 => order, 2 => Others
							$notifytitle = "New Booking";
							$customername = $customeruserdata['User']['name'];
							$msg = "You got a new booking from $customername";
							$type = 1;
							$notification_id = $booking_id;

							$usertype = 2;

						 if($devicetype == "android")
								{

							$nono = $this->Basic->send_notification($usertoken,$msg,$type,$notifytitle,$usertype,$notification_id);
								}
								if($devicetype == "ios")
								{
							$nono = $this->Basic->send_inotification($usertoken,$msg,$type,$notifytitle,$usertype,$notification_id);
								}
								if($nono)
								{
									$this->request->data['Notification']['title'] = $notifytitle;
						 $this->request->data['Notification']['message'] = $msg;
						 $this->request->data['Notification']['user_type'] = $usertype;
						 $this->request->data['Notification']['notification_id'] = $notification_id;
						 $this->request->data['Notification']['notification_type'] = $type;
						 $this->request->data['Notification']['user_id'] = $booking['Booking']['saloon_id'];
						  $this->Notification->create();
						 $this->Notification->save($this->request->data);
								}

						echo "<h1>Your Transaction is successfull</h1>"; die;
}
if($_REQUEST['cm'] == 2)
{
	$booking = $this->Booking->find('first', array('conditions' =>array('Booking.id'=> $booking_id)));
	$pendingamountupdate = $this->PendingAmount->updateAll( array('PendingAmount.block' => 0,'PendingAmount.paid' => 1),array('PendingAmount.booking_id' => $booking_id));

	$getuser = $this->User->find('first', array('conditions' =>array('User.id'=> $booking['Booking']['saloon_id'])));
						$getwalletamount = $getuser['User']['wallet'];
						$finalwallet = $getwalletamount+$_REQUEST['amt'];
						$walletupdate = $this->User->updateAll( array('User.wallet' => $finalwallet),array('User.id' => $booking['Booking']['saloon_id']));
						$this->request->data['Wallet']['booking_id'] = $booking_id;
						 $this->request->data['Wallet']['saloon_id'] = $booking['Booking']['saloon_id'];
						 $this->request->data['Wallet']['price'] = $_REQUEST['amt'];
						 $this->request->data['Wallet']['type'] = 1;

						 $this->Wallet->create();
						 $this->Wallet->save($this->request->data);

	$customeruserdata = $this->User->find("first", array('conditions' => array('User.id' => $booking['Booking']['user_id'])));
	 $saloonuserdata = $this->User->find("first", array('conditions' => array('User.id' => $booking['Booking']['saloon_id'])));

						 $usertoken = $saloonuserdata['User']['deviceToken'];
							$devicetype = $saloonuserdata['User']['deviceType'];

							 // user Type 1 => customer, 2 => saloon
							//notification  type 1 => order, 2 => Others
							$notifytitle = "Cancellation fee Paid";
							$customername = $customeruserdata['User']['name'];
							$msg = "$customername has paid the cancellation fee";
							$type = 1;
							$notification_id = $booking_id;

							$usertype = 2;

						 if($devicetype == "android")
								{

							$nono = $this->Basic->send_notification($usertoken,$msg,$type,$notifytitle,$usertype,$notification_id);
								}
								if($devicetype == "ios")
								{
							$nono = $this->Basic->send_inotification($usertoken,$msg,$type,$notifytitle,$usertype,$notification_id);
								}
								if($nono)
								{
									$this->request->data['Notification']['title'] = $notifytitle;
						 $this->request->data['Notification']['message'] = $msg;
						 $this->request->data['Notification']['user_type'] = $usertype;
						 $this->request->data['Notification']['notification_id'] = $notification_id;
						 $this->request->data['Notification']['notification_type'] = $type;
						 $this->request->data['Notification']['user_id'] = $booking['Booking']['saloon_id'];
						  $this->Notification->create();
						 $this->Notification->save($this->request->data);
								}
								echo "<h1>Your Transaction is successfull</h1>"; die;
} */

	}
	public function cancelpayment() {
		echo "<h1>".__("Sorry Your Payment is Canceled")."</h1>"; die;
	}

	public function booking() {
		// app()->setLocale("de");
		// App::setLocale('de');
		$vehicle_types = Price::orderBy('sort')->get();
		return view('booking')->with(['vehicle_types' => $vehicle_types]);
	}

	public function booking_form(Request $request) {
		if(empty($request->carType)){
			return redirect()->route("booking_taxisteinemann");
		}
		$vehicle_type = Price::find($request->carType);
		$input = $request->all();
		return view('booking_form')->with(['vehicle_type' => $vehicle_type, 'input' => $input]);
	}

	public function send_otp_before_ride_booking(Request $request)
	{
		try
		{
			if (!$request->has('g-recaptcha-response'))
			{
				return response()->json(['status' => 0, 'message' => 'Invalid Request']);
			}
			$captcha = $request['g-recaptcha-response'];
			$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".env('RECAPTCHA_SITE_KEY')."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
			if(!is_array($response) && isset($response) && $response['success'] == false)
			{
				return response()->json(['status' => 0, 'message' => 'Invalid Request']);
			}
			// dd($request->all());
			$expiryMin = config('app.otp_expiry_minutes');
			$otp = rand(1000, 9999);
			$haveOtp = OtpVerification::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0")])->first();
			$now = Carbon::now();
			$endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');
			if ($haveOtp)
			{
				if ($now->gt($haveOtp->expiry))
				{
					OtpVerification::updateOrCreate(
						['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0")],
						['otp' => $otp, 'expiry' => $endTime, 'device_type' => 'web']
					);
				}
				else
				{
					$otp = $haveOtp->otp;
				}
			}
			else
			{
				OtpVerification::updateOrCreate(
					['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0")],
					['otp' => $otp, 'expiry' => $endTime, 'device_type' => 'web']
				);
			}

			$SMSTemplate = SMSTemplate::where(['unique_key'=>'send_otp_create_booking','service_provider_id'=>Auth::user()->id])->first();
			$body = str_replace('#OTP#',$otp,$SMSTemplate->english_content);//"Dear User, your Veldoo verification code is ".$otp.". Use this password to complete your booking";
			if (app()->getLocale()!="en")
			{
				$body = str_replace('#OTP#',$otp,$SMSTemplate->german_content);
			}
			$this->sendSMS("+".$request->country_code, ltrim($request->phone, "0"), $body);
			return response()->json(['status' => 1, 'message' => __('OTP is sent to Your Mobile Number')]);
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		} catch (\Exception $exception) {
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}
	}

	public function verify_otp_and_ride_booking(Request $request)
	{
		// dd($request->all());
		$expiryMin = config('app.otp_expiry_minutes');
		$now = Carbon::now();
		$haveOtp = OtpVerification::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'otp' => $request->otp])->first();
		if (empty($haveOtp))
		{
			return response()->json(['status' => 0, 'message' => __('Verification code is incorrect, please try again')]);
		}

		if ($now->diffInMinutes($haveOtp->expiry) < 0) {
			return response()->json(['status' => 0, 'message' => __('Verification code has expired')]);
		}
		$haveOtp->delete();

		if ($request->pick_lat==$request->dest_lat)
		{
			$request->dest_address = "";
			$request->dest_lat = "";
			$request->dest_lng = "";
		}

		$webobj = new UserWebController;
		if ($now->diffInMinutes($request->ride_time) <= 15) {
			$jsonResponse = $webobj->create_ride_driver($request);
		} else {
			$jsonResponse = $webobj->book_ride($request);
		}
		$content = $jsonResponse->getContent();
		$responseObj = json_decode($content, true);
		$user = User::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'user_type' => 1])->first();
		if($responseObj['status'] == 1){
			$message_content = "Your Booking has been confirmed with Veldoo, for time";
			$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			$SMSTemplate = SMSTemplate::where(['unique_key'=>'send_booking_details_after_create_booking','service_provider_id'=>Auth::user()->id])->first();//find(2);
			if ($request->url_type=="taxisteinemann") {
				$message_content = str_replace('#LINK#',route('list_of_booking_taxisteinemann',$user->random_token),str_replace('#TIME#',date('d M, Y h:ia', strtotime($request->ride_time)),$SMSTemplate->english_content));
				if (app()->getLocale()!="en")
				{
					$message_content = str_replace('#LINK#',route('list_of_booking_taxisteinemann',$user->random_token),str_replace('#TIME#',date('d M, Y h:ia', strtotime($request->ride_time)),$SMSTemplate->german_content));
				}
			} else {
				$message_content = str_replace('#LINK#',route('list_of_booking_taxi2000',$user->random_token),str_replace('#TIME#',date('d M, Y h:ia', strtotime($request->ride_time)),$SMSTemplate->english_content));
				if (app()->getLocale()!="en")
				{
					$message_content = str_replace('#LINK#',route('list_of_booking_taxi2000',$user->random_token),str_replace('#TIME#',date('d M, Y h:ia', strtotime($request->ride_time)),$SMSTemplate->german_content));
				}
			}
			$this->sendSMS("+".$request->country_code, ltrim($request->phone, "0"), $message_content);
		}
		return $jsonResponse;
	}

	public function myBooking() {
		return view('my_booking');
	}

	public function list_of_booking($token=null){
		$data['user'] = [];
		$data['token'] = "";
		if ($token)
		{
			$data['user'] = User::where('random_token',$token)->first();
			if ($data['user'])
			{
				$data['token'] = $token;
				$now = Carbon::now()->subHour();
				$rideList = Ride::where(['user_id' => $data['user']->id, 'platform' => 'web'])->where('ride_time', '>', $now)->where(function ($query) {
					$query->where('status', '!=', 3)->where('status', '!=', -3)->where('status', '!=', -2);
				})->with(['driver', 'vehicle'])->orderBy('created_at','DESC')->get();
				foreach ($rideList as $key => $ride) {
					$rideList[$key]->ride_time = date('D d-m-Y H:i',strtotime($ride->ride_time));
					$rideList[$key]->create_date = date('D d-m-Y H:i',strtotime($ride->created_at));
					$driver_ids = explode(',', $ride->driver_id);
					if (count($driver_ids) > 1 && $ride->status != 1)
					{
						$rideList[$key]->driver_name = "Not Available";
					}
					else
					{
						$rideList[$key]->driver_name = $ride->driver ? wordwrap($ride->driver->first_name, 10, "\n", true) : '';
					}
					$ride_type = "Not Available";
					if ($ride->ride_type == 1)
					{
						$ride_type = "Ride Schedule";
					}
					elseif($ride->ride_type == 2)
					{
						$ride_type = "Ride Now";
					}
					elseif($ride->ride_type == 3)
					{
						$ride_type = "Instant Ride";
					}
					elseif($ride->ride_type == 4)
					{
						$ride_type = "Ride Sharing";
					}
					$rideList[$key]->ride_type = $ride_type;

					$ride_status = "";
					$ride_status_latest = "";
					if ($ride->status == -2) {
						$ride_status = "Cancelled";
						$ride_status_latest = "Ride Cancelled";
					} elseif ($ride->status == -1) {
						$ride_status_latest = "Ride Rejected";
						$ride_status = "Rejected";
					} elseif ($ride->status == 1) {
						$ride_status_latest = "Driver will arrive in #time#";
						$ride_status = "Accepted";
					} elseif ($ride->status == 2) {
						$ride_status_latest = "Ride in progress and will completed in #time#";
						$ride_status = "Started";
					} elseif ($ride->status == 4) {
						$ride_status_latest = "Driver has arrived";
						$ride_status = "Driver Reached";
					} elseif ($ride->status == 3) {
						$ride_status_latest = "Ride Completed";
						$ride_status = "Completed";
					} elseif ($ride->status == -3) {
						$ride_status_latest = "Ride Cancelled By You";
						$ride_status = "Cancelled";
					} elseif ($ride->status == 0) {
						$ride_status_latest = "Pending";
						$ride_status = "Pending";
					} elseif ($ride->status == -4) {
						$ride_status_latest = "Pending";
						$ride_status = "Pending";
					} elseif ($ride->ride_status > date('Y-m-d H:i:s')) {
						$ride_status_latest = "Upcoming Ride";
						$ride_status = "Upcoming";
					} else if (!$ride->driver) {
						$ride_status_latest = "Pending";
						$ride_status = "Pending";
						$rideList[$key]->status = 0;
					}
					// dd($ride);
					$rideList[$key]->ride_status = $ride_status;
					$rideList[$key]->ride_status_latest = $ride_status_latest;
					$rideList[$key]->user_name = ($ride->user ? $ride->user->first_name : 'Not Available').' '.($ride->user ? $ride->user->last_name : '');
				}
				$data['rides'] = $rideList;
			}
		}
		return view('list_of_booking',$data);
	}


	public function booking_details($id)
	{
		$ride = Ride::where(['platform' => 'web'])->where(function ($query) {
			$query->where('status', '!=', 3)->where('status', '!=', -3)->where('status', '!=', -2);
		})->with(['driver', 'vehicle'])->find($id);

		if (!$ride)
		{
			return null;
		}

		$ride->ride_time = date('D d-m-Y H:i',strtotime($ride->ride_time));
		$ride->create_date = date('D d-m-Y H:i',strtotime($ride->created_at));
		$driver_ids = explode(',', $ride->driver_id);
		if (count($driver_ids) > 1 && $ride->status != 1)
		{
			$ride->driver_name = "Not Available";
		}
		else
		{
			$ride->driver_name = $ride->driver ? wordwrap($ride->driver->first_name, 10, "\n", true) : '';
		}
		$ride_type = "Not Available";
		if ($ride->ride_type == 1)
		{
			$ride_type = "Ride Schedule";
		}
		elseif($ride->ride_type == 2)
		{
			$ride_type = "Ride Now";
		}
		elseif($ride->ride_type == 3)
		{
			$ride_type = "Instant Ride";
		}
		elseif($ride->ride_type == 4)
		{
			$ride_type = "Ride Sharing";
		}
		$ride->ride_type = $ride_type;

		$ride_status = "";
		$ride_status_latest = "";
		if ($ride->status == -2) {
			$ride_status = "Cancelled";
			$ride_status_latest = "Ride Cancelled";
		} elseif ($ride->status == -1) {
			$ride_status_latest = "Ride Rejected";
			$ride_status = "Rejected";
		} elseif ($ride->status == 1) {
			$ride_status_latest = "Driver will arrive in #time#";
			$ride_status = "Accepted";
		} elseif ($ride->status == 2) {
			$ride_status_latest = "Ride in progress and will completed in #time#";
			$ride_status = "Started";
		} elseif ($ride->status == 4) {
			$ride_status_latest = "Driver has arrived";
			$ride_status = "Driver Reached";
		} elseif ($ride->status == 3) {
			$ride_status_latest = "Ride Completed";
			$ride_status = "Completed";
		} elseif ($ride->status == -3) {
			$ride_status_latest = "Ride Cancelled By You";
			$ride_status = "Cancelled";
		} elseif ($ride->status == 0) {
			$ride_status_latest = "Pending";
			$ride_status = "Pending";
		} elseif ($ride->status == -4) {
			$ride_status_latest = "Pending";
			$ride_status = "Pending";
		} elseif ($ride->ride_status > date('Y-m-d H:i:s')) {
			$ride_status_latest = "Upcoming Ride";
			$ride_status = "Upcoming";
		} else if (!$ride->driver) {
			$ride_status_latest = "Pending";
			$ride_status = "Pending";
			$ride->status = 0;
		}
		// dd($ride);
		$ride->ride_status = $ride_status;
		$ride->ride_status_latest = $ride_status_latest;
		$ride->user_name = ($ride->user ? $ride->user->first_name : 'Not Available').' '.($ride->user ? $ride->user->last_name : '');

		return $ride;
	}

	public function send_otp_for_my_bookings(Request $request)
	{
		try
		{
			// dd($request->all());
			if (!$request->has('g-recaptcha-response'))
			{
				return response()->json(['status' => 0, 'message' => 'Invalid Request']);
			}
			$captcha = $request['g-recaptcha-response'];
			$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".env('RECAPTCHA_SITE_KEY')."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
			// dd($response);
			if(!is_array($response) && isset($response) && $response['success'] == false)
			{
				return response()->json(['status' => 0, 'message' => 'Invalid Request']);
			}

			$user = User::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'user_type' => 1])->first();
			if($user){
				$expiryMin = config('app.otp_expiry_minutes');
				$otp = rand(1000, 9999);

				$SMSTemplate = SMSTemplate::where(['unique_key'=>'send_otp_for_my_bookings','service_provider_id'=>Auth::user()->id])->first();//find(3);
				$body = str_replace('#OTP#',$otp,$SMSTemplate->english_content);//"Dear User, your Veldoo verification code is ".$otp.". Use this password to complete your booking";
				if (app()->getLocale()!="en")
				{
					$body = str_replace('#OTP#',$otp,$SMSTemplate->german_content);
				}
				$this->sendSMS("+".$request->country_code, ltrim($request->phone, "0"), $body);
				$endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');
				OtpVerification::updateOrCreate(
					['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0")],
					['otp' => $otp, 'expiry' => $endTime, 'device_type' => 'web']
				);
				return response()->json(['status' => 1, 'message' => __('OTP is sent to Your Mobile Number')]);
			} else {
				return response()->json(['status' => 0, 'message' => __("No such number exists in our record")]);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		} catch (\Exception $exception) {
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}
	}

	public function verify_otp_and_ride_list(Request $request)
	{
		try {
			$now = Carbon::now();
			$haveOtp = OtpVerification::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'otp' => $request->otp])->first();
			if (empty($haveOtp)) {
				return response()->json(['status' => 0, 'message' => __('Verification code is incorrect, please try again')]);
			}

			if ($now->diffInMinutes($haveOtp->expiry) < 0) {
				return response()->json(['status' => 0, 'message' => __('Verification code has expired')]);
			}
			$haveOtp->delete();
			$minus1hourFromNow = Carbon::now()->subHour();
			$user = User::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'user_type' => 1])->first();
			if($user){
				$rideList = Ride::where(['user_id' => $user->id, 'platform' => 'web'])->where('ride_time', '>', $minus1hourFromNow)->where(function ($query) {
					$query->where('status', '!=', 3)->where('status', '!=', -3)->where('status', '!=', -2);
				})->with(['driver','vehicle'])->orderBy('created_at','DESC')->get();
				foreach ($rideList as $key => $ride) {
					$rideList[$key]->ride_time = date('D d-m-Y H:i',strtotime($ride->ride_time));
					$rideList[$key]->create_date = date('D d-m-Y H:i',strtotime($ride->created_at));
					$driver_ids = explode(',', $ride->driver_id);
					if (count($driver_ids) > 1 && $ride->status != 1)
					{
						$rideList[$key]->driver_name = "Not Available";
					}
					else
					{
						$rideList[$key]->driver_name = $ride->driver ? wordwrap($ride->driver->first_name, 10, "\n", true) : '';
					}
					$ride_type = "Not Available";
					if ($ride->ride_type == 1)
					{
						$ride_type = "Ride Schedule";
					}
					elseif($ride->ride_type == 2)
					{
						$ride_type = "Ride Now";
					}
					elseif($ride->ride_type == 3)
					{
						$ride_type = "Instant Ride";
					}
					elseif($ride->ride_type == 4)
					{
						$ride_type = "Ride Sharing";
					}
					$rideList[$key]->ride_type = $ride_type;

					$ride_status = "";
					$ride_status_latest = "";
					if ($ride->status == -2) {
						$ride_status = "Cancelled";
						$ride_status_latest = "Ride Cancelled";
					} elseif ($ride->status == -1) {
						$ride_status_latest = "Ride Rejected";
						$ride_status = "Rejected";
					} elseif ($ride->status == 1) {
						$ride_status_latest = "Driver will arrive in #time#";
						$ride_status = "Accepted";
					} elseif ($ride->status == 2) {
						$ride_status_latest = "Ride in progress and will completed in #time#";
						$ride_status = "Started";
					} elseif ($ride->status == 4) {
						$ride_status_latest = "Driver has arrived";
						$ride_status = "Driver Reached";
					} elseif ($ride->status == 3) {
						$ride_status_latest = "Ride Completed";
						$ride_status = "Completed";
					} elseif ($ride->status == -3) {
						$ride_status_latest = "Ride Cancelled By You";
						$ride_status = "Cancelled";
					} elseif ($ride->status == 0) {
						$ride_status_latest = "Pending";
						$ride_status = "Pending";
					} elseif ($ride->status == -4) {
						$ride_status_latest = "Pending";
						$ride_status = "Pending";
					} elseif ($ride->ride_status > date('Y-m-d H:i:s')) {
						$ride_status_latest = "Upcoming Ride";
						$ride_status = "Upcoming";
					} else if (!$ride->driver) {
						$ride_status_latest = "Pending";
						$ride_status = "Pending";
						$rideList[$key]->status = 0;
					}
					// dd($ride);
					$rideList[$key]->ride_status = $ride_status;
					$rideList[$key]->ride_status_latest = $ride_status_latest;
					$rideList[$key]->user_name = ($ride->user ? $ride->user->first_name : 'Not Available').' '.($ride->user ? $ride->user->last_name : '');
				}
				if($rideList && count($rideList) > 0){
					return response()->json(['status' => 1, 'message' => __('OTP is sent to Your Mobile Number'), 'data' => $rideList]);
				} else {
					return response()->json(['status' => 0, 'message' => __("No rides available")]);
				}
			} else {
				return response()->json(['status' => 0, 'message' => __("No such number exists in our record")]);
			}
		} catch (\Exception $exception) {
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}
	}

	public function cancel_booking(Request $request)
	{
		try {
			DB::beginTransaction();
			$ride_id = $request->ride_id;
			$ride = Ride::find($ride_id);
			if (!empty($ride)) {
				if (!empty($ride['driver_id'])) {
					$driverData = User::find($ride['driver_id']);
				}
				if (!empty($ride['user_id'])) {
					$userData = User::find($ride['user_id']);
				}

				if ($ride['status'] == -3) {
					return response()->json(['status' => 0, 'message' => "Ride Cancelled already"]);
				}
				$title = 'Ride Cancelled';
				$message = 'Ride Cancelled by User';

				$type = 6;
				$ride->status = -3;
				// if (!empty($request->cancel_reason)) {
				// 	$ride->cancel_reason = $request->cancel_reason;
				// }
				$ride->save();
				$ride_detail = new RideResource(Ride::find($ride_id));

				$settings = Setting::first();
				$settingValue = json_decode($settings['value']);
				$ride_detail['waiting_time'] = $settingValue->waiting_time;
				if (!empty($driverData)) {
					$deviceToken = $driverData['device_token'] ?? "";
					$deviceType = $driverData['device_type'] ?? "";
					$additional = ['type' => $type, 'ride_id' => $ride_detail->id, 'ride_data' => $ride_detail];
					if (!empty($deviceToken)) {
						if ($deviceType == 'android') {
							bulk_firebase_android_notification($title, $message, [$deviceToken], $additional);
						}
						if ($deviceType == 'ios') {
							bulk_pushok_ios_notification($title, $message, [$deviceToken], $additional, $sound = 'default', $driverData['user_type']);
						}
					}
				}

				if (!empty($userData)) {
					$notification = new Notification();
					$notification->title = 'Ride Cancelled';
					$notification->description = 'Ride Cancelled by you';
					$notification->type = $type;
					$notification->user_id = $userData['id'];
					$notification->additional_data = (!empty($additional)) ? json_encode($additional) : null;
					$notification->save();
				}
			}
			DB::commit();
			return response()->json(['status' => 1, 'message' => __('The ride has been cancelled.')]);
		} catch (\Exception $exception) {
			DB::rollBack();
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}
	}

	public function send_otp_before_ride_edit(Request $request)
	{
		// dd($request->all());
		try {
			if (!$request->has('g-recaptcha-response'))
			{
				return response()->json(['status' => 0, 'message' => 'Invalid Request']);
			}
			$captcha = $request['g-recaptcha-response'];
			$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".env('RECAPTCHA_SITE_KEY')."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
			if(!is_array($response) && isset($response) && $response['success'] == false)
			{
				return response()->json(['status' => 0, 'message' => 'Invalid Request']);
			}

			if ($request->user=="true")
			{
				$now = Carbon::now();
				$phone_number = explode("-",$request->phone);
				$request->phone = $phone_number[1];

				if ($request->pick_lat==$request->dest_lat)
				{
					$request->dest_address = "";
					$request->dest_lat = "";
					$request->dest_lng = "";
				}
				$webobj = new UserWebController;
				if ($now->diffInMinutes($request->ride_time) <= 15) {
					$jsonResponse = $webobj->create_ride_driver_edit($request);
				} else {
					$jsonResponse = $webobj->book_ride_edit($request);
				}
				$content = $jsonResponse->getContent();
				$responseObj = json_decode($content, true);

				return $responseObj;
			}

			$expiryMin = config('app.otp_expiry_minutes');
			$otp = rand(1000, 9999);
			$phone_number = explode("-",$request->phone);
			$request->phone = $phone_number[1];
			$SMSTemplate = SMSTemplate::where(['unique_key'=>'send_otp_before_ride_edit','service_provider_id'=>Auth::user()->id])->first();//find(4);
			$body = str_replace('#OTP#',$otp,$SMSTemplate->english_content);//"Dear User, your Veldoo verification code is ".$otp.". Use this password to complete your booking";
			if (app()->getLocale()!="en")
			{
				$body = str_replace('#OTP#',$otp,$SMSTemplate->german_content);
			}
			$this->sendSMS($phone_number[0], $phone_number[1], "Dear User, your Veldoo verification code is $otp. Use this password to complete your booking");

			$endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');

			OtpVerification::updateOrCreate(
				['country_code' => $request->country_code, 'phone' => $request->phone],
				['otp' => $otp, 'expiry' => $endTime, 'device_type' => 'web']
			);
			return response()->json(['status' => 1, 'message' => __('OTP is sent to Your Mobile Number')]);
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		} catch (\Exception $exception) {
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}
	}

	public function booking_edit(Request $request, $ride_id) {
		$rideDetail = Ride::find($ride_id);
		$vehicle_types = Price::orderBy('sort')->get();
		return view('booking_edit')->with(['vehicle_types' => $vehicle_types, 'rideDetail' => $rideDetail]);
	}

	public function booking_form_edit(Request $request, $ride_id) {
		// dd($request->all());
		if(empty($request->carType)){
			return redirect()->route("booking_taxisteinemann");
		}
		$rideDetail = Ride::with(['user'])->find($ride_id);
		$vehicle_type = Price::find($request->carType);
		$input = $request->all();
		$user = User::where('random_token',$request->token)->where('random_token','!=','')->first();
		if ($rideDetail->user)
		{
			$user = $rideDetail->user;
		}
		return view('booking_form_edit')->with(['user'=>$user,'vehicle_type' => $vehicle_type, 'input' => $input, 'rideDetail' => $rideDetail]);
	}

	public function verify_otp_and_ride_booking_edit(Request $request)
	{
		$expiryMin = config('app.otp_expiry_minutes');
		$now = Carbon::now();
		$phone_number = explode("-",$request->phone);
		$request->phone = $phone_number[1];
		$haveOtp = OtpVerification::where(['country_code' => $request->country_code, 'phone' => $request->phone, 'otp' => $request->otp])->first();
		if (empty($haveOtp)) {
			return response()->json(['status' => 0, 'message' => __('Verification code is incorrect, please try again')]);
		}

		if ($now->diffInMinutes($haveOtp->expiry) < 0) {
			return response()->json(['status' => 0, 'message' => __('Verification code has expired')]);
		}
		$haveOtp->delete();
		if ($request->pick_lat==$request->dest_lat)
		{
			$request->dest_address = "";
			$request->dest_lat = "";
			$request->dest_lng = "";
		}
		$webobj = new UserWebController;
		if ($now->diffInMinutes($request->ride_time) <= 15) {
			$jsonResponse = $webobj->create_ride_driver_edit($request);
		} else {
			$jsonResponse = $webobj->book_ride_edit($request);
		}
		$content = $jsonResponse->getContent();
		$responseObj = json_decode($content, true);
		$user = User::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'user_type' => 1])->first();
		if($responseObj['status'] == 1){
			$message_content = "";
			$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

			$SMSTemplate = SMSTemplate::where(['unique_key'=>'send_booking_details_after_edit_booking','service_provider_id'=>Auth::user()->id])->first();//find(5);
			if ($request->url_type=="taxisteinemann") {
				$message_content = str_replace('#LINK#',route('list_of_booking_taxisteinemann',$user->random_token),str_replace('#TIME#',date('d M, Y h:ia', strtotime($request->ride_time)),$SMSTemplate->english_content));
				if (app()->getLocale()!="en")
				{
					$message_content = str_replace('#LINK#',route('list_of_booking_taxisteinemann',$user->random_token),str_replace('#TIME#',date('d M, Y h:ia', strtotime($request->ride_time)),$SMSTemplate->german_content));
				}
			} else {
				$message_content = str_replace('#LINK#',route('list_of_booking_taxi2000',$user->random_token),str_replace('#TIME#',date('d M, Y h:ia', strtotime($request->ride_time)),$SMSTemplate->english_content));
				if (app()->getLocale()!="en")
				{
					$message_content = str_replace('#LINK#',route('list_of_booking_taxi2000',$user->random_token),str_replace('#TIME#',date('d M, Y h:ia', strtotime($request->ride_time)),$SMSTemplate->german_content));
				}
			}
			$this->sendSMS("+".$request->country_code, ltrim($request->phone, "0"), $message_content);
		}
		return $jsonResponse;
	}

	public function changeLocale(Request $request)
	{
		$url = url()->previous();
		session()->put('locale', $request->locale);
		if (in_array('list_of_booking',explode('/',$url)))
		{
			return redirect()->back();
		}
		return redirect()->route($request->route);
	}

	public function test_notification()
	{
		$options = [
			'key_id' => env('IOS_KEY_ID'), // The Key ID obtained from Apple developer account
			'team_id' => env('IOS_TEAM_ID'), // The Team ID obtained from Apple developer account
			'app_bundle_id' => env('IOS_APP_BUNDLE_ID_DRIVER'), // com.orem.Modo-Provider The bundle ID for app obtained from Apple developer account
			'private_key_path' => public_path('/ios/AuthKey_T5U8YFRV99.p8'), // Path to private key
			'private_key_secret' => null // Private key secret
		];

		$authProvider = AuthProvider\Token::create($options);

		$alert = Alert::create()->setTitle("Test title");
		$alert = $alert->setBody("Test Body Description");

		$payload = Payload::create()->setAlert($alert);

		//set notification sound to default
		$payload->setSound('example.caf');
		$payload->setContentAvailability(true);
		$payload->setMutableContent(true);
		//add custom value to your notification, needs to be customized
		$ride_detail = Ride::first();
		$additional = ['type' => 1, 'ride_id' => $ride_detail->id, 'ride_data' => $ride_detail];
		foreach ($additional as $key => $value) {
			$payload->setCustomValue($key, $value);
		}

		$notifications = [];
		$user_detail = User::find(562);
		$notifications[] = new P_Notification($payload, $user_detail->device_token);
		$settings = \App\Setting::first();
		$settingValue = json_decode($settings['value']);
		$appurl_notification = $settingValue->notification;
		if ($appurl_notification == 1) {
			$client = new Client($authProvider, $production = true);
		} else if ($appurl_notification == 0) {
			$client = new Client($authProvider, $production = false);
		} else {
			$client = new Client($authProvider, $production = true);
		}
		$client->addNotifications($notifications);

		$responses = $client->push();
		print_r($responses);
	}

	public function privacy_policy(){
	    return view('privacy_policy');
    }

}
