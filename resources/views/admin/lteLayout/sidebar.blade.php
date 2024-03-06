<style>
    /*sidebar*/
    .nav-pills .nav-link.active,
    .nav-pills .show > .nav-link {
        color: #fff;
        background: transparent !important;
    }

    .nav-pills .nav-link.active p {
        color: #960082;
    }

    .nav-pills .nav-link.active i {
        color: #960082;
    }

    .main-sidebar {
        background-color: white;
        box-shadow: 0 5px 7px #00000005, 0 0 4px #0000000d, 0 3px 6px #00000014 !important;
        /*width:260px;*/
        font-family: 'Cairo', sans-serif;
    }

    .main-sidebar .brand-link,
    .user-panel {
        border-bottom: 1px solid #dfdfdf;
    }

    .main-sidebar .nav-item {
        border-bottom: 1px solid #dfdfdf;
        padding: 3px 0;

    }

    .main-sidebar .nav-item:last-child {
        border-bottom: none;

    }

    .main-sidebar .nav-link {
        color: #252525;
    }

    .main-sidebar .nav-link p {
        color: #252525;
        font-weight: 600;
        font-size: 1rem;


    }

    .main-sidebar .nav-link:hover p {
        color: #960082;
    }

    .main-sidebar .nav-link i {
        color: #9ca7b9;
        /*margin-left: 7px;*/
        font-size: 16px;
    }

    .main-sidebar .nav-link:hover i {
        color: #960082;
    }

    .main-sidebar .brand-text {
        font-size: 1.25rem;
        color: #252525;
        font-weight: 700;
    }

    .main-sidebar .info .d-block {
        color: #252525;
    }

    /*.main_page{*/
    /*        margin-right: 7px;*/

    /*}*/
    .test {
        background-color: red !important;
    }
</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar">


    <!-- Brand Logo -->
    <a href="{{ url('/admin/home') }}" class="brand-link">
        <img src="{{ asset('/uploads/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
        <span class="brand-text">@lang('messages.control_panel')</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!--here i delete side menu it contains info user-->
        <?php $admin = Auth::guard('admin')->user(); ?>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!--test-->
                <li class="nav-item main_page">
                    <a href="{{ url('/admin/home') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <p> الرئيسية</p>
                    </a>
                </li>

                <!-- end test-->

            {{-- online --}}

            <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                <!--teeeeeeeeeeeeeeeeest-->
                <li class="nav-item has-treeview" id="has-test">
                    <!--delet open menue-->
                    <a href="#"
                       class="nav-link {{ (isUrlActive('restaurants/new') or
                            isUrlActive('restaurants/free') or
                            isUrlActive('restaurants/active') or
                            isUrlActive('restaurants/finished'))
                                ? 'active'
                                : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            @lang('messages.restaurants')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview test-open">

                        <li class="nav-item">
                            <a href="{{ url('/admin/restaurants/new') }}"
                               class="nav-link {{ strpos(URL::current(), '/admin/restaurants/new') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <span class="badge badge-info right">
                                    {{\App\Models\AzSubscription::where('status', 'new')->count() }}
                                </span>
                                <p>
                                    @lang('messages.new_restaurants')
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/restaurants/active') }}"
                               class="nav-link {{ strpos(URL::current(), '/admin/restaurants/active') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <span class="badge badge-info right">
                                    {{\App\Models\AzSubscription::where('status', 'active')->count() }}
                                </span>
                                <p>
                                    @lang('messages.active_restaurants')
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/restaurants/free') }}"
                               class="nav-link {{ strpos(URL::current(), '/admin/restaurants/free') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <span class="badge badge-info right">
                                    {{\App\Models\AzSubscription::where('status', 'free')->count() }}
                                </span>
                                <p>
                                    @lang('messages.free_restaurants')
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/restaurants/finished') }}"
                               class="nav-link {{ strpos(URL::current(), '/admin/restaurants/finished') !== false ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <span class="badge badge-info right">
                                    {{\App\Models\AzSubscription::where('status', 'finished')->count() }}
                                </span>
                                <p>
                                    @lang('messages.finished_restaurants')
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('seller_codes.index') }}"
                       class="nav-link {{ strpos(URL::current(), '/admin/seller_codes') !== false ? 'active' : '' }}">
                        <i class="nav-icon fa fa-code"></i>
                        <p>
                            @lang('messages.seller_codes')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('AzmakSetting') }}"
                       class="nav-link {{ strpos(URL::current(), '/admin/azmak_setting') !== false ? 'active' : '' }}">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p>
                            @lang('messages.azmak_setting')
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
