<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
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
        return redirect()->route('AZOrderPayment' , $order->id);
    }
    public function payment($id)
    {
        $order = AZOrder::findOrFail($id);
        // check restaurant payment company
        if ($order->restaurant->a_z_orders_payment_type == 'tap')
        {
            // tap payment
            return redirect()->to(tap_payment($order->restaurant->a_z_tap_token, $order->total_price, $order->user->name, $order->user->email, $order->restaurant->country->code, $order->user->phone_number, route('AZOrderPaymentTapStatus' , $order->id), $order->order_id));
        }elseif ($order->restaurant->a_z_orders_payment_type == 'edfa')
        {
            // edfa payment
            $payment_url = edfa_payment($order->restaurant->a_z_edfa_merchant, $order->restaurant->a_z_edfa_password, $order->total_price,route('AZOrderPaymentEdfa_status' , $order->id), $order->order_id, $order->user->name, $order->user->email);
            return redirect()->to($payment_url);
        }elseif ($order->restaurant->a_z_orders_payment_type == 'myFatoourah')
        {
            // 1- my fatoourah payment
//        if ($request->online_type == 'visa') {
//            $charge = 2;
//        } elseif ($request->online_type == 'mada') {
//            $charge = 6;
//        } elseif ($request->online_type == 'apple_pay') {
//            $charge = 11;
//        } else {
//            $charge = 2;
//        }
            $name = $order->user->name;
            $token = $order->restaurant->a_z_myFatoourah_token;
//            $amount = number_format((float)$order->total_price, 2, '.', '');
            $data = array(
                'PaymentMethodId' => 2,
                'CustomerName' => $name,
                'DisplayCurrencyIso' => 'SAR',
                'MobileCountryCode' => $order->restaurant->country->code,
                'CustomerMobile' => $order->user->phone_number,
                'CustomerEmail' => $order->user->email,
                'InvoiceValue' => $order->total_price,
                'CallBackUrl' => route('AZOrderPaymentFatoourahStatus' , $order->id),
                'ErrorUrl' => route('AZUserCart' , $order->branch->id),
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
                    'ItemName' => $order->occasion,
                    'Quantity' => $order->items->count(),
                    'UnitPrice' => $order->total_price,
                )],
            );
            $data = json_encode($data);
            $fatooraRes = MyFatoorah($token, $data);
            $result = json_decode($fatooraRes);
            if ($result != null and $result->IsSuccess === true) {
                $order->update([
                    'invoice_id' => $result->Data->InvoiceId,
                ]);
                return redirect()->to($result->Data->PaymentURL);
            } else {
                Toastr::warning(trans('messages.paymentError'), trans('messages.cart'), ["positionClass" => "toast-top-right"]);
                return back();
            }
        }
    }
    public function check_order_fatoourah_status(Request $request , $id)
    {
        $order = AZOrder::find($id);
        $token = $order->restaurant->a_z_myFatoourah_token;
        $PaymentId = $request->query('paymentId');
        $resData = MyFatoorahStatus($token, $PaymentId);
        $result = json_decode($resData);
        if ($result->IsSuccess === true and $result->Data->InvoiceStatus === "Paid") {
            $order->update([
                'status'  => 'active',
            ]);
            // send order details to user whatsapp
            $content = trans('messages.welcome') . $order->person_name . ' ' . trans('messages.at') .' ' . trans('messages.az_orders') . '%0a %0a';
            $content.= $order->user->name . ' : ' . trans('messages.invitedYouToAZOrders'). '%0a %0a';
            $content.= trans('messages.order_details'). '%0a %0a';
            $content.= route('AZOrderBarcode' , $order->id). '%0a %0a';
            $content.= trans('messages.order_code') . ' ' . $order->order_code. '%0a %0a';

            $check = substr($order->person_phone, 0, 2) === '05';
            if ($check == true) {
                $phone = '+966' . ltrim($order->person_phone, '0');
            } else {
                $phone = '+2' . $order->person_phone;
            }
            $url = 'https://api.whatsapp.com/send?phone=' . $phone . '&text='.$content;
            return redirect()->to($url);
        } else {
            Toastr::warning(trans('messages.paymentError'), trans('messages.cart'), ["positionClass" => "toast-top-right"]);
            return back();
        }
    }
    public function edfa_status(Request $request , $id)
    {
        $order = AZOrder::find($id);
        $order->update([
            'status'  => 'active',
        ]);
        // send order details to user whatsapp
        $content = trans('messages.welcome') . $order->person_name . ' ' . trans('messages.at') .' ' . trans('messages.az_orders') . '%0a %0a';
        $content.= $order->user->name . ' : ' . trans('messages.invitedYouToAZOrders'). '%0a %0a';
        $content.= trans('messages.order_details'). '%0a %0a';
        $content.= route('AZOrderBarcode' , $order->id). '%0a %0a';
        $content.= trans('messages.order_code') . ' ' . $order->order_code. '%0a %0a';
        $check = substr($order->person_phone, 0, 2) === '05';
        if ($check == true) {
            $phone = '+966' . ltrim($order->person_phone, '0');
        } else {
            $phone = '+2' . $order->person_phone;
        }
        $url = 'https://api.whatsapp.com/send?phone=' . $phone . '&text='.$content;
        return redirect()->to($url);
//        Toastr::success(trans('messages.paymentSuccess'), trans('messages.cart'), ["positionClass" => "toast-top-right"]);
//        return redirect()->route('AZOrderBarcode' ,$order->id);
    }
    public function check_order_tap_status(Request $request , $id)
    {
        $order = AZOrder::find($id);
        $order->update([
            'status'  => 'active',
        ]);
        // send order details to user whatsapp
        $content = trans('messages.welcome') . $order->person_name . ' ' . trans('messages.at') .' ' . trans('messages.az_orders') . '%0a %0a';
        $content.= $order->user->name . ' : ' . trans('messages.invitedYouToAZOrders'). '%0a %0a';
        $content.= trans('messages.order_details'). '%0a %0a';
        $content.= route('AZOrderBarcode' , $order->id). '%0a %0a';
        $content.= trans('messages.order_code') . ' ' . $order->order_code. '%0a %0a';
        $check = substr($order->person_phone, 0, 2) === '05';
        if ($check == true) {
            $phone = '+966' . ltrim($order->person_phone, '0');
        } else {
            $phone = '+2' . $order->person_phone;
        }
        $url = 'https://api.whatsapp.com/send?phone=' . $phone . '&text='.$content;
        return redirect()->to($url);
//        Toastr::success(trans('messages.paymentSuccess'), trans('messages.cart'), ["positionClass" => "toast-top-right"]);
//        return redirect()->route('AZOrderBarcode' ,$order->id);
    }
}
// test backup mode

