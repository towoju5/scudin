<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Convert;
use App\CPU\ImageManager;
use App\CPU\BackEndHelper;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\Seller;
use App\Model\WithdrawRequest;
use App\Model\SellerWallet;
use App\Notifications\SellerApproved;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::with(['orders', 'product'])->get();
        return view('admin-views.seller.index', compact('sellers'));
    }

    public function view($id)
    {
        $seller = Seller::findOrFail($id);
        return view('admin-views.seller.view', compact('seller'));
    }

    public function updateStatus(Request $request)
    {
        $order = Seller::findOrFail($request->id);
        $order->status = $request->status;
        if ($request->status == "approved") {

            $order->save();
            $offerData = [
                'msg' => "Your Store has been successfully Approved, please login to get started.",
                'url' => route("shop.apply"),
            ];
            Notification::send($order, new SellerApproved($offerData));

            Toastr::success('Seller has been approved successfully');
            return redirect()->route('admin.sellers.seller-list');
        } else if ($request->status == "suspended") {
            $order->save();

            $offerData = [
                'msg' => "Your Business Profile has been suspended, \nDeliverasap.ng, your Business Profile on Google has been suspended because it was flagged for suspicious activity..",
                'url' => route("shop.apply"),
            ];
            Notification::send($order, new SellerApproved($offerData));

            Toastr::info('Seller verification request has been rejected successfully');
            return redirect()->route('admin.sellers.seller-list');
        } else {
            Toastr::error('Something went wrong');
            return back();
        }
    }

    public function order_list($seller_id)
    {
        $order_det = OrderDetail::where('seller_id', $seller_id)->get();
        $order_ids = [];
        foreach ($order_det as $det) {
            if (in_array($det->seller_id, $order_ids) == false) {
                array_push($order_ids, $det->order_id);
            }
        }
        $orders = Order::with(['details'])->whereIn('id', $order_ids)->latest()->paginate(10);
        $seller = Seller::findOrFail($seller_id);
        return view('admin-views.seller.order-list', compact('orders', 'seller'));
    }

    public function product_list($seller_id)
    {
        $product = Product::where(['user_id' => $seller_id, 'added_by' => 'seller'])->latest()->paginate(10);
        $seller = Seller::findOrFail($seller_id);
        return view('admin-views.seller.porduct-list', compact('product', 'seller'));
    }

    public function order_details($order_id, $seller_id)
    {
        $order = Order::with('shipping')->where(['id' => $order_id])->first();
        return view('admin-views.seller.order-details', compact('order', 'seller_id'));
    }

    public function withdraw(Request $request)
    {
        $withdraw_req = WithdrawRequest::with(['seller'])->orderBy('id', 'desc')->latest()->paginate(10);
        
        if($request->has('q') && !empty($request->q)){          
            $withdraw_req = WithdrawRequest::with(['seller'])->latest()->paginate(10);
            if(!is_numeric($request->q)){
              $cust = $request->q;
              $seller = Seller::where('email', $cust)->orWhere('phone', $cust)->orWhere('f_name', 'like', '%' . $cust. '%')->orWhere('l_name', 'like', '%' . $cust. '%')->pluck('id');
              $withdraw_req = WithdrawRequest::whereIn('seller_id', $seller)->with(['seller'])->latest()->paginate(50);
            }
        }

        return view('admin-views.seller.withdraw', compact('withdraw_req'));
    }

    public function withdraw_view($withdraw_id, $seller_id)
    {
        $seller = WithdrawRequest::with(['seller'])->where(['id' => $withdraw_id])->first();
        return view('admin-views.seller.withdraw-view', compact('seller'));
    }

    public function withdrawStatus(Request $request)
    {
        $withdraw = WithdrawRequest::findOrFail($request->id);
        $withdraw->approved = $request->approved;
        if ($request->approved == 1) {
            SellerWallet::where('seller_id', $withdraw->seller_id)->increment('withdrawn', $withdraw['amount']);
            $withdraw->save();
            Toastr::success('Seller Payment has been approved successfully');
            return redirect()->route('admin.sellers.withdraw_list');
        } else if ($request->approved == 2) {
            SellerWallet::where('seller_id', $withdraw->seller_id)->increment('balance', $withdraw['amount']);
            $withdraw->save();
            Toastr::info('Seller Payment request has been Denied successfully');
            return redirect()->route('admin.sellers.withdraw_list');
        } else {
            Toastr::error('Something went wrong');
            return back();
        }
    }

    public function delete($id)
    {
        if (Seller::find($id)->delete()) {
            Toastr::success("Seller suspeneded");
            return back();
        }
        Toastr::error('Unknown Error!');
        return back();
    }
}
