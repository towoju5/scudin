<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\OrderDetail;
use App\Model\Color;
use App\Model\SearchFunction;
use App\Model\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class SystemController extends Controller
{
    public function dashboard()
    {
        $bestSellProduct = OrderDetail::with('product.reviews')
            ->select('product_id', DB::raw('COUNT(product_id) as count'))
            ->groupBy('product_id')
            ->orderBy("count", 'desc')
            ->take(6)
            ->distinct()
            ->get();
        $newSellingProduct = OrderDetail::select('product_id')->orderBy('id', 'desc')->groupBy('order_id')->take(6)->distinct()->get();
        $withdraw_req = WithdrawRequest::orderBy('id', 'desc')->latest()->paginate(10);
        return view('admin-views.system.dashboard', compact('bestSellProduct', 'newSellingProduct', 'withdraw_req'));
    }

    public function search_function(Request $request)
    {
        $request->validate([
            'key' => 'required',
        ], [
            'key.required' => 'Product name is required!',
        ]);

        $key = explode(' ', $request->key);

        $items = SearchFunction::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('key', 'like', "%{$value}%");
            }
        })->get();

        return response()->json([
            'result' => view('admin-views.partials._search-result', compact('items'))->render(),
        ]);
    }
    
    public function feespricing(){
        return view('seller-views.fees');
    }
    
    public function colors(Request $request){
        $colors = Color::all();
        if($request->has('id')){
            Color::find($request->id)->delete();
            Toastr::success("Color deleted successfully");
            return back();
        }
        if($request->post() && $request->has('name')){
            Color::insert([
                'name'  =>  $request->name,
                'code'  =>  $request->code
            ]);
            Toastr::success("Color added successfully");
            return back();
        }
        return view('admin-views.colors', compact('colors'));
    }

}
