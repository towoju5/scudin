<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Illuminate\Support\Facades\Auth;
use Konekt\Address\Models\CountryProxy;
use Vanilo\Cart\Contracts\CartManager;
use Vanilo\Checkout\Contracts\Checkout;
use Vanilo\Order\Contracts\OrderFactory;
// use Vanilo\Order\Models\Order;
use Vanilo\Payment\Factories\PaymentFactory;
use Vanilo\Payment\Models\PaymentMethod;
use Vanilo\Payment\PaymentGateways;
use Vanilo\Framework\Models\Order;

class CheckoutController extends Controller
{
    /** @var Checkout */
    private $checkout;

    /** @var Cart */
    private $cart;

    public function __construct(Checkout $checkout, CartManager $cart)
    {
        $this->checkout = $checkout;
        $this->cart     = $cart;
    }

    public function show()
    {
        $checkout = false;

        if ($this->cart->isNotEmpty()) {
            return $this->checkout;
            $checkout = $this->checkout;
            if ($old = old()) {
                $checkout->update($old);
            }

            $checkout->setCart($this->cart);
        }

        return view('checkout.show', [
            'checkout'  => $checkout,
            'countries' => CountryProxy::all(),
            'paymentMethods' => PaymentMethod::actives()->get(),
        ]);
    }

    public function submit(CheckoutRequest $request, OrderFactory $orderFactory)
    {
        $this->checkout->update($request->all());
        $this->checkout->setCustomAttribute('notes', $request->get('notes'));
        $this->checkout->setCart($this->cart);

        /** @var Order $order */
        $order = $orderFactory->createFromCheckout($this->checkout);
        $order->getBillpayer()->email = Auth::user()->email;
        $order->getBillpayer()->save();
        $order->notes = $request->get('notes');

        $paymentMethod = PaymentMethod::find($request->get('paymentMethod'));
        $payment = PaymentFactory::createFromPayable($order, $paymentMethod);
        $gateway = PaymentGateways::make($paymentMethod->gateway);
        $paymentRequest = $gateway->createPaymentRequest($payment);
        
        return view('checkout.thankyou', [
            'order' => $order,
            'paymentRequest' => $paymentRequest
        ]);
        // $order->save();
        // $this->cart->destroy();
        
        return view('checkout.thankyou', ['order' => $order]);
    }

}
