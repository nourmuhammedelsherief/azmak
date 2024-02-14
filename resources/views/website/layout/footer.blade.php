<style>
    .cart-count {
        position: fixed;
        bottom: 0px;
        left: 0;
        width: 100%;
        height: 60px;
        z-index: 9;
    }
    .cart-count .cart-btn {
        display: block;
        background-color: #f7b538;
        max-width: 494px;
        height: 100%;
        text-align: center;
        margin: auto;
    }
</style>
<footer class="px-4 py-3 d-flex align-items-center justify-content-around">
    <hr>
    @if(auth()->guard('web')->check())
        <div id="cart-count" class="cart-count " style="z-index: 1;">
            <a href="{{route('AZUserCart' , $branch->id)}}" class="cart-btn" style="background-color: #d38301">
                <i class="fa fa-shopping-cart"></i>
                @php
                $count = App\Models\Restaurant\Azmak\AZOrderItem::with('order')
                         ->whereHas('order' , function ($q) use ($branch){
                             $q->whereUserId(auth('web')->user()->id);
                             $q->whereBranchId($branch->id);
                             $q->whereStatus('new');
                             $q->orderBy('id','desc');
                         })
                         ->count();
                @endphp
                [<span class="count">
                    {{$count}}
                </span>]
                <span>@lang('messages.cart')</span>
            </a>
        </div>
    @endif
{{--    <div class="mainHome d-flex flex-column align-items-center">--}}
{{--        <a href="{{route('homeBranchIndex' , [$restaurant->name_barcode , $branch->name_en])}}"> <i class="fa fa-house"></i></a>--}}
{{--        <a href="{{route('homeBranchIndex' , [$restaurant->name_barcode , $branch->name_en])}}"> @lang('messages.home')</a>--}}
{{--    </div class="mainHome d-flex flex-column align-items-center">--}}
{{--    <div class="myorder d-flex flex-column align-items-center">--}}
{{--        <a href='/cart'> <i class="fa-solid fa-cart-shopping"></i></a>--}}
{{--        <a href='/cart'> @lang('messages.my_orders')</a>--}}
{{--    </div>--}}
{{--    <div class="myAccount d-flex flex-column align-items-center">--}}
{{--        @if(auth()->guard('web')->check())--}}
{{--            <a href="{{route('AZUserProfile' , [$restaurant->name_barcode , $branch->name_en])}}"> <i class="fa fa-shopping-cart"></i></a>--}}
{{--            <a href="{{route('AZUserProfile' , [$restaurant->name_barcode , $branch->name_en])}}"> @lang('messages.cart')</a>--}}
{{--        @else--}}
{{--            <a href="{{route('AZUserLogin' , [$restaurant->name_barcode , $branch->name_en])}}">--}}
{{--                <i class="fa-regular fa-star mx-1"></i>--}}
{{--                @lang('messages.login')--}}
{{--            </a>--}}
{{--        @endif--}}
{{--    </div>--}}
</footer>
