<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
        ];
        DB::table('users')->insert($param);
    }
}
