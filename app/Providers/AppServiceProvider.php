<?php

namespace App\Providers;

use App\Company;
use App\Helpers\Helper;
use App\Setting;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('*', function ($view) {
            $companyId = Auth::user() ? Auth::user()->company_id : 0;
            $companyInfo = '';
            if ($companyId > 0) {
                $companyInfo = Company::find($companyId);
            }
            $record = Auth::user();
            $configuration = array();
            $setting = array();
            $service_provider_id = "";
            if (Auth::user() && Auth::user()->user_type == 3) {
                $service_provider_id = Auth::user()->id;
            } elseif (Auth::user() && !empty(Auth::user()->service_provider_id)) {
                $service_provider_id = Auth::user()->service_provider_id;
            }
            if (!empty($service_provider_id)) {
                $configuration = Setting::where(['service_provider_id' => $service_provider_id])->first();
                $setting = json_decode($configuration->value, true);
            }
            if (app('request')->route()) {
                $action = app('request')->route()->getAction();
                $controller = class_basename($action['controller']);
                list($controller, $action) = explode('@', $controller);
                $data['controller'] = $controller;
                $data['method'] = $action;
                $data['currentUser'] = $record;
                $data['body_class'] = Helper::clean($controller) . ' ' . Helper::clean($action);
            }
            $data['configuration'] = $configuration;
            $data['setting'] = $setting;
            $data['companyInfo'] = $companyInfo;
            $view->with($data);
        });

        //JSON VALIDATION
        Validator::extend('valid_json', function ($attributes, $value, $parameters, $validation) {
            $json_string = $value;
            if (!empty($json_string)) {
                if (!is_array(json_decode($json_string))) {
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
