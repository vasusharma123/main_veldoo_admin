<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Expense;
use Carbon\Carbon;
use App\Ride;

class expenseTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-expense:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update expense table';

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
       $expenseData =  Expense::get();
       if($expenseData){
        foreach ($expenseData as $single) {
            // pending service provider iddb
            $expenseUpdate = Expense::find($single->id);
            $expenseUpdate->type = 'expense';
            $expenseUpdate->type_detail = $single->type;
            $expenseUpdate->service_provider_id = 1;
            $expenseUpdate->date = Carbon::parse($single->created_at)->format('Y-m-d');
            $expenseUpdate->update();
        
        } 
       }
    //    dd('expense table ');
       $thirtyDaysAgo = Carbon::now()->subDays(30);
        
       // Eloquent query to get records from the last 30 days
       $allRides = Ride::whereDate('created_at', '>=', $thirtyDaysAgo)->where('status',3)->get();
      // dd($allRides->toArray());
       foreach($allRides as $singleRide){
        $ride_id = $singleRide->id;
        $driver_id = $singleRide->driver_id;
        $payment_type = $singleRide->payment_type;
        $ride_cost = $singleRide->ride_cost;
        $service_provider_id  = $singleRide->service_provider_id;
        $created_at  = $singleRide->created_at;
        if(strtolower($payment_type) == 'cash'){
            // type revenue 
            $saveRevenue = new expense();
            $saveRevenue->driver_id = $driver_id;
            $saveRevenue->type = 'revenue';
            $saveRevenue->type_detail = 'cash';
            $saveRevenue->ride_id = $ride_id;
            $saveRevenue->service_provider_id = $service_provider_id;
            $saveRevenue->revenue = $ride_cost;
            $saveRevenue->date = Carbon::parse($created_at)->format('Y-m-d');
            $saveRevenue->save();
        }else{
            // type deduction

            $saveDeduction = new expense();
            $saveDeduction->driver_id = $driver_id;
            $saveDeduction->type = 'deduction';
            $saveDeduction->type_detail = $payment_type;
            $saveDeduction->ride_id = $ride_id;
            $saveDeduction->service_provider_id = $service_provider_id;
            $saveDeduction->revenue = $ride_cost;
            $saveDeduction->deductions = $ride_cost;
            $saveDeduction->date = Carbon::parse($created_at)->format('Y-m-d');
            $saveDeduction->save();

        }
        
        // for salary

            $saveSalary = new expense();
            $saveSalary->driver_id = $driver_id;
            $saveSalary->type = 'salary';
            $saveSalary->type_detail = 'revenue';
            $saveSalary->ride_id = $ride_id;
            $saveSalary->service_provider_id = $service_provider_id;
            $percentageAmount = (50 * $ride_cost) / 100;
            $saveSalary->salary = $percentageAmount;
            $saveSalary->date = Carbon::parse($created_at)->format('Y-m-d');
            $saveSalary->save();



       }
    }
}
