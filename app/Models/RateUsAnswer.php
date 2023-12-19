<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateUsAnswer extends Model
{
    use HasFactory;
    protected $table = 'rate_us_answers';
    protected $fillable = [
        'our_rate_id',
        'rate_id',
        'answer',
    ];

    public function our_rate()
    {
        return $this->belongsTo(OurRate::class , 'our_rate_id');
    }
    public function rate()
    {
        return $this->belongsTo(RateUsQuestion::class , 'rate_id');
    }
}
