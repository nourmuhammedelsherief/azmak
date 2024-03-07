<header
    class="bg-white p-3 d-flex align-items-center justify-content-between"
>
    <!-- show mobile -->
    <div class="mobile_screen">
        <button
            class="btn"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasRight"
            aria-controls="offcanvasRight"
        >
            <i class="fa-solid fa-bars"></i>
        </button>

        <div
            class="offcanvas offcanvas-end offcanvas_mobile"
            tabindex="-1"
            id="offcanvasRight"
            aria-labelledby="offcanvasRightLabel"
        >
            <div class="offcanvas-header">
                <button
                    type="button"
                    class="btn-close text-reset"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                ></button>
            </div>
            <div class="offcanvas-body">
                <div class="container_ifno">
                    <div class="image">
                        <img src="{{asset('/uploads/restaurants/logo/' . $restaurant->az_logo)}}" alt="3azmak_title"/>
                    </div>
                    @if(auth()->guard('web')->check())
                        <h2 class="name">
                            {{auth()->guard('web')->user()->name}}
                        </h2>
                    @else
                        <button class="joinUs_btn">
                            <a href="{{route('AZUserLogin' , [$restaurant->name_barcode , $branch->name_en])}}">
                                <i class="fa-regular fa-star mx-1"></i>
                                @lang('messages.login')
                            </a>
                        </button>
                    @endif
                    <ul class="p-0">
                        <hr/>
                        @if(auth()->guard('web')->check())
                            <li class="my-2">
                                <a href="{{route('AZUserProfile' , [$restaurant->name_barcode , $branch->name_en])}}">
                                    <i class="fa-regular fa-user mx-1"></i>
                                    @lang('messages.my_account')
                                </a>
                            </li>
                            <hr/>

                    @endif
                    <!-- <li class="my-2">
                          <i class="fa-solid fa-gear mx-2"></i> الإعدادت
                        </li>
                        <hr /> -->
                        <li class="my-2">
                            <a href="{{route('restaurantTerms' , [$restaurant->name_barcode , $branch->name_en])}}">
                                <i class="fa-solid fa-file-contract mx-2"></i>
                                @lang('messages.terms_conditions')
                            </a>
                        </li>
                        <hr/>
                        <li class="my-2">
                            <a href="{{route('restaurantVisitorContactUs' , [$restaurant->name_barcode , $branch->name_en])}}">
                                <i class="fa-solid fa-envelope mx-2"></i>
                                @lang('messages.contact_us')
                            </a>
                        </li>
                        <hr/>
                        <li class="my-2">
                            <a href="{{route('restaurantAboutAzmak' , [$restaurant->name_barcode , $branch->name_en])}}">
                                <i class="fa-solid fa-circle-exclamation mx-2"></i>
                                @lang('messages.about_app')
                            </a>
                        </li>
                        <hr/>
                    </ul>
                    @if(auth()->guard('web')->check())
                        {{--                        <a href="#" class="joinUs_btn">--}}
                        {{--                            @lang('messages.logout')--}}
                        {{--                        </a>--}}
                        <a onclick="document.getElementById('logout_form').submit()" class="dropdown-item">
                            <i class="fas fa-key"></i>
                            @lang('messages.logout')
                        </a>
                        <form style="display: none;" id="logout_form" action="{{ route('azUser.logout') }}"
                              method="post">
                            {!! csrf_field() !!}
                        </form>
                    @else
                        <button class="joinUs_btn">
                            <a href="{{route('AZUserRegister' , [$restaurant->name_barcode , $branch->name_en])}}">
                                <i class="fa-regular fa-star mx-1"></i>
                                @lang('messages.join_us')
                            </a>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <img src="{{asset('/uploads/restaurants/logo/' . $restaurant->az_logo)}}" alt=""/>
    <div class="icons">
        @if(app()->getLocale() == 'ar')
            <a href="{{route('language' , 'en')}}">
                <i class="fa-solid fa-globe mx-2"></i>
                En
            </a>
        @else
            <a href="{{route('language' , 'ar')}}">
                <i class="fa-solid fa-globe mx-2"></i>
                ع
            </a>
        @endif
    </div>
</header>
