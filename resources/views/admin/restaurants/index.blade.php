@extends('admin.lteLayout.master')
@section('title')
    @lang('messages.restaurants')
    @if ($status == 'active')
        @lang('messages.active_restaurants')
    @elseif($status == 'tentative_finished')
        @lang('messages.tentative_finished')
    @elseif($status == 'finished')
        @lang('messages.finished_restaurants')
    @elseif($status == 'tentative_active')
        @lang('messages.tentative_active')
    @elseif($status == 'less_30_day')
        @lang('messages.less_30_day')
    @elseif($status == 'archived')
        @lang('messages.archived')
    @elseif($status == 'inComplete')
        @lang('messages.inComplete')
    @elseif($status == 'InActive')
        @lang('messages.restaurantsInActive')
    @elseif($status == 'categories')
        @lang('dashboard.category') : {{ isset($category->id) ? $category->name : '' }}
    @endif
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    {{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> --}}
    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> --}}
    {{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}
    <!-- Theme style -->
    <style>
        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 10px;
            font-size: 10px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 100px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 2px 3px;
            text-decoration: none;
            font-size: 10px;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }

        #example1_wrapper {
            overflow: auto;
        }

        .archive.btn {
            margin-bottom: 10px;
        }

        .archive.btn.archiveActive {
            background-color: #007bff;
            border-color: #007bff;
        }

        .control_progress {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            list-style: none;
        }

        .login_res {
            transition: all 0.3s linear;
            position: relative;
        }

        .login_res i {
            color: white !important;
        }

        .show_text {
            display: none;
            position: absolute;
            right: 0;
            z-index: 9999;
            background-color: #eeeeee;
            padding: 2px;

        }

        .login_res:hover .show_text {
            display: block;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('messages.restaurants')
                        @if ($status == 'active')
                            @lang('messages.active_restaurants')
                        @elseif($status == 'tentative_finished')
                            @lang('messages.tentative_finished')
                        @elseif($status == 'finished')
                            @lang('messages.finished_restaurants')
                        @elseif($status == 'tentative_active')
                            @lang('messages.tentative_active')
                        @elseif($status == 'less_30_day')
                            @lang('messages.less_30_day')
                        @elseif($status == 'archived')
                            @lang('messages.archived')
                        @elseif($status == 'inComplete')
                            @lang('messages.inComplete')
                        @elseif($status == 'InActive')
                            @lang('messages.restaurantsInActive')
                        @elseif($status == 'categories')
                            @lang('dashboard.category') : {{ isset($category->id) ? $category->name : '' }}
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
            <!--        @if (isset($category->id))-->
                <!--            / <li class="breadcrumb-item">-->
            <!--                <a href="{{ url('/admin/categories') }}">-->
            <!--                    @lang('dashboard.categories')-->
                <!--                </a>-->
                <!--            </li>-->
                <!--        @endif-->

                <!--        <li class="breadcrumb-item active">-->
                <!--            <a-->
            <!--                href="{{ route('restaurants', $status) }}{{ isset($category->id) ? '?category_id=' . $category->id : '' }}">-->
            <!--                @lang('messages.restaurants')-->
            <!--                @if ($status == 'active')-->
            <!--                    @lang('messages.active_restaurants')-->
            <!--                @elseif($status == 'tentative_finished')-->
            <!--                    @lang('messages.tentative_finished')-->
            <!--                @elseif($status == 'finished')-->
            <!--                    @lang('messages.finished_restaurants')-->
            <!--                @elseif($status == 'tentative_active')-->
            <!--                    @lang('messages.tentative_active')-->
            <!--                @elseif($status == 'less_30_day')-->
            <!--                    @lang('messages.less_30_day')-->
            <!--                @elseif($status == 'archived')-->
            <!--                    @lang('messages.archived')-->
            <!--                @elseif($status == 'inComplete')-->
            <!--                    @lang('messages.inComplete')-->
            <!--                @elseif($status == 'InActive')-->
            <!--                    @lang('messages.restaurantsInActive')-->
            <!--                @elseif($status == 'categories')-->
            <!--                    @lang('dashboard.category') : {{ isset($category->id) ? $category->name : '' }}-->
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
            @if ($status == 'archived')
                <div class="col-12">
                    @foreach ($archiveCategories as $item)
                        <a href="{{ route('restaurants' , 'archived') }}?archive_id={{$item->id}}"
                           class="btn  btn_archive archive {{request('archive_id') == $item->id ? 'archiveActive' : ''}}">
                            <i class="fa fa-filter"></i>
                            {{$item->name}} ({{$item->restaurants_count}})
                        </a>
                    @endforeach
                    <br>
                    <a href="{{ route('restaurants' , 'archived') }}?archive_id=-1"
                       class="btn btn_archive archive {{request('archive_id') == -1 ? 'archiveActive' : ''}}">
                        <i class="fa fa-filter"></i>
                        اخري
                    </a>
                </div>
            @endif
            <div class="col-12">
                @if ($status != 'archived')
                    <h3>
                        <a href="{{ route('createRestaurant') }}" class="btn">
                            <i class="fa fa-plus"></i>
                            @lang('messages.add_new')
                        </a>
                    </h3>
                @endif
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-striped" style="overflow: auto;">
                            <thead>
                            <tr>
                                <th>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="group-checkable"
                                               data-set="#sample_1 .checkboxes"/>
                                        <span></span>
                                    </label>
                                </th>
                                <th></th>
                                <th>@lang('messages.name')</th>
                                <th>@lang('messages.phone_number')</th>
                                <th>@lang('messages.country')</th>
                                @if ($status == 'archived')
                                    <th>@lang('messages.archive_category')</th>
                                    <th>تم الارشفة بواسطة</th>
                                @endif
                                <th>@lang('messages.restaurant')</th>
                                <th>@lang('messages.products')</th>
                                {{--                                <th>@lang('messages.orders')</th> --}}
                                {{--                                <th>{{app()->getLocale() == 'ar' ? 'طلبات فودكس' : 'Foodics Orders'}}</th> --}}
                                {{--                                <th>{{app()->getLocale() == 'ar' ? 'طلبات الواتساب' : 'Whatsapp Orders'}}</th> --}}
                                <th>@lang('messages.views')</th>
                                <th>{{ app()->getLocale() == 'ar' ? 'المشاهدات اليومية' : 'Daily Views' }}</th>
                                @if ($status == 'less_30_day')
                                    <th>{{ trans('dashboard.remaining_days') }}</th>
                                @endif
                                <th> {{ app()->getLocale() == 'ar' ? 'ايقاف المنيو' : 'stop menu' }} </th>

                                <th>{{ app()->getLocale() == 'ar' ? 'ملاحظات' : 'Notes' }}</th>
                                <th> @lang('messages.created_at') </th>
                                <th>@lang('messages.operations')</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                            @php
                                $now = Carbon\Carbon::parse(date('Y-m-d'));
                            @endphp
                            @foreach ($restaurants as $restaurant)
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" value="1"/>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td><?php echo ++$i; ?></td>
                                    <td>
                                        @if (app()->getLocale() == 'ar')
                                            {{ $restaurant->name_ar }}
                                        @else
                                            {{ $restaurant->name_en }}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $country = $restaurant->country->code;
                                            $check = substr($restaurant->phone_number, 0, 2) === '05';
                                            if ($check == true) {
                                                $phone = $country . ltrim($restaurant->phone_number, '0');
                                            } else {
                                                $phone = $country . $restaurant->phone_number;
                                            }
                                        @endphp
                                        @if ($restaurant->phone_number != null)
                                            <a target="_blank"
                                               href="https://api.whatsapp.com/send?phone={{ $phone }}">
                                                <i style="font-size:24px" class="fa">&#xf232;</i>
                                            </a>
                                            <a href="tel:{{ $phone }}">
                                                <i class="fa fa-phone"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($restaurant->country != null)
                                            @if (app()->getLocale() == 'ar')
                                                {{ $restaurant->country->name_ar }}
                                            @else
                                                {{ $restaurant->country->name_en }}
                                            @endif
                                        @endif
                                    </td>
                                    @if ($status == 'archived')
                                        <td>
                                            {{ isset($restaurant->archiveCategory->name) ? $restaurant->archiveCategory->name : $restaurant->archive_reason }}
                                        </td>
                                        <td>
                                            {{ isset($restaurant->archiveBy->name) ? $restaurant->archiveBy->name : '' }}
                                        </td>
                                    @endif
                                    <td>
                                        <a href="{{ url('/restaurants/' . $restaurant->name_barcode) }}"
                                           class="btn btn-primary"
                                           target="_blank">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $restaurant->products->count() }}
                                    </td>
                                    {{--                                    <td> --}}
                                    {{--                                        {{$restaurant->orders}} --}}
                                    {{--                                    </td> --}}
                                    {{--                                    <td> --}}
                                    {{--                                        {{$restaurant->foodics_orders}} --}}
                                    {{--                                    </td> --}}
                                    {{--                                    <td> --}}
                                    {{--                                        {{$restaurant->whatsapp_orders}} --}}
                                    {{--                                    </td> --}}
                                    <td>
                                        {{ $restaurant->views }}
                                    </td>
                                    <td>
                                        <?php $daily_views = \App\Models\RestaurantView::whereRestaurantId($restaurant->id)
                                            ->orderBy('id', 'desc')
                                            ->first(); ?>
                                        @if ($daily_views != null)
                                            {{ $daily_views->views }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    @if ($status == 'less_30_day')
                                        <th>
                                            @php
                                                if (
                                                    $sub = $restaurant
                                                        ->subscription()
                                                        ->where('status', 'active')
                                                        ->where('package_id', 1)
                                                        ->where('type', 'restaurant')
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
                                    <td>
                                        @if ($branch = $restaurant->branches()->where('main', 'true')->first())
                                            @if ($branch->stop_menu == 'true')
                                                <a href="{{ route('stopBranchMenu', [$branch->id, 'false']) }}"
                                                   class="btn btn-success"> @lang('messages.yes') </a>
                                            @else
                                                <a href="{{ route('stopBranchMenu', [$branch->id, 'true']) }}"
                                                   class="btn btn-danger"> @lang('messages.no') </a>
                                            @endif
                                        @endif
                                    </td>
                                    {{--                                    <td> --}}
                                    {{--                                        @if ($restaurant->subscription != null and isset($restaurant->subscription->package->id)) --}}
                                    {{--                                            {{app()->getLocale() == 'ar' ? $restaurant->subscription->package->name_ar : $restaurant->subscription->package->name_en}} --}}
                                    {{--                                        @endif --}}
                                    {{--                                    </td> --}}
                                    <td>
                                        <a href="{{ route('adminNote.index', $restaurant->id) }}"
                                           class="btn btn-secondary">
                                            {{ $restaurant->notes->count() }}
                                        </a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#modal-info-{{ $restaurant->id }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <div class="modal fade" id="modal-info-{{ $restaurant->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content bg-info">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">
                                                            @lang('messages.created_at')
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            @lang('messages.date') :
                                                            {{ $restaurant->created_at->format('Y-m-d') }}
                                                        </p>
                                                        <p>
                                                            {{ app()->getLocale() == 'ar' ? 'الوقت' : 'time' }} :
                                                            {{ $restaurant->created_at->format('H:i:s') }}
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-outline-light"
                                                                data-dismiss="modal">
                                                            @lang('messages.close')
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </td>
                                    <td class="control_progress">
                                        <!--<div class="dropdown">-->
                                        <!--    <button type="button" class="btn btn-primary dropbtn"-->
                                        <!--        data-toggle="dropdown">-->
                                    <!--        @lang('messages.operations')-->
                                        <!--        <span class="caret"></span></button>-->
                                        <!--<div class="dropdown-content">-->
                                        @if ($restaurant->archive == 'true')
                                            @if (in_array(auth('admin')->user()->role , ['sales' , 'admin']))
                                                <li class="login_res">
                                                    <a class="btn btn-info"
                                                       href="{{ route('ArchiveRestaurant', [$restaurant->id, 'false']) }}">
                                                        <i class="fa fa-file"></i>
                                                    </a>

                                                    <span class="show_text">                    @lang('messages.remove_archive')
                                                                                           </span>
                                                </li>
                                            @endif
                                        @else
                                            @if (in_array(auth('admin')->user()->role , ['sales' , 'admin']))
                                                <li class=login_res>
                                                    <a class="btn btn-archive btn-secondary" data-toggle="modal"
                                                       data-target="#formArchive" href="javascript:;"
                                                       data-category="{{ $restaurant->achive_category_id }}"
                                                       data-href="{{ route('ArchiveRestaurant', [$restaurant->id, 'true']) }}">
                                                        <i class="fa fa-file"></i>

                                                    </a>
                                                    <span class="show_text">
                                                                      @lang('messages.archive')
                                                                      </span>
                                                </li>
                                            @endif
                                        @endif
                                        @if ($restaurant->admin_activation == 'false')
                                            <li class="login_res">
                                                <a class="btn btn-primary"
                                                   href="{{ route('ActiveRestaurant', $restaurant->id) }}">
                                                    <i class="fa fa-chart-line"></i>

                                                </a>

                                                <span class="show_text">              @lang('messages.ActivateToTentative')  </span>

                                            </li>
                                        @endif

                                    <!--start login_res-->

                                        <li class="login_res">
                                            <a class="btn btn-warning" target="__blank"
                                               href="{{ route('admin.restaurant.login', [$restaurant->id, 'false']) }}">
                                                <i class="fa fa-user"></i>

                                            </a>
                                            <span class="show_text">            @lang('dashboard.login_to_restaurant')  </span>
                                        </li>
                                        <!--start login_res-->

                                        @if ($restaurant->status != 'inComplete')
                                            @if(auth()->guard('admin')->user()->role != 'customer_services')
                                                <li class="login_res">
                                                    <a class="btn btn-info"
                                                       href="{{ route('showRestaurant', $restaurant->id) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <span class="show_text">              @lang('messages.show')  </span>

                                                </li>
                                            @endif
                                        @endif
                                        @if ($restaurant->status == 'inComplete')
                                            <li class="login_res">
                                                <a class="btn btn-info"
                                                   href="{{ route('inCompleteRestaurant', $restaurant->id) }}">
                                                    <i class="fa fa-edit"></i>

                                                </a>

                                                <span class="show_text">               {{ app()->getLocale() == 'ar' ? 'أكمال التسجيل' : 'Complete Register' }} </span>
                                            </li>
                                        @else
                                            <li class="login_res">
                                                <a class="btn btn-primary"
                                                   href="{{ route('editRestaurant', $restaurant->id) }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <span class="show_text">              @lang('messages.edit')  </span>
                                            </li>
                                    @endif
                                    @if (auth('admin')->user()->role == 'admin')

                                        <!--start login res-->
                                            <li class="login_res">
                                                <a class="btn btn-success"
                                                   href="{{ route('admin.restaurant_history', $restaurant->id) }}">
                                                    <i class="fa fa-folder"></i>

                                                </a>
                                                <span class="show_text">
                                                                  @lang('messages.histories')
                                                              </span>
                                            </li>
                                            <li class="login_res">
                                                <a class="delete_city btn btn-danger"
                                                   data="{{ $restaurant->id }}"
                                                   data_name="{{ $restaurant->name_ar }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <span class="show_text">              @lang('messages.delete')  </span>
                                            </li>
                                    @endif
                                    <!--</div>-->
                                        <!--</div>-->

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $restaurants->links() }}
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- Modal -->
    <div class="modal fade" id="formArchive" tabindex="-1" role="dialog" aria-labelledby="formArchiveLabel"
         aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formArchiveLabel">{{ trans('messages.archive_reasons') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="get">


                    <div class="modal-body">
                        <div class="form-group">
                            <label for="archive-category">{{ trans('messages.archive_category') }}</label>
                            <select name="archive_category_id" id="archive-category" class="form-control select2">
                                <option value="" disabled selected>{{ trans('messages.choose') }}</option>
                                @php
                                    $archiveCategories = App\Models\ArchiveCategory::all();
                                @endphp
                                @foreach ($archiveCategories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                <option value="-1">اخري</option>
                            </select>
                        </div>

                        <div class="form-group archive_reason">
                            <label for="archive_reason">سبب الارشفة</label>
                            <input type="text" name="archive_reason" class="form-control" id="archive_reason">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('messages.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{--    <script src="{{asset('dist/js/adminlte.min.js')}}"></script> --}}
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>
    <script>
        $(function () {

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
        $(document).ready(function () {
            var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');

            $('body').on('click', '.delete_city', function () {
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
                }, function () {

                    {{-- var url = '{{ route("imageProductRemove", ":id") }}'; --}}

                            {{-- url = url.replace(':id', id); --}}

                        window.location.href = "{{ url('/') }}" + "/admin/restaurants/delete/" +
                        id;
                });
            });
            $('#formArchive').on('change', 'select', function () {
                var tag = $(this);
                if (tag.val() == -1) {
                    $('.archive_reason').fadeIn(300);
                } else {
                    $('.archive_reason').fadeOut(50);
                }
            });
            $('table').on('click', '.btn-archive', function () {
                var tag = $(this);
                console.log(tag.data('href'));
                $('#formArchive form').attr('action', tag.data('href'));
                $('#formArchive select').val('');
                $('#formArchive select').trigger('change');
            });
        });
    </script>
@endsection
<style>

    .content .btn_archive {
        color: white !important;
        background-color: #64748b !important;
        width: max-content;
        border-radius: 5px;
        font-family: 'cairo';

    }
</style>