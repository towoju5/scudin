<?php

namespace App\Http\Controllers\Web;

use App\CPU\Helpers;
use App\CPU\OrderManager;
use App\CPU\ProductManager;
use App\CPU\CartManager;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\BusinessSetting;
use App\Model\Category;
use App\Model\DealOfTheDay;
use App\Model\FlashDeal;
use App\Model\FlashDealProduct;
use App\Model\HelpTopic;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\Review;
use App\Model\Shop;
use App\Model\Seller;
use App\Model\Order;
use App\User;
use App\Model\Wishlist;
use App\Notifications\NewOrder;
use App\Promotion;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Omnipay\Omnipay;
use Stevebauman\Location\Facades\Location;

class WebController extends Controller
{
    public function home()
    {
        $cat_based = Category::where('parent_id', '<=', 1)->with('products')->inRandomOrder()->get();
        $cat_based1 = Category::where('parent_id', '>', 1)->with('products')->inRandomOrder()->limit(8)->get();
        // $cat_ = Category::where('parent_id', '>', 1)->with('products')->inRandomOrder()->limit(1)->get();

        $featured_products = Product::with(['reviews'])->active()->where('featured_status', 1)->inRandomOrder()->take(8)->get();
        $random_products = Product::with(['reviews'])->active()->inRandomOrder()->take(8)->get();
        $latest_products = Product::with(['reviews'])->active()->orderBy('id', 'desc')->take(6)->get();
        $categories = Category::with(['childes.childes'])->where('position', 0)->take(12)->get();
        $brands = Brand::take(12)->get();
        $recentlyViewed = recentlyViewed();
        //best sell product
        $bestSellProduct = OrderDetail::with('product.reviews')->select('product_id', DB::raw('COUNT(product_id) as count'))->groupBy('product_id')->orderBy("count", 'desc')->inRandomOrder()->take(8)->get();
        // dd($bestSellProduct);
        //Top rated
        $topRated = Review::with('product')->select('product_id', DB::raw('AVG(rating) as count'))->groupBy('product_id')->orderBy("count", 'desc')->inRandomOrder()->take(8)->get();

        if ($bestSellProduct->count() == 0) {
            $bestSellProduct = $latest_products;
        }

        if ($topRated->count() == 0) {
            $topRated = $bestSellProduct;
        }

        $deal_of_the_day = DealOfTheDay::join('products', 'products.id', '=', 'deal_of_the_days.product_id')->select('deal_of_the_days.*', 'products.unit_price')->where('deal_of_the_days.status', 1)->first();

        return view('web-views.home', compact('cat_based', 'cat_based1', 'recentlyViewed', 'featured_products', 'random_products', 'topRated', 'bestSellProduct', 'latest_products', 'categories', 'brands', 'deal_of_the_day'));
    }

    public function flash_deals($id)
    {
        $deal = FlashDeal::with(['products.product.reviews'])->where(['id' => $id, 'status' => 1])->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();

        $discountPrice = FlashDealProduct::with(['product'])->get()->map(function ($data) {
            return [
                'discount' => $data->discount,
                'sellPrice' => $data->product->unit_price,
                'discountedPrice' => $data->product->unit_price - $data->discount,

            ];
        })->toArray();
        // dd($deal->toArray());

        if (isset($deal)) {
            return view('web-views.deals', compact('deal', 'discountPrice'));
        }
        Toastr::warning('no such deal found!');
        return back();
    }

    public function all_categories()
    {
        $categories = Category::all();
        return view('web-views.categories', compact('categories'));
    }

    public function categories_by_category($id)
    {
        $category = Category::with(['childes.childes'])->where('id', $id)->first();
        return response()->json([
            'view' => view('web-views.partials._category-list-ajax', compact('category'))->render(),
        ]);
    }

    public function all_brands()
    {
        $brands = Brand::paginate(12);
        return view('web-views.brands', compact('brands'));
    }

    public function searched_products(Request $request)
    {
        $request->validate([
            'q' => 'required',
        ], [
            'q.required' => 'Product name is required!',
        ]);

        $result = ProductManager::search_products($request['q']);
        $products = $result['products'];

        return response()->json([
            'result' => view('web-views.partials._search-result', compact('products'))->render(),
        ]);
    }

