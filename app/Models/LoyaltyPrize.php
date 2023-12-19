<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPrize extends Model
{
    /**
     * ! status : eunm (new , completed)
    */
    use HasFactory;
    protected $table = 'loyalty_offer_prizes';
    protected $fillable = [
        'restaurant_id' , 'branch_id' , 'product_id' , 'user_id' , 'offer_id' , 'required_quantity' , 'product_name' , 'user_phone' , 'cacher_id' , 'cacher_name' , 'status' , 'delivery_date' , 'prize'
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
    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public function cacher(){
        return $this->belongsTo(RestaurantEmployee::class , 'cacher_id');
    }

    public static function convertToPrizes(LoyaltyOffer $offer , $phone){
        $items = $offer->userHistory()->where('user_phone' , $phone)->where('status' , 'confirmed')->get();
        $sum = 0;
        $oldList = [];
        foreach($items as $item):
            $tempSum = $sum + $item->quantity;

            // if()
            if($tempSum > $offer->required_quantity){
                $item->update([
                    'quantity' => $offer->required_quantity - $sum,

                ]);
                $sum = $offer->required_quantity;
                $data = $item->toArray();
                $data['quantity'] = $tempSum - $offer->required_quantity;

                LoyaltyOfferUser::create($data);
                // $newItem =
            }
            $oldList[]  = $item;
            if($sum == $offer->required_quantity){
                // change status
                foreach($oldList as $t):
                    $t->update([
                        'status' => 'wait_prize' ,
                    ]);
                endforeach;

                LoyaltyPrize::create([
                    'restaurant_id' => $t->restaurant_id ,
                    'branch_id' => $t->branch_id ,
                    'offer_id' => $offer->id ,
                    'product_id' => $t->product_id ,
                    'product_name' => $t->product_name ,
                    'prize' => $offer->prize,
                    'required_quantity' => $offer->required_quantity ,
                    'user_id' => $t->user_id,
                    'user_phone' => $t->user_phone ,
                    'status' => 'new' ,
                ]);

                static::convertToPrizes($offer , $phone);
                return true;
            }
            $sum += $item->quantity;
        endforeach;

        return true;
    }
}
