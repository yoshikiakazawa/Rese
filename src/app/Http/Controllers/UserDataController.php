<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserDataController extends Controller
{
    public function myPage() {
        $today = Carbon::now()->format('Y-m-d');
        $user = Auth::user();
        $shops = Shop::with(['area', 'genre'])->get();
        $reservations = Reservation::where('user_id', $user->id)
        ->where('date','>',$today)
        ->orWhere('user_id', $user->id)->Where('date','=',$today)->orderBy('date')
        ->orderBy('time')
        ->get();
        $favorites = [];
        if (Auth::check()) {
            $favorites = Favorite::where('user_id', Auth::id())->pluck('shop_id')->toArray();
        }
        $favoriteShops = Shop::whereIn('id', $favorites)->get();
        return view('mypage', compact('user','shops', 'reservations','favorites', 'favoriteShops'));
    }

    public function myPageHistory (){
        $today = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');
        $user = Auth::user();
        $shops = Shop::with(['area', 'genre'])->get();
        $reservations = Reservation::where('user_id', $user->id)
        ->where('date','<',$today)
        ->orWhere('user_id', $user->id)->Where('date','=',$today)
        ->where('time','<',$currentTime)->orderBy('date', 'desc')
        ->orderBy('time', 'desc')
        ->get();
        return view ('history', compact('user','shops', 'reservations'));
    }

    public function rank (Request $request) {
        $rank = Reservation::find($request->id);
        if (empty($rank->rank)) {
            $rank->rank = $request->rank;
            $rank->comment = $request->comment;
            $rank->save();
            return redirect()->back()->with('message', '評価しました。');
        }
        $rank->rank = $request->rank;
        $rank->comment = $request->comment;
        $rank->save();
        return redirect()->back()->with('message', '評価を修正しました。');
    }

}
