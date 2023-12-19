@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.add') @lang('messages.menu_categories')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
    <link href="{{ asset('admin') }}/bootstrap-fileinput/css/fileinput.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.add') @lang('messages.menu_categories') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/restaurant/home') }}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('menu_categories.index') }}">
                                @lang('messages.menu_categories')
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                @include('flash::message')
                <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">@lang('messages.add') @lang('messages.menu_categories') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('menu_categories.store') }}" method="post"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{ Session::token() }}'>
                            <input type="hidden" name="image_name" value="">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.branch') </label>
                                    <select name="branch_id[]" class="select2 form-control" required multiple>
                                        {{--                                        <option disabled selected> @lang('messages.choose_one') </option> --}}
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $branch->name_ar == null ? $branch->name_en : $branch->name_ar }}
                                                @else
                                                    {{ $branch->name_en == null ? $branch->name_ar : $branch->name_en }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('branch_id'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('branch_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                @if (Auth::guard('restaurant')->user()->ar == 'true')
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.name_ar') </label>
                                        <input name="name_ar" type="text" class="form-control"
                                               value="{{ old('name_ar') }}" placeholder="@lang('messages.name_ar')">
                                        @if ($errors->has('name_ar'))
                                            <span class="help-block">
                                                <strong style="color: red;">{{ $errors->first('name_ar') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                @if (Auth::guard('restaurant')->user()->en == 'true')
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.name_en') </label>
                                        <input name="name_en" type="text" class="form-control"
                                               value="{{ old('name_en') }}" placeholder="@lang('messages.name_en')">
                                        @if ($errors->has('name_en'))
                                            <span class="help-block">
                                                <strong style="color: red;">{{ $errors->first('name_en') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                @if (Auth::guard('restaurant')->user()->ar == 'true')
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.description_ar') </label>
                                        <textarea class="textarea" name="description_ar" placeholder="@lang('messages.description_ar')"
                                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                        @if ($errors->has('description_ar'))
                                            <span class="help-block">
                                                <strong style="color: red;">{{ $errors->first('description_ar') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                @if (Auth::guard('restaurant')->user()->en == 'true')
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.description_en') </label>
                                        <textarea class="textarea" name="description_en" placeholder="@lang('messages.description_en')"
                                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                        @if ($errors->has('description_en'))
                                            <span class="help-block">
                                                <strong style="color: red;">{{ $errors->first('description_en') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.posters') </label>
                                    <select name="poster_id" class="form-control" required>
                                        <option disabled selected> @lang('messages.choose_one') </option>
                                        <option value="" > @lang('messages.no_poster') </option>
                                        @foreach($posters as $poster)
                                            <option value="{{$poster->id}}">
                                                @if(app()->getLocale() == 'ar')
                                                    {{$poster->name_ar == null ? $poster->name_en : $poster->name_ar}}
                                                @else
                                                    {{$poster->name_en == null ? $poster->name_ar : $poster->name_en}}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('poster_id'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('poster_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.time_activation') </label>
                                    <input name="time" type="radio" onclick="javascript:yesnoCheck();" value="true"
                                           placeholder="@lang('messages.time')" id="noCheck"> @lang('messages.yes')
                                    <input name="time" onclick="javascript:yesnoCheck();" type="radio" value="false"
                                           placeholder="@lang('messages.time')" id="yesCheck"> @lang('messages.no')
                                    @if ($errors->has('time'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('time') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div id="ifYes" style="display:none">
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.start_at') </label>
                                            <input name="start_at" type="time" class="form-control"
                                                   value="{{ old('start_at') }}" placeholder="@lang('messages.start_at')">
                                            @if ($errors->has('start_at'))
                                                <span class="help-block">
                                                    <strong style="color: red;">{{ $errors->first('start_at') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"> @lang('messages.end_at') </label>
                                            <input name="end_at" type="time" class="form-control"
                                                   value="{{ old('end_at') }}" placeholder="@lang('messages.end_at')">
                                            @if ($errors->has('end_at'))
                                                <span class="help-block">
                                                    <strong style="color: red;">{{ $errors->first('end_at') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <label class="control-label"> @lang('messages.days') </label>
                                        <br>
                                        <input id="select-all" type="checkbox"><label for='select-all'>
                                            {{ app()->getLocale() == 'ar' ? 'اختيار الكل' : 'Choose All' }}</label>
                                        <br>

                                        <?php $days = \App\Models\Day::all(); ?>
                                        @foreach ($days as $day)
                                            <input type="checkbox" name="day_id[]" value="{{ $day->id }}">
                                            {{ app()->getLocale() == 'ar' ? $day->name_ar : $day->name_en }}
                                        @endforeach
                                        @if ($errors->has('day_id'))
                                            <span class="help-block">
                                                <strong style="color: red;">{{ $errors->first('day_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- image --}}
                                <div class="image-editor-preview ">
                                    <div class="col-md-12">
                                        <span class="fileinput-new"> {{ trans('messages.photo') }}</span>
                                        <br>
                                        <div dir=rtl class="file-loading">
                                            <input type="file" name="photo" id="normal-image"
                                                   accept=".png,.jpg,.jpeg" class="file" data-browse-on-zone-click="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading">{{ trans('dashboard.explain') }}</h4>
                                <p>{{ trans('dashboard.image_warning_size', ['size' => 'الطول يساوي العرض ']) }}</p>
                                <hr>
                                <p class="mb-0">{!! trans('dashboard.image_resize_hint') !!}
                                    <a href="https://redketchup.io/image-resizer" target="__blank"
                                       style="color : #007bff;" title="موقع لتغير حجم الصور"> موقع لتغير حجم الصور</a>
                                </p>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    @php
        // $itemId = $product->id ;
        $imageUploaderUrl = route('restaurant.menu_category.update_image');
    @endphp
    @include('restaurant.products.product_image_modal')
@endsection
@section('scripts')
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-fileinput.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.js') }}"></script>


    <script src="{{ asset('admin') }}/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
    <script src="{{ asset('admin/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('admin/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('admin/bootstrap-fileinput/js/plugins/purify.min.js') }}"></script>
    <script src="{{ asset('admin/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('admin/bootstrap-fileinput/themes/fa/theme.js') }}"></script>

    <script src="{{ asset('admin/bootstrap-fileinput/locales/ar.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2({
                language: "{{ app()->getLocale() }}",
                dir: "{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
            });
        });
    </script>
    <script type="text/javascript">
        function yesnoCheck() {
            if (document.getElementById('yesCheck').checked) {
                document.getElementById('ifYes').style.display = 'none';
            } else {
                document.getElementById('ifYes').style.display = 'block';
            }
        }
        $("#normal-image").fileinput({
            uploadUrl: "{{ route('restaurant.menu_category.update_image') }}",
            // enableResumableUpload: true,
            resumableUploadOptions: {
                // uncomment below if you wish to test the file for previous partial uploaded chunks
                // to the server and resume uploads from that point afterwards
                // testUrl: "http://localhost/test-upload.php"
            },
            uploadExtraData: {
                '_token': '{{ csrf_token() }}', // for access control / security 
                'action': 'create',

            },
            rtl: false,
            language: 'ar',
            maxFileCount: 1,
            allowedFileTypes: ['image'],
            allowedFileExtensions: ['image'],
            showCancel: true,
            showRemove: true,
            showUpload: true,
            showCancel: true,

            maxFilePreviewSize: 50240,
            initialPreviewAsData: true,
            overwriteInitial: true,

            initialPreviewAsData: true,
            initialPreviewFileType: 'image',


            theme: 'fa',
            // deleteUrl: "http://localhost/file-delete.php"
        }).on('fileuploaded', function(event, previewId, index, fileId) {
            var response = previewId.response;
            console.log(response);
            if (response.status == true) {
                $('input[name=image_name]').val(response.photo);
            }
        }).on('fileuploaderror', function(event, data, msg) {
            // console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
            console.log(msg);
            console.log(data);
        }).on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) {
            console.log('completed');
        });
    </script>
    <script>
        $("#select-all").click(function() {
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
    </script>
@endsection
