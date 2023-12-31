@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.tables')
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
                    <h1>
                        @if ($service_id)
                            @if ($service_id == 9)
                                {{ app()->getLocale() == 'ar' ? 'طاولات الواتساب' : 'WhatsApp Tables' }}
                            @elseif($service_id == 10)
                                {{ app()->getLocale() == 'ar' ? 'طاولات كاشير إيزي منيو' : 'EasyMenu Tables' }}
                            @endif
                        @else
                            @lang('messages.tables')
                        @endif

                    </h1>
                </div>
                <!--<div class="col-sm-6">-->
                <!--    <ol class="breadcrumb float-sm-right">-->
                <!--        <li class="breadcrumb-item">-->
                <!--            <a href="{{ url('/restaurant/home') }}">-->
                <!--                @lang('messages.control_panel')-->
                <!--            </a>-->
                <!--        </li>-->
                <!--        <li class="breadcrumb-item active">-->
                <!--            <a href="{{ route('restaurant.waiter.tables.index') }}"></a>-->
                <!--            @lang('messages.tables')-->
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
                    <a href="{{ route('restaurant.waiter.tables.create') }}" class="btn">
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
                                    <th>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="group-checkable"
                                                data-set="#sample_1 .checkboxes" />
                                            <span></span>
                                        </label>
                                    </th>
                                    <th></th>
                                    <th> @lang('messages.branch') </th>
                                    <th> @lang('messages.name') </th>
                                    <th> @lang('messages.table_code') </th>

                                    <th> @lang('messages.barcode') </th>
                                    <th> @lang('messages.operations') </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($tables as $table)
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" value="1" />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td><?php echo ++$i; ?></td>
                                        <td>
                                            @if (isset($table->branch->id))
                                                {{ $table->branch->name }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ app()->getLocale() == 'ar' ? ($table->name_ar == null ? $table->name_en : $table->name_ar) : ($table->name_en == null ? $table->name_ar : $table->name_en) }}
                                        </td>
                                        <td>
                                            {{ $table->code }}
                                        </td>

                                        <td>
                                            <a href="{{ route('restaurant.waiter.tables.barcode', $table->id) }}"
                                                class="btn btn-info"> @lang('messages.show') </a>
                                        </td>
                                        <td>
                                            @if (isset($table->branch->id))
                                                @if ($table->branch->main == 'true')
                                                    <a class="btn btn-primary"
                                                        href="{{ route('sliverHomeTable', [$table->restaurant->name_barcode, $table->foodics_id != null ? $table->foodics_id : $table->name_barcode]) }}"
                                                        target="_blank">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @else
                                                    <a class="btn btn-primary"
                                                        href="{{ route('sliverHomeTableBranch', [$table->restaurant->name_barcode, $table->foodics_id != null ? $table->foodics_id : $table->name_barcode, $table->branch->name_barcode]) }}"
                                                        target="_blank">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @endif
                                            @endif

                                            <a class="btn btn-primary"
                                                href="{{ route('restaurant.waiter.tables.edit', $table->id) }}">
                                                <i class="fa fa-user-edit"></i>
                                            </a>

                                            <a class="delete_data btn btn-danger" data="{{ $table->id }}"
                                                data_name="{{ app()->getLocale() == 'ar' ? ($table->name_ar == null ? $table->name_en : $table->name_ar) : ($table->name_en == null ? $table->name_ar : $table->name_en) }}">
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
        {{ $tables->links() }}

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
                        "/restaurant/waiter/tables/delete/" + id;

                });

            });
        });
    </script>
@endsection
