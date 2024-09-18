<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use Illuminate\Http\Request;
use SplFileObject;
use Illuminate\Support\Facades\Validator;

class CreateShopController extends Controller
{
    public function upload(Request $request)
{
    // ロケールを設定(日本語に設定)
    setlocale(LC_ALL, 'ja_JP.UTF-8');

    // アップロードしたファイルを取得
    $uploaded_file = $request->file('csvFile');

    if (!$uploaded_file || !$uploaded_file->isValid()) {
        return redirect()->back()->withErrors('ファイルがアップロードされていないか、無効です。');
    }

    // アップロードしたファイルの絶対パスを取得
    $file_path = $uploaded_file->path();

    // SplFileObjectを生成
    $file = new SplFileObject($file_path);

    if (!$file->isReadable()) {
        return redirect()->back()->withErrors('ファイルが読み込めません。');
    }

    $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);

    $row_count = 0; // 1行目がヘッダーの場合は0から始める

    $data = [];

    $valid_areas = ['東京都' => 13, '大阪府' =>27, '福岡県' => 40];
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

        // 最終行の処理(最終行が空っぽの場合の対策)
        if ($row === [null]) continue;

        // ヘッダーをスキップするための処理
        if ($row_count === 0) {
            $row_count++;
            continue;
        }

        // バリデーションチェック
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

        // 画像URLの拡張子チェック
        $image_extension = pathinfo($row[4], PATHINFO_EXTENSION);
        if (!in_array(strtolower($image_extension), ['jpg', 'jpeg', 'png'])) {
            return redirect()->back()->withErrors('画像URLはjpgまたはpng形式のみ対応しています。');
        }

        // CSVの文字コードがSJISと仮定して変換する
        $encoding = mb_detect_encoding($row[0], ['SJIS', 'UTF-8'], true);
        if ($encoding === false) {
            return redirect()->back()->withErrors('ファイルのエンコーディングが不明です。');
        }

        $data[] = [
            'owner_id' => $request->owner_id,
            'shop_name' => mb_convert_encoding($row[0], 'UTF-8', $encoding),
            'area_id' => $valid_areas[mb_convert_encoding($row[1], 'UTF-8', $encoding)],
            'genre_id' => $valid_genres[mb_convert_encoding($row[2], 'UTF-8', $encoding)],
            'overview' => mb_convert_encoding($row[3], 'UTF-8', $encoding),
            'image_path' => mb_convert_encoding($row[4], 'UTF-8', $encoding),
        ];

        dd($data);

        $row_count++;
    }

    // データベースへの挿入
    Shop::insert($data);

    return redirect()->back()->with('flash-message', '登録しました');
}

}

