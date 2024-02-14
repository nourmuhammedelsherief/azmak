@extends('website.orders.cart_layout.master')
@section('content')
    <main>
        <div class="teeeeest my-1 mx-2">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{route('homeBranchIndex' , [$restaurant->name_barcode , $branch->name_en])}}"
                       class="nav-link"
                       role="tab"
                       aria-controls="pills-profile"
                       aria-selected="false">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </li>
                @if($order)
                    <li class="nav-item" role="presentation">
                        <a href="{{route('emptyCart' , $order->id)}}"
                           class="nav-link"
                           role="tab"
                           aria-controls="pills-profile"
                           aria-selected="false"
                           style="color: red"
                        >
                            <i class="fa fa-trash"></i>
                            @lang('messages.deleteCart')
                        </a>
                    </li>
                @endif
            </ul>
            @if($order)
                <div class="tab-content" id="pills-tabContent">
                    <div
                        class="tab-pane fade show active"
                        id="pills-home"
                        role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <!-- <div id="cartItemsContainer" class="p-5 m-auto">
                      </div> -->
                        <div calss="cartItemsContainer" class="m-auto">
                            <div class="bg-white main_wrap">
                                @if($order->items->count() > 0)
                                    @foreach($order->items as $item)
                                        <div class="cart-item">
                                            <div class="image">
                                                <img src="{{asset('/uploads/products/' . $item->product->photo)}}"
                                                     alt=""/>
                                            </div>
                                            <div class="details">
                                                <h6>
                                                    {{app()->getLocale() == 'ar' ?  $item->product->name_ar : $item->product->name_en}}
                                                    {{$item->product_count}} x
                                                </h6>
                                                <p class="my-1">
                                                    {{app()->getLocale() == 'ar' ? strip_tags(str_replace('&nbsp;', ' ', $item->product->description_ar)) : strip_tags(str_replace('&nbsp;', ' ', $item->product->description_en))}}
                                                </p>
                                                <div class="action d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <span>{{$item->price}}</span>
                                                        <small>{{app()->getLocale() == 'ar' ? $item->product->restaurant->country->currency_ar : $item->product->restaurant->country->currency_en}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($item->size)
                                                <div class="details">
                                                    <h6>@lang('messages.sizes')</h6>
                                                    <div
                                                        class="action d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <span>{{$item->size->price}}</span>
                                                            <small>{{app()->getLocale() == 'ar' ? $item->product->restaurant->country->currency_ar : $item->product->restaurant->country->currency_en}}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="details">
                                                <div class="action d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <a href="{{route('deleteCartItem' , $item->id)}}" style="color: red">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($item->options->count() > 0)
                                            {{--item options--}}
                                            <div>
                                                <h6>@lang('messages.options')</h6>
                                                <div class="details">
                                                    @foreach($item->options as $option)
                                                        <div class="row">
                                                            <h6>
                                                                {{app()->getLocale() == 'ar' ? $option->option->name_ar : $option->option->name_en }}
                                                                {{$option->option_count}} x
                                                            </h6>
                                                            <div
                                                                class="action d-flex align-items-center justify-content-between"
                                                                style="padding-right: 400px;">
                                                                <div>
                                                                    <span>{{$option->option->price * $option->option_count}}</span>
                                                                    <small>{{app()->getLocale() == 'ar' ? $item->product->restaurant->country->currency_ar : $item->product->restaurant->country->currency_en}}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        <hr>
                                    @endforeach
                                @else
                                    @lang('messages.emptyCart')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="total bg-white px-4 py-2" id="total_followPayment">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="total_price">
                            <p>@lang('messages.total_price')</p>
                            <p>
                                <span> {{$order->total_price}}</span>
                                {{app()->getLocale() == 'ar' ? $order->restaurant->country->currency_ar : $order->restaurant->country->currency_en}}
                            </p>
                        </div>
                        <div class="payment">
                            <a href="{{route('AZOrderInfo' , $order->id)}}">
                                @lang('messages.next')
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <br>
                <h4 class="text-center">@lang('messages.emptyCart')</h4>
            @endif
        </div>
    </main>
@endsection
