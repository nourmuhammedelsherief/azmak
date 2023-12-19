<?php

namespace App\Http\Controllers\RestaurantController\Lucky_Wheel;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\LuckyItem;
use App\Models\LuckyOrder;
use App\Models\ServiceSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LuckyWheelOrderController extends Controller
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
    public function index($status = null)
    {
        $restaurant = $this->restaurant;
        $orders = LuckyOrder::whereRestaurantId($restaurant->id);
        if(in_array($status , ['new' , 'canceled' , 'completed'])) {
            $orders = $orders->where('status' , $status);
        }else{ $status = 'all';}
        $orders = $orders->orderBy('created_at' , 'desc')
            ->get();
        return view('restaurant.lucky_wheel.orders.index', compact('orders', 'restaurant' , 'status'));
    }
    public function changeStatus($id , $status)
    {
        $item = LuckyOrder::where('restaurant_id' , $this->restaurant->id)->findOrFail($id);
        if(in_array($status , ['accept' , 'reject'])):
            $status = $status == 'accept' ? 'completed' : 'canceled';
            $item->update([
                'status' => $status , 
            ]);
            flash(trans('messages.updated'))->success();
        endif;
        
        return redirect()->route('restaurant.lucky.order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $employee = LuckyOrder::findOrFail($id);
        $employee->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.lucky.order.index');
    }
}
