<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vanilo\Payment\PaymentGateways;
use Vanilo\Payment\Models\PaymentMethod;
use Vanilo\Payment\Models\Payment;
use Vanilo\Payment\Models\PaymentStatus;
use Vanilo\Payment\Events\PaymentPartiallyReceived;
use Vanilo\Payment\Events\PaymentCompleted;
use Vanilo\Payment\Events\PaymentDeclined;

class PaypalReturnController extends Controller
{
    public function cancel(Request $request, string $paymentId)
    {
        $payment = Payment::findByPaymentId($paymentId);

        return view('payment.cancel', [ // The view is from your application
            'payment' => $payment,
            'order'   => $payment->getPayable(),
        ]);
    }

    public function return(Request $request, string $paymentId)
    {
        Log::debug('PayPal return', $request->toArray());

        $response = PaymentGateways::make('paypal')->processPaymentResponse($request);
        $payment  = Payment::findByPaymentId($paymentId);
        return var_dump($payment);

        if (!$payment) {
            // This returns an HTTP response in the format that Paypal understands
            return new ErrorResponseToPaypal(404, 'Could not locate payment with id ' . $response->getPaymentId());
        }

        if ($response->wasSuccessful()) {
            $payment->amount_paid = $response->getAmountPaid();
            if ($response->getAmountPaid() < $payment->getAmount()) {
                $payment->status = PaymentStatus::PARTIALLY_PAID();
                $payment->save();
                event(new PaymentPartiallyReceived($payment, $response->getAmountPaid()));
            } else {
                $payment->status = PaymentStatus::PAID();
                $payment->save();
                event(new PaymentCompleted($payment));
            }
            // $order->save();
            // $this->cart->destroy();
            return view('payment.success', [ // The view is from your application
                'payment' => $payment,
                'order'   => $payment->getPayable(),
            ]);
        } else {
            $payment->status = PaymentStatus::DECLINED();
            $payment->save();
            event(new PaymentDeclined($payment));
        }
    }

}