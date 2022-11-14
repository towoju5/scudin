<?php

namespace App\Http\Controllers;

use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * Category means category ex: smartphone Taxon means sub category ex: iPhone, Samsung, Xiaomi, Nokia et al.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Category = Category::where(['position'=>0])->latest();
        if (request()->ajax()) {
            return DataTables::of($Category)->editColumn('created_at', function ($data) {
                return show_datetime($data->created_at);
            })->make(true);
        }
       
        return view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cat_name' => 'required',
            'cat_image'=> 'required'
        ], [
            'cat_name.required' => 'Category name is required!',
            'cat_image.required' => 'Category image is required!',
        ]);

        // if(!empty($request->cat_image)){
        //     $cat_image = save_image('category', $request->cat_image);
        //     unset($request->cat_image);
        // }

        $category = new Category;
        $category->name = $request->cat_name;
        $category->slug = Str::slug($request->cat_name);
        $category->icon = save_image('storage', $request->file('cat_image'));
        $category->parent_id = 0;
        $category->position = 0;

        if ($category->save()) {
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'code' => 200,
                'error_message' => 'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Category = Category::find($id);
        return response()->json($Category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        if(!empty($request->image)){
            $cat_image = save_image('category', $request->image);
            unset($request->cat_image);
        }

        $category = Category::find($id);
        $category->name = $request->name;
        $category->icon = $cat_image;
        $category->commision_type= $request->commision_type;
        $category->p_type        = $request->p_type;
        $category->flat          = $request->flat ?? 0;
        $category->percentage    = $request->percentage ?? 0;
        $category->save();

        return response()->json([
            'code' => 200,
            'message' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

}