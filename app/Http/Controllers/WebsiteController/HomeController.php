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
use Illuminate\Support\Facades\App;


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
    public function homeBranch(Request $request , $res , $branch , $category_id = null)
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
                ->where('available', 'true')
                ->orderBy(DB::raw('ISNULL(arrange), arrange'), 'ASC')
                ->paginate(100);
        }else{
            $menu_category =AZMenuCategory::whereRestaurantId($restaurant->id)
                ->where('branch_id', $branch->id)
                ->where('active', 'true')
                ->orderBy(DB::raw('ISNULL(arrange), arrange'), 'ASC')
                ->first();
            if ($menu_category != null) {
                $products = AZProduct::whereRestaurantId($restaurant->id)
                    ->where('branch_id', $branch->id)
                    ->where('menu_category_id', $menu_category->id)
                    ->where('active', 'true')
                    ->where('available', 'true')
                    ->orderBy(DB::raw('ISNULL(arrange), arrange'), 'ASC')
                    ->paginate(100);
                $category_id = $menu_category->id;
            } else {
                $products = AZProduct::whereRestaurantId($restaurant->id)
                    ->where('branch_id', $branch->id)
                    ->where('active', 'true')
                    ->where('available', 'true')
                    ->orderBy(DB::raw('ISNULL(arrange), arrange'), 'ASC')
                    ->paginate(100);
            }
        }
        if ($request->is_category == 'true')
        {
            return response([
                'status' => true,
                'data' => [
                    'products' => view('website.accessories.products', compact(['restaurant' ,'products', 'branch' ,'categories', 'sliders' , 'branches' , 'category_id']))->render(),
                ],
            ]);
        }
        return view('website.home' , compact('restaurant' ,'products', 'branch' ,'categories', 'sliders' , 'branches' , 'category_id'));
    }

    public function terms($res , $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $terms = RestaurantTermsCondition::whereRestaurantId($restaurant->id)->first();
        return view('website.pages.terms' , compact('restaurant' , 'branch','terms'));
    }
    public function about($res , $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $about = RestaurantAboutAzmak::whereRestaurantId($restaurant->id)->first();
        return view('website.pages.about' , compact('restaurant' , 'branch','about'));
    }

    public function product_details($id)
    {
        $product = AZProduct::findOrFail($id);
        $restaurant = $product->restaurant;
        $branch = $product->branch;
        $route = route('product_details' , $product->id);
        $details = (app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en) . ' ' . (app()->getLocale() == 'ar' ? strip_tags(str_replace('&nbsp;', ' ', $product->description_ar)) : strip_tags(str_replace('&nbsp;', ' ', $product->description_en)));
        $shareComponent = \Share::page(
            $route,
            $details,
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();
        return view('website.accessories.product_details' , compact('product' ,'restaurant' , 'branch','shareComponent'));
    }
}
