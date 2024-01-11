<script type="text/javascript" src="{{ asset('scripts/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('scripts/jquery.lazy.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('scripts/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/splide/js/splide.min.js') }}"></script>
<script src="https://www.youtube.com/iframe_api"></script>
<script src="{{ asset('plugins/vanilla-calendar/vanilla-calendar.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('scripts/custom.js') }}"></script>
{{-- <script src="https://www.gstatic.com/firebasejs/10.4.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.4.0/firebase-messaging-compat.js"></script> --}}
@if (true or isset($checkWaiting->id) and $restaurant->enable_waiting == 'true')
    <script type="module">
        // Import the functions you need from the SDKs you need
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-app.js";
        import {
            getAnalytics
        } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-analytics.js";
        import {
            getMessaging,
            getToken
        } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-messaging.js";

        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyA9BwvobGmd0-i2SDC1SMhvGh5D0S0pCTA",
            authDomain: "menueasy-f2a0c.firebaseapp.com",
            projectId: "menueasy-f2a0c",
            storageBucket: "menueasy-f2a0c.appspot.com",
            messagingSenderId: "452921524670",
            appId: "1:452921524670:web:74ea430d44f1b6162c79ef",
            measurementId: "G-8NGV79J2LZ"
        };
        console.log(firebaseConfig);
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
        const messaging = getMessaging(app);

        getToken(messaging, {
            vapidKey: "BC3cuBnAoBczbNfhI5GNwS87YNDK2iyG7gWIkxAXLLOX7eFvLAmLoZrQq2PWdIrclNur316ycfq7kXsOlMO0cXk"
        }).then((currentToken) => {
            if (currentToken) {
                // Send the token to your server and update the UI if necessary
                // ...
                console.log(currentToken);
                $.ajax({
                    url: "{{ route('waitingStoreToken', $restaurant->id) }}",
                    method: 'GET',
                    data: {
                        token: currentToken
                    },
                    success: function(json) {

                    },
                    error: function(xhr) {
                        console.log(xhr);
                    },
                });
            } else {
                // Show permission request UI
                console.log('No registration token available. Request permission to generate one.');
                // ...
            }
        }).catch((err) => {
            console.log('An error occurred while retrieving token. ', err);
            // ...
        });
    </script>
    <script src="{{ asset('firebase-messaging-sw.js') }}"></script>
