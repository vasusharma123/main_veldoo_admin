<?php

namespace App\Providers;
use Auth;
use Validator;
use DB;
use App\UserMeta;
use App\Setting;
use App\Company;

use App\User;
use Helper;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
	
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		view()->composer('*', function($view)
		{
			$companyId =  Auth::user() ? Auth::user()->company_id : 0;
			$companyInfo = '';
			if($companyId > 0) {
				$companyInfo = Company::find($companyId);
			}
			$record = Auth::user();
			$admin = User::where(['user_type'=>1])->first();
			$setting =  array();
			$configuration =  Setting::firstOrNew(['key' => '_configuration'])->value;
			$setting = json_decode($configuration,true);
			if(app('request')->route())
			{
				$action = app('request')->route()->getAction();
				$controller = class_basename($action['controller']);
				list($controller, $action) = explode('@', $controller);
				$data['controller'] = $controller;
				$data['method'] = $action;
				$data['currentUser'] = $record;
				$data['body_class'] = Helper::clean($controller).' '.Helper::clean($action);
			}
			$data['setting'] = $setting;
			$data['companyInfo'] = $companyInfo;
			$view->with($data);
		});
		
		//JSON VALIDATION
		Validator::extend('valid_json', function ($attributes, $value, $parameters, $validation) {
			$json_string = $value;
			if(!empty($json_string)){
				if(!is_array(json_decode($json_string))) {
					return false;
				}
				json_decode($json_string);
				if (json_last_error() !== JSON_ERROR_NONE) {
					return false;
				}
			}
			return true;
		});
    }
}
