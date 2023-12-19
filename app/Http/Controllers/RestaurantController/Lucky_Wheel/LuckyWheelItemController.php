<?php

namespace App\Http\Controllers\RestaurantController\Lucky_Wheel;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\LuckyItem;
use App\Models\ServiceSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LuckyWheelItemController extends Controller
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
    public function index()
    {
        $restaurant = $this->restaurant;
        $items = LuckyItem::whereRestaurantId($restaurant->id)
            ->get();
        return view('restaurant.lucky_wheel.items.index', compact('items', 'restaurant'));
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
        })
            ->whereRestaurantId($restaurant->id)
            ->get();


        return view('restaurant.lucky_wheel.items.create', compact('branches'));
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
        $employee = LuckyItem::create([
            'restaurant_id' => $restaurant->id,
            'branch_id'  => $request->branch_id,
            'name_ar'  => $request->name_ar,
            'name_en'  => $request->name_en,
            'sort' => $request->sort,
            'status' => $request->status
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant.lucky.item.index');
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
        $item = LuckyItem::findOrFail($id);
        $branches = Branch::whereHas('service_subscriptions', function ($q) {
                $q->where('service_id', 11)->whereIn('status', ['active', 'tentative']);
            })
            ->whereRestaurantId($restaurant->id)

            ->get();
        return view('restaurant.lucky_wheel.items.edit', compact('branches', 'item'));
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
        $item = LuckyItem::where('restaurant_id' , $restaurant->id)->findOrFail($id);
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
        return redirect()->route('restaurant.lucky.item.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $employee = LuckyItem::findOrFail($id);
        $employee->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.lucky.item.index');
    }
}
