<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class WaitingEmployee extends RestaurantEmployee
{

    protected $guard = 'waiting';
   
    public static function booted()
    {
        parent::boot();
        static::addGlobalScope('type', function ($query) {
            $query->where('type', 'like', '%waiting%');
        });
    }
   
}
