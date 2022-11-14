<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Promotion;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotions = Promotion::paginate(15);
        return view('admin-views.promotion.index', compact('promotions')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-views.promotion.create');
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
            'name'      => 'required',
            'duration'  => 'required|max:31',
            'cost'      => 'required',
        ]);

        $save = Promotion::create([
            'name'      =>  $request->name,
            'duration'  =>  $request->duration,
            'cost'      =>  $request->cost,
        ]);

        if ($save) {
            Toastr::success('Promotion data added successfully!');
            return back();
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
        $promotion = Promotion::find($id);
        return view('admin-views.promotion.show', compact('promotion')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $promotion = Promotion::find($id);
        return view('admin-views.promotion.edit', compact('promotion')); 
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
        $request->validate([
            'name'      => 'required',
            'duration'  => 'required|max:31',
            'cost'      => 'required',
        ]);

        $promotion = Promotion::find($id);
        $promotion->name      =  $request->name;
        $promotion->duration  =  $request->duration;
        $promotion->cost      =  $request->cost;
        if ($promotion->save()) {
            Toastr::success('Promotion data updated successfully!');
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
        if (Promotion::destroy($id)) {
            Toastr::success('Promotion data deleted successfully!');
            return back();
        }else{
            Toastr::success('unable to complete action');
            return back();
        }
    }
}

