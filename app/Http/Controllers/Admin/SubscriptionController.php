<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Subscription;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscription = Subscription::all();
        if (request()->ajax()) {
            return DataTables::of($subscription)
            ->editColumn('created_at', function ($data) {
                return show_datetime($data->created_at);
            })
            ->editColumn('created_at', function ($data) {
                return show_datetime($data->created_at);
            })
            ->make(true);
        }
        return view('admin-views.subscription.list', $subscription);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sub_list()
    {
        $where = [];
        $users  = User::where('plan_id', '!=', '1')->where($where)->with(['plan'])->get();
        $sellers= Seller::where('plan_id', '!=', '1')->where($where)->get();
        [
            'users' => $users,
            'sellers'=> $sellers
        ];
        return view('admin-views.subscription.index', compact('users', 'sellers'));
    }

    public function add_subscription(Request $request)
    {
        if (!auth('admin')->check()) {
            Toastr::info("Unathenticated user");
            return back();
        }
        if ($request->post()) {
            $plans = Subscription::insert([
                'plan_name'    => $request->plan_name,
                'plan_price'   => $request->plan_price,
                'plan_duration'    => $request->plan_duration,
                'plan_user_type'   => $request->plan_user_type,
                'allowed_products' => $request->allowed_products,
                'description'   => $request->description
            ]);
            Toastr::info("Plan added successfully");
            return back();
        }
        return view('admin-views.subscription.add');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id=null)
    {
        $plan = Subscription::find($request->id);
        return view('admin-views.subscription.edit', compact('plan'));
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
        if (!auth('admin')->check()) {
            Toastr::info("Unathenticated user");
            return back();
        }
        $plan = Subscription::find($id);
        if ($request->post()) {
            $plan->plan_name    = $request->plan_name;
            $plan->plan_price   = $request->plan_price;
            $plan->plan_duration    = $request->plan_duration;
            $plan->plan_user_type   = $request->plan_user_type;
            $plan->allowed_products = $request->allowed_products;
            $plan->description   = $request->description;
            $plan->save();
            Toastr::info("Plan updated successfully");
            return redirect()->route('admin.subscription.list');
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
        if($id === 1){
            return response()->json(['error' => 'Plan can not be deleted!']);
        }
        if(Subscription::find($id)->delete()){
            return response()->json(['success' => 'Plan Deleted Successfully']);
        }
    }
}
