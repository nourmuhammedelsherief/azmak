<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class LuckyOrder extends Model
{

    use HasFactory;
    protected $table = 'lucky_orders';
    protected $fillable = [
        'restaurant_id', 'branch_id' , 'item_name_ar' , 'item_name_en' , 'user_name' , 'user_phone' , 'user_sex' , 'status' , 'item_id'     
    ];

    public function getItemNameAttribute(){
        return $this->attributes['item_name_' . app()->getLocale()];
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class , 'branch_id');
    }
    public function item()
    {
        return $this->belongsTo(LuckyItem::class , 'item_id');
    }
   
}
