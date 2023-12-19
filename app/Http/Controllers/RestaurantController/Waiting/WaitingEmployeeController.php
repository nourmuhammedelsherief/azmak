<?php

namespace App\Http\Controllers\RestaurantController\Waiting;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Restaurant;

use App\Models\WaitingEmployeeBranch;
use App\Models\ServiceSubscription;
use App\Models\WaitingEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class WaitingEmployeeController extends Controller
{
    private $restaurant;
    public function __construct()
    {
        $this->middleware('auth:restaurant');
        $this->middleware(function ($request, $next) {
            $restaurant = auth('restaurant')->user();
            $checkOrderService = ServiceSubscription::whereRestaurantId($restaurant->id)
                ->whereIn('service_id', [15])
                ->first();
            if ($checkOrderService == null) {
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
        $restaurant = $this->restaurant;
        $employees = WaitingEmployee::whereRestaurantId($restaurant->id)
            ->get();
        return view('restaurant.waiting.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant = $this->restaurant;
        
        $branches = Branch::with('subscription', 'service_subscriptions')
            // ->whereHas('subscription' , function ($q){
            //     $q->where('end_at' , '!=' , null);
            // })
            ->whereHas('service_subscriptions', function ($q) {
                $q->whereIn('service_id', [15])
                    ->whereIn('status', ['active', 'tentative']);
            })
            ->whereRestaurantId($restaurant->id)
            
            ->get();


        return view('restaurant.waiting.employees.create', compact('branches'));
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
            'name'   => 'required|string|max:191',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => ['required', 'regex:/^((05)|(01))[0-9]{8}/'],
        ]);
        if(WaitingEmployee::where('restaurant_id' , $restaurant->id)->where('email' , $request->email)->first()):
            throw ValidationException::withMessages([
                'email' => 'البريد الالكتروني مستخدم من قبل'
            ]);
        endif;
        if(WaitingEmployee::where('restaurant_id' , $restaurant->id)->where('phone_number' , $request->phone_number)->first()):
            throw ValidationException::withMessages([
                'phone_number' => 'رقم الجوال مستخدم من قبل'
            ]);
        endif;
        // create new employee
        $employee = WaitingEmployee::create([
            'restaurant_id' => $restaurant->id,
            'branch_id'  => $request->branch_id,
            'name'  => $request->name,
            'email'  => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'type'=> ['waiting'] , 
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant.waiting.employee.index');
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
        $employee = WaitingEmployee::findOrFail($id);
        $branches = Branch::with('subscription', 'service_subscriptions')
            // ->whereHas('subscription' , function ($q){
            //     $q->where('end_at' , '!=' , null);
            // })
            ->whereHas('service_subscriptions', function ($q) {
                $q->where('service_id', 15)->whereIn('status', ['active', 'tentative']);
            })
            ->whereRestaurantId($restaurant->id)
            // ->whereStatus('active')
            // ->where('foodics_status', 'false')
            ->get();
        return view('restaurant.waiting.employees.edit', compact('branches', 'employee'));
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
        $employee = WaitingEmployee::findOrFail($id);
        $restaurant = $this->restaurant;
        $this->validate($request, [
            'branch_id' => 'required|exists:branches,id',
            'name'   => 'required|string|max:191',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => ['required', 'regex:/^((05)|(01))[0-9]{8}/'],
        ]);
        if(WaitingEmployee::where('restaurant_id' , $restaurant->id)->where('id' , '!=' , $employee->id)->where('email' , $request->email)->first()):
            throw ValidationException::withMessages([
                'email' => 'البريد الالكتروني مستخدم من قبل'
            ]);
        endif;
        if(WaitingEmployee::where('restaurant_id' , $restaurant->id)->where('id' , '!=' , $employee->id)->where('phone_number' , $request->phone_number)->first()):
            throw ValidationException::withMessages([
                'phone_number' => 'رقم الجوال مستخدم من قبل'
            ]);
        endif;
        // create new employee
        $employee->update([
            'branch_id'  => $request->branch_id,
            'name'  => $request->name,
            'email'  => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $request->password == null ? $employee->password : Hash::make($request->password),
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant.waiting.employee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        
        $employee = WaitingEmployee::findOrFail($id);
        $employee->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.waiting.employee.index');
    }
}
