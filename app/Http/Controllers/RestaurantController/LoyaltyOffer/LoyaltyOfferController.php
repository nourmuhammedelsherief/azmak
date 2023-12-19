<?php

namespace App\Http\Controllers\RestaurantController\LoyaltyOffer;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\LoyaltyOffer;
use App\Models\LuckyItem;
use App\Models\ServiceSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyOfferController extends Controller
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
        $items = LoyaltyOffer::whereHas('branch', function ($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id);
        })->with('branch', 'product')->withCount(['userHistory' => function ($query) {
            $query->where('status', 'completed');
        }]);
        if($request->is_active == 1) $items = $items->isActive();
        $items = $items->get();
        $offerCount = LoyaltyOffer::whereHas('branch', function ($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id);
        })->count();
        $offerAvaliableCount = LoyaltyOffer::whereHas('branch', function ($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id);
        })->isActive()->count();
        return view('restaurant.loyalty_offers.items.index', compact('items', 'restaurant' , 'offerCount' , 'offerAvaliableCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant = $this->restaurant;

        $branches = Branch::whereHas('service_subscriptions', function ($q) {
            $q->whereIn('service_id', [11])
                ->whereIn('status', ['active', 'tentative']);
        })->whereHas('products')
            ->whereRestaurantId($restaurant->id)
            ->get();

        if (!isset($branches[0])) :

            flash('لا يوجد منتجات')->error();
            return redirect(route('restaurant.loyalty-offer.item.index'));
        endif;

        return view('restaurant.loyalty_offers.items.create', compact('branches'));
    }

    public function getProducts(Request $request)
    {
        $restaurant = $this->restaurant;
        $id = !empty($request->id) ? $request->id : 0;
        if (!$branch = Branch::where('restaurant_id', $restaurant->id)->find($id)) {
            return response([
                'status' => false,
                'message' => trans('dashboard.error_no_products_exist')
            ]);
        }
        $products = $branch->products()->where('available', 'true')->orderBy('name_' . app()->getLocale())->get(['id', 'name_ar', 'name_en']);
        if ($products->count() == 0) {
            return response([
                'status' => false,
                'message' => trans('dashboard.error_no_products_exist')
            ]);
        }
        return response([
            'status' => true,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $restaurant = $this->restaurant;
        // return $request->all();
        $data = $this->validate($request, [
            'branch_id' => 'required|exists:branches,id',
            'product_id' => 'required|exists:products,id',
            'prize'   => 'required|string|max:191',
            'required_quantity'   => 'required|integer|min:1',
            'status' => 'required|in:true,false',
            'start_date' => 'nullable|date|date_format:Y-m-d\TH:i',
            'end_date' => 'nullable|date|after:start_date|date_format:Y-m-d\TH:i',

        ]);

        // create new employee
        $employee = LoyaltyOffer::create($data);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant.loyalty-offer.item.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = $this->restaurant;
        $item = LoyaltyOffer::whereHas('branch', function ($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id);
        })->findOrFail($id);
        $branches = Branch::whereHas('service_subscriptions', function ($q) {
            $q->where('service_id', 11)->whereIn('status', ['active', 'tentative']);
        })
            ->whereRestaurantId($restaurant->id)

            ->get();

        return view('restaurant.loyalty_offers.items.edit', compact('branches', 'item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $restaurant = $this->restaurant;
        $item =  LoyaltyOffer::whereHas('branch', function ($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id);
        })->findOrFail($id);
        // return $request->all();
        $data = $this->validate($request, [
            'branch_id' => 'required|exists:branches,id',
            'product_id' => 'required|exists:products,id',
            'prize'   => 'required|string|max:191',
            'required_quantity'   => 'required|integer|min:1',
            'status' => 'required|in:true,false',
            'start_date' => 'nullable|date|date_format:Y-m-d\TH:i',
            'end_date' => 'nullable|date|after:start_date|date_format:Y-m-d\TH:i',

        ]);

        // create new employee
        $item->update($data);

        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant.loyalty-offer.item.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        
        $employee = LoyaltyOffer::findOrFail($id);

        $employee->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.loyalty-offer.item.index');
    }

    public function settings(Request $request)
    {
        $restaurant = $this->restaurant;
        if ($request->method() == 'POST') :
            $data = $request->validate([
                'enable_loyalty_offer' => 'required|in:true,false',
            ]);
            $restaurant->update($data);
        endif;
        return view('restaurant.loyalty_offers.settings', compact('restaurant'));
    }
}
