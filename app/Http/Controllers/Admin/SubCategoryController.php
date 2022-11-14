<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories=Category::where(['position'=>1]);
        if (request()->ajax()) {
            return DataTables::of($categories)->editColumn('created_at', function ($data) {
                return show_datetime($data->created_at);
            })->make(true);
        }
        return view('categories.sub-category-view',compact('categories'));
    }

    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->cat_name;
        $category->slug = Str::slug($request->cat_name);
        $category->icon = save_image('category', $request->file('cat_image'));;//ImageManager::upload('category/', 'png', $request->file('cat_image'));
        $category->parent_id = $request->parent_id;
        $category->position = 1;
        $category->save();
        return response()->json();
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
        $category->parent_id = $request->parent_id;
        $category->position = 1;
        if ($request->hasFile('cat_image')) {
            $category->icon = save_image('category', $request->cat_image);
        }
        $category->save();
        return response()->json();
    }

    public function delete(Request $request)
    {
        $categories = Category::where('parent_id', $request->id)->get();
        if (!empty($categories)) {

            foreach ($categories as $category) {
                Category::destroy($category->id);
            }
        }
        Category::destroy($request->id);
        return response()->json();
    }

    public function fetch(Request $request, $id)
    {
        $Category = Category::find($id);
        return response()->json($Category);
        if ($request->ajax()) {
            $data = Category::find($id);
            return response()->json($data);
        }
    }
}
