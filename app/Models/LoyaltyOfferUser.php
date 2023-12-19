<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyOfferUser extends Model
{
    /**
     * ! status : [pending = waiting to approve on buying the product
     * ! confirmed = the buy operation is confirmed by casher or admin
     * ! wait_prize  = when buy quantity enugh to get prize
     * ! completed = when done ]
    */
    use HasFactory;
    protected $table = 'loyalty_offer_users';
    protected $fillable = [
        'restaurant_id' , 'branch_id' , 'product_id' , 'offer_id' , 'quantity' ,'user_id' ,  'product_name' , 'user_phone' , 'buy_type' , 'cacher_id' , 'cacher_name' ,
         'status' , //  TODO enum (pending , completed , wait_price , confirmed)
    ];

    public function offer(){
        return $this->belongsTo(LoyaltyOffer::class , 'offer_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class , 'branch_id');
    }
    public function restaurant(){
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function product(){
        return $this->belongsTo(Product::class , 'product_id');
    }

    public function cacher(){
        return $this->belongsTo(RestaurantEmployee::class , 'cacher_id');
    }
}
