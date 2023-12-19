<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\ServiceProvider\ServiceProvider;
use App\Models\ServiceProvider\ServiceProviderCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceProviderController extends Controller
{
    public function index(Request $request)
    {
        $restauarnt  = auth('restaurant')->user();
        if ($restauarnt->type == 'employee') $restauarnt->restaurant;
        $categories = ServiceProviderCategory::where('status', 'true')->whereHas('serviceProviders', function ($q) use ($restauarnt) {
            $q->whereHas('subscriptions', function ($query) {
                $query->where('status', 'in_progress')->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'));
            })->whereHas('cities', function ($query) use ($restauarnt) {
                $query->where('city_id', $restauarnt->city_id);
            });
        })->orderBy('sort', 'asc')->get();
        // $users = ServiceProvider::whereHas('subscriptions' , function($query){
        //     $query->where('status' , 'in_progress')->where('start_date' ,'<=' , date('Y-m-d'))->where('end_date' ,'>=' , date('Y-m-d'));
        // })->orderBy('sort')->get();

        return view('restaurant.service_providers.categories_index', compact('categories'));
    }

    public function showCategory(Request $request, $category)
    {
        $category = ServiceProviderCategory::where('status', 'true')->orderBy('sort', 'asc')->findOrFail($category);
        $restauarnt  = auth('restaurant')->user();
        if ($restauarnt->type == 'employee') $restauarnt->restaurant;
        $users = ServiceProvider::whereHas('subscriptions', function ($query) {
            $query->where('status', 'in_progress')->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'));
        })->whereHas('cities', function ($query) use ($restauarnt) {
            $query->where('city_id', $restauarnt->city_id);
        })->whereHas('categories', function ($query) use ($category) {
            $query->where(DB::raw('service_provider_categories.category_id'), $category->id);
        })->orderBy('sort')->get();

        return view('restaurant.service_providers.index', compact('users', 'category'));
    }
}
