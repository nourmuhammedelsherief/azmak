<?php

namespace App\Http\Controllers\RestaurantController\Waiting;

use App\Http\Controllers\Controller;

use App\Models\Reservation\ReservationOrder;
use App\Models\Reservation\ReservationTable;
use App\Models\Restaurant;
use App\Models\ServiceSubscription;
use App\Models\Waiting\WaitingBranch;
use Illuminate\Http\Request;

class WaitingBranchController extends Controller
{
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

        $branches = WaitingBranch::where('restaurant_id', $restaurant->id)->get();
        return view('restaurant.waiting.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.waiting.branches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'name_ar' => 'required|string|max:191',
            'name_en' => 'required|string|max:191',
            'status' => 'required|boolean',
            'location_link' => 'nullable|url',
        ]);
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee') :
         
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        // create new bank
        WaitingBranch::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'status' => $request->status,
            'restaurant_id' => $restaurant->id,
            'location_link' => $request->location_link,
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant.waiting.branch.index');
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
        $branch = WaitingBranch::findOrFail($id);
        return view('restaurant.waiting.branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WaitingBranch $branch)
    {
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee') :
            if (check_restaurant_permission($restaurant->id, 3) == false) :
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $branch = WaitingBranch::where('restaurant_id', $restaurant->id)->findOrFail($branch->id);
        $this->validate($request, [
            'name_ar' => 'required|string|max:191',
            'name_en' => 'required|string|max:191',
            'status' => 'required|boolean',
            'location_link' => 'nullable|url',
        ]);
        $branch->update([

            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'status' => $request->status,
            'location_link' => $request->location_link
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant.waiting.branch.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee') :
            if (check_restaurant_permission($restaurant->id, 3) == false) :
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $bank = WaitingBranch::where('restaurant_id', $restaurant->id)->findOrFail($id);
        $check = $bank->places()->count() > 0 ? true : false;
        if ($check) {
            flash(trans('messages.cant_deleted'))->error();
            return redirect()->route('restaurant.waiting.branch.index');
        }
        $bank->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.waiting.branch.index');
    }
}
