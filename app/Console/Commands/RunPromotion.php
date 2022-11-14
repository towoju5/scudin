<?php

namespace App\Console\Commands;

use App\Model\Product;
use App\PromotionData;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RunPromotion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:promotion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired promotions on a daily basis and have them removed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {        
        $resp = [];
        $expired = PromotionData::where('expires_at', Carbon::today())->get();
        foreach ($expired as $key => $value) {
            $id = $value['id'];
            $product = Product::find($id);
            $product->featured_status = 0;
            $product->save();
            $resp[] = $id;
        }
        $data = PromotionData::destroy($resp);
        // \Log::info("Cron is working fine!. $data");
        // return true;
    }
}
