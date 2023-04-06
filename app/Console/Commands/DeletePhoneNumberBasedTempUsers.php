<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Setting;
use App\User;
use Illuminate\Support\Facades\DB;

class DeletePhoneNumberBasedTempUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete_temp_users:only_phone_number';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete temporary users having only phone number';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $settings = Setting::first();
        $settingValue = json_decode($settings['value']);
        $defaultDays = $settingValue->temporary_phone_number_users??40;
        $deletedTime = Carbon::now()->subDays($defaultDays)->format('Y-m-d');
        User::where(['user_type' => 1, 'app_installed' => 0])->where(function($query){
            $query->where(function($query1){
                $query1->whereNull('first_name')->orWhere(['first_name' => '']);
            })->where(function($query1){
                $query1->whereNull('last_name')->orWhere(['last_name' => '']);
            })->where(function($query1){
                $query1->whereNull('email')->orWhere(['email' => '']);
            })->where(function($query1){
                $query1->whereNotNull('phone')->where('phone', '!=', '');
            });
        })->whereHas('creator', function ($query) {
            $query->where('user_type', 2);
        })->whereDate('created_at', '<', $deletedTime)->forceDelete();
    }
}
