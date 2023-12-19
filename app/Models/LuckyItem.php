<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class LuckyItem extends Model
{

    use HasFactory;
    protected $table = 'lucky_items';
    protected $fillable = [
        'restaurant_id', 'branch_id' , 'name_ar' , 'name_en' , 'status' , 'sort'     , 'can_win'
    ];
    public function getNameAttribute(){
        return $this->attributes['name_' . app()->getLocale()];
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class , 'branch_id');
    }
    public function orders()
    {
        return $this->hasMany(LuckyOrder::class , 'item_id');
    }

}
