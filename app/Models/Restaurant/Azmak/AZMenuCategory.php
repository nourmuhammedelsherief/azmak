<?php

namespace App\Models\Restaurant\Azmak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AZMenuCategory extends Model
{
    use HasFactory;
    protected $table = 'a_z_menu_categories';
    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'name_ar',
        'name_en',
        'photo',
        'active',
        'arrange',
        'description_ar',
        'description_en',
        'foodics_image',
        'foodics_id',
        'time',
        'start_at',
        'end_at',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class , 'restaurant_id');
    }
    public function branch()
    {
        return $this->belongsTo(AZBranch::class , 'branch_id');
    }
}
