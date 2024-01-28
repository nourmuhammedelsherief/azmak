<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Restaurant\Azmak\AZBranch;
use App\Models\CountryPackage;
use App\Models\History;
use App\Models\MenuCategory;
use App\Models\MenuCategoryDay;
use App\Models\Package;
use App\Models\Product;
use App\Models\ProductDay;
use App\Models\ProductModifier;
use App\Models\ProductOption;
use App\Models\ProductPhoto;
use App\Models\ProductSensitivity;
use App\Models\ProductSize;
use App\Models\Report;
use App\Models\Restaurant;
use App\Models\RestaurantFoodicsBranch;
use App\Models\RestaurantSubCategory;
use App\Models\SellerCode;
use App\Models\Setting;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PDF;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $user = Auth::guard('restaurant')->user();
        if ($user->type == 'employee') :
            if (check_restaurant_permission($user->id, 2) == false) :
                abort(404);
            endif;
            $user = Restaurant::find($user->restaurant_id);
        endif;
        $branches = AZBranch::whereRestaurantId($user->id)
            ->orderBy('id', 'desc')
            ->paginate(500);
        return view('restaurant.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        return view('restaurant.branches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $this->validate($request, [
            'name_ar' => 'nullable|string|max:191',
            'name_en' => 'nullable|string|max:191|unique:a_z_branches',
        ]);
        if ($request->name_ar == null && $request->name_en == null) {
            flash(trans('messages.name_required'))->error();
            return redirect()->back();
        }
        // create new branch
        $user = Auth::guard('restaurant')->user();
        if ($user->type == 'employee') :
            if (check_restaurant_permission($user->id, 2) == false) :
                abort(404);
            endif;
            $user = Restaurant::find($user->restaurant_id);
        endif;
        $barcode = str_replace(' ', '-', $request->name_en);
        $branch = AZBranch::create([
            'restaurant_id' => $user->id,
//            'country_id' => $request->country_id,
//            'city_id' => $request->city_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
//            'name_barcode' => $barcode,
//            'status' => 'tentative',
//            'main' => 'false',
//            'description_ar' => $request->description_ar,
//            'description_en' => $request->description_en,
        ]);
//        $end_at = Carbon::now()->addDays(Setting::first()->branch_service_tentative_period);
//        Subscription::create([
//            'package_id' => $package->id,
//            'restaurant_id' => $user->id,
//            'branch_id' => $branch->id,
//            'price' => 0,
//            'status' => 'tentative',
//            'type' => 'branch',
//            'tax_value' => 0,
//            'discount_value' => 0,
//            'end_at' => $end_at,
//        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('branches.index');
    }

    public function get_branch_payment($id)
    {
        $branch = Branch::findOrFail($id);
        $type = 'restaurant';
        return view('restaurant.branches.subscription', compact('branch', 'type'));
    }

    public function store_branch_payment(Request $request, $id)
    {
        if (!auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $this->validate($request, [
            'payment_method' => 'required|in:bank,online',
            'payment_type' => 'sometimes|in:visa,mada,apple_pay',
            'seller_code' => 'nullable|exists:seller_codes,seller_name',

        ]);
        // create new branch
        $user = Auth::guard('restaurant')->user();
        if ($user->type == 'employee') :
            if (check_restaurant_permission($user->id, 2) == false) :
                abort(404);
            endif;
            $user = Restaurant::find($user->restaurant_id);
        endif;
        $branch = Branch::findOrFail($id);
        if ($request->payment == 'true') {
            $branch->subscription->update([
                'payment' => 'true'
            ]);
        }
        // create subscription for branch
        $package = Package::find(1);
        $check_price = CountryPackage::whereCountry_id($branch->country_id)
            ->wherePackageId($package->id)
            ->first();
        if ($check_price == null) {
            $package_actual_price = $branch->main == 'true' ? $package->price : $package->branch_price;
        } else {
            $package_actual_price = $branch->main == 'true' ? $check_price->price : $check_price->branch_price;
        }
        $discount = 0;
        if ($request->seller_code != null) {
            $seller_code = SellerCode::where('seller_name', $request->seller_code)
                ->where('active', 'true')
                ->where('country_id', $branch->country_id)
                ->whereIn('type', ['branch', 'both'])
                ->first();
            if ($seller_code) {
                if ($seller_code->start_at <= Carbon::now() && $seller_code->end_at >= Carbon::now()) {
                    $price = $package_actual_price;
                    $package_price = $price;
                    $discount_percentage = $seller_code->code_percentage;
                    $discount = ($package_price * $discount_percentage) / 100;
                    $price_after_percentage = $package_price - $discount;
                    $commission = $package_price * ($seller_code->percentage - $seller_code->code_percentage) / 100;
                    $total_commission = $seller_code->commission + $commission;
                    $seller_code->update([
                        'commission' => $total_commission,
                    ]);
                    // store this operation to marketer history
                    MarketerOperation::create([
                        'marketer_id' => $seller_code->marketer_id,
                        'seller_code_id' => $seller_code->id,
                        'subscription_id' => $user->subscription->id,
                        'status' => 'not_done',
                        'amount' => $commission,
                    ]);
                    $price = $price_after_percentage;
                } else {
                    $price = $package_actual_price;
                }
            } else {
                $price = $package_actual_price;
            }
        } else {
            $price = $package_actual_price;
        }
        // add the tax for branch subscription price
        $tax = Setting::find(1)->tax;
        $tax_value = $price * $tax / 100;
        $price = $price + $tax_value;
        // check branch has subscription or not
        $subscription_check = Subscription::whereRestaurantId($user->id)
            ->where('branch_id', $branch->id)
            ->first();
        if ($request->seller_code != null) {
            $seller_code = SellerCode::where('seller_name', $request->seller_code)
                ->where('active', 'true')
                ->where('country_id', $branch->country_id)
                ->whereIn('type', ['branch', 'both'])
                ->first();
        } else {
            $seller_code = null;
        }
        if ($subscription_check != null) {
            $subscription_check->update([
                'package_id' => $package->id,
                'price' => $price,
                'tax_value' => $tax_value,
                'discount_value' => $discount,
                'seller_code_id' => $seller_code == null ? null : $seller_code->id,
                'payment_type' => $request->payment_method,
            ]);
            $subscription = $subscription_check;
        } else {

            $subscription = Subscription::create([
                'package_id' => $package->id,
                'restaurant_id' => $user->id,
                'branch_id' => $branch->id,
                'price' => $price,
                'status' => 'tentative',
                'type' => 'branch',
                'tax_value' => $tax_value,
                'discount_value' => $discount,
                'payment_type' => $request->payment_method,
            ]);
        }
        if ($request->payment_method == 'bank') {
            $type = 'restaurant';
            return redirect()->route('renewSubscriptionBankGet', [$user->id, $branch->country_id, $subscription->id, $type]);
        } else {
            // online payment By My fatoorah
            $amount = check_restaurant_amount($id, $price);
            if ($request->payment_type == 'visa') {
                $charge = 2;
            } elseif ($request->payment_type == 'mada') {
                $charge = 6;
            } elseif ($request->payment_type == 'apple_pay') {
                $charge = 11;
            } else {
                $charge = 2;
            }
            $name = app()->getLocale() == 'ar' ? $user->name_ar : $user->name_en;
            $token = "1IzSLeOkLFQH1zljLzerCm2RpB8AjFZLf8MMhSy4d8rHb0h1uHqrBleBFlFv-M4SHnyeiWg2zWQraKYJGndFcFvaBIeCPDQNrNs1Zwo7O-4apFyAXXUVZOAKbYzncpn-1ay0BPxB1X5dNH0EuWQ9OTqzcnOI7c5Ola5Esxz0imTrbVuhmKZl7SWBrPCU_SOYt80BSDe5j2XY5skkK7e5TxDRbbibdZPM7S11aYmQ7xKmZvaSj916IhTNXuIZA73TYE4xxkXyL_8dhHobugeLHF58VJNBjMv2UvzEP0pSk0RqGs3-AeqYwD6S3BbVrOaGIbx4fwKlowd6SOoSqkMoD9tmFwgdbkMxzWKYGqxg7bcvB0r62jBqn4YXh0Ej8FO6mrTdWZo5bHviUDRPMitO2KQDvyXrlWnf74n9DxOfV7MbuutAr2K2L3hzCYkdfU0eqA3snq-3Xh1KFjRvd5QqofEt9ubK71Xd4TooKLyXD4hby5prqJTTEVi23bPsPmB1uZ0D1cawjjJB8eUTIwEiPTgdPOSIOTkVFm4OIrHEXT44NbJ9MyDInxmQK8-pGDr0rNeBeLo8J_uyHbfh_sVlpS7XT0d-ehaTDtENoyG0XMe7hgWDYWsNxIe1N3dXwwtyBXLgggAl6JvdDXBzY3wp13oFfTHdASeOtyO3d0zwvkF-9j0uF2WgHd-kqgEyQVV0_UifcbMafuYwTgbBod5iB1soNMoVcTfjlsmr8LV8CK7Nr8xq";
            $data = array(
                'PaymentMethodId' => $charge,
                'CustomerName' => $name,
                'DisplayCurrencyIso' => 'SAR',
                'MobileCountryCode' => $user->country->code,
                'CustomerMobile' => $user->phone_number,
                'CustomerEmail' => $user->email,
                'InvoiceValue' => $amount,
                'CallBackUrl' => route('checkRestaurantStatus'),
                'ErrorUrl' => url('/error'),
                'Language' => app()->getLocale(),
                'CustomerReference' => 'ref 1',
                'CustomerCivilId' => '12345678',
                'UserDefinedField' => 'Custom field',
                'ExpireDate' => '',
                'CustomerAddress' => array(
                    'Block' => '',
                    'Street' => '',
                    'HouseBuildingNo' => '',
                    'Address' => '',
                    'AddressInstructions' => '',
                ),
                'InvoiceItems' => [array(
                    'ItemName' => $name,
                    'Quantity' => '1',
                    'UnitPrice' => $amount,
                )],
            );
            $data = json_encode($data);
            $fatooraRes = MyFatoorah($token, $data);
            $result = json_decode($fatooraRes);
            if ($result->IsSuccess === true) {
                $subscription->update([
                    'invoice_id' => $result->Data->InvoiceId,
                ]);
                return redirect()->to($result->Data->PaymentURL);
            } else {
                return redirect()->to(url('/error'));
            }
        }
        flash(trans('messages.created'))->success();
        return redirect()->route('branches.index');
    }

    public function renewSubscriptionBankGet($id, $country_id, $subscription_id)
    {
        $user = Restaurant::findOrFail($id);
        $banks = Bank::whereCountryId($country_id)
            ->where('restaurant_id', null)
            ->get();
        $subscription = Subscription::find($subscription_id);
        $type = 'restaurant';
        return view('restaurant.branches.payments.bank_transfer', compact('user', 'banks', 'subscription', 'type'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = AZBranch::findOrFail($id);
        return view('restaurant.branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = AZBranch::findOrFail($id);
        $this->validate($request, [
//            'city_id' => 'required|exists:cities,id',
            'name_ar' => 'nullable|string|max:191',
            'name_en' => 'nullable|string|max:191|unique:a_z_branches,name_en,' . $id,
//            'tax' => 'required|in:true,false',
//            'total_tax_price' => 'required|in:true,false',
//            'tax_value' => "required_if:tax,==,ture",
//            'state' => 'required|in:open,closed,busy,unspecified',
//            'tax_number' => 'nullable|max:191',
//            'description_ar' => 'nullable|min:1',
//            'description_en' => 'nullable|min:1',
            //            'name_barcode' => 'required|string|max:191|unique:branches,name_barcode,' . $id,
        ]);
        if ($request->name_ar == null && $request->name_en == null) {
            flash(trans('messages.name_required'))->error();
            return redirect()->back();
        }
        //        $barcode = str_replace(' ', '-', $request->name_en);
        $branch->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            //            'name_barcode' => $barcode,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('branches.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = AZBranch::findOrFail($id);
        $branch->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->to(url()->previous());
    }

    public function renewSubscriptionBank(Request $request, $id)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $subscription = Subscription::findOrFail($id);
        $this->validate($request, [
            'bank_id' => 'required|exists:banks,id',
            'transfer_photo' => 'required|mimes:jpg,jpeg,png,gif,tif,psd,pmp,webp|max:5000',
        ]);
        // update user subscription
        $subscription->update([
            'bank_id' => $request->bank_id,
            'transfer_photo' => UploadImage($request->file('transfer_photo'), 'photo', '/uploads/transfers'),
            'add_by_admin' => auth('admin')->check() ? auth('admin')->Id() : null,
            'add_by_restaurant' => auth('restaurant')->check() ? auth('restaurant')->Id() : null,
            'transfer_upload_date' => date('Y-m-d H:i:s'),
        ]);
        $isNew = true;
        if (History::where('branch_id', $subscription->branch_id)->where('restaurant_id', $subscription->restaurant->id)->count() > 0) $isNew = false;

        flash(trans('messages.bankTransferDone'))->success();
        return redirect()->route('branches.index');
    }

    public function barcode($id)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $model = AZBranch::findOrFail($id);
        if ($model->main == 'true') {
            $model = Auth::guard('restaurant')->user();
            if ($model->type == 'employee') :
                if (check_restaurant_permission($model->id, 2) == false) :
                    abort(404);
                endif;
                $model = Restaurant::find($model->restaurant_id);
            endif;
            return view('restaurant.user.barcode', compact('model'));
        } else {
            return view('restaurant.branches.barcode', compact('model'));
        }
    }
    public function showBranchCart($id, $state)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = Branch::findOrFail($id);
        $branch->update([
            'cart' => $state,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

    public function stopBranchMenu($id, $state)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = Branch::findOrFail($id);
        $branch->update([
            'stop_menu' => $state,
        ]);
        if ($branch->main == 'true') {
            $branch->restaurant->update([
                'stop_menu' => $state,
            ]);
        }
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

    public function copy_menu()
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $restaurant = Auth::guard('restaurant')->user();
        if ($restaurant->type == 'employee') :
            if (check_restaurant_permission($restaurant->id, 2) == false) :
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $branches = Branch::whereRestaurantId($restaurant->id)
            ->get();
        return view('restaurant.branches.copy_menu', compact('branches'));
    }

    public function copy_menu_post(Request $request)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $this->validate($request, [
            "branch_id_from" => "required",
            "branch_id_to" => "required",
        ]);
        /**
         *  1 - get the from branch menu categories
         */
        $branch_from = Branch::findOrFail($request->branch_id_from);
        $branch_to = Branch::findOrFail($request->branch_id_to);
        $menu_categories = MenuCategory::whereBranchId($branch_from->id)
            ->whereActive('true')
            ->get();
        if ($menu_categories->count() > 0) {
            foreach ($menu_categories as $menu_category) {
                // create the menu category to other branch
                if (!empty($menu_category->photo) and  Storage::disk('public_storage')->exists($menu_category->image_path)) :
                    $imageName = copyImage($menu_category->image_path, 'te', 'uploads/menu_categories');

                else :
                    $imageName = $menu_category->photo;
                endif;
                $to_category = MenuCategory::create([
                    'restaurant_id' => $menu_category->restaurant_id,
                    'branch_id' => $branch_to->id,
                    'name_ar' => $menu_category->name_ar,
                    'name_en' => $menu_category->name_en,
                    'photo' => $imageName,
                    'foodics_image' => $menu_category->foodics_image,
                    'foodics_id' => $menu_category->foodics_id,
                    'active' => $menu_category->active,
                    'arrange' => $menu_category->arrange,
                    'start_at' => $menu_category->start_at,
                    'end_at' => $menu_category->end_at,
                    'time' => $menu_category->time,
                    'description_ar' => $menu_category->description_ar,
                    'description_en' => $menu_category->description_en,
                ]);
                // check if the category has days
                $category_days = MenuCategoryDay::where('menu_category_id', $menu_category->id)->get();
                if ($category_days->count() > 0) {
                    foreach ($category_days as $category_day) {
                        MenuCategoryDay::create([
                            'menu_category_id' => $to_category->id,
                            'day_id' => $category_day->day_id,
                        ]);
                    }
                }
                // check if category has subcategories
                $sub_categories = RestaurantSubCategory::where('menu_category_id', $menu_category->id)->get();
                if ($sub_categories->count() > 0) {
                    foreach ($sub_categories as $sub_category) {
                        if (!empty($sub_category->image) and  Storage::disk('public_storage')->exists($sub_category->image_path)) :
                            $imageName = copyImage($sub_category->image_path, 'te', 'uploads/sub_menu_categories');

                        else :
                            $imageName = $sub_category->image;
                        endif;
                        $copied_sub_category = RestaurantSubCategory::create([
                            'menu_category_id' => $to_category->id,
                            'name_ar' => $sub_category->name_ar,
                            'name_en' => $sub_category->name_en,
                            'image' => $imageName
                        ]);
                    }
                }
                // check category products
                $products = Product::where('menu_category_id', $menu_category->id)->get();
                if ($products->count() > 0) {
                    foreach ($products as $product) {
                        // check sub_category
                        if ($product->sub_category_id != null) {
                            $sub_cat = RestaurantSubCategory::where('menu_category_id', $to_category->id)
                                ->where('name_ar', $product->sub_category->name_ar)
                                ->where('name_en', $product->sub_category->name_en)
                                ->first();
                            $sub_cat = $sub_cat == null ? null : $sub_cat->id;
                        } else {
                            $sub_cat = null;
                        }

                        if (!empty($product->photo) and  Storage::disk('public_storage')->exists($product->image_path)) :
                            $imageName = copyImage($product->image_path, 'te', 'uploads/products');

                        else :
                            $imageName = $product->photo;
                        endif;
                        $copied_product = Product::create([
                            'restaurant_id' => $product->restaurant_id,
                            'branch_id' => $branch_to->id,
                            'menu_category_id' => $to_category->id,
                            'name_ar' => $product->name_ar,
                            'name_en' => $product->name_en,
                            'description_ar' => $product->description_ar,
                            'description_en' => $product->description_en,
                            'price' => $product->price,
                            'price_before_discount' => $product->price_before_discount,
                            'calories' => $product->calories,
                            'arrange' => $product->arrange,
                            'photo' => $imageName,
                            'video_type' => $product->video_type,
                            'video_id' => $product->video_id,
                            'active' => $product->active,
                            'poster_id' => $product->poster_id,
                            'sub_category_id' => $sub_cat,
                            'start_at' => $product->start_at,
                            'end_at' => $product->end_at,
                            'time' => $product->time,
                            'foodics_image' => $product->foodics_image,
                            'foodics_id' => $product->foodics_id,
                        ]);
                        // copy product modifier
                        $product_modifiers = ProductModifier::whereProductId($product->id)->get();
                        if ($product_modifiers->count() > 0) {
                            foreach ($product_modifiers as $product_modifier) {
                                ProductModifier::create([
                                    'product_id' => $copied_product->id,
                                    'modifier_id' => $product_modifier->modifier_id,
                                ]);
                            }
                        }
                        // copy Product Options
                        $product_options = ProductOption::whereProductId($product->id)->get();
                        if ($product_options->count() > 0) {
                            foreach ($product_options as $product_option) {
                                ProductOption::create([
                                    'option_id' => $product_option->option_id,
                                    'product_id' => $copied_product->id,
                                    'modifier_id' => $product_option->modifier_id,
                                    'min' => $product_option->min,
                                    'max' => $product_option->max,
                                ]);
                            }
                        }
                        // copy product sensitivities
                        $product_sensitivities = ProductSensitivity::whereProductId($product->id)->get();
                        if ($product_sensitivities->count() > 0) {
                            foreach ($product_sensitivities as $product_sensitivity) {
                                ProductSensitivity::create([
                                    'product_id' => $copied_product->id,
                                    'sensitivity_id' => $product_sensitivity->sensitivity_id,
                                ]);
                            }
                        }
                        // copy product days
                        $product_days = ProductDay::whereProductId($product->id)->get();
                        if ($product_days->count() > 0) {
                            foreach ($product_days as $product_day) {
                                ProductDay::create([
                                    'product_id' => $copied_product->id,
                                    'day_id' => $product_day->day_id,
                                ]);
                            }
                        }
                        // copy product sizes
                        $product_sizes = ProductSize::whereProductId($product->id)->get();
                        if ($product_sizes->count() > 0) {
                            foreach ($product_sizes as $product_size) {
                                ProductSize::create([
                                    'name_ar' => $product_size->name_ar,
                                    'name_en' => $product_size->name_en,
                                    'price' => $product_size->price,
                                    'calories' => $product_size->calories,
                                    'product_id' => $copied_product->id,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        flash(trans('messages.branch_menu_copied'))->success();
        return redirect()->route('branches.index');
    }

    public function discounts($id)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = Branch::findOrFail($id);
        $discounts = FoodicsDiscount::whereBranchId($id)->get();
        return view('restaurant.settings.discounts', compact('discounts', 'branch'));
    }

    public function print_invoice($id)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = Branch::findOrFail($id);
        return view('restaurant.branches.invoice', compact('branch'));
    }


    public function printMenu(Request $request,  $id)
    {
        if (!auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        ini_set("pcre.backtrack_limit", "5000000000000");
        $restaurant = auth('restaurant')->user();
        $branch = $restaurant->branches()->findOrFail($id);
        $menuCategories = MenuCategory::where('active', 'true')->where('branch_id', $branch->id)->with(['products' => function ($query) {
            $query->where('active', 'true')->orderBy('arrange')->with('sizes');
        }])->orderBy('arrange')->get();
        $images = [];
        foreach ($menuCategories as $c) :
            foreach ($c->products as $p) :
                $images['m-' . $p->id] = null;

                if ((!empty($p->photo) and Storage::disk('public_storage')->exists($p->image_path))) :
                    $type = pathinfo($p->image_path, PATHINFO_EXTENSION);
                    $images['m-' . $p->id] = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($p->image_path));
                endif;
            endforeach;
        endforeach;
        $restaurantImage = null;
        if ((!empty($restaurant->logo) and Storage::disk('public_storage')->exists($restaurant->image_path))) :
            $type = pathinfo($restaurant->image_path, PATHINFO_EXTENSION);
            $restaurantImage = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($restaurant->image_path));
        endif;

        $limit = 10;
        $list = [];
        foreach ($menuCategories as $category) :
            $list[] = [
                'type' => 'category',
                'name' => $category->name,
            ];
            foreach ($category->products as $product) :
                if ($product->sizes->count() > 0) :
                    foreach ($product->sizes as $size) :
                        $list[] = [
                            'type' => 'product',
                            'name' => $product->name,
                            'size' => $size->name,
                            'price' => $size->price,
                            'calories' => $product->calories,
                        ];
                    endforeach;
                else :
                    $list[] = [
                        'type' => 'product',
                        'name' => $product->name,
                        'size' => '',
                        'price' => $product->price,
                        'calories' => $product->calories,
                    ];
                endif;
            endforeach;
        endforeach;
        $data = [];
        $level1Count = 0;
        $level2Count = 0;
        foreach ($list as $key => $value) :
            $data[$level1Count][$level2Count][] = $value;
            if (count($data[$level1Count][$level2Count]) >= $limit) {
                if ($level2Count == 1) {
                    $level2Count = 0;
                    $level1Count++;
                } else
                    $level2Count += 1;
            }
        endforeach;

        $data = collect($data);
        $list = collect($list);
        //    return view('restaurant.branches.print_menu', compact('menuCategories' , 'branch' , 'restaurant' , 'images' , 'restaurantImage' , 'list' , 'data'));
        $pdf = PDF::loadView('restaurant.branches.print_menu', compact('menuCategories', 'branch', 'restaurant', 'images', 'restaurantImage', 'list', 'data'),);
        $fileName = trans('dashboard.menu') . ' ' . $branch->name;
        return $pdf->stream($fileName . '.pdf');
        // $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        // $fontDirs = $defaultConfig['fontDir'];

        // $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        // $fontData = $defaultFontConfig['fontdata'];

        // $mpdf = new \Mpdf\Mpdf([
        //     'fontDir' => array_merge($fontDirs, [
        //         __DIR__ . '/fonts',
        //     ]),
        //     'fontdata' => $fontData + [ // lowercase letters only in font key
        //         'frutiger' => [
        //             'R' => 'Frutiger-Normal.ttf',
        //             'I' => 'FrutigerObl-Normal.ttf',
        //         ],
        //         'useOTL' => 0xFF,
        //         'useKashida' => 75,
        //     ],
        //     'default_font' => 'frutiger'
        // ]);



    }
}
