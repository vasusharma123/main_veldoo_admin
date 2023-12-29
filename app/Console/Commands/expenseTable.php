<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\expense;
use Carbon\Carbon;

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
       $expenseData =  Expense::where('id',2)->get();
       if($expenseData){
        foreach ($expenseData as $single) {
            $expenseUpdate = Expense::find($single->id);
            $expenseUpdate->type = 'expense';
            $expenseUpdate->type_detail = $single->type;
            $expenseUpdate->date = Carbon::parse($single->created_at)->format('Y-m-d');
            $expenseUpdate->update();
        
        } 
       }
    }
}
