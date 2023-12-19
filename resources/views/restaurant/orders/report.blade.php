@extends('restaurant.lteLayout.master')

@section('title')
    @lang('dashboard.order_report')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
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
            /* color: red !important; */
            font-family: 'Cairo', sans-serif;

        }

        .text-dark {
            font-family: 'Cairo', sans-serif;

        }

        /*.small-box:hover{*/
        /*                    background-color:#960082 !important;*/


        /*}*/
        form {
            margin-top: 20px;
            margin-bottom: 50px;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>

                        @lang('dashboard.order_report')


                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/restaurant/home') }}">
                                @lang('messages.control_panel')
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('restaurant.order.report') }}"></a>
                            @lang('dashboard.order_report')
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash::message')

    <section class="content">
        <form action="{{ url()->current() }}" method="get">

            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <label for="year">{{ trans('dashboard.year') }}</label>
                    <select name="year" id="year" class="form-control">
                        <option value="" >{{ trans('dashboard.all') }}</option>
                        @for ($i = intval(date('Y')); $i > 2015; $i--)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 col-sm-4">
                    <label for="month">{{ trans('dashboard.month') }}</label>
                    <select name="month" id="month" class="form-control">
                        <option value="" >{{ trans('dashboard.all') }}</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i > 9 ? $i : '0' . $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 col-sm-4">
                    <button type="submit" class="btn btn-primary"
                        style="margin-top:30px">{{ trans('dashboard.search') }}</button>
                </div>

            </div>
        </form>
        <div class="row">
            <div class="col-md-6 ">
                <a href="#">
                    <!-- small box -->
                    <div class="small-box">
                        <!--bg-success-->
                        <div class="inner">
                            <p>{{ trans('dashboard.total_order_total') }}</p>
                            <h3>
                                {{ $data['order_count']['total'] }}
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 ">
                <a href="#">
                    <!-- small box -->
                    <div class="small-box">
                        <!--bg-success-->
                        <div class="inner">
                            <p>{{ trans('dashboard.income_total') }}</p>
                            <h3>
                                {{ $data['income']['total'] }}
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-md-6 ">
                <a href="#">
                    <!-- small box -->
                    <div class="small-box">
                        <!--bg-success-->
                        <div class="inner">
                            <p>{{ trans('dashboard.total_order_today') }}</p>
                            <h3>
                                {{ $data['order_count']['today'] }}
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 ">
                <a href="#">
                    <!-- small box -->
                    <div class="small-box">
                        <!--bg-success-->
                        <div class="inner">
                            <p>{{ trans('dashboard.total_order_month') }}</p>
                            <h3>
                                {{ $data['order_count']['month'] }}
                            </h3>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 ">
                <a href="#">
                    <!-- small box -->
                    <div class="small-box">
                        <!--bg-success-->
                        <div class="inner">
                            <p>{{ trans('dashboard.income_today') }}</p>
                            <h3>
                                {{ $data['income']['today'] }}
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 ">
                <a href="#">
                    <!-- small box -->
                    <div class="small-box">
                        <!--bg-success-->
                        <div class="inner">
                            <p>{{ trans('dashboard.income_month') }}</p>
                            <h3>
                                {{ $data['income']['month'] }}
                            </h3>
                        </div>
                    </div>
                </a>
            </div>


            <!-- /.col -->
        </div>


        <!-- /.row -->
    </section>

    <!-- Modal -->
@endsection

@section('scripts')
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>
@endsection
