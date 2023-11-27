<?php

namespace App\Http\Controllers\API\user;

use App\Http\Controllers\Controller;
use App\PaymentMethod;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    protected $successCode = 200;
    protected $errorCode = 401;
    protected $warningCode = 500;

    public function __construct(Request $request = null)
    {
    }

    public function my_profile(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                return response()->json(['success' => true, 'message' => 'My profile', 'data' => $user], $this->successCode);
            }
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
                'phone' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first(), 'error' => $validator->errors()], $this->warningCode);
            }

            $user = User::select('id', 'first_name', 'last_name', 'email', 'country_code', 'phone', 'image', 'user_type', 'country', 'state', 'city', 'street', 'zip')
                ->where(['country_code' => $request->country_code, 'phone' => ltrim($request->phone, "0"), 'user_type' => 1])->first();
            if ($user) {
                return response()->json(['success' => true, 'message' => 'User Detail', 'data' => $user], $this->successCode);
            } else {
                return response()->json(['success' => false, 'message' => 'No user was found with the given phone number.'], $this->successCode);
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                User::where(['id' => $user->id])->delete();
                return response()->json(['success' => true, 'message' => 'Your account was successfully deleted.'], $this->successCode);
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }

    public function service_providers(Request $request)
    {
        try {
            $service_providers = User::select('id', 'name', 'user_type')->where(['user_type' => 3])->get();
            return response()->json(['success' => true, 'message' => 'List of service providers', 'data' => $service_providers], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }

    public function mark_favourite_service_provider(Request $request)
    {
        try {
            $user = Auth::user();
            $user->service_provider_id = $request->service_provider_id ?? null;
            $user->save();
            $userDetail = User::find($user->id);
            return response()->json(['success' => true, 'message' => 'My profile', 'data' => $userDetail], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $this->warningCode);
        }
    }

    /* Settings based on default Service Provider */

    public function settings(Request $request)
    {
        $user = Auth::user();
        $service_provider_id = (!empty($user->service_provider_id)) ? $user->service_provider_id : 1;
        $payment_method = PaymentMethod::where(['service_provider_id' => $service_provider_id])->get();
        $settings = Setting::where(['service_provider_id' => $service_provider_id])->first();
        $settingValue = json_decode($settings['value']);
        return response()->json(['message' => 'Success', 'payment_method' => $payment_method, 'currency_symbol' => $settingValue->currency_symbol, 'currency_name' => $settingValue->currency_name, 'driver_count_to_display' => $settingValue->driver_count_to_display], $this->successCode);
    }

    /* Settings based on Service Provider ID */

    public function sp_based_settings(Request $request)
    {
        $service_provider_id = $request->service_provider_id ?? "";
        $payment_method = [];
        if (!empty($service_provider_id)) {
            $payment_method = PaymentMethod::where(['service_provider_id' => $service_provider_id])->get();
            $settings = Setting::where(['service_provider_id' => $service_provider_id])->first();
            $settingValue = json_decode($settings['value']);
        }
        return response()->json(['message' => 'Success', 'payment_method' => $payment_method, 'currency_symbol' => $settingValue->currency_symbol ?? "", 'currency_name' => $settingValue->currency_name ?? "", 'driver_count_to_display' => $settingValue->driver_count_to_display ?? ""], $this->successCode);
    }
}
