<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\RestaurantOrderSetting;
use App\Models\RestaurantOrderSettingRange;
use Illuminate\Http\Request;

class RestaurantOrderSettingRangeController extends Controller
{
    public function index($id)
    {
        $setting = RestaurantOrderSetting::findOrFail($id);
        $ranges = RestaurantOrderSettingRange::whereSettingId($id)->get();
        return view('restaurant.settings.ranges.index', compact('setting' , 'ranges'));
    }

    public function create($id)
    {
        $setting = RestaurantOrderSetting::findOrFail($id);
        return view('restaurant.settings.ranges.create', compact('setting'));
    }

    public function store(Request $request , $id)
    {
        $setting = RestaurantOrderSetting::findOrFail($id);
        $this->validate($request , [
            'distance' => 'required',
            'price'    => 'required'
        ]);

        RestaurantOrderSettingRange::create([
            'setting_id' => $setting->id,
            'distance'   => $request->distance,
            'price'      => $request->price,
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant_setting_range.index' , $setting->id);
    }

    public function edit($id)
    {
        $range = RestaurantOrderSettingRange::findOrFail($id);
        return view('restaurant.settings.ranges.edit', compact('range'));
    }

    public function update(Request $request , $id)
    {
        $range = RestaurantOrderSettingRange::findOrFail($id);
        $this->validate($request , [
            'distance' => 'required',
            'price'    => 'required'
        ]);

        $range->update([
            'distance'   => $request->distance,
            'price'      => $request->price,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant_setting_range.index' , $range->setting->id);
    }

    public function destroy($id)
    {
        $range = RestaurantOrderSettingRange::findOrFail($id);
        $range->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant_setting_range.index' , $range->setting->id);
    }
}
