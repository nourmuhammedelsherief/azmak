<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        {{app()->getLocale() == 'ar' ? $restaurant->name_ar : $restaurant->name_en}}
    </title>
    <!-- //font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
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
    @include('website.accessories.products')
    <!-- </main> -->
    @include('website.layout.footer')
</div>


<script src="{{asset('site/js/bootstrap.bundle.js')}}"></script>
<script>
    // new Splide(".splide").mount();
    new Splide(".splide", {
        rewind: true,
        rewind: true,
        loop: true,
        pauseOnFocus: true,
        breakpoints: {
            640: {
                perPage: 1,
            },
        },
    }).mount();
</script>
<script src="{{asset('site/js/cart.js')}}"></script>
</body>
</html>
