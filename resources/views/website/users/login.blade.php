<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@lang('messages.login')</title>
    <!-- //font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@200;300;400&display=swap"
        rel="stylesheet"
    />
    <!-- //bootstrap -->
    <!-- <link rel="stylesheet" href="css/bootstrap.css" /> -->
    <link rel="stylesheet" href="{{asset('site/css/bootstrap-grid.min.css')}}" />
    <link rel="stylesheet" href="{{asset('site/css/bootstrap.css')}}" />
    <!-- fontawsome -->
    <link rel="stylesheet" href="{{asset('site/css/all.min.css')}}" />
    <!-- style sheet -->
    <link rel="stylesheet" href="{{asset('site/css/global.css')}}" />
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <style>
        .join_us {
            border-radius: 10px;
        }
        .join_us img {
            margin-top: -50px;
        }
        .join_us p {
            font-weight: 300;
            font-size: 14px;
            margin-top: -50px;
        }
        ::placeholder {
            font-size: 10px !important;
        }
        .container_form {
            border-radius: 8px !important;
        }
    </style>

</head>
<body>

<div class="mycontainer">
    <header
        class="d-flex align-items-center justify-content-between bg-white p-3"
    >
        <a href="{{route('homeBranchIndex' , [$restaurant->name_barcode , $branch->name_en])}}" style='color: black'>
            <i class="fa-solid fa-angle-right"></i>
        </a>
        <h5>@lang('messages.login')</h5>
        @if(app()->getLocale() == 'ar')
            <a href="{{route('language' , 'en')}}">
                En
            </a>
        @else
            <a href="{{route('language' , 'ar')}}">
                ع
            </a>
        @endif
    </header>
    <main>
        @if (session('An_error_occurred'))
            <div class="alert alert-success">
                {{ session('An_error_occurred') }}
            </div>
        @endif
        @if (session('warning_login'))
            <div class="alert alert-danger">
                {{ session('warning_login') }}
            </div>
        @endif
        <div
            class="join_us d-flex flex-column align-items-center px-1 m-3 justify-content-center bg-white"
        >
            <br><br><br>
            <img src="{{asset('/uploads/restaurants/logo/' . $restaurant->logo)}}" width="75" height="75" alt="logo" />
            <br><br><br>
            <form method="post" action="{{route('AZUserLoginSubmit' , [$restaurant->name_barcode , $branch->name_en])}}">
                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                <div class="m-2 px-1 container_form">
                    <div class="phone_number">
                        <label for="type_company"> @lang('messages.country')</label>
                        <select name="country_id" class="form-control" required>
                            <option disabled  selected> @lang('messages.choose_one') </option>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">
                                    {{$country->name_ar}}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('country_id'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('country_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="m-2 px-1 container_form">
                    <div class="phone_number">
                        <label for="type_company"> @lang('messages.phone_number') :</label>
                        <div class="container_input">
                            <i class="fa fa-phone"></i>
                            <input
                                style="direction: rtl"
                                type="tel"
                                id="phone_number"
                                name="phone_number"
                                value="{{old('phone_number')}}"
                                placeholder="@lang('messages.phone_number')"
                                required
                            />
                        </div>
                        @if ($errors->has('phone_number'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <input type="submit" value="@lang('messages.login')" class="my-5" />
            </form>
        </div>
    </main>

    @include('website.layout.footer')
</div>

<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}
</body>
</html>
