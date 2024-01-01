<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Setting;
use Carbon\Carbon;

class GuestUser
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
        $slug = $request->route()->parameters['slug'];
        $slugRecord = Setting::where(['slug' => $slug])->first();
        if ($slugRecord) {
            $request->attributes->add(['slugRecord' => $slugRecord]);
            view()->share('themeSettings', $slugRecord);
            return $next($request);
        } else {
            abort(404, 'Unknown Host');
        }
    }
}
