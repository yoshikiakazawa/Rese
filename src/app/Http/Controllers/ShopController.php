<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'high');

        if ($sort == 'high') {
            $shops = Shop::with('reviews')->get()->sortByDesc(function ($shop) {
                return $shop->reviews->sum('rank');
            });
        } elseif ($sort == 'low') {
            $shops = Shop::with('reviews')->get()->sortBy(function ($shop) {
                $totalRank = $shop->reviews->sum('rank');
                return $totalRank > 0 ? $totalRank : PHP_INT_MAX;
            });
        } elseif ($sort == 'random') {
            $shops = Shop::inRandomOrder()->get();
        } else {
            $shops = Shop::with('reviews')->get();
        }

        $areas = Area::all();
        $genres = Genre::all();
        $favorites = [];
        if (Auth::check()) {
            $favorites = Favorite::where('user_id', Auth::id())->pluck('shop_id')->toArray();
        }

        return view('index', compact('shops', 'areas', 'genres', 'favorites'));
    }

    public function search(Request $request) {
        $area = $request->area_id;
        $genre = $request->genre_id;
        $shop = $request->shop_name;

        $query = Shop::query();

        if (!empty($shop)) {
            $query->where(function ($q) use ($shop)
            {
                $q->where('shop_name', 'like', "%$shop%");
            });
        }

        if (!empty($area))
        {
            $query->where('area_id', $area);
        }

        if (!empty($genre))
        {
            $query->where('genre_id', $genre);
        }
        $shops = $query->get();
        $areas = Area::all();
        $genres = Genre::all();
        $favorites = [];
        if (Auth::check()) {
            $favorites = Favorite::where('user_id', Auth::id())->pluck('shop_id')->toArray();
        }
        if ($shops->isEmpty()) {
            return view('index', compact('shops', 'areas', 'genres', 'favorites'))->with('flash-message', '検索結果がありません。');
        }
        return view('index', compact('shops', 'areas', 'genres', 'favorites'));

    }
    public function toggleFavorite(Request $request)
    {
        $userId = Auth::id();
        $shopId = $request->input('shop_id');
        $favorite = Favorite::where('user_id', $userId)
            ->where('shop_id', $shopId)
            ->first();
            if ($favorite) {
                $favorite->delete();
                $isFavorite = false;
            } else {
            Favorite::create([
                'user_id' => $userId,
                'shop_id' => $shopId
            ]);
            $isFavorite = true;
        }
        return response()->json(['success' => true, 'is_favorite' => $isFavorite]);
    }

    public function detail($id)
    {
        $shop = Shop::find($id);
        $myReview = Review::where('user_id', Auth::id())->where('shop_id', $id)->first();
        $otherReviews = Review::where('user_id', '!=', Auth::id())->where('shop_id', $id)->get();
        $times = Reservation::getTimes();
        return view('detail', compact('shop','times', 'myReview', 'otherReviews'));
    }
}
