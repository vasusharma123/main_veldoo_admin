<?php

namespace App\Http\Controllers\API\user;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Ride;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
                'phone' => 'required'
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
}
