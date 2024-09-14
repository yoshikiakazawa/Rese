<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class OwnerFactory extends Factory
{
    private static $login_owner_idCounter = 0;
    private static $login_owner_ids = ['owner001', 'owner002', 'owner003', 'owner004', 'owner005'];
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $login_owner_id = self::$login_owner_ids[self::$login_owner_idCounter % count(self::$login_owner_ids)];
        self::$login_owner_idCounter++;
        return [
            'login_owner_id' => $login_owner_id,
            'name' => $this->faker->name(),
            'password' => Hash::make($login_owner_id),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
