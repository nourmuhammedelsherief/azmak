<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurRate extends Model
{
    use HasFactory;
    protected $table = 'our_rates';

    public function answers()
    {
        return $this->hasMany(RateUsAnswer::class , 'our_rate_id');
    }
}
