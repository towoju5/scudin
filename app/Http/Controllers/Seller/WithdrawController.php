<?php

namespace App\Http\Controllers\Seller;

use App\CPU\BackEndHelper;
use App\CPU\Convert;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\SellerWallet;
use App\Model\WithdrawRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
{
    public function index()
    {
        $id = auth('seller')->id();
        $withdraw_req=WithdrawRequest::where('seller_id', $id)->latest()->paginate(10);
        $data = Seller::where('id', $id)->first();
        return view('seller-views.system.withdraw', compact('withdraw_req','data'));
    }

    public function w_request(Request $request)
    {
        $w = SellerWallet::where('seller_id', auth()->guard('seller')->id())->first();
        if ($w->balance >= Convert::usd($request['amount']) && $request['amount'] > 1) {
            $data = [
                'seller_id' => auth()->guard('seller')->user()->id,
                'amount' => Convert::usd($request['amount']),
                'transaction_note' => $request->note,
                'approved' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ];
            DB::table('withdraw_requests')->insert($data);
            SellerWallet::where('seller_id', auth()->guard('seller')->user()->id)->decrement('balance', Convert::usd($request['amount']));
            Toastr::success('Withdraw request has been sent.');
            return redirect()->back();
        }

        Toastr::error('invalid request.!');
        return redirect()->back();
    }

    public function schedule(Request $request)
    {
        $w = SellerWallet::where('seller_id', auth('seller')->id())->first();
        $w->method       = $request->method;
        $w->schedule     = $request->schedule;
        $w->min_balance  = $request->balance;
        if($w->save()){
            Toastr::success('Withdraw Details Updated.');
            return back();
        }
    }

    public function close_request($id)
    {
        $wr = WithdrawRequest::find($id);
        if ($wr->approved == 0) {
            SellerWallet::where('seller_id', auth()->guard('seller')->user()->id)->increment('balance', Convert::usd($wr['amount']));
        }
        $wr->delete();
        Toastr::success('request closed!');
        return back();
    }
}
