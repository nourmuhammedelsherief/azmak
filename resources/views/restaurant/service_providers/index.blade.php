@extends('restaurant.lteLayout.master')

@section('title')
    @lang('dashboard.service_providers')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <!-- Theme style -->
    <style>
        .items {
            text-align: center;
        }

        .cat-item {
            display: inline-block;
            max-width: 330px;
            border: 1px solid #CCC;
            border-radius: 10px;
            box-shadow: 1px 1px 10px #CCC;
            transition: 0.5s;
            /* min-height: 500px; */
            justify-items: center;
            padding-top: 30px;
            padding-bottom: 30px;
            margin: 10px 10px;
        }

        .cat-item:hover {
            box-shadow: 1px 1px 10px #4a4a4a;
            transition: 0.s;
        }

        .image-preview {
            width: 100%;
            height: 300px;
            /* padding: 10px; */
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .image-preview img {
            width: 100%;
            border-radius: 3px;
            max-width: 300px;
            max-height: 300px;
        }

        .cat-item h5 {
            color: #4a4a4a;
            font-size: 1.4rem;
            font-weight: bold;
        }
        .cat-item .body-des {
            text-align: center;
            color: #4a4a4a;
            font-size:.8rem;
        }

        .cat-item .description {
            color: #4a4a4a;
            font-size: 1rem;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.service_providers')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/restaurant/home') }}">
                                @lang('messages.control_panel')
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('restaurant.service-provider.index') }}"></a>
                            @lang('dashboard.service_providers')
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

                </h3>
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">
                        <h3 class="mb-5 text-center">{{ $category->name }}
                        </h3>

                        <div class="items mt-5">
                            @if (count($users) > 0)
                                @foreach ($users as $item)
                                    <div class=" cat-item">
                                        <div class="container">
                                            <div class="image-preview">
                                                <img src="{{ asset($item->image_path) }}" alt="">
                                            </div>

                                            <h5 class="text-center">{{ $item->name }}</h5>
                                            <p class="body-des">
                                                <span><i class="fas fa-phone"></i> {{ $item->phone }}</span>
                                            </p>
                                            <p class="description">{{ $item->description }}</p>
                                        </div>

                                    </div>
                                @endforeach
                            @else
                                <p class="text-center mt-5 alert alert-danger">
                                    {{ trans('dashboard.error_service_provider_not_found') }}
                                </p>
                            @endif


                        </div>
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

                    window.location.href = "{{ url('/') }}" + "/restaurant/banks/delete/" +
                        id;

                });

            });
        });
    </script>
@endsection
