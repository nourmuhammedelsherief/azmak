<?php

namespace App\Models\Waiting;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingPlace extends Model
{
    use HasFactory;
    protected $table = 'waiting_places';
    protected $fillable = [
        'name_ar' , 'name_en' , 'status' , 'restaurant_id' , 'branch_id' , 'location_link'
    ];
    protected $appends = ['name'];


    public function getNameAttribute(){
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }
    public function restaurant(){
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function branch(){
        return $this->belongsTo(WaitingBranch::class , 'branch_id');
    }
    public function orders(){
        return $this->hasMany(WaitingOrder::class , 'place_id');
    }
}
