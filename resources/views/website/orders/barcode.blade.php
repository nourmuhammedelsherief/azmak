<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@lang('messages.order_details')</title>
    <link type="text/css" rel="icon" href="{{asset('/uploads/restaurants/logo/' . $order->restaurant->az_logo)}}" type="image/x-icon">

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
            <div class="image_thanks">
                <img
                    src="{{asset('site/image/thankyou.jpg')}}"
                    class="d-block m-auto wImage"
                    alt="thank"
                />
            </div>
            <div id="barcode-svg">
                <h6 class="text-center">
                    @lang('messages.order_no') : {{$order->order_id}}
                    <hr>
                    {{\Carbon\Carbon::parse($order->created_at)->translatedFormat('F d Y') }}
                    /
                    {{\Carbon\Carbon::parse($order->created_at)->isoFormat('h:mm a')}}
                </h6>
                <div class=" text-center">
                    {!! QrCode::size(200)->generate(route('AZOrderDetails' , $order->id)) !!}
                    <div class="description" style="margin-top:10px;">
                        <img width="20" height="20"
                             src="{{asset('/uploads/restaurants/logo/' . $order->restaurant->logo)}}">
                        <p class="footer-copyright pb-3 mb-1 pt-0 mt-0 font-13 font-600"
                           style="    text-align: center;font-size:12px;display:inline; margin-right:5px;">
                            {{trans('messages.made_love')}}
                        </p>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-sm-4">
                    <a class="btn btn-danger"
                       href="{{route('homeBranchIndex' , [$order->restaurant->name_barcode , $order->branch->name_en])}}">
                        @lang('messages.close')
                    </a>
                </div>
                <br>
                <div class="col-sm-8">
                    <a href="#" id="printPage" class="printPage btn btn-success">@lang('messages.downloadQr')</a>
                </div>
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
