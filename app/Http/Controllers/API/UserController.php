<?php

namespace App\Http\Controllers\API;

use App\AdminContact;
use App\BankDetail;
use App\Booking;
use App\Card;
use App\Cart;
use App\Category;
use App\Complaint;
use App\ComplainType;
use App\Contact;
use App\DriverChooseCar;
use App\Driverclass;
use App\DriverStayActiveNotification;
use App\Favourite;
use App\Helpers\Notifications;
use App\Http\Controllers\Controller;
use App\Http\Resources\RideResource;
use App\InvitationMile;
use App\Item;
use App\Notification;
use App\OtpVerification;
use App\Page;
use App\PaymentMethod;
use App\Place;
use App\Price;
use App\Promocode;
use App\Promotion;
use App\Rating;
use App\Ride;
use App\RideHistory;
use App\Rules\MatchOldPassword;
use App\SaveLocation;
use App\Setting;
use App\Stopover;
use App\Subject;
use App\User;
use App\UserData;
use App\UserMeta;
use App\UserVoucher;
use App\Vehicle;
use App\Voucher;
use App\Wallet;
use Carbon\Carbon;
use Config;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Mail;
use \stdClass;
use App\SMSTemplate;
use App\Expense;

class UserController extends Controller
{

	use Notifiable;
	use SendsPasswordResetEmails;

	protected $successCode = 200;
    protected $errorCode = 401;
    protected $warningCode = 500;
	protected $limit;

	public function __construct(Request $request = null)
	{
		$this->limit = Config::get('limit_api');

		if (!empty($request->step) && $request->step > 1) {
			$this->middleware('auth:api')->only('register_or_update');
		}
	}

	public function common()
	{
		return response()->json(['message' => __('Successfully.'), 'data' => array()], $this->successCode);
	}

	public function push2()
	{
		//echo "push 2"; die;
		// $title, $body, $sound='default', $deviceTokens = array(), $additional=array()
		$title = 'Title driver';
		$message = 'Testing ios push';

		$deviceToken = $_POST['device_token'];
		$type = 1;
		$ride = Ride::query()->where([['id', '=', 1474]])->first();
		$user_data = User::query()->where([['id', '=', $ride['user_id']]])->first();
		if (!empty($user_data)) {
			$ride['user_data'] = $user_data;
		} else {
			$ride['user_data'] = null;
		}
		$additional = ['type' => $type, 'ride_id' => 0, 'ride_data' => $ride];
		$saveData = ['title' => $title, 'description' => $message];

		$deviceType = 'ios';
		$user_type = $_POST['user_type'];
		ios_notification($title, $message, $deviceToken, $additional = array(), $sound = 'default', $user_type);
		//send_iosnotification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
	}

	public function push()
	{
		//echo "push"; die;
		$title = 'Title';
		$message = 'Body Description';
		$type = 1;
		$deviceToken = $_POST['device_token'];
		$ride = Ride::query()->where([['id', '=', 1474]])->first();
		$user_data = User::query()->where([['id', '=', $ride['user_id']]])->first();
		$ride['user_data'] = $user_data;
		$additional = ['type' => $type, 'ride_id' => 0, 'ride_data' => $ride];
		$saveData = ['title' => $title, 'description' => $message];

		$deviceType = 'android';
		send_notification($title, $message, $deviceToken, '', $additional, true, false, $deviceType, []);
	}

	#USER REGISTER & UPDATE
	// public function register_or_update(Request $request)
	// {

	// 	#trans('api.step_required')
	// 	if (empty($request->step)) {
	// 		return response()->json(['message' => 'Step required'], $this->errorCode);
	// 	}

	// 	$rules = [];
	// 	if ($request->step == 1 || $request->step == 3) {
	// 		$rules['country_code'] = 'required|integer';
	// 		$rules['phone'] = 'required';
	// 		if ($request->step == 1) {
	// 			$rules['password'] = 'required';
	// 			$rules['user_type'] = 'required|integer';
	// 		}
	// 		$rules['first_name'] = 'required';
	// 		$rules['last_name'] = 'required';
	// 		$rules['email'] = 'required|email';
	// 		//$rules['city'] = 'required';
	// 	}

	// 	if ($request->step == 2) {
	// 		$rules['otp'] = 'required|integer';
	// 	}

	// 	$validator = Validator::make($request->all(), $rules);
	// 	if ($validator->fails()) {
	// 		return response()->json(['message' => 'Required data missed', 'error' => $validator->errors()], $this->warningCode);
	// 	}

	// 	if ($request->step == 1 || $request->step == 3) {

	// 		$userQuery = User::where(['country_code' => $request->country_code, 'phone' => $request->phone]);
	// 		if (!empty($request->email)) {

	// 			$userQuery2 = User::where(['email' => $request->email]);
	// 			$isUserEmail = $userQuery2->first();
	// 		}

	// 		$isUser = $userQuery->first();

	// 		/* print_r($isUser->toArray());
	// 		print_r(Auth::user()->toArray());
	// 		exit; */

	// 		if (!empty($isUser)) {
	// 			if ($request->step == 3) {
	// 				if ($isUser->country_code . $isUser->phone != Auth::user()->country_code . Auth::user()->phone) {
	// 					return response()->json(['message' => 'Phone number already exists', 'data' => $isUser], $this->warningCode);
	// 				}
	// 			} else {
	// 				return response()->json(['message' => 'Phone number already exists', 'data' => $isUser], $this->warningCode);
	// 			}
	// 		}
	// 		if (!empty($isUserEmail)) {
	// 			if ($request->step == 3) {
	// 				if ($isUserEmail->email != Auth::user()->email) {
	// 					return response()->json(['message' => 'Email already exists', 'data' => $isUserEmail], $this->warningCode);
	// 				}
	// 			} else {
	// 				return response()->json(['message' => 'Email already exists', 'data' => $isUserEmail], $this->warningCode);
	// 			}
	// 		}
	// 	}

	// 	if ($request->step == 2) {

	// 		$expiryMin = config('app.otp_expiry_minutes');
	// 		$now = Carbon::now();
	// 		$haveOtp = OtpVerification::where(['email' => Auth::user()->email, 'otp' => $request->otp])->first();

	// 		if (empty($haveOtp)) {
	// 			return response()->json(['message' => 'Verification code is incorrect, please try again'], $this->warningCode);
	// 		}

	// 		if ($now->diffInMinutes($haveOtp->updated_at) >= $expiryMin) {
	// 			return response()->json(['message' => 'Verification code has expired, please use a new code by clicking resend the code'], $this->warningCode);
	// 		}

	// 		$haveOtp->delete();

	// 		$userData = User::where('id', Auth::user()->id)->first();
	// 		$userData->step = $request->step;

	// 		$userData->verify = 1;
	// 		$userData->save();

	// 		return response()->json(['message' => 'Verified'], $this->successCode);
	// 	}

	// 	$input = $request->all();

	// 	try {

	// 		/* if(!empty($input['email'])){
	// 			$input['user_name'] = $input['email'];
	// 		} */

	// 		if (Auth::check()) {

	// 			$user_id = Auth::user()->id;

	// 			if ($request->hasFile('image') && $request->file('image')->isValid()) {

	// 				$imageName = Auth::user()->image;
	// 				if (!empty($imageName)) {
	// 					Storage::disk('public')->delete("$imageName");
	// 				}

	// 				$input['image'] = Storage::disk('public')->putFileAs(
	// 					'user/' . $user_id,
	// 					$request->file('image'),
	// 					'profile-image'.time().'.' . $input['image']->extension()
	// 				);
	// 			}

	// 			$userData = User::where('id', $user_id)->first();

	// 			foreach ($input as $key => $value) {
	// 				$userData->$key = $value;
	// 			}
	// 			if (!empty($request->device_type)) {
	// 				$userData->device_type = $request->device_type;
	// 			}
	// 			if (!empty($request->device_token)) {
	// 				$userData->device_token = $request->device_token;
	// 			}
	// 			$userData->save();
	// 			$token = '';
	// 		} else {

	// 			$user = User::create($input);
	// 			$user->AauthAcessToken()->delete();
	// 			$token = $user->createToken('auth')->accessToken;
	// 			if (!empty($request->device_type)) {
	// 				$user->device_type = $request->device_type;
	// 			}
	// 			if (!empty($request->device_token)) {
	// 				$user->device_token = $request->device_token;
	// 			}
	// 			$user->save();

	// 			$user_id = $user->id;

	// 			if ($request->hasFile('image') && $request->file('image')->isValid()) {

	// 				$input['image'] = Storage::disk('public')->putFileAs(
	// 					'user/' . $user_id,
	// 					$request->file('image'),
	// 					'profile-image'.time().'.' . $input['image']->extension()
	// 				);
	// 			}

	// 			#SEND OTP
	// 			$otp = rand(1000, 9999);
	// 			$data = array('name' => $otp);
	// 			$m = Mail::send('mail', $data, function ($message) use ($request) {
	// 				$message->to($request->email, 'OTP')->subject('OTP Verification Code');

	// 				if (!empty($request->from)) {
	// 					$message->from($request->from, 'FoodFix');
	// 				}
	// 			});
	// 			$expiryMin = config('app.otp_expiry_minutes');
	// 			$endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');
	// 			OtpVerification::updateOrCreate(
	// 				['email' => $request->email],
	// 				['otp' => $otp, 'expiry' => $endTime]
	// 			);


	// 			$userData = $this->getRafrenceUser($user_id);

	// 			return response()->json(['message' => 'The verification code has been sent to your email address', 'user' => $userData, 'token' => $token, 'otp' => $otp], $this->successCode);
	// 		}

	// 		$userData = $this->getRafrenceUser($user_id);

	// 		return response()->json(['message' => 'Success', 'user' => $userData, 'token' => $token], $this->successCode);
	// 	} catch (\Illuminate\Database\QueryException $exception) {
	// 		$errorCode = $exception->errorInfo[1];
	// 		return response()->json(['message' => $exception->getMessage()], 401);
	// 	} catch (\Exception $exception) {
	// 		return response()->json(['message' => $exception->getMessage()], 401);
	// 	}
	// }

