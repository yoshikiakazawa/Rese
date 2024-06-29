<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class OwnerFactory extends Factory
{
    private static $ownerIdCounter = 0;
    private static $ownerIds = ['owner001', 'owner002', 'owner003', 'owner004', 'owner005'];
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ownerId = self::$ownerIds[self::$ownerIdCounter % count(self::$ownerIds)];
        self::$ownerIdCounter++;
        return [
            'ownerid' => $ownerId,
            'name' => $this->faker->name(),
            'password' => Hash::make($ownerId),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
