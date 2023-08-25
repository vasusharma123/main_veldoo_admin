<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Setting;
use App\User;
use Illuminate\Support\Facades\DB;

class DeleteLastNameBasedTempUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete_temp_users:only_last_name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete temporary users having only last name';

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
        $defaultDays = $settingValue->temporary_phone_number_users??20;
        $deletedTime = Carbon::now()->subDays($defaultDays)->format('Y-m-d');
        User::join('users as creator','creator.id','=','users.created_by')->where(['users.user_type' => 1, 'users.app_installed' => 0])->where(function($query){
            $query->where(function($query1){
                $query1->whereNull('users.first_name')->orWhere(['users.first_name' => '']);
            })->where(function($query1){
                $query1->whereNull('users.phone')->orWhere(['users.phone' => '']);
            })->where(function($query1){
                $query1->whereNull('users.email')->orWhere(['users.email' => '']);
            })->where(function($query1){
                $query1->whereNotNull('users.last_name')->where('users.last_name', '!=', '');
            });
        })->where(['creator.user_type' => 2])
        ->whereDate('users.created_at', '<', $deletedTime)->forceDelete();
    }
}