    public function checkout_details()
    {
        // if (session()->has('shipping_method_id') == false) {
        //     Toastr::info('Select shipping method first!');
        //     return redirect(route('shop-cart'));
        // }

        if (session()->has('cart') && count(session('cart')) > 0) {
            return view('web-views.checkout-details');
        }
        Toastr::info('No items in your basket!');
        return redirect('/');
    }

    public function checkout_shipping(Request $request)
    {
        if (session()->has('customer_info') && session()->has('cart') && count(session('cart')) > 0) {
            return view('web-views.checkout-shipping');
        }

        Toastr::error('Incomplete info!');
        return back();
    }

    public function checkout_payment()
    {
        if (session()->has('customer_info') && session()->has('cart') && count(session('cart')) > 0) {
            return view('web-views.checkout-payment');
        }

        Toastr::error('Incomplete info!');
        return back();
    }

    public function checkout_review()
    {
        if (session()->has('shipping_method_id') == false) {
            Toastr::info('Select shipping method first!');
            return redirect(route('shop-cart'));
        }

        if (session()->has('customer_info') == false) {
            Toastr::error('Incomplete info!');
            return back();
        }

        if (session()->has('payment_method') == false) {
            session()->put('payment_method', 'cash_on_delivery');
        }

        if (session()->has('cart') && count(session('cart')) > 0) {
            $data = session('customer_info');
            if (session()->has('payment_method') == false || session('payment_method') == null) {
                session()->put('payment_method', 'cash_on_delivery');
            }
            return view('web-views.checkout-review', compact('data'));
        }
        Toastr::info('No items in your basket!');
        return redirect('/');
    }

