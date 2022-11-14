<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Units as units;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnitsController extends Controller
{
    public function index()
    {
        $attr = units::all();
        if (request()->ajax()) {
            return datatables()->of($attr)->make();
        }
        return view('admin-views.units.view', compact('attr'));
    }

    public function store(Request $request)
    {
        $units = new units;
        $units->units = $request->name;
        $save = $units->save();
        if($save && !$request->ajax()){
            Toastr::success("Unit added successfully");
            return back();
        }
        return response()->json();
    }

    public function edit(Request $request)
    {
        $data = units::where('id', $request->id)->first();
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $units = units::find($request->id);
        $units->units = $request->name;
        $units->save();
        return response()->json();
    }
    public function delete(Request $request)
    {
        units::destroy($request->id);
        return response()->json();
    }
    public function fetch(Request $request)
    {
        $attr = units::all();
        // if (request()->ajax()) {
            return datatables()->of($attr)->make();
        // }
    }
}
