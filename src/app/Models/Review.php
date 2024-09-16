<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['shop_id', 'user_id', 'comment', 'rank', 'image'];

    public function shop()
    {
        return $this->belongsTo(Shop::class, "shop_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
