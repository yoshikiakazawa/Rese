<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReviewRequest;


class ReviewController extends Controller
{
    public function show ($id) {
        $shop = Shop::find($id);
        $favorite = Favorite::where('shop_id', $id)->where('user_id', Auth::id())->get();
        $review = Review::where('user_id', Auth::id())->where('shop_id', $id)->first();

        return view('review', compact('shop', 'favorite'));
    }

    public function store (ReviewRequest $request, $id) {
        $review = Review::where('user_id', Auth::id())->where('shop_id', $id)->first();
        if (empty($review)) {
            $path = null;
            if (!empty($request->image)) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = storage_path('app/public/reviews/' . $filename);
                $image->move(storage_path('app/public/reviews'), $filename);
                $path = '/storage/reviews/' . $filename;
            }
            Review::create([
                'shop_id' => $id,
                'user_id' => Auth::id(),
                'comment' => $request->comment,
                'rank' => $request->rank,
                'image' => $path,
            ]);
            return redirect()->back()->with('flash_message', '口コミを登録しました');
        }
        return redirect()->back()->with('flash_message', '口コミは既に登録されています');
    }

    public function edit (ReviewRequest $request, $id) {
        $review = Review::find($id);
        if (!empty($review)) {
            $path = null;
            if (!empty($request->image)) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = storage_path('app/public/reviews/' . $filename);
                $image->move(storage_path('app/public/reviews'), $filename);
                $path = '/storage/reviews/' . $filename;
            }

            $review->image = $path;
            $review->rank = $request->rank;
            $review->comment = $request->comment;
            $review->save();
            return redirect()->back()->with('flash_message', '口コミを修正しました');
        }
        return redirect()->back()->with('flash_message', 'エラーが発生しました');
    }

    public function destroy($id)
    {
        $review = Review::find($id);
        if (($review->user_id) === (Auth::id()) ) {
            $review->delete();
            return redirect()->back()->with('flash_message', '口コミを削除しました');
        }
        return redirect()->back()->with('flash_message', '他人の口コミは削除できません');
    }
}
