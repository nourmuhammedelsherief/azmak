
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> @lang('messages.terms_conditions') </title>
    <!-- //font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@200;300;400&display=swap"
        rel="stylesheet"
    />
    <!-- //bootstrap -->
    <link rel="stylesheet" href="{{asset('site/css/bootstrap-grid.min.css')}}" />
    <link rel="stylesheet" href="{{asset('site/css/bootstrap.css')}}" />
    <!-- fontawsome -->
    <link rel="stylesheet" href="{{asset('site/css/all.min.css')}}" />
    <!-- style sheet -->
    <link rel="stylesheet" href="{{asset('site/css/global.css')}}" />
    <style>
        .about_us {
            border-radius: 8px;
        }
        p {
            font-size: 14px;
            font-weight: 400;
        }
    </style>

</head>
<body>
<div class="mycontainer">
    <header
        class="d-flex align-items-center justify-content-between bg-white p-3"
    >
        <a href="{{url()->previous()}}" style='color: black'>
            <i class="fa-solid fa-angle-right"></i>
        </a>
        <h5>@lang('messages.terms_conditions')</h5>
        <i class="fa-regular fa-bell"></i>
    </header>
    <div
        class="about_us d-flex flex-column align-items-center p-3 justify-content-center bg-white my-3"
    >
        <p>
            @if($terms)
                @if(app()->getLocale() == 'ar')
                    {!! $terms->terms_ar !!}
                @else
                    {!! $terms->terms_en !!}
                @endif
            @endif
        </p>

    </div>
    @include('website.layout.footer')
</div>
</body>
</html>
