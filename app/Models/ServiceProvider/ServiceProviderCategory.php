<?php

namespace App\Models\ServiceProvider;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceProviderCategory extends Category
{

    public static function booted()
    {
        parent::boot();
        static::addGlobalScope('type' , function($query){
            $query->where(DB::raw('categories.type') , '=' , 'service_provider');
        });
    }

    public function getImagePathAttribute(){
        return empty($this->image) ? null :  'uploads/service-provicer-categories/' . $this->image;
    }
    public function serviceProviders(){
        return $this->belongsToMany(ServiceProvider::class , 'service_provider_categories' , 'category_id' , 'service_provider_id');
    }
}
