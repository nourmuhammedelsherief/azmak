<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSubscription extends Model
{
    use HasFactory;
    protected $table = 'service_subscriptions';
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'service_id',
        'restaurant_name',
        'restaurant_phone',
        'price',
        'paid_at',
        'type',
        'payment_type',
        'photo',
        'canceled_at',
        'end_at',
        'status',
        'seller_code_id',
        'invoice_id',
        'discount',
        'tax_value',
        'transfer_upload_date',
        'add_by_admin',
        'add_by_restaurant',
        'started_at',
        'last_use',
    ];

    protected $appends  = ['is_paid'];
    protected $dates = ['paid_at', 'end_at' , 'started_at' , 'last_use'];

    public function getImagePathAttribute()
    {
        return 'uploads/transfers/' . $this->photo;
    }
    public function getIsPaidAttribute()
    {
        return empty($this->paid_at) ? false : true;
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
    public function reports()
    {
        return $this->hasMany(Report::class, 'service_subscription_id');
    }
    public function seller_code()
    {
        return $this->belongsTo(SellerCode::class, 'seller_code_id');
    }
    public function addByAdmin()
    {
        return $this->belongsTo(Admin::class, 'add_by_admin');
    }
    public function addByRestaurant()
    {
        return $this->belongsTo(Restaurant::class, 'add_by_restaurant');
    }
}
