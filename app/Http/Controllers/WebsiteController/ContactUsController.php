<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Restaurant\Azmak\AZContactUs;

class ContactUsController extends Controller
{
    public function index($res)
    {
        $restaurant  = Restaurant::whereNameBarcode($res)->firstOrFail();
        return view('website.pages.contactUs' , compact('restaurant'));
    }

    public function contact_us(Request $request , $res)
    {
        $restaurant  = Restaurant::whereNameBarcode($res)->firstOrFail();
        $this->validate($request , [
            'name'       => 'required|string|max:191',
            'email'      => 'required|email|max:191',
            'message'    => 'required|string',
        ]);
        // create new contact us
        AZContactUs::create([
            'restaurant_id' => $restaurant->id,
            'name'          => $request->name,
            'email'         => $request->email,
            'message'       => $request->message,
        ]);
        flash(trans('messages.contactSendSuccessfully'))->success();
        return redirect()->back();
    }
}
