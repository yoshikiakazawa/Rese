<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // ソートのパラメータを取得
        $sort = $request->input('sort', 'high');  // デフォルトは高い順

        // 並び替えのロジック
        if ($sort == 'high') {
            $shops = Shop::with('reviews')->get()->sortByDesc(function ($shop) {
                return $shop->reviews->sum('rank'); // 高評価順
            });
        } elseif ($sort == 'low') {
            $shops = Shop::with('reviews')->get()->sortBy(function ($shop) {
                $totalRank = $shop->reviews->sum('rank');
                return $totalRank > 0 ? $totalRank : PHP_INT_MAX;
            });
        } elseif ($sort == 'random') {
            $shops = Shop::inRandomOrder()->get();  // ランダム
        } else {
            $shops = Shop::with('reviews')->get();  // デフォルトの並び
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
            return view('index', compact('shops', 'areas', 'genres', 'favorites'))->with('message', '検索結果がありません。');
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
        $times = [
            '11:00', '11:30', '12:00', '12:30', '13:00', '13:30',
            '14:00', '14:30', '15:00', '15:30', '16:00', '16:30',
            '17:00', '17:30', '18:00', '18:30', '19:00', '19:30',
            '20:00', '20:30', '21:00', '21:30', '22:00'
        ];
        return view('detail', compact('shop','times', 'myReview', 'otherReviews'));
    }
}
