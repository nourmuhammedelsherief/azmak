<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateUsQuestion extends Model
{
    use HasFactory;
    protected $table = 'rate_us_questions';
    protected $fillable = [
        'id',
        'question_ar',
        'question_en',
        'more_option',
    ];
}
