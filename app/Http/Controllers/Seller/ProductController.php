<?php

namespace App\Http\Controllers\Seller;

use App\CPU\BackEndHelper;
use App\CPU\Convert;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Color;
use App\Model\DealOfTheDay;
use App\Model\FlashDealProduct;
use App\Model\Product;
use App\Promotion;
use App\PromotionData;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Omnipay\Omnipay;
use Rap2hpoutre\FastExcel\FastExcel;

class ProductController extends Controller
{
    public $columns = "";
    public $values = "";
    public $column = "";
    public $value = "";


    public function add_new()
    {
        $cat = Category::where(['parent_id' => 0])->get();
        $br = Brand::orderBY('name', 'ASC')->get();
        return view('seller-views.product.add-new', compact('cat', 'br'));
    }

    public function status_update(Request $request)
    {
        Product::where(['id' => $request['id'], 'added_by' => 'seller', 'user_id' => \auth('seller')->id()])->update([
            'status' => $request['status'],
        ]);
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function featured_status(Request $request)
    {
        if ($request->ajax()) {
            $product = Product::find($request->id);
            $product->featured_status = $request->status;
            $product->save();
            $data = $request->status;
            return response()->json($data);
        }
    }

    public function store(Request $request)
    {
        if (checkSellerLimit() === false) {
            Toastr::success('Product Limit reached, Please upgrade your plan to add more products');
            return redirect()->route('seller.product.add_new');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'unit' => 'required',
            'images' => 'required',
            'unit_price' => 'required|numeric|min:1',
            'purchase_price' => 'required|numeric|min:1',
        ], [
            'name.required' => 'Product name is required!',
            'category_id.required' => 'category  is required!',
            'images.required' => 'Product images is required!',
            'brand_id.required' => 'brand  is required!',
            'unit.required' => 'Unit  is required!',
            'unit_price.required' => 'Unit  is required!',
        ]);

        if ($request['discount_type'] == 'percent') {
            $dis = ($request['unit_price'] / 100) * $request['discount'];
        } else {
            $dis = $request['discount'];
        }

        if ($request['unit_price'] <= $dis) {
            Toastr::error('Discount can not be more or equal to the price!');
            return back();
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'unit_price',
                    'Discount can not be more or equal to the price!'
                );
            });
        }

        $product = new Product();
        $product->user_id = auth('seller')->id();
        $product->added_by = "seller";
        $product->name = $request->name;

        $product->product_type = $request->product_type ?? 0; // defines if product is downloadable or not // 1 for downloadable
        $product->download_url = $request->download_url ?? NULL;
        
        $product->charge_cat = $request->category_id;
        $product->slug = Str::slug($request->name, '-') . '-' . Str::random(6);

        $category = [];

        if ($request->category_id != null) {
            array_push($category, [
                'id' => $request->category_id,
                'position' => 1,
            ]);

            $p_type = Category::find($request->category_id);
            $product->p_type = $p_type->p_type;
        }
        if ($request->sub_category_id != null) {
            array_push($category, [
                'id' => $request->sub_category_id,
                'position' => 2,
            ]);
        }
        if ($request->sub_sub_category_id != null) {
            array_push($category, [
                'id' => $request->sub_sub_category_id,
                'position' => 3,
            ]);
        }

        $product->category_ids = json_encode($category);
        $product->brand_id = $request->brand_id;
        $product->unit = $request->unit;
        $product->details = $request->details;

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = product_image($img);
            }
            $product->images = json_encode($product_images);
        }
        $product->thumbnail = product_thumnail_image($request->file('image'));

        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $product->colors = json_encode($request->colors);
        } else {
            $colors = [];
            $product->colors = json_encode($colors);
        }
        $choice_options = [];
        if ($request->has('choice')) {
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_' . $no;
                $item['name'] = 'choice_' . $no;
                $item['title'] = $request->choice[$key];
                $item['options'] = explode(',', implode('|', $request[$str]));
                array_push($choice_options, $item);
            }
        }
        $product->choice_options = json_encode($choice_options);
        $variations = [];
        //combinations start
        $options = [];
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }
        //Generates the combinations of customer choice options
        $combinations = Helpers::combinations($options);
        $variations = [];
        $stock_count = 0;
        if (count($combinations[0]) > 0) {
            foreach ($combinations as $key => $combination) {
                $str = '';
                foreach ($combination as $k => $item) {
                    if ($k > 0) {
                        $str .= '-' . str_replace(' ', '', $item);
                    } else {
                        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
                            $color_name = Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        } else {
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }
                $item = [];
                $item['type'] = $str;
                $item['price'] = Convert::usd(abs($request['price_' . str_replace('.', '_', $str)]));
                $item['sku'] = $request['sku_' . str_replace('.', '_', $str)];
                $item['qty'] = $request['qty_' . str_replace('.', '_', $str)];
                array_push($variations, $item);
                $stock_count += $item['qty'];
            }
        } else {
            $stock_count = (int)$request['current_stock'];
        }
        if ((int)$request['current_stock'] != $stock_count) {
            $validator->after(function ($validator) {
                $validator->errors()->add('total_stock', 'Stock calculation mismatch!');
            });
        }
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        // additional data/extra data available for tech & car categories only
        $_f_data = [];
        if ($request->has('_data')) {
            $_f_data =  array_filter($request->input('_data'));
        }

        //combinations end
        $product->variation = json_encode($variations);
        $product->unit_price = Convert::usd($request->unit_price);
        $product->purchase_price = Convert::usd($request->purchase_price);
        // $product->tax = 8.25;

        $product->height = $request->height;
        $product->length = $request->length;
        $product->width = $request->width;
        $product->weight = $request->weight;
        
        $product->tax = 8.25; //$request->tax == 'flat' ? BackEndHelper::currency_to_usd($request->tax) : $request->tax;
        $product->tax_type = 'percent'; //$request->tax_type;
        $product->discount = $request->discount_type == 'flat' ? Convert::usd($request->discount) : $request->discount;
        $product->discount_type = $request->discount_type;
        $product->attributes = json_encode($request->choice_attributes);
        $product->current_stock = $request->current_stock;
        $product->extra_data = json_encode($_f_data);

        

        /**
         * Grab category info via charge_cat
         * Calculate product commision per product
         */
        $p_cat = Category::find($request->category_id);
        if($p_cat->commision_type == 'combined_fee'){
            $commission = ((($request->purchase_price / 100) * $p_cat->percentage) + $p_cat->flat);
        } elseif($p_cat->commision_type == 'flat_fee') {
            $commission = $p_cat->flat;
        } elseif($p_cat->commision_type == 'percentage') {
            $commission = (($request->purchase_price / 100) * $p_cat->percentage);
        }

        $product->commission = BackEndHelper::currency_to_usd($commission);

        $product->save();

        // return response()->json([], 200);
        Toastr::success('Product added successfully!');
        return redirect()->route('seller.product.list');
    }

    function list(Request $request)
    {
        $query = new Product();
        $query = $query->where([
            'added_by' => 'seller',
            'user_id' => auth('seller')->id()
        ]);

        if($request->has('q'))
            $query = $query->where('name', 'like', "%{$request->q}%");

        $products = $query->latest()->paginate(20);
        return view('seller-views.product.list', compact('products'));
    }

    public function get_categories(Request $request)
    {
        $cat = Category::where(['parent_id' => $request->parent_id])->get();
        $res = '<option value="' . 0 . '" disabled selected>---Select---</option>';
        foreach ($cat as $row) {
            if ($row->id == $request->sub_category) {
                $res .= '<option value="' . $row->id . '" selected >' . $row->name . '</option>';
            } else {
                $res .= '<option value="' . $row->id . '">' . $row->name . '</option>';
            }
        }
        return response()->json([
            'select_tag' => $res,
        ]);
    }

    public function sku_combination(Request $request)
    {
        $options = [];
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = Helpers::combinations($options);
        return response()->json([
            'view' => view('seller-views.product.partials._sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'))->render(),
        ]);
    }

    public function edit($id)
    {
        $product = Product::where('id',$id)->where('user_id', auth('seller')->id())->first();
        if(empty($product)){
            Toastr::success('Product not found!');
            return back();
        }
        $product_category = json_decode($product->category_ids);
        $product->colors = json_decode($product->colors);

        $categorys = Category::where(['parent_id' => 0])->get();
        $br = Brand::orderBY('name', 'ASC')->get();
        return view('seller-views.product.edit', compact('categorys', 'br', 'product', 'product_category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'details' => 'required',
            'unit' => 'required',
            'unit_price' => 'required|numeric|min:1',
            'purchase_price' => 'required|numeric|min:1',
        ], [
            'name.required' => 'Product name is required!',
            'category_id.required' => 'category  is required!',
            'brand_id.required' => 'brand  is required!',
            'unit.required' => 'Unit  is required!',
        ]);

        if ($request['discount_type'] == 'percent') {
            $dis = ($request['unit_price'] / 100) * $request['discount'];
        } else {
            $dis = $request['discount'];
        }

        if ($request['unit_price'] <= $dis) {
            $validator->after(function ($validator) {
                $validator->errors()->add('unit_price', 'Discount can not be more or equal to the price!');
            });
        }

        $product = Product::find($id);
        $product->details = $request->details;
        $product->name = $request->name;
        $product->charge_cat = $request->category_id;

        $product->product_type = $request->product_type ?? 0; // defines if product is downloadable or not // 1 for downloadable
        $product->download_url = $request->download_url ?? NULL;

        $category = [];
        if ($request->category_id != null) {
            array_push($category, [
                'id' => $request->category_id,
                'position' => 1,
            ]);
        }
        if ($request->sub_category_id != null) {
            array_push($category, [
                'id' => $request->sub_category_id,
                'position' => 2,
            ]);
        }
        if ($request->sub_sub_category_id != null) {
            array_push($category, [
                'id' => $request->sub_sub_category_id,
                'position' => 3,
            ]);
        }
        $product->category_ids = json_encode($category);
        $product->brand_id = $request->brand_id;
        $product->unit = $request->unit;
        $product->details = $request->details;

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = product_image($img);
            }
            $product->images = json_encode($product_images);
        }
        if ($request->file('image')):
            $product->thumbnail = product_thumnail_image($request->file('image'));
        endif;

        //$product_images = json_decode($product->images);
        //if ($request->file('images')) {
        //   foreach ($request->file('images') as $img) {
        //        $product_images[] = ImageManager::upload('product/', 'png', $img);
        //    }
        //    $product->images = json_encode($product_images);
        //}

        //if ($request->file('image')) {
        //    $product->thumbnail = p_thumnail_image($request->file('image'));
        //}


        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $product->colors = json_encode($request->colors);
        } else {
            $colors = [];
            $product->colors = json_encode($colors);
        }
        $choice_options = [];
        if ($request->has('choice')) {
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_' . $no;
                $item['name'] = 'choice_' . $no;
                $item['title'] = $request->choice[$key];
                $item['options'] = explode(',', implode('|', $request[$str]));
                array_push($choice_options, $item);
            }
        }
        $product->choice_options = json_encode($choice_options);
        $variations = [];
        //combinations start
        $options = [];
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }
        //Generates the combinations of customer choice options
        $combinations = Helpers::combinations($options);
        $variations = [];
        $stock_count = 0;
        if (count($combinations[0]) > 0) {
            foreach ($combinations as $key => $combination) {
                $str = '';
                foreach ($combination as $k => $item) {
                    if ($k > 0) {
                        $str .= '-' . str_replace(' ', '', $item);
                    } else {
                        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
                            $color_name = Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        } else {
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }
                $item = [];
                $item['type'] = $str;
                $item['price'] = Convert::usd(abs($request['price_' . str_replace('.', '_', $str)]));
                $item['sku'] = $request['sku_' . str_replace('.', '_', $str)];
                $item['qty'] = $request['qty_' . str_replace('.', '_', $str)];
                array_push($variations, $item);
                $stock_count += $item['qty'];
            }
        } else {
            $stock_count = (int)$request['current_stock'];
        }
        //if ((int)$request['current_stock'] != $stock_count) {
        //   $validator->after(function ($validator) {
        //        $validator->errors()->add('total_stock', 'Stock calculation mismatch!');
        //    });
        //}

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        //combinations end
        $product->variation = json_encode($variations);
        $product->unit_price = Convert::usd($request->unit_price);
        $product->purchase_price = Convert::usd($request->purchase_price);
        // $product->tax = $request->tax;
        $product->tax = 8.25; //$request->tax == 'flat' ? BackEndHelper::currency_to_usd($request->tax) : $request->tax;
        $product->tax_type = 'percent'; //$request->tax_type;
        
        $product->height = $request->height;
        $product->length = $request->length;
        $product->width = $request->width;
        $product->weight = $request->weight;
        
        // $product->tax_type = $request->tax_type;
        $product->discount = $request->discount_type == 'flat' ? Convert::usd($request->discount) : $request->discount;
        $product->attributes = json_encode($request->choice_attributes);
        $product->discount_type = $request->discount_type;
        $product->current_stock = $request->current_stock;
        
        $_f_data = [];
        if ($request->has('_data')) {
            $_f_data =  array_filter($request->input('_data'));
        }
        $product->extra_data = json_encode($_f_data);

        /**
         * Grab category info via charge_cat
         * Calculate product commision per product
         */
        $p_cat = Category::find($request->category_id);
        if($p_cat->commision_type == 'combined_fee'){
            $commission = ((($request->purchase_price / 100) * $p_cat->percentage) + $p_cat->flat);
        } elseif($p_cat->commision_type == 'flat_fee') {
            $commission = $p_cat->flat;
        } elseif($p_cat->commision_type == 'percentage') {
            $commission = (($request->purchase_price / 100) * $p_cat->percentage);
        }

        $product->commission = BackEndHelper::currency_to_usd($commission);
        $product->save();

        Toastr::success('Product updated successfully!');
        return back();
        return response()->json([], 200);
    }

    public function view($id)
    {
        $product = Product::with(['reviews'])->where(['id' => $id])->first();
        return view('seller-views.product.view', compact('product'));
    }

    public function remove_image(Request $request)
    {
        ImageManager::delete('/product/' . $request['image']);
        $product = Product::find($request['id']);
        $array = [];
        if (count(json_decode($product['images'])) < 2) {
            Toastr::warning('You cannot delete all images!');
            return back();
        }
        foreach (json_decode($product['images']) as $image) {
            if ($image != $request['name']) {
                array_push($array, $image);
            }
        }
        Product::where('id', $request['id'])->update([
            'images' => json_encode($array),
        ]);
        Toastr::success('Product image removed successfully!');
        return back();
    }

    public function delete($id)
    {
        $product = Product::find($id);
        foreach (json_decode($product['images'], true) as $image) {
            ImageManager::delete('/product/' . $image);
        }
        ImageManager::delete('/product/thumbnail/' . $product['thumbnail']);
        $product->delete();
        FlashDealProduct::where(['product_id' => $id])->delete();
        DealOfTheDay::where(['product_id' => $id])->delete();
        Toastr::success('Product removed successfully!');
        return back();
    }

    public function import()
    {
        $result = [];
        if (request()->file('file')) {
            $result = csvToArray(request()->file('file'));
            if ($result) {
                $resp = [];
                $resp[] = $result;
            }
            return view('seller-views.product.import', compact('result'));
        } else if ($productImages = request()->allFiles('productImages')) {
            foreach ($productImages as $key => $value) {
                upload_product_image($value);
                upload_product_thumnail_image($value);
            }
        }
        return view('seller-views.product.import', compact('result'));
    }

    public function promote()
    {
        $product = [];
        if (request()->post()) {
            $id = request()->input('id');
            $promo['days'] = 7;
            $promo['amount'] = 5000;
            $products = Product::find($id);
            $promotion = Promotion::all();
            return view('seller-views.product.promote', compact('products', 'promo', 'promotion'));
        }
        $query = [
            'added_by' => 'seller',
            'user_id'           => auth('seller')->id(),
            'featured_status'   =>  true
        ];
        $products = Product::where($query)->latest()->paginate(10);
        return view('seller-views.product.promote', compact('products'));
    }

    public function terminate_promote($id)
    {
        $product = Product::find($id);
        $product->featured_status = 0;
        $product->save();
        $this->updateUserPromotion($id, 'remove');
        Toastr::success("Promotion/Sponsor discountinued for $product->name");
        return back();
    }

    public function add_promote($id, $duration)
    {
        $product = Product::find($id);
        $product->featured_status = 1;
        $product->save();
        $this->updateUserPromotion($id, 'add', $duration);
        Toastr::success("$product->name added to Promotion/Sponsor");
        return back();
    }

    public function updateUserPromotion($id, $action, $duration = NULL)
    {
        if ($action == 'add') {
            PromotionData::insert([
                'user_id'   => auth('seller')->id(),
                'expires_at' =>  Carbon::now()->addDays($duration),
                'product_id' =>  $id
            ]);
        }
        if ($action == 'remove') {
            $product = Product::find($id);
            $product->featured_status = 0;
            $product->save();
            $remove = PromotionData::destroy($id);
        }
        return true;
    }

    public function bulk_import_index()
    {
        return view('seller-views.product.bulk-import');
    }

    public function bulk_import_data(Request $request)
    {
        if (checkSellerLimit() === false) {
            Toastr::success('Product Limit reached, Please upgrade your plan to add more products');
            return back();
        }

        try {
            $collections = (new FastExcel)->import($request->file('products_file'));
        } catch (\Exception $exception) {
            Toastr::error('You have uploaded a wrong format file, please upload the right file.');
            return back();
        }
        $data = [];
        $skip = ['youtube_video_url', 'details', 'thumbnail'];
        foreach ($collections as $collection) {
            foreach ($collection as $key => $value) {
                if ($key != "" && $value === "" && !in_array($key, $skip)) {
                    Toastr::error('Please fill ' . $key . ' fields');
                    return back();
                }
            }

            $thumbnail = explode('/', $collection['thumbnail']);

            array_push($data, [
                'name' => $collection['name'],
                'slug' => Str::slug($collection['name'], '-') . '-' . Str::random(6),
                'category_ids' => json_encode([['id' => (string)$collection['category_id'], 'position' => 1], ['id' => (string)$collection['sub_category_id'], 'position' => 2], ['id' => (string)$collection['sub_sub_category_id'], 'position' => 3]]),
                'brand_id' => $collection['brand_id'],
                'unit' => $collection['unit'],
                'min_qty' => $collection['min_qty'],
                'refundable' => $collection['refundable'],
                'unit_price' => $collection['unit_price'],
                'purchase_price' => $collection['purchase_price'],
                'tax' => $collection['tax'],
                'discount' => $collection['discount'],
                'discount_type' => $collection['discount_type'],
                'current_stock' => $collection['current_stock'],
                'details' => $collection['details'],
                'video_provider' => 'youtube',
                'video_url' => $collection['youtube_video_url'],
                'images' => json_encode(['def.png']),
                'thumbnail' => $thumbnail[1] ?? $thumbnail[0],
                'status' => 0,
                'colors' => json_encode([]),
                'attributes' => json_encode([]),
                'choice_options' => json_encode([]),
                'variation' => json_encode([]),
                'featured_status' => 1,
                'added_by' => 'seller',
                'user_id' => auth('seller')->id(),
            ]);
        }
        DB::table('products')->insert($data);
        Toastr::success(count($data) . ' - Products imported successfully!');
        return back();
    }

    public function bulk_export_data()
    {
        $products = Product::where(['added_by' => 'seller', 'user_id' => auth('seller')->id()])->get();
        //export from product
        $storage = [];
        foreach ($products as $item) {
            $category_id = 0;
            $sub_category_id = 0;
            $sub_sub_category_id = 0;
            foreach (json_decode($item->category_ids, true) as $category) {
                if ($category['position'] == 1) {
                    $category_id = $category['id'];
                } else if ($category['position'] == 2) {
                    $sub_category_id = $category['id'];
                } else if ($category['position'] == 3) {
                    $sub_sub_category_id = $category['id'];
                }
            }
            $storage[] = [
                'name' => $item->name,
                'category_id' => $category_id,
                'sub_category_id' => $sub_category_id,
                'sub_sub_category_id' => $sub_sub_category_id,
                'brand_id' => $item->brand_id,
                'unit' => $item->unit,
                'min_qty' => $item->min_qty,
                'refundable' => $item->refundable,
                'youtube_video_url' => $item->video_url,
                'unit_price' => $item->unit_price,
                'purchase_price' => $item->purchase_price,
                'tax' => $item->tax,
                'discount' => $item->discount,
                'discount_type' => $item->discount_type,
                'current_stock' => $item->current_stock,
                'details' => $item->details,
                'thumbnail' => 'thumbnail/' . $item->thumbnail

            ];
        }
        return (new FastExcel($storage))->download('products.xlsx');
    }
}
