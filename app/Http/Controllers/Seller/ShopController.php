<?php

namespace App\Http\Controllers\Seller;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function view()
    {
        $shop = Shop::where(['seller_id' => auth('seller')->id()])->first();
        if (isset($shop) == false) {
            DB::table('shops')->insert([
                'seller_id' => auth('seller')->id(),
                'name' => auth('seller')->user()->f_name,
                'address' => '',
                'contact' => auth('seller')->user()->phone,
                'image' => 'def.png',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $shop = Shop::where(['seller_id' => auth('seller')->id()])->first();
        }

        return view('seller-views.shop.shopInfo', compact('shop'));
    }

    public function edit($id)
    {
        $shop = Shop::where(['seller_id' =>  auth('seller')->id()])->first();
        return view('seller-views.shop.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'contact'   =>  'required|min:10,max:15'
        ],[
            'contact.required'  =>  "Phone Number is required",
            'contact.min'       =>  "Phone number can't be less than 10 character",
            'contact.max'       =>  "Phone number can not be more than 15 character"
        ]);
        $shop = Shop::find($id);
        $shop->name = $request->name;
        $shop->address = $request->address;
        $shop->contact = $request->contact;
        $shop->tax_id  = $request->tax_id;
        
        if ($request->hasFile('logo')) {
            $shop->image = save_image('seller', $request->logo);
        }
        $shop->save();
        
        if ($request->hasFile('image')) {
            $seller = Seller::find(auth('seller')->id())->first();
            $seller->image = save_image('shop-banner', $request->image);
            $seller->save();
        }

        Toastr::info('Shop updated successfully!');
        return redirect()->route('seller.shop.view');
    }

}
