@extends('restaurant.lteLayout.master')

@section('title')
    @lang('dashboard.users_histroy')
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
                    <h1>@lang('dashboard.users_histroy')</h1>
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
                <!--            @lang('dashboard.users_histroy')-->
                <!--        </li>-->
                <!--    </ol>-->
                <!--</div>-->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash::message')

    <section class="content">
        @if($errors->any())
            <p class="text-danger">{{$errors->first()}}</p>
        @endif
        <div class="row">
            <div class="col-12">
                <h3>


                </h3>
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">

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


                                    <th> @lang('dashboard.user_phone') </th>

                                    <th> @lang('messages.operations') </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($items as $item)
                                    <tr class="odd gradeX">

                                        <td>
                                            {{ $item->user_phone }}
                                        </td>

                                        <td>
                                            <a href="{{url('restaurant/loyalty-offer/request?user_phone=' . $item->user_phone)}}" class=" btn btn-primary "
                                                style="color:white ;">
                                                {{ trans('dashboard.request_details') }}
                                            </a>
                                            <a href="{{url('restaurant/loyalty-offer/prize?user_phone=' . $item->user_phone)}}" class=" btn btn-primary "
                                            style="color:white ;">
                                            {{ trans('dashboard.prize_details') }}
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ trans('dashboard.send_prize') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('restaurant.loyalty-offer.prize.confirm') }}" method="post" id="prize-store">
                        @csrf
                        <input type="hidden" name="id" id="offer-prize-id" value="">
                        <div class="row">
                            <div class="col-12">
                                <label for="">{{ trans('dashboard.cacher_name') }}</label>
                                <input type="text" name="cacher_name" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('dashboard.close') }}</button>
                    <button type="submit" form="prize-store"
                        class="btn btn-primary">{{ trans('dashboard.save') }}</button>
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
                'order': [
                    [0, 'desc']
                ],
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
            $('body').on('click', '.send-prize', function() {
                var tag = $(this);
                $('#offer-prize-id').val(tag.data('id'));
                console.log('send- prize');
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
                        "/restaurant/loyalty-offer/prize/delete/" + id;

                });

            });
        });
    </script>
@endsection
