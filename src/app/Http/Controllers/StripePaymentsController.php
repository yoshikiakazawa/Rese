<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use App\Models\Reservation;

class StripePaymentsController extends Controller
{
    public function payment(Request $request)
    {
        $reservation = Reservation::find($request->id);
        if (empty($reservation->amount)) {
            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $amount = $request->input('amount');
                $reservation->amount = $amount;
                $reservation->save();
                $customer = Customer::create(array(
                    'email' => $request->stripeEmail,
                    'source' => $request->stripeToken
                ));
                $charge = Charge::create(array(
                    'customer' => $customer->id,
                    'amount' => $amount,
                    'currency' => 'jpy'
                ));
                return back();
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }
        }
        return redirect()->back()->with('message', '支払い済みです');
    }
}
