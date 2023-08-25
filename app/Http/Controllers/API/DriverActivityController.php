<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DriverStayActiveNotification;
use Carbon\Carbon;

class DriverActivityController extends Controller
{

    public function __construct(Request $request = null)
    {
        $this->successCode = 200;
        $this->errorCode = 401;
        $this->warningCode = 500;
    }

    public function still_active_notification_response()
    {
        $user = Auth::user();
        if ($user->availability == 1) {
            DriverStayActiveNotification::where(['driver_id' => $user->id])->update(['last_activity_time' => Carbon::now(), 'is_availability_alert_sent' => 0, 'is_availability_changed' => 0, 'is_logout_alert_sent' => 0]);
        } elseif ($user->availability == 0) {
            DriverStayActiveNotification::where(['driver_id' => $user->id])->update(['last_activity_time' => Carbon::now(), 'is_availability_alert_sent' => 1, 'is_availability_changed' => 1, 'is_logout_alert_sent' => 0]);
        }
        return response()->json(['message' => __('Thanks for showing your presence.')], $this->successCode);
    }
}
