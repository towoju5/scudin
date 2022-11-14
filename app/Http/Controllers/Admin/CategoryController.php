<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        // $categories=Category::where(['position'=>0])->latest()->paginate(10);
        // return view('admin-views.category.view',compact('categories'));
        $Category = Category::where(['position' => 0])->latest();
        if (request()->ajax()) {
            return DataTables::of($Category)->editColumn('created_at', function ($data) {
                return show_datetime($data->created_at);
            })->make(true);
        }

        return view('categories.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cat_name' => 'required',
            'cat_image' => 'required'
        ], [
            'cat_name.required' => 'Category name is required!',
            'cat_image.required' => 'Category image is required!',
        ]);

        $category = new Category;
        $category->name             = $request->cat_name;
        $category->slug             = Str::slug($request->cat_name);
        $category->commision_type   = $request->commision_type;
        // $category->commision        = $request->cat_image;
        $category->flat             = $request->flat ?? 0;
        $category->percentage       = $request->percentage ?? 0;
        $category->icon             =  save_image('category', $request->file('cat_image'));
        $category->parent_id        = 0;
        $category->position         = 0;
        $category->save();

        Toastr::success('Category added successfully!');
        return back();
    }

    public function edit(Request $request)
    {
        $data = Category::where('id', $request->id)->first();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($request->image) {
            $category = save_image('category', $request->image);
        }
        $category->parent_id = 0;
        $category->position = 0;
        $category->commision_type   = $request->commision_type;
        $category->flat             = $request->flat ?? 0;
        $category->percentage       = $request->percentage ?? 0;
        $category->save();
        Toastr::success('Category updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $categories = Category::where('parent_id', $request->id)->get();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $categories1 = Category::where('parent_id', $category->id)->get();
                if (!empty($categories1)) {
                    foreach ($categories1 as $category1) {
                        Category::destroy($category1->id);
                    }
                }
                Category::destroy($category->id);
            }
        }
        Category::destroy($request->id);
        return response()->json();
    }

    public function fetch(Request $request)
    {
        $Category = Category::find($request->id);
        return response()->json($Category);
        
        if ($request->ajax()) {
            $data = Category::where('position', 0)->orderBy('id', 'desc')->get();
            return response()->json($data);
        }
    }
}
