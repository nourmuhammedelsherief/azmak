@extends('restaurant.lteLayout.master')

@section('title')
    @lang('dashboard.loyalty_offer_items')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <!-- Theme style -->
    <style>
        .row h3 .btn.btn-info{
            background-color: #17a2b8 !important;
        }
        .row h3 .btn.btn-primary{
            background-color: #007bff !important;
        }
    </style>
@endsection

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.loyalty_offer_items')</h1>
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
                <!--            @lang('dashboard.loyalty_offer_items')-->
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

                    <a href="{{ route('restaurant.loyalty-offer.item.create') }}" class="btn">
                        <i class="fa fa-plus"></i>
                        @lang('messages.add_new')
                    </a>
                    <br>
                    <br>
                    <a href="{{ route('restaurant.loyalty-offer.item.index') }}" class="btn btn-{{request('is_active') != 1 ? 'primary' : 'info'}}">
                        <i class="fa fa-list"></i>
                        @lang('dashboard.all')
                        ({{isset($offerCount) ? $offerCount : 0}})
                    </a>
                    <a href="{{ route('restaurant.loyalty-offer.item.index') }}?is_active=1" class="btn btn-{{request('is_active') == 1 ? 'primary' : 'info'}}">
                        <i class="fa fa-list"></i>
                        @lang('dashboard.loyalty_offer_available_now')
                        ({{isset($offerAvaliableCount) ? $offerAvaliableCount : 0}})
                    </a>
                </h3>
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="example1" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="group-checkable"
                                                data-set="#sample_1 .checkboxes" />
                                            <span></span>
                                        </label>
                                    </th>
                                    <th></th>
                                    <th> @lang('dashboard.branch') </th>
                                    <th> @lang('dashboard.product') </th>
                                    <th> @lang('dashboard.required_quantity_to_prize') </th>
                                    <th> @lang('dashboard.prize') </th>
                                    <th> @lang('dashboard.prize_delivered_count') </th>
                                    <th> @lang('dashboard.entry.status') </th>
                                    <th> @lang('dashboard.entry.start_date') </th>
                                    <th> @lang('dashboard.entry.end_date') </th>

                                    <th> @lang('messages.operations') </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($items as $item)
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" value="1" />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>
                                            {{ $item->id }}
                                        </td>
                                        <td>
                                            @if (isset($item->branch->id))
                                                {{ $item->branch->name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($item->product->id))
                                                <a href="{{ route('products.edit' , $item->product_id) }}">{{$item->product->name}}</a>
                                            @endif
                                        </td>
                                        <td>
                                            {{$item->required_quantity}}
                                        </td>
                                        <td>
                                            {{$item->prize}}
                                        </td>
                                        <td>
                                            {{$item->user_history_count}}
                                        </td>
                                        <td>
                                            @if ($item->status == 'true')
                                                <span class="badge badge-success">{{ trans('dashboard.yes') }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ trans('dashboard.no') }}</span>
                                            @endif

                                        </td>
                                        <td>
                                            {{ empty($item->start_date) ? '--' : date('Y-m-d h:i A' , strtotime($item->start_date)) }}
                                        </td>
                                        <td>
                                            {{ empty($item->end_date) ? '--' : date('Y-m-d h:i A' , strtotime($item->end_date)) }}
                                        </td>

                                        <td>
                                            <a class="btn btn-primary"
                                                href="{{ route('restaurant.loyalty-offer.item.edit', $item->id) }}">
                                                <i class="fa fa-user-edit"></i>
                                            </a>

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
                        "/restaurant/loyalty-offer/item/delete/" + id;

                });

            });
        });
    </script>
@endsection
