<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>
        @lang('messages.contact_us')
    </title>
    <!-- //font -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@200;300;400&display=swap"
        rel="stylesheet"
    />
    <link type="text/css" rel="icon" href="{{asset('/uploads/restaurants/logo/' . $restaurant->logo)}}"  type="image/x-icon">

    <!-- //bootstrap -->
    <link rel="stylesheet" href="{{asset('site/css/bootstrap-grid.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/css/bootstrap.css')}}"/>
    <!-- fontawsome -->
    <link rel="stylesheet" href="{{asset('site/css/all.min.css')}}"/>
    <!-- style sheet -->
    <link rel="stylesheet" href="{{asset('site/css/global.css')}}"/>
    <style>
        .container_form {
            border-radius: 8px !important;
        }
    </style>
</head>
<body>
<div class="mycontainer contact_us">
    <header
        class="d-flex align-items-center justify-content-between bg-white p-3"
    >
        <a href="{{route('homeBranchIndex' , [$restaurant->name_barcode , $branch->name_en])}}" style='color: black'>
            <i class="fa-solid fa-angle-right"></i>
        </a>
        <h5>
            @lang('messages.contact_us')
        </h5>
        <i class="fa-regular fa-bell"></i>
    </header>
    @include('flash::message')
    <main>
        <form method="post" action="{{route('restaurantVisitorContactUsSend' , $restaurant->name_barcode)}}">
            @csrf
            <div class="bg-white m-3 py-4 px-3 container_form">
                <div class="name">
                    <label for="name">@lang('messages.name') : </label>
                    <div class="container_input">
                        <i class="fa fa-user"></i>
                        <input type="text" id="name" name="name" placeholder="@lang('messages.name')"/>
                    </div>
                </div>
                <div class="email">
                    <label for="name">@lang('messages.email') :</label>
                    <div class="container_input">
                        <i class="fa-solid fa-envelope"></i>
                        <input
                            name="email"
                            type="email"
                            id="email"
                            placeholder="@lang('messages.email')"
                        />
                    </div>
                </div>
                <div class="message">
                    <label for="message">@lang('messages.message') :</label>
                    <div class="container_input">
                        <textarea
                            id="message"
                            name="message"
                            placeholder="@lang('messages.message')"
                            rows="5"></textarea>
                    </div>
                </div>
            </div>
            <input type="submit" value="@lang('messages.send')"/>
        </form>
    </main>
    @include('website.layout.footer')
</div>
</body>
</html>
