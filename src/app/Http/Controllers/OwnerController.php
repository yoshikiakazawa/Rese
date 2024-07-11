<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Area;
use App\Models\Genre;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\EditShopRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
    public function index() {
        $owner = Auth::user();
        $shops = Shop::where('owner_id', $owner->id)->with(['areas', 'genres'])->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('owner.index', compact('owner', 'shops', 'areas', 'genres'));
    }

    public function store(StoreShopRequest $request) {
        $path = $request->file('image')->store('shops', 's3');
        $owner = Auth::user();
        Shop::create([
            'owner_id' => $owner->id,
            'shop_name' => $request->shop_name,
            'area_id' => $request->area_id,
            'genre_id' => $request->genre_id,
            'overview' => $request->overview,
            'image_path' => Storage::disk('s3')->url($path),
        ]);
        return redirect()->back()->with('message', 'shopを作成しました。');
    }

    public function show($id) {
        $owner = Auth::user();
        $shop = Shop::where('id', $id)->with(['areas', 'genres'])->first();
        $areas = Area::all();
        $genres = Genre::all();
        return view('owner.show', compact('owner', 'shop', 'areas', 'genres'));
    }

    public function edit(EditShopRequest $request) {
        $oldShop = Shop::find($request->id);
        $oldShop->shop_name = $request->shop_name;
        $oldShop->area_id = $request->area_id;
        $oldShop->genre_id = $request->genre_id;
        $oldShop->overview = $request->overview;
        $oldShop->save();
        return redirect()->back()->with('message', 'shopを修正しました。');
    }
}
