<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Restaurant\Azmak\AZUser;
use App\Models\Restaurant\Azmak\AZBranch;
use App\Models\Restaurant\Azmak\AZProduct;
use App\Models\Restaurant\Azmak\AZProductSize;
use App\Models\Restaurant\Azmak\AZOrder;
use App\Models\Restaurant\Azmak\AZOption;
use App\Models\Restaurant\Azmak\AZOrderItem;
use App\Models\Restaurant\Azmak\AZOrderItemOption;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $product = AZProduct::find($request->product_id);
        $restaurant = $product->restaurant;
        $branch = $product->branch;

        $check_required_options = \App\Models\Restaurant\Azmak\AZProductOption::whereProductId($product->id)
            ->where('min', '>=', 1)
            ->count();
        if (($request->options == null and $check_required_options > 0) or ($request->options != null and $check_required_options > count($request->options))) {
            Toastr::warning(trans('messages.optionsRequired'), trans('messages.cart'), ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
        if (!auth('web')->check()) {
            session()->put('current_order', $request->all());
            return redirect(route('AZUserLogin', [$restaurant->name_barcode, $branch->name_en]));
        } else {
            session()->forget('current_order');
        }
        $user = auth('web')->user();
        // check order
        $check_order = AZOrder::whereRestaurantId($restaurant->id)
            ->whereBranchId($branch->id)
            ->whereUserId($user->id)
            ->whereStatus('new')
            ->first();
        $product_count = $request->product_count;
        $order_price = $product_count * ($request->size_id ? AZProductSize::find($request->size_id)->price : $product->price);
        if ($check_order) {
            $order = $check_order;
        } else {
            // create new order
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $order_id = $characters[rand(0, strlen($characters) - 1)] .'-'. mt_rand(1000000, 9999999);
            $order_code = $characters[rand(0, strlen($characters) - 1)] .'-'. mt_rand(1000000, 9999999);
            $order = AZOrder::create([
                'restaurant_id' => $restaurant->id,
                'branch_id' => $branch->id,
                'user_id' => $user->id,
                'order_id' => $order_id,
                'status' => 'new',
                'order_code' => $order_code,
            ]);
        }
        //create order items
        $item = AZOrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'size_id' => $request->size_id == null ? null : $request->size_id,
            'product_count' => $product_count,
            'price' => $order_price,
        ]);
        // create order item options
        if ($request->options != null) {
            foreach ($request->options as $option) {
                $option_count = 'option_count-' . $option;
                $item_option = AZOrderItemOption::create([
                    'item_id' => $item->id,
                    'option_id' => $option,
                    'option_count' => $request->$option_count,
                ]);
                $option_price = AZOption::find($option)->price * $item_option->option_count;
                $order_price += $option_price;
            }
        }
        $order_price += $order->order_price;
        $order->update([
            'order_price' => $order_price,
            'total_price' => $order_price,
        ]);
        Toastr::success(trans('messages.addedToCart'), trans('messages.cart'), ["positionClass" => "toast-top-right"]);
        return redirect()->route('homeBranchIndex', [$restaurant->name_barcode, $branch->name_en]);
    }

    public function cart_details($branch_id)
    {
        $user = auth('web')->user();
        $branch = AZBranch::find($branch_id);
        $restaurant = $branch->restaurant;
        $order = AZOrder::whereUserId($user->id)
            ->whereStatus('new')
            ->whereBranchId($branch_id)
            ->orderBy('id', 'desc')
            ->first();
        return view('website.orders.cart', compact('user', 'order', 'restaurant', 'branch'));
    }

    public function emptyCart($id)
    {
        $order = AZOrder::find($id);
        $order->delete();
        Toastr::success(trans('messages.cartDeletedSuccessfully'), trans('messages.cart'), ["positionClass" => "toast-top-right"]);
        return redirect()->route('homeBranchIndex', [$order->restaurant->name_barcode, $order->branch->name_en]);
    }

    public function deleteCartItem($id)
    {
        $item = AZOrderItem::find($id);
        $item->delete();
        if ($item->order->items->count() == 0):
            $item->order->delete();
        endif;
        Toastr::success(trans('messages.cartItemDeletedSuccessfully'), trans('messages.cart'), ["positionClass" => "toast-top-right"]);
        return redirect()->route('homeBranchIndex', [$item->order->restaurant->name_barcode, $item->order->branch->name_en]);
    }
    public function barcode($id)
    {
        $order = AZOrder::findOrFail($id);
        return view('website.orders.barcode' , compact('order'));
    }
    public function order_details($id){
        $order = AZOrder::findOrFail($id);
        return view('website.orders.order_details' , compact('order'));
    }
}
