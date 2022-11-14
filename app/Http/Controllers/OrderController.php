<?php

declare(strict_types=1);

/**
 * Contains the OrderController class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-17
 *
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderDetail;
use Illuminate\Http\Request;
// use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Framework\Contracts\Requests\UpdateOrder;
// use Vanilo\Order\Contracts\Order;
use Vanilo\Order\Contracts\OrderAwareEvent;
use Vanilo\Order\Events\OrderWasCancelled;
use Vanilo\Order\Events\OrderWasCompleted;
// use Vanilo\Order\Models\Order as ModelsOrder;
use Vanilo\Order\Models\OrderProxy;
use Vanilo\Order\Models\OrderStatus;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = 'all';
        return $orders = OrderDetail::with('order.customer', 'order')->where(['seller_id' => auth('seller')->id(), 'delivery_status' => $status])->latest()->paginate(25);

        $inactives = $request->has('inactives');
        if (!$inactives) {
            $query->open();
        }

        if ($request->ajax()) {
            return datatables()->of($query)->toJson();
        }
        return view('orders.index', [
            'orders' => $query->paginate(10),
            'inactives' => $inactives,
        ]);
    }

    public function show(Order $order, Request $request, $id)
    {
        // $result = ModelsOrder::where('orders.id', $id)->join('order_items', 'orders.id', '=', 'order_items.order_id')->first();
         $order = OrderProxy::find($id);
        //  return $order->billpayer;
        return view("orders.show", ['order' => $order]);
    }

    public function update(Order $order, UpdateOrder $request)
    {
        try {
            $event = null;
            if ($request->wantsToChangeOrderStatus($order)) {
                $event = $this->getStatusUpdateEventClass($request->getStatus(), $order);
            }

            $order->update($request->all());

            if (null !== $event) {
                event($event);
            }

            // flash()->success(__('Order :no has been updated', ['no' => $order->number]));
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with(__('Error: :msg', ['msg' => $e->getMessage()]));
        }

        return redirect(route('orders.show', $order));
    }

    public function destroy(Order $order)
    {
        try {
            $number = $order->getNumber();
            $order->delete();

            flash()->warning(__('Order :no has been deleted', ['no' => $number]));
        } catch (\Exception $e) {
            return redirect()->back()->with(__('Error: :msg', ['msg' => $e->getMessage()]));
        }

        return redirect(route('vanilo.order.index'));
    }

    private function getStatusUpdateEventClass(string $status, Order $order): ?OrderAwareEvent
    {
        if (OrderStatus::CANCELLED === $status) {
            return new OrderWasCancelled($order);
        }

        if (OrderStatus::COMPLETED === $status) {
            return new OrderWasCompleted($order);
        }

        return null;
    }
}
