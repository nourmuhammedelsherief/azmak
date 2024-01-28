<footer
    class="px-4 py-3 d-flex align-items-center justify-content-around"
>
    <div class="mainHome d-flex flex-column align-items-center">
        <a href="{{route('homeBranchIndex' , [$restaurant->name_barcode , $branch->name_en])}}"> <i class="fa fa-house"></i></a>
        <a href="{{route('homeBranchIndex' , [$restaurant->name_barcode , $branch->name_en])}}"> @lang('messages.home')</a>
    </div>
    <div class="myorder d-flex flex-column align-items-center">
        <a href='/cart'> <i class="fa-solid fa-cart-shopping"></i></a>
        <a href='/cart'> @lang('messages.my_orders')</a>
    </div>
    <div class="myAccount d-flex flex-column align-items-center">
        @if(auth()->guard('web')->check())
            <a href="{{route('AZUserProfile' , [$restaurant->name_barcode , $branch->name_en])}}"> <i class="fa-solid fa-user"></i></a>
            <a href="{{route('AZUserProfile' , [$restaurant->name_barcode , $branch->name_en])}}"> @lang('messages.my_account')</a>
        @else
            <a href="{{route('AZUserLogin' , [$restaurant->name_barcode , $branch->name_en])}}">
                <i class="fa-regular fa-star mx-1"></i>
                @lang('messages.login')
            </a>
        @endif
    </div>
</footer>
