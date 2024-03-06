@extends('admin.lteLayout.master')
@section('title')
    @lang('messages.branches')
    @if ($status == 'active')
        @lang('messages.active_restaurants')
    @elseif($status == 'finished')
        @lang('messages.finished_restaurants')
    @elseif($status == 'less_30_day')
        @lang('messages.less_30_day')
    @elseif($status == 'archived')
        @lang('messages.archived')
    @elseif($status == 'tentativeA')
        @lang('messages.tentative_active')
    @elseif($status == 'tentative_finished')
        @lang('messages.tentative_finished')
    @endif
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <!-- Theme style -->
    <style>
        a i{
            color : var(--primary-color) !important;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('messages.branches')
                        @if ($status == 'active')
                            @lang('messages.active_restaurants')
                        @elseif($status == 'finished')
                            @lang('messages.finished_restaurants')
                        @elseif($status == 'less_30_day')
                            @lang('messages.less_30_day')
                        @elseif($status == 'archived')
                            @lang('messages.archived')
                        @elseif($status == 'tentativeA')
                            @lang('messages.tentative_active')
                        @elseif($status == 'tentative_finished')
                            @lang('messages.tentative_finished')
                        @endif
                    </h1>
                </div>
                <!--<div class="col-sm-6">-->
                <!--    <ol class="breadcrumb float-sm-right">-->
                <!--        <li class="breadcrumb-item">-->
                <!--            <a href="{{ url('/admin/home') }}">-->
                <!--                @lang('messages.control_panel')-->
                <!--            </a>-->
                <!--        </li>-->
                <!--        <li class="breadcrumb-item active">-->
                <!--            <a href="{{ route('branches', $status) }}">-->
                <!--                @lang('messages.branches')-->
                <!--                @if ($status == 'active')-->
                <!--                    @lang('messages.active_restaurants')-->
                <!--                @elseif($status == 'finished')-->
                <!--                    @lang('messages.finished_restaurants')-->
                <!--                @elseif($status == 'less_30_day')-->
                <!--                    @lang('messages.less_30_day')-->
                <!--                @elseif($status == 'archived')-->
                <!--                    @lang('messages.archived')-->
                <!--                @elseif($status == 'tentativeA')-->
                <!--                    @lang('messages.tentative_active')-->
                <!--                @elseif($status == 'tentative_finished')-->
                <!--                    @lang('messages.tentative_finished')-->
                <!--                @endif-->
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
                {{--                <h3> --}}
                {{--                    <a href="{{route('createRestaurant')}}" class="btn btn-info"> --}}
                {{--                        <i class="fa fa-plus"></i> --}}
                {{--                        @lang('messages.add_new') --}}
                {{--                    </a> --}}
                {{--                </h3> --}}
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
                                    <th>@lang('messages.name')</th>
                                    <th>@lang('messages.country')</th>
                                    <th>@lang('messages.restaurant')</th>
                                    <th>@lang('messages.register_date')</th>
                                    <th> {{ app()->getLocale() == 'ar' ? 'ايقاف المنيو' : 'stop menu' }} </th>
                                    <th>@lang('messages.views')</th>
                                    @if ($status == 'less_30_day')
                                        <th>{{ trans('dashboard.remaining_days') }}</th>
                                    @endif
                                    <th>@lang('messages.products')</th>
                                    <th>@lang('messages.link')</th>
                                    {{--                                <th>@lang('messages.histories')</th> --}}
                                    <th> الاشتراك</th>
                                    <th>@lang('messages.operations')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @php
                                    $now = Carbon\Carbon::parse(date('Y-m-d'));
                                @endphp
                                @foreach ($branches as $branch)
                                    <tr class="odd gradeX">
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" class="checkboxes" value="1" />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td><?php echo ++$i; ?></td>
                                        <td>
                                            @if (app()->getLocale() == 'ar')
                                                {{ $branch->name_ar }}
                                            @else
                                                {{ $branch->name_en }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($branch->country != null)
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $branch->country->name_ar }}
                                                @else
                                                    {{ $branch->country->name_en }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($branch->restaurant != null)
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $branch->restaurant->name_ar }}
                                                @else
                                                    {{ $branch->restaurant->name_en }}
                                                @endif
                                            @endif

                                            <br>

                                        </td>
                                        <td>
                                            {{ $branch->created_at->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            @if ($branch->stop_menu == 'true')
                                                <a href="{{ route('stopBranchMenu', [$branch->id, 'false']) }}"
                                                    class="btn btn-success"> @lang('messages.yes') </a>
                                            @else
                                                <a href="{{ route('stopBranchMenu', [$branch->id, 'true']) }}"
                                                    class="btn btn-danger"> @lang('messages.no') </a>
                                            @endif
                                        </td>
                                        <td> {{ $branch->views }} </td>
                                        @if ($status == 'less_30_day')
                                            <th>
                                                @php
                                                    if (
                                                        $sub = $branch
                                                            ->subscription()
                                                            ->where('status', 'active')
                                                            ->where('package_id', 1)
                                                            ->where('type', 'branch')
                                                            ->whereDate('end_at', '<=', now()->addDays(30))
                                                            ->orderBy('id', 'desc')
                                                            ->first()
                                                    ):
                                                        $end = Carbon\Carbon::parse($sub->end_at);
                                                        echo $now->diffInDays($end, false);
                                                    endif;

                                                @endphp
                                            </th>
                                        @endif
                                        <td> {{ $branch->products->count() }} </td>
                                        <td>
                                            @if ($branch->status != 'not_active')
                                                <?php $name = $branch->main == 'true' ? $branch->restaurant->name_barcode : ($branch->name_barcode == null ? $branch->name_en : $branch->name_barcode); ?>
                                                <a target="_blank"
                                                    href="{{ url('/restaurnt/' . $branch->restaurant->name_barcode . '/' . $name) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                              @endif

                                        </td>
                                        <td>
                                            <a href="{{ route('ControlBranchSubscription', $branch->id) }}"
                                                class="btn btn-warning"> تمديد</a>
                                            <a href="{{ route('getBranchPayment', [$branch->id, 'admin']) }}"
                                                class="btn btn-primary">
                                                @if ($status == 'tentativeA' or $status == 'tentative_finished')
                                                    تفعيل
                                                @else
                                                    تجديد
                                                @endif
                                            </a>
                                            <br>
                                            <br>
                                            <span class="badge badge-secondary">
                                                {{ trans('dashboard.subscription_expired_at') }} : <br><br>
                                                {{ (isset($branch->subscription->end_at) and !empty($branch->subscription->end_at)) ? date('Y-m-d', strtotime($branch->subscription->end_at)) : '' }}</span>
                                        </td>
                                        <td>
                                            @if ($branch->archive == 'true')
                                                <a class="btn btn-info"
                                                    href="{{ route('ArchiveBranch', [$branch->id, 'false']) }}">
                                                    @lang('messages.remove_archive')</a>
                                            @else
                                                <a class="btn btn-secondary"
                                                    href="{{ route('ArchiveBranch', [$branch->id, 'true']) }}">
                                                    @lang('messages.archive')</a>
                                            @endif

                                            <a class="btn btn-primary"
                                                href="{{ route('editRestaurantBranch', $branch->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @if (auth('admin')->check() and auth('admin')->user()->role == 'admin')
                                                <a class="delete_city btn btn-danger" data="{{ $branch->id }}"
                                                    data_name="{{ $branch->name_ar }}">
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
            var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');

            $('body').on('click', '.delete_city', function() {
                var id = $(this).attr('data');

                var swal_text = 'حذف ' + $(this).attr('data_name') + '؟';
                var swal_title = 'هل أنت متأكد من الحذف ؟';

                swal({
                    title: swal_title,
                    text: swal_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-warning",
                    confirmButtonText: "تأكيد",
                    cancelButtonText: "إغلاق",
                    closeOnConfirm: false
                }, function() {

                    {{-- var url = '{{ route("imageProductRemove", ":id") }}'; --}}

                    {{-- url = url.replace(':id', id); --}}

                    window.location.href = "{{ url('/') }}" + "/admin/branches/delete/" + id;
                });
            });
        });
    </script>
@endsection
<style>
    .delete_city i {
        color:white;
    }
</style>