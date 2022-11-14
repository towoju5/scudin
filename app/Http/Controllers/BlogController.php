<?php

namespace App\Http\Controllers;

use App\BlogModel;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all Blog Post
        $posts = BlogModel::all();
        return view('admin-views.blog.index', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        // Get all Blog Post
        $posts = BlogModel::join('admins', 'admins.id', '=', 'blog.author')->paginate(12);
        return view('web-views.blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-views.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = blog_url($request->title);
        if ($request->hasFile('image')) {
            $image = save_image('blog', $request->file('image'));
        }
        // return $image;
        $addPost = BlogModel::insert([
            'title'     =>  $request->title,
            'body'      =>  $request->body,
            'slug'      =>  $slug,
            'blog_image'=>  $image ?? NULL,
            'author'    =>  auth('admin')->id()
        ]);

        if ($addPost) {
            Toastr::success("Blog post added successfully");
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // $posts = BlogModel::findorFail($id);
        $post = BlogModel::where('slug', $slug)->first();
        if (!$post || empty($post)) {
            return response()->view('errors.404', ['error' => 'Not Found'], 404);
        }
        return view('web-views.blog.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = BlogModel::where(['id'=>$id, 'author' => auth('admin')->id()])->first();
        return view('admin-views.blog.edit', compact('blog'));
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
        $post = BlogModel::find($id);
        $post->title = $request->title;
        $post->body = $request->body;
        if ($request->hasFile('image')) {
            $post->blog_image = save_image('blog', $request->file('image'));
        }
        if ($post->save()) {
            Toastr::success("Blog post updated successfully");
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (BlogModel::destroy($id)) {
            Toastr::success("Blog post deleted successfully");
            return back();
        }
    }
}
