<?php

namespace App\Console\Commands;

use App\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Mail\TestPlanExpireTonightMail;
use Illuminate\Support\Facades\Mail;

class TestPlanExpireTonight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TestPlan:ExpireTonight';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email whose test plan going to expire tonight';

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
        $today = Carbon::now()->toDateTimeString();
        $tomorrow = Carbon::now()->addDays(1)->toDateTimeString();
        $subscribers = Setting::where(['is_subscribed' => 0])->whereBetween('demo_expiry', [$today, $tomorrow])->get();
        if (!empty($subscribers) && count($subscribers) > 0) {
            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->service_provider->email)->send(new TestPlanExpireTonightMail($subscriber));
            }
        }
    }
}
