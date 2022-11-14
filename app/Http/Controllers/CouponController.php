<?php

namespace App\Http\Controllers;

use App\Model\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Vanilo\Cart\Contracts\CartItem;
use Vanilo\Shipment\Models\Shipment;

class CouponController extends Controller
{

    public function index()
    {
        $coupon = response()->json([]);
        $coupon = Coupon::all();
        if (auth()->user()->role == 'vendor') {
            $coupon = Coupon::where('shop_id', auth()->id())->get();
        }
        if (auth()->user()->role == 'admin') {
            $coupon = Coupon::all();
        }
        if (request()->ajax()) {
            return datatables()->of($coupon)->toJson();
        }

        return view('coupon.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return back()->withErrors('Invalid coupon code. Please try again.');
        }

        dispatch_now(new UpdateCoupon($coupon));

        return back()->with('message', 'Coupon has been applied!');
    }

    public function edit($id)
    {
        return $coupon = Coupon::where('id', $id)->first();
    }

    public function update(Request $request, $id)
    {
        //test
        // $shippingFee = new SimpleShippingFee($shippingCost = 6.99, $freeWhenOrderValueIsMoreThan = 30);


        if ($this->validate($request, [
            'coupon_code' => 'required',
            'coupon_type' => 'required',
            'coupon_value' => 'required',
        ])) {
            $coupon = Coupon::findorfail($id);
            $coupon->code = $request->coupon_code;
            $coupon->type = $request->coupon_type;
            $coupon->value = $request->coupon_value;
            $coupon->save();
            return response()->json(['message' => 'Coupon updated successfully']);
        }
        return response()->json(['error_message' => 'Something went wrong']);
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'coupon_code' => 'required',
            'coupon_type' => 'required',
            'coupon_value' => 'required',
        ]);
        $save = Coupon::create([
            'code' => $request->coupon_code,
            'type' => $request->coupon_type,
            'value' => $request->coupon_value
        ]);
        if ($save) {
            return response()->json(['message' => 'Coupon added successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        session()->forget('coupon');

        return back()->with('success_message', 'Coupon has been removed.');
    }
    
    
    public function delete($id)
    {
        if (!empty($id)) {
            Coupon::where('id',$id)->delete();
        }

        return response()->json(['message' => 'Coupon has been deleted.']);
    }

    public function apply(CartItem $cart_item, Request $request)
    {
        if(!empty($cart_item) && isset($request->coupon_code)){
            $coupon = new Coupon();
            return $coupon->discount($request->coupon_code);
            // $newPrice = '';
            // $cart = $cart_item;
            // $cart->price = $newPrice;
            // $cart->save();
            session()->set('message', __('Coupon code applied successfully'));
        } else {
            session()->set('message', __('Something went wrong!'));
        }      

        return redirect()->route('cart.show');
    }
}
