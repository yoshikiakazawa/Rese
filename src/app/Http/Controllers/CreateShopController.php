<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\CreateShopRequest;
use App\Http\Requests\EditShopRequest;
use SplFileObject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreateShopController extends Controller
{
    public function upload(Request $request){
        setlocale(LC_ALL, 'ja_JP.UTF-8');
        $uploaded_file = $request->file('csvFile');
        if (!$uploaded_file || !$uploaded_file->isValid()) {
            return redirect()->back()->withErrors('ファイルがアップロードされていないか、無効です。');
        }
        $file_path = $uploaded_file->path();
        $file = new SplFileObject($file_path);
        if (!$file->isReadable()) {
            return redirect()->back()->withErrors('ファイルが読み込めません。');
        }
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);
        $row_count = 0;
        $data = [];
        $valid_areas = [
            '東京都' => 13,
            '大阪府' =>27,
            '福岡県' => 40
        ];
        $valid_genres = [
            '寿司' => 1,
            '焼肉' => 2,
            'イタリアン' => 3,
            '居酒屋' => 4,
            'ラーメン' => 5
        ];
        foreach ($file as $row) {
            if (!is_array($row)) {
                continue;
            }
            if ($row === [null]) continue;
            if ($row_count === 0) {
                $row_count++;
                continue;
            }
            if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4])) {
                return redirect()->back()->withErrors('全ての項目は必須です。');
            }
            if (mb_strlen($row[0]) > 50) {
                return redirect()->back()->withErrors('店舗名は50文字以内で入力してください。');
            }
            if (!array_key_exists($row[1], $valid_areas)) {
                return redirect()->back()->withErrors('地域は「東京都」「大阪府」「福岡県」のいずれかで入力してください。');
            }
            if (!array_key_exists($row[2], $valid_genres)) {
                return redirect()->back()->withErrors('ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかで入力してください。');
            }
            if (mb_strlen($row[3]) > 400) {
                return redirect()->back()->withErrors('店舗概要は400文字以内で入力してください。');
            }
            $image_extension = pathinfo($row[4], PATHINFO_EXTENSION);
            if (!in_array(strtolower($image_extension), ['jpg', 'jpeg', 'png'])) {
                return redirect()->back()->withErrors('画像URLはjpgまたはpng形式のみ対応しています。');
            }
            $encoding = mb_detect_encoding($row[0], ['SJIS', 'UTF-8'], true);
            if ($encoding === false) {
                return redirect()->back()->withErrors('ファイルのエンコーディングが不明です。');
            }
            $data[] = [
                'owner_id' => $request->owner_id,
                'shop_name' => mb_convert_encoding($row[0], 'UTF-8'),
                'area_id' => $valid_areas[mb_convert_encoding($row[1], 'UTF-8')],
                'genre_id' => $valid_genres[mb_convert_encoding($row[2], 'UTF-8')],
                'overview' => mb_convert_encoding($row[3], 'UTF-8'),
                'image_path' => mb_convert_encoding($row[4], 'UTF-8'),
            ];
            $row_count++;
        }
        Shop::insert($data);
        return redirect()->back()->with('flash-message', 'shop作成しました');
    }

    public function store(CreateShopRequest $request) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = storage_path('app/public/shops/' . $filename);
        $image->move(storage_path('app/public/shops'), $filename);
        $path = '/storage/shops/' . $filename;

        $owner = Auth::user();
        Shop::create([
            'owner_id' => $owner->id,
            'shop_name' => $request->shop_name,
            'area_id' => $request->area_id,
            'genre_id' => $request->genre_id,
            'overview' => $request->overview,
            'image_path' => $path,
        ]);
        return redirect()->back()->with('flash-message', 'shopを作成しました');
    }

    public function edit(EditShopRequest $request) {
        $oldShop = Shop::find($request->id);
        $oldShop->shop_name = $request->shop_name;
        $oldShop->area_id = $request->area_id;
        $oldShop->genre_id = $request->genre_id;
        $oldShop->overview = $request->overview;
        $oldShop->save();
        return redirect()->back()->with('flash-message', 'shopを修正しました');
    }
}
