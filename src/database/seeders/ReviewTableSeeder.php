<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '1',
            'shop_id' => '1',
            'comment' => 'コースでいい値段ですが、お店の雰囲気はフォーマルな感じではなく品があっていい雰囲気です。予約して行きましたが、テーブルに感謝のメッセージが書かれてありました。',
            'rank' => '4',
            'image' => '/storage/reviews/review_test.jpg',
            'created_at' => Carbon::now(),
        ];
        DB::table('reviews')->insert($param);
    }
}
