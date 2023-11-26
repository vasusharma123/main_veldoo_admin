<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Notification;
use App\Ride;

class NotificationController extends Controller
{

    protected $successCode = 200;
    protected $errorCode = 401;
    protected $warningCode = 500;

    public function last_unseen(Request $request)
    {
        $userDetail = Auth::user();
        try {
            $last_unseen_notification = Notification::where(['user_id' => $userDetail->id, 'status' => 0, 'service_provider_id' => $userDetail->service_provider_id])->whereIn('type',[1,4,10,11,12,13,16])->orderBy('id','desc')->first();
            if(!empty($last_unseen_notification)){
                // if((!empty($last_unseen_notification->additional_data)) && (!empty($last_unseen_notification->additional_data->ride_id))){
                    // $rideDetail = Ride::find($last_unseen_notification->additional_data->ride_id);
                    // if(!empty($rideDetail) && $rideDetail->status == 0){
                        return response()->json(['status' => 1, 'message' => 'Your last unseen notification', 'data' => $last_unseen_notification], $this->successCode);
                    // } else {
                    //     return response()->json(['status' => 1, 'message' => 'Your last unseen notification', 'data' => []], $this->successCode);
                    // }
                // } else {
                //     return response()->json(['status' => 1, 'message' => 'Your last unseen notification', 'data' => $last_unseen_notification], $this->successCode);
                // }
            } else {
                return response()->json(['status' => 1, 'message' => 'Your last unseen notification', 'data' => []], $this->successCode);

            }
            

            
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['status' => 0, 'message' => $exception->getMessage()], $this->warningCode);
        } catch (\Exception $exception) {
            return response()->json(['status' => 0, 'message' => $exception->getMessage()], $this->warningCode);
        }
    }

}
