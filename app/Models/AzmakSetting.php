<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AzmakSetting extends Model
{
    use HasFactory;
    protected $table = 'azmak_settings';
    protected $fillable = [
        'subscription_type',
        'tax',
        'subscription_amount',
        'online_payment_type',
        'online_token',
    ];
}
