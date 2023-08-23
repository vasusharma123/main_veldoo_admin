<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\DriverStayActiveNotification;
use Carbon\Carbon;

class DriverStillActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentUser = Auth::user();
        if($currentUser->user_type == 2){
            DriverStayActiveNotification::updateOrCreate(['driver_id' => $currentUser->id],['last_activity_time' => Carbon::now()]);
        }
        return $next($request);
    }
}
