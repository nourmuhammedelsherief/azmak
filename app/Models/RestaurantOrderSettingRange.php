<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantOrderSettingRange extends Model
{
    use HasFactory;
    protected $table = 'restaurant_order_setting_ranges';
    protected $fillable = [
        'setting_id',
        'distance',
        'price',
    ];

    public function setting()
    {
        return $this->belongsTo(RestaurantOrderSetting::class , 'setting_id');
    }
}