	#USER LOGIN
	public function login(Request $request)
	{
		//dd($request->all());
		$rules = [
			//'email' => 'required',
			'password' => 'required',
		];
		$where = ['password' => request('password')];
		if (!empty($request->email)) {
			$where['email'] = $request->email;
		}
		$where2 = ['password' => request('password')];
		if (!empty($request->phone)) {
			$where2['phone'] = ltrim($request->phone, "0");
			$where2['country_code'] = ltrim($request->country_code,"+");
		}
		$where['user_type'] = 1;
		$where2['user_type'] = 1;

		if (auth()->attempt($where2)) {
			Auth::user()->AauthAcessToken()->delete();
			$user = Auth::user();
			$user->fcm_token = "";
			$user->device_type = "";
			$user->device_token = "";
			$user->save();
			// print_r($user->id); die;
			if (!empty($request->fcm_token)) {
				$user['fcm_token'] = $request->fcm_token;
			}
			if (!empty($request->device_type)) {
				$user['device_type'] = $request->device_type;
			}
			if (!empty($request->device_token)) {
				$user['device_token'] = $request->device_token;
			}
			if (!empty($request->app_version)) {
				$user['app_version'] = $request->app_version;
			}
			if (!empty($request->phone_model)) {
				$user['phone_model'] = $request->phone_model;
			}
			$user['updated_at'] = Carbon::now();
			$user['app_installed'] = 1;
			$user->save();
			/* if($user->status == 0){
				return response()->json(['message'=>'Your account is disabled', 'user'=>'', 'token'=>''], $this->warningCode);
			}
			if($user->verify == 0){
				return response()->json(['message'=>'Please verify your number', 'user'=>$user, 'token'=>''], $this->successCode);
			} */
			$token =  $user->createToken('auth')->accessToken;
			$user = $this->getRafrenceUser($user->id);
			// print_r($user);
			/* $userdata = UserData::query()->where([['user_id', '=', $user->id]])->first();
			if(!empty($userdata))
			{
			 $user['phone_number']=json_decode($userdata->phone_number);
        	$user['emails']=json_decode($userdata->email);
			$user['addresses']=json_decode($userdata->addresses);
			$user['favourite_address']=json_decode($userdata->favourite_address);
			}
			else
			{
				 $user['phone_number']=array();
        	$user['emails']=array();
			$user['addresses']=array();
			$user['favourite_address']=array();
			} */
			return response()->json(['success' => true, 'message' => 'Success', 'user' => $user, 'token' => $token], $this->successCode);
		} else {
			return response()->json(['success' => false, 'message' => 'Details are incorrect, please try again'], $this->successCode);
		}
	}
	#USER LOGIN
	public function driverLogin(Request $request)
	{
		$rules = [
			'country_code' => 'required',
			'phone' => 'required',
			'password' => 'required',
			'service_provider_id' => 'required'
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}

		$where = ['password' => request('password'), 'country_code' => request('country_code')];

		// if (!empty($request->email)) {
		// 	$where['email'] = $request->email;
		// }

		if (!empty($request->phone)) {
			$where['phone'] = ltrim($request->phone, "0");
		}
		$where['user_type'] = 2;
		if (auth()->attempt($where)) {
			Auth::user()->AauthAcessToken()->delete();
			$user = Auth::user();
			if (!empty($request->fcm_token)) {
				$user['fcm_token'] = $request->fcm_token;
			}
			if (!empty($request->device_type)) {
				$user['device_type'] = $request->device_type;
			}
			if (!empty($request->device_token)) {
				$user['device_token'] = $request->device_token;
			}
			if (!empty($request->socket_id)) {
				$user['socket_id'] = $request->socket_id;
			}

			$user['service_provider_id'] = $request->service_provider_id;
			if (!empty($request->app_version)) {
				$user['app_version'] = $request->app_version;
			}
			if (!empty($request->phone_model)) {
				$user['phone_model'] = $request->phone_model;
			}

			$user['availability'] = 0;
			$user->save();
			/* if($user->status == 0){
				return response()->json(['message'=>'Your account is disabled', 'user'=>'', 'token'=>''], $this->warningCode);
			}
			if($user->verify == 0){
				return response()->json(['message'=>'Please verify your number', 'user'=>$user, 'token'=>''], $this->successCode);
			} */
			

			$token =  $user->createToken('auth')->accessToken;
			
			$user = $this->getRafrenceUser($user->id);
			
			// $driverhoosecar = DriverChooseCar::where(['user_id' => $user->id, 'logout' => 0])->orderBy('id', 'desc')->first();
			// if (!empty($driverhoosecar)) {
			// 	$driverhoosecar->logout = 1;
			// 	$driverhoosecar->save();
			// }
			DriverStayActiveNotification::updateOrCreate(['driver_id' => $user->id], ['last_activity_time' => Carbon::now(), 'is_availability_alert_sent' => 1, 'is_availability_changed' => 1, 'is_logout_alert_sent' => 0, 'service_provider_id' => $user->service_provider_id]);
			return response()->json(['success' => true, 'message' => 'Success', 'user' => $user, 'token' => $token], $this->successCode);
		} else {
			return response()->json(['success' => false, 'message' => 'Details are incorrect, please try again'], $this->successCode);
		}
	}
	public function driverVerifyOtp(Request $request)
	{

		$rules = [
			'country_code' => 'required',
			'phone' => 'required',
			'otp' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}

		$expiryMin = config('app.otp_expiry_minutes');
		$now = Carbon::now();
		$haveOtp = OtpVerification::where(['phone' => ltrim($request->phone, "0"), 'otp' => $request->otp])->first();

		if (empty($haveOtp)) {
			return response()->json(['message' => 'Verification code is incorrect, please try again'], $this->warningCode);
		}

		if ($now->diffInMinutes($haveOtp->updated_at) >= $expiryMin) {
			return response()->json(['message' => 'Verification code has expired, please use a new code by clicking resend the code'], $this->warningCode);
		}

		$haveOtp->delete();
		$userData = User::where(['country_code' => ltrim($request->country_code,"+"), 'phone' => ltrim($request->phone, "0"), 'user_type' => 2])->first();

		//$userData = User::where('phone', $request->phone)->first();
		Auth::login($userData);
		Auth::user()->AauthAcessToken()->delete();
		$driverchoosecar = DriverChooseCar::where(['user_id' => $userData->id, 'logout' => 0])->orderBy('id', 'desc')->first();
		if (!empty($driverchoosecar)) {
			$driverchoosecar->logout = 1;
			$driverchoosecar->save();
		}
		if (!empty($request->fcm_token)) {
			$userData->fcm_token = $request->fcm_token;
		}
		if (!empty($request->device_type)) {
			$userData->device_type = $request->device_type;
		}
		if (!empty($request->device_token)) {
			$userData->device_token = $request->device_token;
		}
		if (!empty($request->app_version)) {
			$userData->app_version = $request->app_version;
		}
		if (!empty($request->phone_model)) {
			$userData->phone_model = $request->phone_model;
		}
		
		$userData->verify = 1;
		$userData->availability= 0;
		$userData->updated_at = Carbon::now();
		$userData->save();
		$token =  $userData->createToken('auth')->accessToken;
		$user = $this->getRafrenceUser($userData->id);
		DriverStayActiveNotification::updateOrCreate(['driver_id' => $user->id], ['last_activity_time' => Carbon::now(), 'is_availability_alert_sent' => 1, 'is_availability_changed' => 1, 'is_logout_alert_sent' => 0, 'service_provider_id' => $user->service_provider_id]);
		return response()->json(['message' => 'Success', 'user' => $user, 'token' => $token], $this->successCode);

		//return response()->json(['message' => 'Verified'], $this->successCode);
	}
	public function verifyOtp(Request $request)
	{

		$rules = [
			'country_code' => 'required',
			'phone' => 'required',
			'otp' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}

		$expiryMin = config('app.otp_expiry_minutes');
		$now = Carbon::now();
		$haveOtp = OtpVerification::where(['phone' => ltrim($request->phone, "0"), 'otp' => $request->otp])->first();

		if (empty($haveOtp)) {
			return response()->json(['message' => 'Verification code is incorrect, please try again'], $this->warningCode);
		}

		if ($now->diffInMinutes($haveOtp->updated_at) >= $expiryMin) {
			return response()->json(['message' => 'Verification code has expired, please use a new code by clicking resend the code'], $this->warningCode);
		}

		$haveOtp->delete();
		$userData = User::where(['country_code' => ltrim($request->country_code,"+"), 'phone' => ltrim($request->phone, "0"), 'user_type' => 1])->first();
		if (!empty($userData)) {
			Auth::login($userData);

			if (!empty($request->fcm_token)) {

				$userData->fcm_token = $request->fcm_token;
			}
			if (!empty($request->device_type)) {
				$userData->device_type = $request->device_type;
			}
			if (!empty($request->device_token)) {
				$userData->device_token = $request->device_token;
			}
			if (!empty($request->app_version)) {
				$userData->app_version = $request->app_version;
			}
			if (!empty($request->phone_model)) {
				$userData->phone_model = $request->phone_model;
			}
			$userData->verify = 1;
			$userData->save();
			$token =  $userData->createToken('auth')->accessToken;
			$user = $this->getRafrenceUser($userData->id);

			return response()->json(['message' => 'Success', 'user' => $user, 'token' => $token], $this->successCode);
		} else {
			return response()->json(['message' => 'Success', 'user' => "", 'token' => ""], $this->successCode);
		}
		//$userData = User::where('phone', $request->phone)->first();


		//return response()->json(['message' => 'Verified'], $this->successCode);
	}
	public function social_login(Request $request)
	{

		$rules = [];


		$rules['social_id'] = 'required';
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => 'Required data missed', 'error' => $validator->errors()], $this->warningCode);
		}



		$user = User::where('social_id', '=', $_REQUEST['social_id'])->first();
		if (!empty($user)) {

			if (!empty($_REQUEST['email'])) {

				$useremailcheck = User::where([['email', '=', $_REQUEST['email']], ['social_id', '=', $_REQUEST['social_id']]])->first();
				if (!empty($useremailcheck)) {
				} else {

					if (!empty($request->email)) {
						$user->email = $request->email;
					}
				}
			}
			if (!empty($_REQUEST['phone_number'])) {
				$userphonecheck = User::where([['phone_number', '=', $_REQUEST['phone_number']], ['social_id', '=', $_REQUEST['social_id']]])->first();
				if (!empty($userphonecheck)) {
				} else {
					if (!empty($request->phone_number)) {
						$user->phone_number = $request->phone_number;
					}
				}
			}
		} else {

			if (!empty($_REQUEST['email'])) {
				$user = User::where('email', '=', $_REQUEST['email'])->first();
			}
			if (!empty($_REQUEST['phone_number'])) {
				$user = User::where('phone_number', '=', $_REQUEST['phone_number'])->first();
			}
			if (!empty($user)) {
			} else {

				$user = new User();
				if (!empty($request->email)) {
					$user->email = $request->email;
				}
				if (!empty($request->phone_number)) {
					$user->phone_number = $request->phone_number;
				}
			}
		}

		try {
			if (!empty($request->email)) {
				$user->email = $request->email;
			}
			if (!empty($request->phone_number)) {
				$user->phone_number = $request->phone_number;
			}
			if (!empty($request->social_id)) {
				$user->social_id = $request->social_id;
			}
			if (!empty($request->social_type)) {
				$user->social_type = $request->social_type;
			}
			if (!empty($request->first_name)) {
				$user->first_name = $request->first_name;
			}
			if (!empty($request->last_name)) {
				$user->last_name = $request->last_name;
			}
			if (!empty($request->device_type)) {
				$user->device_type = $request->device_type;
			}
			if (!empty($request->device_token)) {
				$user->device_token = $request->device_token;
			}
			if (!empty($request->user_type)) {
				$user->user_type = $request->user_type;
			} else {
				$user->user_type = 1;
			}

			if (!empty($_FILES['image'])) {

				if (isset($_FILES['image']) && $_FILES['image']['name'] !== '' && !empty($_FILES['image']['name'])) {
					$file = $_FILES['image'];
					$file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
					$filename = time() . '-' . $file;
					$ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$path = "public/images/user_image/";
						if (move_uploaded_file($_FILES['image']['tmp_name'], $path . $filename)) {
							$user->image = $path . $filename;
						}
					} else {


						return response()->json(['message' => 'upload Valid image'], $this->errorCode);
					}
				}
			}


			$user->save();

			$token =  $user->createToken('auth')->accessToken;
			$userdata = $this->getRafrenceUser($user->id);



			return response()->json(['message' => 'Success', 'user' => $userdata, 'token' => $token], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];

			$errorCode = $exception->getMessage();
			return response()->json(['message' => $errorCode], $this->errorCode);
		} catch (\Exception $exception) {

			$errorCode = $exception->getMessage();
			return response()->json(['message' => $errorCode], $this->errorCode);
		}
	}
	public function checkRegisteredUser(Request $request)
	{
		try {

			$rules = [
				'phone' => 'required',
				'country_code' => 'required',
				'user_type' => 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}

			$user = User::with(['driver_service_providers:id,name'])->where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'user_type' => $request->user_type])->first();
			//print_r($user)
			//$user=\App\User::where('phone',$request->phone)->where('country_code',$request->country_code)->first();
			if (!empty($user) && $user != null) {
				return response()->json(['message' => 'You are already registered with this phone number', 'data' => $user], $this->successCode);
			} else {
				return response()->json(['message' => 'Not Registered'], $this->successCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function verify_user_registered(Request $request)
	{
		try {
			$rules = [
				'phone' => 'required',
				'country_code' => 'required',
				'user_type' => 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}

			$user = User::where(['country_code' => ltrim($request->country_code,"+"), 'phone' => ltrim($request->phone, "0"), 'user_type' => $request->user_type])->first();
			if ($user) {
				if(!empty($user->password)){
					return response()->json(['data' => ['account_created' => 1, 'password_created' => 1, 'user' => $user], 'message' => 'Already registered & login'], $this->successCode);
				} else {
					return response()->json(['data' => ['account_created' => 1, 'password_created' => 0, 'user' => $user], 'message' => 'Already registered but not login'], $this->successCode);
				}
			} else {
				return response()->json(['data' => ['account_created' => 0, 'password_created' => 0, 'user' => null], 'message' => 'Not Registered'], $this->successCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function register(Request $request)
	{
		DB::beginTransaction();
		try {
			$userId = '';
			$rules = [
				// 'signup_type' => 'required|integer|between:1,3',
				'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
				'device_type' => 'required',
				'device_token' => 'required',
				'first_name' => 'required',
				'last_name' => 'required',
				'country_code' => 'required|integer',
				'phone' => 'required',
				'password' => 'required',
				'email'=>'email|unique:users',
				'user_type' => 'required'
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}
			$usercheck = User::where(['country_code' => ltrim($request->country_code,"+"), 'phone' => ltrim($request->phone, "0"), 'user_type' => $request->user_type])->first();
			if (!empty($usercheck)) {
				return response()->json(['success' => true, 'message' => 'This Phone number already used.'], $this->warningCode);
			}
			$input = $request->all();
			// print_r($input ); die;
			$input['password'] = Hash::make($request->password);
			$input['refer_code'] = $this->generateRandomString(7);
			$userData = \App\User::create($input);
			// print_r($userData); die;
			$userData->AauthAcessToken()->delete();
			$token =  $userData->createToken('auth')->accessToken;


			if (!empty($_FILES['image'])) {
				if (isset($_FILES['image']) && $_FILES['image']['name'] !== '' && !empty($_FILES['image']['name'])) {
					$file = $_FILES['image'];
					$file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
					$filename = "IMG-" . date('Ymd') . '-' . $file;
					$ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$path = "public/images/user_image/";
						if (move_uploaded_file($_FILES['image']['tmp_name'], $path . $filename)) {
							$input['image'] = url($path . $filename);
						}
					} else {
						return back()->with('error', __('Upload Valid Image'));
					}
				}
			}

			\App\User::where('id', $userData->id)->update($input);
			$newUserData = User::where([['id', '=', $userData->id]])->first();
			$newUserData->full_name = $newUserData->first_name . ' ' . $newUserData->last_name;

			DB::commit();

			if (!empty($request->refer_code)) {
				$refered_userdata = User::select('id', 'refer_code')->where('refer_code', $request->refer_code)->first();

				if (!empty($refered_userdata)) {
					$voucher = \App\Voucher::first();
					$voucherValue = json_decode($voucher['value']);
					$mile_on_invitation = $voucherValue->mile_on_invitation;


					$uservoucher = new UserVoucher();
					$uservoucher->miles = $mile_on_invitation;
					$uservoucher->refer_code = $request->refer_code;
					$uservoucher->user_id = $refered_userdata['id'];
					$uservoucher->refer_use_by = $newUserData->id;
					//$uservoucher->ride_id = 0;
					$uservoucher->type = 2;


					unset($uservoucher->created_at);
					unset($uservoucher->updated_at);

					$uservoucher->save();


					/* $InvitationMile = new InvitationMile();
				$InvitationMile->refer_code = $request->refer_code;
				$InvitationMile->user_id = $refered_userdata['id'];




				$InvitationMile->miles_received = $mile_on_invitation;
            unset($InvitationMile->created_at);
            unset($InvitationMile->updated_at);

				$InvitationMile->save(); */

					// $where = array('id' => $userData->id);
					// $userd = DB::table('user')->select('*')->where($where)->first();

					// $userd->refer_user_id = $refered_userdata['id'];
					// $userd->save();
				}
			}

			return response()->json(['success' => true, 'message' => 'Register successfully.', 'user' => $newUserData, 'token' => $token], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			DB::rollback();
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], 401);
		} catch (\Exception $exception) {
			DB::rollback();
			return response()->json(['message' => $exception->getMessage()], 401);
		}
	}

	#RESEND OTP
	public function resendOtp(Request $request)
	{

		$rules = [
			'country_code' => 'required',
			'phone' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}

		$isUser = User::where(['country_code' => ltrim($request->country_code,"+"), 'phone' => ltrim($request->phone, "0")])->first();
		if (empty($isUser)) {
			return response()->json(['message' => 'Your number is not registered with us.'], $this->warningCode);
		}

		$expiryMin = config('app.otp_expiry_minutes');
		$now = Carbon::now();

		$haveOtp = OtpVerification::where(['phone' => $isUser->phone])->first();

		/* if(!empty($haveOtp)){
			if($now->diffInMinutes($haveOtp->updated_at)<$expiryMin){
				return response()->json(['message'=>'Please wait 10 minutes since the previous code sent before resending a new verification code'], $this->warningCode);
			}
		} */

		$otp = rand(1000, 9999);
		$data = array('name' => $otp);

		$this->sendSMS("+".ltrim($request->country_code,"+"), ltrim($request->phone, "0"), "Dear User, your Veldoo verification code is $otp. Use this to reset your password");

		/* 	$m = Mail::send('mail', $data, function($message) use ($request, $isUser) {
			$message->to($isUser->email, 'OTP')->subject('OTP Verification Code');

			if(!empty($request->from)){
				$message->from($request->from, 'Haylup');
			}
		}); */

		$endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');

		$otpverify = OtpVerification::where(['country_code' => ltrim($request->country_code,"+"), 'phone' => ltrim($request->phone, "0")])->first();


		if (!empty($otpverify)) {
			$otpverify->otp = $otp;
			$otpverify->expiry = $endTime;
		} else {
			$otpverify = new OtpVerification();
			$otpverify->phone = ltrim($request->phone, "0");
			$otpverify->country_code = ltrim($request->country_code,"+");
			$otpverify->otp = $otp;
			$otpverify->expiry = $endTime;
		}
		$otpverify->device_type = $request->device_type??"";
		$otpverify->save();

		$dataArr = array('otp' => $otp);
		return response()->json(['message' => 'The verification code has been sent', 'data' => $dataArr], $this->successCode);
	}

	#FORGET PASSWORD
	public function forgotPassword(Request $request)
	{

		$rules = [
			'email' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}

		$isEmail = User::where(['email' => $request->email])->first();
		if (empty($isEmail)) {
			return response()->json(['message' => 'Your email is not registered. Please check again or click here to register as a new user'], $this->warningCode);
		}

		//$request->merge( array( 'email' => $isUser->email ) );

		if ($request->input('email')) {
			$this->sendResetLinkEmail($request);
		}

		/* if($request->expectsJson()){
			return $response = Password::RESET_LINK_SENT
				? response()->json(['message' => 'Reset Password Link Sent'],$this->successCode)
				: response()->json(['message' => 'Reset Link Could Not Be Sent'],$this->warningCode);
		} */
		return response()->json(['message' => 'Reset Password Link Sent'], $this->successCode);
	}

	#USER DETAILS
	public function details()
	{
		$user = Auth::user();
		$user = $this->getRafrenceUser(Auth::user()->id);
		return response()->json(['message' => __('Successfully.'), 'user' => $user], $this->successCode);
	}

	public function getRide($ride_id)
	{


		$ride = Ride::query()->where([['id', '=', $ride_id]])->first();

		$user_data = User::select('id', 'first_name', 'last_name', 'image', 'country_code', 'phone', 'user_type')->where('id', $ride['user_id'])->first();


		//$driver_data= User::query()->where([['id', '=', $ride['driver_id']]])->first();
		$driver_data = User::select('id', 'first_name', 'last_name', 'image', 'current_lat', 'current_lng', 'country_code', 'phone', 'user_type')->where('id', $ride['driver_id'])->first();
		if (!empty($driver_data)) {
			$driver_car = DriverChooseCar::where('user_id', $driver_data['id'])->first();
			$ride['driver_data'] = $driver_data;
			$car_data = Vehicle::select('id', 'model', 'vehicle_image', 'vehicle_number_plate')->where('id', $driver_car['id'])->first();
			if (!empty($car_data)) {
				$driver_data['car_data'] = $car_data;
			} else {
				$driver_data['car_data'] = new \stdClass();
			}
		} else {
			$ride['driver_data'] = new \stdClass();
		}

		$ride['user_data'] = $user_data;

		return $ride;
	}
	public function getUser($id)
	{
		// echo $id;
		$where = array('id' => $id);
		$userd = User::where($where)->first();
		if (!empty($userd['refer_code'])) {
		} else {
			$random_code = $this->generateRandomString(7);
			$userd->refer_code = $random_code;
			$userd->save();
		}
		$userdata = User::where($where)->first();
		$userdata2 = User::query()->where([['refer_user_id', '=', $id]])->first();
		// print_r($userdata2 ); die;
		// echo $userdata2->email; die;
		if (!empty($userdata2)) {
			if (!empty($userdata2->phone_number)) {
				//echo "if true"; die;
				$userdata['phone_number'] = $userdata2->phone_number;
			} else {
				//echo "else true"; die;
				$userdata['phone_number'] = "";
			}
			if (!empty($userdata2->emails)) {
				$userdata['email'] = $userdata2->email;
			} else {
				$userdata['email'] = "";
			}
			if (!empty($userdata2->addresses)) {
				$userdata['addresses'] = $userdata2->addresses;
			} else {
				$userdata['addresses'] = "";
			}
			if (!empty($userdata2->country)) {
				$userdata['country'] = $userdata2->country;
			} else {
				$userdata['country'] = "";
			}
			if (!empty($userdata2->state)) {
				$userdata['state'] = $userdata2->state;
			} else {
				$userdata['state'] = "";
			}
			if (!empty($userdata2->city)) {
				$userdata['city'] = $userdata2->city;
			} else {
				$userdata['city'] = "";
			}
			if (!empty($userdata2->state)) {
				$userdata['zip'] = $userdata2->state;
			} else {
				$userdata['zip'] = "";
			}
			//$userdata['emails']=json_decode($userdata2->email);
			//$userdata['addresses']=json_decode($userdata2->addresses);
			//$userdata['favourite_address']=json_decode($userdata2->favourite_address);
		} else {
			//echo "else true";
			$userdata['phone_number'] = "";
			$userdata['emails'] = "";
			$userdata['addresses'] = "";
			$userdata['addresses'] = "";
			$userdata['city'] = "";
			$userdata['state'] = "";
			$userdata['zip'] = "";
			$userdata['country'] = "";
		}
		$driver_car = DriverChooseCar::where('user_id', $id)->orderBy('id', 'desc')->first();
		if (!empty($driver_car)) {
			$car_data = Vehicle::select('id', 'model', 'vehicle_image', 'vehicle_number_plate')->where('id', $driver_car['car_id'])->first();
			$userdata['cardata'] = $car_data;
		} else {
			$userdata['cardata'] = null;
		}
		//$cardata = DriverChooseCar::query()->where([['user_id', '=', $id]])->orderBy('id','desc')->first();
		// $userdata['cardata'] = $car_data;
		$ride_detail = "";
		if ($userdata['user_type'] == 1) {
			/* ->where(function($query) {
			$query->where([['status', '=', 0]])->orWhere([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
}) */
			$ride = Ride::query()->where([['user_id', '=', $id]])->where(function ($query) {
				$query->where([['status', '=', 0]])->orWhere([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
			})->orderBy('id', 'desc')->first();
			// print_r('$ride ',$ride ); die;
			if (!empty($ride)) {
				$ride_detail = $this->getRide($ride['id']);
			} else {
				$ride_detail = null;
			}
		}
		if ($userdata['user_type'] == 2) {
			$ride = Ride::query()->where([['driver_id', '=', $id]])->where(function ($query) {
				$query->where([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
			})->orderBy('id', 'asc')->first();
			if (!empty($ride)) {
				$ride_detail = $this->getRide($ride['id']);
			} else {
				$ride_detail = null;
			}
		}
		$userdata['ride_detail'] = $ride_detail;
		//print_r($userdata); die;
		/*  $ncount = Notification::query()->where([['user_id', '=', $id],['status', '=', 0]])->count();
		$userdata['notification_count'] = $ncount; */
		return $userdata;
	}

	public function getRafrenceUser($id)
	{
		$where = array('id' => $id);
		$userd = User::where($where)->first();
		if (!empty($userd['refer_code'])) {
		} else {
			$random_code = $this->generateRandomString(7);
			$userd->refer_code = $random_code;
			$userd->save();
		}
		$userdata = User::where($where)->get();
		$userdata = $userdata[0];
		$driver_car = DriverChooseCar::where(['user_id' => $id, 'logout' => 0])->orderBy('id', 'desc')->first();
		if (!empty($driver_car)) {
			$car_data = Vehicle::select('id', 'model', 'vehicle_image', 'vehicle_number_plate','category_id')->with(['carType:id,price_per_km,basic_fee'])->where('id', $driver_car['car_id'])->first();
			if (!empty($car_data)) {
				$car_data->mileage = $driver_car->mileage;
				$userdata->cardata = $car_data;
			} else {
				$userdata->cardata = null;
			}
			$userdata->cardata = $car_data;
		} else {
			$userdata->cardata = null;
		}
		$userdata->full_name = $userdata->first_name . ' ' . $userdata->last_name;
		$ride_detail = "";
		if ($userdata->user_type == 1) {
			$ride = Ride::query()->where([['user_id', '=', $id]])->where(function ($query) {
				$query->where([['status', '=', 0]])->orWhere([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
			})->orderBy('id', 'desc')->first();
			if (!empty($ride)) {
				$ride_detail = $this->getRide($ride['id']);
			} else {
				$ride_detail = null;
			}
		}
		if ($userdata->user_type == 2) {
			$ride = Ride::query()->where([['driver_id', '=', $id]])->where(function ($query) {
				$query->where([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
			})->orderBy('id', 'asc')->first();
			if (!empty($ride)) {
				$ride_detail = $this->getRide($ride['id']);
			} else {
				$ride_detail = null;
			}
		}
		$userdata->ride_detail = $ride_detail;
		return $userdata;
	}
	
	function generateRandomString($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	public function getAdmin()
	{
		$where = array('user_type' => 1);
		$user = User::where($where)->first();

		return $user;
	}

	public function change_password(Request $request)
	{
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', new MatchOldPassword],
			'new_password' => ['required'],
			'new_confirm_password' => ['same:new_password'],
        ]);
        if ($validator->fails())
        {
            $fields =['current_password','new_password','new_confirm_password'];
            $error_message = "";
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0])) {
                    return response()->json(['success' => 0, 'message' => __($validator->errors()->getMessages()[$field][0])], $this->warningCode);
                }
            }
        }
		User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
		return response()->json(['message' => __('Password changed.')], $this->successCode);
	}
	public function reset_password(Request $request)
	{
		$request->validate([
			// 'current_password' => ['required', new MatchOldPassword],
			'new_password' => ['required'],
			'new_confirm_password' => ['same:new_password'],
		]);
		User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
		return response()->json(['message' => __('Password changed.')], $this->successCode);
	}
	public function update_profile(Request $request)
	{
		$user = Auth::user();

		try {
			if (!empty($request->country_code) && !empty($request->phone)) {
				$already_exist_phone = User::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'user_type' => $user->user_type])->where('id','!=',$user->id)->first();
				if($already_exist_phone){
					return response()->json(['message' => "This phone number already exists for another user."], $this->warningCode);
				}
			}

			if (!empty($request->email)) {
				$user->email = $request->email;
			}

			if (isset($_REQUEST['availability']) && $_REQUEST['availability'] == 0) {
				$user->availability = 0;
				if ($user->user_type == 2) {
					DriverStayActiveNotification::where(['driver_id' => $user->id])->update(['is_availability_alert_sent' => 1, 'is_availability_changed' => 1, 'is_logout_alert_sent' => 0]);
				}
			}
			if (isset($_REQUEST['availability']) && $_REQUEST['availability'] == 1) {
				$user->availability = 1;
				if ($user->user_type == 2) {
					DriverStayActiveNotification::where(['driver_id' => $user->id])->update(['is_availability_alert_sent' => 0, 'is_availability_changed' => 0, 'is_logout_alert_sent' => 0]);
				}
			}

			if (isset($_REQUEST['notification'])) {
				$user->notification = $_REQUEST['notification'];
			}

			if (!empty($request->lat)) {
				$user->lat = $request->lat;
			}

			if (!empty($request->lng)) {
				$user->lng = $request->lng;
			}

			if (!empty($request->location)) {
				$user->location = $request->location;
			}

			if (!empty($request->device_type)) {
				$user->device_type = $request->device_type;
			}
			if (!empty($request->device_token)) {
				$user->device_token = $request->device_token;
			}
			if (!empty($request->app_version)) {
				$user->app_version = $request->app_version;
			}
			if (!empty($request->phone_model)) {
				$user->phone_model = $request->phone_model;
			}
			if (!empty($request->fcm_token)) {

				$user->fcm_token = $request->fcm_token;
			}
			if (!empty($request->country_code)) {
				$user->country_code = ltrim($request->country_code,"+");
			}
			if (!empty($request->phone)) {
				$user->phone = ltrim($request->phone, "0");
			}
			if (!empty($request->first_name)) {
				$user->first_name = $request->first_name;
			}
			if (!empty($request->last_name)) {
				$user->last_name = $request->last_name;
			}

			if (!empty($_FILES['image'])) {

				if (isset($_FILES['image']) && $_FILES['image']['name'] !== '' && !empty($_FILES['image']['name'])) {
					$file = $_FILES['image'];
					$file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
					$filename = time() . '-' . $file;
					$ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$path = "public/images/user_image/";
						if (move_uploaded_file($_FILES['image']['tmp_name'], $path . $filename)) {
							$url = URL::to('/');
							$user->image = $url . "/" . $path . $filename;
						}
					} else {
						return response()->json(['message' => 'Upload valid image'], $this->warningCode);
					}
				}
			}

			//print_r($user); die;
			$user->save();
			$userdata = $this->getRafrenceUser($user->id);

			return response()->json(['message' => 'Success', 'user' => $userdata], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], 401);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], 401);
		}
	}

	public function updateCar(Request $request)
	{
		$user = Auth::user();
		$user_id = $user->id;
		$rules = [
			'car_id' => 'required',
			'mileage' => 'required',
		];
		$car_id = $request->car_id;
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			$oldDriverDetails = DriverChooseCar::where(['car_id' => $car_id, 'logout' => 0])->orderBy('id', 'desc')->first();
			if (!empty($oldDriverDetails)) {
				User::where(['id' => $oldDriverDetails->user_id])->update(['availability' => 0]);
				DB::table('oauth_access_tokens')
					->where(['user_id' => $oldDriverDetails->user_id])
					->delete();
				DriverStayActiveNotification::where(['driver_id' => $oldDriverDetails->user_id])->delete();
			}

			DriverChooseCar::where(function ($query) use ($user_id, $car_id) {
				$query->where(['user_id' => $user_id])->orWhere(['car_id' => $car_id]);
			})->where(['logout' => 0])->update(array('logout' => 1));

			$driverhoosencar = new DriverChooseCar();
			$driverhoosencar->car_id = $request->car_id;
			$driverhoosencar->user_id = $user_id;
			$driverhoosencar->mileage = $request->mileage;
			$driverhoosencar->logout_mileage = $request->mileage;
			$driverhoosencar->logout = 0;
			$driverhoosencar->save();

			return response()->json(['message' => 'Success'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], 401);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], 401);
		}
	}

	// public function phoneVerify(Request $request)
	// {
	// 	$user = Auth::user();
	// 	$rules = [
	// 		'phone' => 'required',
	// 		'country_code' => 'required',
	// 	];

	// 	$validator = Validator::make($request->all(), $rules);
	// 	if ($validator->fails()) {
	// 		return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
	// 	}

	// 	$isphone = User::where(['phone' => ltrim($request->phone, "0")])->first();
	// 	/* if(empty($isphone)){
	// 		return response()->json(['message'=>'Your phone is not registered.'], $this->warningCode);

	// 	} */
	// 	if (!empty($isphone) && $isphone['verify'] == 1) {
	// 		return response()->json(['message' => 'Your phone number already verified.'], $this->warningCode);
	// 	}
	// 	try {

	// 		if (!empty($request->country_code)) {
	// 			$user->country_code = $request->country_code;
	// 		}
	// 		if (!empty($request->phone)) {
	// 			$user->phone = ltrim($request->phone, "0");
	// 		}
	// 		#SEND OTP
	// 		$otp = rand(1000, 9999);

	// 		$expiryMin = config('app.otp_expiry_minutes');
	// 		$endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');
	// 		/* OtpVerification::updateOrCreate(
	// 				['phone'=>$request->phone],
	// 				['otp' => $otp,'expiry'=>$endTime]
	// 			); */
	// 		$otpverify = OtpVerification::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0")])->first();


	// 		if (!empty($otpverify)) {
	// 			$otpverify->otp = $otp;
	// 			$otpverify->expiry = $endTime;
	// 		} else {
	// 			$otpverify = new OtpVerification();
	// 			$otpverify->phone = ltrim($request->phone, "0");
	// 			$otpverify->country_code = $request->country_code;
	// 			$otpverify->otp = $otp;
	// 			$otpverify->expiry = $endTime;
	// 		}
	// 		$otpverify->save();
	// 		//print_r($user); die;
	// 		$user->save();
	// 		$userdata = $this->getRafrenceUser($user->id);

	// 		return response()->json(['message' => 'Success', 'user' => $userdata, 'otp' => $otp], $this->successCode);
	// 	} catch (\Illuminate\Database\QueryException $exception) {
	// 		$errorCode = $exception->errorInfo[1];
	// 		return response()->json(['message' => $exception->getMessage()], 401);
	// 	} catch (\Exception $exception) {
	// 		return response()->json(['message' => $exception->getMessage()], 401);
	// 	}
	// }
	#CONTACT TO ADMIN
	public function adminContact(Request $request)
	{

		$rules = [
			'subject_id' => 'required|integer|exists:subjects,id',
			'description' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first()], $this->warningCode);
		}

		try {

			$subjectData = Subject::where('id', $request->subject_id)->first();

			$contData['user_id'] = Auth::user()->id;
			$contData['subject_id'] = $subjectData->id;
			$contData['subject_name'] = $subjectData->name;
			$contData['description'] = $request->description;

			$dataSaved = AdminContact::create($contData);

			return response()->json(['message' => 'Added successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function logout(Request $request)
	{
		$user_id = Auth::user()->id;
		if (Auth::user()->user_type == 2) {
			DriverStayActiveNotification::where(['driver_id' => $user_id])->delete();
		}
		if (!empty($request->car_id)) {
			$driverhoosecar = DriverChooseCar::where(['user_id' => $user_id, 'car_id' => $request->car_id, 'logout' => 0])->orderBy('id', 'desc')->first();
			if (!empty($driverhoosecar)) {
				if (!empty($request->mileage)) {
					$driverhoosecar->logout_mileage = $request->mileage;
				}
				$driverhoosecar->logout = 1;
				$driverhoosecar->save();
			}
		}
		$user = User::find($user_id);
		$user->fcm_token = "";
		$user->device_type = "";
		$user->device_token = "";
		$user->availability = 0;
		$user->save();
		Auth::user()->AauthAcessToken()->delete();
		return response()->json(['message' => __('Logged out successfully')], $this->successCode);
	}




	public function get_users(Request $request)
	{
		$where = array('status' => 1, 'user_type' => 2, 'verify' => 1);
		// Search Parameter
		isset($request->q) ? $q = $request->q : $q = null;
		// Sort Parameter
		$sort = [];
		if (isset($request->sortby) && (isset($request->direction))) {
			$sort[$request->sortby] = $request->direction;
		}
		$users = User::where($where)->ofSearch($q)->ofSort($sort)->paginate($this->limit);
		return response()->json(['message' => __('Successful.'), 'users' => $users], $this->successCode);
	}
	public function get_notification(Request $request)
	{
		$userId = Auth::user()->id;
		$user = User::where(['id' => $userId])->first();
		$where = array('user_id' => $userId);
		$query = \App\Notification::select('notifications.*', DB::raw("0 AS category_ids"))->where($where)->whereIn('type', [2, 3, 4, 5, 6, 7, 8]);

		$notification = $query->paginate($this->limit);
		return response()->json(['message' => __('Successful.'), 'notification' => $notification], $this->successCode);
	}
	public function categories(Request $request)
	{
		$where = array('status' => 1);
		// Search Parameter
		isset($request->q) ? $q = $request->q : $q = null;
		// Sort Parameter
		$sort = [];
		if (isset($request->sortby) && (isset($request->direction))) {
			$sort[$request->sortby] = $request->direction;
		}
		$user_id = 0;
		if (!empty(auth('api')->user())) {
			$user_id = auth('api')->user()->id;
		}
		// dd(Auth::user(), Auth::Guest());
		// dd(Auth::user()->id);

		$categories = Category::select("categories.*")
			->where($where)
			->ofSearch($q)
			->ofSort($sort)
			->paginate($this->limit);
		return response()->json(['message' => __('Successful.'), 'categories' => $categories], $this->successCode);
	}

	public function sendOtp(Request $request)
	{
		$rules = [
			'country_code' => 'required|integer',
			'phone' => 'required|integer',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => __('All fields are required.'), 'error' => $validator->errors()], $this->warningCode);
		}
		try {
			// OtpVerification
			$expiryMin = config('app.otp_expiry_minutes');
			$endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');
			$otp = rand(1000, 9999);
			OtpVerification::updateOrCreate(
				['country_code' => ltrim($request->country_code,"+"), 'phone' => ltrim($request->phone, "0")],
				['otp' => $otp, 'expiry' => $endTime, 'device_type' => $request->device_type??""]
			);
			$this->sendSMS("+".ltrim($request->country_code,"+"), ltrim($request->phone, "0"), "Dear User, your Veldoo verification code is ".$otp);
			return response()->json(['message' => __('Send Successfully.'), 'otp' => $otp], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function otpVerify(Request $request)
	{
		$rules = [
			'country_code' => 'required|integer',
			'phone' => 'required|integer',
			'otp' => 'required|integer',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => __('All fields are required.'), 'error' => $validator->errors()], $this->warningCode);
		}
		try {
			$expiryMin = config('app.otp_expiry_minutes');
			// OtpVerification
			$now = Carbon::now();
			$haveOtp = OtpVerification::where(['country_code' => ltrim($request->country_code,"+"), 'phone' => ltrim($request->phone, "0"), 'otp' => $request->otp])->first();
			if (empty($haveOtp)) {
				return response()->json(['message' => 'Invalid OTP'], $this->warningCode);
			}
			if ($now->diffInMinutes($haveOtp->expiry) > $expiryMin) {
				return response()->json(['message' => 'OTP is expired'], $this->warningCode);
			}
			$haveOtp->delete();
			$userData = User::where(['country_code' => ltrim($request->country_code,"+"), 'phone' => ltrim($request->phone, "0"), 'user_type' => 1])->first();
			if (!empty($userData)) {
				$user = Auth::login($userData);
				if (!empty($request->fcm_token)) {

					$userData->fcm_token = $request->fcm_token;
				}
				if (!empty($request->device_type)) {
					$userData->device_type = $request->device_type;
				}
				if (!empty($request->device_token)) {
					$userData->device_token = $request->device_token;
				}
				if (!empty($request->app_version)) {
					$userData->app_version = $request->app_version;
				}
				if (!empty($request->phone_model)) {
					$userData->phone_model = $request->phone_model;
				}
				$userData->verify = 1;
				$userData->save();
				$token =  $userData->createToken('auth')->accessToken;

				$user = $this->getRafrenceUser($userData['id']);

				return response()->json(['message' => 'Verified Successfully', 'user' => $user, 'token' => $token], $this->successCode);
			} else {

				return response()->json(['message' => 'Verified Successfully.', 'token' => ''], $this->successCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function adClick(Request $request)
	{
		$rules = [
			'id' => 'required|integer',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('admin.All fields are required.'), 'error' => $validator->errors()], $this->warningCode);
		}
		try {
			$now = Carbon::now();
			$haveAd = \App\Ad::where(['id' => $request->id, 'status' => 1])->first();
			if (empty($haveAd)) {
				return response()->json(['message' => trans('admin.Invalid Ad')], $this->warningCode);
			}
			if ($haveAd->total_click >= $haveAd->click_limit) {
				return response()->json(['message' => trans('admin.Ad limit exceeded.')], $this->warningCode);
			}
			$haveAd->total_click =  ($haveAd->total_click + 1);
			$haveAd->save();
			return response()->json(['message' => trans('admin.Successful.')], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function guestTest(Request $request)
	{

		$dataM = array('name' => "Virat Gandhi");
		$data = array('name' => 1296);
		$m = Mail::send('mail', $data, function ($message) use ($request) {
			$message->to($request->to, 'OTP Verification')->subject('OTP Verification Code');
			if (!empty($request->from)) {
				$message->from($request->from, 'Prospects');
			}
		});
		dd($m);

		$user = $this->getRafrenceUser(104);
		$usedTags = \App\Topic::where('user_id', 104)->with('tags:name')->get()->pluck('tags')->flatten()->pluck('name')->unique();
		// dd($usedTags->toArray());
		return response()->json(['message' => __('Successfully.'), 'user' => $user, 'usedTags' => $usedTags], $this->successCode);
	}
	public function driver_list()
	{

		$user = Auth::user();
		$user_id = $user['id'];
		$q = User::query();



		if (!empty($_REQUEST['lat']) && !empty($_REQUEST['lng'])) {

			$lat = $_REQUEST['lat'];
			$lon = $_REQUEST['lng'];

			$query = User::select(
				"users.*",
				DB::raw("3959 * acos(cos(radians(" . $lat . "))
                    * cos(radians(users.lat))
                    * cos(radians(users.lng) - radians(" . $lon . "))
                    + sin(radians(" . $lat . "))
                    * sin(radians(users.lat))) AS distance")
			);
			$query->where('user_type', '=', 3)->having('distance', '<', 2000)->orderBy('distance', 'asc');
			/* $query->where('user_type','=',3);
                    $query->where('distance','<=',20);
                    $query->orderBy('distance','asc'); */




			$resnewarray = $query->get()->toArray();

			if (!empty($resnewarray)) {
				//$newresultarray[$i]['user_data'] = $this->get_user($result['user_id']);
				//  $this->api_response(200,'Homedata listed successfully',$resnewarray);
				/*  $resnewarray = array();
		  foreac */

				$i = 0;
				$newresultarray = array();
				foreach ($resnewarray as $result) {

					$newresultarray[$i] = $result;
					/* $dealimgresults = DealImage::query()->where('deal_images.deal_id',$result['id'])->orderBy('deal_images.id','DESC')->get()->toArray();
				$newresultarray[$i]['deal_images'] = $dealimgresults;
				$views= Click::where('deal_id', '=', $result['id'])->count();
				$newresultarray[$i]['views'] = "$views";
				$purchases= Order::where('deal_id', '=', $result['id'])->count();
				$newresultarray[$i]['purchases'] = "$purchases";
				$avgrating = DB::table('reviews')->where('business_user_id', $result['user_id'])->avg('rating');
				$avgrating = round($avgrating,2);
				$newresultarray[$i]['business_avg_rating'] = "$avgrating"; */
					$i++;
				}

				return response()->json(['message' => __('Successfully.'), 'drivers' => $newresultarray], $this->successCode);
			} else {
				return response()->json(['message' => 'No data found'], $this->successCode);
			}
		} else {
			return response()->json(['message' => 'Please fill all required fields'], $this->warningCode);
		}
	}
	#ADD MENU ITEM
	public function addFav(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'item_id' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {





			$fav = Favourite::query()->where([['user_id', '=', $user_id], ['item_id', '=', $request->item_id]])->first();
			if (!empty($fav)) {
			} else {
				$fav = new Favourite();
			}
			$fav->item_id = $request->item_id;
			$fav->status = $request->status;



			$fav->user_id = $user_id;
			unset($fav->created_at);
			unset($fav->updated_at);



			if ($fav->save()) {
			}
			if ($request->status == 1) {
				return response()->json(['message' => 'Favourite Added successfully'], $this->successCode);
			} else {
				return response()->json(['message' => 'Favourite Removed successfully'], $this->successCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function fav_list()
	{

		$user = Auth::user();
		$user_id = $user['id'];
		$resnewarray = Favourite::query()->where([['user_id', '=', $user_id], ['status', '=', 1]])->get()->toArray();





		if (!empty($resnewarray)) {
			//$newresultarray[$i]['user_data'] = $this->get_user($result['user_id']);
			//  $this->api_response(200,'Homedata listed successfully',$resnewarray);
			/*  $resnewarray = array();
		  foreac */

			$i = 0;
			$newresultarray = array();
			foreach ($resnewarray as $result) {
				$item = Item::where(['id' => $result['item_id']])->first();

				$driver_data = User::where(['id' => $item['user_id']])->first();
				$newresultarray[$i] = $item;
				$newresultarray[$i]['fav'] = '1';
				$newresultarray[$i]['driver_data'] = $driver_data;
				/* $dealimgresults = DealImage::query()->where('deal_images.deal_id',$result['id'])->orderBy('deal_images.id','DESC')->get()->toArray();
				$newresultarray[$i]['deal_images'] = $dealimgresults;
				$views= Click::where('deal_id', '=', $result['id'])->count();
				$newresultarray[$i]['views'] = "$views";
				$purchases= Order::where('deal_id', '=', $result['id'])->count();
				$newresultarray[$i]['purchases'] = "$purchases";
				$avgrating = DB::table('reviews')->where('business_user_id', $result['user_id'])->avg('rating');
				$avgrating = round($avgrating,2);
				$newresultarray[$i]['business_avg_rating'] = "$avgrating"; */
				$i++;
			}

			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} else {
			return response()->json(['message' => 'No data found'], $this->successCode);
		}
	}
	public function addPlace(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'label' => 'required',
			'lat' => 'required',
			'lng' => 'required',
			'address' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$place = new Place();

			$place->label = $request->label;
			$place->address = $request->address;
			$place->lat = $request->lat;
			$place->lng = $request->lng;



			$place->user_id = $user_id;
			unset($place->created_at);
			unset($place->updated_at);
			//print_r($place); die;
			$place->save();


			return response()->json(['message' => 'Address Added successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function addwallet(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'price' => 'required',


		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$wallet = new Wallet();

			$wallet->price = $request->price;
			$wallet->type = 1;
			if (!empty($request->payment_id)) {
				$wallet->payment_id = $request->payment_id;
			}



			$wallet->user_id = $user_id;
			unset($wallet->created_at);
			unset($wallet->updated_at);
			//print_r($place); die;
			$wallet->save();
			$where = array('id' => $user_id);

			$userdata = User::where($where)->first();
			$wallet_amount = $userdata['wallet_amount'];
			if (!empty($wallet_amount)) {
				$newwallet_amount = $wallet_amount + $request->price;
			} else {
				$newwallet_amount = $request->price;
			}
			$userdata->wallet_amount = $newwallet_amount;
			$userdata->save();
			return response()->json(['message' => 'Amount Added successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function deleteCard(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];

		$rules = [
			'card_id' => 'required'

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}


		try {
			//DB::table('places')->where('id', $request->place_id)->delete();
			DB::table('cards')->where([['id', '=', $request->card_id], ['user_id', '=', $user_id]])->delete();
			$msg = "Card Deleted Successfully";
			return response()->json(['message' => $msg], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function deletePlace(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];

		$rules = [
			'place_id' => 'required'

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}


		try {
			//DB::table('places')->where('id', $request->place_id)->delete();
			DB::table('places')->where([['id', '=', $request->place_id], ['user_id', '=', $user_id]])->delete();
			$msg = "Place Deleted Successfully";
			return response()->json(['message' => $msg], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function addPersonal(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'firstname' => 'required',
			'id_number' => 'required',
			'issue_date' => 'required',
			'expiry_date' => 'required',
			'license_number' => 'required',
			'driver_class' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$personal = new UserMeta();

			$personal->firstname = $request->firstname;
			$personal->id_number = $request->id_number;
			$personal->issue_date = $request->issue_date;
			$personal->expiry_date = $request->expiry_date;
			$personal->license_number = $request->license_number;
			$personal->driver_class = $request->driver_class;



			$personal->user_id = $user_id;
			unset($personal->created_at);
			unset($personal->updated_at);
			//print_r($place); die;
			$personal->save();

			$user->step = 1;

			$user->save();

			return response()->json(['message' => 'Personal Info Added successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function giveRating(Request $request)
	{
		$userId = Auth::user()->id;
		$rules = [
			'rating' => 'required',
			'to_id' => 'required',
			'ride_id' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}
		try {
			$rating = new Rating();
			$rating->to_id = $request->to_id;
			$rating->rating = $request->rating;
			$rating->ride_id = $request->ride_id;
			$rating->from_id = $userId;
			$rating->comment = $request->comment??"";
			$rating->save();
			return response()->json(['message' => 'Rating Added successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $e) {
			Log::info('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $e->getLine(). ' --- ' . $e->getMessage());
			return response()->json(['message' => $e->getMessage()], $this->warningCode);
		} catch (\Exception $e) {
			Log::info('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $e->getLine(). ' --- ' . $e->getMessage());
			return response()->json(['message' => $e->getMessage()], $this->warningCode);
		}
	}

	public function bookRide(Request $request)
	{
		try {
			$userId = Auth::user()->id;

			// $rules = [
			// 	//'pick_lat' => 'required',
			// 	//'pick_lng' => 'required',
			// 	//'dest_lat' => 'required',
			// 	//'dest_lng' => 'required',
			// 	'pickup_location' => 'required',
			// 	//'dest_address' => 'required',
			// 	'car_type' => 'required',
			// 	'ride_time' => 'required',
			// 	//'ride_type'=>'required',
			// ];
			// $validator = Validator::make($request->all(), $rules);

			// $validator = Validator::make($request->all(), [
			// 	'pickup_location' => 'required',
			// 	'pick_lat' => 'required',
			// 	'pick_lng' => 'required',
			// 	'car_type' => 'required',
			// 	'ride_time' => 'required',
			// ], [ 
			// 	'pickup_location.required' => 'The pickup location field is required.',
			// 	'pick_lat.required' => 'Pickup location data missing. Please select pickup location again.',
			// 	'pick_lng.required' => 'Pickup location data missing. Please select pickup location again.',
			// ]);

			// if ($validator->fails()) {
			// 	return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
			// }

			if(empty($request->pickup_location)) {
				return response()->json(['message' => "The pickup location field is required"], $this->warningCode);
			}
			if(empty($request->pick_lat)) {
				return response()->json(['message' => "Pickup location data missing. Please select pickup location again."], $this->warningCode);
			}
			if(empty($request->pick_lng)) {
				return response()->json(['message' => "Pickup location data missing. Please select pickup location again."], $this->warningCode);
			}
			if(empty($request->car_type)) {
				return response()->json(['message' => "The car type field is required."], $this->warningCode);
			}
			if(empty($request->ride_time)) {
				return response()->json(['message' => "The ride time field is required."], $this->warningCode);
			}
			$all_rides_dates = [];
			if (!empty($request->additional_dates)) {
				$ride_only_time = date('H:i:s', strtotime($request->ride_time));
				foreach ($request->additional_dates as $additional_date) {
					$all_rides_dates[] = $additional_date . " " . $ride_only_time;
				}
				$all_rides_dates = array_unique($all_rides_dates);
			} else {
				$all_rides_dates = [$request->ride_time];
			}
			$all_ride_ids = [];
			$rideUser = User::find($request->user_id);
			foreach ($all_rides_dates as $ride_date_time) {
				$ride = new Ride();
				if ($rideUser)
				{
					$ride->user_country_code = $rideUser->country_code;
					$ride->user_phone = $rideUser->phone;
				}
				$ride->user_id = $request->user_id;
				$ride->pickup_address = $request->pickup_location;
				$ride->dest_address = $request->drop_off_location;
				$ride->passanger = $request->passanger;
				$ride->note = $request->note;
				$ride->ride_type = 1;
				$ride->car_type = $request->car_type;
				$ride->driver_id = $request->driver_id ?? null;
				$ride->route = $request->route ?? null;
				if (!empty($request->alert_time)) {
					$ride->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('-' . $request->alert_time . ' minutes', strtotime($ride_date_time)));
				} else {
					$ride->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('-15 minutes', strtotime($ride_date_time)));
				}
				$ride->alert_time = $request->alert_time ?? null;
				if (!empty($request->pick_lat)) {
					$ride->pick_lat = $request->pick_lat;
				}
				if (!empty($request->pick_lng)) {
					$ride->pick_lng = $request->pick_lng;
				}
				if (!empty($request->dest_lat)) {
					$ride->dest_lat = $request->dest_lat;
				}
				if (!empty($request->dest_lng)) {
					$ride->dest_lng = $request->dest_lng;
				}
				if (!empty($request->payment_type)) {
					$ride->payment_type = $request->payment_type;
				}

				if (!empty($request->ride_cost)) {
					$ride->ride_cost = $request->ride_cost;
				}
				$ride->ride_time = $ride_date_time;
				if (!empty($request->distance)) {
					$ride->distance = $request->distance;
				}
				if (!empty($request->company_id)) {
					$ride->company_id = $request->company_id;
				}
				$ride->created_by = 2;
				$ride->creator_id = Auth::user()->id;
				$ride->status = 0;
				$ride->platform = Auth::user()->device_type;
                $ride->service_provider_id = Auth::user()->service_provider_id;
				$ride->save();
				$all_ride_ids[] = $ride->id;
			}

			if(!empty($all_ride_ids) && count($all_ride_ids) > 1){
				Ride::whereIn('id',$all_ride_ids)->update(['parent_ride_id' => $all_ride_ids[0]]);
			}

			/* When a planned ride is created by any driver, send a notification to all master drivers about this */
			$settings = Setting::where('service_provider_id',Auth::user()->service_provider_id)->first();
			$settingValue = json_decode($settings['value']);

			$masterDriverIds = User::whereNotNull('device_token')->whereNotNull('device_type')->where(['user_type' => 2, 'is_master' => 1, 'service_provider_id'=>Auth::user()->service_provider_id])->pluck('id')->toArray();
			$ride = new RideResource(Ride::find($ride->id));
			if (!empty($masterDriverIds)) {
				$title = 'Ride is planned';
				$message = 'A new ride is planned';
				$ride['waiting_time'] = $settingValue->waiting_time;
				$additional = ['type' => 15, 'ride_id' => $ride->id, 'ride_data' => $ride];
				$ios_driver_tokens = User::whereIn('id', $masterDriverIds)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'ios'])->pluck('device_token')->toArray();
				if (!empty($ios_driver_tokens)) {
					bulk_pushok_ios_notification($title, $message, $ios_driver_tokens, $additional, $sound = 'default', 2);
				}
				$android_driver_tokens = User::whereIn('id', $masterDriverIds)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'android'])->pluck('device_token')->toArray();
				if (!empty($android_driver_tokens)) {
					bulk_firebase_android_notification($title, $message, $android_driver_tokens, $additional);
				}
				$notification_data = [];
				foreach ($masterDriverIds as $driverid) {
					$notification_data[] = ['title' => $title, 'description' => $message, 'type' => 15, 'user_id' => $driverid, 'additional_data' => json_encode($additional), 'service_provider_id' => Auth::user()->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
				}
				Notification::insert($notification_data);
			}
			// if (!empty($ride->user) && empty($ride->user->password) && !empty($ride->user->phone)) {
			// 	$message_content = "";
			// 	$SMSTemplate = SMSTemplate::find(2);
			// 	if ($ride->user->country_code == "41" || $ride->user->country_code == "43" || $ride->user->country_code == "49") {
			// 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#TIME#', date('d M, Y h:ia', strtotime($ride->ride_time)), $SMSTemplate->german_content));
			// 	} else {
			// 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#TIME#', date('d M, Y h:ia', strtotime($ride->ride_time)), $SMSTemplate->english_content));
			// 	}
			// 	$this->sendSMS("+" . $ride->user->country_code, ltrim($ride->user->phone, "0"), $message_content);
			// }
			return response()->json(['message' => 'Ride Booked successfully', 'data' => $ride], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	/* public function shareRide(Request $request){
		$user = Auth::user();
			$user_id = $user['id'];
		$rules = [
			'pick_lat' => 'required',
			'pick_lng' => 'required',
			//'dest_lat' => 'required',
			//'dest_lng' => 'required',
			'pickup_address' => 'required',
			//'dest_address' => 'required',
			'car_type' => 'required',
			'payment_type' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message'=>trans('api.required_data'),'error'=>$validator->errors()], $this->warningCode);
        }

		try {

				$ride = new Ride();

			$ride->pick_lat = $request->pick_lat;
            $ride->pick_lng = $request->pick_lng;
			if(!empty($request->drop_location))
		{
		$ride->drop_location=$request->drop_location;
		}
			if(!empty($request->dest_lat))
			{
            $ride->dest_lat = $request->dest_lat;
			}
			if(!empty($request->dest_lng))
			{
            $ride->dest_lng = $request->dest_lng;
			}
            $ride->pickup_address = $request->pickup_address;
			if(!empty($request->dest_address))
			{
            $ride->dest_address = $request->dest_address;
			}
			if(!empty($request->passanger))
			{
			$ride->passanger =$request->passanger;
			}
			if(!empty($request->schedule_time))
			{
			$ride->schedule_time =$request->schedule_time;
			}
            $ride->price = $request->price;
            $ride->car_type = $request->car_type;
            $ride->payment_type = $request->payment_type;
            $ride->pool_ride = 1;
            $ride->created_by = 1;
            $pool_number = time();
            $ride->pool_number = $pool_number;


            $ride->user_id = $user_id;
          unset($ride->created_at);
            unset($ride->updated_at);
			//print_r($place); die;


			 $lat = $_REQUEST['pick_lat'];
            $lon = $_REQUEST['pick_lng'];

			$query = User::select("users.*"
                    ,DB::raw("3959 * acos(cos(radians(" . $lat . "))
                    * cos(radians(users.current_lat))
                    * cos(radians(users.current_lng) - radians(" . $lon . "))
                    + sin(radians(" .$lat. "))
                    * sin(radians(users.current_lat))) AS distance"));
					$query->where('user_type', '=',2)->having('distance', '<', 20)->orderBy('distance','asc');
					$drivers = $query->get()->toArray();
	 $driverids = array();
			if(!empty($drivers))
			{
				foreach($drivers as $driver)
				{

			$checkride = Ride::query()->where([['driver_id', '=', $driver['id']],['status', '=', 0],['car_type', '=', 4]])->first();
			//print_r($checkride);
			if(!empty($checkride))
			{
				$driverids[] = $driver['id'];
				$ride->pool_number = $checkride['pool_number'];
			}
			else
			{
			//echo $driver['id']; die;
					$driverids[] = $driver['id'];
				$title = 'New Booking';
		$message = 'You Received new booking';

		$type = 1;
		$deviceToken = $driver['device_token'];
		$additional = ['type'=>$type,'ride_id'=>0];
		//$additional = ['type'=>1];
	//echo $deviceToken; die;

		$deviceType = $driver['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				$deviceToken = $driver['fcm_token'];
		send_iosnotification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver['id'];
		$notification->save();
			}
				}

				}
				$driverids = implode(",",$driverids);
			}
			else
			{
				return response()->json(['message'=>"No Driver Found"], $this->successCode);
			}
			if(empty($driverids))
			{
				return response()->json(['message'=>"No Driver Found"], $this->successCode);
			}
			$ride->driver_id = $driverids;
			$lat1 = $request->pick_lat;
            $long1 = $request->pick_lng;
            $lat2 = $request->dest_lat;
            $long2 = $request->dest_lng;
			$distance = $this->getdistancebyDirection($lat1,$long1,$lat2,$long2);
			if(!empty($distance))
			{
				$ride->distance = round($distance['distance'],2);
				$ride->duration = $distance['duration'];
			}
			else
			{
				return response()->json(['message'=>"No Driver Found"], $this->successCode);
			}
			//echo $distance; die;
		  $ride->save();
		  $rideid = $ride->id;
		  $ride= Ride::query()->where([['id', '=', $rideid]])->first();
				return response()->json(['message'=>'Booking Created successfully','data'=>$ride], $this->successCode);


		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	} */
	public function scheduleRide(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'pick_lat' => 'required',
			'pick_lng' => 'required',
			'dest_lat' => 'required',
			'dest_lng' => 'required',
			'pickup_address' => 'required',
			'dest_address' => 'required',
			'car_type' => 'required',
			'payment_type' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$ride = new Ride();

			$ride->pick_lat = $request->pick_lat;
			$ride->pick_lng = $request->pick_lng;
			$ride->dest_lat = $request->dest_lat;
			$ride->dest_lng = $request->dest_lng;
			$ride->pickup_address = $request->pickup_address;
			$ride->dest_address = $request->dest_address;
			$ride->price = $request->price;
			$ride->car_type = $request->car_type;
			$ride->payment_type = $request->payment_type;
			$ride->schedule_ride = $request->schedule_ride;
			$ride->schedule_time = $request->schedule_time;
			$ride->ride_time = $request->schedule_ride;



			$ride->user_id = $user_id;
			$rideUser = User::find($user_id);
			if ($rideUser)
			{
				$ride->user_country_code = $rideUser->country_code;
				$ride->user_phone = $rideUser->phone;
			}
			unset($ride->created_at);
			unset($ride->updated_at);
			//print_r($place); die;


			$lat = $_REQUEST['pick_lat'];
			$lon = $_REQUEST['pick_lng'];

			/* $query = User::select("users.*"
                    ,DB::raw("3959 * acos(cos(radians(" . $lat . "))
                    * cos(radians(users.current_lat))
                    * cos(radians(users.current_lng) - radians(" . $lon . "))
                    + sin(radians(" .$lat. "))
                    * sin(radians(users.current_lat))) AS distance"));
					$query->where('user_type', '=',2)->having('distance', '<', 20)->orderBy('distance','asc');
					$drivers = $query->get()->toArray();
	 $driverids = array();
			if(!empty($drivers))
			{
				foreach($drivers as $driver)
				{
					$driverids[] = $driver['id'];
				$title = 'New Booking';
		$message = 'You Received new booking';


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
			else
			{
				return response()->json(['message'=>"No Driver Found"], $this->successCode);
			}
			$ride->driver_id = $driverids; */
			$lat1 = $request->pick_lat;
			$long1 = $request->pick_lng;
			$lat2 = $request->dest_lat;
			$long2 = $request->dest_lng;
			$distance = $this->getdistancebyDirection($lat1, $long1, $lat2, $long2);
			if (!empty($distance)) {
				$ride->distance = round($distance['distance'], 2);
				$ride->duration = $distance['duration'];
			} else {
				return response()->json(['message' => "No Driver Found"], $this->successCode);
			}
			//echo $distance; die;
			$ride->save();
			$rideid = $ride->id;
			$ride = Ride::query()->where([['id', '=', $rideid]])->first();
			return response()->json(['message' => 'Booking Created successfully', 'data' => $ride], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function getdistancebyDirection($lat1, $long1, $lat2, $long2)
	{

		/* echo "lat1 ".$lat1;
echo "long1 ".$long1;
echo "lat2 ".$lat2;
echo "long2 ".$long2;
die; */
		// $lat1 = $_REQUEST['lat1'];
		// $long1 = $_REQUEST['lon1'];
		// $lat2 =  $_REQUEST['lat2'];
		// $long2 = $_REQUEST['lon2'];
		// AIzaSyBSKGC2md-gYLtjwtN0LUWUKzvulhgZhf8
		// new key = AIzaSyB3BkG8m_df4tC9LoWfKcSGFBxuW6GJ0Jo
		$url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $lat1 . "," . $long1 . "&destination=" . $lat2 . "," . $long2 . "&alternatives=true&sensor=false&key=AIzaSyBziz-4En_1Mj_aM73wJvsd4kG3bR3wr3A";
		/* $url = str_replace(" ","",$url);
echo $url; die; */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);

		curl_close($ch);
		//$json = file_get_contents($url);

		/* print_r($data['results'][0]['geometry']['location']['lat']);
print_r($data['results'][0]['geometry']['location']['lng']); */
		/*  $routes=json_decode(file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=$origin&destination=$destination&alternatives=true&sensor=false&key=AIzaSyBSKGC2md-gYLtjwtN0LUWUKzvulhgZhf8"))->routes; */
		//print_r($response); die;
		if (!empty($response)) {

			$data = json_decode($response, TRUE);
			if (!empty($data['routes'])) {
				$routes = $data['routes'];

				$legarray = array();
				$kk = 0;
				foreach ($routes as $route) {
					$legarray[$kk] = $route['legs'];
					$kk++;
				}
				$distancearr = array();
				$durationarray = array();
				$jj = 0;
				foreach ($legarray as $legar) {
					$distancearr[$jj] = $legar[0]['distance']['value'];
					$durationarray[$jj] = $legar[0]['duration']['value'];
					$jj++;
				}



				//print the shortest distance
				$distance = min($distancearr);
				$duration = min($durationarray);
				$distance = $distance * 0.621371;
				$distance = $distance / 1000;



				if (!empty($distance)) {
					$distanceduration['distance'] = $distance;
					$distanceduration['duration'] = $duration;
					return $distanceduration;
				} else {
					return 0;
				}
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}
	public function newRides(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];


		$rules = [
			'type' => 'required',


		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}
		try {
			if ($request->type == 1) {

				$resnewarray = Ride::query()->where([['status', '=', 0]])->whereRaw('FIND_IN_SET(?,driver_id)', [$user_id])->orderBy('id', 'desc')->get()->toArray();
			}
			if ($request->type == 2) {

				$resnewarray = Ride::query()->where([['status', '=', 3]])->Where('driver_id', [$user_id])->orderBy('id', 'desc')->get()->toArray();
			}
			if ($request->type == 3) {

				$resnewarray = Ride::query()->where([['status', '<', -1]])->Where('driver_id', [$user_id])->orderBy('id', 'desc')->get()->toArray();
			}

			$newresultarray = array();
			if (!empty($resnewarray)) {

				$i = 0;

				foreach ($resnewarray as $result) {
					$newresultarray[$i] = $result;
					$rating_data = Rating::query()->where([['ride_id', '=', $result['id']]])->get()->toArray();
					if (!empty($rating_data)) {
						$newresultarray[$i]['rate_status'] = "1";
					} else {
						$newresultarray[$i]['rate_status'] = "0";
					}
					//$currenttime = date('h:i A');
					//echo date_default_timezone_get(); die;


					$i++;
				}
			}
			/*  $amount = array();
  $amount['go'] = round((3*$amountsetgo),2);
  $amount['premier'] = round((4*$amountsetpremier),2);
  $amount['xl'] = round((5*$amountsetxl),2);
  $amount['pool'] = round((2*$amountsetpool),2); */



			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function earning_detail(Request $request)
	{
		$user = Auth::user();
		$rules = [
			'type' => 'required',
		];
		$user_id = 0;
		if (!empty($request->driver_id)) {
			$user_id = $request->driver_id;
		}

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			$resnewarray = Ride::with(['user', 'driver', 'company_data']);
			$rideWithPayment = Ride::select(DB::raw("sum(ride_cost) as ride_cost, payment_type"));
			if ($request->type == 1) {
				$month = $request->month;
				$year = $request->year;
				$resnewarray = $resnewarray->whereMonth('ride_time', date("$month"))->whereYear('ride_time', date("$year"));
				$rideWithPayment = $rideWithPayment->whereMonth('ride_time', date("$month"))->whereYear('ride_time', date("$year"));
			} else if ($request->type == 2) {
				$date = $request->date;
				$resnewarray = $resnewarray->whereDate('ride_time', date("$date"));
				$rideWithPayment = $rideWithPayment->whereDate('ride_time', date("$date"));
			} else if ($request->type == 3) {
				$start_date = Carbon::parse($request->start_date)
					->toDateString();
				$end_date = Carbon::parse($request->end_date)
					->toDateString();
				$resnewarray = $resnewarray->whereBetween('ride_time', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
				$rideWithPayment = $rideWithPayment->whereBetween('ride_time', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
			}
			if (!empty($user_id)) {
				$resnewarray = $resnewarray->where(['driver_id' => $user_id]);
				$rideWithPayment = $rideWithPayment->where(['driver_id' => $user_id]);
			}
			$resnewarray = $resnewarray->where(['status' => 3]);
			$paginated_rides = $resnewarray->orderBy('ride_time', 'desc')->paginate(20);
			$rideWithPayment = $rideWithPayment->where(['status' => 3])->groupBy('payment_type')->get();

			$total_earning = (float)$resnewarray->sum('ride_cost');
			$cash_earning = (float)$resnewarray->where(['payment_type' => 'Cash'])->sum('ride_cost');
			return response()->json(['message' => __('Successfully.'), 'data' => $paginated_rides, 'total_earning' => $total_earning, 'cash_earning' => $cash_earning, 'overall_earnings' => $rideWithPayment], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function drivercompleted_ride(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];


		try {

			$resnewarray = Ride::query()->where([['status', '=', 3]])->whereRaw('driver_id', [$user_id])->orderBy('id', 'desc')->get()->toArray();




			$newresultarray = array();
			if (!empty($resnewarray)) {

				$i = 0;

				foreach ($resnewarray as $result) {
					$newresultarray[$i] = $result;

					//$currenttime = date('h:i A');
					//echo date_default_timezone_get(); die;


					$i++;
				}
			}




			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function drivercancelled_ride(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];


		try {

			$resnewarray = Ride::query()->where([['status', '<', -1]])->whereRaw('driver_id', [$user_id])->orderBy('id', 'desc')->get()->toArray();




			$newresultarray = array();
			if (!empty($resnewarray)) {

				$i = 0;

				foreach ($resnewarray as $result) {
					$newresultarray[$i] = $result;

					//$currenttime = date('h:i A');
					//echo date_default_timezone_get(); die;


					$i++;
				}
			}




			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function userRideList(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'type' => 'required',


		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			if ($request->type == 1) {
				$resnewarray = Ride::query()->where([['user_id', '=', $user_id], ['status', '=', 3]])->orderBy('id', 'desc')->get()->toArray();
			}
			if ($request->type == 2) {
				$resnewarray = Ride::query()->where([['user_id', '=', $user_id], ['status', '=', -1]])->orWhere('status', -2)->orWhere('status', -3)->orderBy('id', 'desc')->get()->toArray();
			}
			if ($request->type == 3) {
				$resnewarray = Ride::query()->where([['user_id', '=', $user_id], ['schedule_ride', '=', 1]])->orderBy('id', 'desc')->get()->toArray();
			}


			$newresultarray = array();
			if (!empty($resnewarray)) {

				$i = 0;

				foreach ($resnewarray as $result) {
					$newresultarray[$i] = $result;
					$rating_data = Rating::query()->where([['ride_id', '=', $result['id']], ['from_id', '=', $user_id]])->get()->toArray();
					if (!empty($rating_data)) {
						$newresultarray[$i]['rating_data'] = $rating_data;
					} else {
						$newresultarray[$i]['rating_data'] = array();
					}
					if (!empty($result['driver_id'])) {
						//$driverData= User::query()->where([['id', '=', $result['driver_id']]])->first();
						$vehicle_detail = Vehicle::query()->where([['user_id', '=', $result['driver_id']]])->first();
						$newresultarray[$i]['vehicle_info'] = $vehicle_detail;
					} else {
						$newresultarray[$i]['vehicle_info'] = array();
					}
					//$currenttime = date('h:i A');
					//echo date_default_timezone_get(); die;


					$i++;
				}
			}
			/*  $amount = array();
  $amount['go'] = round((3*$amountsetgo),2);
  $amount['premier'] = round((4*$amountsetpremier),2);
  $amount['xl'] = round((5*$amountsetxl),2);
  $amount['pool'] = round((2*$amountsetpool),2); */



			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function vehicleTypes(Request $request)
	{
		$user = Auth::user();
		try {
			$resnewarray = Price::where(['service_provider_id' => $user->service_provider_id])->orderBy('sort')->get();
			return response()->json(['message' => __('Successfully.'), 'data' => $resnewarray], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function rideStatusChange(Request $request)
	{
		$logged_in_user = Auth::user();
		$rules = [
			'status' => 'required',
			'ride_id' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}
		//dd(Auth::user());
		$settings = Setting::where('service_provider_id',Auth::user()->service_provider_id)->first();
       
		$settingValue = json_decode($settings['value']);
		
		try {
			
			$rideDetail = Ride::find($request->ride_id);
			
			$ride = Ride::find($request->ride_id);

			if (!empty($request->note)) {
				$ride->note = $request->note;
			}
			if(!empty($ride->service_provider_id)){
				$ride->service_provider_id = $logged_in_user->service_provider_id;
			}

			if (!empty($ride)) {
				$cost = $rideDetail->ride_cost;
				if(!empty($request->user_id)){
					$userdata = User::find($request->user_id);
					$user_id = $request->user_id;
				} else {
					$userdata = User::find($ride['user_id']);
					$user_id = $ride['user_id'];
				}
				$deviceToken = $userdata['device_token']??"";
				$deviceType = $userdata['device_type']??"";
				if ($request->status == 1) {
					if ($ride->status == 1) {
						return response()->json(['message' => "Ride already Accepted"], $this->warningCode);
					}
					if (empty($request->car_id)) {
						return $this->validationErrorResponse('The car id is required !');
					}
					if ($ride->status == 3) {
						return response()->json(['success' => false, 'message' => "Ride  is completed", 'is_already_cancelled_deleted' => 1], $this->warningCode);
					}
					if ($ride->status == -1 || $ride->status == -2 || $ride->status == -3) {
						return response()->json(['success' => false, 'message' => "Ride is cancelled", 'is_already_cancelled_deleted' => 1], $this->warningCode);
					}
					$ride->status = $request->status;
					$ride->vehicle_id = $request->car_id;
					$ride->waiting = $request->waiting;
					$ride->driver_id = Auth::user()->id;
					$rideHistoryDetail = RideHistory::where(['ride_id' => $request->ride_id, 'driver_id' => Auth::user()->id])->first();
					if (!empty($rideHistoryDetail)) {
						$rideHistoryDetail->status = "1";
						$rideHistoryDetail->save();
					}
					$title = 'Ride Accepted';
					$responseMessage = 'Ride Accepted Successfully.';
					$notifiMessage = 'Your booking accepted by the driver please check the driver detail';
					$type = 2;

					if (!empty($ride->check_assigned_driver_ride_acceptation)) {
						$ride->check_assigned_driver_ride_acceptation = null;
					}

					// if(!empty($settingValue->want_send_sms_to_user_when_ride_accepted_by_driver) && $settingValue->want_send_sms_to_user_when_ride_accepted_by_driver == 1){
					// 	if (!empty($ride->user) && empty($ride->user->password) && !empty($ride->user->phone)) {
					// 		$SMSTemplate = SMSTemplate::find(6);
					// 		if ($ride->user->country_code == "41" || $ride->user->country_code == "43" || $ride->user->country_code == "49") {
					// 			$message_content = $SMSTemplate->german_content;
					// 		} else {
					// 			$message_content = $SMSTemplate->english_content;
					// 		}
					// 		$this->sendSMS("+" . $ride->user->country_code, ltrim($ride->user->phone, "0"), $message_content);
					// 	}
					// }
				}
				if ($request->status == 2) {
					if ($ride['status'] == 2) {
						return response()->json(['message' => "Ride already Started"], $this->successCode);
					}
					if ($ride->status == 3) {
						return response()->json(['success' => false, 'message' => "Ride is completed", 'is_already_cancelled_deleted' => 1], $this->warningCode);
					}
					if ($ride->status == -1 || $ride->status == -2 || $ride->status == -3) {
						return response()->json(['success' => false, 'message' => "Ride is cancelled", 'is_already_cancelled_deleted' => 1], $this->warningCode);
					}
					$title = 'Ride Started';
					$responseMessage = 'Ride Started Successfully';
					$notifiMessage = 'Ride Started Successfully';
					$type = 3;
					$ride->status = 2;

                    // if (!empty($ride->user) && empty($ride->user->password) && !empty($ride->user->phone)) {
                    // 	$message_content = "";
                    // 	$SMSTemplate = SMSTemplate::find(6);
                    // 	if ($ride->user->country_code == "41" || $ride->user->country_code == "43" || $ride->user->country_code == "49") {
                    // 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#SERVICE_PROVIDER#', "Taxi2000", $SMSTemplate->german_content));
                    // 	} else {
                    // 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#SERVICE_PROVIDER#', "Taxi2000", $SMSTemplate->english_content));
                    // 	}
                    // 	$this->sendSMS("+" . $ride->user->country_code, ltrim($ride->user->phone, "0"), $message_content);
                    // }
				}
				if ($request->status == 4) {
					if ($ride['status'] == 4) {
						return response()->json(['message' => "Driver already Reached"], $this->successCode);
					}
					if ($ride->status == 3) {
						return response()->json(['success' => false, 'message' => "Ride is completed", 'is_already_cancelled_deleted' => 1], $this->warningCode);
					}
					if ($ride->status == -1 || $ride->status == -2 || $ride->status == -3) {
						return response()->json(['success' => false, 'message' => "Ride is cancelled", 'is_already_cancelled_deleted' => 1], $this->warningCode);
					}
					$title = 'Driver Reached';
					$responseMessage = 'Driver Reached Successfully';
					$notifiMessage = 'Driver Reached Successfully';
					$type = 7;
					$ride->status = 4;
					// if(!empty($settingValue->want_send_sms_to_user_when_driver_reached_to_pickup_point) && $settingValue->want_send_sms_to_user_when_driver_reached_to_pickup_point == 1){
					// 	if (!empty($ride->user) && empty($ride->user->password) && !empty($ride->user->phone)) {
					// 		$SMSTemplate = SMSTemplate::find(7);
					// 		if ($ride->user->country_code == "41" || $ride->user->country_code == "43" || $ride->user->country_code == "49") {
					// 			$message_content = $SMSTemplate->german_content;
					// 		} else {
					// 			$message_content = $SMSTemplate->english_content;
					// 		}
					// 		$this->sendSMS("+" . $ride->user->country_code, ltrim($ride->user->phone, "0"), $message_content);
					// 	}
					// }
				}
				if ($request->status == 3) {
					if ($ride['status'] == 3) {
						return response()->json(['success' => true, 'message' => "Ride already Completed"], $this->successCode);
					}
					if ($ride->status == -1 || $ride->status == -2 || $ride->status == -3) {
						return response()->json(['success' => false, 'message' => "Ride is cancelled", 'is_already_cancelled_deleted' => 1], $this->warningCode);
					}
					$title = "Ride Completed";
					$responseMessage = 'Ride Completed Successfully';
					$notifiMessage = 'Ride Completed Successfully';
					$type = 4;
					$ride->status = 3;
					$ride->route = $request->route??"";

					if (!empty($request->ride_cost)) {
						$ride->ride_cost = $request->ride_cost;
					}
					if (!empty($request->payment_type)) {
						$ride->payment_type = $request->payment_type;
					}
					if (!empty($request->dest_address)) {
						$ride->dest_address = $request->dest_address;
					}
					if (!empty($request->dest_lat)) {
						$ride->dest_lat = $request->dest_lat;
					}
					if (!empty($request->dest_lng)) {
						$ride->dest_lng = $request->dest_lng;
					}
					if (!empty($request->company_id)) {
						$ride->company_id = $request->company_id;
					}
					if (!empty($request->user_id)) {
						$ride->user_id = $request->user_id;
					}

					if (!empty($request->distance)) {
						$ride->distance = $request->distance;
						$voucher = Voucher::where(['service_provider_id' => $logged_in_user->service_provider_id])->first();
						$voucherValue = json_decode($voucher['value']);
						$mile_per_ride = $voucherValue->mile_per_ride;
						$distance = $request->distance;
						$miles_got = round(($distance * $mile_per_ride) / 100);
						$ride->miles_received = $miles_got;

						if (!empty($user_id)) {
							if (strtolower($request->payment_type) != 'voucher') {
								$uservoucher = new UserVoucher();
								$uservoucher->miles = $miles_got;
								$uservoucher->user_id = $user_id;
								$uservoucher->ride_id = $request->ride_id;
								$uservoucher->type = 1;
								$uservoucher->save();
							}
						}
					}
				}
				if ($request->status == -2) {
					if ($ride['status'] == -2) {
						return response()->json(['success' => true, 'message' => "Ride Cancelled already"], $this->successCode);
					}
					$title = 'Ride Cancelled';
					$responseMessage = 'Ride Cancelled Successfully';
					$notifiMessage = 'The ride is cancelled by the driver.';

					$type = 5;
					$ride->status = -2;
					// if(!empty($settingValue->want_send_sms_to_user_when_driver_cancelled_the_ride) && $settingValue->want_send_sms_to_user_when_driver_cancelled_the_ride == 1){
					// 	if (!empty($ride->user) && empty($ride->user->password) && !empty($ride->user->phone)) {
					// 		$SMSTemplate = SMSTemplate::find(8);
					// 		if ($ride->user->country_code == "41" || $ride->user->country_code == "43" || $ride->user->country_code == "49") {
					// 			$message_content = $SMSTemplate->german_content;
					// 		} else {
					// 			$message_content = $SMSTemplate->english_content;
					// 		}
					// 		$this->sendSMS("+" . $ride->user->country_code, ltrim($ride->user->phone, "0"), $message_content);
					// 	}
					// }
				}
			} else {
				return response()->json(['success' => false, 'message' => "No such ride exist", 'is_already_cancelled_deleted' => 1], $this->warningCode);
			}

			$ride->save();
			$deduction = null;
			$expense_ride_cost = null;
			if($rideDetail->payment_type == 'Cash'){
				$deduction = $cost;
				$type = 'deduction';
				$type_detail = 'cash';
			}else{
				$expense_ride_cost =  $cost;
				$type = 'revenue';
				$type_detail = $rideDetail->payment_type;
			}
			
			$expense = new Expense();
			$expense->driver_id = $rideDetail->driver_id;
			$expense->type = $type;
			$expense->type_detail = $type_detail;
			$expense->ride_id = $rideDetail->id;
			$expense->revenue =  $expense_ride_cost;
			$expense->deductions =  $deduction;
			$expense->date = Carbon::now()->format('Y-m-d');
			$expense->service_provider_id = $rideDetail->service_provider_id;
			$expense->save();
			

			$ride_detail = new RideResource(Ride::find($request->ride_id));
			$settings = Setting::where(['service_provider_id' => $logged_in_user->service_provider_id])->first();
			$settingValue = json_decode($settings['value']);
			$ride['waiting_time'] = $settingValue->waiting_time;
			if ($request->status != -1) {
				if (!empty($userdata)) {
					$additional = ['type' => $type, 'ride_id' => $ride->id, 'ride_data' => $ride_detail];
					if (!empty($deviceToken)) {
						if ($deviceType == 'android') {
							bulk_firebase_android_notification($title, $notifiMessage, [$deviceToken], $additional);
						}
						if ($deviceType == 'ios') {
							bulk_pushok_ios_notification($title, $notifiMessage, [$deviceToken], $additional, $sound = 'default', $userdata['user_type']);
						}
					}

					$notification = new Notification();
					$notification->title = $title;
					$notification->description = $notifiMessage;
					$notification->type = $type;
					$notification->user_id = $userdata['id'];
					$notification->additional_data = json_encode($additional);
					$notification->service_provider_id = $rideDetail->service_provider_id;
					$notification->save();
				}
			}
			if ($request->payment_type == 'voucher' || $request->payment_type == 'Voucher') {
				if (!empty($request->miles_used)) {
					if (!empty($ride['user_id'])) {
						$uservoucher = new UserVoucher();
						$uservoucher->miles = $request->miles_used;
						$uservoucher->user_id = $ride['user_id'];
						$uservoucher->ride_id = $request->ride_id;
						$uservoucher->type = 3;
						$uservoucher->service_provider_id = $rideDetail->service_provider_id;
						$uservoucher->save();
					}
				}
			}

			// if ($request->status == 3 && empty($rideDetail->user_id) && !empty($request->user_id) && !empty($ride->user) && empty($ride->user->password) && !empty($ride->user->phone)) {
			// 	$message_content = "";
			// 	$SMSTemplate = SMSTemplate::find(6);
			// 	if ($ride->user->country_code == "41" || $ride->user->country_code == "43" || $ride->user->country_code == "49") {
			// 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#SERVICE_PROVIDER#', "Taxi2000", $SMSTemplate->german_content));
			// 	} else {
			// 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#SERVICE_PROVIDER#', "Taxi2000", $SMSTemplate->english_content));
			// 	}
			// 	$this->sendSMS("+" . $ride->user->country_code, ltrim($ride->user->phone, "0"), $message_content);
			// }

			return response()->json(['success' => true, 'message' => $responseMessage, 'data' => $ride_detail], $this->successCode);
		} catch (\Illuminate\Database\QueryException $e) {
			Log::error('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $e->getLine(). ' --- ' . $e->getMessage());
			return response()->json(['success' => false, 'message' => $e->getMessage()."--".$e->getLine()], $this->warningCode);
		} catch (\Exception $e) {
			Log::error('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $e->getLine(). ' --- ' . $e->getMessage());
			return response()->json(['success' => false, 'message' => $e->getMessage()."--".$e->getLine()], $this->warningCode);
		}
	}

	public function rideDetail(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];

		$rules = [
			'ride_id' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}
		try {
			$ride_detail = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at', 'route', 'service_provider_id')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])->find($request->ride_id);
			if (!empty($ride_detail) && $ride_detail->service_provider_id == $user->service_provider_id) {
				$settings = \App\Setting::first();
				$settingValue = json_decode($settings['value']);
				$ride_detail['waiting_time'] = $settingValue->waiting_time;
				return response()->json(['message' => 'Ride Detail Got Successfully', 'data' => $ride_detail], $this->successCode);
			} else {
				return response()->json(['message' => 'Ride Not found'], $this->warningCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function driverDetail(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];

		$rules = [
			'ride_id' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}
		try {

			$ride = Ride::query()->where([['id', '=', $_REQUEST['ride_id']], ['user_id', '=', $user_id]])->first();





			if (!empty($ride)) {
				$driverData = User::query()->where([['id', '=', $ride['driver_id']]])->first();

				if (!empty($driverData)) {
					if ($ride['status'] == 1) {
						$lat1 = $ride['pick_lat'];
						$long1 = $ride['pick_lng'];
						$lat2 = $driverData['current_lat'];
						$long2 = $driverData['current_lng'];
						$distance = $this->getdistancebyDirection($lat1, $long1, $lat2, $long2);
						if (!empty($distance)) {
							//$ride->distance = round($distance['distance'],2);
							$ride['duration'] = $distance['duration'];
						}
					}
					$ride['driver_data'] = $driverData;
					$avgrating = DB::table('ratings')->where('to_id', $ride['user_id'])->avg('rating');
					$avgrating = round($avgrating, 2);
					$ride['driver_data']['rating'] = "$avgrating";
					$vehicle_detail = Vehicle::query()->where([['user_id', '=', $ride['driver_id']]])->first();
					$ride['driver_data']['vehicle_info'] = $vehicle_detail;
				} else {
					$ride['driver_data'] = array();
				}

				$rating_data = Rating::query()->where([['ride_id', '=', $ride['id']], ['from_id', '=', $ride['user_id']]])->get()->toArray();
				if (!empty($rating_data)) {
					$ride['rating_data'] = $rating_data;
				} else {
					$ride['rating_data'] = array();
				}
			} else {
				return response()->json(['message' => 'Ride Not found'], $this->warningCode);
			}



			return response()->json(['message' => 'Ride Detail Got Successfully', 'data' => $ride], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function customerDetail(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];

		$rules = [
			'ride_id' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}
		try {

			$ride = Ride::query()->where([['id', '=', $_REQUEST['ride_id']], ['driver_id', '=', $user_id]])->first();





			if (!empty($ride)) {
				if ($ride['car_type'] == 4) {
					$pool_number = $ride['pool_number'];
					$pool_rides = Ride::query()->where([['pool_number', '=', $pool_number], ['driver_id', '=', $user_id]])->get()->toArray();
					$userdatanew = array();
					$i = 0;
					foreach ($pool_rides as $pool_ride) {
						$userdatanew[$i] =  User::query()->where([['id', '=', $pool_ride['user_id']]])->first();
						$userdatanew[$i]['pick_lat'] = $pool_ride['pick_lat'];
						$userdatanew[$i]['pick_lng'] = $pool_ride['pick_lng'];
						$userdatanew[$i]['dest_lat'] = $pool_ride['dest_lat'];
						$userdatanew[$i]['dest_lng'] = $pool_ride['dest_lng'];
						$userdatanew[$i]['pickup_address'] = $pool_ride['pickup_address'];
						$userdatanew[$i]['dest_address'] = $pool_ride['dest_address'];
						$userdatanew[$i]['rating'] = "";
						$userdatanew[$i]['review_count'] = "";
						$i++;
					}
					/* $userData = User::query()->where([['id', '=', $ride['user_id']]])->first();
			$ride['user_data'] = $userData; */
					/* $ride['user_data']['rating'] = "";
			$ride['user_data']['review_count'] = ""; */
					$ride['user_data'] = $userdatanew;
				} else {

					$userDatas = User::query()->where([['id', '=', $ride['user_id']]])->get()->toArray();
					$userdatanew = array();
					$i = 0;
					foreach ($userDatas as $userD) {
						$userdatanew[$i] =  $userD;
						$userdatanew[$i]['pick_lat'] = "";
						$userdatanew[$i]['pick_lng'] = "";
						$userdatanew[$i]['dest_lat'] = "";
						$userdatanew[$i]['dest_lng'] = "";
						$userdatanew[$i]['pickup_address'] = "";
						$userdatanew[$i]['dest_address'] = "";
						$userdatanew[$i]['rating'] = "";
						$userdatanew[$i]['review_count'] = "";
						$i++;
					}
					$ride['user_data'] = $userdatanew;
				}
			} else {
				return response()->json(['message' => 'Ride Not found'], $this->warningCode);
			}



			return response()->json(['message' => 'Ride Detail Got Successfully', 'data' => $ride], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function addVehicle(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'year' => 'required',
			'model' => 'required',
			'color' => 'required',
			'insurance_company' => 'required',
			'certificate_number' => 'required',
			'policy_number' => 'required',
			'issue_date' => 'required',
			'expiry_date' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$vehicle = new Vehicle();

			$vehicle->year = $request->year;
			$vehicle->model = $request->model;
			$vehicle->color = $request->color;
			$vehicle->insurance_company = $request->insurance_company;
			$vehicle->policy_number = $request->policy_number;
			$vehicle->certificate_number = $request->certificate_number;
			$vehicle->issue_date = $request->issue_date;
			$vehicle->expiry_date = $request->expiry_date;

			if (!empty($_FILES['driving_license'])) {

				if (isset($_FILES['driving_license']) && $_FILES['driving_license']['name'] !== '' && !empty($_FILES['driving_license']['name'])) {
					$file = $_FILES['driving_license'];
					$file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
					$filename = time() . '-' . $file;
					$ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$path = "public/images/user_image/";
						if (move_uploaded_file($_FILES['driving_license']['tmp_name'], $path . $filename)) {
							$url = URL::to('/');
							$vehicle->driving_license = $url . "/" . $path . $filename;
						}
					} else {


						return response()->json(['message' => 'Upload valid image'], $this->warningCode);
					}
				}
			}
			if (!empty($_FILES['vehicle_rc'])) {

				if (isset($_FILES['vehicle_rc']) && $_FILES['vehicle_rc']['name'] !== '' && !empty($_FILES['vehicle_rc']['name'])) {
					$file = $_FILES['vehicle_rc'];
					$file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
					$filename = time() . '-' . $file;
					$ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$path = "public/images/user_image/";
						if (move_uploaded_file($_FILES['vehicle_rc']['tmp_name'], $path . $filename)) {
							$url = URL::to('/');
							$vehicle->vehicle_rc = $url . "/" . $path . $filename;
						}
					} else {


						return response()->json(['message' => 'Upload valid image'], $this->warningCode);
					}
				}
			}
			if (!empty($_FILES['vehicle_image'])) {

				if (isset($_FILES['vehicle_image']) && $_FILES['vehicle_image']['name'] !== '' && !empty($_FILES['vehicle_image']['name'])) {
					$file = $_FILES['vehicle_image'];
					$file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
					$filename = time() . '-' . $file;
					$ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$path = "public/images/user_image/";
						if (move_uploaded_file($_FILES['vehicle_image']['tmp_name'], $path . $filename)) {
							$url = URL::to('/');
							$vehicle->vehicle_image = $url . "/" . $path . $filename;
						}
					} else {


						return response()->json(['message' => 'Upload valid image'], $this->warningCode);
					}
				}
			}
			if (!empty($_FILES['vehicle_number_plate'])) {

				if (isset($_FILES['vehicle_number_plate']) && $_FILES['vehicle_number_plate']['name'] !== '' && !empty($_FILES['vehicle_number_plate']['name'])) {
					$file = $_FILES['vehicle_number_plate'];
					$file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
					$filename = time() . '-' . $file;
					$ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$path = "public/images/user_image/";
						if (move_uploaded_file($_FILES['vehicle_number_plate']['tmp_name'], $path . $filename)) {
							$url = URL::to('/');
							$vehicle->vehicle_number_plate = $url . "/" . $path . $filename;
						}
					} else {


						return response()->json(['message' => 'Upload valid image'], $this->warningCode);
					}
				}
			}


			$vehicle->user_id = $user_id;
			unset($vehicle->created_at);
			unset($vehicle->updated_at);
			//print_r($place); die;
			$vehicle->save();
			$user->step = 2;

			$user->save();

			return response()->json(['message' => 'Vehicle Info Added successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function notificationRead(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		try {
			Notification::where('user_id', $user_id)->update(['status' => 1]);
			return response()->json(['message' => 'Notification Updated successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function updateVehicle(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'vehicle_id' => 'required',


		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			$vehicle = Vehicle::query()->where([['user_id', '=', $user_id], ['id', '=', $_REQUEST['vehicle_id']]])->first();
			if (!empty($request->year)) {
				$vehicle->year = $request->year;
			}
			if (!empty($request->model)) {
				$vehicle->model = $request->model;
			}
			if (!empty($request->color)) {
				$vehicle->color = $request->color;
			}
			if (!empty($request->year)) {
				$vehicle->year = $request->year;
			}
			if (!empty($request->insurance_company)) {
				$vehicle->insurance_company = $request->insurance_company;
			}
			if (!empty($request->certificate_number)) {
				$vehicle->certificate_number = $request->certificate_number;
			}
			if (!empty($request->policy_number)) {
				$vehicle->policy_number = $request->policy_number;
			}
			if (!empty($request->year)) {
				$vehicle->year = $request->year;
			}
			if (!empty($request->issue_date)) {
				$vehicle->issue_date = $request->issue_date;
			}
			if (!empty($request->expiry_date)) {
				$vehicle->expiry_date = $request->expiry_date;
			}



			if (!empty($_FILES['driving_license'])) {

				if (isset($_FILES['driving_license']) && $_FILES['driving_license']['name'] !== '' && !empty($_FILES['driving_license']['name'])) {
					$file = $_FILES['driving_license'];
					$file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
					$filename = time() . '-' . $file;
					$ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$path = "public/images/user_image/";
						if (move_uploaded_file($_FILES['driving_license']['tmp_name'], $path . $filename)) {
							$url = URL::to('/');
							$vehicle->driving_license = $url . "/" . $path . $filename;
						}
					} else {


						return response()->json(['message' => 'Upload valid image'], $this->warningCode);
					}
				}
			}
			if (!empty($_FILES['vehicle_rc'])) {

				if (isset($_FILES['vehicle_rc']) && $_FILES['vehicle_rc']['name'] !== '' && !empty($_FILES['vehicle_rc']['name'])) {
					$file = $_FILES['vehicle_rc'];
					$file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
					$filename = time() . '-' . $file;
					$ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$path = "public/images/user_image/";
						if (move_uploaded_file($_FILES['vehicle_rc']['tmp_name'], $path . $filename)) {
							$url = URL::to('/');
							$vehicle->vehicle_rc = $url . "/" . $path . $filename;
						}
					} else {


						return response()->json(['message' => 'Upload valid image'], $this->warningCode);
					}
				}
			}
			if (!empty($_FILES['vehicle_image'])) {

				if (isset($_FILES['vehicle_image']) && $_FILES['vehicle_image']['name'] !== '' && !empty($_FILES['vehicle_image']['name'])) {
					$file = $_FILES['vehicle_image'];
					$file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
					$filename = time() . '-' . $file;
					$ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$path = "public/images/user_image/";
						if (move_uploaded_file($_FILES['vehicle_image']['tmp_name'], $path . $filename)) {
							$url = URL::to('/');
							$vehicle->vehicle_image = $url . "/" . $path . $filename;
						}
					} else {


						return response()->json(['message' => 'Upload valid image'], $this->warningCode);
					}
				}
			}
			if (!empty($_FILES['vehicle_number_plate'])) {

				if (isset($_FILES['vehicle_number_plate']) && $_FILES['vehicle_number_plate']['name'] !== '' && !empty($_FILES['vehicle_number_plate']['name'])) {
					$file = $_FILES['vehicle_number_plate'];
					$file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
					$filename = time() . '-' . $file;
					$ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$path = "public/images/user_image/";
						if (move_uploaded_file($_FILES['vehicle_number_plate']['tmp_name'], $path . $filename)) {
							$url = URL::to('/');
							$vehicle->vehicle_number_plate = $url . "/" . $path . $filename;
						}
					} else {


						return response()->json(['message' => 'Upload valid image'], $this->warningCode);
					}
				}
			}



			unset($vehicle->created_at);
			unset($vehicle->updated_at);
			//print_r($place); die;
			$vehicle->save();


			return response()->json(['message' => 'Vehicle Updated successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function updateBankdetail(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		/* $rules = [
			'vehicle_id' => 'required',


        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message'=>trans('api.required_data'),'error'=>$validator->errors()], $this->warningCode);
        } */

		try {
			$bankdetail = BankDetail::query()->where([['user_id', '=', $user_id]])->first();
			if (!empty($bankdetail)) {
			} else {
				$bankdetail = new BankDetail();
			}
			if (!empty($request->bank_name)) {
				$bankdetail->bank_name = $request->bank_name;
			}
			if (!empty($request->account_number)) {
				$bankdetail->account_number = $request->account_number;
			}
			if (!empty($request->account_name)) {
				$bankdetail->account_name = $request->account_name;
			}
			if (!empty($request->ifsc_code)) {
				$bankdetail->ifsc_code = $request->ifsc_code;
			}
			if (!empty($request->phone_number)) {
				$bankdetail->phone_number = $request->phone_number;
			}

			$bankdetail->user_id = $user_id;

			unset($bankdetail->created_at);
			unset($bankdetail->updated_at);
			//print_r($place); die;
			$bankdetail->save();


			return response()->json(['message' => 'Bank Detail Updated successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function driverClassList()
	{


		$resnewarray = Driverclass::query()->get()->toArray();




		$newresultarray = array();
		if (!empty($resnewarray)) {

			$i = 0;

			foreach ($resnewarray as $result) {

				$newresultarray[$i] = $result;

				$i++;
			}

			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} else {
			return response()->json(['message' => 'No data found', 'data' => $newresultarray], $this->successCode);
		}
	}
	public function place_list()
	{

		$user = Auth::user();
		$user_id = $user['id'];
		$resnewarray = Place::query()->where([['user_id', '=', $user_id]])->get()->toArray();




		$newresultarray = array();
		if (!empty($resnewarray)) {

			$i = 0;

			foreach ($resnewarray as $result) {

				$newresultarray[$i] = $result;

				$i++;
			}

			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} else {
			return response()->json(['message' => 'No data found', 'data' => $newresultarray], $this->successCode);
		}
	}
	public function notification_list()
	{

		$user = Auth::user();
		$user_id = $user['id'];
		$resnewarray = Notification::query()->where([['user_id', '=', $user_id]])->get()->toArray();




		$newresultarray = array();
		if (!empty($resnewarray)) {

			$i = 0;

			foreach ($resnewarray as $result) {

				$newresultarray[$i] = $result;

				$i++;
			}

			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} else {
			return response()->json(['message' => 'No data found', 'data' => $newresultarray], $this->successCode);
		}
	}
	public function rideTypes(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];



		try {

			$resnewarray = Price::query()->get()->toArray();




			$newresultarray = array();
			if (!empty($resnewarray)) {

				$i = 0;

				foreach ($resnewarray as $result) {
					$newresultarray[$i] = $result;


					$i++;
				}
			}




			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function price_list(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'pick_lat' => 'required',
			'pick_lng' => 'required',
			'dest_lat' => 'required',
			'dest_lng' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			$lon1 = $_REQUEST['pick_lng'];
			$lon2 = $_REQUEST['dest_lng'];
			$lat1 = $_REQUEST['pick_lat'];
			$lat2 = $_REQUEST['dest_lat'];
			/* 	$theta = $lon1 - $lon2;
			$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $kilometers = $miles * 1.609344; */
			//$settings = $this->Setting->findById(1);
			$distance = $this->getdistancebyDirection($lat1, $lon1, $lat2, $lon2);
			if ($distance == 0) {
				return response()->json(['message' => 'No Driver Found'], $this->warningCode);
			}
			$resnewarray = Price::query()->get()->toArray();




			$newresultarray = array();
			if (!empty($resnewarray)) {

				$i = 0;

				foreach ($resnewarray as $result) {
					$newresultarray[$i] = $result;
					$discount = 0;
					if ($result['car_type'] == 1) {

						//echo $distance; die;
						$price = round(($result['price_per_km']) * ($distance['distance']));

						if ($distance['distance'] > 5 && $distance['distance'] < 10) {
							$discount = round(($price * 14) / 100);
						}
						if ($distance['distance'] > 10 && $distance['distance'] < 20) {
							$discount = round(($price * 34) / 100);
						}
						if ($distance['distance'] > 20 && $distance['distance'] < 25) {
							$discount = round(($price * 38) / 100);
						}
						if ($distance['distance'] > 25 && $distance['distance'] < 30) {
							$discount = round(($price * 40) / 100);
						}
						if ($distance['distance'] > 30 && $distance['distance'] < 35) {
							$discount = round(($price * 30) / 100);
						}
						if ($distance['distance'] > 35) {
							$discount = round(($price * 40) / 100);
						}
						$newresultarray[$i]['price'] = round($price - $discount);
					}

					if ($result['car_type'] == 4) {
						$price = round(($result['price_per_km']) * ($distance['distance']));
						if ($distance['distance'] > 5 && $distance['distance'] < 10) {
							$discount = round(($price * 14) / 100);
						}
						if ($distance['distance'] > 10 && $distance['distance'] < 20) {
							$discount = round(($price * 34) / 100);
						}
						if ($distance['distance'] > 20 && $distance['distance'] < 25) {
							$discount = round(($price * 38) / 100);
						}
						if ($distance['distance'] > 25 && $distance['distance'] < 30) {
							$discount = round(($price * 40) / 100);
						}
						if ($distance['distance'] > 30 && $distance['distance'] < 35) {
							$discount = round(($price * 30) / 100);
						}
						if ($distance['distance'] > 35) {
							$discount = round(($price * 40) / 100);
						}
						$pooldiscount = (round($discount * 30) / 100);
						$newresultarray[$i]['price'] = round($price - $discount - $pooldiscount);
					}
					//$currenttime = date('h:i A');
					//echo date_default_timezone_get(); die;
					$duration = $distance['duration'];
					$newresultarray[$i]['time'] = date("h:i:s a", time() + $duration);
					$newresultarray[$i]['distance'] = $distance['distance'];

					$i++;
				}
			}
			/*  $amount = array();
  $amount['go'] = round((3*$amountsetgo),2);
  $amount['premier'] = round((4*$amountsetpremier),2);
  $amount['xl'] = round((5*$amountsetxl),2);
  $amount['pool'] = round((2*$amountsetpool),2); */



			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function addCard(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'name' => 'required',
			'card_number' => 'required',
			'expiry' => 'required',
			//'cvv' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$card = new Card();

			$card->name = $request->name;
			$card->card_number = $request->card_number;
			$card->expiry = $request->expiry;

			if (!empty($request->brand_name)) {
				$card->brand_name = $request->brand_name;
			}



			$card->user_id = $user_id;
			unset($card->created_at);
			unset($card->updated_at);
			//print_r($place); die;
			if (!empty($request->save)) {
				$card->save();
			} else {
			}

			return response()->json(['message' => 'Card Added successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function invoice(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'ride_id' => 'required',


		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$where = array('id' => $user_id);

			$userdata = User::where($where)->first();
			$email = $userdata['email'];
			$ride_data = Ride::query()->where([['user_id', '=', $user_id], ['id', '=', $request->ride_id]])->first();
			$ride_data['email'] = $email;
			$driver_id = array('id' => $ride_data['driver_id']);

			$driver_data = User::where($driver_id)->first();
			$otp = rand(1000, 9999);
			$data = array('pickup_location' => $ride_data['pickup_address'], 'dest_address' => $ride_data['dest_address'], 'price' => $ride_data['price'], 'payment_type' => $ride_data['payment_type'], 'ride_date' => $ride_data['created_at'], 'driver_name' => $driver_data['first_name']);
			$ride_id = $request->ride_id;
			$m = Mail::send('invoice', $data, function ($message) use ($ride_data) {
				$email = $ride_data['email'];
				$ride_id = $ride_data['id'];
				$message->to($email, 'Invoice')->subject("Invoice #$ride_id");

				if (!empty($request->from)) {
					$message->from($request->from, 'Haylup');
				}
			});
			return response()->json(['message' => 'Invoice sent successfully to mail'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function raisecomplain(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'ride_type' => 'required',
			'complain_type' => 'required',
			'message' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$complaint = new Complaint();

			$complaint->ride_type = $request->ride_type;
			$complaint->complain_type = $request->complain_type;
			$complaint->message = $request->message;



			$complaint->user_id = $user_id;
			unset($complaint->created_at);
			unset($complaint->updated_at);
			//print_r($place); die;
			if (!empty($request->save)) {
				$complaint->save();
			} else {
			}

			return response()->json(['message' => 'Your message sent successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function contactAdmin(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'email' => 'required',
			'message' => 'required'

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$contact = new Contact();

			$contact->email = $request->email;
			$contact->message = $request->message;



			$contact->user_id = $user_id;
			unset($contact->created_at);
			unset($contact->updated_at);
			//print_r($place); die;
			if (!empty($request->save)) {
				$contact->save();
			} else {
			}

			return response()->json(['message' => 'Your message sent successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function complainedTypes()
	{

		$user = Auth::user();
		$user_id = $user['id'];
		$resnewarray = ComplainType::query()->get()->toArray();




		$newresultarray = array();
		if (!empty($resnewarray)) {

			$i = 0;

			foreach ($resnewarray as $result) {

				$newresultarray[$i] = $result;

				$i++;
			}

			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} else {
			return response()->json(['message' => 'No data found', 'data' => $newresultarray], $this->successCode);
		}
	}
	public function card_list()
	{

		$user = Auth::user();
		$user_id = $user['id'];
		$resnewarray = Card::query()->where([['user_id', '=', $user_id]])->get()->toArray();
		$newresultarray = array();
		if (!empty($resnewarray)) {

			$i = 0;

			foreach ($resnewarray as $result) {

				$newresultarray[$i] = $result;

				$i++;
			}

			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray], $this->successCode);
		} else {
			return response()->json(['message' => 'No data found', 'data' => $newresultarray], $this->successCode);
		}
	}
	public function pages(Request $request)
	{
		/* $user = Auth::user();
			$user_id = $user['id']; */
		$rules = [
			'type' => 'required',


		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			$pageddata = Page::query()->where([['type', '=', $request->type]])->first();

			return response()->json(['message' => __('Successfully.'), 'data' => $pageddata], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function addCart(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'item_id' => 'required',
			'driver_id' => 'required',



		];


		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			$drivercheck = Cart::query()->where([['user_id', '=', $user_id]])->first();
			if (!empty($drivercheck)) {
				$driver_id = $drivercheck['driver_id'];
				$getdriverid = $request->driver_id;
				if ($driver_id != $getdriverid) {
					return response()->json(['message' => 'You are adding item from different driver'], 402);
				}
			}
			$cart = Cart::query()->where([['user_id', '=', $user_id], ['item_id', '=', $request->item_id]])->first();
			$itemcheck = Item::query()->where([['id', '=', $request->item_id]])->first();
			if (!empty($itemcheck)) {
				$itemqty = $itemcheck['qty'];
				$getqty = $request->qty;
				if (isset($_REQUEST['cart_list']) && $_REQUEST['cart_list'] == 1) {
					if ($getqty > $itemqty) {
						return response()->json(['message' => "Only $itemqty items available"], $this->warningCode);
					}
				} else {
					$matchqty = $request->qty + $cart['qty'];
					if ($matchqty > $itemqty) {
						return response()->json(['message' => "Only $itemqty items available"], $this->warningCode);
					}
				}
			}

			if (!empty($cart)) {
				$msg = "Item Updated Successfully";
				$cart->qty = $request->qty + $cart['qty'];
				if (isset($_REQUEST['cart_list']) && $_REQUEST['cart_list'] == 1) {
					$cart->qty = $request->qty;
				}
			} else {
				$cart = new Cart();
				$cart->item_id = $request->item_id;
				$cart->driver_id = $request->driver_id;
				$cart->user_id = $user_id;
				$cart->qty = $request->qty;
				$msg = "Item Added to cart Successfully";
			}

			if ($request->qty == 0) {
				$cart->delete();
				$msg = "Item Removed Successfully";
			} else {
				$cart->save();
			}



			//return response()->json(['message'=>$msg], $this->successCode);
			$cart_count = Cart::where('user_id', '=', $user_id)->count();

			return response()->json(['message' => $msg, 'cart_count' => $cart_count], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function cart_list()
	{

		$user = Auth::user();
		$user_id = $user['id'];
		$resnewarray = Cart::query()->where([['user_id', '=', $user_id]])->get()->toArray();





		if (!empty($resnewarray)) {
			//$newresultarray[$i]['user_data'] = $this->get_user($result['user_id']);
			//  $this->api_response(200,'Homedata listed successfully',$resnewarray);
			/*  $resnewarray = array();
		  foreac */

			$i = 0;
			$newresultarray = array();
			foreach ($resnewarray as $result) {
				$item = Item::where(['id' => $result['item_id']])->first();

				$driver_data = User::where(['id' => $result['driver_id']])->first();
				$newresultarray[$i] = $item;
				$newresultarray[$i]['cart_qty'] = $result['qty'];
				$newresultarray[$i]['cart_user_id'] = $result['user_id'];
				$newresultarray[$i]['driver_data'] = $driver_data;
				if ($newresultarray[$i]['driver_data']['current_lat'] == null) {
					$newresultarray[$i]['driver_data']['current_lat'] = "";
				}
				if ($newresultarray[$i]['driver_data']['current_lng'] == null) {
					$newresultarray[$i]['driver_data']['current_lng'] = "";
				}
				//$newresultarray[$i] = $result;
				/* $item = Item::where(['id' => $result['item_id']])->first();

				$driver_data = User::where(['id' => $item['user_id']])->first();
				$newresultarray[$i] = $item;
				$newresultarray[$i]['driver_data'] = $driver_data; */
				/* $dealimgresults = DealImage::query()->where('deal_images.deal_id',$result['id'])->orderBy('deal_images.id','DESC')->get()->toArray();
				$newresultarray[$i]['deal_images'] = $dealimgresults;
				$views= Click::where('deal_id', '=', $result['id'])->count();
				$newresultarray[$i]['views'] = "$views";
				$purchases= Order::where('deal_id', '=', $result['id'])->count();
				$newresultarray[$i]['purchases'] = "$purchases";
				$avgrating = DB::table('reviews')->where('business_user_id', $result['user_id'])->avg('rating');
				$avgrating = round($avgrating,2);
				$newresultarray[$i]['business_avg_rating'] = "$avgrating"; */
				$i++;
			}
			$cart_count = Cart::where('user_id', '=', $user_id)->count();

			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray, 'cart_count' => $cart_count, 'tax' => 10], $this->successCode);
		} else {
			return response()->json(['message' => 'No data found'], $this->successCode);
		}
	}
	public function addBooking(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'items' => 'required',
			'driver_id' => 'required',
			'subtotal' => 'required',
			'total_price' => 'required',
			'payment_id' => 'required',
			'payment_type' => 'required',



		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$booking = new Booking();
			$booking->items = $request->items;
			$booking->driver_id = $request->driver_id;
			$booking->user_id = $user_id;
			$booking->subtotal = $request->subtotal;
			$booking->total_price = $request->total_price;
			$booking->payment_id = $request->payment_id;
			$booking->payment_type = $request->payment_type;
			if (!empty($request->promo_discount)) {
				$booking->promo_discount = $request->promo_discount;
			}
			if (!empty($request->foodfix_points)) {
				$booking->foodfix_points = $request->foodfix_points;
			}

			if (!empty($request->foodfix_points_price)) {
				$booking->foodfix_points_price = $request->foodfix_points_price;
			}
			if (!empty($request->tax)) {
				$booking->tax = $request->tax;
			}

			DB::table('carts')->where('user_id', $user_id)->delete();
			$msg = "Booking Created Successfully";

			if ($booking->save()) {

				if (!empty($request->foodfix_points)) {


					$userData = User::where('id', $user_id)->first();
					$earnpoint = $userData['earned_points'];
					$spendpoint = $userData['spent_points'];
					if (!empty($earnpoint)) {
						$earnpoint = $earnpoint - $request->foodfix_points;
					}

					$userData->earned_points = $earnpoint + $request->total_price;

					$userData->spent_points = $spendpoint + $request->foodfix_points;

					$userData->save();
				} else {

					$userData = User::where('id', $user_id)->first();
					$earnpoint = $userData['earned_points'];
					$userData->earned_points = $earnpoint + $request->total_price;
					$userData->save();
				}
			}
			$title = 'New Booking';
			$message = 'You Received new booking';
			$driverdetail = User::where('id', '=', $request->driver_id)->first();

			$deviceToken = $driverdetail['device_token'];
			$type = 0;
			$additional = ['type' => $type];


			$deviceType = $driverdetail['device_type'];
			if ($deviceType == 'android') {
				send_notification($title, $message, $deviceToken, '', $additional, true, false, $deviceType, []);
				$notification = new Notification();
				$notification->title = $title;
				$notification->description = $message;
				$notification->type = $type;
				$notification->user_id = $driverdetail['id'];
				$notification->save();
			}
			if ($deviceType == 'ios') {
				$deviceToken = $driverdetail['fcm_token'];
				send_iosnotification($title, $message, $deviceToken, '', $additional, true, false, $deviceType, []);
				$notification = new Notification();
				$notification->title = $title;
				$notification->description = $message;
				$notification->type = $type;
				$notification->user_id = $driverdetail['id'];
				$notification->save();
			}
			$userData = User::where('id', $user_id)->first();
			//return response()->json(['message'=>$msg], $this->successCode);
			//$cart_count= Cart::where('user_id', '=', $user_id)->count();

			return response()->json(['message' => $msg, 'earned_points' => $userData['earned_points'], 'spent_points' => $userData['spent_points']], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function checkPromo(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'promo' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			$date = date("Y-m-d");
			$promocode = Promocode::query()->where([['start_date', '<=', $date], ['end_date', '>=', $date], ['code', '=', $request->promo]])->first();
			if (!empty($promocode)) {
				$msg = "Promocode Found Successfully";
				return response()->json(['message' => $msg, 'data' => $promocode], $this->successCode);
			} else {

				$msg = "No Promocode Found";
				return response()->json(['message' => $msg], $this->successCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function instantRide(Request $request)
	{
		$rules = [
			'start_location' => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}
		$ride = new Ride();
		$ride->pickup_address = $request->start_location;
		if (!empty($request->drop_location)) {
			$ride->dest_address = $request->drop_location;
		}
		if (!empty($request->pick_lat)) {
			$ride->pick_lat = $request->pick_lat;
		}
		if (!empty($request->pick_lng)) {
			$ride->pick_lng = $request->pick_lng;
		}
		if (!empty($request->dest_lat)) {
			$ride->dest_lat = $request->dest_lat;
		}
		if (!empty($request->dest_lng)) {
			$ride->dest_lng = $request->dest_lng;
		}
		if (!empty($request->passanger)) {
			$ride->passanger = $request->passanger;
		}
		if (!empty($request->payment_type)) {
			$ride->payment_type = $request->payment_type;
		}
		if (!empty($request->schedule_time)) {
			$ride->schedule_time = $request->schedule_time;
		}
		if (!empty($request->alert_time)) {
			$ride->alert_time = $request->alert_time;
		}
		if (!empty($request->time)) {
			$ride->ride_time = date("Y-m-d H:i:s", strtotime($request->time));
		} else {
			$ride->ride_time = date('Y-m-d H:i:s');
		}
		if (!empty($request->note)) {
			$ride->note = $request->note;
		}
		if (!empty($request->car_type)) {
			$ride->car_type = $request->car_type;
		}
		if (!empty($request->ride_cost)) {
			$ride->ride_cost = $request->ride_cost;
		}
		if (!empty($request->distance)) {
			$ride->distance = $request->distance;
		}
		if(!empty($request->service_provider_id)){
			$ride->service_provider_id = $request->service_provider_id;
		}
		$ride->ride_type = 3;
		$ride->created_by = 1;
		$ride->creator_id = Auth::user()->id;
		if (!empty($request->ride_time)) {
			$ride->ride_time = date("Y-m-d H:i:s", strtotime($request->ride_time));
		} else {
			$ride->ride_time = date("Y-m-d H:i:s");
		}

		if (!empty($request->ride_cost)) {
			$ride->ride_cost = $request->ride_cost;
		}
		$ride->user_id = Auth::user()->id;
		if (!empty($request->distance)) {
			$ride->distance = $request->distance;
		}
		if (!empty($request->pick_lat) && !empty($request->pick_lng)) {
			$lat = $request->pick_lat;
			$lon = $request->pick_lng;
		}
		$settings = \App\Setting::first();
		$settingValue = json_decode($settings['value']);
		$driverlimit = $settingValue->driver_requests;
		$query = User::select(
			"users.*",
			DB::raw("3959 * acos(cos(radians(" . $lat . "))
                    * cos(radians(users.current_lat))
                    * cos(radians(users.current_lng) - radians(" . $lon . "))
                    + sin(radians(" . $lat . "))
                    * sin(radians(users.current_lat))) AS distance")
		);
		$query->where([['user_type', '=', 2], ['availability', '=', 1]])->orderBy('distance', 'asc')->limit($driverlimit);
		$drivers = $query->get()->toArray();

		$driverids = array();
		if (!empty($drivers)) {
			foreach ($drivers as $driver) {
				$driverids[] = $driver['id'];
			}
		} else {
			return response()->json(['message' => "No Driver Found"], $this->warningCode);
		}
		if (!empty($driverids)) {
			$driverids = implode(",", $driverids);
		} else {
			return response()->json(['message' => "No Driver Found"], $this->warningCode);
		}

		$ride->driver_id = null;
		$ride->all_drivers = $driverids;
		$ride->platform = Auth::user()->device_type;
		$ride->save();

		$ride_data = new RideResource(Ride::find($ride->id));
		$driverids = explode(",", $driverids);
		$title = 'New Booking';
		$message = 'You Received new booking';
		$ride_data['waiting_time'] = $settingValue->waiting_time;
		$additional = ['type' => 1, 'ride_id' => $ride->id, 'ride_data' => $ride_data];
		if (!empty($driverids)) {
			$ios_driver_tokens = User::whereIn('id', $driverids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'ios'])->pluck('device_token')->toArray();
			if (!empty($ios_driver_tokens)) {
				bulk_pushok_ios_notification($title, $message, $ios_driver_tokens, $additional, $sound = 'default', 2);
			}
			$android_driver_tokens = User::whereIn('id', $driverids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'android'])->pluck('device_token')->toArray();
			if (!empty($android_driver_tokens)) {
				bulk_firebase_android_notification($title, $message, $android_driver_tokens, $additional);
			}
			$notification_data = [];
			$ridehistory_data = [];
			foreach ($driverids as $driverid) {
				$notification_data[] = ['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $driverid, 'additional_data' => json_encode($additional), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
				$ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $driverid, 'status' => '2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
			}
			Notification::insert($notification_data);
			RideHistory::insert($ridehistory_data);
		}

		$overallDriversCount = User::select(
			"users.*",
			DB::raw("3959 * acos(cos(radians(" . $ride->pick_lat . "))
				* cos(radians(users.current_lat))
				* cos(radians(users.current_lng) - radians(" . $ride->pick_lng . "))
				+ sin(radians(" . $ride->pick_lat . "))
				* sin(radians(users.current_lat))) AS distance")
		)->where(['user_type' => 2, 'availability' => 1])->whereNotNull('device_token')->get()->toArray();
		$rideData = Ride::find($ride->id);
		$rideData->notification_sent = 1;
		if (count($overallDriversCount) <= count($drivers)) {
			$rideData->alert_send = 1;
		}
		$rideData->alert_notification_date_time = Carbon::now()->addseconds($settingValue->waiting_time)->format("Y-m-d H:i:s");
		$rideData->save();

		return response()->json(['success' => true, 'message' => 'Instant ride created successfully.', 'data' => $ride], $this->successCode);
	}

	public function createRideDriver(Request $request, rideHistory $rideHistory)
	{
		// $rules = [
		// 	'pickup_location' => 'required',
		// 	//'drop_location' => 'required',
		// ];


		// $validator = Validator::make($request->all(), [
		// 	'pickup_location' => 'required',
		// 	'pick_lat' => 'required',
		// 	'pick_lng' => 'required',
		// ], [ 
		// 	'pickup_location.required' => 'The pickup location field is required.',
		// 	'pick_lat.required' => 'Pickup location data missing. Please select pickup location again.',
		// 	'pick_lng.required' => 'Pickup location data missing. Please select pickup location again.',
		// ]);

		// $validator = Validator::make($request->all(), $rules);
		// if ($validator->fails()) {
		// 	return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		// }

		if(empty($request->pickup_location)) {
			return response()->json(['message' => "The pickup location field is required"], $this->warningCode);
		}
		if(empty($request->pick_lat)) {
			return response()->json(['message' => "Pickup location data missing. Please select pickup location again."], $this->warningCode);
		}
		if(empty($request->pick_lng)) {
			return response()->json(['message' => "Pickup location data missing. Please select pickup location again."], $this->warningCode);
		}
		
		$ride = new Ride();
		$lat = '';
	    $lon = ''; 
		$ride->pickup_address = $request->pickup_location;
		if (!empty($request->drop_location)) {
			$ride->dest_address = $request->drop_location;
		}
		if (!empty($request->pick_lat)) {
			$ride->pick_lat = $request->pick_lat;
		}
		if (!empty($request->pick_lng)) {
			$ride->pick_lng = $request->pick_lng;
		}
		if (!empty($request->dest_lat)) {
			$ride->dest_lat = $request->dest_lat;
		}
		if (!empty($request->dest_lng)) {
			$ride->dest_lng = $request->dest_lng;
		}
		if (!empty($request->passanger)) {
			$ride->passanger = $request->passanger;
		}
		if (!empty($request->payment_type)) {
			$ride->payment_type = $request->payment_type;
		}
		if (!empty($request->company_id)) {
			$ride->company_id = $request->company_id;
		}
		$ride->route = $request->route ?? null;
		$ride->ride_type = 3;
		$ride->created_by = 2;
		$ride->creator_id = Auth::user()->id;
        if(Auth::user()->service_provider_id)
        {
            $ride->service_provider_id = Auth::user()->service_provider_id;
        }
		if (!empty($request->ride_time)) {
			$ride->ride_time = date("Y-m-d H:i:s", strtotime($request->ride_time));
		} else {
			$ride->ride_time = date("Y-m-d H:i:s");
		}
		if (!empty($request->ride_cost)) {
			$ride->ride_cost = $request->ride_cost;
		}
		if (!empty($request->user_id)) {
			$ride->user_id = $request->user_id;
			$rideUser = User::find($request->user_id);
			if ($rideUser)
			{
				$ride->user_country_code = $rideUser->country_code;
				$ride->user_phone = $rideUser->phone;
			}
		}
		if (!empty($request->note)) {
			$ride->note = $request->note;
		}
		if (!empty($request->car_type)) {
			$ride->car_type = $request->car_type;
		}
		if (!empty($request->distance)) {
			$ride->distance = $request->distance;
		}
		if (!empty($request->pick_lat) && !empty($request->pick_lng)) {
			$lat = $request->pick_lat;
			$lon = $request->pick_lng;
		}
		$driverids = array();
		$settings = Setting::where('service_provider_id',Auth::user()->service_provider_id)->first();
		$settingValue = json_decode($settings['value']);

		if(!empty($request->driver_id)){
			$ride->driver_id = $request->driver_id;
			$driverids[] = $request->driver_id;
		} else {
			$driverlimit = $settingValue->driver_requests;
			$driver_radius = $settingValue->radius;
			$query = User::select(
				"users.*",
				DB::raw("3959 * acos(cos(radians(" . $lat . "))
						* cos(radians(users.current_lat))
						* cos(radians(users.current_lng) - radians(" . $lon . "))
						+ sin(radians(" . $lat . "))
						* sin(radians(users.current_lat))) AS distance")
			);
			$query = $query->with(['ride' => function ($query1) {
				$query1->where(['waiting' => 0]);
				$query1->where(function ($query2) {
					$query2->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
				});
			}])->with(['all_rides' => function ($query3) {
				$query3->where(['status' => 1, 'waiting' => 1]);
			}])->where([['user_type', '=', 2], ['availability', '=', 1]])->where('users.service_provider_id',Auth::user()->service_provider_id)->orderBy('distance', 'asc');
			$drivers = $query->get()->toArray();

			$rideObj = new Ride;
			foreach ($drivers as $driver_key => $driver_value) {
				if (!empty($driver_value['ride'])) {
					if (!empty($driver_value['ride']['dest_lat'])) {
						if ($driver_value['ride']['status'] == 1) {
							$drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($driver_value['current_lat'], $driver_value['current_lng'], $driver_value['ride']['pick_lat'], $driver_value['ride']['pick_lng']);
						}
						$drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($driver_value['ride']['pick_lat'], $driver_value['ride']['pick_lng'], $driver_value['ride']['dest_lat'], $driver_value['ride']['dest_lng']);
					} else {
						$drivers[$driver_key]['distance'] += $settingValue->current_ride_distance_addition??10;
					}
				}
				if (!empty($driver_value['all_rides'])) {
					foreach ($driver_value['all_rides'] as $waiting_ride_key => $waiting_ride_value) {
						if (!empty($driver_value['ride']['dest_lat'])) {
							$drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($driver_value['current_lat'], $driver_value['current_lng'], $waiting_ride_value['pick_lat'], $waiting_ride_value['pick_lng']);
							$drivers[$driver_key]['distance'] += $rideObj->haversineGreatCircleDistance($waiting_ride_value['pick_lat'], $waiting_ride_value['pick_lng'], $waiting_ride_value['dest_lat'], $waiting_ride_value['dest_lng']);
						} else {
							$drivers[$driver_key]['distance'] += $settingValue->waiting_ride_distance_addition??15;
						}
					}
				}
			}

			usort($drivers, 'sortByDistance');

			if (!empty($drivers)) {
				for ($i=0 ; $i < $driverlimit; $i++) {
					if(!empty($drivers[$i])){
						$driverids[] = $drivers[$i]['id'];
					}
				}
			} else {
				return response()->json(['message' => "No Driver Found"], $this->warningCode);
			}

			$ride->driver_id = null;
			$ride->all_drivers = implode(",", $driverids);
		}

		$ride->platform = Auth::user()->device_type;
		$ride->save();
		$ride_data = new RideResource(Ride::find($ride->id));

		$title = 'New Booking';
		$message = 'You Received new booking';
		$ride_data['waiting_time'] = $settingValue->waiting_time;
		$additional = ['type' => 1, 'ride_id' => $ride->id, 'ride_data' => $ride_data];
		if (!empty($driverids)) {
			$ios_driver_tokens = User::whereIn('id', $driverids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'ios'])->pluck('device_token')->toArray();
			if (!empty($ios_driver_tokens)) {
				bulk_pushok_ios_notification($title, $message, $ios_driver_tokens, $additional, $sound = 'default', 2);
			}
			$android_driver_tokens = User::whereIn('id', $driverids)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'android'])->pluck('device_token')->toArray();
			if (!empty($android_driver_tokens)) {
				bulk_firebase_android_notification($title, $message, $android_driver_tokens, $additional);
			}
			$notification_data = [];
			$ridehistory_data = [];
			foreach ($driverids as $driverid) {
				$notification_data[] = ['title' => $title, 'description' => $message, 'type' => 1, 'user_id' => $driverid, 'additional_data' => json_encode($additional), 'service_provider_id' => Auth::user()->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
				$ridehistory_data[] = ['ride_id' => $ride->id, 'driver_id' => $driverid, 'status' => '2', 'service_provider_id' => Auth::user()->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
			}
			Notification::insert($notification_data);
			RideHistory::insert($ridehistory_data);
		}
		$rideData = Ride::find($ride->id);
		if(!empty($request->driver_id)){
			$rideData->driver_id = null;
		} else {
			$overallDriversCount = User::select(
				"users.*",
				DB::raw("3959 * acos(cos(radians(" . $ride->pick_lat . "))
					* cos(radians(users.current_lat))
					* cos(radians(users.current_lng) - radians(" . $ride->pick_lng . "))
					+ sin(radians(" . $ride->pick_lat . "))
					* sin(radians(users.current_lat))) AS distance")
			)->where(['user_type' => 2, 'availability' => 1])->whereNotNull('device_token')->get()->toArray();
			$rideData->notification_sent = 1;
			if (count($overallDriversCount) <= count($drivers)) {
				$rideData->alert_send = 1;
			}
		}
		$rideData->alert_notification_date_time = Carbon::now()->addseconds($settingValue->waiting_time)->format("Y-m-d H:i:s");
		$rideData->save();
		// if (!empty($rideData->user) && empty($rideData->user->password) && !empty($rideData->user->phone)) {
		// 	$message_content = "";
		// 	$SMSTemplate = SMSTemplate::find(2);
		// 	if ($rideData->user->country_code == "41" || $rideData->user->country_code == "43" || $rideData->user->country_code == "49") {
		// 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#TIME#', date('d M, Y h:ia', strtotime($rideData->ride_time)), $SMSTemplate->german_content));
		// 	} else {
		// 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#TIME#', date('d M, Y h:ia', strtotime($rideData->ride_time)), $SMSTemplate->english_content));
		// 	}
		// 	$this->sendSMS("+" . $rideData->user->country_code, ltrim($rideData->user->phone, "0"), $message_content);
		// }

		return response()->json(['success' => true, 'message' => 'Instant ride created successfully.', 'data' => $ride], $this->successCode);
	}

	public function sharingRide(Request $request)
	{
		$rules = [
			'pick_lat' => 'required',
			'pick_lng' => 'required',
			// 'pickup_address' => 'required',
			'start_location' => 'required',
			// 'drop_location' => 'required',
			'number_of_passanger' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}
		$ride = new Ride();
		$ride->pick_lat = $request->pick_lat;
		$ride->pick_lng = $request->pick_lng;

		if (!empty($request->dest_address)) {
			$ride->dest_address = $request->dest_address;
		}
		if (!empty($request->dest_lat)) {
			$ride->dest_lat = $request->dest_lat;
		}
		if (!empty($request->dest_lng)) {
			$ride->dest_lng = $request->dest_lng;
		}

		/* if(!empty($request->dest_address))
			{
            $input['dest_address'] = $request->dest_address;
			} */
		if (!empty($request->number_of_passanger)) {
			$ride->passanger = $request->number_of_passanger;
		}

		$ride->pickup_address = $request->start_location;
		//$input['dest_address']=$request->drop_location;
		$ride->ride_type = 4;
		$ride->max_seats = Price::max('seating_capacity');
		$ride->actual_share_ride = 1;
		if (!empty($request->schedule_time)) {
			$ride->ride_time = date("Y-m-d H:i:s", strtotime($request->schedule_time));
		}
		if (!empty($request->ride_cost)) {
			$ride->ride_cost = $request->ride_cost;
		}
		if (!empty($request->payment_type)) {
			$ride->payment_type = $request->payment_type;
		}
		$ride->user_id = Auth::user()->id;
		if (Auth::user())
		{
			$ride->user_country_code = Auth::user()->country_code;
			$ride->user_phone = Auth::user()->phone;
		}
		if (!empty($request->distance)) {
			$ride->distance = $request->distance;
		}
		//dd($input);
		$ride->save();
		$rideid = $ride->id;
		$ride_data = Ride::query()->where([['id', '=', $rideid]])->first();
		$ride_data->join_id = $rideid;
		$ride_data->save();
		$ride_datafinal = Ride::query()->where([['id', '=', $rideid]])->first();
		return response()->json(['success' => true, 'message' => ' Ride for share created successfully.', 'data' => $ride_datafinal], $this->successCode);
	}
	public function joinRideList(Request $request)
	{
		$user_id = Auth::user()->id;
		/* $rules = [
            'pick_lat' => 'required',
            'pick_lng' => 'required',
            'dest_lat' => 'required',
            'dest_lng' => 'required',
            'number_of_passanger' => 'required',
            'ride_time' => 'required',
         ];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first(),'error'=>$validator->errors()], $this->warningCode);
        } */

		//$from = date("Y-m-d H:i:s");
		if (!empty($request->ride_time)) {
			$from = $request->ride_time;
		} else {
			$from = date("Y-m-d H:i:s");
		}

		$settings = \App\Setting::first();
		$settingValue = json_decode($settings['value']);
		$joinradius = $settingValue->join_radius;


		if (!empty($request->from_time) && !empty($request->to_time)) {
			$from = $request->from_time;
			$to = $request->to_time;
			if (!empty($request->pick_lat) && !empty($request->pick_lng)) {
				$lat = $request->pick_lat;
				$lon = $request->pick_lng;
				$query = Ride::select(
					"rides.*",
					DB::raw("3959 * acos(cos(radians(" . $lat . "))
                    * cos(radians(rides.pick_lat))
                    * cos(radians(rides.pick_lng) - radians(" . $lon . "))
                    + sin(radians(" . $lat . "))
                    * sin(radians(rides.pick_lat))) AS distance")
				);
				$query->where([['status', '=', 0], ['ride_type', '=', 4], ['actual_share_ride', '=', 1]])->whereBetween('ride_time', [$from, $to])->having('distance', '<', $joinradius)->orderBy('distance', 'asc');
				$rides = $query->get()->toArray();
				//$query->where('user_type', '=',2)->orderBy('distance','asc');

			} else {

				$rides = Ride::where([['status', '=', 0], ['ride_type', '=', 4], ['actual_share_ride', '=', 1]])->whereBetween('ride_time', [$from, $to])->orderBy('id', 'desc');
			}
		} else {
			if (!empty($request->pick_lat) && !empty($request->pick_lng)) {
				$lat = $request->pick_lat;
				$lon = $request->pick_lng;
				$query = Ride::select(
					"rides.*",
					DB::raw("3959 * acos(cos(radians(" . $lat . "))
                    * cos(radians(rides.pick_lat))
                    * cos(radians(rides.pick_lng) - radians(" . $lon . "))
                    + sin(radians(" . $lat . "))
                    * sin(radians(rides.pick_lat))) AS distance")
				);
				$query->where([['status', '=', 0], ['ride_type', '=', 4], ['actual_share_ride', '=', 1], ['ride_time', '>=', $from]])->having('distance', '<', $joinradius)->orderBy('distance', 'asc');
				$rides = $query->get()->toArray();
			} else {
				$rides = Ride::where([['status', '=', 0], ['ride_type', '=', 4], ['actual_share_ride', '=', 1], ['ride_time', '>=', $from]])->orderBy('id', 'desc')->get();
			}
		}


		//echo $sql = Ride::where([['status', '=', 0],['ride_type', '=', 4],['actual_share_ride', '=', 1],['ride_time', '>=', $from]])->orderBy('id', 'desc')->toSql(); die;
		if (!empty($rides)) {
			$ridesnew = array();
			$i = 0;
			foreach ($rides as $ride) {
				$seatsfilled = Ride::where([['join_id', '=', $ride['id']], ['status', '=', 0]])->sum('passanger');
				$max_seats = Price::max('seating_capacity');
				$ridesnew[$i] = $ride;
				$ridesnew[$i]['max_seats'] = $max_seats;
				$ridesnew[$i]['seats_filled'] = $seatsfilled;
				$ridesnew[$i]['available_seats'] = $max_seats - $seatsfilled;
				$joinridecheck = Ride::where([['join_id', '=', $ride['id']], ['status', '=', 0], ['user_id', '=', $user_id]])->first();
				if (!empty($joinridecheck)) {
					$ridesnew[$i]['ride_joined'] = 1;
					$ridesnew[$i]['ride_joined_id'] = $joinridecheck['id'];
				} else {
					$ridesnew[$i]['ride_joined'] = 0;
					$ridesnew[$i]['ride_joined_id'] = 0;
				}
				$i++;
			}
			$rides = $ridesnew;
		}


		$datarides['current_page'] = 1;
		$total = count($rides);
		$datarides['data'] = $rides;
		$datarides['per_page'] = 20;
		$datarides['last_page'] = 1;
		$datarides['total'] = $total;

		return response()->json(['success' => true, 'message' => 'Ride List got successfully.', 'data' => $datarides], $this->successCode);
	}
	public function joinRide(Request $request)
	{
		$rules = [
			'ride_id' => 'required',
			'pick_lat' => 'required',
			'pick_lng' => 'required',
			'dest_lat' => 'required',
			'dest_lng' => 'required',
			'number_of_passanger' => 'required',
			'ride_time' => 'required',
			'start_location' => 'required',
			'dest_address' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}
		$ride_data = Ride::query()->where([['id', '=', $request->ride_id]])->first();

		$ride = new Ride();



		$ride->pick_lat = $request->pick_lat;
		$ride->pick_lng = $request->pick_lng;

		if (!empty($request->dest_address)) {
			$ride->dest_address = $request->dest_address;
		}
		if (!empty($request->dest_lat)) {
			$ride->dest_lat = $request->dest_lat;
		}
		if (!empty($request->dest_lng)) {
			$ride->dest_lng = $request->dest_lng;
		}

		/* if(!empty($request->dest_address))
			{
            $input['dest_address'] = $request->dest_address;
			} */
		if (!empty($request->number_of_passanger)) {
			$ride->passanger = $request->number_of_passanger;
		}

		$ride->pickup_address = $request->start_location;
		//$input['dest_address']=$request->drop_location;
		$ride->ride_type = 4;
		$ride->join_id = $request->ride_id;
		$ride->max_seats = Price::max('seating_capacity');
		if (!empty($request->ride_time)) {
			$ride->ride_time = date("Y-m-d H:i:s", strtotime($request->ride_time));
		}
		if (!empty($request->ride_cost)) {
			$ride->ride_cost = $request->ride_cost;
		}
		if (!empty($request->payment_type)) {
			$ride->payment_type = $request->payment_type;
		}
		$ride->user_id = Auth::user()->id;
		if (Auth::user())
		{
			$ride->user_country_code = Auth::user()->country_code;
			$ride->user_phone = Auth::user()->phone;
		}
		if (!empty($request->distance)) {
			$ride->distance = $request->distance;
		}
		//dd($input);
		$ride->save();
		$rideid = $ride->id;
		$ride_data = Ride::query()->where([['id', '=', $rideid]])->first();

		return response()->json(['success' => true, 'message' => 'Ride Joined Successfully.', 'data' => $ride_data], $this->successCode);
	}
	public function joinRideData(Request $request)
	{
		$user_id = Auth::user()->id;
		$rules = [
			'ride_id' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}
		$user_data = User::select('id', 'current_lat', 'current_lng', 'user_type')->where('id', $user_id)->first();
		$lat = $user_data['current_lat'];
		$lon = $user_data['current_lng'];
		$joinridedata = Ride::where([['id', '=', $request->ride_id], ['actual_share_ride', '=', 1]])->first();

		$datarides = array();


		$query = Ride::select(
			"rides.*",
			DB::raw("3959 * acos(cos(radians(" . $lat . "))
                    * cos(radians(rides.pick_lat))
                    * cos(radians(rides.pick_lng) - radians(" . $lon . "))
                    + sin(radians(" . $lat . "))
                    * sin(radians(rides.pick_lat))) AS distance")
		);
		$query->where([['join_id', '=', $request->ride_id]])->orderBy('distance', 'asc')->with('user');
		//$query->where('user_type', '=',2)->orderBy('distance','asc');
		$joinridepickups = $query->get()->toArray();

		$query2 = Ride::select(
			"rides.*",
			DB::raw("3959 * acos(cos(radians(" . $lat . "))
                    * cos(radians(rides.dest_lat))
                    * cos(radians(rides.dest_lng) - radians(" . $lon . "))
                    + sin(radians(" . $lat . "))
                    * sin(radians(rides.dest_lat))) AS distance")
		);
		$query->where([['join_id', '=', $request->ride_id]])->orderBy('distance', 'asc')->with('user');
		//$query->where('user_type', '=',2)->orderBy('distance','asc');
		$joinridedestinations = $query2->get()->toArray();


		//$joinrides = Ride::where([['join_id', '=', $request->ride_id]])->orderBy('id', 'desc')->get();

		if (!empty($joinridedata)) {
			$datarides['pickups'] = $joinridepickups;
			$datarides['destination'] = $joinridepickups;
		}
		return response()->json(['success' => true, 'message' => 'Ride List got successfully.', 'data' => $datarides], $this->successCode);
	}

	public function createTrip(Request $request)
	{
		try {
			// $rules = [
			// 	'start_location' => 'required',
			// 	'car_type' => 'required',
			// 	'time' => 'required',
			// ];

			// $validator = Validator::make($request->all(), $rules);


			// $validator = Validator::make($request->all(), [
			// 	'start_location' => 'required',
			// 	'pick_lat' => 'required',
			// 	'pick_lng' => 'required',
			// 	'car_type' => 'required',
			// 	'time' => 'required',
			// ], [ 
			// 	'start_location.required' => 'The pickup location field is required.',
			// 	'pick_lat.required' => 'Pickup location data missing. Please select pickup location again.',
			// 	'pick_lng.required' => 'Pickup location data missing. Please select pickup location again.',
			// ]);

			// if ($validator->fails()) {
			// 	return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			// }


			if(empty($request->start_location)) {
				return response()->json(['message' => "The pickup location field is required"], $this->warningCode);
			}
			if(empty($request->pick_lat)) {
				return response()->json(['message' => "Pickup location data missing. Please select pickup location again."], $this->warningCode);
			}
			if(empty($request->pick_lng)) {
				return response()->json(['message' => "Pickup location data missing. Please select pickup location again."], $this->warningCode);
			}
			if(empty($request->car_type)) {
				return response()->json(['message' => "The car type field is required."], $this->warningCode);
			}
			if(empty($request->time)) {
				return response()->json(['message' => "The time field is required."], $this->warningCode);
			}
			
			$input = $request->all();
			$ride = new Ride();
			$ride->pickup_address = $request->start_location;
			if (!empty($request->drop_location)) {
				$ride->dest_address = $request->drop_location;
			}
			if (!empty($request->dest_lat)) {
				$ride->dest_lat = $request->dest_lat;
			}
			if (!empty($request->dest_lng)) {
				$ride->dest_lng = $request->dest_lng;
			}
			if (!empty($request->pick_lat)) {
				$ride->pick_lat = $request->pick_lat;
			}
			if (!empty($request->pick_lng)) {
				$ride->pick_lng = $request->pick_lng;
			}
			if (!empty($request->dest_address)) {
				$ride->dest_address = $request->dest_address;
			}
			if (!empty($request->passanger)) {
				$ride->passanger = $request->passanger;
			}
			if (!empty($request->schedule_time)) {
				$ride->schedule_time = $request->schedule_time;
			}
			if (!empty($request->alert_time)) {
				$ride->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('-' . $request->alert_time . ' minutes', strtotime($request->time)));
			} else {
				$ride->alert_notification_date_time = date('Y-m-d H:i:s', strtotime('-15 minutes', strtotime($request->time)));
			}
			$ride->alert_time = $request->alert_time;

			unset($input['note']);
			if (!empty($request->payment_type)) {
				$ride->payment_type = $request->payment_type;
			}
			if (!empty($request->time)) {
				$ride->ride_time = date("Y-m-d H:i:s", strtotime($request->time));
			} else {
				$ride->ride_time = date('Y-m-d H:i:s');
			}
			if (!empty($request->note)) {
				$ride->note = $request->note;
			}
			if (!empty($request->car_type)) {
				$ride->car_type = $request->car_type;
			}
			if (!empty($request->ride_cost)) {
				$ride->ride_cost = $request->ride_cost;
			}
			if (!empty($request->distance)) {
				$ride->distance = $request->distance;
			}
			if(!empty($request->service_provider_id)){
				$ride->service_provider_id = $request->service_provider_id;
			}
			$ride->pickup_address = $request->start_location;
			$ride->ride_type = 1;
			$ride->created_by = 1;
			$ride->creator_id = Auth::user()->id;
			$ride->user_id = Auth::user()->id;
			if (Auth::user())
			{
				$ride->user_country_code = Auth::user()->country_code;
				$ride->user_phone = Auth::user()->phone;
			}
			$ride->platform = Auth::user()->device_type;
			if (!empty($request->driver_id)) {
				$ride->driver_id = $request->driver_id;
			}

			$ride->save();

			if (!empty($request->service_provider_id)) {
				$settings = Setting::where(['service_provider_id' => $request->service_provider_id])->first();
				$settingValue = json_decode($settings['value']);

				$masterDriverIds = User::whereNotNull('device_token')->whereNotNull('device_type')->where(['user_type' => 2, 'is_master' => 1, 'service_provider_id' => $request->service_provider_id])->pluck('id')->toArray();
				if (!empty($masterDriverIds)) {
					$title = 'Ride is planned';
					$message = 'A new ride is planned';
					$ride = new RideResource(Ride::find($ride->id));
					$ride['waiting_time'] = $settingValue->waiting_time;
					$additional = ['type' => 15, 'ride_id' => $ride->id, 'ride_data' => $ride];
					$ios_driver_tokens = User::whereIn('id', $masterDriverIds)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'ios'])->pluck('device_token')->toArray();
					if (!empty($ios_driver_tokens)) {
						bulk_pushok_ios_notification($title, $message, $ios_driver_tokens, $additional, $sound = 'default', 2);
					}
					$android_driver_tokens = User::whereIn('id', $masterDriverIds)->whereNotNull('device_token')->where('device_token', '!=', '')->where(['device_type' => 'android'])->pluck('device_token')->toArray();
					if (!empty($android_driver_tokens)) {
						bulk_firebase_android_notification($title, $message, $android_driver_tokens, $additional);
					}
					$notification_data = [];
					foreach ($masterDriverIds as $driverid) {
						$notification_data[] = ['title' => $title, 'description' => $message, 'type' => 15, 'user_id' => $driverid, 'additional_data' => json_encode($additional), 'service_provider_id' => $request->service_provider_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
					}
					Notification::insert($notification_data);
				}
			}

			$ride_data = Ride::find($ride->id);
			return response()->json(['success' => true, 'message' => 'Trip created successfully.', 'data' => $ride_data], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function rideEdit(Request $request)
	{
		// $rules = [
		// 	'ride_id' => 'required',
		// ];

		// $validator = Validator::make($request->all(), $rules);

		// $validator = Validator::make($request->all(), [
		// 	'start_location' => 'required',
		// 	'pick_lat' => 'required',
		// 	'pick_lng' => 'required',
		// 	'ride_id' => 'required',
		// ], [ 
		// 	'start_location.required' => 'The pickup location field is required.',
		// 	'pick_lat.required' => 'Pickup location data missing. Please select pickup location again.',
		// 	'pick_lng.required' => 'Pickup location data missing. Please select pickup location again.',
		// ]);

		// if ($validator->fails()) {
		// 	return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		// }

		if(!empty($request->start_location)) {
			if(empty($request->pick_lat)) {
				return response()->json(['message' => "Pickup location data missing. Please select pickup location again."], $this->warningCode);
			}
			if(empty($request->pick_lng)) {
				return response()->json(['message' => "Pickup location data missing. Please select pickup location again."], $this->warningCode);
			}
		}
		if(empty($request->ride_id)) {
			return response()->json(['message' => "The ride id field is required."], $this->warningCode);
		}
		try {
			DB::beginTransaction();
			$rideDetail = Ride::find($request->ride_id);
			$all_ride_ids = [$request->ride_id];
			if($request->change_for_all == 1){
				if(!empty($rideDetail->parent_ride_id)){
					$all_ride_ids = Ride::where(['parent_ride_id' => $rideDetail->parent_ride_id])->where('ride_time', '>', Carbon::now())->pluck('id')->toArray();
				}
			}
			foreach ($all_ride_ids as $ride_key => $ride_id) {
				$ride = Ride::find($ride_id);

				if (!empty($request->start_location)) {
					$ride->pickup_address = $request->start_location;
				}
				if (!empty($request->user_id)) {
					$ride->user_id = $request->user_id;
				}
				if (!empty($request->drop_location)) {
					$ride->dest_address = $request->drop_location;
				}
				if (!empty($request->dest_lat)) {
					$ride->dest_lat = $request->dest_lat;
				}
				if (!empty($request->dest_lng)) {
					$ride->dest_lng = $request->dest_lng;
				}
				if (!empty($request->pick_lat)) {
					$ride->pick_lat = $request->pick_lat;
				}
				if (!empty($request->pick_lng)) {
					$ride->pick_lng = $request->pick_lng;
				}
				if (!empty($request->passanger)) {
					$ride->passanger = $request->passanger;
				}
				if (!empty($request->schedule_time)) {
					$ride->schedule_time = $request->schedule_time;
				}

				if (!empty($request->ride_time)) {
					$onlyTime = date("H:i:s", strtotime($request->ride_time));
					if($request->change_for_all == 1){
						if($request->ride_id == $ride_id){
							$onlyDate = date("Y-m-d", strtotime($request->ride_time));
						} else {
							$onlyDate = date("Y-m-d", strtotime($ride->ride_time));
						}
					} else {
						$onlyDate = date("Y-m-d", strtotime($request->ride_time));
					}
					$date_time = $onlyDate." ".$onlyTime;
					$ride->ride_time = $date_time;
					if (!empty($request->alert_time)) {
						$ride->alert_time = $request->alert_time;
						$alert_notification_date_time = date('Y-m-d H:i:s', strtotime('-' . $request->alert_time . ' minutes', strtotime($date_time)));
					} else {
						if($date_time > date('Y-m-d H:i:s')){
							$to = Carbon::createFromFormat('Y-m-d H:i:s', $date_time);
							$from = now();
							$diff_in_minutes = $to->diffInMinutes($from);
							if($diff_in_minutes >= 15) {
								$ride->alert_time = 15;
								$alert_notification_date_time = date('Y-m-d H:i:s', strtotime('-15 minutes', strtotime($date_time)));
							} else {
								$ride->alert_time = $diff_in_minutes;
								$alert_notification_date_time = date("Y-m-d H:i:s");
							}
						} else {
							$ride->alert_time = 0;
							$alert_notification_date_time = date('Y-m-d H:i:s');
						}
					}
				}

				if (!empty($request->alert_time)) {
					$ride->alert_time = $request->alert_time;
				}

				if (!empty($request->note)) {
					$ride->note = $request->note;
				}
				if (!empty($request->company_id)) {
					$ride->company_id = $request->company_id;
				}
				if (!empty($request->payment_type)) {
					$ride->payment_type = $request->payment_type;
				}
				if (!empty($request->car_type)) {
					$ride->car_type = $request->car_type;
				}
				if (!empty($request->ride_cost)) {
					$ride->ride_cost = $request->ride_cost;
				}
				if (!empty($request->distance)) {
					$ride->distance = $request->distance;
				}
				if (!empty($request->ride_type)) {
					$ride->ride_type = 1;
				}
				if ($request->has('route')) {
					$ride->route = $request->route;
				}

				if ((!empty($alert_notification_date_time)) && (!empty($request->ride_time)) && $alert_notification_date_time >= Carbon::now()->format("Y-m-d H:i:s")) {
					$ride->alert_notification_date_time = $alert_notification_date_time;
					$ride->notification_sent = 0;
					$ride->alert_send = 0;
					$ride->status = 0;
				}
				$ride->save();
			}

			// if (empty($rideDetail->user_id) && !empty($request->user_id) && !empty($ride->user) && empty($ride->user->password) && !empty($ride->user->phone)) {
			// 	$message_content = "";
			// 	$SMSTemplate = SMSTemplate::find(6);
			// 	if ($ride->user->country_code == "41" || $ride->user->country_code == "43" || $ride->user->country_code == "49") {
			// 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#SERVICE_PROVIDER#', "Taxi2000", $SMSTemplate->german_content));
			// 	} else {
			// 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#SERVICE_PROVIDER#', "Taxi2000", $SMSTemplate->english_content));
			// 	}
			// 	$this->sendSMS("+" . $ride->user->country_code, ltrim($ride->user->phone, "0"), $message_content);
			// }
			DB::commit();
			$ride_data = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'route', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])->find($request->ride_id);
			if (!empty($ride_data->user_id)) {
				$ride_data['user_data'] = User::find($ride_data->user_id);
			} else {
				$ride_data['user_data'] = null;
			}
			return response()->json(['success' => true, 'message' => 'Ride Updated successfully.', 'data' => $ride_data], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			DB::rollback();
			Log::info('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $exception->getLine(). ' --- ' . $exception->getMessage());
			return response()->json(['message' => $exception->getMessage()], 401);
		} catch (\Exception $exception) {
			DB::rollback();
			Log::info('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $exception->getLine(). ' --- ' . $exception->getMessage());
			return response()->json(['message' => $exception->getMessage()], 401);
		}
	}

	public function waitingstatuschange(Request $request)
	{
		$userDetail = Auth::user();

		$rules = [
			'ride_id' => 'required',
			'waiting' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}

		$ride = Ride::find($request->ride_id);
		if ($ride) {
			if ($ride->driver_id == $userDetail->id && $ride->service_provider_id == $userDetail->service_provider_id) {

				if ($request->waiting == 0) {
					$ride->waiting = 0;
				}
				if ($request->waiting == 1) {
					$ride->waiting = 1;
				}

				$ride->save();
				$ride_data = Ride::find($request->ride_id);
				return response()->json(['success' => true, 'message' => 'Waiting status Updated successfully.', 'data' => $ride_data], $this->successCode);
			} else {
				return response()->json(['message' => "This ride doesn't belong to you."], $this->warningCode);
			}
		} else {
			return response()->json(['message' => 'No such ride exists.'], $this->warningCode);
		}
	}

	public function rideForSharing(Request $request)
	{
		/*$rules = [
            'time' => 'required',
         ];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first(),'error'=>$validator->errors()], $this->warningCode);
        }*/
		$dateTime = $request->time;
		if (!empty($dateTime) && $dateTime != null) {
			$rides = Ride::where('ride_type', 4)->where('ride_time', '>=', $request->time)->paginate(10);
		} else {
			$rides = Ride::where('ride_type', 4)->where('ride_time', '>=', date('Y-m-d H:i:s'))->paginate(10);
		}
		return response()->json(['success' => true, 'message' => 'get successfully.', 'data' => $rides], $this->successCode);
	}

	public function cancelRide(Request $request)
	{
		$rules = [
			'ride_id' => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}
		$logged_in_user = Auth::user();
		$rideDetail = Ride::where(['id' => $request->ride_id, 'user_id' => $logged_in_user->id])->first();
		if ($rideDetail) {
			$rideDetail->status = -1;
			$rideDetail->save();
			if(!empty($rideDetail->driver_id)){
				$driverData = User::find($rideDetail->driver_id);
				if ($driverData) {
					$deviceToken = $driverData['device_token'];
					$deviceType = $driverData['device_type'];
					$title = 'Ride Cancelled';
					$message = "The ride has been cancelled by the user.";
					$type = 5;
					$ride_detail = new RideResource(Ride::find($request->ride_id));
					$additional = ['type' => $type, 'ride_id' => $request->ride_id, 'ride_data' => $ride_detail];
					if (!empty($deviceToken)) {
						if ($deviceType == 'android') {
							bulk_firebase_android_notification($title, $message, [$deviceToken], $additional);
						}
						if ($deviceType == 'ios') {
							bulk_pushok_ios_notification($title, $message, [$deviceToken], $additional, $sound = 'default', $driverData['user_type']);
						}
					}

					$notification = new Notification();
					$notification->title = $title;
					$notification->description = $message;
					$notification->type = $type;
					$notification->user_id = $driverData->id;
					$notification->additional_data = json_encode($additional);
					$notification->save();
				}
			}
			return response()->json(['success' => true, 'message' => 'Ride cancelled successfully.'], $this->successCode);
		} else {
			return response()->json(['success' => false, 'message' => "No such ride exist"], $this->warningCode);
		}
	}


	public function carList()
	{
		$logged_in_user = Auth::user();
		$categories = Price::where(['service_provider_id' => $logged_in_user->service_provider_id])->get();
		foreach ($categories as $category_key => $cat) {
			$j = 0;
			$allcars = Vehicle::where([['category_id', '=', $cat['id']]])->orderBy('id', 'desc')->get();
			$cararray = array();
			foreach ($allcars as $allcar) {
				$driver_car = DriverChooseCar::where(['car_id' => $allcar->id])->orderBy('id', 'desc')->first();
				if (!empty($driver_car) && $driver_car->logout == 0) {
					if ($logged_in_user->is_master == 1) {
						$allcar->logout_mileage = "";
						$allcar->is_occupied = 1;
						$cararray[$j] = $allcar;
						$j++;
					}
				} else {
					$allcar->is_occupied = 0;
					if (!empty($driver_car)) {
						$allcar->logout_mileage = $driver_car['logout_mileage'];
					} else {
						$allcar->logout_mileage = "";
					}
					$cararray[$j] = $allcar;
					$j++;
				}
			}
			$categories[$category_key]['cars'] = $cararray;
		}

		return response()->json(['success' => true, 'message' => 'List of cars', 'data' => $categories], $this->successCode);
	}


	public function setPassword(Request $request)
	{
		$rules = [
			'password' => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}
		$userId = Auth::user()->id;
		$input['password'] = Hash::make($request['password']);
		\App\User::where('id', $userId)->update($input);
		$userData = \App\User::where('id', $userId)->first();
		$userData->AauthAcessToken()->delete();
		$token =  $userData->createToken('auth')->accessToken;
		$input = $request->all();
		return response()->json(['success' => true, 'message' => 'Password set successfully.', 'data' => $userData, 'token' => $token], $this->successCode);
	}

	public function saveSelectedCar(Request $request)
	{
		$rules = [
			'car_id' => 'required',
			'mileage' => 'required'
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}

		$vehicle = \App\Vehicle::where('id', $request->car_id)->first();
		if (!empty($vehicle)) {
			$vehicle->update(['mileage' => $request->mileage]);
			return response()->json(['success' => true, 'message' => 'Selected card saved successfully.'], $this->successCode);
		} else {
			return response()->json(['message' => 'record not found'], $this->errorCode);
		}
	}


	public function getCurrentUserType()
	{
		$userId = Auth::user()->id;
		$user = \App\User::where('id', $userId)->first();
		if ($user->is_master == 1) {
			$userType = "Master Driver";
		} else {
			$userType = "Regular Driver";
		}
		return response()->json(['success' => true, 'message' => 'success.', 'date' => $userType], $this->successCode);
	}


	public function getSavedLocation()
	{
		$userId = Auth::user()->id;
		$savedLocation = \App\SaveLocation::where('user_id', $userId)->paginate(10);
		if (count($savedLocation) > 0) {
			return response()->json(['success' => true, 'message' => 'success.', 'date' => $savedLocation], $this->successCode);
		} else {
			return response()->json(['success' => false, 'message' => 'Location not found'], $this->successCode);
		}
	}

	public function changeDefaultHomeWorkLocation(Request $request)
	{
		$rules = [
			'location_type' => 'required',
			'lat' => 'required',
			'long' => 'required',
			'name' => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}
		$userId = Auth::user()->id;
		$defaultLocation = \App\SaveLocation::where('user_id', $userId)->where('default_location', 1)->first();
		if (!empty($defaultLocation) && $defaultLocation != null) {
			$result = \App\SaveLocation::where('user_id', $userId)->where('default_location', 1)->update([
				'location_type' => $request->location_type,
				'current_lat' => $request->lat,
				'current_lng' => $request->long,
				'location_name' => $request->name
			]);
			if ($result == 1) {
				$defaultLocation = \App\User::select('id', 'location_type', 'current_lng', 'current_lat', 'location_name', 'user_type')->where('id', $userId)->first();
				return response()->json(['success' => true, 'message' => 'Default Location Changed Successfully.', 'date' => $defaultLocation], $this->successCode);
			} else {
				return response()->json(['message' => 'Something went wrong'], $this->warningCode);
			}
		} else {
			$defaultLocation = \App\SaveLocation::create([
				'location_type' => $request->location_type,
				'current_lat' => $request->lat,
				'current_lng' => $request->long,
				'location_name' => $request->name
			]);
			return response()->json(['success' => true, 'message' => 'Default Location Changed Successfully.', 'date' => $defaultLocation], $this->successCode);
		}
	}

	public function completeRide(Request $request)
	{
		$rules = [
			'ride_id' => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}
		$userId = Auth::user()->id;
		$result = Ride::where('id', $request->ride_id)->where('user_id', $userId)->update(['status' => 3]);
		if ($result > 0) {
			return response()->json(['success' => true, 'message' => 'Ride completed successfully.'], $this->successCode);
		}
	}

	public function rateRide(Request $request)
	{
		try {
			$rules = [
				'ride_id' => 'required',
				'to_user_id' => 'required',
				'rating' => 'required',
				//'review'=>'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}
			$input = $request->all();
			$input['to_id'] = $request->to_user_id;
			$input['from_id'] = Auth::user()->id;
			$rating = \App\Rating::create($input);
			return response()->json(['success' => true, 'message' => 'success.', 'date' => $rating], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function acceptRejectRide(Request $request, RideHistory $rideHistory)
	{
		try {
			$rules = [
				'status' => 'required',
				'ride_id' => 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}

			$ride = Ride::find($request->ride_id);
			if ($ride->status == -2 && $request->status == 1) {
				return response()->json(['message' => "Ride already cancelled"], $this->warningCode);
			}
			if (!empty($ride)) {
				if ($request->status == 1) {
					if ($ride->status == 1) {
						return response()->json(['message' => "Ride already Accepted"], $this->warningCode);
					}
					if (empty($request->car_id)) {
						return $this->validationErrorResponse('The car id is required !');
					}
					Ride::where('id', $request->ride_id)->update(['status' => $request->status, 'vehicle_id' => $request->car_id, 'waiting' => $request->waiting, 'driver_id' => Auth::user()->id]);
					$rideHistoryDetail = RideHistory::where(['ride_id' => $request->ride_id, 'driver_id' => Auth::user()->id])->first();
					if(!empty($rideHistoryDetail)){
						$rideHistoryDetail->status = "1";
						$rideHistoryDetail->save();
					}
					$ride_detail = new RideResource(Ride::find($request->ride_id));
					$userdata = User::find($ride_detail['user_id']);
					if (!empty($userdata)) {
						if ($ride->platform == 'web') {
							// $ride->accept_ride_sms_notify($userdata, $choosed_vehicle);
						}

						/* Send Notification to User */
						$title = 'Ride Accepted';
						$message = 'Your booking accepted by the driver please check the driver detail';
						$deviceType = $userdata['device_type'];
						$type = 2;
						$additional = ['type' => $type, 'ride_id' => $request->ride_id, 'ride_data' => $ride_detail];
						$deviceToken = $userdata['device_token'];
						if (!empty($deviceToken)) {
							if ($deviceType == 'android') {
								bulk_firebase_android_notification($title, $message, [$deviceToken], $additional);
							}
							if ($deviceType == 'ios') {
								bulk_pushok_ios_notification($title, $message, [$deviceToken], $additional, $sound = 'default', $userdata['user_type']);
							}
						}
						$notification = new Notification();
						$notification->title = $title;
						$notification->description = $message;
						$notification->type = $type;
						$notification->user_id = $userdata['id'];
						$notification->additional_data = json_encode($additional);
						$notification->service_provider_id = $ride->service_provider_id;
						$notification->save();
					}
					$rideDetail = Ride::find($request->ride_id);
					if(!empty($rideDetail->check_assigned_driver_ride_acceptation)){
						$rideDetail->check_assigned_driver_ride_acceptation = null;
						$rideDetail->save();
					}
					$rideResponse = new RideResource(Ride::find($request->ride_id));
					return $this->successResponse($rideResponse, 'Ride Accepted Successfully.');
				} else if ($request->status == 2) {
					// \App\Ride::where('id', $request->ride_id)->update(['status' => $request->status]);
					// $rideHistory->saveData(['ride_id'=>$request->ride_id,'driver_id'=>Auth::user()->id]);
					$rideHistoryDetail = RideHistory::where(['ride_id' => $request->ride_id, 'driver_id' => Auth::user()->id])->first();
					if (!empty($rideHistoryDetail)) {
						if ($rideHistoryDetail->status == "0") {
							return response()->json(['message' => "Ride already Rejected"], $this->warningCode);
						}
						$rideHistoryDetail->status = "0";
						$rideHistoryDetail->save();
					}
					if ($ride->status == 0) {
						$lastSendNotificationDrivers = explode(',', $ride->all_drivers);
						if (!empty($lastSendNotificationDrivers)) {
							$lastSendNotificationRejectedDriverCount = RideHistory::where(['ride_id' => $request->ride_id, 'status' => "0"])->whereIn('driver_id', $lastSendNotificationDrivers)->count();

							if (count($lastSendNotificationDrivers) == $lastSendNotificationRejectedDriverCount) {
								if ($ride->notification_sent == 1 && $ride->alert_send == 1) {
									Notifications::sendRideNotificationToMasters($request->ride_id);
								} else {
									$driverlimit = 3;
									if(!empty($ride->service_provider_id)){
										$settings = Setting::where(['service_provider_id' => $ride->service_provider_id])->first();
										$settingValue = json_decode($settings['value']);
										$driverlimit = $settingValue->driver_requests;
									}
									
									// $driver_radius = $settingValue->radius;
									$query = User::select(
										"users.*",
										DB::raw("3959 * acos(cos(radians(" . $ride->pick_lat . "))
									* cos(radians(users.current_lat))
									* cos(radians(users.current_lng) - radians(" . $ride->pick_lng . "))
									+ sin(radians(" . $ride->pick_lat . "))
									* sin(radians(users.current_lat))) AS distance")
									)->where(['user_type' => 2, 'availability' => 1])->whereNotNull('device_token');
									if(!empty($ride->service_provider_id)){
										$query->where(['service_provider_id' => $ride->service_provider_id]);
									}
									$overallDriversAvailable = $query->get()->toArray();
									$overallNotificationSentCount = RideHistory::where(['ride_id' => $request->ride_id])->count();
									if (count($overallDriversAvailable) <= $overallNotificationSentCount) {
										Notifications::sendRideNotificationToMasters($request->ride_id);
									} else if ((count($overallDriversAvailable) > $driverlimit) && ($overallNotificationSentCount >= $driverlimit)) {
										Notifications::sendRideNotificationToRemainingDrivers($request->ride_id);
									} else {
										Notifications::SendRideNotificationToDriverOnScheduleTime($request->ride_id);
									}
								}
							}
						}
					}
					// Notifications::checkAllDriverCancelRide($request->ride_id);

					// return response()->json(['success' => true, 'message' => ''], $this->successCode);
					$rideDetail = Ride::find($request->ride_id);
					if(!empty($rideDetail->check_assigned_driver_ride_acceptation)){
						$rideDetail->check_assigned_driver_ride_acceptation = null;
						$rideDetail->save();
					}
					$rideResponse = new RideResource(Ride::find($request->ride_id));
					return $this->successResponse($rideResponse, 'Ride Rejected Successfully.');
				}
			} else {
				return response()->json(['message' => 'Record not found'], $this->errorCode);
			}
		} catch (\Illuminate\Database\QueryException $e) {
			Log::info('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $e->getLine(). ' --- ' . $e->getMessage());
			return response()->json(['message' => $e->getMessage()], $this->warningCode);
		} catch (\Exception $e) {
			Log::info('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $e->getLine(). ' --- ' . $e->getMessage());
			return response()->json(['message' => $e->getMessage()], $this->warningCode);
		}
	}


	public function paymentReceived(Request $request)
	{
		try {
			$rules = [
				'amount' => 'required',
				'mode_of_payment' => 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}



	public function startInstantRide(Request $request)
	{
		try {
			$rules = [
				'pickup_location' => 'required',
				//'promotion'=>'required'
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}
			$input = $request->all();
			$userId = Auth::user()->id;
			$ride = new Ride();

			$ride->pickup_address = $request->pickup_location;
			//$ride->dest_address=$request->drop_off_location;
			//$ride->pick_lat = $request->pick_lat;
			//   $ride->pick_lng = $request->pick_lng;
			if (!empty($request->drop_off_location)) {
				$ride->dest_address = $request->drop_off_location;
			}
			/* if(!empty($request->promotion))
		{
		$ride->promotion=$request->promotion;
		} */
			if (!empty($request->payment_type)) {
				$ride->payment_type = $request->payment_type;
			}
			if (!empty($request->pick_lat)) {
				$ride->pick_lat = $request->pick_lat;
			}
			if (!empty($request->pick_lng)) {
				$ride->pick_lng = $request->pick_lng;
			}
			if (!empty($request->dest_lat)) {
				$ride->dest_lat = $request->dest_lat;
			}
			if (!empty($request->dest_lng)) {
				$ride->dest_lng = $request->dest_lng;
			}
			if (isset($request->user_id) && !empty($request->user_id)) {

				$ride->user_id = $request->user_id;
				$rideUser = User::find($request->user_id);
				if ($rideUser)
				{
					$ride->user_country_code = $rideUser->country_code;
					$ride->user_phone = $rideUser->phone;
				}
			} else {
				unset($input['user_id']);
			}
			$ride->driver_id = $userId;
            if(Auth::user()->service_provider_id)
            {
                $ride->service_provider_id = Auth::user()->service_provider_id;
            }
			if (empty($request->ride_time)) {
				$ride->ride_time = date('Y-m-d H:i:s');
			} else {
				$ride->ride_time = date("Y-m-d H:i:s", strtotime($request->ride_time));
			}

			if (!empty($request->ride_cost)) {
				$ride->ride_cost = $request->ride_cost;
			}
			if (!empty($request->company_id)) {
				$ride->company_id = $request->company_id;
			}
			$ride->ride_type = 3;
			$ride->status = 2;
			$ride->created_by = 2;
			$ride->creator_id = Auth::user()->id;
			$ride->vehicle_id = $request->car_id;
			$ride->is_personal_instant_ride = 1;
			if (!empty($request->distance)) {
				$ride->distance = $request->distance;
			}
			$ride->platform = Auth::user()->device_type;
			$ride->save();
			// if (!empty($ride->user) && empty($ride->user->password) && !empty($ride->user->phone)) {
			// 	$message_content = "";
			// 	$SMSTemplate = SMSTemplate::find(2);
			// 	if ($ride->user->country_code == "41" || $ride->user->country_code == "43" || $ride->user->country_code == "49") {
			// 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#TIME#', date('d M, Y h:ia', strtotime($ride->ride_time)), $SMSTemplate->german_content));
			// 	} else {
			// 		$message_content = str_replace('#LINK#', "\n". 'Android : https://play.google.com/store/apps/details?id=com.dev.veldoouser'."\n".'iOS : https://apps.apple.com/in/app/id1597936025', str_replace('#TIME#', date('d M, Y h:ia', strtotime($ride->ride_time)), $SMSTemplate->english_content));
			// 	}
			// 	$this->sendSMS("+" . $ride->user->country_code, ltrim($ride->user->phone, "0"), $message_content);
			// }
			$rideid = $ride->id;
			$ride = Ride::query()->where([['id', '=', $rideid]])->first();
			return response()->json(['success' => true, 'message' => 'Instant ride started successfully', 'data' => $ride], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function getPromotion(Request $request)
	{
		$userId = Auth::user()->id;
		$current_date = date("Y-m-d");

		//$promotionassigned = Promotion::query()->where([['type', '=', 2]])->whereRaw('FIND_IN_SET(?,user_id)', [$userId])->orderBy('id', 'desc')->where('start_date', '>=', $current_date)->where('end_date', '<=', $current_date)->get()->toArray();
		$promotionassigned = Promotion::query()->where([['type', '=', 2]])->whereRaw('FIND_IN_SET(?,user_id)', [$userId])->orderBy('id', 'desc')->where('end_date', '>=', $current_date)->get()->toArray();
		$promotionglobal = Promotion::query()->where([['type', '=', 1]])->where('end_date', '>=', $current_date)->orderBy('id', 'desc')->get()->toArray();
		//echo Promotion::query()->where([['type', '=', 1]])->where('end_date', '>=', $current_date)->orderBy('id', 'desc')->toSql(); die;
		$promotions = array();


		/* if(!empty($promotionassigned))
		{
			array_push($promotions,$promotionassigned);
		}

		if(!empty($promotionglobal))
		{
			array_push($promotions,$promotionglobal);
		} */
		$promotions = array_merge($promotionassigned, $promotionglobal);

		//$promotions = $promotionglobal;

		if (!empty($request->user_id)) {
			$promotionassigned = Promotion::query()->where([['type', '=', 2]])->whereRaw('FIND_IN_SET(?,user_id)', [$request->user_id])->orderBy('id', 'desc')->where('end_date', '>=', $current_date)->get()->toArray();
			$promotionglobal = Promotion::query()->where([['type', '=', 1]])->where('end_date', '>=', $current_date)->orderBy('id', 'desc')->get()->toArray();

			$promotions = array();
			$promotions = array_merge($promotionassigned, $promotionglobal);
		}
		if (count($promotions) > 0) {
			return response()->json(['success' => true, 'message' => 'get successfully', 'data' => $promotions], $this->successCode);
		} else {
			return response()->json(['message' => 'Record Not found'], $this->warningCode);
		}
	}
	public function getVouchersbak(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];

		try {
			$voucherfromrides = Ride::query()->where([['user_id', '=', $user_id], ['status', '=', 3]])->orderBy('id', 'desc')->get()->toArray();
			$totalmilesfromrides = Ride::where([['user_id', '=', $user_id], ['status', '=', 3]])->sum('miles_received');
			$voucherfrominvitation = InvitationMile::query()->where([['user_id', '=', $user_id]])->orderBy('id', 'desc')->get()->toArray();
			$totalmilesfrominvitation = InvitationMile::query()->where([['user_id', '=', $user_id]])->sum('miles_received');
			$total_miles = $totalmilesfromrides + $totalmilesfrominvitation;

			/*  $newresultarray = array();
			if(!empty($resnewarray))
			{

			$i = 0;

			foreach($resnewarray as $result)
			{
				$newresultarray[$i] = $result;



				$i++;
			}
			} */

			$vouchers = array();
			$vouchers['ride_miles'] = $voucherfromrides;
			$vouchers['invitation_miles'] = $voucherfrominvitation;




			return response()->json(['message' => __('Successfully.'), 'data' => $vouchers, 'total_miles' => $total_miles], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function getVouchers(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];

		try {
			$vouchers = UserVoucher::query()->where([['user_id', '=', $user_id]])->orderBy('id', 'desc')->get()->toArray();
			$plus_vouchers = UserVoucher::where([['user_id', '=', $user_id], ['type', '!=', 3]])->sum('miles');
			$minus_vouchers = UserVoucher::where([['user_id', '=', $user_id], ['type', '=', 3]])->sum('miles');

			$total_miles = $plus_vouchers - $minus_vouchers;

			$newresultarray = array();
			if (!empty($vouchers)) {

				$i = 0;

				foreach ($vouchers as $result) {
					$newresultarray[$i] = $result;
					if (!empty($result['ride_id'])) {
						$ride_data = Ride::query()->where([['id', '=', $result['ride_id']]])->first();
						$newresultarray[$i]['ride_data'] = $ride_data;
					}
					if (!empty($result['refer_use_by'])) {
						$user_data = User::select('id', 'first_name', 'last_name', 'image', 'user_type')->where('id', $result['refer_use_by'])->first();
						$newresultarray[$i]['user_data'] = $user_data;
					}


					$i++;
				}
			}



			return response()->json(['message' => __('Successfully.'), 'data' => $newresultarray, 'total_miles' => $total_miles], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function usermilecheck(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'user_id' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$plus_vouchers = UserVoucher::where([['user_id', '=', $request->user_id], ['type', '!=', 3]])->sum('miles');
			$minus_vouchers = UserVoucher::where([['user_id', '=', $request->user_id], ['type', '=', 3]])->sum('miles');

			$total_miles = $plus_vouchers - $minus_vouchers;


			return response()->json(['message' => __('Successfully.'), 'data' => $total_miles, 'total_miles' => $total_miles], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function addLocation(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'title' => 'required',
			'lat' => 'required',
			'lng' => 'required',
			'type' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$savedLocationCount = \App\SaveLocation::where('user_id', $user_id)->count();

			$savedLocationCount = \App\SaveLocation::where('user_id', $user_id)->count();
			if($savedLocationCount >= 15 && ( $request->type != 1 || $request->type !=2 )){
				  $locationData = \App\SaveLocation::where('user_id', $user_id)->whereNotIn('type',[1,2])->get();

				$recordsToKeep = \App\SaveLocation::where('user_id', $user_id)
				->whereNotIn('type', [1, 2])
				->orderBy('created_at', 'asc')
				->take(1)
				->pluck('id');

				$locationDeleted = \App\SaveLocation::where('id', $recordsToKeep)->delete();
				
				if(!$locationDeleted){
					return response()->json(['message' => 'Location Not  deleted'], $this->successCode);
				}

			}
			if ($request->type == 1 || $request->type == 2) {
				$location = \App\SaveLocation::where('user_id', $user_id)->where('type', $request->type)->first();
				if (!empty($location)) {
					$location->update(['lat' => $request->lat, 'lng' => $request->lng, 'title' => $request->title, 'type' => $request->type]);
					return response()->json(['message' => 'Location Updated successfully'], $this->successCode);
				} else {
					
					\App\SaveLocation::create(['lat' => $request->lat, 'lng' => $request->lng, 'title' => $request->title, 'type' => $request->type, 'user_id' => $user_id]);
					return response()->json(['message' => 'Location Added successfully'], $this->successCode);
				}
			}else{
				$location = SaveLocation::where([['type', '=', $_REQUEST['type']], ['user_id', '=', $user_id], ['lat', '=', $request->lat], ['lng', '=', $request->lng]])->first();
				//$location = SaveLocation::where('user_id',$user_id)->where('type',$request->type)->first();
	
				if (!empty($location) && $location != null) {
					return response()->json(['message' => 'Location Already Added'], $this->successCode);
				} else {
	
					$location = new SaveLocation();
				}
				if ($_REQUEST['type'] == 3) {
					$location = new SaveLocation();
				}
				$location->lat = $request->lat;
				$location->lng = $request->lng;
				$location->title = $request->title;
				$location->type = $request->type;
	
				$location->user_id = $user_id;
				unset($location->created_at);
				unset($location->updated_at);
	
				if ($location->save()) {

					return response()->json(['message' => 'Location Added successfully'], $this->successCode);
				} else {
					return response()->json(['message' => 'Something went wrong'], $this->warningCode);
				}	
			}

			
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function getLocations()
	{
		try {
			$userId = Auth::user()->id;
			$locations = SaveLocation::where('user_id', $userId)->whereIn('type', [1, 2, 3])->orderBy('type', 'asc')->orderBy('id', 'desc')->limit(15)->get();
			$count = SaveLocation::where('user_id', $userId)->whereIn('type', [1, 2, 3])->orderBy('type', 'asc')->limit(15)->count();
			//if(count($locations)>0){
			if (!empty($locations)) {
				return response()->json(['success' => true, 'message' => 'get successfully', 'count' => $count, 'data' => $locations], $this->successCode);
			} else {
				return response()->json(['message' => 'Record Not found'], $this->successCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function userSearchList(Request $request)
	{
		try {
			$text = $request->text;
			$usersQuery = User::where(['user_type' => 1]);
			if (isset($request->text) && $request->text != '') {
				$usersQuery = $usersQuery->where(function ($query) use ($text) {
					$query->where('first_name', 'like', '%' . $text . '%')->orWhere('last_name', 'like', '%' . $text . '%')->orWhere('phone', 'like', '%' . $text . '%');
				});
			}
			if(!empty($request->company_id)){
				$usersQuery = $usersQuery->where(['company_id' => $request->company_id]);
			}
			$users = $usersQuery->orderBy('first_name', 'ASC')->paginate(100);
			$usercountQuery = User::where(['user_type' => 1]);
			if (isset($request->text) && $request->text != '') {
				$usercountQuery = $usercountQuery->where(function ($query) use ($text) {
					$query->where('first_name', 'like', '%' . $text . '%')->orWhere('last_name', 'like', '%' . $text . '%')->orWhere('phone', 'like', '%' . $text . '%');
				});
			}
			if(!empty($request->company_id)){
				$usercountQuery = $usercountQuery->where(['company_id' => $request->company_id]);
			}
			$usercount = $usercountQuery->count();
			if (!empty($usercount)) {
				foreach ($users as $user_key => $userDat) {
					$users[$user_key]->full_name = $userDat->full_name;
					$users[$user_key]->avg_rating = $userDat->avg_rating;
					$users[$user_key]->app_installed = (!empty($userDat->password)) ? 1 : 0;
				}
			} else {
				return response()->json(['success' => true, 'message' => 'No records found', 'data' => $users], $this->successCode);
			}
			return response()->json(['success' => true, 'message' => 'List of users', 'data' => $users], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function getUserByPhone(Request $request)
	{
		try {
			$rules = [
				'country_code' => 'required',
				'phone' => 'required'
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}

			$user = \App\User::select('id', 'first_name', 'last_name', 'email', 'country_code', 'phone', 'image', 'user_type')
				->where('country_code', ltrim($request->country_code,"+"))->where('phone', ltrim($request->phone, "0"))->where('user_type', 1)->first();

			//$userData=\App\UserData::whereRaw('json_contains(phone_number, \''.$request->phone.'\')')->first();

			$phonenum = ltrim($request->phone, "0");
			$countryCode = ltrim($request->country_code,"+");
			$userData = \App\UserData::whereJsonContains('phone_numbers', ['country_code' => $countryCode])->whereJsonContains('phone_numbers', ['phone' => $phonenum])->first();
			$userData2 = \App\UserData::where('user_id', $user['id'])->first();
			if (empty($user) && empty($userData)) {
				return response()->json(['success' => false, 'message' => 'Record Not found'], $this->successCode);
			}

			if (!empty($userData)) {
				$user = \App\User::select('id', 'first_name', 'last_name', 'email', 'country_code', 'phone', 'image', 'user_type')
					->where('id', $userData->user_id)->where('user_type', 1)->first();
				$user['phone_number'] = json_decode($userData->phone_number);
				$user['emails'] = json_decode($userData->email);
				$user['addresses'] = json_decode($userData->addresses);
				$user['favourite_address'] = json_decode($userData->favourite_address);
			}
			if (!empty($userData2)) {
				//echo "true"; die;
				$user = \App\User::select('id', 'first_name', 'last_name', 'email', 'country_code', 'phone', 'image', 'user_type')
					->where('id', $userData2->user_id)->where('user_type', 1)->first();
				$user['phone_number'] = json_decode($userData2->phone_number);
				$user['emails'] = json_decode($userData2->email);
				$user['addresses'] = json_decode($userData2->addresses);
				$user['favourite_address'] = json_decode($userData2->favourite_address);
			}
			if (empty($userData) && empty($userData2)) {
				$user['phone_number'] = array();
				$user['emails'] = array();
				$user['addresses'] = array();
				$user['favourite_address'] = array();
			}
			return response()->json(['success' => true, 'message' => 'get successfully', 'data' => $user], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function scheduleRideList(Request $request)
	{
		try {
			$rules = [
				'hours' => 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}
			$userId = Auth::user()->id;
			$user = \App\User::where('id', $userId)->first();
			$current_time = date("Y-m-d H:i:s");
			$from = date("Y-m-d H:i:s");
			$hours = $request->hours;
			$to = date("Y-m-d H:i:s", strtotime("+$hours hours"));
			/* $rides = Ride::where('user_id',$userId)->whereBetween('ride_date', [$from, $to])->where(function($query) {
			$query->where([['status', '=', 0]])->orWhere([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
})->orderBy('id', 'desc')->with('driver')->paginate($this->limit); */
			$rides = Ride::where([['status', '=', 0], ['user_id', '=', $userId]])->whereBetween('ride_time', [$from, $to])->orderBy('id', 'desc')->with('driver')->paginate($this->limit);
			return response()->json(['success' => true, 'message' => 'get successfully', 'data' => $rides], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function saveUserData(Request $request)
	{
		try {
			$rules = [
				'phone_number' => 'required_without_all:first_name,last_name,email',
				// 'first_name' => 'required',
				// 'country_code' => 'required',
				// 'phone_number' => 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}
			$input = $request->all();
			if (!empty($_FILES['image'])) {
				if (isset($_FILES['image']) && $_FILES['image']['name'] !== '' && !empty($_FILES['image']['name'])) {
					$ext = $request->image->extension();
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
					if (!in_array($ext, $arr_ext)) {
						return response()->json(['success' => false, 'message' => "Please upload a valid Image"], $this->warningCode);
					}
				}
			}
			if (!empty($input['phone_number']) && (!isset($input['email']) || empty($input['email']))) {
				$checkuserPhnEml =  \App\User::where([['country_code', '=', $input['country_code']], ['phone', '=', ltrim($input['phone_number'], "0")]])->where(['user_type' => 1])->first();
				if($checkuserPhnEml){
					return response()->json(['message' => "This user's phone number already exists.", 'error' => "This user's phone number already exists."], $this->warningCode);
				}
			} else if (!empty($input['email']) && (!isset($input['phone_number']) || empty($input['phone_number']))) {
				$checkuserPhnEml =  \App\User::where(['email' => $input['email'], 'user_type' => 1])->first();
				if($checkuserPhnEml){
					return response()->json(['message' => "This user's email already exists.", 'error' => "This user's email already exists."], $this->warningCode);
				}
			} elseif (!empty($input['email']) && !empty($input['phone_number'])) {
				$checkuserPhnEml =  \App\User::where(['user_type' => 1])->where(function($query) use($input){
					$query->where(['email' => $input['email']]);
					$query->orWhere(function($query1) use($input){
						$query1->where(['country_code' => $input['country_code'], 'phone' => ltrim($input['phone_number'], "0")]);
					});
				})->first();
				if (!empty($checkuserPhnEml)) {
					return response()->json(['message' => "This user's email or phone number already exists.", 'error' => "This user's email or phone number already exists."], $this->warningCode);
				}
			}

			$input['phone'] = ltrim($request->phone_number, "0");
			$input['email'] = $request->email;
			$input['addresses'] = $request->addresses;
			$input['country_code'] = ltrim($request->country_code,"+");
			$input['refer_user_id'] = Auth::user()->id;
			$input['first_name'] = $request->first_name;
			$input['last_name'] = $request->last_name;
			$input['country'] = $request->country;
			$input['state'] = $request->state;
			$input['city'] = $request->city;
			$input['zip'] = $request->zip;
			$input['created_by'] = Auth::user()->id;
			$input['user_type'] = 1;
			$record = \App\User::create($input);
			if (!empty($_FILES['image'])) {
				if (isset($_FILES['image']) && $_FILES['image']['name'] !== '' && !empty($_FILES['image']['name'])) {
					$imageName = 'profile-image' . time() . '.' . $request->image->extension();
					$record->image = Storage::disk('public')->putFileAs(
						'user/' . $record->id,
						$request->image,
						$imageName
					);
					$record->save();
				}
			}
			$newData = User::find($record->id);
			return response()->json(['success' => true, 'message' => 'User data was successfully saved.', 'data' => $newData], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()."------".$exception->getLine()], $this->warningCode);
		}
	}

	public function updateUserData(Request $request)
	{
		if (isset($request['id'])) {
			$user = User::find($request['id']);
		} else {
			$user = Auth::user();
		}
		try {
			// $rules = [
			// 	'first_name' => 'required',
			// 	'country_code' => 'required',
			// 	'phone_number' => 'required',
			// ];

			// $validator = Validator::make($request->all(), $rules);
			// if ($validator->fails()) {
			// 	return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			// }
			$input = $request->all();
			$user_id = $user->id;

			if (!empty($input['email'])) {
				$alreadyExist = User::where(['email' => $input['email'], 'user_type' => $user->user_type])->where('user_type', '!=', $user->user_type)->where('id', '!=', $user_id)->first();
				if ($alreadyExist) {
					return response()->json(['success' => false, 'message' => "An email address has already been assigned to another user"], $this->warningCode);
				} else {
					$user['email'] = $input['email'];
				}
			}

			if (!empty($_FILES['image'])) {
				if (isset($_FILES['image']) && $_FILES['image']['name'] !== '' && !empty($_FILES['image']['name'])) {
					$ext = $request->image->extension();
					$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions

					if (in_array($ext, $arr_ext)) {
						$imageName = 'profile-image'.time().'.' . $request->image->extension();
						if (!empty($user['image'])) {
							Storage::disk('public')->delete($user['image']);
						}
						$user['image'] = Storage::disk('public')->putFileAs(
							'user/' . $user['id'],
							$request->image,
							$imageName
						);
					} else {
						return response()->json(['success' => false, 'message' => "Please upload a valid Image"], $this->warningCode);
					}
				}
			}
			if ($request->has('first_name')) {
				$user['first_name'] = $input['first_name'];
			}
			if ($request->has('last_name')) {
				$user['last_name'] = $input['last_name'];
			}
			if ($request->has('city')) {
				$user['city'] = $input['city'];
			}
			if ($request->has('state')) {
				$user['state'] = $input['state'];
			}
			if ($request->has('zip')) {
				$user['zip'] = $input['zip'];
			}
			if ($request->has('location')) {
				$user['location'] = $input['location'];
			}
			if ($request->has('country')) {
				$user['country'] = $input['country'];
			}
			if ($request->has('addresses')) {
				$user['addresses'] = $input['addresses'];
			}
			if ($request->has('street')) {
				$user['street'] = $input['street'];
			}
			if ($request->has('second_country_code')) {
				$user['second_country_code'] = $input['second_country_code'];
			}
			if ($request->has('second_phone_number')) {
				$user['second_phone_number'] = $input['second_phone_number'];
			}
			if ($request->has('phone_number')) {
				$user['phone'] = $input['phone_number'];
			}
			if ($request->has('country_code')) {
				$user['country_code'] = $input['country_code'];
			}
			if ($request->has('name')) {
				$user['name'] = $input['name'];
			}
			$user->save();
			$userData = $this->getRafrenceUser($user_id);
			return response()->json(['success' => true, 'message' => 'User data was successfully saved.', 'user' => $userData], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function addStopover(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'location_name' => 'required',
			'lat' => 'required',
			'lng' => 'required',
			'ride_id' => 'required',

		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {

			$stopover = new Stopover();

			$stopover->location_name = $request->location_name;
			$stopover->ride_id = $request->ride_id;
			$stopover->lat = $request->lat;
			$stopover->lng = $request->lng;



			$stopover->user_id = $user_id;
			unset($stopover->created_at);
			unset($stopover->updated_at);
			//print_r($place); die;
			$stopover->save();


			return response()->json(['message' => 'Stopover Added successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function settings(Request $request)
	{
		$user = Auth::user();
		$payment_method = PaymentMethod::where(['service_provider_id' => $user->service_provider_id])->get();
		$settings = Setting::where(['service_provider_id' => $user->service_provider_id])->first();
		$settingValue = json_decode($settings['value']);
		return response()->json(['message' => 'Success', 'payment_method' => $payment_method, 'currency_symbol' => $settingValue->currency_symbol, 'currency_name' => $settingValue->currency_name, 'driver_count_to_display' => $settingValue->driver_count_to_display], $this->successCode);
	}

	public function rideAssignstoNext(Request $request)
	{
		echo "function working";
	}

	public function homedriverList(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'pick_lat' => 'required',
			'pick_lng' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			$lat = $request->pick_lat;
			$lon = $request->pick_lng;

			$radius = 50;
			$driverlimit = 3;
			if (!empty($user->service_provider_id)) {
				$settings = Setting::where(['service_provider_id' => $user->service_provider_id])->first();
				$settingValue = json_decode($settings['value']);
				$radius = $settingValue->radius;
				$driverlimit = $settingValue->driver_requests;
			}
			$query = User::select("users.id", "users.first_name", "users.last_name", "users.image", "users.current_lat", "users.current_lng", DB::raw("6371 * acos(cos(radians(" . $lat . "))
                    * cos(radians(users.current_lat))
                    * cos(radians(users.current_lng) - radians(" . $lon . "))
                    + sin(radians(" . $lat . "))
                    * sin(radians(users.current_lat))) AS distance"));
			if (!empty($user->service_provider_id)) {
				$query->where(['service_provider_id' => $user->service_provider_id]);
			}
			$query->where([['user_type', '=', 2], ['availability', '=', 1]])->having('distance', '<', $radius)->orderBy('distance', 'asc')->limit($driverlimit);
			$drivers = $query->get()->toArray();

			if (!empty($drivers)) {
				return response()->json(['message' => 'Driver Listed successfully', 'data' => $drivers], $this->successCode);
			} else {
				return response()->json(['message' => 'No Driver Found'], $this->warningCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function sendRidetoMaster(Request $request)
	{
		// If no driver will accept then ride will sent to all master drivers
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'ride_id' => 'required',

		];
		$ride_data = Ride::query()->where([['id', '=', $request->ride_id]])->first();
		$rideid = $request->ride_id;
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			$master_drivers = User::query()->where([['user_type', '=', 2], ['is_master', '=', 1], ['availability', '=', 1]])->get()->toArray();
			$driverids = array();
			if (!empty($master_drivers)) {
				foreach ($master_drivers as $master_driver) {
					$ride = Ride::query()->where([['id', '=', $request->ride_id]])->first();
					$ride->status = -4;
					//print_r($input); die;
					$ride->save();







					$driverids[] = $master_driver['id'];
				}
			} else {
				return response()->json(['message' => 'No Master Driver Found'], $this->warningCode);
			}


			if (!empty($driverids)) {
				$driverids = implode(",", $driverids);
			} else {
				return response()->json(['message' => "No Driver Found"], $this->warningCode);
			}




			$driverids = explode(",", $driverids);
			//print_r($driverids); die;
			/* echo "ride data :";
		print_r($ride_data); die; */
			foreach ($driverids as $driverid) {
				$driver_id = $driverid;
				$user_data = User::select('id', 'first_name', 'last_name', 'image', 'country_code', 'phone')->where('id', $ride_data['user_id'])->first();

				$driver_data = User::select('id', 'first_name', 'last_name', 'image', 'current_lat', 'current_lng', 'device_token', 'device_type', 'country_code', 'phone', 'user_type')->where('id', $driverid)->first();
				$driver_car = DriverChooseCar::where('user_id', $driver_data['id'])->first();
				$car_data = Vehicle::select('id', 'model', 'vehicle_image', 'vehicle_number_plate')->where('id', $driver_car['id'])->first();
				$driver_data['car_data'] = $car_data;
				$title = 'Pending Ride';
				$message = 'No Driver Accepted Ride';


				$deviceToken = $driver_data['device_token'];
				$type = 9;
				$ride_data['user_data'] = $user_data;
				$settings = \App\Setting::first();
				$settingValue = json_decode($settings['value']);
				$ride_data['waiting_time'] = $settingValue->waiting_time;
				/* echo "ride data :";
		print_r($ride); */
				$additional = ['type' => $type, 'ride_id' => $rideid, 'ride_data' => $ride_data];


				$deviceType = $driver_data['device_type'];
				if ($deviceType == 'android') {
					send_notification($title, $message, $deviceToken, '', $additional, true, false, $deviceType, []);
					$notification = new Notification();
					$notification->title = $title;
					$notification->description = $message;
					$notification->type = $type;
					$notification->user_id = $driver_data['id'];
					$notification->save();
				}
				if ($deviceType == 'ios') {
					/* $deviceToken = $driver_data['device_token'];
		send_iosnotification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]); */
					$user_type = $driver_data['user_type'];

					/* echo "Driver id : ".$driver_data['id'];
		echo "User type : $user_type"; */
					ios_notification($title, $message, $deviceToken, $additional, $sound = 'default', $user_type);
					$notification = new Notification();
					$notification->title = $title;
					$notification->description = $message;
					$notification->type = $type;
					$notification->user_id = $driver_data['id'];
					$notification->save();
				}
			}

			return response()->json(['message' => 'Request sent successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function driverlistforMaster(Request $request)
	{
		$user = Auth::user();
		$rules = [
			'ride_id' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try
        {
			$ride_data = Ride::find($request->ride_id);
			if (!$ride_data)
            {
				return response()->json(['message' => 'No such ride exist'], $this->warningCode);
			}
			$lat = $ride_data['pick_lat'];
			$lon = $ride_data['pick_lng'];

			$settings = Setting::where('service_provider_id',$user->service_provider_id)->first();
			$settingValue = json_decode($settings['value']);
			$driverlimit = $settingValue->driver_requests;

			if (!empty($lat) && !empty($lon)) {

				$driver_radius = $settingValue->radius;
				$query = User::select(
					"users.*",
					"vehicles.model",
					"vehicles.vehicle_number_plate",
					"vehicles.vehicle_image",
					DB::raw("3959 * acos(cos(radians(" . $lat . "))
					* cos(radians(users.current_lat))
					* cos(radians(users.current_lng) - radians(" . $lon . "))
					+ sin(radians(" . $lat . "))
					* sin(radians(users.current_lat))) AS distance")
				);
				$query->leftJoin('driver_choose_cars', function ($join) {
					$join->on('users.id', '=', 'driver_choose_cars.user_id')->where('driver_choose_cars.logout', '=', '0');
				})
                ->leftJoin('vehicles', function ($join) {
                    $join->on('driver_choose_cars.car_id', '=', 'vehicles.id');
                });
				$query->where([['user_type', '=', 2]])->where('users.service_provider_id',$user->service_provider_id)->orderBy('distance', 'asc');
				// ->limit($driverlimit);
				//$query->where('user_type', '=',2)->orderBy('distance','asc');
				$drivers = $query->get();
			} else {
				$query = User::where([['user_type', '=', 2]])->where('users.service_provider_id',$user->service_provider_id)->orderBy('created_at', 'desc');
				// ->limit($driverlimit);
				//$query->where('user_type', '=',2)->orderBy('distance','asc');
				$drivers = $query->get();
			}
			//$drivers = User::query()->where([['user_type', '=', 2],['is_master', '=', 0]])->get()->toArray();
			if (!empty($drivers)) {
				$end_date_time = Carbon::now()->addMinutes(2)->format("Y-m-d H:i:s");
				foreach ($drivers as $driver_key => $driver_value) {
					$count_of_assign_rides = Ride::where(['driver_id' => $driver_value->id])->where('ride_time', '<=', $end_date_time)->where(function ($query) {
						$query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
					})->count();
					$drivers[$driver_key]['already_have_ride'] = $count_of_assign_rides ? 1 : 0;
					if (empty($lat) || $driver_value->availability == 0){
						$drivers[$driver_key]->distance = 0;
					}
					$drivers[$driver_key]->car_data = $driver_value->car_data;
				}
				return response()->json(['message' => 'Driver Listed successfully', 'data' => $drivers], $this->successCode);
			} else {
				return response()->json(['message' => 'No Driver Found'], $this->warningCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage() . "---" . $exception->getLine()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage() . "---" . $exception->getLine()], $this->warningCode);
		}
	}

	public function assigndrivertoRide(Request $request)
	{
		$rules = [
			'ride_id' => 'required',
			'driver_id' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			$previousRideData = Ride::find($request->ride_id);
			$ride_data = Ride::find($request->ride_id);
			$ride_data->driver_id = $request->driver_id;
			$ride_data->status = 0;

			if ($ride_data->save()) {
				$ride = Ride::find($request->ride_id);
				$currentTime = Carbon::now()->format('Y-m-d H:i:s');
				if(!empty($ride->alert_time)){
					$rideAlertTime = date('Y-m-d H:i:s', strtotime('-' . $ride->alert_time . ' minutes', strtotime($ride->ride_time)));
				} else {
					$rideAlertTime = date('Y-m-d H:i:s', strtotime('-15 minutes', strtotime($ride->ride_time)));
				}
				if ($rideAlertTime > $currentTime) {
					$rideDetail = Ride::find($request->ride_id);
					$rideDetail->alert_notification_date_time = $rideAlertTime;
					$rideDetail->save();
				} else {
					$ride = new RideResource(Ride::find($request->ride_id));
					$settings = \App\Setting::first();
					$settingValue = json_decode($settings['value']);
					$ride['waiting_time'] = $settingValue->waiting_time;
					$title = 'New Ride';
					$message = 'Master Driver have assigned new Ride';
					$driverdata = User::find($request->driver_id);
					$deviceToken = $driverdata['device_token'];
					$ride_id = $request->ride_id;
					if ($ride['ride_type'] == 1) {
						$type = 11;
					} else {
						$type = 10;
					}

					$deviceType = $driverdata['device_type'];
					$additional = ['type' => $type, 'ride_id' => $ride_id, 'ride_data' => $ride];
					if (!empty($deviceToken)) {
						if ($deviceType == 'android') {
							bulk_firebase_android_notification($title, $message, [$deviceToken], $additional);
						}
						if ($deviceType == 'ios') {
							bulk_pushok_ios_notification($title, $message, [$deviceToken], $additional, $sound = 'default', $driverdata['user_type']);
						}
					}

					$rideDetail = Ride::find($request->ride_id);
					$rideDetail->check_assigned_driver_ride_acceptation = date('Y-m-d H:i:s', strtotime('+' . $settingValue->waiting_time . ' seconds '));
					$rideDetail->save();

					$notification = new Notification();
					$notification->title = $title;
					$notification->description = $message;
					$notification->type = $type;
					$notification->user_id = $driverdata['id'];
					$notification->additional_data = json_encode($additional);
					$notification->save();

					RideHistory::create(['ride_id' => $request->ride_id, 'driver_id' => $request->driver_id, 'status' => '2']);
				}
				$ride_detail = new RideResource(Ride::find($request->ride_id));
				if (!empty($previousRideData->driver_id) && ($previousRideData->driver_id != $request->driver_id) && $previousRideData->status != 0) {
					$settings = Setting::first();
                    $settingValue = json_decode($settings['value']);
                    $ride_detail['waiting_time'] = $settingValue->waiting_time;

					$driverData = User::find($previousRideData->driver_id);
					$deviceToken = $driverData['device_token'] ?? "";
					$deviceType = $driverData['device_type'] ?? "";
					$title = 'Ride Reassign';
					$message = "Your ride has been reassigned";
					$type = 17;

					$additional = ['type' => $type, 'ride_id' => $ride->id, 'ride_data' => $ride_detail];
					if (!empty($deviceToken)) {
						if ($deviceType == 'android') {
							bulk_firebase_android_notification($title, $message, [$deviceToken], $additional);
						}
						if ($deviceType == 'ios') {
							bulk_pushok_ios_notification($title, $message, [$deviceToken], $additional, $sound = 'default', $driverData['user_type']);
						}
					}

					$notification = new Notification();
					$notification->title = $title;
					$notification->description = $message;
					$notification->type = $type;
					$notification->user_id = $driverData->id;
					$notification->additional_data = json_encode($additional);
					$notification->save();
				}
				return response()->json(['message' => 'Driver Assigned Successfully', 'data' => $ride_detail], $this->successCode);
			} else {
				return response()->json(['message' => 'Something went wrong'], $this->warningCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function unassigndrivertoRide(Request $request)
	{
		$user = Auth::user();
		$user_id = $user['id'];
		$rules = [
			'ride_id' => 'required',
		];

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => trans('api.required_data'), 'error' => $validator->errors()], $this->warningCode);
		}

		try {
			$ride_data = Ride::find($request->ride_id);
			$ride_data->driver_id = null;
			$ride_data->all_drivers = null;
			$ride_data->status = 0;
			if ($ride_data->save()) {
				// $lat = $ride_data['pick_lat'];
				// $lon = $ride_data['pick_lng'];
				// if (!empty($lat) && !empty($lon)) {
				// } else {
				// 	return response()->json(['message' => "No Driver Found"], $this->warningCode);
				// }
				// $settings = \App\Setting::first();
				// $settingValue = json_decode($settings['value']);
				// $driverlimit = $settingValue->driver_requests;
				// $driver_radius = $settingValue->radius;
				// $query = User::select(
				// 	"users.*",
				// 	DB::raw("3959 * acos(cos(radians(" . $lat . "))
                //     * cos(radians(users.current_lat))
                //     * cos(radians(users.current_lng) - radians(" . $lon . "))
                //     + sin(radians(" . $lat . "))
                //     * sin(radians(users.current_lat))) AS distance")
				// );
				// $query->where([['user_type', '=', 2], ['availability', '=', 1]])->having('distance', '<', $driver_radius)->orderBy('distance', 'asc')->limit($driverlimit);
				// //$query->where('user_type', '=',2)->orderBy('distance','asc');
				// $drivers = $query->get()->toArray();

				// $driverids = array();

				// if (!empty($drivers)) {
				// 	foreach ($drivers as $driver) {
				// 		$driverids[] = $driver['id'];
				// 		$socket_id = $driver['socket_id'];
				// 	}
				// } else {
				// 	return response()->json(['message' => "No Driver Found"], $this->warningCode);
				// }
				// if (!empty($driverids)) {
				// 	$driverids = implode(",", $driverids);
				// } else {
				// 	return response()->json(['message' => "No Driver Found"], $this->warningCode);
				// }
				// $ride = Ride::query()->where([['id', '=', $request->ride_id]])->first();
				// $ride->driver_id = $driverids;
				// $ride->all_drivers = $driverids;

				// $ride->save();
				// $rideid = $ride->id;
				// $ride = Ride::query()->where([['id', '=', $rideid]])->first();
				// $ride_data = Ride::query()->where([['id', '=', $rideid]])->first();
				// if (!empty($ride_data['ride_cost'])) {
				// 	$ride_data['price'] = $ride_data['ride_cost'];
				// }
				// $driverids = explode(",", $driverids);
				// foreach ($driverids as $driverid) {
				// 	$driver_id = $driverid;
				// 	$user_data = User::select('id', 'first_name', 'last_name', 'image', 'country_code', 'phone')->where('id', $ride_data['user_id'])->first();

				// 	$driver_data = User::select('id', 'first_name', 'last_name', 'image', 'current_lat', 'current_lng', 'device_token', 'device_type', 'country_code', 'phone', 'user_type')->where('id', $driverid)->first();
				// 	$driver_car = DriverChooseCar::where('user_id', $driver_data['id'])->first();
				// 	$car_data = Vehicle::select('id', 'model', 'vehicle_image', 'vehicle_number_plate')->where('id', $driver_car['id'])->first();
				// 	$driver_data['car_data'] = $car_data;
				// 	$title = 'New Booking';
				// 	$message = 'You Received new booking';

				// 	$deviceToken = $driver_data['device_token'];
				// 	$type = 1;
				// 	$ride_data['user_data'] = $user_data;
				// 	$settings = \App\Setting::first();
				// 	$settingValue = json_decode($settings['value']);
				// 	$ride_data['waiting_time'] = $settingValue->waiting_time;
				// 	$additional = ['type' => $type, 'ride_id' => $rideid, 'ride_data' => $ride_data];

				// 	$deviceType = $driver_data['device_type'];
				// 	if ($deviceType == 'android') {
				// 		send_notification($title, $message, $deviceToken, '', $additional, true, false, $deviceType, []);
				// 		$notification = new Notification();
				// 		$notification->title = $title;
				// 		$notification->description = $message;
				// 		$notification->type = $type;
				// 		$notification->user_id = $driver_data['id'];
				// 		$notification->save();
				// 	}
				// 	if ($deviceType == 'ios') {
				// 		$user_type = $driver_data['user_type'];
				// 		ios_notification($title, $message, $deviceToken, $additional, $sound = 'default', $user_type);
				// 		$notification = new Notification();
				// 		$notification->title = $title;
				// 		$notification->description = $message;
				// 		$notification->type = $type;
				// 		$notification->user_id = $driver_data['id'];
				// 		$notification->save();
				// 	}
				// }
				$ride_detail = Ride::select('id', 'note', 'pick_lat', 'pick_lng', 'pickup_address', 'dest_address', 'dest_lat', 'dest_lng', 'distance', 'passanger', 'ride_cost', 'ride_time', 'ride_type', 'waiting', 'created_by', 'status', 'user_id', 'driver_id', 'payment_type', 'alert_time', 'car_type', 'company_id', 'vehicle_id', 'parent_ride_id', 'created_at')->with(['user:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'driver:id,first_name,last_name,country_code,phone,current_lat,current_lng,image', 'company_data:id,name,logo,state,city,street,zip,country', 'car_data:id,model,vehicle_image,vehicle_number_plate,category_id', 'car_data.carType:id,car_type,car_image', 'vehicle_category:id,car_type,car_image'])->find($request->ride_id);
				return response()->json(['message' => 'Ride Unassigned successfully', 'data' => $ride_detail], $this->successCode);
			} else {
				return response()->json(['message' => 'Something went wrong'], $this->warningCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function onlineDrivers(Request $request)
	{
		$resultArr = array();
		$userObj = Auth::user();

		if (!$userObj) {
			return $this->notAuthorizedResponse('User is not authorized');
		}

		$resultArr['count'] = User::where('user_type', 2)->where('availability', 1);
        if($userObj->service_provider_id)
        {
            $resultArr['count']->where('service_provider_id',$userObj->service_provider_id);
        }
        $resultArr['count'] = $resultArr['count']->count();
		$resultArr['data'] = User::select(['users.*', 'vehicles.model', 'vehicles.vehicle_number_plate', 'vehicles.vehicle_image'])
			->leftJoin('driver_choose_cars', function ($join) {
				$join->on('users.id', '=', 'driver_choose_cars.user_id')->where('driver_choose_cars.logout', '=', '0');
			})
			->leftJoin('vehicles', function ($join) {
				$join->on('driver_choose_cars.car_id', '=', 'vehicles.id');
			})->where('users.availability', 1);
        if($userObj->service_provider_id)
        {
            $resultArr['data']->where('users.service_provider_id',$userObj->service_provider_id);
        }
        $resultArr['data'] = $resultArr['data']->orderBy('users.id', 'DESC')->get();
		// $end_date_time = Carbon::now()->addMinutes(2)->format("Y-m-d H:i:s");
		// ->where('ride_time', '<=', $end_date_time)
		foreach ($resultArr['data'] as $driver_key => $driver_value) {
			if(!empty($driver_value->vehicle_image)){
				$resultArr['data'][$driver_key]['vehicle_image'] = env('URL_PUBLIC').'/'.$driver_value->vehicle_image;
			}
			$count_of_assign_rides = Ride::where(['driver_id' => $driver_value->id])->where(function ($query) {
				$query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
			})->count();
			$resultArr['data'][$driver_key]->already_have_ride = $count_of_assign_rides ? 1 : 0;
			$resultArr['data'][$driver_key]->car_data = $driver_value->car_data;
		}
		return $this->successResponse($resultArr, 'Get online drivers successfully');
	}

	public function onlineDriversList(Request $request)
	{
		$userObj = Auth::user();

		$resultArr = User::with(['driver_choosen_car' => function ($query) {
			$query->where('logout','=',0);
		}])->with('driver_choosen_car.vehicle')->whereHas('driver_choosen_car', function ($query) {
			$query->where('logout','=',0);
		})->where('users.availability', 1)->orderBy('users.id', 'DESC')->get();

		foreach ($resultArr as $driver_key => $driver_value) {
			$count_of_assign_rides = Ride::where(['driver_id' => $driver_value->id])->where(function ($query) {
				$query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
			})->count();
			$resultArr[$driver_key]->already_have_ride = $count_of_assign_rides ? 1 : 0;
		}
		return response()->json(['message' => 'List of online drivers', 'data' => $resultArr], $this->successCode);
	}


	public function getInvoiceUserStatus(Request $request)
	{
		try {
			$rules = [
				'id' => 'required',

			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}
			$input = $request->all();
			$userData = \App\User::select('id', 'invoice_status')->where([['id', '=', $input['id']]])->first();
			return response()->json(['success' => true, 'message' => 'success.', 'date' => $userData], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function getUserById(Request $request)
	{
		$rules = [
			'id' => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
		}

		$result = User::select('*')->where([['id', '=', $request->id]])->first();
		if (!empty($result)) {
			return response()->json(['success' => true, 'message' => 'get successfully', 'data' => $result], $this->successCode);
		} else {

			return response()->json(['message' => "User not found"], $this->warningCode);
		}
	}

	public function all_drivers()
	{
		$user = Auth::user();
		$all_drivers = User::select("id", "first_name", "last_name", "country_code", "phone", "current_lat", "current_lng", "image", "availability")->where(['user_type' => 2])->orderBy('first_name')->get();

		foreach ($all_drivers as $driver_key => $driver_value) {
			$driver_car = DriverChooseCar::with(['vehicle:id,model,vehicle_image,vehicle_number_plate'])->where(['user_id' => $driver_value->id, 'logout' => 0])->first();
			$all_drivers[$driver_key]->car_detail = $driver_car->vehicle??null;
			$all_drivers[$driver_key]['already_have_ride'] = $driver_value->driver_already_on_ride();
		}
		return response()->json(['success' => true, 'message' => 'List of all drivers', 'data' => $all_drivers], $this->successCode);
	}

	public function getUserInfoById(Request $request)
	{
		try {
			$rules = [
				'user_id' => 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}

			$user = User::where([['user_type', '=', 1]])->find($request->user_id);
			if (!empty($user)) {
				$user->full_name = $user->full_name;
				$user->avg_rating = $user->avg_rating;
				$user->app_installed = (!empty($user->password))?1:0;
			}
			return response()->json(['success' => true, 'message' => 'get successfully', 'data' => $user], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function setUsersPassword(Request $request)
	{
		DB::beginTransaction();
		try {
			$rules = [
				'phone_number' => 'required',
				'country_code' => 'required',
				'password' => 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}
			// $user = User::where([['user_type', '=', 1]])->find($request->user_id);
			$user = User::where(['country_code' => ltrim($request->country_code,"+"), 'phone' => ltrim($request->phone_number, "0"), 'user_type' => 1])->first();
			if (!empty($user) && empty($user->password)) {
				$user->password = Hash::make($request->password);
				$user->update();
			}
			else
			{
				return response()->json(['success' => false, 'message' => 'Invalid request'], $this->successCode);
			}
			DB::commit();
			return response()->json(['success' => true, 'message' => 'Password changed successfully'], $this->successCode);
			// all good
		} catch (\Exception $e) {
			DB::rollback();
			// something went wrong
			return response()->json(['message' => $e->getMessage()], $this->warningCode);
		}
	}

	public function make_driver_logout(Request $request)
	{
		try {
			$rules = [
				'driver_id' => 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			}
			$logged_in_user = Auth::user();
			if ($logged_in_user->is_master == 0) {
				return response()->json(['status' => 0, 'message' => "You are not authorised for this operation."], $this->warningCode);
			}
			DB::beginTransaction();
			User::where(['id' => $request->driver_id])->update(['availability' => 0]);
			DB::table('oauth_access_tokens')
			->where(['user_id' => $request->driver_id])
			->delete();
			DriverStayActiveNotification::where(['driver_id' => $request->driver_id])->delete();
			DriverChooseCar::where(['user_id' => $request->driver_id])->where(['logout' => 0])->update(['logout' => 1]);
			DB::commit();
			return response()->json(['status' => 1, 'message' => "Driver has successfully logged out."], 200);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['status' => 0, 'message' => $e->getMessage()], $this->warningCode);
		}
	}


	public function getStatements(Request $request)
	{
		try {
			DB::beginTransaction();
			$rules = [
				'driver_id' => 'required|integer',
				'type' => 'required|string',

			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			} 
			$userId = $request->driver_id;
			$driverData =  User::where('id', $userId)->first();
			if(!$driverData){
				return response()->json(['message' => "Driver not found"], $this->warningCode);
			}
		    $service_provider_id  =$driverData->service_provider_id;
			
			if($request->type == 'daily'){
				
				$data  = Expense::select(DB::raw('SUM(revenue) as total_revenue'), 'date','driver_id','service_provider_id',DB::raw('SUM(salary) as salary'),DB::raw('SUM(deductions) as deductions'),DB::raw('SUM(amount) as expense'))
				->where('driver_id',$userId)->where('service_provider_id',$service_provider_id)->groupBy('date')->orderBy('date','desc')->paginate(10);	
				
			}else if($request->type == 'weekly'){
				$data = Expense::select(DB::raw('SUM(revenue) as total_revenue'), DB::raw('WEEK(date,1) as week_number'),'driver_id','service_provider_id','date',DB::raw('SUM(salary) as salary'),DB::raw('SUM(deductions) as deductions'),DB::raw('SUM(amount) as expense'))
				->where('driver_id',$userId)->where('service_provider_id',$service_provider_id)->orderBy('date','desc')->groupBy( DB::raw('WEEK(date,1)'))
				->paginate(10);
				
			}else if($request->type == 'monthly'){
				$data = Expense::select(DB::raw('SUM(revenue) as total_revenue'), DB::raw('MONTH(date) as month'),'driver_id','service_provider_id','date',DB::raw('SUM(salary) as salary'),DB::raw('SUM(deductions) as deductions'),DB::raw('SUM(amount) as expense'))
				->where('driver_id',$userId)->where('service_provider_id',$service_provider_id)->orderBy('date','desc')
				->groupBy(DB::raw('MONTH(date)'))
				->paginate(10);
				
			}
			
			if (!empty($data)) {
				return response()->json(['success' => true, 'message' => 'get successfully',  'data' => $data], $this->successCode);
			} else {
				return response()->json(['message' => 'Record Not found'], $this->successCode);
			}
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}
	public function getStatementDetail(Request $request)
	{
		try {
			DB::beginTransaction();
			$rules = [
				'driver_id' => 'required|integer',
				'type' => 'required|string',
				'date' => 'required',
				'month' => 'required_if:type,monthly',
				'week_number' => 'required_if:type,weekly',

			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
			} 
			$userId = $request->driver_id;
			$driverData =  User::where('id', $userId)->first();
			if(!$driverData){
				return response()->json(['message' => "Driver not found"], $this->warningCode);
			}
		    $service_provider_id  =$driverData->service_provider_id;
			$detailArray = [];
			if($request->type == 'weekly'){
				$carbonDate = Carbon::parse($request->date);
				$year = $carbonDate->year;
				$weekNumber = $request->week_number;
				$weeklyData = Expense::select('type','type_detail','amount','salary','deductions','revenue')->where(DB::raw("YEARWEEK(date, 1)"), '=', "{$year}{$weekNumber}")
				->where('driver_id',$userId)->where('service_provider_id',$service_provider_id)->get()->toArray();
				
				$this->loopingForStatements($weeklyData,$detailArray);

			}

			if($request->type == 'monthly'){
				$carbonDate = Carbon::parse($request->date);
				$selectedYear = $carbonDate->year;
				$month = $request->month;
				$monthlyData = Expense::select('type','type_detail','amount','salary','deductions','revenue')->whereYear('date', $selectedYear)
				->whereMonth('date', $month)->where('driver_id',$userId)->where('service_provider_id',$service_provider_id)
				->get()->toArray();

				$this->loopingForStatements($monthlyData,$detailArray);

			}
			if($request->type == 'daily'){
				$dailyData = Expense::select('type','type_detail','amount','salary','deductions','revenue')
				->where('date', $request->date)->where('driver_id',$userId)->where('service_provider_id',$service_provider_id)
				->get()->toArray();
				$this->loopingForStatements($dailyData,$detailArray);
			}

			if (!empty($detailArray)) {
				$detailArray['driver_id'] = $userId;
				$detailArray['type'] = $request->type;
				return response()->json(['success' => true, 'message' => 'get successfully',  'data' => $detailArray], $this->successCode);
			} else {
				return response()->json(['message' => 'Record Not found'], $this->successCode);
			}

		} catch (\Illuminate\Database\QueryException $exception) {
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		} catch (\Exception $exception) {
			return response()->json(['message' => $exception->getMessage()], $this->warningCode);
		}
	}

	public function loopingForStatements($userData, &$detailArray)
	{
		try{
			
				foreach($userData as $single){
					if($single['type'] == 'salary'){
						$detailArray['salary'] =  $single['salary'];
					}else if($single['type'] == 'revenue'){
					
						$this->createStatementData($single, $detailArray,'revenue');
						
					}else if($single['type'] == 'deduction'){
						
						$this->createStatementData($single, $detailArray,'deductions');
					}
					else if($single['type'] == 'expense'){
						
						$this->createStatementData($single, $detailArray,'amount');
					}
				}

			} catch (\Illuminate\Database\QueryException $exception) {
				$errorCode = $exception->errorInfo[1];
				return response()->json(['message' => $exception->getMessage()], $this->warningCode);
			} catch (\Exception $exception) {
				return response()->json(['message' => $exception->getMessage()], $this->warningCode);
			}
					
					
	}


public function createStatementData($single, &$detailArray,$type)
{
	try{
		if (array_key_exists(strtolower($single['type_detail']) , $detailArray)) {
			$detailArray[strtolower($single['type_detail'])] = $detailArray[strtolower($single['type_detail'])] + $single[$type];
		}else{
			$detailArray[strtolower($single['type_detail'])] =  $single[$type];
		}
	} catch (\Illuminate\Database\QueryException $exception) {
		$errorCode = $exception->errorInfo[1];
		return response()->json(['message' => $exception->getMessage()], $this->warningCode);
	} catch (\Exception $exception) {
		return response()->json(['message' => $exception->getMessage()], $this->warningCode);
	}
}

}
