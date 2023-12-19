@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.restaurant_control_panel')
@endsection
@section('style')
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

        section.request-chart {
            margin-top: 100px;

        }

        .chart-container {
            width: 100%;
            padding-bottom: 30px;
            overflow-x: auto;
        }

        .chart-container>div {
            min-width: 700px;
        }

        .total-all {
            margin-top: 30px;
        }
    </style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ trans('messages.control_panel') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @php
        $user = Auth::guard('restaurant')->user();
        $totalAll = 0;
        foreach ($requestChartData as $item):
            $totalAll += $item->row_count;
        endforeach;
    @endphp
    @if (auth('restaurant')->check() and $user->type == 'restaurant')
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Main row -->
                <section class="request-chart">
                    <div class="form-data mb-5">
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">{{ trans('dashboard.type') }}</label>
                                    <select name="type" id="type" class="select2 form-control">
                                        <option value="easymenu" {{ request('type') == 'easymenu' ? 'selected' : '' }}>
                                            {{ trans('dashboard.reports_menu') }}</option>
                                        <option value="category_more"
                                            {{ request('type') == 'category_more' ? 'selected' : '' }}>
                                            {{ trans('dashboard.reports_category_more') }}</option>
                                        <option value="category_less"
                                            {{ request('type') == 'category_less' ? 'selected' : '' }}>
                                            {{ trans('dashboard.reports_category_less') }}</option>

                                            <option value="product_more"
                                            {{ request('type') == 'product_more' ? 'selected' : '' }}>
                                            {{ trans('dashboard.reports_product_more') }}</option>
                                            <option value="product_less"
                                            {{ request('type') == 'product_less' ? 'selected' : '' }}>
                                            {{ trans('dashboard.reports_product_less') }}</option>

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">{{ trans('dashboard.period') }}</label>
                                    <select name="period" id="period" class="select2 form-control">
                                        <option value="60_min" {{ request('period') == '60_min' ? 'selected' : '' }}>
                                            {{ trans('dashboard.60_mins') }}</option>
                                        <option value="24h" {{ request('period') == '24h' ? 'selected' : '' }}>
                                            {{ trans('dashboard.24h') }}</option>
                                        <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>
                                            {{ trans('dashboard.7_day') }}</option>
                                        <option value="30_day" {{ request('period') == '30_day' ? 'selected' : '' }}>
                                            {{ trans('dashboard.30_day') }}</option>
                                        <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>
                                            {{ trans('dashboard.year') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"
                                        style="margin-top:30px;">{{ trans('dashboard.search') }}</button>
                                </div>
                            </div>
                        </form>

                        <div>
                            <h4 class="total-all">
                                {{ trans('dashboard.total_logs') }} : <span
                                    class="">{{ number_format($totalAll) }}</span>
                            </h4>
                        </div>
                    </div>
                    <div class="chart-container">
                        <div>
                            <canvas id="request-chart"></canvas>
                        </div>

                    </div>

                </section>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    @else
        <h1>
            @lang('messages.welcome')
            {{ $user->name_ar }}
        </h1>
    @endif
@endsection


@php
    if (in_array(request('type'), ['category_more', 'category_less', 'product_less', 'product_more'])) {
        if (request('period') == '60_min') {
            $chartLabel = trans('dashboard.60_mins');
        } elseif (request('period') == 'week') {
            $chartLabel = trans('dashboard.7_day');
        } elseif (request('period') == '24h') {
            $chartLabel = trans('dashboard.24h');
        } elseif (request('period') == 'year') {
            $chartLabel = trans('dashboard.year');
        } elseif (request('period') == '30_day') {
            $chartLabel = trans('dashboard.30_day');
        } else {
            $chartLabel = trans('dashboard.60_mins');
        }
    } else {
        if (request('period') == '60_min') {
            $chartLabel = trans('dashboard.60_mins') . ' (' . trans('dashboard.per_1_min') . ')';
        } elseif (request('period') == 'week') {
            $chartLabel = trans('dashboard.7_day') . ' (' . trans('dashboard.per_1_hour') . ')';
        } elseif (request('period') == '24h') {
            $chartLabel = trans('dashboard.24h') . ' (' . trans('dashboard.per_5_min') . ')';
        } elseif (request('period') == 'year') {
            $chartLabel = trans('dashboard.year') . ' (' . trans('dashboard.per_1_day') . ')';
        } elseif (request('period') == '30_day') {
            $chartLabel = trans('dashboard.30_day') . ' (' . trans('dashboard.per_1_hour') . ')';
        } else {
            $chartLabel = trans('dashboard.60_mins') . ' (' . trans('dashboard.per_1_min') . ')';
        }
    }

@endphp
@push('scripts')
    <script src="{{ asset('dist/js/chart.js') }}"></script>

    <script>
        $(function() {
            const requestChart = document.getElementById('request-chart');

            @if (in_array(request('type') , ['category_more' , 'category_less' , 'product_more' , 'product_less']))
                const requestChartData = [
                    @foreach ($requestChartData as $item)
                        {{ $item->row_count }},
                    @endforeach
                ];
                const requestChartLabels = [
                    @foreach ($requestChartData as $item)
                        "{{ app()->getLocale() == 'ar' ? $item->name_ar : $item->name_en }}",
                    @endforeach
                ];
                Chart.defaults.font.size = 16;
                Chart.defaults.font.weight = 'bold';
                Chart.defaults.font.family = "Cairo";
                var chart = new Chart(requestChart, {
                    type: 'bar',
                    data: {
                        datasets: [{
                            data: requestChartData,

                            label: "{{ $chartLabel }}",
                            borderColor: '#ff7675',
                            backgroundColor: '#ff76759e',
                            fill: true
                        }],
                        labels: requestChartLabels

                    },
                    options: {

                        plugins: {
                            filler: {
                                propagate: false,
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    font: {
                                        size: 20,
                                        weight: 'bold'
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: "{{ trans('dashboard.chart_requests') }}",
                                font: {
                                    size: 18
                                }
                            },
                            legend: {
                                labels: {
                                    font: {
                                        size: 20,
                                        weight: 'bold'
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                        },

                    },
                });
            @else
                Chart.defaults.font.weight = 'bold';
                Chart.defaults.font.family = "Cairo";
                const requestChartData = [
                    @foreach ($requestChartData as $item)
                        {{ $item->row_count }},
                    @endforeach
                ];
                const requestChartLabels = [
                    @foreach ($requestChartData as $item)
                        "{{ request('period') == 'year' ? carbon::parse($item->interval_start_datetime)->format('Y-m-d') : $item->interval_start_datetime }}",
                    @endforeach
                ];
                var chart = new Chart(requestChart, {
                    type: 'line',
                    data: {
                        datasets: [{
                            data: requestChartData,

                            label: "{{ $chartLabel }}",
                            borderColor: '#ff7675',
                            backgroundColor: '#ff76759e',
                            fill: true
                        }],
                        labels: requestChartLabels

                    },
                    options: {

                        plugins: {
                            filler: {
                                propagate: false,
                            },
                            title: {
                                display: true,
                                text: "{{ trans('dashboard.chart_requests') }}",
                                font: {
                                    size: 18
                                }
                            },
                            legend: {
                                labels: {
                                    font: {
                                        size: 18
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                        },

                    },
                });
            @endif


        });
    </script>
@endpush
