<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>عازمك</title>
    <!-- //font -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@200;300;400&display=swap"
        rel="stylesheet"
    />
    <!-- //bootstrap -->
    <!-- <link rel="stylesheet" href="css/bootstrap.css" /> -->
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
    <header
        class="bg-white mb-4 p-3 d-flex align-items-center justify-content-between"
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
                class="offcanvas offcanvas-end"
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
                            <img src="./image/3azmak.png" alt="3azmak_title"/>
                        </div>
                        <h2 class="name">فهد الغامري</h2>
                        <ul class="p-0">
                            <hr/>
                            <li class="my-2">
                                <i class="fa-solid fa-globe mx-2"></i> تغيير اللغة
                            </li>
                            <hr/>
                            <li class="my-2">
                                <i class="fa-solid fa-gear mx-2"></i> الإعدادت
                            </li>
                            <hr/>
                            <li class="my-2">
                                <a href="Terms&Conditions.html" target="_blank">
                                    <i class="fa-solid fa-file-contract mx-2"></i> الشروط
                                    والأحكام</a
                                >
                            </li>
                            <hr/>
                            <li class="my-2">
                                <a href="contactUS.html" target="_blank">
                                    <i class="fa-solid fa-envelope mx-2"></i> تواصل معنا</a
                                >
                            </li>
                            <hr/>
                            <li class="my-2">
                                <a href="aboutApp.html" target="_blank">
                                    <i class="fa-solid fa-circle-exclamation mx-2"></i> حول
                                    التطبيق</a
                                >
                            </li>
                            <hr/>
                        </ul>
                        <button class="joinUs_btn py-3 px-1">
                            <a href="joinUs.html" target="_blank">
                                <i class="fa-regular fa-star mx-1"></i> انضم إلينا</a
                            >
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="icons">
            <i class="fa-regular fa-bell mx-3"></i>
        </div>
    </header>
    <main class="px-3 py-1">
    @include('website.accessories.slider')
    <!-- end  main slider  -->
        <div class="location_branch my-4 d-flex align-items-center justify-content-between">
            <div>
                {{app()->getLocale() == 'ar' ? $branch->name_ar : $branch->name_en}}
            </div>

            @if($branches->count() > 1)
                @include('website.accessories.branch')
            @endif
        </div>
        <!-- end location branch -->
        <section class="splide my-5 story" aria-label="Basic Structure Example">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <div><img src="./image/bake.jpg"/></div>
                        <h6 class="my-2">عروض الفطور</h6>
                    </li>
                    <li class="splide__slide">
                        <img src="./image/desert.jpg"/>
                        <h6 class="my-2">حلويات</h6>
                    </li>
                    <li class="splide__slide">
                        <img src="./image/meal.jpg"/>
                        <h6 class="my-2">عروض الغداء</h6>
                    </li>
                </ul>
            </div>
        </section>
        <!-- end slider story -->
        <section
            class="splide my-5 main_dish"
            aria-label="Basic Structure Example"
        >
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <div class="image">
                            <img src="./image/cover1.jpg"/>
                        </div>
                        <h6 class="text-center my-2">المطاعم</h6>
                    </li>
                    <li class="splide__slide">
                        <div class="image">
                            <img src="./image/drink.jpg"/>
                        </div>
                        <h6 class="text-center my-2">المقاهي</h6>
                    </li>
                    <li class="splide__slide">
                        <div class="image">
                            <img src="./image/bake.jpg"/>
                        </div>
                        <h6 class="text-center my-2">المخبوزات</h6>
                    </li>
                </ul>
            </div>
        </section>
        <!-- end slider show main dishes -->
        <div
            class="search_meal my-3 mx-2 bg-white p-2 d-flex align-items-center"
        >
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" placeholder="ابحث عن   مطعم أو وجبة"/>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active"
                    id="home-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#home"
                    type="button"
                    role="tab"
                    aria-controls="home"
                    aria-selected="true"
                >
                    <i class="fas fa-th-large"></i>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="profile-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#profile"
                    type="button"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                >
                    <i class="fa-solid fa-image"></i>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="contact-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#contact"
                    type="button"
                    role="tab"
                    aria-controls="contact"
                    aria-selected="false"
                >
                    <i class="fa-solid fa-list"></i>
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div
                class="tab-pane fade show active"
                id="home"
                role="tabpanel"
                aria-labelledby="home-tab"
            >
                <div class="row my-3">
                    <div class="col-6">
                        <div class="list_Galler th_large p-2" id="product1">
                            <div class="image">
                                <a href="productDetails.html">
                                    <img src="./image/meal3.jpg" alt=""/>
                                </a>
                            </div>
                            <div class="content_list p-2">
                                <h3>اسم الوجبة</h3>
                                <p>وصف الوجبة</p>
                                <div
                                    class="more_details d-flex align-items-center justify-content-between"
                                >
                                    <div class="action">
                                        <button
                                            id="addToCartBtn"
                                            class="cart-btn"
                                            data-product-id="product1"
                                        >
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                        <i class="fa-solid fa-share-nodes"></i>
                                    </div>
                                    <div class="price">
                                        <span>50</span>
                                        <small> ر.س</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="list_Galler th_large p-2" id="product2">
                            <div class="image">
                                <a href="productDetails.html">
                                    <img id="productImage" src="./image/meal.jpg" alt=""/>
                                </a>
                            </div>
                            <div class="content_list p-2">
                                <h3>اسم الوجبة</h3>
                                <p>وصف الوجبة</p>
                                <div
                                    class="more_details d-flex align-items-center justify-content-between"
                                >
                                    <div class="action">
                                        <button
                                            id="addToCartBtn"
                                            class="cart-btn"
                                            data-product-id="product2"
                                        >
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                        <i class="fa-solid fa-share-nodes"></i>
                                    </div>
                                    <div class="price">
                                        <span>60</span>
                                        <small> ر.س</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-6">
                        <div class="list_Galler th_large p-2" id="product3">
                            <div class="image">
                                <a href="productDetails.html">
                                    <img src="./image/meal2.jpg" alt=""/>
                                </a>
                            </div>
                            <div class="content_list p-2">
                                <h3>اسم الوجبة</h3>
                                <p>وصف الوجبة</p>
                                <div
                                    class="more_details d-flex align-items-center justify-content-between"
                                >
                                    <div class="action">
                                        <button
                                            id="addToCartBtn"
                                            class="cart-btn"
                                            data-product-id="product3"
                                        >
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                        <i class="fa-solid fa-share-nodes"></i>
                                    </div>
                                    <div class="price">
                                        <span>40</span>
                                        <small> ر.س</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="list_Galler th_large p-2" id="product4">
                            <div class="image">
                                <a href="productDetails.html">
                                    <img src="./image/cover1.jpg" alt=""/>
                                </a>
                            </div>
                            <div class="content_list p-2">
                                <h3>اسم الوجبة</h3>
                                <p>وصف الوجبة</p>
                                <div
                                    class="more_details d-flex align-items-center justify-content-between"
                                >
                                    <div class="action">
                                        <button
                                            id="addToCartBtn"
                                            class="cart-btn"
                                            data-product-id="product4"
                                        >
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                        <i class="fa-solid fa-share-nodes"></i>
                                    </div>
                                    <div class="price">
                                        <span>40</span>
                                        <small> ر.س</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end home-tab -->
            <div
                class="tab-pane fade"
                id="profile"
                role="tabpanel"
                aria-labelledby="profile-tab"
            >
                <div class="list_Gallery my-3">
                    <div class="image">
                        <a href="productDetails.html">
                            <img src="./image/cover1.jpg" alt=""/>
                        </a>
                    </div>
                    <div class="content_list p-2">
                        <h3>اسم الوجبة</h3>

                        <p>
                            وصف قصير عن الوجبة هنا وصف قصير عن الوجبة هناوصف قصير عن
                            الوجبة هنا وصف قصير عن الوجبة هنا
                        </p>
                        <div
                            class="more_details d-flex align-items-center justify-content-between"
                        >
                            <div class="action">
                                <i class="fa-solid fa-cart-plus"></i>
                                <i class="fa-solid fa-share-nodes"></i>
                            </div>
                            <div class="price">
                                <span>40</span>
                                <small> ر.س</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- profile-tab -->
            <div
                class="tab-pane fade"
                id="contact"
                role="tabpanel"
                aria-labelledby="contact-tab"
            >
                <div class="list my-3 d-flex align-items-center gap-2">
                    <div class="image">
                        <a href="productDetails.html">
                            <img src="./image/cover1.jpg" alt=""/>
                        </a>
                    </div>
                    <div class="content_list p-2 w-100">
                        <h3>اسم الوجبة</h3>
                        <p>وصف الوجبة</p>
                        <div
                            class="more_details d-flex align-items-center justify-content-between"
                        >
                            <div class="action">
                                <i class="fa-solid fa-cart-plus"></i>
                                <i class="fa-solid fa-share-nodes"></i>
                            </div>
                            <div class="price">
                                <span>40</span>
                                <small> ر.س</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer
        class="mt-5 px-4 py-3 d-flex align-items-center justify-content-around"
    >
        <div class="mainHome d-flex flex-column align-items-center">
            <a href="home.html"> <i class="fa fa-house"></i></a>
            <a href="home.html"> الرئيسية</a>
        </div>
        <div class="myorder d-flex flex-column align-items-center">
            <a href="cart.html">
                <i class="fa-solid fa-cart-shopping"></i
                ></a>
            <a href="cart.html"> طلباتي</a>
        </div>
        <div class="myAccount d-flex flex-column align-items-center">
            <a href="myAccount.html">
                <i class="fa-solid fa-user"></i
                ></a>
            <a href="myAccount.html"> حسابي</a>
        </div>
    </footer>
</div>

<script src="{{asset('site/js/bootstrap.bundle.js')}}"></script>
<script>
    // new Splide(".splide", {
    //   // type: "loop",
    //   perPage: 4,
    //   rewind: true,
    //   breakpoints: {
    //     640: {
    //       perPage: 2,
    //     },
    //   },
    // }).mount();
    var elms = document.getElementsByClassName("splide");

    for (var i = 0; i < elms.length; i++) {
        new Splide(elms[0], {
            perPage: 4,
            rewind: true,
            breakpoints: {
                640: {
                    perPage: 2,
                },
            },
        }).mount();
        new Splide(elms[1], {
            perPage: 4,
            rewind: true,
            breakpoints: {
                640: {
                    perPage: 2,
                },
            },
        }).mount();
    }
</script>
<script src="{{asset('js/cart.js')}}"></script>
</body>
</html>
