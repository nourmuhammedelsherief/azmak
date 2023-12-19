<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineOfferCategory extends Model
{
    use HasFactory;
    protected $table = 'online_offers_categories';
    protected $fillable = [
        'name_ar' , 'name_en' , 'branch_id' , 'status' , 'sort'
    ];

    public function getNameAttribute(){
        return $this->attributes['name_' . app()->getLocale()];
    }
    public function branch(){
        return $this->belongsTo(Branch::class , 'branch_id');
    }
    public function images(){
        return $this->hasMany(OnlineOfferImage::class, 'category_id');
    }
}
