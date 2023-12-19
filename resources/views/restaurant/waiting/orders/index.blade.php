@extends('restaurant.lteLayout.master')

@section('title')
    @lang('dashboard.waiting_orders')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <!-- Theme style -->
    <style>
        .top-action {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.waiting_orders')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/restaurant/home') }}">
                                @lang('messages.control_panel')
                            </a>
                        </li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash::message')

    <section class="content">
        <div class="row">
            <div class="col-12">
                <h3>
                    @if (is_array(auth('restaurant')->user()->waiting_new_request) and
                            in_array('dashboard', auth('restaurant')->user()->waiting_new_request))
                        <a href="javascript:;" data-toggle="modal" data-target="#addOrder" class="btn btn-info">
                            <i class="fa fa-plus"></i>
                            @lang('messages.add_new')
                        </a>
                    @endif

                    <a href="javascript:;" data-toggle="modal" data-target="#receiveOrderModal" class="btn btn-info">
                        <i class="fa fa-plus"></i>
                        @lang('dashboard.receive_order')
                    </a>


                </h3>
                <div class="main-content">

                    @include('restaurant.waiting.orders.includes.order_table')

                </div>

            </div>
            <!-- /.col -->
        </div>


        <!-- /.row -->
    </section>


    <!-- Modal -->
    <div class="modal fade" id="addOrder" tabindex="-1" role="dialog" aria-labelledby="addOrderTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOrderTitle">{{ trans('dashboard.add_waiting_order') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('restaurant.waiting.order.store') }}" method="post" id="formAddOrder">
                        @csrf
                        <div class="row">
                            {{-- place --}}
                            <div class="form-group col-md-6">
                                <label class="control-label"> @lang('dashboard.place') </label>
                                <select name="place_id" id="" class="select2 form-control " required>
                                    @foreach ($places as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}
                                            ({{ $item->branch->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- name --}}
                            <div class="form-group col-md-6">
                                <label class="control-label"> @lang('dashboard.entry.name') </label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            {{-- phone --}}
                            <div class="form-group col-md-6">
                                <label class="control-label"> @lang('dashboard.entry.phone') </label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            {{-- email --}}
                            <div class="form-group col-md-6">
                                <label class="control-label"> @lang('dashboard.entry.email') </label>
                                <input type="text" name="email" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('dashboard.cancel') }}</button>
                    <button type="button" class="btn btn-primary save-add-order">{{ trans('dashboard.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="receiveOrderModal" tabindex="-1" role="dialog" aria-labelledby="receiveOrderModalTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiveOrderModalTitle">{{ trans('dashboard.receive_order') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('restaurant.waiting.order.receive') }}" method="post" id="formReceiveOrder">
                        @csrf
                        <div class="row">
                            {{-- place --}}
                            <div class="form-group col-md-12">
                                <label class="control-label"> @lang('dashboard.place') </label>
                                <select name="place_id" id="" class="select2 form-control " required>
                                    @foreach ($places as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}
                                            ({{ $item->branch->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('dashboard.cancel') }}</button>
                    <button type="button"
                        class="btn btn-primary save-receive-order">{{ trans('dashboard.save') }}</button>
                </div>
            </div>
        </div>
    </div>
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
                order: [
                    [0, 'desc']
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
        var newOrdersCount = {{ $newOrdersCount }};

        function get() {
            $.ajax({
                url: "{{ route('restaurant.waiting.order.index') }}?{{ request('page') > 0 ? 'page=' . request('page') . '&' : '' }}status={{ request('status') }}",
                method: "GET",
                headers: {
                    Accept: 'application/json'
                },
                success: function(json) {
                    console.log(json);
                    if (json.status) {
                        $('.main-content').html(json.view);
                        if (json.new_orders_count > newOrdersCount) {
                            newOrdersCount = json.new_orders_count;
                            toastr.info("{{ trans('dashboard.waiting_order_updated') }}");
                            var audio = new Audio(
                                '{{ asset('images/message-song.mp3') }}'
                            );
                            audio.play();
                        }
                        $("#example1").DataTable({
                            lengthMenu: [
                                [10, 25, 50, 100, -1],
                                [10, 25, 50, 100, 'All'],
                            ],
                            order: [
                                [0, 'desc']
                            ],
                        });
                    }

                },
                error: function(xhr) {},
            });
        }
        $(document).ready(function() {
            setInterval(() => {
                get();
            }, 3000);
            $('#formAddOrder').submit(function() {
                return false;
            });
            $('.save-add-order').on('click', function() {
                var form = $('#formAddOrder');
                var formData = new FormData(form[0]);
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    headers: {
                        Accept: 'application/json'
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(json) {
                        // console.log(json);
                        if (json.status) {
                            newOrdersCount += 1;
                            toastr.success(json.message);
                            $('#addOrder').modal('hide');
                            get();
                        } else {
                            toastr.error(json.message);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        toastr.error('البيانات غير صحيحة !!');
                    },
                });
            });
            $('body').on('click', '.complete-order', function() {
                var tag = $(this);
                console.log(tag.data());
                $.ajax({
                    url: "{{ route('restaurant.waiting.order.complete') }}",
                    method: "GET",
                    headers: {
                        Accept: 'application/json'
                    },
                    data: {
                        id: tag.data('id')
                    },
                    // beforeSend : function(){

                    // } , 
                    success: function(json) {
                        if (json.status) {
                            toastr.success(json.message);
                        } else {
                            toastr.warning(json.message);
                        }
                        get();
                    },
                    error: function(xhr) {
                        toastr.error('طلب غير صحيح');
                    }
                });
            });
            $('.save-receive-order').on('click', function() {
                var form = $('#formReceiveOrder');
                var formData = new FormData(form[0]);
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    headers: {
                        Accept: 'application/json'
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(json) {
                        console.log(json);
                        if (json.status) {
                            toastr.success(json.message);
                            $('#receiveOrderModal').modal('hide');
                            get();
                        } else {
                            toastr.info(json.message);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        toastr.error('البيانات غير صحيحة !!');
                    },
                });
            });
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
                        "/restaurant/waiting/order/delete/" + id;

                });

            });
        });
    </script>
@endsection
