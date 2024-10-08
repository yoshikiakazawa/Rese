<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function index() {
        $owner = Auth::user();
        $shops = Shop::where('owner_id', $owner->id)->with(['area', 'genre'])->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('owner.index', compact('owner', 'shops', 'areas', 'genres'));
    }

    public function show($id) {
        $owner = Auth::user();
        $shop = Shop::where('id', $id)->with(['area', 'genre'])->first();
        $areas = Area::all();
        $genres = Genre::all();
        return view('owner.show', compact('owner', 'shop', 'areas', 'genres'));
    }

    public function history($id) {
        $owner = Auth::user();
        $shop = Shop::where('id', $id)->with(['area', 'genre'])->first();
        $today = Carbon::now()->format('Y-m-d');
        $reservations = Reservation::where('shop_id', $id)->with('user')
        ->where('date','>',$today)
        ->orWhere('shop_id', $id)->Where('date','=',$today)->orderBy('date')
        ->orderBy('time')
        ->get();
        return view('owner.history', compact('owner', 'shop', 'reservations'));
    }

    public function pastHistory($id) {
        $owner = Auth::user();
        $shop = Shop::where('id', $id)->with(['area', 'genre'])->first();
        $today = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');
        $reservations = Reservation::where('shop_id', $id)->with('user')
        ->where('date','<',$today)
        ->orWhere('shop_id', $id)->Where('date','=',$today)
        ->where('time','<',$currentTime)->orderBy('date', 'desc')
        ->orderBy('time', 'desc')
        ->get();

        return view('owner.past-history', compact('owner', 'shop', 'reservations'));
    }
}
