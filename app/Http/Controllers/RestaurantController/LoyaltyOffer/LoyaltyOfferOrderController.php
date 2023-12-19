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

class LoyaltyOfferOrderController extends Controller
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
        $items = LoyaltyOfferUser::whereHas('branch', function ($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id);
        });
        if (!empty($request->offer_num)) {
            $items = $items->where('offer_id', $request->offer_num);
        }
        if (!empty($request->user_phone)) {
            $items = $items->where('user_phone', 'like', $request->user_phone . '%');
        }
        if (!empty($request->status)) {
            $items = $items->where('status', '=', $request->status);
        }
        $items = $items->get();

        return view('restaurant.loyalty_offers.requests.index', compact('items', 'restaurant'));
    }
    public function create()
    {
        $restaurant = $this->restaurant;
        $offers =  LoyaltyOffer::whereHas('branch', function ($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id);
        })->with('branch', 'product')->isActive()->get();

        return view('restaurant.loyalty_offers.requests.create', compact('restaurant', 'offers'));
    }

    public function store(Request $request)
    {
        $restaurant = $this->restaurant;
        $request->validate([
            'offer_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'user_phone' =>  ['required', 'regex:/^((05)|(01))[0-9]{8}/', 'max:11'],
            'cacher_name' => 'required|min:1|max:190',

        ]);
        if (!$offer  = LoyaltyOffer::whereHas('branch', function ($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id);
        })->with('branch', 'product')->isActive()->where('id', $request->offer_id)->first()) :
            throw ValidationException::withMessages([
                'offer_id' => trans('dashboard.error_loyalty_offer_not_active') ,
            ]);
        endif;
        // check user phone
        if(!$user = User::where('phone_number' ,'like' ,"%".$request->user_phone . "%")->first()):
            $user = User::create([
                'phone_number' => $request->user_phone ,
                'active' => 'true' ,
                'country_id' => substr($request->user_phone, 0, 2) === "01"  ? 1 : 2 ,
            ]);
        endif;
        // return $userOfferCount = LoyaltyOfferUser::whereRaw('(user_id = '.$user->id.' or user_phone = "'.$request->user_phone.'")')->where('offer_id' , $request->offer_id)->where('status' , 'confirmed')->count();
        // if($userOfferCount >= $offer->required_quantity):
        //     throw ValidationException::withMessages([
        //         'user_phone' => trans(ph) ,
        //     ])
        // endif;

        $item = LoyaltyOfferUser::create([
            'offer_id' => $offer->id ,
            'branch_id' => $offer->branch_id ,
            'restaurant_id' => $offer->branch->restaurant_id ,
            'user_id' => $user->id ,
            'user_phone' => $user->phone_number ,
            'product_id' => $offer->product_id ,
            'product_name' => $offer->product->name_ar ,
            'quantity' => $request->quantity ,
            'buy_type' => 'cacher' ,
            'status' => 'confirmed' ,
            'cacher_id' => null ,
            'cacher_name' => $request->cacher_name ,
        ]);

        LoyaltyPrize::convertToPrizes($offer , $user->phone_number);

        flash(trans('messages.created'))->success();
        return redirect(route('restaurant.loyalty-offer.request.index'));
    }

    public function delete(Request $request  , $id){
        $employee = LoyaltyOfferUser::findOrFail($id);
        $employee->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.loyalty-offer.request.index');
    }

    public function searchPhone(Request $request){
        $validator = validator( $request->all(), [
            'phone' => ['required' ,  'regex:/^((05)|(01))[0-9]{8}/']
        ]);

        if($validator->fails()){
            return response([
                'status' => false ,
                'error' => $validator->errors()->first(),
                'phone' => $request->phone ,
            ]);
        }

        $user = LoyaltyOfferUser::where('user_phone' , $request->phone)->first();
        $offerNum = LoyaltyOfferUser::where('user_phone' , $request->phone)->count();
        $prizeNum = LoyaltyPrize::where('user_phone' , $request->phone)->count();
        if(isset($user->id)):
            return response([
                'status' => true ,
                'message' => 'حساب '.$this->restaurant->name.' , بحث بالرقم المستخدم ' . $request->phone . ' بعدد طلبات شراء (' . $offerNum . ') , عدد جزائز (' . $prizeNum . ')' ,

                'phone' => $request->phone ,
            ]);
        else:
            return response([
                'status' => false ,
                'error' => 'رقم الجوال غير مسجل من قبل',
                'phone' => $request->phone ,
            ]);
        endif;
    }


}
