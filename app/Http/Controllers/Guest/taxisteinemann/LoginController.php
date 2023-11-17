<?php

namespace App\Http\Controllers\Guest\taxisteinemann;

use App\Http\Controllers\Controller;
use App\OtpVerification;
use App\Price;
use App\SMSTemplate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\GuestRegisterRequest;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        Auth::logout();
        return view('company.login');
    }

    public function guestLogin()
    {

        if (Auth::check() && Auth::user()->user_type == 1) {
            Auth::user()->syncRoles('Customer');
            return redirect()->route('guest.taxisteinemann.rides', 'month');
        }

        $breadcrumb = array('title' => 'Home', 'action' => 'Login');
        $vehicle_types = Price::orderBy('sort')->get();
        $data = [];

        $data = array_merge($breadcrumb, $data);
        $data['vehicle_types'] = $vehicle_types;
        return view('guest.taxisteinemann.auth.login')->with($data);
    }

    public function doLoginGuest(Request $request)
    {
        $rules = [
            'phone' => 'required',
            'country_code' => 'required',
            'password' => 'required|min:6',
        ];
        $request->validate($rules);
        $input = $request->all();

        //$whereData = array('phone' => '7355551203', 'country_code' => '91', 'password' => '123456');
        //$whereData = array('email' => 'suryamishra20794@gmail.com', 'password' => '123456');
        $phone_number = str_replace(' ', '', ltrim($request->phone, "0"));

        $user = User::where('phone', $phone_number)->where('country_code', $request->country_code)->where('user_type', 1)->first();
        //dd(Hash::check($request->password, $user->password));
        if (!empty($user) && Hash::check($request->password, $user->password)) {
            \Auth::login($user);
            if (in_array(Auth::user()->user_type, [1])) {
                Auth::user()->syncRoles('Customer');
                return redirect()->route('guest.taxisteinemann.rides', 'month');
            }
            Auth::logout();
            return redirect()->back()->withInput(array('phone' => $request->phone, 'country_code' => $request->country_code))->withErrors(['message' => 'These credentials do not match our records.']);
        } else {
            Auth::logout();
            return redirect()->back()->withInput(array('phone' => $request->phone, 'country_code' => $request->country_code))->withErrors(['message' => 'Please check your credentials and try again.']);
        }
    }

    public function guestRegister()
    {
        $breadcrumb = array('title' => 'Home', 'action' => 'Login');
        $data = [];
        $data = array_merge($breadcrumb, $data);
        return view('guest.taxisteinemann.auth.register')->with($data);
    }

	public function doRegisterGuest(GuestRegisterRequest $request)
	{
		try {
			if ($request->isMethod('post')) {
				DB::beginTransaction();
				$input = $request->all();
				$input['password'] = Hash::make($request->input('password'));
				$input['user_type'] = 1;

				$phone_number = str_replace(' ', '', ltrim($request->phone, "0"));
				$input['phone'] = $phone_number;
				//$otp = rand(1000,9999);
				unset($input['_token']);
				unset($input['confirm_password']);

				$user = User::where('phone', $phone_number)->where('country_code', $request->country_code)->where('user_type', 1)->where(function($query){
					$query->where('password','!=','');
					$query->whereNotNull('password');
				})->first();
				if ($user) {
					return redirect()->back()->withErrors(['message' => 'Mobile number already has been taken']);
				}
				$user = User::updateOrCreate($input);

				// $expiryMin = config('app.otp_expiry_minutes');
				// $SMSTemplate = SMSTemplate::find(3);
				// $body = str_replace('#OTP#',$otp,$SMSTemplate->english_content);//"Dear User, your Veldoo verification code is ".$otp.". Use this password to complete your booking";
				// if (app()->getLocale()!="en")
				// {
				// 	$body = str_replace('#OTP#',$otp,$SMSTemplate->german_content);
				// }
				// $this->sendSMS("+".$request->country_code, ltrim($request->phone, "0"), $body);
				// $endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');
				// \App\OtpVerification::create(
				// 	['phone'=> ltrim($request->phone, "0"),
				// 	'otp' => $otp,
				// 	'expiry'=>$endTime,
				// 	'country_code'=>$request->country_code
				// 	]
				// );

				DB::commit();

				\Auth::login($user);
				if (in_array(Auth::user()->user_type, [1])) {
					Auth::user()->syncRoles('Customer');
					return redirect()->route('guest.taxisteinemann.rides', 'month');
				}
				//return redirect()->to(url('verify-otp?phone='.$request->phone.'&code='.$request->country_code));
			}
			return view('guest.taxisteinemann.register');
		} catch (\Exception $e) {
			DB::rollback();
			echo $e->getMessage();
			die;
			// something went wrong
		}
	}

    public function send_otp_before_register(Request $request)
    {
        try {
            $expiryMin = config('app.otp_expiry_minutes');
            $otp = rand(1000, 9999);
            $phone_number = $this->phone_number_trim($request->phone);
            $userDetail = User::where(['country_code' => $request->country_code, 'phone' => $phone_number, 'user_type' => 1])->where(function($query){
                $query->where('password','!=','');
                $query->whereNotNull('password');
            })->first();
            if ($userDetail) {
                return response()->json(['status' => 0, 'message' => 'An account has already been registered with this mobile number. Please use the "Forgot Password" option to reset it.']);
            }

            $haveOtp = OtpVerification::where(['country_code' => $request->country_code, 'phone' => $phone_number])->first();
            $now = Carbon::now();
            $endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');
            if ($haveOtp) {
                if ($now->gt($haveOtp->expiry)) {
                    OtpVerification::updateOrCreate(
                        ['country_code' => $request->country_code, 'phone' => $phone_number],
                        ['otp' => $otp, 'expiry' => $endTime, 'device_type' => 'web']
                    );
                } else {
                    $otp = $haveOtp->otp;
                }
            } else {
                OtpVerification::updateOrCreate(
                    ['country_code' => $request->country_code, 'phone' => $phone_number],
                    ['otp' => $otp, 'expiry' => $endTime, 'device_type' => 'web']
                );
            }

            $SMSTemplate = SMSTemplate::find(1);
            $body = str_replace('#OTP#', $otp, $SMSTemplate->english_content); //"Dear User, your Veldoo verification code is ".$otp.". Use this password to complete your booking";
            if (app()->getLocale() != "en") {
                $body = str_replace('#OTP#', $otp, $SMSTemplate->german_content);
            }
            $this->sendSMS("+" . $request->country_code, $phone_number, $body);
            return response()->json(['status' => 1, 'message' => __('OTP is sent to Your Mobile Number')]);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
    }

    public function verify_otp_before_register(Request $request)
    {

        $expiryMin = config('app.otp_expiry_minutes');
        $now = Carbon::now();
        $haveOtp = OtpVerification::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'otp' => $request->otp])->first();

        if (empty($haveOtp)) {
            return response()->json(['status' => 0, 'message' => __('Verification code is incorrect, please try again')]);
        }

        if ($now->diffInMinutes($haveOtp->expiry) < 0) {
            return response()->json(['status' => 0, 'message' => __('Verification code has expired')]);
        }
        $haveOtp->delete();
        return response()->json(['status' => 2, 'message' => __('Verified'), 'code' => $request->country_code, 'phone' => $request->phone, 'otp' => $request->otp]);
    }

    public function send_otp_forgot_password(Request $request)
    {
        try {
            $phone_number = $this->phone_number_trim($request->phone);
            $userInfo = User::where(['country_code' => $request->country_code, 'phone' => (int) filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT), 'user_type' => 1])->first();
            if (!$userInfo) {
                return response()->json(['status' => 0, 'message' => 'The mobile number does not match our records.']);
            }

            $expiryMin = config('app.otp_expiry_minutes');
            $otp = rand(1000, 9999);
            $haveOtp = OtpVerification::where(['country_code' => $request->country_code, 'phone' => $phone_number])->first();
            $now = Carbon::now();
            $endTime = Carbon::now()->addMinutes($expiryMin)->format('Y-m-d H:i:s');
            if ($haveOtp) {
                if ($now->gt($haveOtp->expiry)) {
                    OtpVerification::updateOrCreate(
                        ['country_code' => $request->country_code, 'phone' => $phone_number],
                        ['otp' => $otp, 'expiry' => $endTime, 'device_type' => 'web']
                    );
                } else {
                    $otp = $haveOtp->otp;
                }
            } else {
                OtpVerification::updateOrCreate(
                    ['country_code' => $request->country_code, 'phone' => $phone_number],
                    ['otp' => $otp, 'expiry' => $endTime, 'device_type' => 'web']
                );
            }

            $SMSTemplate = SMSTemplate::find(1);
            $body = str_replace('#OTP#', $otp, $SMSTemplate->english_content); //"Dear User, your Veldoo verification code is ".$otp.". Use this password to complete your booking";
            if (app()->getLocale() != "en") {
                $body = str_replace('#OTP#', $otp, $SMSTemplate->german_content);
            }
            $this->sendSMS("+" . $request->country_code, $phone_number, $body);
            return response()->json(['status' => 1, 'message' => __('OTP is sent to Your Mobile Number')]);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
    }

    public function verify_otp_forgot_password(Request $request)
    {
        $expiryMin = config('app.otp_expiry_minutes');
        $now = Carbon::now();
        $haveOtp = OtpVerification::where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'otp' => $request->otp])->first();

        if (empty($haveOtp)) {
            return response()->json(['status' => 0, 'message' => __('Verification code is incorrect, please try again')]);
        }

        if ($now->diffInMinutes($haveOtp->expiry) < 0) {
            return response()->json(['status' => 0, 'message' => __('Verification code has expired')]);
        }
        $haveOtp->delete();
        $userInfo = User::where(['country_code' => $request->country_code, 'phone' => (int) filter_var($request->phone, FILTER_SANITIZE_NUMBER_INT), 'user_type' => 1])->first();
        if (empty($userInfo->random_token)) {
            $generateRandomString = $this->generateRandomString(16);
            $userInfo->random_token = $generateRandomString;
            $userInfo->save();
        }
        return response()->json(['status' => 2, 'message' => __('Verified'), 'auth_token' => $userInfo->random_token]);
    }

    public function forgetPassword()
    {
        $breadcrumb = array('title' => 'Forget', 'action' => 'ForgetPassword');
        $data = [];
        $data = array_merge($breadcrumb, $data);
        return view('guest.taxisteinemann.auth.forget-password')->with($data);
    }

    public function changeForgetPassword(Request $request)
    {
        $rules = [
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ];
        $request->validate($rules);
        $userInfo = User::where(['random_token' => $request->auth_token])->first();
        if (!$userInfo) {
            return redirect()->back()->withErrors(['message' => 'No such number exists in our record']);
        }
        User::find($userInfo->id)->update(['password' => Hash::make($request->password)]);
        return redirect()->route('guest.taxisteinemann.login')->with('success', __('Password updated successfully.'));
    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect()->route("guest.taxisteinemann.rides");
    }
}
