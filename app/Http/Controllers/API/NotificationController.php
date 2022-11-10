<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Notification;

class NotificationController extends Controller
{

    public function __construct(Request $request = null)
    {
        $this->successCode = 200;
        $this->errorCode = 401;
        $this->warningCode = 500;
    }

    public function last_unseen(Request $request)
    {
        $userDetail = Auth::user();
        try {
            $last_unseen_notification = Notification::where(['user_id' => $userDetail->id, 'status' => 0])->orderBy('id','desc')->first();
            return response()->json(['status' => 1, 'message' => 'Your last unseen notification', 'data' => $last_unseen_notification], $this->successCode);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['status' => 0, 'message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['status' => 0, 'message' => $exception->getMessage()], $this->warningCode);
        }
    }

}
