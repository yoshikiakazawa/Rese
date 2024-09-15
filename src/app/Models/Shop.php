<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = ['owner_id', 'shop_name', 'area_id', 'genre_id', 'overview', 'image_path'];

    public function owner()
    {
        return $this->belongsTo(Owner::class, "owner_id");
    }

    public function area()
    {
        return $this->belongsTo(Area::class, "area_id");
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, "genre_id");
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'shop_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'shop_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'shop_id');
    }
}
