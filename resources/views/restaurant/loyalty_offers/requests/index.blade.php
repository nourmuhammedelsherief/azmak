@extends('restaurant.lteLayout.master')

@section('title')
    @lang('dashboard.loyalty_requests')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <!-- Theme style -->
    <style>
        .row h3 .btn.btn-info {
            background-color: #17a2b8 !important;
        }

        .row h3 .btn.btn-primary {
            background-color: #007bff !important;
        }

        form {
            margin-top: 20px;
            margin-bottom: 40px;
        }

        form button {
            margin-top: 30px;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.loyalty_requests')</h1>
                </div>
                <!--<div class="col-sm-6">-->
                <!--    <ol class="breadcrumb float-sm-right">-->
                <!--        <li class="breadcrumb-item">-->
                <!--            <a href="{{ url('/restaurant/home') }}">-->
                <!--                @lang('messages.control_panel')-->
                <!--            </a>-->
                <!--        </li>-->
                <!--        <li class="breadcrumb-item active">-->
                <!--            <a href="{{ route('restaurant.loyalty-offer.item.index') }}"></a>-->
                <!--            @lang('dashboard.loyalty_requests')-->
                <!--        </li>-->
                <!--    </ol>-->
                <!--</div>-->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash::message')

    <section class="content">
        <div class="row">
            <div class="col-12">
                <h3>

                    <a href="{{ route('restaurant.loyalty-offer.request.create') }}" class="btn">
                        <i class="fa fa-plus"></i>
                        @lang('messages.add_new')
                    </a>

                </h3>
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ url()->current() }}" method="get">
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <label for="">{{ trans('dashboard.offer_num') }}</label>
                                    <input type="text" name="offer_num" class="form-control"
                                        value="{{ request('offer_num') }}">
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <label for="">{{ trans('dashboard.user_phone') }}</label>
                                    <input type="text" name="user_phone" class="form-control"
                                        value="{{ request('user_phone') }}">
                                </div>

                                {{-- <div class="col-md-3 col-sm-6">
                                    <label for="">{{ trans('dashboard.entry.status') }}</label>
                                    <select name="status" id="status" class="form-control select2">
                                        <option value="">{{ trans('dashboard.all') }}</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            {{ trans('dashboard.pending') }}</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                            {{ trans('dashboard.completed') }}</option>
                                    </select>
                                </div> --}}

                                <div class="col-md-3 col-sm-6">

                                    <button type="submit" class="btn btn-primary">{{ trans('dashboard.search') }}</button>
                                </div>
                            </div>
                        </form>
                        <table id="example1" class="table table-striped">
                            <thead>
                                <tr>
                                    {{-- <th>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="group-checkable"
                                                data-set="#sample_1 .checkboxes" />
                                            <span></span>
                                        </label>
                                    </th> --}}
                                    <th></th>
                                    <th> @lang('dashboard.offer_num') </th>
                                    <th> @lang('dashboard.branch') </th>
                                    <th> @lang('dashboard.product') </th>
                                    <th> @lang('dashboard.quantity') </th>
                                    <th> @lang('dashboard.user_phone') </th>
                                    <th> @lang('dashboard.entry.type') </th>
                                    <th> @lang('dashboard.entry.status') </th>
                                    <th> @lang('dashboard.entry.created_at') </th>
                                    <th> @lang('messages.operations') </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($items as $item)
                                    <tr class="odd gradeX">
                                        {{-- <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" value="1" />
                                                <span></span>
                                            </label>
                                        </td> --}}
                                        <td>{{$item->id}}</td>
                                        <td>
                                            @if (isset($item->offer->id))
                                                <a
                                                    href="{{ route('restaurant.loyalty-offer.item.edit', $item->offer_id) }}">{{ $item->offer_id }}</a>
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($item->branch->id))
                                                {{ $item->branch->name }}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($item->product->id))
                                                <a
                                                    href="{{ route('products.edit', $item->product_id) }}">{{ $item->product->name }}</a>
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->quantity }}
                                        </td>
                                        <td>
                                            {{ $item->user_phone }}
                                        </td>
                                        <td>
                                            @if ($item->buy_type == 'cacher')
                                                <span class="badge badge-primary">{{ trans('dashboard.cacher') }}</span>

                                                <span class="mt-3 badge badge-secondary text-center">
                                                    {{ trans('dashboard.cacher_name') }}:
                                                    <br>
                                                    <br>
                                                    {{$item->cacher_name}}
                                                </span>
                                            @else
                                                <span class="badge badge-info">{{ trans('dashboard.client') }}</span>
                                            @endif


                                        </td>
                                        <td>
                                            @if ($item->status == 'completed')
                                                <span class="badge badge-success">{{ trans('dashboard.completed') }}</span>
                                            @elseif ($item->status == 'waiting_price')
                                                <span
                                                    class="badge badge-info">{{ trans('dashboard.waiting_prize') }}</span>
                                            @elseif ($item->status == 'confirmed')
                                                <span
                                                    class="badge badge-primary">{{ trans('dashboard.loyalty_offer_confirmed') }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ trans('dashboard.pending') }}</span>
                                            @endif

                                        </td>
                                        <td>
                                            {{ empty($item->created_at) ? '--' : date('Y-m-d h:i A', strtotime($item->created_at)) }}
                                        </td>
                                        <td>

                                            <a class="delete_data btn btn-danger" data="{{ $item->id }}"
                                                data_name="{{ $item->name }}">
                                                <i class="fa fa-trash"></i>
                                            </a>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                'order' : [[0 , 'desc']] ,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All'],
                ],
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '.delete_data', function() {
                var id = $(this).attr('data');
                var swal_text = '{{ trans('messages.delete') }} ' + $(this).attr('data_name');
                var swal_title = "{{ trans('messages.deleteSure') }}";

                swal({
                    title: swal_title,
                    text: swal_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-warning",
                    confirmButtonText: "{{ trans('messages.sure') }}",
                    cancelButtonText: "{{ trans('messages.close') }}"
                }, function() {

                    window.location.href = "{{ url('/') }}" +
                        "/restaurant/loyalty-offer/request/delete/" + id;

                });

            });
        });
    </script>
@endsection
