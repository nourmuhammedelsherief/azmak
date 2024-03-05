@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.control_panel')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('messages.control_panel')</h1>
                </div>
                <!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                @if (auth('admin')->user()->role != 'developer' and auth('admin')->user()->role != 'customer_services')
                    <div class="col-lg-4 col-6">
                        <a href="{{ url('/admin/restaurants/active') }}">

                            <!-- small box -->
                            <div class="small-box">
                                <!--bg-success-->
                                <div class="inner">
                                    <p>@lang('messages.restaurants')</p>

                                    <h3>
                                        {{ \App\Models\Restaurant::where('archive', 'false')->where('status', 'active')->count() }}
                                    </h3>

                                </div>
                                <!--<div class="icon">-->
                                <!--    <i class="ion ion-person-add"></i>-->
                                <!--</div>-->

                            </div>
                        </a>

                    </div>
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <a href="{{ url('/admin/restaurants/InActive') }}">

                            <div class="small-box ">
                                <!--bg-blue-->
                                <div class="inner">
                                    <p>
                                        @lang('messages.restaurants') @lang('messages.restaurantsInActive')
                                    </p>
                                    <h3>
                                        {{ $restaurants = \App\Models\Restaurant::where('admin_activation', 'false')->count() }}
                                    </h3>


                                </div>


                            </div>
                        </a>

                    </div>
                    <div class="col-lg-4 col-6">
                        <a href="{{ url('/admin/restaurants/inComplete') }}">
                            <!-- small box -->
                            <div class="small-box ">
                                <!--bg-gray-->
                                <div class="inner">
                                    <p>
                                        @lang('messages.rest_inComplete')
                                    </p>
                                    <h3>
                                        {{ $restaurants = \App\Models\Restaurant::where('status', 'inComplete')->where('archive', 'false')->count() }}
                                    </h3>


                                </div>


                            </div>
                        </a>

                    </div>
                @endif

            <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
<style>
    .col-lg-4:hover {
        transtion: all 0.3s linear;
    }

    .col-lg-4:hover {
        /*background-color:red;*/
        transform: translateY(-0.5rem);
    }

    .inner h6 {
        /*background-color:blue;*/
        font-size: 0.9rem;
        font-weight: 400;
        font-family: 'Cairo', sans-serif;


    }

    .inner h3 {
        text-align: center;
        font-size: 1.8rem !important;
        font-family: 'Cairo', sans-serif;


    }

    a {
        color: black !important;
        font-family: 'Cairo', sans-serif;

    }

    a:hover {
        text-decoration: none !important;

    }

    .small-box {
        /*background-color:#960082 !important;*/
        height: 90%;
    }

    h1 {
        color: red !important;
        font-family: 'Cairo', sans-serif;

    }

    .text-dark {
        font-family: 'Cairo', sans-serif;

    }

    /*.small-box:hover{*/
    /*                    background-color:#960082 !important;*/


    /*}*/
</style>
