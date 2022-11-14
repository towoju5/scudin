<?php

namespace App\Http\Controllers\Customer;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\CartController;
use App\Model\Product;
use App\Model\ShippingMethod;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SystemController extends Controller
{
    public function set_payment_method($name)
    {
        if (auth('customer')->check() || session()->has('mobile_app_payment_customer_id')) {
            session()->put('payment_method', $name);
            return response()->json([
                'status' => 1
            ]);
        }
        return response()->json([
            'status' => 0
        ]);
    }

    public function set_shipping_method(Request $request)
    {
        if ($request['id'] != 0) {
            session()->put('shipping_method_id', $request['id']);

            $cart = $request->session()->get('cart', collect([]));
            $cart = $cart->map(function ($object, $key) use ($request) {
                if ($key == $request['key']) {
                    $product = Product::find($object['id']);
                    $object['shipping_method_id'] = $request['id'];
                    $object['shipping_cost'] = ShippingMethod::find($request['id'])->cost;
                }
                return $object;
            });
            $request->session()->put('cart', $cart);

            // return response()->json([
            //     'status' => 1
            // ]);

            return redirect(route("checkout-payment"))->with(['status' => 1]);
        }
        return response()->json([
            'status' => 0
        ]);
    }

    public function choose_shipping_address(Request $request)
    {
        // session()->put('shipping_method_id', 1);
        if ($request->save_address == 'on') {
            $address_id = DB::table('shipping_addresses')->insertGetId([
                'customer_id' => auth('customer')->id(),
                'contact_person_name' => $request['contact_person_name'],
                'address_type' => $request['address_type'],
                'address' => $request['address'],
                'city' => $request['city'],
                'zip' => $request['zip'],
                'state' => $request['province'],
                'country' => $request['country'],
                'phone' => $request['phone'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else if ($request['shipping_method_id'] == 0) {

            $validator = Validator::make($request->all(), [
                'contact_person_name' => 'required',
                'address_type' => 'required',
                'address' => 'required',
                'city' => 'required',
                'zip' => 'required',
                'phone' => 'required',
                'state' => 'required',
                'country' => 'required',
            ], [
                'contact_person_name.required' => 'Shipping contact person name is required',
                'address_type.required' => 'Shipping address type is required',
                'address.required' => 'address is required',
                'city.required' => 'Shipping city is required',
                'zip.required' => 'Shipping zip is required',
                'phone.required' => 'Shipping phone is required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => Helpers::error_processor($validator)]);
            }

            $address_id = DB::table('shipping_addresses')->insertGetId([
                'customer_id' => 0,
                'contact_person_name' => $request['contact_person_name'],
                'address_type' => $request['address_type'],
                'address' => $request['address'],
                'city' => $request['city'],
                'zip' => $request['zip'],
                'phone' => $request['phone'],
                'state' => $request['province'],
                'country' => $request['country'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $address_id = $request['shipping_method_id'];
        }

        session()->put('customer_info', [
            'address_id' => $address_id
        ]);

        $this->curl_post();
        return response()->json([], 200);
    }

    public function markNotification(Request $request)
    {
        auth()->user()->unreadNotifications->when($request->input('id'), function ($query) use ($request) {
            return $query->where('id', $request->input('id'));
        })->markAsRead();

        return response()->noContent();
    }

    public function setShippingPrice(Request $request)
    {
        $status = 1;
        $qty = 0;
        $cart = $request->session()->get('cart', collect([]));
        $cart = $cart->map(function ($object, $key) use ($request, &$status, &$qty) {
            if ($key == $request->key) {
                $shipping_id = $object['shipping_method_id'];
                $product = Product::find($object['id']);
                $_shipFee = $_shipFee = get_shipping_price_by_id($shipping_id, $product['weight'], $product['height'], $product['width'], $product['length'], $product['unit']);;
                $count = count(json_decode($product->variation));
                if ($count) {
                    for ($i = 0; $i < $count; $i++) {
                        if (json_decode($product->variation)[$i]->type == $object['variant']) {
                            if (json_decode($product->variation)[$i]->qty < $request->quantity) {
                                $status = 0;
                                $qty = $object['quantity'];
                            } else {
                                $object['quantity'] = $request->quantity;
                                $object['shipping_cost'] = ($_shipFee * $request->quantity);
                            }
                        }
                    }
                } else if ($product['current_stock'] < $request->quantity) {
                    $status = 0;
                    $qty = $object['quantity'];
                } else {
                    $object['quantity'] = $request->quantity;
                    $object['shipping_cost'] = ($_shipFee * $request->quantity);
                }
            }
            return $object;
        });

        if ($status == 0) {
            return response()->json([
                'data' => $status,
                'qty' => $qty,
            ]);
        }

        $request->session()->put('cart', $cart);

        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        return view('cart._summary');
        // return view('layouts.front-end.partials.cart_details');
    }

    public function curl_post()
    {
        $cart = session('cart');
        foreach ($cart as $k => $cartItem) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, route('updateShippingPrice'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            $post = array(
                'key'       => $k,
                'quantity'  => $cartItem['quantity'],
                '_token'    => csrf_token()
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            //do what you want with the responce
            var_dump($result); exit;
        }
    }
}
