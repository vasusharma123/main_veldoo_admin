<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\User;
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
		
		if($user->user_type==2){
			session()->flash('success',  __('Password reset successful'));
			$this->redirectTo = route('password.success');
		} else {
			session()->flash('success',  __('Password reset successful'));
			$this->redirectTo = route('adminLogin');
		}
	}
	protected function emailverify($id)
	{
		 $user_id = base64_decode($id);
		$where = array('id' => $user_id);
		
        $user = User::where($where)->first();
		//echo $user->verify; die;
		if($user->verify == 1)
		{
			echo "Your email verified already"; die;
		}

		$user->verify = 1;

		$user->save();
		
		echo "Email verify successfully. You can login now"; die;
			
	}
}
