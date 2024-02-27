<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AzSellerCode extends Model
{
    use HasFactory;
    protected $table = 'az_seller_codes';
    protected $fillable = [
        'country_id',
        'seller_name',
        'permanent',
        'active',
        'percentage',
        'code_percentage',
        'commission',
        'start_at',
        'end_at',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class , 'country_id');
    }
}
