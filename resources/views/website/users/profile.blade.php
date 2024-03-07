
<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@lang('messages.my_account')</title>
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
    <style>
        .my_account {
            border-radius: 10px;
        }
        .my_account img {
            margin-top: -50px;
        }
        .my_account p {
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
        <h5>@lang('messages.my_account')</h5>
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
        @include('flash::message')
        <div
            class="my_account d-flex flex-column align-items-center px-1 m-3 justify-content-center bg-white"
        >
            <br><br><br>
            <img src="{{asset('/uploads/restaurants/logo/' . $restaurant->az_logo)}}" width="75" height="75" alt="logo" />
            <br>
            <form method="post" action="{{route('AZUserProfileUpdate' , [$restaurant->name_barcode , $branch->name_en])}}">
                @csrf
                <div class="m-2 px-1 container_form">
                    <div class="name">
                        <label for="name">@lang('messages.name') :</label>
                        <div class="container_input">
                            <i class="fa fa-user"></i>
                            <input type="text" id="name" name="name" value="{{$user->name}}" placeholder="@lang('messages.name')" />
                        </div>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="email">
                        <label for="name">@lang('messages.email') :</label>
                        <div class="container_input">
                            <i class="fa-solid fa-envelope"></i>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{$user->email}}"
                                placeholder="@lang('messages.email')"
                            />
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="password">
                        <label for="name">@lang('messages.password') :</label>
                        <div class="container_input">
                            <i class="fa-solid fa-envelope"></i>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="@lang('messages.password')"
                            />
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="password_confirmation">
                        <label for="name">@lang('messages.password_confirmation') :</label>
                        <div class="container_input">
                            <i class="fa-solid fa-envelope"></i>
                            <input
                                type="password"
                                id="password"
                                name="password_confirmation"
                                placeholder="@lang('messages.password_confirmation')"
                            />
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="name_company">
                        <label for="name_company">@lang('messages.company_name') :</label>
                        <div class="container_input">
                            <i class="fa-solid fa-building"></i>
                            <input
                                type="text"
                                id="name_company"
                                name="company"
                                value="{{$user->company}}"
                                placeholder="@lang('messages.company_name')"
                            />
                        </div>
                        @if ($errors->has('company'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('company') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="type_company">
                        <label for="type_company">@lang('messages.company_type') :</label>
                        <div class="container_input">
                            <i class="fa fa-email"></i>
                            <input
                                type="text"
                                id="type_company"
                                name="company_type"
                                value="{{$user->company_type}}"
                                placeholder="@lang('messages.company_type')"
                            />
                        </div>
                        @if ($errors->has('company_type'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('company_type') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="phone_number">
                        <label for="type_company"> @lang('messages.contact_number') :</label>
                        <div class="container_input">
                            <i class="fa fa-phone"></i>
                            <input
                                style="direction: rtl"
                                type="tel"
                                id="phone_number"
                                name="phone_number"
                                value="{{$user->phone_number}}"
                                placeholder="@lang('messages.contact_number')"
                            />
                        </div>
                        @if ($errors->has('phone_number'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <input type="submit" value="@lang('messages.edit')" class="my-5" />
            </form>
        </div>
    </main>

    @include('website.layout.footer')
</div>
</body>
</html>
