<?php

namespace App\Http\Controllers\Seller;

use App\CPU\BackEndHelper;
use App\Http\Controllers\Controller;
use App\Model\ShippingMethod;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingMethodController extends Controller
{
   public function index()
   {
      $shipping_methods = ShippingMethod::where(['creator_id' => auth('seller')->id(), 'creator_type' => 'seller'])->get();
      return view('seller-views.shipping-method.add-new', compact('shipping_methods'));
   }

   public function store(Request $request)
   {
      $request->validate([
         'title' => 'required',
      ],[
         'title.required'  => "Shipping title is required. please select a valid value",
      ]);

      if (str_contains(strtolower($request->title), 'ups')) {
         $method = 'ups';
      } else {
         $method = 'fedex';
      }

      DB::table('shipping_methods')->insert([
         'creator_id'      =>    auth('seller')->id(),
         'creator_type'    =>    'seller',
         'title'           =>    $request['title'],
         'duration'        =>    $request['duration'] ? $request['duration'] : "Auto-generated on checkout",
         'cost'            =>    BackEndHelper::currency_to_usd($request['cost'] ? $request['cost'] : 0),
         'status'          =>    1,
         'method'          =>    $method,
         'refund_policy'   =>    $request['refund_policy'],
         'address'         =>    $request['address'],
         'city'            =>    $request['city'],
         'state'           =>    $request['state'],
         'postal'          =>    $request['postal'],
         'country'         =>    $request['country'],
         'shipping_policy' =>    $request['shipping_policy'],
         'created_at'      =>    now(),
         'updated_at'      =>    now()
      ]);

      Toastr::success('Successfully added.');
      return back();
   }

   public function status_update(Request $request)
   {
      ShippingMethod::where(['id' => $request['id']])->update([
         'status' => $request['status']
      ]);
      return response()->json([
         'success' => 1,
      ], 200);
   }

   public function edit($id)
   {
      $method = ShippingMethod::where(['id' => $id])->first();
      return view('seller-views.shipping-method.edit', compact('method'));
   }

   public function update(Request $request, $id)
   {
      $request->validate([
         'title' => 'required',
      ],[
         'title.required'  => "Shipping title is required. please select a valid value",
      ]);

      if (str_contains(strtolower($request->title), 'ups')) {
         $method = 'ups';
      } else {
         $method = 'fedex';
      }

      DB::table('shipping_methods')->where(['id' => $id])->update([
         'creator_id'      =>    auth('seller')->id(),
         'creator_type'    =>    'seller',
         'title'           =>    $request['title'],
         'duration'        =>    $request['duration'] ? $request['duration'] : NULL,
         'cost'            =>    BackEndHelper::currency_to_usd($request['cost'] ? $request['cost'] : 0),
         'status'          =>    1,
         'method'          =>    $method,
         'refund_policy'   =>    $request['refund_policy'],
         'address'         =>    $request['address'],
         'city'            =>    $request['city'],
         'state'           =>    $request['state'],
         'postal'          =>    $request['postal'],
         'country'         =>    $request['country'],
         'shipping_policy' =>    $request['shipping_policy'],
         'created_at'      =>    now(),
         'updated_at'      =>    now()
      ]);

      Toastr::success('Successfully updated.');
      return redirect()->route('seller.business-settings.shipping-method.add');
   }

   public function delete($id)
   {
      try {
         ShippingMethod::where(['id' => $id])->delete();
      } catch (\Exception $e) {
         Toastr::success($e->getMessage());
         return back();
      }
      Toastr::success('Successfully removed.');
      return back();
   }
}

