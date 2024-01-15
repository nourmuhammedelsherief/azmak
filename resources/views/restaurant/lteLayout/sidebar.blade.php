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
    .show>.nav-link {
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
<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('restaurant.home') }}" class="brand-link">
        <img src="{{ asset('/uploads/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light"> @lang('messages.control_panel') </span>
    </a>
    @php
        $user = Auth::guard('restaurant')->user();
    @endphp
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        @if ($user->archive == 'true')
            @php
                $url = 'https://api.whatsapp.com/send?phone=' . \App\Models\Setting::find(1)->active_whatsapp_number . '&text=';
                $content = 'حسابي مؤرشف اريد تفعيل الحساب';
            @endphp
            <a href="{{ $url . $content }}" class="btn btn-success" target="_blank">
                <i class="fab fa-whatsapp"></i>
                {{ trans('dashboard.contact_with_admin') }}
            </a>
        @elseif($user->subscription != null and $user->admin_activation == 'true' or $user->type == 'employee')
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @php
                        $account_permission = \App\Models\RestaurantPermission::whereRestaurantId($user->id)
                            ->wherePermissionId(2)
                            ->first();
                    @endphp
                    @if ($user->type == 'restaurant' or $account_permission and $user->type == 'employee')
                        <li class="nav-item">
                            <a href="{{ route('restaurant.home') }}" class="nav-link">
                                <i class="nav-icon fa fa-home"></i>
                                <p>
                                    الرئيسية
                                </p>
                            </a>
                        </li>
                        <li class="nav-item sidebar-title">
                            <i class="nav-icon far fa-user"></i>
                            <p class="">{{ trans('dashboard.account_settings') }}</p>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('RestaurantProfile') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/profile') !== false ? 'active' : '' }}">
                                <i class="nav-icon far fa-user"></i>
                                <p>
                                    @lang('messages.profile')
                                </p>
                            </a>
                        </li>
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
                            <a href="{{ url('/restaurant/pdf-barcode') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/pdf-barcode') !== false ? 'active' : '' }}">
                                <i class="nav-icon fa fa-barcode"></i>
                                <p>
                                    {{ trans('dashboard.pdf_barcode') }}
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

                    @endif

                    @php
                        $menu_permission = \App\Models\RestaurantPermission::whereRestaurantId($user->id)
                            ->wherePermissionId(4)
                            ->first();
                    @endphp
                    @if ($user->type == 'restaurant' or $menu_permission and $user->type == 'employee')
                        <li class="nav-item sidebar-title">
                            <i class="nav-icon fa fa-bars"></i>
                            <p class="">{{ trans('dashboard.side_3') }}</p>
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
                                <i class="nav-icon fa fa-poo-storm"></i>
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
                                <i class="nav-icon fa fa-project-diagram"></i>
                                <span class="badge badge-info right">
                                    {{ \App\Models\Restaurant\Azmak\AZProduct::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                </span>
                                <p>
                                    @lang('messages.products')
                                </p>
                            </a>
                        </li>
                    @endif
                    @php
                        $sales_permission = \App\Models\RestaurantPermission::whereRestaurantId($user->id)
                            ->wherePermissionId(5)
                            ->first();
                    @endphp
                    @if ($user->type == 'restaurant' or $sales_permission and $user->type == 'employee')
                        <li class="nav-item sidebar-title">
                            <i class="nav-icon fa fa-users"></i>
                            <p class="">{{ trans('dashboard.side_4') }}</p>
                        </li>


                        <li
                            class="nav-item {{ strpos(URL::current(), '/restaurant/sliders') !== false ? 'active' : '' }}">
                            <a href="{{ url('/restaurant/sliders') }}?type=home"
                                class="nav-link {{ (strpos(URL::current(), '/restaurant/sliders') and request('type') == 'home') !== false ? 'active' : '' }}">
                                <i class="fas fa-sliders-h"></i>
                                <p>
                                    @lang('messages.sliders')
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


                        <li
                            class="nav-item has-treeview {{ strpos(URL::current(), '/restaurant/sms') !== false ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/sms') !== false ? 'active' : '' }}">
                                <i class="fas fa-comments"></i>
                                <p>
                                    @lang('dashboard.sms')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ url('restaurant/sms/history') }}"
                                        class="nav-link {{ strpos(URL::current(), '/restaurant/sms/history') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.sms_history')
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('restaurant/sms/send') }}"
                                        class="nav-link {{ Request::is('restaurant/sms/send') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.send_sms')
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('restaurant/sms/settings') }}"
                                        class="nav-link {{ Request::is('restaurant/sms/settings') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.sms_settings')
                                        </p>
                                    </a>
                                </li>


                            </ul>
                        </li>
                        <li
                            class="nav-item has-treeview {{ (isUrlActive('restaurant_rate_us') or isUrlActive('restaurant_rate_us')) !== false ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ (isUrlActive('restaurant_rate_us') or isUrlActive('restaurant_rate_us')) !== false ? 'active' : '' }}">
                                <i class="fas fa-comment-dots"></i>
                                <p>
                                    @lang('dashboard.rate_service')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/restaurant/restaurant_rate_us') }}"
                                        class="nav-link {{ strpos(URL::current(), '/restaurant/restaurant_rate_us') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('messages.rate_us')
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/restaurant/restaurant_our_rates') }}"
                                        class="nav-link {{ strpos(URL::current(), '/restaurant/restaurant_our_rates') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('messages.our_rates')
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif



                </ul>
            </nav>
        @else
            @php
                $url = 'https://api.whatsapp.com/send?phone=' . \App\Models\Setting::find(1)->active_whatsapp_number . '&text=';
                $content = '
لقد قمت بتسجيل حساب جديد لديكم وأريد اكمال الاجراءات المطلوبه لتفعيل الحساب';
            @endphp
            <a href="{{ $url . $content }}" class="btn btn-success" target="_blank">
                <i class="fab fa-whatsapp"></i>
                {{ app()->getLocale() == 'ar' ? 'لتفعيل الفترة التجريبية أضغط هنا' : 'To Have The Tentative Period Click Here' }}
            </a>

        @endif
        <!-- Sidebar Menu -->

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
