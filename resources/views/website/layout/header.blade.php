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
                        <img src="{{asset('/uploads/restaurants/logo/' . $restaurant->logo)}}" alt="3azmak_title" />
                    </div>
                    <h2 class="name">
                        {{app()->getLocale() == 'ar' ? $restaurant->name_ar : $restaurant->name_en}}
                    </h2>
                    <ul class="p-0">
                        <hr />
                        <li class="my-2">
                            @if(app()->getLocale() == 'ar')
                                <a href="{{route('language' , 'en')}}">
                                    <i class="fa-solid fa-globe mx-2"></i>
                                    English
                                </a>
                            @else
                                <a href="{{route('language' , 'ar')}}">
                                    <i class="fa-solid fa-globe mx-2"></i>
                                    عربي
                                </a
                            @endif
                        </li>
                        <hr />
                        <!-- <li class="my-2">
                          <i class="fa-solid fa-gear mx-2"></i> الإعدادت
                        </li>
                        <hr /> -->
                        <li class="my-2">
                            <a href="{{route('restaurantTerms' , $restaurant->name_barcode)}}">
                                <i class="fa-solid fa-file-contract mx-2"></i>
                                @lang('messages.terms_conditions')
                            </a>
                        </li>
                        <hr />
                        <li class="my-2">
                            <a href="{{route('restaurantVisitorContactUs' , $restaurant->name_barcode)}}">
                                <i class="fa-solid fa-envelope mx-2"></i>
                                @lang('messages.contact_us')
                            </a>
                        </li>
                        <hr />
                        <li class="my-2">
                            <a href="{{route('restaurantAboutAzmak' , $restaurant->name_barcode)}}">
                                <i class="fa-solid fa-circle-exclamation mx-2"></i>
                                @lang('messages.about_app')
                            </a>
                        </li>
                        <hr />
                    </ul>
                    <button class="joinUs_btn">
                        <a href='/joinus'>
                            <i class="fa-regular fa-star mx-1"></i> انضم إلينا</a
                        >
                    </button>
                </div>
            </div>
        </div>
    </div>
    <img src="{{asset('/uploads/restaurants/logo/' . $restaurant->logo)}}" alt="" />
    <div class="icons">
        <a href='/notefecation'>
            <i class="fa-regular fa-bell mx-3"></i>
        </a>
    </div>
</header>
