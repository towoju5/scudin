<?php

namespace App\Http\Controllers;

use App\Model\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{
    public function chart()
    {
        $today   = get_price(day_based_sales(1));
        $week   = get_price(day_based_sales(7));
        $month  = get_price(day_based_sales(30));
        $year   = get_price(day_based_sales(365));
        $all_time = get_price(day_based_sales(365));
        $shop = Shop::where('id', auth('seller')->id())->first();
        if (request()->ajax()) {
            $date = Carbon::now()->subDays(1)->startOfYear();
            $result = DB::table('orders')->where('orders.created_at', '>=', $date)->join('order_items', 'orders.id', '=', 'order_items.order_id')->groupBy(DB::raw('DATE(orders.created_at)'))->where('order_details.seller_id', '=', auth('seller')->id())->select(DB::raw('DATE(orders.created_at) as date'), DB::raw('SUM(order_items.price) as total'), DB::raw('SUM(order_items.quantity) as quantity'))->get();
            return response()->json(["orders" => $result]);
        }
        return view('chart.reports', compact(['today', 'week', 'month', 'year', 'all_time', 'shop']));
    }

    public function orderReport()
    {
        if (request()->ajax()) {
            $result = DB::table('orders')->where('shop_id', '=', 0)->groupBy('created_at')->limit(5)->get();
            return response()->json($result);
        }
        //return view('chart.index');
    }

    public function dayBasedChart()
    {
        if (request()->ajax()) {
            $orders  = DB::table('orders')
                ->where('order_details.seller_id', '=', auth('seller')->id())
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->groupBy(DB::raw('DATE(orders.created_at)'))
                ->select(
                    DB::raw('DATE(orders.created_at) as date'),
                    DB::raw('SUM(orders.order_amount) as total'),
                    DB::raw('SUM(order_details.qty) as quantity')
                )->get();

            return response()->json([
                'orders'     => $orders,
            ]);
        }
        return view('chart.day');
    }

    public function dayBasedSellersChart()
    {
        if (request()->ajax()) {
            $orders  = DB::table('orders')
                ->where('order_details.seller_id', auth('seller')->id())
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->groupBy(DB::raw('DATE(orders.created_at)'))
                ->select(
                    DB::raw('DATE(orders.created_at) as date'),
                    DB::raw('SUM(orders.order_amount) as total'),
                    DB::raw('SUM(order_details.qty) as quantity')
                )->get();

            return response()->json([
                'orders'     => $orders,
            ]);
        }
        return view('chart.day');
    }
}


/*
$billings = DB::table("sales")->select("sales.store",
        DB::raw("SUM(CASE WHEN created_at >= NOW() - INTERVAL 1 WEEK THEN amount ELSE 0 END) weekly_sales",
        DB::raw("SUM(CASE WHEN created_at >= NOW() - INTERVAL 1 MONTH THEN amount ELSE 0 END) monthly_sales",
        DB::raw("SUM(CASE WHEN created_at >= NOW() - INTERVAL 1 YEAR THEN amount ELSE 0 END) yearly_sales",
        DB::raw("SUM(amount) total_sales")
    )
    ->groupBy("sales.store")
    ->orderByRaw('sales.store ASC'); 
*/