<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\AzSellerCode;
use App\Models\Setting;
use App\Models\AzSubscription;
use App\Models\AzmakSetting;
use App\Models\AzHistory;


class AzmakSubscriptionController extends Controller
{
    public function show_subscription($id)
    {
        $restaurant = Restaurant::find($id);
        // get azmak setting subscription type
        $settings = AzmakSetting::first();
        if ($settings->subscription_type == 'free')
        {
            // 1 - free subscription
            AzSubscription::updateOrCreate(
                ['restaurant_id' => $restaurant->id],
                [
                    'status' => 'free',
                    'end_at' => Carbon::now()->addYears(10),
                    'subscription_type' => 'new',
                ]);
            flash(trans('messages.AzmakFreeSubscriptionDoneSuccessfully'))->success();
            return redirect()->back();
        }elseif ($settings->subscription_type == 'paid')
        {
            // 2 - Online Payment
            return view('restaurant.payments.payment_method');
        }
    }

    public function show_payment_methods(Request $request, $id)
    {
        $this->validate($request, [
            'payment_type' => 'required',
            'seller_code' => 'nullable|exists:az_seller_codes,seller_name',
        ]);
        $restaurant = Restaurant::findOrFail($id);
        $setting = AzmakSetting::first();
        $name = $restaurant->name_en;
        $token = $setting->online_token;
        $amount = $setting->subscription_amount;
        $seller_code = null;
        $tax = $setting->tax;
        $discount = 0;
        if ($request->seller_code != null) {
            $seller_code = AzSellerCode::where('seller_name', $request->seller_code)
                ->whereActive('true')
                ->where('country_id', $restaurant->country_id)
                ->first();
            if ($seller_code) {
                if ($seller_code->start_at <= Carbon::now() and $seller_code->end_at >= Carbon::now()) {
                    $discount_percentage = $seller_code->code_percentage;
                    $discount = ($amount * $discount_percentage) / 100;
                    $price_after_percentage = $amount - $discount;
                    $commission = $amount * ($seller_code->percentage - $seller_code->code_percentage) / 100;
                    $seller_code->update([
                        'commission' => $commission + $seller_code->commission,
                    ]);
                    $tax_value = $price_after_percentage * $tax / 100;
                    $amount = $price_after_percentage + $tax_value;
                } else {
                    $tax_value = $amount * $tax / 100;
                    $amount += $tax_value;
                }
            } else {
                $tax_value = $amount * $tax / 100;
                $amount += $tax_value;
            }
        } else {
            $tax_value = $amount * $tax / 100;
            $amount += $tax_value;
        }
        $data = array(
            'PaymentMethodId' => $request->payment_type,
            'CustomerName' => $name,
            'DisplayCurrencyIso' => 'SAR',
            'MobileCountryCode' => $restaurant->country->code,
            'CustomerMobile' => $restaurant->phone_number,
            'CustomerEmail' => $restaurant->email,
            'InvoiceValue' => $amount,
            'CallBackUrl' => route('AZSubscriptionStatusF'),
            'ErrorUrl' => route('restaurant.home'),
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
                'ItemName' => $restaurant->name_en,
                'Quantity' => 1,
                'UnitPrice' => $amount,
            )],
        );
        $data = json_encode($data);
        $fatooraRes = MyFatoorah($token, $data);
        $result = json_decode($fatooraRes);
        if ($result != null and $result->IsSuccess === true) {
            AzSubscription::updateOrCreate(
                ['restaurant_id' => $restaurant->id],
                [
                    'invoice_id' => $result->Data->InvoiceId,
                    'payment_type' => 'online',
                    'payment' => 'false',
                    'price' => $amount,
                    'seller_code_id' => $seller_code?->id,
                    'tax_value' => $tax_value,
                    'discount_value' => $discount,
                ]);
            return redirect()->to($result->Data->PaymentURL);
        } else {
            flash(trans('messages.paymentError'))->error();
            return back();
        }
    }

    public function subscription_status(Request $request)
    {
        $setting = AzmakSetting::first();
        $token = $setting->online_token;
        $PaymentId = $request->query('paymentId');
        $resData = MyFatoorahStatus($token, $PaymentId);
        $result = json_decode($resData);
        if ($result->IsSuccess === true and $result->Data->InvoiceStatus === "Paid") {
            $InvoiceId = $result->Data->InvoiceId;
            $subscription = AzSubscription::whereInvoiceId($InvoiceId)->first();
            // store operation at history
            AzHistory::create([
                'restaurant_id'   => $subscription->restaurant_id,
                'bank_id'         => $subscription->bank_id,
                'seller_code_id'  => $subscription->seller_code_id,
                'paid_amount'     => $subscription->price,
                'discount'        => $subscription->discount_value,
                'tax'             => $subscription->tax_value,
                'transfer_photo'  => $subscription->transfer_photo,
                'invoice_id'      => $subscription->invoice_id,
                'payment_type'    => 'online',
                'subscription_type' => $subscription->status == 'finished' ? 'renew' : 'new',
                'details'         => $subscription->status == 'finished' ? trans('messages.renew_subscription') : trans('messages.new_subscription'),
            ]);
            $subscription->update([
                'status' => 'active',
                'payment' => 'true',
                'end_at' => Carbon::now()->addYear(),
                'subscription_type' => $subscription->status == 'finished' ? 'renew' : 'new',
            ]);
            flash(trans('messages.paymentDoneSuccessfully'))->success();
            return redirect()->route('restaurant.home');
        } else {
            flash(trans('messages.paymentError'))->error();
            return back();
        }
    }
}
