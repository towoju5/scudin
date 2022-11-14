<?php

namespace App\Http\Controllers;

use App\Model\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today   = get_price(day_based_sales(1));
        $week   = get_price(day_based_sales(7));
        $month  = get_price(day_based_sales(30));
        $year   = get_price(day_based_sales(365));
        $all_time = get_price(day_based_sales(365));
        $shop = Shop::where('id', Auth::id())->first();
        return view('vendor.home', compact(['today','week', 'month', 'year', 'all_time', 'shop']));
    }

    // Dashboard - Ecommerce
    public function dashboardEcommerce()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/content/dashboard/dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
    }

}
