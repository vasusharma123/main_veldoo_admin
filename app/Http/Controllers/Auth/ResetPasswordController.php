<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin';
    // protected $redirectTo;
	
	 protected function resetPassword($user, $password)
	{
		$user->password = Hash::make($password);

		$user->setRememberToken(Str::random(60));

		$user->save();

		event(new PasswordReset($user));
		
		if($user->user_type==2 || $user->user_type==1){
			session()->flash('success',  __('Password reset successfully'));
			$this->redirectTo = route('password.success');
		} elseif($user->user_type==4 || $user->user_type==5) {
            session()->flash('success',  __('Password reset successful'));
            $this->redirectTo = route('company_login');
        }
        else
        {
            session()->flash('success',  __('Password reset successful'));
            $this->redirectTo = route('adminLogin');
        }
	}
}
