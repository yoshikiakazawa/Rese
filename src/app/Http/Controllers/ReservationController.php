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
        return view('reservation_thanks');
    }
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $formattedTime = Carbon::parse($reservation->time)->format('H:i');
        $shop = Shop::findOrFail($reservation->shop_id);
        $times = [
            '11:00', '11:30', '12:00', '12:30', '13:00', '13:30',
            '14:00', '14:30', '15:00', '15:30', '16:00', '16:30',
            '17:00', '17:30', '18:00', '18:30', '19:00', '19:30',
            '20:00', '20:30', '21:00', '21:30', '22:00'
        ];
        return view('reservation-edit', compact('reservation','shop','times', 'formattedTime'));
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
