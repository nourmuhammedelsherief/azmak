<style>
    .sidebar-title p,
    .sidebar-title a,
    .sidebar-title span {
        color: black !important;
        font-family: 'cairo' !important;
    }

    .sidebar-title * {
        color: black !important;
    }

    .main-sidebar {
        background-color: #fff !important;
    }

    .user-panel {
        border-bottom: none !important;
    }

    .nav-link.active,
    .show > .nav-link {
        color: #960082 !important;
        background-color: transparent !important;

    }

    .nav-pills .nav-link:not(.active):hover {
        color: #960082 !important;
    }

    .nav-pills .nav-link,
    .brand-text {
        color: #252525;
        font-weight: 600;
        font-size: 1rem;
        font-family: 'cairo' !important;
    }

    .sidebar-title {
        border-top: none !important;
    }

    .nav-item {
        border-bottom: 1px solid #dfdfdf;
    }
</style>
@php
    $user = Auth::guard('restaurant')->user();
    $subscription = App\Models\AzSubscription::whereRestaurantId($user->id)->first();
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('restaurant.home') }}" class="brand-link">
        <img src="{{asset('/uploads/restaurants/logo/' . $user->az_logo)}}" alt="AdminLTE Logo" class="brand-image"
             style="opacity: .8">
        <span class="brand-text font-weight-light"> @lang('messages.control_panel') </span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('restaurant.home') }}" class="nav-link">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            @lang('messages.home')
                        </p>
                    </a>
                </li>
                @if($subscription and ($subscription->status == 'free' or $subscription->status == 'active'))
                    <li class="nav-item sidebar-title">
                        <i class="nav-icon far fa-user"></i>
                        <p class="">{{ trans('messages.account_settings') }}</p>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('RestaurantProfile') }}"--}}
{{--                           class="nav-link {{ strpos(URL::current(), '/restaurant/profile') !== false ? 'active' : '' }}">--}}
{{--                            <i class="nav-icon far fa-user"></i>--}}
{{--                            <p>--}}
{{--                                @lang('messages.profile')--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        <a href="{{ url('/restaurant/barcode') }}"
                           class="nav-link {{ strpos(URL::current(), '/restaurant/barcode') !== false ? 'active' : '' }}">
                            <i class="nav-icon fa fa-barcode"></i>
                            <p>
                                {{ app()->getLocale() == 'ar' ? 'باركود المينو' : 'Print Barcode' }}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('branches.index') }}"
                           class="nav-link {{ strpos(URL::current(), '/restaurant/branches') !== false ? 'active' : '' }}">
                            <i class="nav-icon far fa-flag"></i>
                            <span class="badge badge-info right">
                                    {{ \App\Models\Restaurant\Azmak\AZBranch::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}

                                </span>
                            <p>
                                @lang('messages.branches')
                            </p>
                        </a>
                    </li>
                    <li class="nav-item sidebar-title">
                        <i class="nav-icon fa fa-bars"></i>
                        <p class="">{{ trans('messages.side_3') }}</p>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('menu_categories.index') }}"
                           class="nav-link {{ strpos(URL::current(), '/restaurant/menu_categories') !== false ? 'active' : '' }}">
                            <i class="nav-icon fa fa-bars"></i>
                            <span class="badge badge-info right">
                                    {{ \App\Models\Restaurant\Azmak\AZMenuCategory::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                </span>
                            <p>
                                @lang('messages.menu_categories')
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('modifiers.index') }}"
                           class="nav-link {{ strpos(URL::current(), '/restaurant/modifiers') !== false ? 'active' : '' }}">
                            <i class="nav-icon fa fa-plus"></i>
                            <span class="badge badge-info right">
                                    {{ \App\Models\Restaurant\Azmak\AZModifier::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                </span>
                            <p>
                                @lang('messages.modifiers')
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('additions.index') }}"
                           class="nav-link {{ strpos(URL::current(), '/restaurant/additions') !== false ? 'active' : '' }}">
                            <i class="nav-icon fa fa-plus"></i>
                            <span class="badge badge-info right">
                                    {{ \App\Models\Restaurant\Azmak\AZOption::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                </span>
                            <p>
                                @lang('messages.options')
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('posters.index') }}"
                           class="nav-link {{ strpos(URL::current(), '/restaurant/posters') !== false ? 'active' : '' }}">
                            <i class="nav-icon fa fa-image"></i>
                            <span class="badge badge-info right">
                                    {{ \App\Models\RestaurantPoster::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                </span>
                            <p>
                                @lang('messages.posters')
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}"
                           class="nav-link {{ strpos(URL::current(), '/restaurant/products') !== false ? 'active' : '' }}">
                            <i class="nav-icon fa fa-list"></i>
                            <span class="badge badge-info right">
                                    {{ \App\Models\Restaurant\Azmak\AZProduct::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                </span>
                            <p>
                                @lang('messages.products')
                            </p>
                        </a>
                    </li>
                    <li
                        class="nav-item has-treeview {{ strpos(URL::current(), '/restaurant/azmak_orders/active') !== false ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ strpos(URL::current(), '/restaurant/azmak_orders/active') !== false ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <p>
                                @lang('messages.az_orders')
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('restaurant/azmak_orders/new') }}"
                                   class="nav-link {{ Request::is('restaurant/azmak_orders/new') !== false ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('messages.new')
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('restaurant/azmak_orders/active') }}"
                                   class="nav-link {{ strpos(URL::current(), '/restaurant/azmak_orders/active') !== false ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('messages.active')
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('restaurant/azmak_orders/completed') }}"
                                   class="nav-link {{ Request::is('restaurant/azmak_orders/completed') !== false ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('messages.completed')
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('restaurant/azmak_orders/canceled') }}"
                                   class="nav-link {{ Request::is('restaurant/azmak_orders/canceled') !== false ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('messages.canceled')
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('restaurant/azmak_orders/finished') }}"
                                   class="nav-link {{ Request::is('restaurant/azmak_orders/finished') !== false ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('messages.finished')
                                    </p>
                                </a>
                            </li>


                        </ul>
                    </li>
                    <li class="nav-item sidebar-title">
                        <i class="nav-icon fa fa-users"></i>
                        <p class="">{{ trans('messages.side_4') }}</p>
                    </li>
                    <li
                        class="nav-item {{ strpos(URL::current(), '/restaurant/sliders') !== false ? 'active' : '' }}">
                        <a href="{{ url('/restaurant/sliders') }}"
                           class="nav-link {{ (strpos(URL::current(), '/restaurant/sliders') ) !== false ? 'active' : '' }}">
                            <i class="fas fa-sliders-h"></i>
                            <p>
                                @lang('messages.sliders')
                            </p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ strpos(URL::current(), '/restaurant/az_contacts') !== false ? 'active' : '' }}">
                        <a href="{{ url('/restaurant/az_contacts') }}"
                           class="nav-link {{ (strpos(URL::current(), '/restaurant/az_contacts')) !== false ? 'active' : '' }}">
                            <i class="fas fa-file"></i>
                            <p>
                                @lang('messages.contact_us')
                            </p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ strpos(URL::current(), '/restaurant/terms/conditions') !== false ? 'active' : '' }}">
                        <a href="{{ url('/restaurant/terms/conditions') }}"
                           class="nav-link {{ (strpos(URL::current(), '/restaurant/terms/conditions')) !== false ? 'active' : '' }}">
                            <i class="fas fa-file"></i>
                            <p>
                                @lang('messages.terms_conditions')
                            </p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ strpos(URL::current(), '/restaurant/azmak_about') !== false ? 'active' : '' }}">
                        <a href="{{ url('/restaurant/azmak_about') }}"
                           class="nav-link {{ (strpos(URL::current(), '/restaurant/azmak_about')) !== false ? 'active' : '' }}">
                            <i class="fas fa-file"></i>
                            <p>
                                @lang('messages.about_app')
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- Sidebar Menu -->

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
