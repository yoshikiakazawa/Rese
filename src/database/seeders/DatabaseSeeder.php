<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Owner;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Owner::factory(5)->create();
        $this->call(UserTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(AreaTableSeeder::class);
        $this->call(GenreTableSeeder::class);
        $this->call(ShopTableSeeder::class);
    }
}
