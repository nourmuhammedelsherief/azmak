<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AzmakSetting;

class SettingController extends Controller
{
    public function setting()
    {
        $settings = AzmakSetting::first();
        return view('admin.settings.index' , compact('settings'));
    }
    public function setting_update(Request $request)
    {
        $settings = AzmakSetting::first();
        $this->validate($request , [
            'type'  => 'required'
        ]);
        $settings->update([
            'subscription_type'  => $request->type,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }
}
