<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AzSubscription extends Model
{
    use HasFactory;
    protected $table = 'az_subscriptions';
    protected $fillable = [
        'restaurant_id',
        'seller_code_id',
        'bank_id',
        'status',
        'payment_type',
        'payment',
        'tax_value',
        'discount_value',
        'price',
        'end_at',
        'transfer_photo',
        'invoice_id',
    ];


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function seller_code()
    {
        return $this->belongsTo(AzSellerCode::class , 'seller_code_id');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class , 'bank_id');
    }
}