@endif
{{-- <script type="module" src="{{ asset('scripts/firebase-config.js') }}"></script> --}}
{{-- <script type="module">
    const firebaseConfig = {
        apiKey: "AIzaSyDYRCxL_CdnwzEPL0FObg3oLIi3s1zmy54",
        authDomain: "easymenu-7162b.firebaseapp.com",
        projectId: "easymenu-7162b",
        storageBucket: "easymenu-7162b.appspot.com",
        messagingSenderId: "433902515097",
        appId: "1:433902515097:web:36895a24b86a74025fd908",
        measurementId: "G-R9H8CQN468"
    };

    const app = firebase.initializeApp(firebaseConfig);
    const messaging  = firebase.messaging();
    messaging.getToken( {
        vapidKey: 'BC_SsTubp1vdxfWHHq7GeC5r210WTCYE7QtShm9cfR26ZLwblV7Xo-HOQL-c_KTcComjRtH0znKfQFlwgtmLxow'
    }).then((currentToken) => {
        if (currentToken) {
            // Send the token to your server and update the UI if necessary
            // ...
            console.log('current token : '  , currentToken);
        } else {
            // Show permission request UI
            console.log('No registration token available. Request permission to generate one.');
            // ...
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        // ...
    });


</script> --}}
<script type="text/javascript" src="{{ asset('scripts/global.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>

<!-- Restaurant tags start -->
@php
    $tt = isset($restaurant->id) ? App\Models\RestaurantCode::all() : [];
@endphp
@foreach ($tt as $item)
    {!! $item->footer !!}
@endforeach
<!-- Restaurant tags end -->

<script type="text/javascript">
    // $('ul.pagination').hide();
    var checkMobile = function() {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) return true;
        return false;
    }

    function onYouTubeIframeAPIReadySlider(videoId, tagId) {

        console.log('interval' , videoId , tagId);
        if (videoId && tagId) {
            window.YT.ready(function() {
                console.log($(tagId));
                var player = new YT.Player(tagId, {
                    height: '200',
                    width: '100%',
                    videoId: videoId,
                    playerVars: {
                        'playsinline': 1,
                        'fs': 1,
                        'disablekb': 1,
                        'rel': 0,
                        'showinfo': 0,
                        'ecver': 2
                    },
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });



                console.log('done');

            });
        }




    }

    // 4. The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        console.log('ready video');
        event.target.playVideo();
    }

    // 5. The API calls this function when the player's state changes.
    //    The function indicates that when playing a video (state=1),
    //    the player should play for six seconds and then stop.
    var done = false;

    function onPlayerStateChange(event) {
        console.log('change : ' + event.data);

    }

    function checkMenuProductSubmit(productId) {

        var menu = $('#menu-prodact-' + productId);

        var check = true;
        if (menu.length > 0) {
            // check sizes
            var sizes = menu.find('input.size_price').length;
            if (sizes > 0 && menu.find('input.size_price:checked').length == 0) {
                toastr.error('{{ trans('messages.error_size_price_required') }}');
                check = false;
            }

            // check additions
            var additions = menu.find('.addition-item');

            if (check) {

                $.each(additions, function(k, item) {
                    var t = $(item);
                    var option = t.find('.activity_price');
                    if (check == false) {
                        return false;
                    }

                    // check quantity validation
                    if (option.data('min') >= 1) {
                        if (option.data('choose_one') == true) {
                            var items = menu.find('[data-main_id="' + option.data('main_id') + '"]:checked');
                            if (items.length == 0 && check) {
                                toastr.error('{{ trans('messages.error_option_required') }}');
                                check = false;
                            }


                        } else if (!option.parent().parent().parent().is(':hidden') && option.prop('checked') ==
                            false && check) {

                            toastr.error('{{ trans('messages.the_addition') }} "' + option.data('name') +
                                '" {{ trans('messages.required') }}');
                            check = false;
                        }
                    }
                    // check if main modifier choose == 'custom' , check validation
                    if (option.length > 0 && option.data('is_custom') == true) {
                        var items = menu.find('.addition-item input[data-custom_id=' + option.data(
                            'custom_id') + ']:checked');
                        if (items.length != option.data('custom_num')) {
                            toastr.error('{{ trans('messages.error_option_custom') }} ' + option.data(
                                'custom_num') + ' {{ trans('messages.only') }}');
                            check = false;
                        }
                    }
                });
                console.info('success');
            }

            return check;
        }
        return false;
    }
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        console.log('vvaldl : ' + $(element).val());
        $temp.val($(element).val()).select();
        document.execCommand("copy");
        $temp.remove();
    }
    var isCategoryUp = false;
    var maxWidth = 0;
    $(function() {

        @if (isset($sliderVideo->id) and $sliderVideo->type == 'youtube')
            onYouTubeIframeAPIReadySlider("{{ $sliderVideo->youtube }}", 'slider-{{ $sliderVideo->id }}');
        @endif
        @if (session()->has('flash_notification'))
            @foreach (session('flash_notification') as $key => $notif)
                @if ($notif['level'] == 'info')
                    toastr.info("{{ $notif['message'] }}",
                        "{{ $notif['title'] }}");
                @elseif ($notif['level'] == 'success')
                    toastr.success("{{ $notif['message'] }}",
                        "{{ $notif['title'] }}");
                @elseif ($notif['level'] == 'danger')
                    toastr.danger("{{ $notif['message'] }}",
                        "{{ $notif['title'] }}");
                @elseif ($notif['level'] == 'warning')
                    toastr.warning("{{ $notif['message'] }}",
                        "{{ $notif['title'] }}");
                @endif
            @endforeach
        @endif
        // when click on categories
        $('body').on('click', '.my-categories .itemCat > a', function() {
            var thisTag = $(this);
            console.log('get product from category');
            console.log(thisTag.data('link'));
            $('.xproducts .switch-control').data('tag', thisTag.parent().attr('id'));
            var tt = $('.xproducts');
            var theme = 1;
            if (tt.hasClass('product-view-3')) {
                theme = 3;
            } else if (tt.hasClass('product-view-2')) {
                theme = 2;
            }

            $.ajax({
                url: thisTag.data('link'),
                method: 'GET',
                headers: {
                    Accept: 'application/json',
                },
                data: {
                    is_category: true,
                    theme: theme,
                },
                beforeSend: function() {
                    var height = window.outerHeight - $('#xcategories').height() - 30;
                    // $('#restaurant-products').html(
                    //     '<div class="preload-custom" style="display:flex;height:' +
                    //     height +
                    //     'px"><div class="lds-ripple" style="margin:auto;top:0 !important;"><div></div><div></div></div></div>'
                    // );

                    $('.my-categories .itemCat').removeClass('active');
                    $('.my-categories .itemCat  div.item').removeClass('active');
                    thisTag.parent().addClass('active');
                    thisTag.parent().find('div.item').addClass('active');
                },
                success: function(json) {
                    console.log(json);
                    if (json.status == true) {
                        $('.menu-category-name h5').html(json.data.category_name);
                        $('#menu-sub-categories').html(json.data.sub_categories);
                        $('#restaurant-products').html(json.data.products);
                        $('#menu-ad').remove();
                        $('body').append(json.data.ads_content).ready(function() {
                            setTimeout(() => {
                                console.log($('#menu-ad'));

                                $('#menu-ad').trigger('click');

                            }, 1000);

                        });
                        $("#restaurant-products").animate({
                            scrollTop: 0
                        }, 1);

                        window.scrollTo(0, 450);
                        console.log('scoll done');

                    }
                    $('[data-src]').lazy();
                },
                error: function(xhr) {
                    $('#restaurant-products').html(
                        '<p class="text-center">{{ trans('messages.no_products') }}</p>'
                    );
                }
            });
        }); // end click on category

        // when click on subcategory
        $('#menu-sub-categories').on('click', '.item  a', function() {
            var thisTag = $(this);
            console.log('sub-category');
            console.log(thisTag.data('link'));
            $('.xproducts .switch-control').data('tag', thisTag.parent().attr('id'));
            var tt = $('.xproducts');
            var theme = 1;
            if (tt.hasClass('product-view-3')) {
                theme = 3;
            } else if (tt.hasClass('product-view-2')) {
                theme = 2;
            }
            $.ajax({
                url: thisTag.data('link'),
                method: 'GET',
                headers: {
                    Accept: 'application/json',
                },
                data: {
                    is_category: true,
                    theme: 1,
                },
                beforeSend: function() {
                    // $('#restaurant-products').html(
                    //     '<div class="preload-custom" style="display:flex;height:380px"><div class="lds-ripple" style="margin:auto;top:0 !important;"><div></div><div></div></div></div>'
                    // ); // loader
                    $('#menu-sub-categories .subcat-card').removeClass('active');
                    thisTag.parent().addClass('active');

                },
                success: function(json) {
                    console.log(json);
                    if (json.status == true) {

                        // $('#menu-sub-categories').html(json.data.sub_categories);
                        $('#restaurant-products').html(json.data.products);

                    }
                    $('[data-src]').lazy();
                },
                error: function(xhr) {
                    $('#restaurant-products').html(
                        '<p class="text-center">{{ trans('messages.no_products') }}</p>'
                    );
                }
            });
        });


        // add add to cart
        @if (session('addToCart'))
            toastr.success("{{ trans('messages.saved_cart_success') }}", "{{ trans('messages.cart') }}");
        @endif
        $('body').on('click', '.btn-save-cart', function() {
            var tag = $(this);
            var form = $('#silverCartForm-' + tag.data('product_id'));

            var formData = new FormData(form[0]);
            const formDataObj = {};
            formData.forEach((value, key) => (formDataObj[key] = value));

            // check data
            var checkMenu = checkMenuProductSubmit(tag.data('product_id'));
            if (!checkMenu) return 0;

            // end check
            console.log(form.attr('action'));
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                headers: {
                    Accept: 'application/json'
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(json) {

                    if (json.status == true) {
                        $('#footer-bar a span').text(json.data.cart_count);

                        $('#menu-prodact-' + tag.data('product_id') + ' .close-menu')
                            .trigger('click');
                        toastr.success(json.message, "{{ trans('messages.cart') }}");
                        $('#cart-count span.count').text(json.data.cart_count);
                        $('#cart-count').fadeIn(100);
                    } else if (json.status == 2) {
                        window.location.replace(json.login_link);
                    } else if (json.status == false) {

                        toastr.error(json.message, "{{ trans('messages.cart') }}");
                    } else {
                        toastr.error("{{ trans('messages.fail_to_add_to_cart') }}",
                            "{{ trans('messages.cart') }}");
                    }

                },
                error: function(xhr) {
                    console.log(xhr);

                    toastr.error("{{ trans('messages.fail_to_add_to_cart') }}",
                        "{{ trans('messages.cart') }}");
                }
            });
        });


        var scrollValue = $(window).scrollTop();
        var categoryTop = null;
        $(window).on('scroll', function() {

            var lastProduct = $('.last-product');

            // if ({{ isset($restaurant->id) ? $restaurant->id : 0 }} == 276 && !checkIsMore && $(window).scrollTop() > scrollValue && $(window).scrollTop() >= lastProduct.offset().top + lastProduct.
            // 	outerHeight() - window.innerHeight) {
            // 	console.log(lastProduct.data());

            // 	var a = $('.menu-category-' + lastProduct.data('category_id')).next().find('> a');
            // 	// console.log('.menu-category-' + lastProduct.data('category_id'));
            // 	console.log('temp');
            // 	checkIsMore= true;
            // 	a.trigger('click');

            // 	// 	window.scrollTo(420, 420);

            // 	// alert('You reached the end of the DIV');
            // 	lastProduct.removeClass('last-product');
            // }
            // console.log( $(window).scrollTop() > scrollValue && $(window).scrollTop() >= lastProduct.offset().top + lastProduct.
            // 	outerHeight() - window.innerHeight);
            scrollValue = $(window).scrollTop();


            var $el = $('#xcategories');
            var width = $('body').width();
            @if ($restaurant->enable_fixed_category == 'true')
                if (categoryTop == null) categoryTop = $el.offset().top;
                // if($el.offset().top < (scrollValue + 30)){
                // 	// $el.css({
                // 	// 	'postion' : 'fixed' ,
                // 	// 	'top'  : '30px' ,
                // 	// 	'z-index' : 3  ,
                // 	// });
                // 	// console.log('up');
                // 	// console.log($el);
                // 	$el.addClass('fixed-categories');
                // 	isCategoryUp = true;
                // }else{
                // 	$el.css({
                // 		'postion' : 'relative' ,

                // 		'z-index' : 1  ,
                // 	});
                // }
                console.log(categoryTop);
                if (categoryTop < (scrollValue + 30) && !isCategoryUp) {
                    console.log('up');
                    $el.addClass('fixed-categories');
                    $('.card.xproducts').addClass('top-190');
                    isCategoryUp = true;
                }
                if (categoryTop >= (scrollValue + 30) && isCategoryUp) {
                    console.log('down');
                    $el.removeClass('fixed-categories');
                    $('.card.xproducts').removeClass('top-190');
                    isCategoryUp = false;
                }
            @endif
            if ($el.width() != width || $(window).width() < 1000) {
                $el.css('width', width);
                // console.log('xcategories done');
            } else {
                // console.log("width : " + width);
            }



        });
        $('body').on('click', '.total_sum', function() {
            console.log('sum');
            var mealId = $(this).attr('data');
            var all = parseInt(document.getElementById(mealId).textContent);
            var inputName = 'total' + mealId;

            let el = document.querySelector(`[name="${inputName}"]`);

            el.value = parseInt(el.value) + 1;


            calcPrice(mealId);
        });
        $('body').on('click', '.total_min', function() {
            var mealId = $(this).attr('data');
            var all = parseInt(document.getElementById(mealId).textContent);
            var inputName = 'total' + mealId;

            let el = document.querySelector(`[name="${inputName}"]`);
            if (el && el.value > 1)
                el.value = parseInt(el.value) - 1;

            console.log('value is : ' + all);
            calcPrice(mealId);
        });
        $('body').on('click', '.option_increase', function() {
            var tag = $(this);
            var optionData = tag.data();

            var optionId = $(this).attr('data');
            var mealId = $(this).attr('data-id');
            var inputName = 'qty' + optionId + mealId;
            var tagInput = $('input[name=' + inputName + ']');
            var quantity = parseInt(tagInput.val());

            if (optionData.max < (quantity + 1)) {

                toastr.info("{{ trans('messages.error_option_top_max') }}" + optionData.max);
                // tagInput.val(optionData.max);
                calcPrice(mealId);
                return 0;
            }
            var old = parseInt(document.getElementById(optionId + mealId).textContent);
            var optionPrice = parseInt((this.value));
            let el = document.querySelector(`[name="${inputName}"]`);
            // check if the input checked
            var checkId = 'box' + optionId + mealId + '-fac-radio';
            var checkBox = document.getElementById(checkId);
            if (true) {
                document.getElementById(optionId + mealId).textContent = old + optionPrice;
                el.value = parseInt(el.value) + 1;
            }
            calcPrice(mealId);

        });


        $('body').on('click', '.option_decrease', function() {
            var tag = $(this);
            var optionData = tag.data();
            var optionId = $(this).attr('data');
            var mealId = $(this).attr('data-id');
            var inputName = 'qty' + optionId + mealId;
            var tagInput = $('input[name=' + inputName + ']');
            var quantity = parseInt(tagInput.val());
            if (optionData.min > (quantity - 1)) {
                toastr.info("{{ trans('messages.error_option_top_min') }}" + optionData.min);
                // tagInput.val(optionData.max);
                calcPrice(mealId);
                return 0;
            }
            var old = parseInt(document.getElementById(optionId + mealId).textContent);
            var optionPrice = parseInt((this.value));
            var inputName = 'qty' + optionId + mealId;
            let el = document.querySelector(`[name="${inputName}"]`);
            // check if the input checked
            var checkId = 'box' + optionId + mealId + '-fac-radio';
            var checkBox = document.getElementById(checkId);
            if (true) {
                if ((old - optionPrice) >= optionPrice) {
                    document.getElementById(optionId + mealId).textContent = old - optionPrice;
                    if (parseInt(el.value) > 1) {
                        el.value = parseInt(el.value) - 1;
                    }
                }
            }
            calcPrice(mealId);

        });

        // start tabet

        if ($(window).width() > 1000) {
            $('body').addClass('mobile-width')
            console.log('max');
        }
        // end

        $('.prodcontent').on('click', '[data-xmenu]', function() {
            window.location.replace($(this).data('url'));
        });
        $('.left-sidebar').on('click', function() {
            console.log('open');
            $('#web-sidebar .sidebar-content').removeClass('close').addClass('open');
        })
        $('#web-sidebar .sidebar-content .close-sidebar').on('click', function() {
            console.log('close');
            var tag = $(this);
            console.log('sidebar', $(this));
            $('#web-sidebar .sidebar-content').addClass('close');
        })



        $('body').on('click', '.copy-url', function() {
            var tag = $(this);
            console.log($("#product-" + tag.data('id') + '-url'));
            $("input#product-" + tag.data('id') + '-url').select();
            // document.execCommand('copy');
            copyToClipboard("input#product-" + tag.data('id') + '-url');
            var t = tag.parent().parent().find('.success-copy-url');
            t.fadeIn(300);
            setTimeout(() => {
                t.fadeOut(300);
            }, 1000);
        });


        $('body').on('click', '.share-product', function() {
            var tag = $(this);
            console.log(tag.data());

            var url = $("input#product-" + tag.data('id') + '-url').val();
            if (navigator.share) {
                navigator.share({
                        title: tag.data('title'),
                        url: tag.data('url'),
                    })
                    .then(() => console.log('Successful share'))
                    .catch((error) => console.log('Error sharing', error));
            } else {
                console.log('Share not supported on this browser, do it the old way.');
            }
        });
        $('.xproducts .switch-control  > span').on('click', function() {
            var tag = $(this);
            var t = tag.parent().data('tag');
            console.log(t);

            if (tag.hasClass('view-1')) {
                tag.parent().parent().parent().removeClass('product-view-2');
                tag.parent().parent().parent().removeClass('product-view-3');
                tag.parent().parent().parent().addClass('product-view-1');

            } else if (tag.hasClass('view-2')) {
                tag.parent().parent().parent().removeClass('product-view-1');
                tag.parent().parent().parent().removeClass('product-view-3');
                tag.parent().parent().parent().addClass('product-view-2');
            } else {
                tag.parent().parent().parent().removeClass('product-view-2');
                tag.parent().parent().parent().removeClass('product-view-1');
                tag.parent().parent().parent().addClass('product-view-3');

            }
            // $('#' + t + ' > a').trigger('click');
        });

        $('body').on('click', '.waiter-request-items input[type=checkbox]', function() {

            var tag = $(this);
            if (tag.prop('checked')) {
                tag.parent().addClass('active');
            } else {
                tag.parent().removeClass('active');
            }
        });
        var splide = new Splide('.splide', {
            // type     : 'loop',
            // height   : '10rem',
            // focus    : 'right',
            //  autoplay: 'pause',
            direction: '{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}',
            autoplay: 'play',
            perPage: 1,
            interval: 3000,
            autoWidth: true,
        });
        splide.mount();


        // splide.resolve('right');




    }); // end loading function
</script>
@stack('scripts')
</body>
