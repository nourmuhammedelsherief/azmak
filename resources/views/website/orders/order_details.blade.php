<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@lang('messages.order_details')</title>
    <link type="text/css" rel="icon" href="{{asset('/uploads/restaurants/logo/' . $order->restaurant->logo)}}"
          type="image/x-icon">

    <!-- //font -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@200;300;400&display=swap"
        rel="stylesheet"
    />
    <!-- //bootstrap -->
    <!-- <link rel="stylesheet" href="css/bootstrap.css" /> -->
    <link rel="stylesheet" href="{{asset('site/css/bootstrap-grid.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/css/bootstrap.css')}}"/>
    <!-- fontawsome -->
    <link rel="stylesheet" href="{{asset('site/css/all.min.css')}}"/>
    <!-- style sheet -->
    <link rel="stylesheet" href="{{asset('site/css/global.css')}}"/>
    <style>
        main {
            min-height: 100vh !important;
        }

        .image_thanks {
            width: 250px;
            margin: auto;
        }

        .wImage {
            width: 100%;
        }

        @media (max-width: 768px) {
            .image_thanks {
                width: 200px;
                margin: auto;
            }
        }

        #barcode-svg {
            width: 245px;
        }
    </style>

</head>
<body>
<div class="mycontainer bg-white">
    <main class="bg-white">
        <div
            class="end_thank bg-white p-5 d-flex flex-column align-items-center"
            id="end_thank"
        >

            <div id="barcode-svg">
                <h6 class="text-center">
                    @lang('messages.order_status') :
                    @switch($order->status)
                        @case('active')
                        <span class="btn btn-success"> @lang('messages.active') </span>
                        @break
                        @case('completed')
                        <span class="btn btn-secondary"> @lang('messages.completed') </span>
                        @break
                        @case('canceled')
                        <span class="btn btn-danger"> @lang('messages.canceled') </span>
                        @break
                        @case('finished')
                        <span class="btn btn-danger"> @lang('messages.finished') </span>
                        @break
                        @default
                        <span class="btn btn-danger"> @lang('messages.new') </span>
                    @endswitch
                </h6>
                <hr>
                <h6 class="text-center">
                    @lang('messages.restaurant') : {{$order->restaurant->name_ar}}
                    <hr>
                    @lang('messages.branch') : {{$order->branch->name_ar}}
                    ({{$order->branch->city->name_ar}})
                    @php $location = 'https://www.google.com/maps?q=' . $order->branch->latitude . ',' . $order->branch->longitude; @endphp
                    <a href="{{$location}}" class="btn btn-secondary" target="_blank"> @lang('messages.location')</a>
                    <hr>
                </h6>
                <h6 class="text-center">
                    @lang('messages.order_no') : <span style="color: red">{{$order->order_id}}</span>
                </h6>
                <h6 class="text-center">
                    @lang('messages.order_date') :
                    {{\Carbon\Carbon::parse($order->created_at)->translatedFormat('F d Y') }}
                    {{--                    /--}}
                    {{--                    {{\Carbon\Carbon::parse($order->created_at)->isoFormat('h:mm a')}}--}}
                </h6>
                <hr>

                <div class=" text-center">
                    <h5 class="text-center">@lang('messages.order_items')</h5>
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
                                                <div class="total bg-white px-4 py-2" id="total_followPayment">
                                                    <div class="d-flex justify-content-between w-100">
                                                        <p style="text-align: left">
                                                            {{app()->getLocale() == 'ar' ?  $item->product->name_ar : $item->product->name_en}}
                                                            {{$item->product_count}} x
                                                        </p>
                                                        <h6 class="text-center btn btn-info">
                                                            <div class="text-center">
                                                                <span>{{$item->price}}</span>
                                                                <small>{{app()->getLocale() == 'ar' ? $item->product->restaurant->country->currency_ar : $item->product->restaurant->country->currency_en}}</small>
                                                            </div>
                                                        </h6>

                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                            @if($item->options->count() > 0)
                                                {{--item options--}}
                                                <div>
                                                    <h6>@lang('messages.options')</h6>
                                                    <br>
                                                    <div class="details">
                                                        @foreach($item->options as $option)
                                                            <div class="total bg-white px-4 py-2"
                                                                 id="total_followPayment">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between w-100">
                                                                    <h6>
                                                                        {{app()->getLocale() == 'ar' ? $option->option->name_ar : $option->option->name_en }}
                                                                        {{$option->option_count}} x
                                                                    </h6>
                                                                    <h6 class="text-center btn btn-info">
                                                                        <div class="text-center">
                                                                            <span>{{$option->option->price * $option->option_count}}</span>
                                                                            <small>{{app()->getLocale() == 'ar' ? $item->product->restaurant->country->currency_ar : $item->product->restaurant->country->currency_en}}</small>
                                                                        </div>
                                                                    </h6>

                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <hr>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="total bg-white px-4 py-2" id="total_followPayment">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <p>@lang('messages.total_price')</p>
                            <h6 class="text-center btn btn-warning">
                                <div class="text-center">
                                    <span> {{$order->total_price}}</span>
                                    {{app()->getLocale() == 'ar' ? $order->restaurant->country->currency_ar : $order->restaurant->country->currency_en}}
                                </div>
                            </h6>

                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <a href="#" id="printPage" class="printPage btn btn-success">@lang('messages.printPage')</a>
            </div>
        </div>
    </main>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('dist/js/html2canvas.min.js')}}"></script>

<script>
    $(document).ready(function () {

        document.getElementById("printPage").addEventListener("click", function () {
            html2canvas(document.getElementById("barcode-svg")).then(function (canvas) {
                var anchorTag = document.createElement("a");
                document.body.appendChild(anchorTag);
                // document.getElementById("previewImg").appendChild(canvas);
                anchorTag.download = "{{$order->order_id}}-barcode.jpg";
                anchorTag.href = canvas.toDataURL();
                anchorTag.target = '_blank';
                anchorTag.click();
            });
        });
    });
</script>
</body>
</html>