    public function checkout_complete(Request $request)
    {
        $mm_content = '';
        if (session()->has('shipping_method_id') == false) {
            Toastr::info('Select shipping method first!');
            return redirect(route('shop-cart'));
        }

        if (session()->has('cart') == false || count(session('cart')) == 0) {
            Toastr::info('Your cart is empty.');
            return redirect()->route('home');
        }

        $customer_info = session('customer_info');
        $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $mm_total = CartManager::cart_grand_total(session('cart')) - $discount;

        try {
            $or = [
                'id' => 100000 + Order::all()->count() + 1,
                'customer_id' => auth('customer')->id(),
                'customer_type' => 'customer',
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'payment_method' => $request['payment_method'],
                'transaction_ref' => null,
                'discount_amount' => $discount,
                'discount_type' => $discount == 0 ? null : 'coupon_discount',
                'order_amount' => $mm_total,
                'shipping_address' => $customer_info['address_id'],
                'created_at' => now(),
                'updated_at' => now()
            ];

            $order_id = DB::table('orders')->insertGetId($or);

            foreach (session('cart') as $c) {
                $product = Product::where(['id' => $c['id']])->first();
                $or_d = [
                    'order_id' => $order_id,
                    'product_id' => $c['id'],
                    'seller_id' => $product->added_by == 'seller' ? $product->user_id : '0',
                    'product_details' => $product,
                    'qty' => $c['quantity'],
                    'price' => $c['price'],
                    'tax' => $c['tax'] * $c['quantity'],
                    'discount' => $c['discount'] * $c['quantity'],
                    'discount_type' => 'discount_on_product',
                    'variant' => $c['variant'],
                    'variation' => json_encode($c['variations']),
                    'delivery_status' => 'pending',
                    'shipping_method_id' => $c['shipping_method_id'],
                    'payment_status' => 'unpaid',
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                
                $mm_content .= "<tr>
                                    <td>". $product->name ."</td>
                                    <td>". $c['price'] ."</td>
                                </tr>";

                if ($c['variant'] != null) {
                    $type = $c['variant'];
                    $var_store = [];
                    foreach (json_decode($product['variation'], true) as $var) {
                        if ($type == $var['type']) {
                            $var['qty'] -= $c['quantity'];
                        }
                        array_push($var_store, $var);
                    }
                    Product::where(['id' => $product['id']])->update([
                        'variation' => json_encode($var_store),
                    ]);
                }

                Product::where(['id' => $product['id']])->update([
                    'current_stock' => $product['current_stock'] - $c['quantity']
                ]);

                DB::table('order_details')->insert($or_d);
            }

            try {
                $fcm_token = User::where(['id' => auth('customer')->id()])->first()->cm_firebase_token;
                $value = \App\CPU\Helpers::order_status_update_message('pending');
                if ($value) {
                    $data = [
                        'title' => 'Order',
                        'description' => $value,
                        'order_id' => $order_id,
                        'image' => '',
                    ];
                    Helpers::send_push_notif_to_device($fcm_token, $data);
                }
            } catch (\Exception $e) {
                Toastr::error('FCM token config issue.');
            }

            try {
                // send invoice to user
                $template = \App\Model\BusinessSetting::where(['type' => 'general_invoice'])->pluck('value')->first();                
                if (str_contains($template, '!invoice_ID')) {
                    $template = str_replace('!invoice_ID', $order_id , $template);
                }
                if (str_contains($template, '!created_at')) {
                    $template = str_replace('!created_at', now(), $template);
                }
                if (str_contains($template, '!due_date')) {
                    $template = str_replace('!due_date', now()->addMinutes(30), $template);
                }
                if (str_contains($template, '!item_info')) {
                    $template = str_replace('!item_info', $mm_content, $template);
                }
                if (str_contains($template, '!total_price')) {
                    $template = str_replace('!total_price', $mm_total, $template);
                }
                if (str_contains($template, '!receive_address')) {
                    $user = auth('customer')->user();
                    $receive_address = "$user->name <br> $user->phone";
                    $template = str_replace('!receive_address', $receive_address, $template);
                }
                send_user_mail(auth('customer')->user()->email, "Order Placed Successfully. #$order_id", $template);
                // Mail::to(auth('customer')->user()->email)->send(new \App\Mail\OrderPlaced($order_id));
            } catch (\Exception $mail_exception) {
                Toastr::error('Invalid mail or configuration.');
            }
        } catch (\Exception $e) {
            Toastr::error('Invalid informations.');
            return back();
        }

        // session()->forget('cart');
        // session()->forget('coupon_code');
        // session()->forget('coupon_discount');
        // session()->forget('payment_method');
        // session()->forget('customer_info');
        // session()->forget('shipping_method_id');

        return view('web-views.checkout-complete', compact('order_id'));
    }

    public function shop_cart()
    {
        if (session()->has('cart') && count(session('cart')) > 0) {
            return view('cart.show');
        }
        Toastr::error('No items in your basket!');
        return redirect('/');
    }

    //for seller Shop

    public function seller_shop(Request $request, $id)
    {
        $products = Product::active()->with('shop')->where(['added_by' => 'seller'])
            ->where('user_id', $id)
            ->paginate(12);
        $shop = Shop::where('seller_id', $id)->first();
        $seller = Seller::where('id', $id)->with(['shop'])->first();
        if ($request['sort_by'] == null) {
            $request['sort_by'] = 'latest';
        }

        return view('web-views.shop-page', compact('products', 'shop', 'seller'));
    }

    public function quick_view(Request $request)
    {
        $product = ProductManager::get_product($request->product_id);
        $order_details = OrderDetail::where('product_id', $product->id)->get();
        $wishlists = Wishlist::where('product_id', $product->id)->get();
        $countOrder = count($order_details);
        $countWishlist = count($wishlists);
        $relatedProducts = Product::with(['reviews'])->where('category_ids', $product->category_ids)->where('id', '!=', $product->id)->limit(12)->get();
        return response()->json([
            'success' => 1,
            'view' => view('web-views.partials._quick-view-data', compact('product', 'countWishlist', 'countOrder', 'relatedProducts'))->render(),
        ]);
    }

    public function product($slug)
    {
        $product = Product::active()->with(['reviews', 'category'])->where('slug', $slug)->first();
        if ($product != null) {
            session()->push('products.recently_viewed', $product->getKey());
            $recentlyViewed = recentlyViewed();
            $countOrder = OrderDetail::where('product_id', $product->id)->count();
            $countWishlist = Wishlist::where('product_id', $product->id)->count();
            $relatedProducts = Product::with(['reviews'])->active()->where('category_ids', $product->category_ids)->where('id', '!=', $product->id)->limit(12)->get();
            $deal_of_the_day = DealOfTheDay::where('product_id', $product->id)->where('status', 1)->first();
            $mproducts = Product::with(['reviews'])->active()->inRandomOrder()->limit(6)->get();

            return view('web-views.products.details', compact('product', 'mproducts', 'recentlyViewed', 'countWishlist', 'countOrder', 'relatedProducts', 'deal_of_the_day'));
        }

        Toastr::error('Product not found!');
        return back();
    }

    public function products(Request $request)
    {
        $cat_title = "Products";
        if ($request['sort_by'] == null) {
            $request['sort_by'] = 'latest';
        }

        if ($request['data_from'] == 'category') {
            $products = Product::active()->get();
            $cat_title = Category::find($request['id']);
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $request['id']) {
                        array_push($product_ids, $product['id']);
                    }
                }
            }

