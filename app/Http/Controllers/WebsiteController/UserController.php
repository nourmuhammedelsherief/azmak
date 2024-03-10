<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Country;
use App\Models\Restaurant\Azmak\AZUser;
use App\Models\Restaurant\Azmak\AZBranch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function join_us($res, $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        return view('website.users.register', compact('restaurant', 'branch'));
    }

    public function register(Request $request, $res, $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'company' => 'sometimes|string|max:191',
            'company_type' => 'sometimes|string|max:191',
            'phone_number' => 'required|numeric|min:10',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
        ]);
        // create new user
        AZUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company' => $request->company,
            'company_type' => $request->company_type,
            'phone_number' => $request->phone_number,
        ]);
        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::guard('web')->attempt($credential, true)):
            return redirect()->route('homeBranchIndex', [$restaurant->name_barcode, $branch->name_en]);
        endif;
        return redirect()->back()->withInput($request->only(['email', 'remember']))->with('warning_login', trans('messages.warning_login'));
        flash(trans('messages.user_registered_successfully'))->success();
        return redirect()->back();
    }

    public function show_login($res = null, $branch=null)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $countries = Country::all();
        return view('website.users.login', compact('restaurant', 'branch' , 'countries'));
    }

    public function login(Request $request, $res, $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $this->validate($request, [
            'country_id' => 'required|exists:countries,id',
            'phone_number' => ['required', 'regex:/^((05)|(01)|())[0-9]{8}/'],
        ]);

        $check = substr($request->phone_number, 0, 2) === '05';
        //        dd($check , $request->country_id);
        if ($check == true and $request->country_id == '1') {
            Toastr::error(trans('messages.loginErrorCountry'), trans('messages.login'), ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        } elseif ($check == false and $request->country_id == '2') {
            Toastr::error(trans('messages.loginErrorCountry'), trans('messages.login'), ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
        $user = AZUser::wherePhoneNumber($request->phone_number)->first();
        if ($user == null)
        {
            $user = AZUser::create([
                'country_id'   => $request->country_id,
                'phone_number' => $request->phone_number,
            ]);
        }
        Auth::guard('web')->login($user, true);
        Toastr::success(trans('messages.loginSuccessfully'), trans('messages.login'), ["positionClass" => "toast-top-right"]);
        if (session()->has('current_order')) :
            $myRequest = new Request(session('current_order'));
            $con = new CartController();
            return $con->add_to_cart($myRequest);
        endif;
        return redirect()->route('homeBranchIndex', [$restaurant->name_barcode, $branch->name_en]);
    }

    public function profile($res, $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $user = auth()->guard('web')->user();
        return view('website.users.profile', compact('restaurant', 'branch', 'user'));
    }

    public function edit_profile(Request $request, $res, $branch)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        $user = auth()->guard('web')->user();

        $this->validate($request, [
            'name' => 'sometimes|string|max:191',
            'email' => 'sometimes|email|max:191',
            'company' => 'sometimes|string|max:191',
            'company_type' => 'sometimes|string|max:191',
            'phone_number' => 'required|numeric|min:10',
            'password' => 'sometimes',
            'password_confirmation' => 'sometimes|same:password',
        ]);
        $user->update([
            'name' => $request->name == null ? $user->name : $request->name,
            'email' => $request->email == null ? $user->email : $request->email,
            'password' => $request->password == null ? $user->password : Hash::make($request->password),
            'company' => $request->company == null ? $user->company : $request->company,
            'company_type' => $request->company_type == null ? $user->company_type : $request->company_type,
            'phone_number' => $request->phone_number == null ? $user->phone_number : $request->phone_number,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

    public function logout(Request $request , $res = null , $branch = null)
    {
        $restaurant = Restaurant::whereNameBarcode($res)->firstOrFail();
        $branch = AZBranch::whereNameEn($branch)->first();
        auth()->guard('web')->logout();
        return redirect()->route('homeBranchIndex', [$restaurant->name_barcode, $branch->name_en]);
    }
}
