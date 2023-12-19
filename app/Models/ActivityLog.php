<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table = 'logs';
    protected $fillable = [
        'related_id'  , 'url' , 'method' , 'guard' , 'created_at' , 'data'  , 'user_id' , 'user_name' , 'user_type' , 'easymenu_restaurant_id' , 'category_id' , 'product_id'
    ];
    public $timestamps = false;
    public $casts = [
        'data' => 'json',
        'created_at' => 'datetime',
    ];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function restaurant(){
        return $this->belongsTo(Restaurant::class , 'easymenu_restaurant_id');
    }

    public function category(){
        return $this->belongsTo(Category::class , 'category_id');
    }
    public function product(){
        return $this->belongsTo(Product::class , 'product_id');
    }

}
