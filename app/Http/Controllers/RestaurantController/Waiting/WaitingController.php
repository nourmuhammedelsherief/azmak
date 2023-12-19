<?php

namespace App\Http\Controllers\RestaurantController\Waiting;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaitingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:restaurant');
    }

    public function getSettings(Request $request)
    {
        $restaurant = auth('restaurant')->user();
        if ($request->method() == 'POST') :
            // return $request->all();
            $data = $request->validate([
                'enable_waiting' => 'required|in:true,false',
                'waiting_progress_time' => 'required|integer|min:1',
                'waiting_max_new_request' => 'required|integer|min:1' , 
                'waiting_new_request' => 'required|array|min:1', 
                'waiting_new_request.*' => 'required|in:client,dashboard' ,  
                'waiting_alert_type' => 'required|in:sms,notification'  , 
                'waiting_privacy_en' => 'nullable|string' , 
                'waiting_privacy_ar' => 'nullable|string' , 
                'sms_method' => 'nullable|in:taqnyat' , 
                'sms_sender' => 'nullable|min:1|max:190' , 
                'sms_token' => 'nullable|min:1|max:190' , 
            ]);
            if($request->waiting_alert_type == 'sms'):
                $request->validate([
                    'sms_method' => 'required|in:taqnyat' , 
                    'sms_sender' => 'required|min:1|max:190' , 
                    'sms_token' => 'required|min:1|max:190' , 
                ]);
            endif;
          

            flash(trans('messages.updated'))->success();
            $restaurant->update($data);
        endif;
        
        return view('restaurant.waiting.settings', compact('restaurant'));
    }

}
