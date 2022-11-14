<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Vanilo\Cart\Contracts\CartItem;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Foundation\Search\ProductFinder;
use Vanilo\Product\Contracts\Product as ContractsProduct;

class CartController extends Controller
{
    public function __construct()
    {
        $this->cart = new Cart;
    }
    public function add($sku = "Est aliquid consecte", $quantity = 1)
    {
        $product = Product::findBySku($sku);
        $addItem = Cart::addItem($product, $quantity, [ 'attributes' => ['weight' => 3], 'color' => ['blue'], 'size' => 'XL']);
        
        // response()->json($addItem);

        if($addItem){
            $result = [
                'code'  =>  200,
                'status' => 'success',
                'msg'   =>  'Product added to card successfully'
            ];
        } else {
            $result = [
                'code' => 400,
                'status' => 'error',
                'msg'=> 'Product not found!',
            ];
        }
        return response()->json($result);
    }

    public function remove($cart_item)
    {
        $product = Product::findBySku($cart_item);
        $cart = app('vanilo.cart');
        $cart->removeProduct($product);
        return redirect()->route('cart.show')->with('message' . __(' has been removed from cart'));
    }

    public function update(CartItem $cart_item, Request $request)
    {
        $isItemInCurrentCart = false;
        foreach (Cart::getItems() as $item) {
            if ($item->id == $cart_item->id) {
                $isItemInCurrentCart = true;
                break;
            }
        }

        if (!$isItemInCurrentCart) {
            session()->flash('info','Meeh!');
            return redirect()->route('cart.show');
        }

        $qty = (int) $request->get('qty', $cart_item->getQuantity());
        $cart_item->quantity = $qty;
        $cart_item->save();

        session()->flash('message', __(':cart_item has been updated', ['cart_item' => $cart_item->getBuyable()->getName()]));

        return redirect()->route('cart.show');
    }

    public function show()
    {
        $cart_items = Cart::getItems();
        return view('cart.show', compact(['cart_items']));
    }
}
