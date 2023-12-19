<?php

namespace App\Http\Controllers\RestaurantController\OnlineOffer;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\LuckyItem;
use App\Models\OnlineOfferCategory;
use App\Models\ServiceSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineOfferCategoryController extends Controller
{
    private $restaurant, $subscription;
    public function __construct()
    {
        $this->middleware('auth:restaurant');
        $this->middleware(function ($request, $next) {
            $this->restaurant = auth('restaurant')->user();

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant = $this->restaurant;
        $items = OnlineOfferCategory::whereHas('branch' , function($query)use($restaurant){
            $query->where('restaurant_id' , $restaurant->id);
        })->paginate(500);
        return view('restaurant.online_offers.items.index', compact('items', 'restaurant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant = $this->restaurant;

        $branches = Branch::
            whereRestaurantId($restaurant->id)
            ->get();


        return view('restaurant.online_offers.items.create', compact('branches'));
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
        $this->validate($request, [
            'branch_id' => 'required|exists:branches,id',
            'name_ar'   => 'required|string|max:191',
            'name_en'   => 'nullable|string|max:191',
            'status' => 'required|in:true,false' ,
            'sort' => 'required|integer|min:1' ,

        ]);
        // create new employee
        $employee = OnlineOfferCategory::create([
            // 'restaurant_id' => $restaurant->id,
            'branch_id'  => $request->branch_id,
            'name_ar'  => $request->name_ar,
            'name_en'  => $request->name_en,
            'sort' => $request->sort,
            'status' => $request->status
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant.online_offer.category.index');
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
        $item = OnlineOfferCategory::whereHas('branch' , function($query)use($restaurant){
            $query->where('restaurant_id' , $restaurant->id);
        })->findOrFail($id);
        $branches = Branch::
            whereRestaurantId($restaurant->id)

            ->get();
        return view('restaurant.online_offers.items.edit', compact('branches', 'item'));
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
        $item =  OnlineOfferCategory::whereHas('branch' , function($query)use($restaurant){
            $query->where('restaurant_id' , $restaurant->id);
        })->findOrFail($id);
        $this->validate($request, [
            'branch_id' => 'required|exists:branches,id',
            'name_ar'   => 'required|string|max:191',
            'name_en'   => 'nullable|string|max:191',
            'status' => 'required|in:true,false' ,
            'sort' => 'required|integer|min:1' ,

        ]);
        // create new employee
        $item->update([

            'branch_id'  => $request->branch_id,
            'name_ar'  => $request->name_ar,
            'name_en'  => $request->name_en,
            'sort' => $request->sort,
            'status' => $request->status
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant.online_offer.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $restaurant = $this->restaurant;
        $employee =  OnlineOfferCategory::whereHas('branch' , function($query)use($restaurant){
            $query->where('restaurant_id' , $restaurant->id);
        })->findOrFail($id);
        $employee->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.online_offer.category.index');
    }
}
