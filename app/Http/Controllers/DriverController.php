<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Ride;
use Carbon\Carbon;

class DriverController extends Controller
{

    public function __construct()
    {
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $currentTime = Carbon::now();
            User::where('id', $request->user_id)->delete();
            Ride::where(['driver_id' => $request->user_id])->where('ride_time', '>', $currentTime)->update(['driver_id' => null]);
            DB::commit();
            return response()->json(['status' => 1, 'message' => __('The driver has been deleted.')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
    }

}
