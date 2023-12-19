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
                            <a href="{{ url('/restaurant/contact_us/barcode') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/contact_us/barcode') !== false ? 'active' : '' }}">
                                <i class="nav-icon fa fa-barcode"></i>
                                <p>
                                    {{ trans('dashboard.bio_barcode') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/restaurant/urgent-barcode') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/urgent-barcode') !== false ? 'active' : '' }}">
                                <i class="nav-icon fa fa-barcode"></i>
                                <p>
                                    {{ trans('dashboard.urgent_barcode') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('show_restaurant_history', $user->type == 'employee' ? $user->restaurant_id : $user->id) }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/history/' . $user->type == 'employee' ? $user->restaurant_id : $user->id) !== false ? 'active' : '' }}">
                                <i class="nav-icon fa fa-history"></i>
                                <span class="badge badge-info right">
                                    {{ \App\Models\History::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                </span>
                                <p>
                                    @lang('messages.histories')
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('branches.index') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/branches') !== false ? 'active' : '' }}">
                                <i class="nav-icon far fa-flag"></i>
                                <span class="badge badge-info right">
                                    {{ \App\Models\Branch::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->whereIn('status', ['active', 'tentative'])->count() }}

                                </span>
                                <p>
                                    @lang('messages.branches')
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('restaurant.report.menu') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/report/menu') !== false ? 'active' : '' }}">
                                <i class="nav-icon far fa-flag"></i>
                                <p>
                                    @lang('dashboard.reports_and_details')
                                </p>
                            </a>
                        </li>

                        {{--                        @if ($user->type == 'restaurant') --}}

                        {{--                            <li class="nav-item"> --}}
                        {{--                                <a href="{{url('/restaurant/restaurant_employees')}}" --}}
                        {{--                                   class="nav-link {{ strpos(URL::current(), '/restaurant/restaurant_employees') !== false ? 'active' : '' }}"> --}}
                        {{--                                    <i class="nav-icon fa fa-users"></i> --}}
                        {{--                                    <span class="badge badge-info right"> --}}
                        {{--                                        {{\App\Models\Restaurant::whereRestaurantId($user->id)->whereType('employee')->count()}} --}}
                        {{--                                    </span> --}}
                        {{--                                    <p> --}}
                        {{--                                        @lang('messages.restaurant_employees') --}}
                        {{--                                    </p> --}}
                        {{--                                </a> --}}
                        {{--                            </li> --}}
                        {{--                        @endif --}}
                    @endif
                    @php
                        $integration_permission = \App\Models\RestaurantPermission::whereRestaurantId($user->id)
                            ->wherePermissionId(3)
                            ->first();
                    @endphp
                    @if ($user->type == 'restaurant' or $integration_permission and $user->type == 'employee')
                        <li class="nav-item sidebar-title">
                            <i class="nav-icon fas fa-external-link-alt"></i>
                            <p class="">{{ trans('dashboard.side_2') }}</p>
                        </li>
                        <li
                            class="nav-item {{ strpos(URL::current(), '/restaurant/services_store') !== false ? 'active' : '' }}">
                            <a href="{{ url('restaurant/services_store') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/services_store') !== false ? 'active' : '' }}">
                                <i class="fas fa-external-link-alt"></i>
                                <span class="badge badge-info right">
                                    {{ \App\Models\Service::withCount('prices')->whereNotIn('type', ['bank', 'my_fatoora'])->where('status', 'true')->count() }}
                                </span>
                                <p>
                                    @lang('dashboard.tab_3')
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ strpos(URL::current(), '/restaurant/integrations') !== false ? 'active' : '' }}">
                            <a href="{{ url('restaurant/integrations') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/integrations') !== false ? 'active' : '' }}">
                                <i class="fas fa-external-link-alt"></i>
                                <span class="badge badge-info right">
                                    {{ \App\Models\ServiceSubscription::whereRestaurantId(
                                        $user->type == 'employee' ? $user->restaurant_id : $user->id,
                                    )->whereHas('service', function ($query) {
                                            $query->whereNotIn('type', ['bank', 'my_fatoora']);
                                        })->where('status', 'active')->count() }}
                                </span>
                                <p>
                                    @lang('dashboard.tab_2')
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ strpos(URL::current(), '/restaurant/integrations') !== false ? 'active' : '' }}">
                            <a href="{{ url('restaurant/tentative_services') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/tentative_services') !== false ? 'active' : '' }}">
                                <i class="fas fa-external-link-alt"></i>
                                <span class="badge badge-info right">
                                    {{ \App\Models\ServiceSubscription::whereRestaurantId(
                                        $user->type == 'employee' ? $user->restaurant_id : $user->id,
                                    )->whereHas('service', function ($query) {
                                            $query->whereNotIn('type', ['bank', 'my_fatoora']);
                                        })->whereIn('status', ['tentative', 'tentative_finished'])->count() }}
                                </span>
                                <p>
                                    @lang('dashboard.tab_2_tentative')
                                </p>
                            </a>
                        </li>

                        {{-- loyalty_points --}}
                        @php
                            $loyaltySubscription = \App\Models\ServiceSubscription::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)
                                ->whereHas('service', function ($query) {
                                    $query->where('id', 11);
                                })
                                ->whereIn('status', ['active', 'tentative'])
                                ->first();
                        @endphp
                        @if (isset($loyaltySubscription->id))
                            <li class="nav-header">{{ trans('dashboard.loyalty_group') }}</li>
                            <li
                                class="nav-item has-treeview {{ strpos(URL::current(), 'estaurant/loyalty_point') !== false ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ strpos(URL::current(), '/restaurant/loyalty_point') !== false ? 'active' : '' }}">
                                    {{-- <i class="fas fa-money-bill-wave"></i> --}}
                                    1 )
                                    <p>
                                        @lang('dashboard.loyalty_points')
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    {{-- prices --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/loyalty_point_price') }}"
                                            class="nav-link {{ strpos(URL::current(), 'loyalty_point_price') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.loyalty_point_prices')
                                            </p>
                                        </a>
                                    </li>

                                    {{-- settings --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/loyalty_point/settings') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/loyalty_point/settings') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.settings')
                                            </p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        @endif
                        @php
                            $luckySubscription = \App\Models\ServiceSubscription::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)
                                ->whereHas('service', function ($query) {
                                    $query->where('id', 11);
                                })
                                ->whereIn('status', ['active', 'tentative'])
                                ->first();

                        @endphp
                        @if (isset($luckySubscription->id) and $luckySubscription->service->lucky_wheel == 'true')
                            <li
                                class="nav-item has-treeview {{ strpos(URL::current(), 'estaurant/lucky_wheel') !== false ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ strpos(URL::current(), '/restaurant/lucky_wheel') !== false ? 'active' : '' }}">
                                    2 )
                                    <p>
                                        @lang('dashboard.lucky_wheel')
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    {{-- tables --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/lucky_wheel/item') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/lucky_wheel/item') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.lucky_items')
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/lucky_wheel/order') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/lucky_wheel/order') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.lucky_orders')
                                            </p>
                                        </a>
                                    </li>

                                    {{-- settings --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/loyalty_point/settings') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/loyalty_pointx/settings') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.settings')
                                            </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif
                        @if (isset($luckySubscription->id))
                            <li
                                class="nav-item has-treeview {{ strpos(URL::current(), 'estaurant/loyalty-offer') !== false ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ strpos(URL::current(), '/restaurant/loyalty-offer') !== false ? 'active' : '' }}">
                                    3 )
                                    <p>
                                        @lang('dashboard.loyalty_card')
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/loyalty-offer/item') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/loyalty-offer/item') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.offers')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- requests --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/loyalty-offer/request') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/loyalty-offer/request') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.loyalty_requests')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- prize --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/loyalty-offer/prize') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/loyalty-offer/prize') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.loyalty_prizes')
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/loyalty-offer/users') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/loyalty-offer/users') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.users_histroy')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- settings --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/loyalty-offer/settings') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/loyalty-offer/settings') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.settings')
                                            </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif
                        @php
                            $waiterSubscription = \App\Models\ServiceSubscription::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)
                                ->whereHas('service', function ($query) {
                                    $query->where('id', 14);
                                })
                                ->whereIn('status', ['active', 'tentative'])
                                ->first();
                            $waiterCasherSubscription = \App\Models\ServiceSubscription::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)
                                ->whereHas('service', function ($query) {
                                    $query->where('id', 10);
                                })
                                ->whereIn('status', ['active', 'tentative'])
                                ->first();
                        @endphp
                        @if (isset($waiterSubscription->id) or
                                isset($waiterCasherSubscription->id) and $waiterCasherSubscription->service->enable_waiter == 'true')
                            <li
                                class="nav-item has-treeview {{ strpos(URL::current(), 'estaurant/waiter') !== false ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ strpos(URL::current(), '/restaurant/waiter') !== false ? 'active' : '' }}">
                                    <i class="fas fa-wine-glass nav-icon"></i>
                                    <p>
                                        @lang('dashboard.waiters')
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    {{-- tables --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/waiter/tables') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/waiter/tables') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.tables')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- employee --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/waiter/employees') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/waiter/employees') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.employees')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- item --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/waiter/items') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/waiter/items') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.waiter_requests')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- order --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/waiter/orders') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/waiter/orders') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.waiter_orders')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- settings --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/waiter/settings') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/waiter/settings') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.settings')
                                            </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif

                        @php
                            $waitingSubscription = \App\Models\ServiceSubscription::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)
                                ->whereHas('service', function ($query) {
                                    $query->where('id', 15);
                                })
                                ->whereIn('status', ['active', 'tentative'])
                                ->first();
                        @endphp
                        @if (isset($waitingSubscription->id))
                            <li
                                class="nav-item has-treeview {{ strpos(URL::current(), 'estaurant/waiting') !== false ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ strpos(URL::current(), '/restaurant/waiting') !== false ? 'active' : '' }}">

                                    <i class="fas fa-chair"></i>
                                    <p>
                                        @lang('dashboard.waiting_system')
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    {{-- branches --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/waiting/branch') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/waiting/branch') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.branches')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- place --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/waiting/place') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/waiting/place') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.places')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- employee --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/waiting/employee') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/waiting/employee') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.employees')
                                            </p>
                                        </a>
                                    </li>

                                    {{-- orders --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/waiting/order') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/waiting/order') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <span class="badge badge-info right">
                                                {{ \App\Models\Waiting\WaitingOrder::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                            </span>
                                            <p>
                                                @lang('dashboard.waiting_orders')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- settings --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/waiting/settings') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/waiting/settings') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.waiting_settings')
                                            </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif
                        @php
                            $partySubscription = \App\Models\ServiceSubscription::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)
                                ->whereHas('service', function ($query) {
                                    $query->where('id', 13);
                                })
                                ->whereIn('status', ['active', 'tentative'])
                                ->first();
                        @endphp
                        @if (isset($partySubscription->id))
                            <li
                                class="nav-item has-treeview {{ strpos(URL::current(), 'estaurant/party') !== false ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ strpos(URL::current(), '/restaurant/party') !== false ? 'active' : '' }}">
                                    <i class="fas fa-comment-dots"></i>
                                    <p>
                                        @lang('dashboard.parties')
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    {{-- prices --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/party-branch') }}"
                                            class="nav-link {{ strpos(URL::current(), 'party-branch') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.party_branches')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- parties --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/party') }}"
                                            class="nav-link {{ isUrlActive('restaurant/party', true) !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.parties')
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/party-order') }}"
                                            class="nav-link {{ isUrlActive('restaurant/party-order') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.party_orders')
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/party/payment-settings') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/party/payment-settings') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.reservation_services')
                                            </p>
                                        </a>
                                    </li>
                                    {{-- settings --}}
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/party/settings') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/party/settings') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.settings')
                                            </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif
                        {{-- reservation --}}
                        {{--                    @if (auth('admin')->check()) --}}
                        @php
                            $checkReservation = \App\Models\ServiceSubscription::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)
                                ->where('service_id', 1)
                                ->whereIn('status', ['active', 'tentative'])
                                ->first();
                        @endphp
                        @if ($checkReservation)
                            <li
                                class="nav-item has-treeview {{ (isUrlActive('reservation/branch') or
                                isUrlActive('reservation/place') or
                                isUrlActive('reservation/barcode') or
                                isUrlActive('reservation/services') or
                                isUrlActive('reservation/description') or
                                isUrlActive('/reservation/tables') or
                                isUrlActive('restaurant/banks') or
                                isUrlActive('restaurant/myfatoora_token') or
                                isUrlActive('estaurant/reservation/cash') or
                                isUrlActive('estaurant/reservation') or
                                isUrlActive('reservation/order'))
                                    ? 'menu-open'
                                    : 'menu-open' }}">
                                <a href="#"
                                    class="nav-link {{ isUrlActive('reservation/branch') ? 'active' : '' }}">
                                    <i class="fas fa-comment-dots"></i>
                                    <p>
                                        @lang('dashboard.reservations')
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{ route('restaurant.reservation.branch.index') }}"
                                            class="nav-link {{ isUrlActive('reservation/branch') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.branches')
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('restaurant.reservation.place.index') }}"
                                            class="nav-link {{ isUrlActive('reservation/place') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.places')
                                            </p>
                                        </a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="{{ route('restaurant.reservation.description.edit') }}"
                                            class="nav-link {{ isUrlActive('reservation/description') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.reservation_description')
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/restaurant/reservation/tables') }}"
                                            class="nav-link {{ isUrlActive('/reservation/tables') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.reservation_tables')
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('restaurant.reservation.index') }}"
                                            class="nav-link {{ isUrlActive('/reservation/order') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.reservation_orders')
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('resetaurant.reservation.services') }}"
                                            class="nav-link {{ (isUrlActive('/reservation/services') or
                                            isUrlActive('urant/banks') or
                                            isUrlActive('estaurant/myfatoora_token') or
                                            isUrlActive('estaurant/reservation/cash') or
                                            isUrlActive('estaurant/reservation/service'))
                                                ? 'active'
                                                : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.reservation_services')
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('reservation.settings') }}"
                                            class="nav-link {{ strpos(URL::current(), '/reservation/settings') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ trans('dashboard.settings') }}
                                            </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif
                        @php
                            $check_branch = \App\Models\Branch::with('service_subscriptions')
                                ->whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)

                                ->where('foodics_status', 'true')
                                ->where('status', 'active')
                                ->orWhereHas('service_subscriptions', function ($q) use ($user) {
                                    $q->where('restaurant_id', $user->id);
                                    $q->whereStatus('tentative');
                                    $q->where('service_id', 4);
                                })
                                ->first();
                            $check = isUrlActive('foodics');
                            $foodicsBranchId = isset($check_branch->id) ? $check_branch->id : 0;
                        @endphp
                        @if ($check_branch)
                            <li class="nav-item has-treeview {{ $check !== false ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ $check !== false ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-table"></i>
                                    <p>
                                        @lang('dashboard.casher_foodics')
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    {{-- end foodics --}}
                                    <li class="nav-item">
                                        <a href="{{ route('foodics_branches') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/foodics/branches') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <span class="badge badge-info right">
                                                {{ \App\Models\RestaurantFoodicsBranch::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                            </span>
                                            <p>
                                                {{ trans('dashboard.foodics_branches') }}
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('foodics_discounts', $foodicsBranchId) }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/foodics/discounts/' . $foodicsBranchId) !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <span class="badge badge-info right">
                                                {{ \App\Models\FoodicsDiscount::whereBranchId($foodicsBranchId)->count() }}
                                            </span>
                                            <p>
                                                @lang('messages.foodics_discount')
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('FoodicsOrderSetting', $foodicsBranchId) }}"
                                            class="nav-link {{ strpos(URL::current(), 'foodics/restaurant_setting/' . $foodicsBranchId) !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                {{ app()->getLocale() == 'ar' ? 'إعدادت طلبات فودكس' : 'Foodics Order Setting' }}
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('FoodicsOrderTable', $foodicsBranchId) }}"
                                            class="nav-link {{ strpos(URL::current(), 'foodics/tables/' . $foodicsBranchId) !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <span class="badge badge-info right">
                                                {{ \App\Models\Table::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->whereBranchId($foodicsBranchId)->where('foodics_id', '!=', null)->count() }}
                                            </span>
                                            <p>
                                                {{ app()->getLocale() == 'ar' ? 'طاولات فوودكس' : 'Foodics Tables' }}
                                            </p>
                                        </a>
                                    </li>
                                    @if (auth('restaurant')->check())
                                        <li class="nav-item">
                                            <a href="{{ route('FoodicsOrder') }}"
                                                class="nav-link {{ strpos(URL::current(), 'foodics-orders') !== false ? 'active' : '' }}">
                                                <i class="far fa-circle nav-icon"></i>

                                                <span class="badge badge-info right">
                                                    {{ \App\Models\SilverOrderFoodics::where('restaurant_id', auth('restaurant')->Id())->whereHas('details')->count() }}
                                                </span>
                                                <p>
                                                    {{ trans('dashboard.foodicsOrders') }}
                                                </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('FoodicsTableOrder') }}"
                                                class="nav-link {{ strpos(URL::current(), 'foodics/order') !== false ? 'active' : '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <span class="badge badge-info right">
                                                    {{ \App\Models\TableOrder::where('restaurant_id', auth('restaurant')->id())->where('status', '!=', 'in_reservation')->whereHas('order_items')->orderBy('created_at', 'desc')->count() }}
                                                </span>
                                                <p>
                                                    {{ trans('dashboard.foodics_orders') }}
                                                </p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>



                        @endif

                        @php
                            $checkEasyMenuCasherService = \App\Models\RestaurantOrderSetting::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)
                                ->where('order_type', 'easymenu')
                                ->where('table', 'true')
                                ->first();
                            $checkEasyMenuCasherSubscription = \App\Models\ServiceSubscription::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)
                                ->whereServiceId(10)
                                ->whereIn('status', ['active', 'tentative'])
                                ->first();
                        @endphp
                        @if ($checkEasyMenuCasherSubscription)
                            @php
                                $check = (isUrlActive('easymenu_cacher') or isUrlActive('easymenu/table') or isUrlActive('t/employee') or isUrlActive('restaurant_setting') or isUrlActive('order_seller_codes') or isUrlActive('order/report'));
                            @endphp
                            <li class="nav-item has-treeview {{ $check !== false ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ $check !== false ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-table"></i>
                                    <p>
                                        @lang('dashboard.casher_easy')
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    {{-- tables --}}
                                    @if ($checkEasyMenuCasherService)
                                        <li class="nav-item">
                                            <a href="{{ route('EasyMenuTable', 10) }}"
                                                class="nav-link  {{ (strpos(URL::current(), '/restaurant/easymenu_casher/tables/10') or isUrlActive('easymenu/table')) !== false ? 'active' : '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <span class="badge badge-info right">
                                                    {{ \App\Models\Table::whereRestaurantId($user->id)->where('service_id', 10)->count() }}
                                                </span>
                                                <p>
                                                    {{ app()->getLocale() == 'ar' ? 'طاولات كاشير إيزي منيو' : 'EasyMenu Tables' }}
                                                </p>
                                            </a>
                                        </li>
                                    @endif

                                    <li class="nav-item">
                                        <a href="{{ route('employees.index') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/employees') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <span class="badge badge-info right">
                                                {{ \App\Models\RestaurantEmployee::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                            </span>
                                            <p>
                                                @lang('messages.employees')
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('restaurant_setting.index') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/restaurant_setting') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <span class="badge badge-info right">
                                                {{ \App\Models\RestaurantOrderSetting::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                            </span>
                                            <p>
                                                @lang('messages.restaurant_orders_settings')
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('order_seller_codes.index') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/order_seller_codes') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <span class="badge badge-info right">
                                                {{ \App\Models\RestaurantOrderSellerCode::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->where('type' , 'casher_easymenu')->count() }}
                                            </span>
                                            <p>
                                                @lang('messages.order_seller_codes')
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('restaurant.order.report') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/order/report') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>

                                            <p>
                                                @lang('dashboard.order_report')
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @php
                            $checkWhatsAppService = \App\Models\RestaurantOrderSetting::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)
                                ->where('order_type', 'whatsapp')
                                ->first();
                            $checkWhatsAppSubscription = \App\Models\ServiceSubscription::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)
                                ->whereServiceId(9)
                                ->whereIn('status', ['active', 'tentative'])
                                ->first();
                        @endphp



                        @if ($checkWhatsAppSubscription)
                            @php
                                $check = (isUrlActive('whatsApp') or isUrlActive('whatsapp/order')  or isUrlActive('t/employee') or isUrlActive('restaurant_setting') or isUrlActive('whatsapp_branch'));
                            @endphp
                            <li class="nav-item has-treeview {{ $check !== false ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ isUrlActive('easymenu_casher') !== false ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-table"></i>
                                    <p>
                                        @lang('dashboard.whatsapp_casher')
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if ($checkWhatsAppService)
                                        @if(App\Models\RestaurantOrderSetting::where('restaurant_id' , $user->id)->where('table' , 'true')->count() > 0)
                                        <li class="nav-item">
                                            <a href="{{ route('WhatsAppTable', 9) }}"
                                                class="nav-link {{ strpos(URL::current(), '/restaurant/whatsApp/tables/9') !== false ? 'active' : '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <span class="badge badge-info right">
                                                    {{ \App\Models\Table::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->where('service_id', 9)->count() }}
                                                </span>
                                                <p>
                                                    {{ app()->getLocale() == 'ar' ? 'طاولات الواتساب' : 'WhatsApp Tables' }}
                                                </p>
                                            </a>
                                        </li>
                                        @endif

                                        <li class="nav-item">
                                            <a href="{{ route('whatsapp_branches.index') }}"
                                                class="nav-link {{ strpos(URL::current(), 'whatsapp_branches') !== false ? 'active' : '' }}">

                                                <i class="far fa-circle nav-icon"></i>
                                                <span class="badge badge-info right">
                                                    {{ \App\Models\WhatsappBranch::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                                </span>
                                                <p>
                                                    {{ trans('dashboard.whatsapp_branches') }}
                                                </p>
                                            </a>
                                        </li>
                                    @endif


                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/whatsapp/order_seller_codes') }}"
                                            class="nav-link  {{ (strpos(URL::current(), '/restaurant/whatsapp/order_seller_codes') ) !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <span class="badge badge-info right">
                                                {{ \App\Models\RestaurantOrderSellerCode::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->where('type' , 'casher_whatsapp')->count() }}
                                            </span>
                                            <p>
                                                @lang('messages.order_seller_codes')
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('restaurant_setting.index') }}"
                                            class="nav-link {{ strpos(URL::current(), '/restaurant/restaurant_setting') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <span class="badge badge-info right">
                                                {{ \App\Models\RestaurantOrderSetting::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                            </span>
                                            <p>
                                                @lang('messages.restaurant_orders_settings')
                                            </p>
                                        </a>
                                    </li>



                                </ul>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('restaurant.service-provider.index') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/service-provider') !== false ? 'active' : '' }}">
                                <i class="nav-icon fa fa-users"></i>
                                <span class="badge badge-info right">
                                    @php
                                        $restaurant = auth('restaurant')->user();
                                        if ($restaurant->type == 'employee') {
                                            $restaurant = $restaurant->restaurant;
                                        }
                                    @endphp
                                    {{ \App\Models\ServiceProvider\ServiceProvider::whereHas('subscriptions', function ($query) {
                                        $query->where('status', 'in_progress')->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'));
                                    })->whereHas('cities', function ($query) use ($restaurant) {
                                            $query->where('city_id', $restaurant->city_id);
                                        })->count() }}
                                </span>
                                <p>
                                    @lang('dashboard.service_providers')
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                                <a href="{{ route('EasyMenuTable', 10) }}"
                                    class="nav-link {{ strpos(URL::current(), '/restaurant/easymenu_casher/tables/10') !== false ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-table"></i>
                                    <span class="badge badge-info right">
                                        {{ \App\Models\Table::whereRestaurantId($user->id)->where('service_id', 10)->count() }}
                                    </span>
                                    <p>
                                        {{ app()->getLocale() == 'ar' ? 'طاولات كاشير إيزي منيو' : 'EasyMenu Tables' }}
                                    </p>
                                </a>
                            </li> --}}




                        {{--
                        @if ($EasyMenuService)
                            <li class="nav-item">
                                <a href="{{ route('order_seller_codes.index') }}"
                                    class="nav-link {{ strpos(URL::current(), '/restaurant/order_seller_codes') !== false ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-code-branch"></i>
                                    <span class="badge badge-info right">
                                        {{ \App\Models\RestaurantOrderSellerCode::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
                                    </span>
                                    <p>
                                        @lang('messages.order_seller_codes')
                                    </p>
                                </a>
                            </li>
                        @endif --}}

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
                                    {{ \App\Models\MenuCategory::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
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
                                    {{ \App\Models\Modifier::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
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
                                    {{ \App\Models\Option::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
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
                                    {{ \App\Models\Product::whereRestaurantId($user->type == 'employee' ? $user->restaurant_id : $user->id)->count() }}
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
                        <!--<li class="nav-item">-->
                        <!--    <a href="{{ route('my_restaurant_users') }}"-->
                        <!--       class="nav-link {{ strpos(URL::current(), '/restaurant/my_restaurant_users') !== false ? 'active' : '' }}">-->
                        <!--        <i class="nav-icon fa fa-users"></i>-->
                        <!--        <span class="badge badge-info right">-->
                        <!--        {{ \DB::select('select count(DISTINCT(user_id)) as count from orders where restaurant_id = ' . $user->id)[0]->count }}-->
                        <!--    </span>-->
                        <!--        <p>-->
                        <!--            @lang('messages.my_restaurant_users')-->
                        <!--        </p>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <li
                            class="nav-item has-treeview {{ strpos(URL::current(), 'estaurant/online_offer') !== false ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/online_offer') !== false ? 'active' : '' }}">
                                <i class=" fas fa-bolt"></i>
                                <p>
                                    @lang('dashboard.online_offers')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ url('restaurant/online_offer/category') }}"
                                        class="nav-link {{ strpos(URL::current(), '/restaurant/online_offer/category') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.online_offer_categories')
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('restaurant/online_offer/image') }}"
                                        class="nav-link {{ strpos(URL::current(), '/restaurant/online_offer/image') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.online_offer_images')
                                        </p>
                                    </a>
                                </li>



                            </ul>
                        </li>
                        <li
                            class="nav-item {{ strpos(URL::current(), '/restaurant/ads') !== false ? 'active' : '' }}">
                            <a href="{{ route('restaurant.ads.index') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/ads') !== false ? 'active' : '' }}">
                                <i class="fas fa-external-link-alt"></i>
                                <p>
                                    @lang('dashboard.ads')
                                </p>
                            </a>
                        </li>

                        <li
                            class="nav-item {{ strpos(URL::current(), '/restaurant/offers') !== false ? 'active' : '' }}">
                            <a href="{{ url('/restaurant/offers') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/offers') !== false ? 'active' : '' }}">
                                <i class="fas fa-gift"></i>
                                <p>
                                    @lang('messages.offers')
                                </p>
                            </a>
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

                        {{-- rate --}}

                        <li
                            class="nav-item has-treeview {{ strpos(URL::current(), '/restaurant/feedback') !== false ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/feedback') !== false ? 'active' : '' }}">
                                <i class="fas fa-comment-dots"></i>
                                <p>
                                    @lang('dashboard.client_rate')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                {{-- rate --}}

                                <li class="nav-item">
                                    <a href="{{ route('restaurant.feedback.index') }}"
                                        class="nav-link {{ strpos(URL::current(), '/restaurant/feedbackx') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.client_feedback')
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('restaurant/feedback/branch') }}"
                                        class="nav-link {{ strpos(URL::current(), '/restaurant/feedback/branchx') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.branches')
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('restaurant/feedback/branch_setting') }}"
                                        class="nav-link {{ strpos(URL::current(), '/restaurant/feedback/branch_settingx') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.feedback_setting')
                                        </p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        {{-- contact_us --}}
                        <li
                            class="nav-item has-treeview {{ (strpos(URL::current(), '/restaurant/contact_us') !== false or
                            isUrlActive('link_contact_us') or
                            strpos(URL::current(), '/restaurant/sliders') and request('type') == 'contact_us' or
                            strpos(URL::current(), '/restaurant/sliders') and request('type') == 'contact_us_client')
                                ? 'menu-open'
                                : '' }}">
                            <a href="#"
                                class="nav-link {{ (strpos(URL::current(), '/restaurant/contact_us') !== false or
                                isUrlActive('link_contact_us') or
                                strpos(URL::current(), '/restaurant/sliders') and request('type') == 'contact_us' or
                                strpos(URL::current(), '/restaurant/sliders') and request('type') == 'contact_us_client')
                                    ? 'active'
                                    : '' }}">
                                <i class="fas fa-share-square"></i>
                                <p>
                                    @lang('dashboard.bio_link')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if ($restaurant->enable_contact_us_links == 'true')
                                    <li class="nav-item">
                                        <a href="{{ url('restaurant/link_contact_us') }}"
                                            class="nav-link {{ Request::is('restaurant/link_contact_us') !== false ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                @lang('dashboard.link_contact_us')
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a href="{{ url('restaurant/contact_us') }}"
                                        class="nav-link {{ Request::is('restaurant/contact_us') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.default_link')
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a href="{{ url('/restaurant/sliders') }}?type=contact_us"
                                        class="nav-link {{ (strpos(URL::current(), '/restaurant/sliders') and request('type') == 'contact_us') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.slider_contact_us')
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a href="{{ url('/restaurant/sliders') }}?type=contact_us_client"
                                        class="nav-link {{ (strpos(URL::current(), '/restaurant/sliders') and request('type') == 'contact_us_client') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.slider_contact_us_client')
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('restaurant/contact_us/settings') }}"
                                        class="nav-link {{ strpos(URL::current(), '/restaurant/contact_us/settings') !== false ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            @lang('dashboard.default_link_settings')
                                        </p>
                                    </a>
                                </li>

                            </ul>
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


                    @php
                        $info_permission = \App\Models\RestaurantPermission::whereRestaurantId($user->id)
                            ->wherePermissionId(6)
                            ->first();
                    @endphp
                    @if ($user->type == 'restaurant' or $info_permission and $user->type == 'employee')
                        <li class="nav-item sidebar-title">
                            <i class="nav-icon fas fa-info"></i>
                            <p class="">{{ trans('dashboard.side_5') }}</p>
                        </li>
                        {{-- information --}}
                        <li class="nav-item">
                            <a href="{{ route('restaurant.home_icons.index') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/home_icons') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    @lang('dashboard.home_icons')
                                </p>
                            </a>
                        </li>
                        {{-- social --}}
                        <li class="nav-item">
                            <a href="{{ url('/restaurant/socials') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/socials') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    @lang('messages.socials')
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/restaurant/deliveries') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/deliveries') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    @lang('messages.deliveries')
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/restaurant/sensitivities') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/sensitivities') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    @lang('messages.sensitivities')
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/restaurant/information') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/information') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    @lang('messages.information')
                                </p>
                            </a>
                        </li>
                        @if (auth('restaurant')->check() and auth('restaurant')->user()->enable_bank == 'true')
                            <li class="nav-item">
                                <a href="{{ route('restaurant.banks.index') }}"
                                    class="nav-link {{ isUrlActive('banks') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('messages.banks')
                                    </p>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="{{ url('/restaurant/res_branches') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/res_branches') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    @lang('messages.branches_location')
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/restaurant/my-information') }}"
                                class="nav-link {{ strpos(URL::current(), '/restaurant/my-information') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    @lang('messages.my_information')
                                </p>
                            </a>
                        </li>

                    @endif

                    {{-- <li class="nav-item">
                        <a href="{{ url('/restaurant/related_code') }}"
                           class="nav-link {{ strpos(URL::current(), '/restaurant/related_code') !== false ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                @lang('dashboard.header_footer')
                            </p>
                        </a>
                    </li> --}}
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
