<?php

namespace App\Http\Controllers\RestaurantController\Waiter;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Restaurant;
use App\Models\RestaurantWaiter;
use App\Models\RestaurantWaiterBranch;
use App\Models\ServiceSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:restaurant');
        $this->middleware(function ($request, $next) {
            $restaurant = auth('restaurant')->user();
            $checkReservation = ServiceSubscription::whereRestaurantId($restaurant->id)
                ->whereIn('service_id', [14, 10])
                ->whereIn('status', ['active', 'tentative'])
                ->first();
            if ($checkReservation == null or ($checkReservation->service_id == 10 and $checkReservation->service->enable_waiter != 'true')) {
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
        $restaurant = Auth::guard('restaurant')->user();
        if ($restaurant->type == 'employee') :

            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;

        $employees = RestaurantWaiter::whereRestaurantId($restaurant->id)
            ->get();
        return view('restaurant.waiters.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant = Auth::guard('restaurant')->user();
        if ($restaurant->type == 'employee') :
            // if (check_restaurant_permission($restaurant->id, 3) == false) :
            //     abort(404);
            // endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;

        $branches = Branch::with('subscription', 'service_subscriptions')
            // ->whereHas('subscription' , function ($q){
            //     $q->where('end_at' , '!=' , null);
            // })
            ->whereHas('service_subscriptions', function ($q) {
                $q->whereIn('service_id', [14 , 10])
                    ->whereIn('status', ['active', 'tentative']);
            })
            ->whereRestaurantId($restaurant->id)

            ->get();


        return view('restaurant.waiters.employees.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $restaurant = Auth::guard('restaurant')->user();
        if ($restaurant->type == 'employee') :
            // if (check_restaurant_permission($restaurant->id, 3) == false) :
            //     abort(404);
            // endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $this->validate($request, [
            'branch_id' => 'required|exists:branches,id',
            'name'   => 'required|string|max:191',
            'email' => 'required|string|email|max:255|unique:restaurant_employees',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => ['required', 'unique:restaurant_employees', 'regex:/^((05)|(01))[0-9]{8}/'],
        ]);
        // create new employee
        $employee = RestaurantWaiter::create([
            'restaurant_id' => $restaurant->id,
            'branch_id'  => $request->branch_id,
            'name'  => $request->name,
            'email'  => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'type' => ['waiter'],
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant.waiter.employees.index');
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
        $restaurant = Auth::guard('restaurant')->user();
        if ($restaurant->type == 'employee') :
            if (check_restaurant_permission($restaurant->id, 3) == false) :
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $checkOrderService = ServiceSubscription::whereRestaurantId($restaurant->id)
            ->whereIn('service_id', [9, 14, 14])
            ->first();
        if ($checkOrderService == null) {
            abort(404);
        }
        $employee = RestaurantWaiter::findOrFail($id);
        $branches = Branch::with('subscription', 'service_subscriptions')
            // ->whereHas('subscription' , function ($q){
            //     $q->where('end_at' , '!=' , null);
            // })
            ->whereHas('service_subscriptions', function ($q) {
                $q->where('service_id', 14)->whereIn('status', ['active', 'tentative']);
            })
            ->whereRestaurantId($restaurant->id)
            // ->whereStatus('active')
            // ->where('foodics_status', 'false')
            ->get();
        return view('restaurant.waiters.employees.edit', compact('branches', 'employee'));
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
        $employee = RestaurantWaiter::findOrFail($id);
        $this->validate($request, [
            'branch_id' => 'required|exists:branches,id',
            'name'   => 'required|string|max:191',
            'email' => 'required|string|email|max:255|unique:restaurant_employees,email,' . $employee->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => ['required', 'unique:restaurant_employees,phone_number,' . $employee->id, 'regex:/^((05)|(01))[0-9]{8}/'],
        ]);
        // create new employee
        $employee->update([
            'branch_id'  => $request->branch_id,
            'name'  => $request->name,
            'email'  => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $request->password == null ? $employee->password : Hash::make($request->password),
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant.waiter.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $employee = RestaurantWaiter::findOrFail($id);
        $employee->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.waiter.employees.index');
    }
}
