<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodicsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id' , 'foodics_referance' , 'restaurant_id' , 'type' , 'status_code' , 'response' , 'request' , 'entity_type' , 'event' , 'foodics_name'
    ];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class) ;
    }
    public function order(){
        return $this->belongsTo(SilverOrderFoodics::class, 'restaurant_id') ;
    }
}
