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

class StripeReturnController extends Controller
{
    public function cancel(Request $request)
    {
        $payment = Payment::findByPaymentId($request->get('orderId'));

        return view('payment.cancel', [ // The view is from your application
            'payment' => $payment,
            'order'   => $payment->getPayable(),
        ]);
    }

    public function return(Request $request)
    {
        Log::debug('Stripe return', $request->toArray());

        $response = PaymentGateways::make('stripe')->processPaymentResponse($request);
        $payment  = Payment::findByPaymentId($response->getPaymentId());

        if (!$payment) {
            // This returns an HTTP response in the format that Stripe understands
            return new ErrorResponseToStripe(404, 'Could not locate payment with id ' . $response->getPaymentId());
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
        } else {
            $payment->status = PaymentStatus::DECLINED();
            $payment->save();
            event(new PaymentDeclined($payment));
        }
    }
}
