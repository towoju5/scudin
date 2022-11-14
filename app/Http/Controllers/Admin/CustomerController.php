<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customer_list(Request $request)
    {
        $where = [];
        $customers = User::with(['orders'])->latest()->paginate(15);
        if($request->has('customer') && !empty($request->customer)){
            $cust = $request->customer;
            $customers = User::where('email', $cust)->orWhere('phone', $cust)->orWhere('name', 'like', '%' . $cust. '%')->with(['orders'])->latest()->paginate(15);
        }
        return view('admin-views.customer.list', compact('customers'));
    }

    public function view($id)
    {
        $customer = User::find($id);
        if (isset($customer)) {
            $orders = Order::latest()->where(['customer_id' => $id])->paginate(10);
            return view('admin-views.customer.customer-view', compact('customer', 'orders'));
        }
        Toastr::error('Customer not found!');
        return back();
    }

    public function delete($id)
    {
        if (User::find($id)->delete()) {
            Toastr::success("Customer suspeneded");
            return back();
        }
        Toastr::error('Unknown Error!');
        return back();
    }
}
