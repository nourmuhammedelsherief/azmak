<?php

namespace App\Models\Waiting;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingBranch extends Model
{
    use HasFactory;
    protected $table = 'waiting_branches';
    protected $fillable = [
        'name_ar' , 'name_en' , 'status' , 'restaurant_id' , 'location_link'
    ];


    public function getNameAttribute(){
        return app()->getLocale() == 'ar' ? $this->name_ar : $this->name_en;
    }
    public function restaurant(){
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function places(){
        return $this->hasMany(WaitingPlace::class , 'branch_id');
    }
}
