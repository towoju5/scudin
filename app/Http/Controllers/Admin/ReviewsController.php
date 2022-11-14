<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Review;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    function list() {
        $reviews = Review::with(['product', 'customer'])->latest()->paginate(10);
        return view('admin-views.reviews.list', compact('reviews'));
    }
    
    function review() {
        $reviews = Rating::where('shop_id', Auth::id())->with(['product', 'user'])->latest()->paginate(1);
        return view('vendor.reviews', compact('reviews'));
    }

    public function analytics ()
    {
        return view('seller-views.system.analytics');
    }
}
