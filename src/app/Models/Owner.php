<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Owner extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'ownerid',
        'name',
        'password',
        'remember_token',
    ];

    protected $hidden = [
        'password',
    ];

    public function shops()
    {
        return $this->hasMany(Shop::class, 'owner_id');
    }
}
