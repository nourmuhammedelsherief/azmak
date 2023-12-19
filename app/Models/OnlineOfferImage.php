<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineOfferImage extends Model
{
    use HasFactory;
    protected $table = 'online_offers_images';
    protected $fillable = [
        'path' , 'category_id'  , 'status'
    ];

    public function getImagePathAttribute(){
        return 'uploads/online_offers/' . $this->path;
    }
    public function category(){
        return $this->belongsTo(OnlineOfferCategory::class , 'category_id');
    }

}
