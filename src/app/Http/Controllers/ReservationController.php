<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function thanks(ReservationRequest $request) {
        Reservation::create([
            'shop_id' => $request->shop_id,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
        ]);
        return view('reservation.thanks');
    }

    public function edit($id)
    {
        $reservation = Reservation::find($id);
        $formattedTime = Carbon::parse($reservation->time)->format('H:i');
        $shop = Shop::find($reservation->shop_id);
        $times = Reservation::getTimes();
        return view('reservation.edit', compact('reservation','shop','times', 'formattedTime'));
    }

    public function update (ReservationRequest $request) {
        $oldReservation = Reservation::find($request->id);
        $oldReservation->date = $request->date;
        $oldReservation->time = $request->time;
        $oldReservation->number = $request->number;
        $oldReservation->save();
        return redirect('mypage')->with('message_reservation', '修正しました。');
    }

    public function destroy(Request $request)
    {
        Reservation::find($request->id)->delete();
        return redirect('mypage')->with('message_reservation', 'キャンセルしました。');
    }
}
