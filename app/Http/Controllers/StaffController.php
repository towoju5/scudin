<?php

namespace App\Http\Controllers;

// use App\Models\Staff;

use App\Model\Staff;
// use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $returns = Staff::where('shop_id', shop())->orderBy('created_at', 'DESC')->get();
            return DataTables::of($returns)
                    ->editColumn('updated_at', function($data){
                        return show_datetime($data->updated_at);
                    })->make(true);
        }
        return view('seller-views.system.staffs');
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
        if (request()->ajax()) {

            $this->validate($request, [
                'staff_name' => 'required',
                'staff_password' => 'required',
                'staff_email'=> 'required',
            ]);

            if ($request->shop != auth('seller')->id()) {
                return response()->json(['error_message' => 'Only Vendor owner can add new staff']);
            }

            $Staff = Staff::create([
                'name'          => $request->staff_name,
                'email'         => $request->staff_email,
                'password'      => Hash::make($request->staff_password),
                'shop_id'       => auth('seller')->id(),
                'is_active'     => 1,
                'type'          => 'staff'
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Staff::where('id', $id)->first();
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
        if (request()->ajax()) {

            $this->validate($request, [
                'staff_name' => 'required',
                'staff_email'=> 'required',
                'staff_password' => 'required',
            ]);

            $Staff = Staff::find($id);
            $Staff->name     = $request->staff_name;
            $Staff->email    = $request->staff_email;
            $Staff->password = Hash::make($request->staff_password);
            $Staff->save();
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
        $Staff = Staff::find($id);
        $Staff->delete();
        return response()->json([
            'status' => 'success',
            'message' => "Staff has been Deleted Successfully!"
        ]);
    }
}
