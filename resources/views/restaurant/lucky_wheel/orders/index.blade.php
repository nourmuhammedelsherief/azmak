@extends('restaurant.lteLayout.master')

@section('title')
    @lang('dashboard.lucky_wheel_orders')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <!-- Theme style -->
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.lucky_wheel_orders')</h1>
                </div>
                <!--<div class="col-sm-6">-->
                <!--    <ol class="breadcrumb float-sm-right">-->
                <!--        <li class="breadcrumb-item">-->
                <!--            <a href="{{ url('/restaurant/home') }}">-->
                <!--                @lang('messages.control_panel')-->
                <!--            </a>-->
                <!--        </li>-->
                <!--        <li class="breadcrumb-item active">-->
                <!--            <a href="{{ route('restaurant.lucky.order.index') }}"></a>-->
                <!--            @lang('dashboard.lucky_wheel_orders')-->
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
                <div class="actions mb-4">
                    <a href="{{ route('restaurant.lucky.order.index') }}" class="btn btn-info"
                        style="background-color:{{ $status == 'all' ? '#440044' : ';' }}">{{ trans('dashboard.all') }}  ( {{App\Models\LuckyOrder::where('restaurant_id' , $restaurant->id)->count() }} )</a>
                    <a href="{{ route('restaurant.lucky.order.index', 'new') }}" class="btn btn-info"
                        style="background-color:{{ $status == 'new' ? '#440044' : ';' }}">{{ trans('dashboard.new') }}   ( {{App\Models\LuckyOrder::where('restaurant_id' , $restaurant->id)->where('status' , 'new')->count() }} )</a>
                    <a href="{{ route('restaurant.lucky.order.index', 'completed') }}" class="btn btn-info"
                        style="background-color:{{ $status == 'completed' ? '#440044' : ';' }}">{{ trans('dashboard.completed') }}   ( {{App\Models\LuckyOrder::where('restaurant_id' , $restaurant->id)->where('status' , 'completed')->count() }} )</a>
                    <a href="{{ route('restaurant.lucky.order.index', 'canceled') }}" class="btn btn-info"
                        style="background-color:{{ $status == 'canceled' ? '#440044' : ';' }}">{{ trans('dashboard.canceled') }}   ( {{App\Models\LuckyOrder::where('restaurant_id' , $restaurant->id)->where('status' , 'canceled')->count() }} )</a>

                </div>
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
                                    <th> @lang('dashboard.prise_name') </th>
                                    <th> @lang('dashboard.branch') </th>
                                    <th> @lang('dashboard.client_name') </th>
                                    <th> @lang('dashboard.entry.phone') </th>
                                    <th> @lang('dashboard.type') </th>

                                    {{-- <th> @lang('dashboard.product_name_en') </th> --}}
                                    <th> @lang('dashboard.entry.status') </th>
                                    <th> @lang('dashboard.entry.created_at') </th>
                                    <th> @lang('messages.operations') </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($orders as $item)
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" value="1" />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td><?php echo $item->id ; ?></td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $item->item_name_ar }} </span> <br>
                                            <span class="badge badge-secondary">{{ $item->item_name_en }} </span>
                                        </td>
                                        <td>
                                            {{ app()->getLocale() == 'ar' ? $item->branch->name_ar : $item->branch->name_en }}
                                        </td>
                                        <td>{{ $item->user_name }}</td>
                                        <td>{{ $item->user_phone }}</td>
                                        <td>
                                            @if ($item->user_sex == 'male')
                                                <span class="badge badge-primary">{{ trans('dashboard.male') }}</span>
                                            @else
                                                <span class="badge badge-primary">{{ trans('dashboard.female') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 'new')
                                                <span class="badge badge-primary">{{ trans('dashboard.new') }}</span>
                                            @elseif($item->status == 'completed')
                                                <span class="badge badge-success">{{ trans('dashboard.completed') }}</span>
                                            @elseif($item->status == 'canceled')
                                                <span class="badge badge-danger">{{ trans('dashboard.canceled') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ date('Y-m-d h:i A', strtotime($item->created_at)) }}</td>
                                        <td class="text-center">
                                            @if ($item->status == 'new')
                                                <a class="btn btn-info"
                                                    href="{{ route('restaurant.lucky.order.status', [$item->id, 'accept']) }}">
                                                    <i class="fa fa-user-edit"></i> @lang('dashboard.accept')
                                                </a>
                                                <a class="btn btn-info"
                                                    href="{{ route('restaurant.lucky.order.status', [$item->id, 'reject']) }}">
                                                    <i class="fa fa-user-edit"></i> @lang('dashboard.reject')
                                                </a>
                                                <br>
                                            @endif

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
                        "/restaurant/lucky_wheel/order/delete/" + id;

                });

            });
        });
    </script>
@endsection
