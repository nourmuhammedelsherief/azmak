<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantAboutAzmak extends Model
{
    use HasFactory;
    protected $table = 'restaurant_about_azmaks';
    protected $fillable = [
        'restaurant_id',
        'about_ar',
        'about_en',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
}
