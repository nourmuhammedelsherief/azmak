<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AzRestaurantSlider extends Model
{
    use HasFactory;
    protected $table = 'az_restaurant_sliders';
    protected $fillable = [
        'restaurant_id',
        'photo',
        'type',
        'youtube',
        'description_en',
        'description_ar',
        'stop',
    ];

    public function getDescriptionAttribute()
    {
        return app()->getLocale() == 'ar' ? $this->description_ar : $this->description_en;
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}