            $query = Product::with(['reviews'])->whereIn('id', $product_ids);
            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'brand') {
            $query = Product::with(['reviews'])->active()->where('brand_id', $request['id']);
            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'latest') {
            $query = Product::with(['reviews'])->active()->orderBy('id', 'DESC');
            // dd($query->toArray());
            if ($request['sort_by'] == 'latest') {
                $fetched = $query;
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'top-rated') {
            $reviews = Review::select('product_id', DB::raw('AVG(rating) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')->get();
            $product_ids = [];
            foreach ($reviews as $review) {
                array_push($product_ids, $review['product_id']);
            }
            $query = Product::with(['reviews'])->whereIn('id', $product_ids);

            if ($request['sort_by'] == 'latest') {
                $fetched = $query;
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'best-selling') {
            $details = OrderDetail::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = Product::with(['reviews'])->active()->whereIn('id', $product_ids);

            if ($request['sort_by'] == 'latest') {
                $fetched = $query;
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'featured') {
            $query = Product::with(['reviews'])->active()->where('featured', 1);
            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'search') {
            $key = explode(' ', $request['name']);
            $cat_title = Category::find($request['id']);

            $query = Product::with(['reviews'])->active()->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });


            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }

            if ($request->has('category') && !empty($request->category)) {
                $products = Product::active()->get();
                $product_ids = [];
                foreach ($products as $product) {
                    foreach (json_decode($product['category_ids'], true) as $category) {
                        if ($category['id'] == $request->category) {
                            array_push($product_ids, $product['id']);
                        }
                    }
                }
                $fetched = $fetched->whereIn('id', $product_ids);
            }
        }

        if ($request['min_price'] != null || $request['max_price'] != null) {
            $fetched = $fetched->whereBetween('unit_price', [Helpers::convert_currency_to_usd($request['min_price']), Helpers::convert_currency_to_usd($request['max_price'])]);
        }

        $product = $products = $fetched->paginate(58);

        $data = [
            'id' => $request['id'],
            'name' => $request['name'],
            'data_from' => $request['data_from'],
            'sort_by' => $request['sort_by'],
            'page_no' => $request['page'],
            'min_price' => $request['min_price'],
            'max_price' => $request['max_price'],
            'page_number' => $products->lastPage(),
        ];

        if ($request->ajax()) {
            $page = $request['page'];
            return response()->json([
                'view' => view('web-views.products._ajax-products', compact('products'))->render(),
                'paginator' => view('web-views.products._ajax-paginator', compact('data', 'page'))->render(),
            ], 200);
        }

        if ($request['data_from'] == 'category') {
            $data['brand_name'] = Category::find((int)$request['id'])->name;
        }
        
        if ($request['data_from'] == 'brand') {
            $data['brand_name'] = Brand::find((int)$request['id'])->name;
        }

        if ($request['data_from'] == 'search' && isset($request['category'])) {
            
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $request['id']) {
                        array_push($product_ids, $product['id']);
                    }
                }
            }

            $key = explode(' ', $request['name']);
            $query = Product::with(['reviews'])->active()->where('category_ids', $request['category'])->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->where('name', 'like', "%{$value}%");
                }
            });

            $query = Product::with(['reviews'])->whereIn('id', $product_ids);
            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        return view('web-views.products.view', compact('products', 'product', 'data', 'cat_title'), $data);
    }

    public function viewWishlist()
    {
        $wishlists = Wishlist::where('customer_id', auth('customer')->id())->with(['product'])->get();
        // return print_r($wishlists);
        return view('web-views.users-profile.account-wishlist', compact('wishlists'));
    }

    public function storeWishlist(Request $request)
    {
        if ($request->ajax()) {
            if (auth('customer')->check()) {
                $wishlist = Wishlist::where('customer_id', auth('customer')->id())->where('product_id', $request->product_id)->first();
                if (empty($wishlist)) {

                    $wishlist = new Wishlist;
                    $wishlist->customer_id = auth('customer')->id();
                    $wishlist->product_id = $request->product_id;
                    $wishlist->save();

                    $countWishlist = Wishlist::where('customer_id', auth('customer')->id())->get();
                    $data = "Product has been added to wishlist";

                    $product_count = Wishlist::where(['product_id' => $request->product_id])->count();
                    session()->put('wish_list', Wishlist::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());
                    return response()->json(['success' => $data, 'value' => 1, 'count' => count($countWishlist), 'id' => $request->product_id, 'product_count' => $product_count]);
                } else {
                    $data = "Product already added to wishlist";
                    return response()->json(['error' => $data, 'value' => 2]);
                }
            } else {
                $data = "Please login first";
                return response()->json(['error' => $data, 'value' => 0]);
            }
        }
    }

    public function deleteWishlist(Request $request)
    {
        Wishlist::where(['product_id' => $request['id'], 'customer_id' => auth('customer')->id()])->delete();
        $data = "Product has been remove from wishlist!";
        $wishlists = Wishlist::where('customer_id', auth('customer')->id())->get();
        session()->put('wish_list', Wishlist::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());
        return response()->json([
            'success' => $data,
            'count' => count($wishlists),
            'id' => $request->id,
            'wishlist' => view('web-views.partials._wish-list-data', compact('wishlists'))->render(),
        ]);
    }

    //for HelpTopic
    public function helpTopic()
    {
        $helps = HelpTopic::Status()->latest()->get();
        return view('web-views.help-topics', compact('helps'));
    }

    //for Contact US Page
    public function contacts()
    {
        return view('web-views.contacts');
    }

    public function about_us()
    {
        $terms_condition = BusinessSetting::where('type', 'about_us')->first();
        $title = trans("about_us");
        return view('web-views.about-us', compact('terms_condition', 'title'));
    }

    public function sell_on_scudin()
    {
        return view('web-views.sell-on-scudin');
    }

    public function termsandCondition()
    {
        $terms_condition = BusinessSetting::where('type', 'terms_condition')->first();
        $title = trans("terms_and_condition");
        return view('web-views.terms', compact('terms_condition', 'title'));
    }

    public function privacy_policy()
    {
        $terms_condition = BusinessSetting::where('type', 'privacy_policy')->first();
        $title = trans("privacy_policy");
        return view('web-views.terms', compact('terms_condition', 'title'));
    }

    public function return_policy()
    {
        $terms_condition = BusinessSetting::where('type', 'return_policy')->first();
        $title = trans("return_policy");
        return view('web-views.terms', compact('terms_condition', 'title'));
    }

    //order Details

    public function orderdetails()
    {
        return view('web-views.orderdetails');
    }

    public function chat_for_product(Request $request)
    {
        return $request->all();
    }

    //for test
    public function testOrderList()
    {
        return view('web-views.users-profile.profile.order-list');
    }

    public function testOrder()
    {
        return view('web-views.users-profile.profile.myorder');
    }

    public function testProfile()
    {
        return view('web-views.users-profile.profile.profileInfo');
    }

    public function testSupport()
    {
        return view('web-views.users-profile.profile.support-ticket');
    }

    public function testWish()
    {
        return view('web-views.users-profile.profile.wishList');
    }

    public function testChat()
    {
        return view('web-views.users-profile.profile.chat-with-seller');
    }

    public function testAddress()
    {
        return view('web-views.users-profile.profile.address');
    }

    public function testAddressView()
    {
        return view('web-views.users-profile.profile.address-view');
    }

    public function testpurchase()
    {
        return view('web-views.users-profile.profile.purchase');
    }

    public function supportChat()
    {
        return view('web-views.users-profile.profile.supportTicketChat');
    }

    public function error()
    {
        return view('web-views.404-error-page');
    }

    function get_p_type(Request $request)
    {
        $product = [];
        $find = Category::where(['id' => $request->type])->first();
        if($request->has('productId') && !empty($request->productId)){
            $find_product = Product::find($request->productId);
            $product = json_decode($find_product->extra_data);
        }
        if ($find->p_type == 'car') {
            return view('product.parts.car', compact('product'));
        } else if ($find->p_type == 'tech') {
            return view('product.parts.pc', compact('product'));
        } else if ($find->p_type == 'pc') {
            return view('product.parts.pc', compact('product'));
        }
    }

    public function importCsv(Request $request)
    {
        $order = OrderDetail::find(2);
        $_orderInfo = $order->product_details;
        $order = json_encode($_orderInfo);
        echo ($_orderInfo); exit;
        $collection = request()->session()->get('cart', collect([]));

        foreach ($collection as $key => $value) {
            // var_dump($key);
            $collection = $this->getV($collection, $key);
        }

        // var_dump($)

        request()->session()->put('cart', $collection);
        echo "<pre>";
        var_dump($collection);
    }

    function getV($collection, $i)
    {
        $new_collection = $collection->map(function ($item, $key) use (&$i) {
            if ($key == $i) {
                // var_dump($item); exit;
                $product = Product::find($item['id']);
                $_id = $item['shipping_method_id'];
                $item['shipping_cost'] = get_shipping_price_by_id($_id, $product['weight'], $product['height'], $product['width'], $product['length'], $product['unit']);
                // var_dump($item['shipping_cost']); exit;
            }
            return $item;
        });

        return $new_collection;
    }

    function address_validation()
    {
        $address = [
            'address'   => request()->address ?? NULL,
            'city'      => request()->city ?? NULL,
            'state'     => request()->state ?? NULL,
            'postal'    => request()->postal ?? NULL,
            'country'   => request()->country ?? "US",
        ];

        // return $address;

        try {
            $response = validate_address($address);
        } catch (\Throwable $e) {
            $response = $e;
        }
        if ($response === true) {
            $status = "success";
            $msg = "Address is Valid";
        } else {
            $status = "error";
            $msg = json_decode($response);
            if (empty($msg) || strlen($msg) < 5) {
                $msg = "Invalid Address or this service is not yet available in your region";
            }
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    /**
     * @param id => product_id
     * @param duration int days subscribing for
     */
    public function stripeCheckout(Request $request)
    {
        $request->validate([
            'cc_date'   =>  'required',
            'cc_num'    =>  'required',
            'cc_cvv'    =>  'required'
        ],[
            'cc_cvv.required'  =>  'CVV is Required',
            'cc_num.required'  =>  'Card number is required',
            'cc_date.required' =>  'Expiring date not provided'
        ]);
        
        $stripe = \App\CPU\Helpers::get_business_settings('stripe');
        $gateway = Omnipay::create('Stripe');
        $gateway->setApiKey($stripe['api_key']);
        $plan = Promotion::find($request->plan_id);

        // '4242424242424242'
        $getExpDate = explode('/', $request->cc_date);
        $expiryMonth = $getExpDate[0] ?? NULL;
        $expiryYear = $getExpDate[1] ?? NULL;
        $formData = array('number' => $request->cc_num, 'expiryMonth' => $expiryMonth, 'expiryYear' => $expiryYear, 'cvv' => $request->cc_cvv);
        $response = $gateway->purchase(array('amount' => $plan->cost, 'currency' => 'USD', 'card' => $formData))->send();

        try {
            if ($response->isRedirect()) {
                // redirect to offsite payment gateway
                $response->redirect();
            } elseif ($response->isSuccessful()) {
                // payment was successful: update database
                $this->add_promote($request->id, $plan->duration);
                Toastr::success('Plan updated successfully.');
                return back();
            } else {
                // payment failed: display message to customer
                Toastr::error($response->getMessage());
                return redirect()->route('payment-fail');
            }
        } catch (\Throwable $e) {
            Toastr::error($e->getMessage());
            return redirect()->route('payment-fail');
        }
    }

    function paymentFail()
    {
        return view('failed');
    }
}

