<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;

class AZBranch extends Model
{
    use HasFactory;
    protected  $table = 'a_z_branches';
    protected $fillable = [
        'restaurant_id',
        'name_ar',
        'name_en'
    ];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
}
