@extends('restaurant.lteLayout.master')

@section('title')
    @lang('dashboard.waiting_settings')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <!-- Theme style -->
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.waiting_settings')</h1>
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

                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">
                        <form role="form" id="post-form" action="{{ route('restaurant.waiting.settings') }}"
                            method="post" enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{ Session::token() }}'>

                            <div class="card-body">
                                <p class="text-danger">{{ $errors->first() }}</p>
                                <div class="form-group" style="margin-bottom:30px;">

                                    <div id="barcode-svg"
                                        style="width: 240px;
                                height: 274px;
                                margin: auto;
                                padding: 20px;">
                                        <?php $name = $restaurant->name_barcode == null ? $restaurant->name_en : $restaurant->name_barcode; ?>
                                        {!! QrCode::size(200)->generate(route('createWaiting', $restaurant->id)) !!}
                                        <div class="description" style="margin-top:10px;">
                                            <img width="20px" height="20px" src="{{ asset('uploads/img/logo.png') }}">

                                            <p class="footer-copyright pb-3 mb-1 pt-0 mt-0 font-13 font-600"
                                                style="    text-align: center;font-size:12px;display:inline; margin-right:5px;">
                                                {{ trans('messages.made_love') }}
                                              
                                            </p>
                                        </div>
                                    </div>

                                    <h3 class="text-center" style="margin-top:10px;">
                                        <a href="#" id="printPage"
                                            class="printPage btn btn-info">@lang('messages.downloadQr')</a>
                                        <a href="{{ route('createWaiting', $restaurant->id) }}"
                                            target="__blank" id="" class=" btn btn-primary">@lang('messages.view_barcode')</a>
                                        {{--                            <a class="btn btn-primary" href="{{ URL::to('/hotel/create_pdf') }}"> @lang('messages.saveAsPdf')</a> --}}
                                    </h3>


                                </div>
                                @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first() }}</p>
                                @endif

                                <div class="form-group">

                                    <label class="control-label"> @lang('dashboard.enable_waiting') </label>

                                    <select name="enable_waiting" id="" class="form-control">

                                        <option value="true"
                                            {{ $restaurant->enable_waiting == 'true' ? 'selected' : '' }}>
                                            {{ trans('dashboard.yes') }}</option>

                                        <option
                                            value="false"{{ $restaurant->enable_waiting == 'false' ? 'selected' : '' }}>
                                            {{ trans('dashboard.no') }}</option>
                                    </select>


                                </div>
                                {{-- waiting_alert_type --}}
                                <div class="form-group">

                                    <label class="control-label"> @lang('dashboard.waiting_alert_type') </label>

                                    <select name="waiting_alert_type" id="" class="form-control select2">

                                        <option value="notification"
                                            {{ $restaurant->waiting_alert_type == 'notification' ? 'selected' : '' }}>
                                            {{ trans('dashboard.notification') }}</option>

                                        <option
                                            value="sms"{{ $restaurant->waiting_alert_type == 'sms' ? 'selected' : '' }}>
                                            {{ trans('dashboard.sms') }}</option>
                                    </select>

                                    <p class="text-mute sms-note display-none">{{ trans('dashboard.waiting_sms_setting_note') }}  <a href="{{route('restaurant.sms.settings')}}" target="__blank">{{ trans('dashboard.sms_settings') }}</a></p>
                                </div>
                                <div class="sms-settings">
                                    @include('restaurant.waiting.includes.sms_setting')
                                </div>
                                {{-- waiting_new_request --}}
                                <div class="form-group">

                                    <label class="control-label"> @lang('dashboard.waiting_new_request') </label>

                                    <select name="waiting_new_request[]" id="" class="form-control select2"
                                        multiple>

                                        <option value="client"
                                            {{ (is_array($restaurant->waiting_new_request) and in_array('client', $restaurant->waiting_new_request)) ? 'selected' : '' }}>
                                            {{ trans('dashboard.client') }}</option>

                                        <option
                                            value="dashboard"{{ (is_array($restaurant->waiting_new_request) and in_array('dashboard', $restaurant->waiting_new_request)) ? 'selected' : '' }}>
                                            {{ trans('dashboard.dashboard') }}</option>
                                    </select>


                                </div>
                                {{-- waiting_progress_time --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.waiting_progress_time') </label>

                                    <input type="number" name="waiting_progress_time" class="form-control"
                                        value="{{ $restaurant->waiting_progress_time }}">
                                </div>
                                {{-- waiting_max_new_request --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.waiting_max_new_request') </label>

                                    <input type="number" name="waiting_max_new_request" class="form-control"
                                        value="{{ $restaurant->waiting_max_new_request }}">
                                </div>
                                @if ($restaurant->ar == 'true')
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.waiting_privacy_ar') </label>
                                    <textarea class="textarea" name="waiting_privacy_ar" placeholder="@lang('dashboard.waiting_privacy_ar')"
                                        style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $restaurant->waiting_privacy_ar }}</textarea>
                                    @if ($errors->has('waiting_privacy_ar'))
                                        <span class="help-block">
                                            <strong
                                                style="color: red;">{{ $errors->first('waiting_privacy_ar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if ($restaurant->en == 'true')
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.waiting_privacy_en') </label>
                                    <textarea class="textarea" name="waiting_privacy_en" placeholder="@lang('dashboard.waiting_privacy_en')"
                                        style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $restaurant->waiting_privacy_en }}</textarea>
                                    @if ($errors->has('waiting_privacy_en'))
                                        <span class="help-block">
                                            <strong
                                                style="color: red;">{{ $errors->first('waiting_privacy_en') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endif

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                            </div>

                        </form>
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
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>
    <script src="{{ asset('dist/js/html2canvas.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('select[name=waiting_alert_type]').on('change' , function(){
                var tag = $(this);
                if(tag.val() == 'sms'){
                    $('.sms-note').fadeIn(500);
                    $('.sms-settings').fadeIn(500);
                }else{
                    $('.sms-note').fadeOut(500);
                    $('.sms-settings').fadeOut(500);
                }
            });
            $('select[name=waiting_alert_type]').trigger('change');
            $('.checkhidden').on('change', function() {
                var tag = $(this);
                console.log(typeof tag.val(), tag.val());
                if (tag.val() == 'false')
                    $(tag.data('target')).fadeOut(400);
                else
                    $(tag.data('target')).fadeIn(400);
            });
            $('.checkhidden').trigger('change');
            document.getElementById("printPage").addEventListener("click", function() {
                html2canvas(document.getElementById("barcode-svg")).then(function(canvas) {
                    var anchorTag = document.createElement("a");
                    document.body.appendChild(anchorTag);
                    // document.getElementById("previewImg").appendChild(canvas);
                    anchorTag.download = "{{ $name }} Contact Us Page.jpg";
                    anchorTag.href = canvas.toDataURL();
                    anchorTag.target = '_blank';
                    anchorTag.click();
                });
            });

        });
    </script>
@endsection
