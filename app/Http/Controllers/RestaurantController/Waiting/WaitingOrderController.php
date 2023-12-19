<?php

namespace App\Http\Controllers\RestaurantController\Waiting;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Restaurant;

use App\Models\WaitingOrderBranch;
use App\Models\ServiceSubscription;
use App\Models\Waiting\WaitingOrder;
use App\Models\Waiting\WaitingPlace;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class WaitingOrderController extends Controller
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
    public function index(Request $request)
    {
        $restaurant = $this->restaurant;
        $orders = WaitingOrder::whereRestaurantId($restaurant->id)->with('branch' , 'place');
        if(in_array($request->status , ['new' , 'completed' ,'canceled' , 'in_progress'])):
            $orders = $orders->where('status' , $request->status);
        else:
            $orders = $orders->whereIn( 'status' , ['new' , 'in_progress']);
        endif;
        $t = $orders;
        $newOrdersCount =WaitingOrder::whereRestaurantId($restaurant->id)->with('branch' , 'place')->where('status' , 'new')->count();
        $orders = $orders->selectRaw('waiting_orders.* , (select count(*) from waiting_orders as w where w.id != waiting_orders.id and w.status in("new") and w.created_at < waiting_orders.created_at) as waiting_count')->orderBy('created_at', 'asc')->paginate(200);
        
        if(request()->wantsJson()):
            
            return response([
                'status' => true , 
                'new_orders_count' => $newOrdersCount , 
                'view' => view('restaurant.waiting.orders.includes.order_table' , compact('orders' , 'restaurant'))->render() , 
            ]);
        endif;
        $places = WaitingPlace::where('restaurant_id' , $restaurant->id)->where('status' , 'true')->get();
        return view('restaurant.waiting.orders.index', compact('orders' , 'places' , 'restaurant' , 'newOrdersCount'));
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
        $valid = validator($request->all(), [
            'place_id' => 'required|exists:waiting_places,id',
            'name'   => 'required|string|max:191',
            'email' => 'nullable|string|email|max:255',
            'phone' => ['required', 'regex:/^((05)|(01))[0-9]{8}/'],
        ]);
        if($valid->fails()):
            return response([
                'status' => false, 
                'message' => $valid->errors()->first() , 
            ]);
        else:
            $data = $valid->validate();
        endif;
        $place = WaitingPlace::where('restaurant_id' , $restaurant->id)->findOrFail($request->place_id);
        $data['restaurant_id'] = $restaurant->id;
        $data['branch_id'] = $place->branch_id;
        $data['num'] = WaitingOrder::getNewNum($restaurant->id);
        // create new employee
        $employee = WaitingOrder::create($data);
        return response([
            'status' => true , 
            'message' => trans('messages.created') , 
        ]);
        
    }
    public function completeOrder(Request $request)
    {
        $restaurant = $this->restaurant;
        $valid = validator($request->all(), [
            'id' => 'required|integer',

        ]);
        if ($valid->fails()) :
            return response([
                'status' => false,
                'message' => $valid->errors()->first(),
            ]);

        endif;

        $order = WaitingOrder::where('restaurant_id', $restaurant->id)->where('id', $request->id)->where('status', 'in_progress')->first();
        $mins = (empty($restaurant->waiting_progress_time) ? 5 : $restaurant->waiting_progress_time);
        $ddate = Carbon::now()->subMinutes($mins);
        $inProgressDate = Carbon::parse($order->in_progress_date);
        if (!isset($order->id)) :
            return response([
                'status' => false,
                'message' => 'الطلب غير موجود',
            ]);
        elseif ($inProgressDate->greaterThan($ddate)) :
            $order->update([
                'status' => 'canceled' ,
            ]);
            return response([
                'status' => false,
                'message' => 'لقد انتهي الطلب من قبل',
            ]);
        endif;

        $order->update([
            'status' => 'completed',
            // 'in_progress_date' => Carbon::now(),
        ]);
        return response([
            'status' => true,
            'message' =>'تم انهاء الطلب بنجاح',
        ]);
    }
    public function receiveOrder(Request $request)
    {
        $restaurant = $this->restaurant;
        $valid = validator($request->all(), [
            'place_id' => 'required|exists:waiting_places,id',
       
        ]);
        if($valid->fails()):
            return response([
                'status' => false, 
                'message' => $valid->errors()->first() , 
            ]);
 
        endif;
        $place = WaitingPlace::where('restaurant_id' , $restaurant->id)->findOrFail($request->place_id);
        $orders = WaitingOrder::where('restaurant_id' , $restaurant->id)->where('place_id' , $place->id)->where('status' ,'new')->orderBy('created_at' , 'asc')->get();
        if($orders->count() == 0):
            return response([
                'status' => false, 
                'message' => 'لا يوجد عملاء جديد لهذا المكان' , 
            ]);
        endif;
        $temp = $orders[0];
        $temp->update([
            'status' => 'in_progress' , 
            'in_progress_date' => Carbon::now() , 
        ]);
        return response([
            'status' => true , 
            'message' => 'تم استقبال العميل ' . $temp->name . ' الي المكان ' . $place->name , 
        ]);
        
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
        $employee = WaitingOrder::findOrFail($id);
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
        return view('restaurant.waiting.orders.edit', compact('branches', 'employee'));
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
        $employee = WaitingOrder::findOrFail($id);
        $restaurant = $this->restaurant;
        $this->validate($request, [
            'branch_id' => 'required|exists:branches,id',
            'name'   => 'required|string|max:191',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => ['required', 'regex:/^((05)|(01))[0-9]{8}/'],
        ]);
        if(WaitingOrder::where('restaurant_id' , $restaurant->id)->where('id' , '!=' , $employee->id)->where('email' , $request->email)->first()):
            throw ValidationException::withMessages([
                'email' => 'البريد الالكتروني مستخدم من قبل'
            ]);
        endif;
        if(WaitingOrder::where('restaurant_id' , $restaurant->id)->where('id' , '!=' , $employee->id)->where('phone_number' , $request->phone_number)->first()):
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
        return redirect()->route('restaurant.waiting.order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        
        $employee = WaitingOrder::findOrFail($id);
        $employee->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.waiting.order.index');
    }
}
