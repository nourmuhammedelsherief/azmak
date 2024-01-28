<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Restaurant\Azmak\AZUser;
use App\Models\Restaurant\Azmak\AZBranch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function join_us($res , $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        return view('website.users.register' , compact('restaurant' , 'branch'));
    }

    public function register(Request $request , $res , $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $this->validate($request , [
            'name'         => 'required|string|max:191',
            'email'        => 'required|email|max:191',
            'company'      => 'sometimes|string|max:191',
            'company_type' => 'sometimes|string|max:191',
            'phone_number' => 'required|numeric|min:10',
            'password'     => 'required|string|min:6',
            'password_confirmation'     => 'required|same:password',
        ]);
        // create new user
        AZUser::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'company'         => $request->company,
            'company_type'    => $request->company_type,
            'phone_number'    => $request->phone_number,
        ]);
        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::guard('web')->attempt($credential, true)):
            return redirect()->route('homeBranchIndex' , [$restaurant->name_barcode , $branch->name_en]);
        endif;
        return redirect()->back()->withInput($request->only(['email', 'remember']))->with('warning_login', trans('messages.warning_login'));
        flash(trans('messages.user_registered_successfully'))->success();
        return redirect()->back();
    }

    public function show_login($res , $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        return view('website.users.login' , compact('restaurant' , 'branch'));
    }

    public function login(Request $request , $res , $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $this->validate($request , [
            'phone_number'  => 'required|min:10',
            'password'      => 'required|string|min:6'
        ]);
        $credential = [
            'phone_number' => $request->phone_number,
            'password' => $request->password
        ];
        if (Auth::guard('web')->attempt($credential, true)):
            return redirect()->route('homeBranchIndex' , [$restaurant->name_barcode , $branch->name_en]);
        endif;
        return redirect()->back()->withInput($request->only(['phone_number', 'remember']))->with('warning_login', trans('messages.warning_login'));
    }

    public function profile($res , $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $user = auth()->guard('web')->user();
        return view('website.users.profile' , compact('restaurant' , 'branch' , 'user'));
    }
    public function edit_profile(Request $request , $res , $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $user = auth()->guard('web')->user();

        $this->validate($request , [
            'name'         => 'sometimes|string|max:191',
            'email'        => 'sometimes|email|max:191',
            'company'      => 'sometimes|string|max:191',
            'company_type' => 'sometimes|string|max:191',
            'phone_number' => 'required|numeric|min:10',
            'password'     => 'sometimes',
            'password_confirmation'     => 'sometimes|same:password',
        ]);
        $user->update([
            'name'            => $request->name == null ? $user->name : $request->name,
            'email'           => $request->email == null ? $user->email : $request->email,
            'password'        => $request->password == null ? $user->password : Hash::make($request->password),
            'company'         => $request->company == null ? $user->company : $request->company,
            'company_type'    => $request->company_type == null ? $user->company_type : $request->company_type,
            'phone_number'    => $request->phone_number == null ? $user->phone_number : $request->phone_number,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        auth()->guard('web')->logout();
        return redirect()->back();
    }
}
