<style>
    .shareBtn ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        /*background-color: #333333;*/
    }

    .shareBtn ul li {
        float: left;
    }

    .shareBtn ul li a {
        display: block;
        /*color: white;*/
        text-align: center;
        padding: 16px;
        text-decoration: none;
    }

    .shareBtn ul li a:hover {
        background-color: #e1ca6c;
    }
</style>
<div class="show_meals bg-white p-3">
    @if($products->count() > 0)
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
                <div class="row mt-3">
                    @foreach($products as $product)
                        @php
                            $route = route('product_details' , $product->id);
                            $details = (app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en) . ' ' . (app()->getLocale() == 'ar' ? strip_tags(str_replace('&nbsp;', ' ', $product->description_ar)) : strip_tags(str_replace('&nbsp;', ' ', $product->description_en)));
                            $shareComponent = \Share::page(
                                $route,
                                $details,
                            )
                                ->facebook()
                                ->twitter()
                                ->linkedin()
                                ->telegram()
                                ->whatsapp()
                                ->reddit();
                        @endphp
                        <div class="col-6 mt-3">
                            <div class="list_Galler th_large p-2" id="product1">
                                <div class="image">
                                    <a href='{{route('product_details' , $product->id)}}'>
                                        <img src="{{asset('/uploads/products/' . $product->photo)}}" alt=""/>
                                    </a>
                                </div>
                                <div class="content_list p-2">
                                    <h3>
                                        <a href='{{route('product_details' , $product->id)}}'>
                                            {{app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}
                                        </a>
                                    </h3>
                                    <p>
                                        <a href='{{route('product_details' , $product->id)}}'>
                                            {{app()->getLocale() == 'ar' ? strip_tags(str_replace('&nbsp;', ' ', $product->description_ar)) : strip_tags(str_replace('&nbsp;', ' ', $product->description_en))}}
                                        </a>
                                    </p>
                                    <div
                                        class="more_details d-flex align-items-center justify-content-between"
                                    >
                                        <div class="action">
                                            <button
                                                id="addToCartBtn"
                                                class="cart-btn"
                                                data-product-id="product1"
                                            >
                                                <a href='{{route('product_details' , $product->id)}}'>
                                                    <i class="fa-solid fa-cart-plus"></i>
                                                </a>
                                            </button>
                                            <button class="share_btn" id="{{$product->id}}">
                                                <i class="fa-solid fa-share-nodes"></i>
                                            </button>
                                        </div>
                                        <div class="price">
                                            <span style="font-size: 13px">{{$product->price}} </span>
                                            <small>@lang('messages.SR')</small>
                                        </div>
                                    </div>
                                    <div style="display: none" class="shareBtn" id="shareDiv-{{$product->id}}">
                                        {!! $shareComponent !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- end home-tab -->
            <div
                class="tab-pane fade"
                id="profile"
                role="tabpanel"
                aria-labelledby="profile-tab">
                @foreach($products as $product)
                    @php
                        $route = route('product_details' , $product->id);
                        $details = (app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en) . ' ' . (app()->getLocale() == 'ar' ? strip_tags(str_replace('&nbsp;', ' ', $product->description_ar)) : strip_tags(str_replace('&nbsp;', ' ', $product->description_en)));
                        $shareComponent = \Share::page(
                            $route,
                            $details,
                        )
                            ->facebook()
                            ->twitter()
                            ->linkedin()
                            ->telegram()
                            ->whatsapp()
                            ->reddit();
                    @endphp
                    <div class="list_Gallery mt-3">
                        <div class="image">
                            <a href='{{route('product_details' , $product->id)}}'>
                                <img src="{{asset('/uploads/products/'.$product->photo)}}" alt=""/>
                            </a>
                        </div>
                        <div class="content_list p-2">
                            <h3>
                                <a href='{{route('product_details' , $product->id)}}'>
                                    {{app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}
                                </a>
                            </h3>
                            <p>
                                <a href='{{route('product_details' , $product->id)}}'>
                                    {{app()->getLocale() == 'ar' ? strip_tags(str_replace('&nbsp;', ' ', $product->description_ar)) : strip_tags(str_replace('&nbsp;', ' ', $product->description_en))}}
                                </a>
                            </p>
                            <div
                                class="more_details d-flex align-items-center justify-content-between"
                            >
                                <div class="action">
                                    <a href='{{route('product_details' , $product->id)}}'>
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </a>
                                    <button class="share2_btn" id="{{$product->id}}">
                                        <i class="fa-solid fa-share-nodes"></i>
                                    </button>
                                </div>
                                <div class="price">
                                    <span>{{$product->price}}</span>
                                    <small> @lang('messages.SR')</small>
                                </div>
                            </div>
                            <div style="display: none" class="shareBtn" id="share2Div-{{$product->id}}">
                                {!! $shareComponent !!}
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- profile-tab -->
            <div
                class="tab-pane fade"
                id="contact"
                role="tabpanel"
                aria-labelledby="contact-tab"
            >
                @foreach($products as $product)
                    @php
                        $route = route('product_details' , $product->id);
                        $details = (app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en) . ' ' . (app()->getLocale() == 'ar' ? strip_tags(str_replace('&nbsp;', ' ', $product->description_ar)) : strip_tags(str_replace('&nbsp;', ' ', $product->description_en)));
                        $shareComponent = \Share::page(
                            $route,
                            $details,
                        )
                            ->facebook()
                            ->twitter()
                            ->linkedin()
                            ->telegram()
                            ->whatsapp()
                            ->reddit();
                    @endphp
                    <div class="list mt-3 d-flex align-items-center gap-2">
                        <div class="image">
                            <a href='{{route('product_details' , $product->id)}}'>
                                <img src="{{asset('/uploads/products/'.$product->photo)}}" alt=""/>
                            </a>
                        </div>
                        <div class="content_list p-2 w-100">
                            <h3>
                                <a href='{{route('product_details' , $product->id)}}'>
                                    {{app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}
                                </a>
                            </h3>
                            <p>
                                <a href='{{route('product_details' , $product->id)}}'>
                                    {{app()->getLocale() == 'ar' ? strip_tags(str_replace('&nbsp;', ' ', $product->description_ar)) : strip_tags(str_replace('&nbsp;', ' ', $product->description_en))}}
                                </a>
                            </p>
                            <div
                                class="more_details d-flex align-items-center justify-content-between"
                            >
                                <div class="action">
                                    <a href='{{route('product_details' , $product->id)}}'>
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </a>
                                    <button class="share3_btn" id="{{$product->id}}">
                                        <i class="fa-solid fa-share-nodes"></i>
                                    </button>
                                </div>
                                <div class="price">
                                    <span>{{$product->price}}</span>
                                    <small>@lang('messages.SR')</small>
                                </div>
                            </div>
                            <div style="display: none" class="shareBtn" id="share3Div-{{$product->id}}">
                                {!! $shareComponent !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <h6 class="text-center">
            @lang('messages.no_products')
        </h6>
    @endif
</div>
<script>
    $(".share_btn").click(function(){
        var id = this.id;
        document.getElementById('shareDiv-' + id).style.display = 'block';
    });
    $(".share2_btn").click(function(){
        var id = this.id;
        document.getElementById('share2Div-' + id).style.display = 'block';
    });
    $(".share3_btn").click(function(){
        var id = this.id;
        document.getElementById('share3Div-' + id).style.display = 'block';
    });


</script>
