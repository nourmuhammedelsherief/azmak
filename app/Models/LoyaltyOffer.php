<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyOffer extends Model
{
    use HasFactory;
    protected $table = 'loyalty_offers';
    protected $fillable = [
        'branch_id' , 'product_id' , 'required_quantity' , 'prize' , 'status' , 'start_date' , 'end_date'
    ];

    public function userHistory(){
        return $this->hasMany(LoyaltyOfferUser::class , 'offer_id');
    }
    public function prizes(){
        return $this->hasMany(LoyaltyPrize::class , 'offer_id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class , 'branch_id');
    }
    public function product(){
        return $this->belongsTo(Product::class , 'product_id');
    }
    public function scopeIsActive($query){
        return $query->whereRaw('(status = "true" and (start_date is null or start_date <= "'.date('Y-m-d H:i:s').'") and (end_date is null or end_date >= "'.date('Y-m-d H:i:s').'") )');
    }
    public function isActive(){
        if($this->status == 'true'){
            $current = Carbon::parse(date('Y-m-d H:i:s'));
            if(!empty($this->start_date)){
                $startDate= Carbon::parse($this->start_date);
                if($startDate->greaterThan($current)) return false;
            }
            if(!empty($this->end_date)){
                $endDate= Carbon::parse($this->end_date);
                if($endDate->lessThan($current)) return false;
            }
            return true;
        }
        return false;
    }
}
