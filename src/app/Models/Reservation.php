<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['shop_id', 'user_id', 'date', 'time', 'number', 'rank', 'comment', 'amount', 'payment_status'];

    public static function getTimes()
    {
        return [
            '11:00', '11:30', '12:00', '12:30', '13:00', '13:30',
            '14:00', '14:30', '15:00', '15:30', '16:00', '16:30',
            '17:00', '17:30', '18:00', '18:30', '19:00', '19:30',
            '20:00', '20:30', '21:00', '21:30', '22:00'
        ];
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, "shop_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
