<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant\Azmak\AZBranch;
use App\Models\Restaurant\Azmak\AZMenuCategory;
use App\Models\Restaurant\Azmak\AZProduct;
use App\Models\Restaurant;
use App\Models\RestaurantTermsCondition;
use App\Models\RestaurantAboutAzmak;
use App\Models\RestaurantSlider;
use DB;


class HomeController extends Controller
{
    public function index($res)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branches = AZBranch::whereRestaurantId($restaurant->id)->get();
        return view('website.index' , compact('branches' , 'restaurant'));
    }

    public function home(Request $request , $branch_id = null)
    {
        if ($request->branch)
        {
            $branch = AZBranch::find($request->branch);
        }else{
            $branch = AZBranch::find($branch_id);
        }
        return redirect()->route('homeBranchIndex' , [$branch->restaurant->name_barcode , $branch->name_en]);
    }
    public function homeBranch($res , $branch , $category_id = null)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $sliders = $restaurant->sliders()
            ->where('slider_type', 'home')
            ->whereStop('false')
            ->get();
        $branches = AZBranch::whereRestaurantId($restaurant->id)->get();
        $categories = AZMenuCategory::whereRestaurantId($restaurant->id)
            ->where('branch_id', $branch->id)
            ->where('active', 'true')
            ->orderBy(DB::raw('ISNULL(arrange), arrange'), 'ASC')
            ->get();
        if ($category_id)
        {
            $products = AZProduct::whereRestaurantId($restaurant->id)
                ->where('branch_id', $branch->id)
                ->where('menu_category_id', $category_id)
                ->where('active', 'true')
                ->orderBy(DB::raw('ISNULL(arrange), arrange'), 'ASC')
                ->paginate(100);
        }else{
            $menu_category = AZMenuCategory::whereRestaurantId($restaurant->id)
                ->where('branch_id', $branch->id)
                ->where('active', 'true')
                ->where('time', 'false')
                ->orderBy(DB::raw('ISNULL(arrange), arrange'), 'ASC')
                ->first();
            if ($menu_category != null) {
                $products = AZProduct::whereRestaurantId($restaurant->id)
                    ->where('branch_id', $branch->id)
                    ->where('menu_category_id', $menu_category->id)
                    ->where('active', 'true')
                    ->orderBy(DB::raw('ISNULL(arrange), arrange'), 'ASC')
                    ->paginate(100);
            } else {
                $products = AZProduct::whereRestaurantId($restaurant->id)
                    ->where('branch_id', $branch->id)
                    ->where('active', 'true')
                    ->orderBy(DB::raw('ISNULL(arrange), arrange'), 'ASC')
                    ->paginate(100);
            }
        }
        return view('website.home' , compact('restaurant' , 'branch' ,'categories', 'sliders' , 'branches'));
    }

    public function terms($res)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $terms = RestaurantTermsCondition::whereRestaurantId($restaurant->id)->first();
        return view('website.pages.terms' , compact('restaurant' , 'terms'));
    }
    public function about($res)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $about = RestaurantAboutAzmak::whereRestaurantId($restaurant->id)->first();
        return view('website.pages.about' , compact('restaurant' , 'about'));
    }
}
