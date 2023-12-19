<?php

namespace App\Http\Controllers\RestaurantController\LoyaltyOffer;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\LoyaltyOffer;
use App\Models\LoyaltyOfferUser;
use App\Models\LoyaltyPrize;
use App\Models\LuckyItem;
use App\Models\ServiceSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoyaltyOfferPrizeController extends Controller
{
    private $restaurant, $subscription;
    public function __construct()
    {
        $this->middleware('auth:restaurant');
        $this->middleware(function ($request, $next) {
            $restaurant = auth('restaurant')->user();
            $checkService = ServiceSubscription::whereRestaurantId($restaurant->id)
                ->whereIn('service_id', [11])
                ->whereIn('status', ['active', 'tentative'])
                ->first();

            if ($checkService == null) {
                abort(404);
            }
            $this->restaurant = $restaurant;
            $this->subscription = $checkService;
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $restaurant = $this->restaurant;
        $items = LoyaltyPrize::where('restaurant_id' , $restaurant->id);
        if(!empty($request->user_phone)):
            $items = $items->where('user_phone' , $request->user_phone);
        endif;
        $items = $items->get();

        return view('restaurant.loyalty_offers.prize_index', compact('items', 'restaurant' , 'items') );
    }




    public function confirmPrize(Request $request ){
        $request->validate([
            'cacher_name' => 'required|min:1' ,
            'id' => 'required|integer'
        ]);

        if($offer = LoyaltyPrize::where('restaurant_id' , $this->restaurant->id)->where('id' , $request->id)->first()):
            $offer->update([
                'status' => 'completed' ,
                'cacher_name' => $request->cacher_name ,
                'delivery_date' => date('Y-m-d H:i:s') ,
            ]);
            flash(trans('messages.created'))->success();
        endif;
        return redirect(route('restaurant.loyalty-offer.prize.index')) ;
    }

    public function usersIndex(Request $request)
    {
        $restaurant = $this->restaurant;
        $items = LoyaltyOfferUser::whereHas('branch', function ($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id);
        })->selectRaw('DISTINCT user_phone')->get();

        return view('restaurant.loyalty_offers.user_index', compact('items', 'restaurant' , 'items') );
    }

}
