<?php

namespace App\Http\Controllers\SpAdmin;

use App\Http\Controllers\Controller;
use App\Mail\SpForgotPassword;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('adminLogin');
    }

    public function forgot_password()
    {
        $data = array('page_title' => 'Forgot Password', 'action' => 'forgot_password');
        return view('service_provider.forgot_password')->with($data);
    }

    public function forgot_password_submit(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'email' => 'required',
        ]);
        try {
            $serviceProviderExists = User::where(['email' => request('email')])->where(function ($query) {
                $query->where(function ($query1) {
                    $query1->where(['user_type' => 3, 'is_email_verified' => 1])->whereHas('setting', function ($query2) {
                        $query2->where(['is_subscribed' => 1]);
                    });
                });
                $query->orWhere(['user_type' => 7]);
            })->first();

            if (!$serviceProviderExists) {
                return redirect()->back()->withInput($input)->with('error', __('Sorry, the email address you entered is not registered with us. Please check your email address and try again.'));
            }
            $endTime = Carbon::now()->addDay()->format('Y-m-d H:i:s');

            if ($serviceProviderExists && $serviceProviderExists->forgot_password_token_expiry >= Carbon::now()) {
                $token = $serviceProviderExists->forgot_password_token;
            } else {
                $token = $this->generateForgotPasswordToken(16);
                $serviceProviderExists->forgot_password_token = $token;
                $serviceProviderExists->forgot_password_token_expiry = $endTime;
            }
            $serviceProviderExists->save();

            Mail::to($request->email)->send(new SpForgotPassword($token));
            return redirect()->back()->with('success', __('Password reset link sent successfully. Please check your email.'));
        } catch (Exception $e) {
            Log::info('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $e->getLine() . ' --- ' . $e->getMessage());
            return redirect()->back()->withInput($input)->with('error', $e->getMessage());
        }
    }

    public function reset_password($token)
    {
        $verifyUser = User::where('forgot_password_token', $token)->first();
        if ($token) {
            if ($verifyUser) {
                $now = Carbon::now();
                if ($verifyUser->forgot_password_token_expiry >= $now) {
                    $data = array('page_title' => 'Reset Password', 'action' => 'reset_password');
                    $data['token'] = $token;
                    return view('service_provider.reset_password')->with($data);
                }
            }
        }
        return abort(404);
    }

    public function reset_password_submit(Request $request, $token)
    {
        $input = $request->all();
        $request->validate([
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
        ]);
        $existingUser = User::where('forgot_password_token', $token)->first();
        $existingUser->password = Hash::make($input['password']);
        if ($existingUser->save()) {
            Auth::attempt(['email' => $existingUser->email, 'password' => $request->password, 'user_type' => $existingUser->user_type]);
            Auth::user()->syncRoles('Administrator');
            return redirect()->route('users.dashboard');
        }
    }
}
