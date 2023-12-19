<?php

namespace App\Http\Controllers\RestaurantController\Waiting;

use App\Http\Controllers\Controller;

use App\Models\Reservation\ReservationOrder;
use App\Models\Reservation\ReservationTable;
use App\Models\Restaurant;
use App\Models\ServiceSubscription;
use App\Models\Waiting\WaitingBranch;
use App\Models\Waiting\WaitingPlace;
use Illuminate\Http\Request;

class WaitingPlaceController extends Controller
{
    private $restaurant;
    public function __construct()
    {
        
        $this->middleware('auth:restaurant');
        $this->middleware(function ($request, $next) {
            $restaurant = auth('restaurant')->user();
            $checkReservation = ServiceSubscription::whereRestaurantId($restaurant->id)
                ->where('service_id', 15)
                ->whereIn('status', ['active', 'tentative'])
                ->first();
            if ($checkReservation == null) {
                abort(404);
            }
            $this->restaurant = $restaurant;
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
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee') :

            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;

        $places = WaitingPlace::where('restaurant_id', $restaurant->id)->get();
        return view('restaurant.waiting.places.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $branches = WaitingBranch::where('restaurant_id' , $this->restaurant->id)->where('status' , 'true')->get();
        return view('restaurant.waiting.places.create' , compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'branch_id' => 'required|integer|exists:waiting_branches,id' , 
            'name_ar' => 'required|string|max:191',
            'name_en' => 'required|string|max:191',
            'status' => 'required|boolean',
            // 'location_link' => 'nullable|url',
        ]);
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee') :
         
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $data['restaurant_id'] = $restaurant->id;
        // create new bank
        WaitingPlace::create($data);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant.waiting.place.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $place = WaitingPlace::findOrFail($id);
        $branches = WaitingBranch::where('restaurant_id' , $this->restaurant->id)->where('status' , 'true')->get();
        return view('restaurant.waiting.places.edit', compact('place' , 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WaitingPlace $place)
    {
        $restaurant = $this->restaurant;

        $data = $this->validate($request, [
            'name_ar' => 'required|string|max:191',
            'name_en' => 'required|string|max:191',
            'status' => 'required|boolean',
            'branch_id' => 'required|integer|exists:waiting_branches,id',
        ]);
        $place->update($data);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant.waiting.place.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $restaurant = $this->restaurant;
        $bank = WaitingPlace::where('restaurant_id', $restaurant->id)->findOrFail($id);
        
        // if ($check) {
        //     flash(trans('messages.cant_deleted'))->error();
        //     return redirect()->route('restaurant.waiting.place.index');
        // }
        $bank->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.waiting.place.index');
    }
}
