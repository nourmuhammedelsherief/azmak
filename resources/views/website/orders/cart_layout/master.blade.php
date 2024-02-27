<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@lang('messages.cart')</title>
    <!-- //font -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@200;300;400&display=swap"
        rel="stylesheet"
    />
    <!-- //bootstrap -->
    <link rel="stylesheet" href="{{asset('site/css/bootstrap-grid.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/css/bootstrap.css')}}"/>
    <!-- fontawsome -->
    <link rel="stylesheet" href="{{asset('site/css/all.min.css')}}"/>
    <!-- style sheet -->
    <link rel="stylesheet" href="{{asset('site/css/header.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/css/global.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/css/home.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/css/cart.css')}}"/>
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

</head>
<body>
<div class="mycontainer">
    @include('website.layout.header')
    <br>
    <!-- <img src="./image//cartempty.jpg" -->
    @yield('content')

</div>

{!! \Brian2694\Toastr\Facades\Toastr::message() !!}

<script src="{{asset('site/js/GetProductToCart.js')}}"></script>
<script src="{{asset('site/js/bootstrap.bundle.js')}}"></script>
</body>
</html>
