<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@lang('messages.about_app')</title>
    <!-- //font -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@200;300;400&display=swap"
        rel="stylesheet"
    />
    <link type="text/css" rel="icon" href="{{asset('/uploads/restaurants/logo/' . $restaurant->az_logo)}}"  type="image/x-icon">

    <!-- //bootstrap -->
    <link rel="stylesheet" href="{{asset('site/css/bootstrap-grid.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/css/bootstrap.css')}}"/>
    <!-- fontawsome -->
    <link rel="stylesheet" href="{{asset('site/css/all.min.css')}}"/>
    <!-- style sheet -->
    <link rel="stylesheet" href="{{asset('site/css/global.css')}}"/>
    <style>
        .about_us img {
            margin-top: -50px;
        }

        .about_us p {
            margin-top: -50px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 400;
        }
    </style>
</head>
<body>
<div class="mycontainer">
    <header
        class="d-flex align-items-center justify-content-between bg-white p-3">
        <a href="{{route('homeBranchIndex' , [$restaurant->name_barcode , $branch->name_en])}}" style='color: black'>
            <i class="fa-solid fa-angle-right"></i>
        </a>
        <h5>@lang('messages.about_app')</h5>
        <i class="fa-regular fa-bell"></i>
    </header>
    <div
        class="about_us d-flex flex-column align-items-center justify-content-center">
        <br>
        <br>
        <br>
        <img src="{{asset('/uploads/restaurants/logo/' . $restaurant->logo)}}" width="80" height="80" alt="logo"/>
        <br>
        <br>
        <br>
        <p class="bg-white p-4">
            @if($about)
                {{app()->getLocale() == 'ar' ? strip_tags(str_replace('&nbsp;', ' ', $about->about_ar)) : strip_tags(str_replace('&nbsp;', ' ', $about->about_en))}}
            @endif
        </p>

    </div>
    @include('website.layout.footer')
</div>
</body>
</html>
