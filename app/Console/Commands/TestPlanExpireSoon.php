<?php

namespace App\Console\Commands;

use App\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Mail\TestPlanExpireSoonMail;
use Illuminate\Support\Facades\Mail;

class TestPlanExpireSoon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TestPlan:ExpireSoon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email whose test plan going to expire soon';

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
        $after6Days = Carbon::now()->addDays(6)->toDateTimeString();
        $after7Days = Carbon::now()->addDays(7)->toDateTimeString();
        $subscribers = Setting::where(['is_subscribed' => 0])->whereBetween('demo_expiry', [$after6Days, $after7Days])->get();
        if (!empty($subscribers) && count($subscribers) > 0) {
            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->service_provider->email)->send(new TestPlanExpireSoonMail($subscriber));
            }
        }
    }
}
