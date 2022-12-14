<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SubSubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where(['position' => 2]);
        if (request()->ajax()) {
            return DataTables::of($categories)->editColumn('created_at', function ($data) {
                return show_datetime($data->created_at);
            })->make(true);
        }
        // return view('admin-views.category.sub-sub-category-view', compact('categories'));
        return view('categories.sub-sub-category-view', compact('categories'));
    }

    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if($request->has('cat_image')){
            $category->icon = save_image('category', $request->cat_image);
        }
        $category->parent_id = $request->parent_id;
        $category->position = 2;
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
        $category->position = 2;
        if($request->has('cat_image')) {
            $category->icon = save_image('category', $request->cat_image);
        }
        $category->save();
        return response()->json();
    }
    public function delete(Request $request)
    {
        Category::destroy($request->id);
        return response()->json();
    }
    public function fetch(Request $request, $id)
    {
        $Category = Category::find($id);
        return response()->json($Category);
        if ($request->ajax()) {
            $data = Category::where('position', 2)->orderBy('id', 'desc')->get();
            return response()->json($data);
        }
    }

    public function getSubCategory(Request $request)
    {
        $data = Category::where("parent_id", $request->id)->get();
        $output = "";
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->name . '</option>';
        }
        echo $output;
    }

    public function getCategoryId(Request $request)
    {
        $data = Category::where('id', $request->id)->first();
        return response()->json($data);
    }
}
