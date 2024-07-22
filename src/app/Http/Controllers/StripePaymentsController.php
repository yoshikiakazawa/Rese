<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use App\Models\Reservation;

class StripePaymentsController extends Controller
{
    public function amount(Request $request)
    {
        $reservation = Reservation::find($request->id);
        if (empty($reservation->amount)) {
                $amount = $request->input('amount');
                $reservation->amount = $amount;
                $reservation->payment_status = false;
                $reservation->save();
                return redirect()->back()->with('message', '金額を確定しました');
        }
        $amount = $request->input('amount');
        $reservation->amount = $amount;
        $reservation->payment_status = false;
        $reservation->save();
        return redirect()->back()->with('message', '金額を修正しました');
    }

    public function payment(Request $request)
    {
        $reservation = Reservation::find($request->id);
        if ($reservation->payment_status === 0) {
            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));

                $reservation->payment_status = true;
                $reservation->save();

                $customer = Customer::create(array(
                    'email' => $request->stripeEmail,
                    'source' => $request->stripeToken
                ));
                $charge = Charge::create(array(
                    'customer' => $customer->id,
                    'amount' => $reservation->amount,
                    'currency' => 'jpy'
                ));
                return redirect()->back()->with('message', '支払いが成功しました');
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }
        }
        return redirect()->back()->with('message', '支払い済みです');
    }
}
