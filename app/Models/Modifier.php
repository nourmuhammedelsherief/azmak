<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    use HasFactory;
    protected $table = 'modifiers';
    protected $fillable = [
        'name_ar',
        'name_en',
        'restaurant_id',
        'is_ready',
        'old_id',
        'foodics_id',
        'choose' ,     // one , multiple , custom
        'custom' ,
        'sort'  , 
    ];

    public function getNameAttribute(){
        return $this->attributes['name_' . app()->getLocale()];
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function options(){
        return $this->hasMany(Option::class , 'modifier_id');
    }
}
