<?php

namespace App\Http\Controllers;

use App\Models\ReturnModel;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     * DETAILS	PRODUCTS	TYPE	STATUS	LAST UPDATED
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $returns = ReturnModel::where('shop_id', shop())->orderBy('created_at', 'DESC')->with('user')->with('shop')->get();
            return DataTables::of($returns)
                    ->editColumn('updated_at', function($data){
                        return show_datetime($data->updated_at);
                    })->make(true);
        }
        return view('vendor.returns');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $returns = ReturnModel::where('id', $id)->get();
        return view('vendor.show_return', compact('returns'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
