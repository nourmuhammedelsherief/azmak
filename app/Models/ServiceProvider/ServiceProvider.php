<?php

namespace App\Models\ServiceProvider;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\RestaurantContactUs;
use App\Models\RestaurantSlider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ServiceProvider  extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $guard = 'service_provider';
    protected $table = 'service_providers';
    protected $fillable = [
        'name', 'email', 'phone', 'status', 'password', 'image', 'sort', 'description', 'enable_contact_us', 'bio_description_en', 'bio_description_ar', 'barcode', 'slider_down_contact_us_title' , 'enable_contact_us_links'
    ];

    public function getImagePathAttribute()
    {
        return empty($this->image) ? 'images/default-user.jpg' : 'uploads/service-providers/' . $this->image;
    }


    public function categories()
    {
        return $this->belongsToMany(ServiceProviderCategory::class, 'service_provider_categories', 'service_provider_id', 'category_id');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'service_provider_cities', 'service_provider_id', 'city_id');
    }
    public function scopeIsAccepted($query)
    {
        return $query->whereHas('subscriptions', function ($q) {
            $q->whereNotIn('status', ['denied', 'new']);
        });
    }
    public function subscriptions()
    {
        return $this->hasMany(ServiceProviderSubscription::class, 'service_provider_id');
    }

    public function sliders()
    {
        return $this->hasMany(RestaurantSlider::class, 'service_provider_id');
    }
    public function contactUsItems()
    {
        return $this->hasMany(RestaurantContactUs::class, 'service_provider_id');
    }
}
