<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>
        {{app()->getLocale() == 'ar' ? $restaurant->name_ar : $restaurant->name_en}}
    </title>
    <!-- //font -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css"
        crossorigin=""
    />

    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="{{asset('site/assets/css/swiper-bundle.min.css')}}"/>

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="{{asset('site/assets/css/styles.css')}}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@200;300;400&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="{{asset('site/css/bootstrap-grid.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/css/bootstrap.css')}}"/>
    <!-- fontawsome -->
    <link rel="stylesheet" href="{{asset('site/css/all.min.css')}}"/>
    <!-- style sheet -->
    <link rel="stylesheet" href="{{asset('site/splide/dist/css/splide.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/css/home.css')}}"/>
    <script src="{{asset('site/splide/dist/js/splide.min.js')}}"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>--}}
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
{{--    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">--}}

    <style>
        .active_categery {
            border: 3px solid var(--main_color);
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="mycontainer">
@include('website.layout.header')

<!-- <main class="py-1"> -->
    <div class="show_main_info px-1 py-3">
    @include('website.accessories.slider')
    <!-- end  main slider  -->
        <div
            class="location_branch bg-white my-4 d-flex align-items-center justify-content-between"
        >
            <span class="showBranch px-2">
                {{app()->getLocale() == 'ar' ? $branch->name_ar : $branch->name_en}}
            </span>
            @if($branches->count() > 1)
                @include('website.accessories.branch')
            @endif
        </div>
        <!-- end location branch -->
        <p class="description my-3 p-2">
            نبذة عن المطعم كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.
            ومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل
            الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص
            بديل لا علاقة له بالموضوع
        </p>
        @include('website.accessories.categories')
    </div>

    <!-- end slider show main dishes -->
    <div id="restaurant-products">
        @include('website.accessories.products')
    </div>
<!-- </main> -->
    @include('website.layout.footer')
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cardArticles = document.querySelectorAll(".card__image");

        cardArticles.forEach(function (card) {
            card.addEventListener("click", function () {
                // Remove "active" class from all cards
                cardArticles.forEach(function (card) {
                    card.classList.remove("active_categery");
                });

                // Add "active" class to the clicked card
                this.classList.add("active_categery");
            });
        });
    });
</script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

{!! Toastr::message() !!}
<script src="{{asset('site/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('site/js/cart.js')}}"></script>
<script src="{{asset('site/assets/js/swiper-bundle.min.js')}}"></script>
<script src="{{asset('site/assets/js/main.js')}}"></script>
</body>
</html>
