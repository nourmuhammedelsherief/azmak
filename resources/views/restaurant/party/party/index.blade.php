@extends('restaurant.lteLayout.master')

@section('title')
    @lang('dashboard.parties')
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
                    <h1>@lang('dashboard.parties')</h1>
                </div>
                <!--<div class="col-sm-6">-->
                <!--    <ol class="breadcrumb float-sm-right">-->
                <!--        <li class="breadcrumb-item">-->
                <!--            <a href="{{ url('/restaurant/home') }}">-->
                <!--                @lang('messages.control_panel')-->
                <!--            </a>-->
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
                    <a href="{{ route('restaurant.party.create') }}" class="btn">
                        <i class="fa fa-plus"></i>
                        @lang('messages.add_new')
                    </a>
                </h3>
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-striped">
                            <thead>
                                <tr>


                                    <th> @lang('dashboard.entry.name') </th>
                                    <th> @lang('dashboard.branch') </th>
                                    <th> @lang('dashboard.days') </th>
                                    <th> @lang('dashboard.entry.price') </th>
                                    <th> @lang('dashboard.entry.created_at') </th>
                                    <th> @lang('messages.operations') </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($branches as $index => $item)
                                    <tr class="odd gradeX">


                                        <td>{{ $item->title }}</td>
                                        <td>{{ isset($item->branch->id) ? $item->branch->name : '' }}</td>

                                        <td>
                                            @php
                                                $tt = [];
                                            @endphp
                                            @foreach ($item->days as $t)
                                                @if (!in_array($t->date, $tt))
                                                    <span class="badge badge-secondary">{{ $t->date }}</span>
                                                    @php
                                                        $tt[] = $t->date;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ date('Y-m-d h:i A', strtotime($item->created_at)) }}</td>

                                        <td>
                                            <a href="{{ route('restaurant.party.edit', $item->id) }}"
                                                class=" btn btn-primary" data="{{ $item->id }}"
                                                data_name="{{ $item->name }}">
                                                <i class="fa fa-user-edit"></i>
                                            </a>
                                            @php
                                                $user = Auth::guard('restaurant')->user();
                                                $deletePermission = \App\Models\RestaurantPermission::whereRestaurantId($user->id)
                                                    ->wherePermissionId(7)
                                                    ->first();
                                            @endphp
                                            @if ($user->type == 'restaurant' or $deletePermission)
                                                <a class="delete_data btn btn-danger" data="{{ $item->id }}"
                                                    data_name="{{ $index + 1 }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endif

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
                order : [[4, 'desc']] ,
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

                    window.location.href = "{{ url('/') }}" + "/restaurant/party/delete/" +
                    id;

                });

            });
        });
    </script>
@endsection
