<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant\Azmak\AZOrder;

class OrderController extends Controller
{
    public function order_info($id)
    {
        $order = AZOrder::findOrFail($id);
        $restaurant = $order->restaurant;
        $branch = $order->branch;
        return view('website.orders.info' , compact('order' , 'restaurant' , 'branch'));
    }
    public function submit_order_info(Request $request , $id)
    {
        $order = AZOrder::findOrFail($id);
        $restaurant = $order->restaurant;
        $branch = $order->branch;
        if ($order->user->name == null)
        {
            $this->validate($request , [
                'name' => 'required|string|max:191',
                'email' => 'required|email|max:191',
            ]);
            $order->user->update([
                'name'   =>  $request->name,
                'email'  => $request->email
            ]);
        }
        $this->validate($request , [
            'person_name' => 'required|string|max:191',
            'person_phone' => 'required|min:10',
            'occasion' => 'required|string|max:191',
            'message' => 'nullable|string',
        ]);
        $order->update([
            'person_name'        => $request->person_name,
            'person_phone'       => $request->person_phone,
            'occasion'           => $request->occasion,
            'occasion_message'   => $request->message,
        ]);
        // move to payment
        return redirect()->route();
    }
}
