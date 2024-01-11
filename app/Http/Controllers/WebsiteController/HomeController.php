<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant\Azmak\AZBranch;
use App\Models\Restaurant;
use App\Models\RestaurantSlider;


class HomeController extends Controller
{
    public function index($res)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->first();
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
    public function homeBranch($res , $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->first();
        $branch = AZBranch::whereNameEn($branch)->first();
        $sliders = $restaurant->sliders()
            ->where('slider_type', 'home')
            ->whereStop('false')
            ->get();
        $branches = AZBranch::whereRestaurantId($restaurant->id)->get();
        return view('website.home' , compact('restaurant' , 'branch' , 'sliders' , 'branches'));
    }
}
