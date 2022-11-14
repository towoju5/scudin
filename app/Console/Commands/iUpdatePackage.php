<?php

namespace App\Console\Commands;

use App\CentralLogics\Helpers;
use App\Model\Seller;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class iUpdatePackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prepare:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {       
        $resp = [];
        $expired = Seller::where('plan_id', '!=', 1)->where('plan_expires', '<=', Carbon::today()->subDays(5))->get();
        foreach ($expired as $key => $value) {
            $plan = Subscription::find($value->plan_id);
            $template = \App\Model\BusinessSetting::where(['type' => 'plan_expiration'])->pluck('value')->first();
            if (str_contains($template, '!user')) {
                $template = str_replace('!user', $value->shop->name, $template);
            }
            if (str_contains($template, '!plan')) {
                $template = str_replace('!plan', $plan->plan_name, $template);
            }
            send_mail($value->email, "Plan Expiration Notice ($plan->plan_name)", $template);
        }
        
        $expired = Seller::where('plan_id', '!=', 1)->where('plan_expires', '<=', Carbon::today())->get();
        foreach ($expired as $key => $value) {
            $plan = Seller::find($value->id);
            $plan->plan_id = 1;
            $plan->save();

            $template = \App\Model\BusinessSetting::where(['type' => 'plan_expired'])->pluck('value')->first();
            if (str_contains($template, '!user')) {
                $template = str_replace('!user', $value->shop->name, $template);
            }
            if (str_contains($template, '!plan')) {
                $template = str_replace('!plan', $plan->plan_name, $template);
            }
            send_mail($value->email, "Plan Expiration Notice ($plan->plan_name)", $template);
        }
        
        #-------------- User Plans ------------------

        $expired = User::where('plan_id', '!=', 1)->where('plan_expires', '<=', Carbon::today()->subDays(5))->get();
        foreach ($expired as $key => $value) {
            $plan = Subscription::find($value->plan_id);
            $template = \App\Model\BusinessSetting::where(['type' => 'plan_expiration'])->pluck('value')->first();
            if (str_contains($template, '!user')) {
                $template = str_replace('!user', $value->name, $template);
            }
            if (str_contains($template, '!plan')) {
                $template = str_replace('!plan', $plan->plan_name, $template);
            }
            send_mail($value->email, "Plan Expiration Notice ($plan->plan_name)", $template);
        }
        
        $expired = User::where('plan_id', '!=', 1)->where('plan_expires', '<=', Carbon::today())->get();
        foreach ($expired as $key => $value) {
            $plan = Seller::find($value->id);
            $plan->plan_id = 1;
            $plan->save();

            $template = \App\Model\BusinessSetting::where(['type' => 'plan_expired'])->pluck('value')->first();
            if (str_contains($template, '!user')) {
                $template = str_replace('!user', $value->name, $template);
            }
            if (str_contains($template, '!plan')) {
                $template = str_replace('!plan', $plan->plan_name, $template);
            }
            send_mail($value->email, "Plan Expiration Notice ($plan->plan_name)", $template);
        }
        // \Log::info("Cron is working fine!");
    }
}
