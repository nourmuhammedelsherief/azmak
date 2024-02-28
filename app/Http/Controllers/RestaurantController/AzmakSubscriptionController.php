<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\AzSubscription;

class AzmakSubscriptionController extends Controller
{
    public function show_subscription($id)
    {
        $restaurant = Restaurant::find($id);
        // get azmak setting subscription type
        // 2 - Online Payment

        // 1 - free subscription
        AzSubscription::create([
            'restaurant_id'  => $restaurant->id,
            'status'         => 'free',
            'end_at'         => Carbon::now()->addYears(10),
        ]);
        flash(trans('messages.AzmakFreeSubscriptionDoneSuccessfully'))->success();
        return redirect()->back();
    }
}
