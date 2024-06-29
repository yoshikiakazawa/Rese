<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '管理者テスト',
            'adminid' => 'admin001',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
        ];
        DB::table('admins')->insert($param);
    }
}
