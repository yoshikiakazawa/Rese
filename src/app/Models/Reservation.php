<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['shop_id', 'user_id', 'date', 'time', 'number', 'rank', 'comment', 'amount', 'payment_status'];

    public function shops()
    {
        return $this->belongsTo(Shop::class, "shop_id");
    }

    public function users()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
