@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.edit') @lang('messages.branches')
@endsection

@section('style')
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.edit') @lang('messages.branches') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/restaurant/home') }}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('branches.index') }}">
                                @lang('messages.branches')
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
                            <h3 class="card-title">@lang('messages.edit') @lang('messages.branches') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('branches.update', $branch->id) }}" method="post"
                            enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{ Session::token() }}'>

                            <div class="card-body">
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.name_ar') </label>
                                        <input name="name_ar" type="text" class="form-control"
                                            value="{{ $branch->name_ar }}" placeholder="@lang('messages.name_ar')">
                                        @if ($errors->has('name_ar'))
                                            <span class="help-block">
                                                <strong style="color: red;">{{ $errors->first('name_ar') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.name_en') </label>
                                    <input name="name_en" onkeypress="clsAlphaNoOnly(event)" onpaste="return false;" type="text" class="form-control" required
                                        value="{{ $branch->name_en }}" placeholder="@lang('messages.name_en') [format :  A-Za-z]">
                                    @if ($errors->has('name_en'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('name_en') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <!-- /.card-body -->
                                @method('PUT')
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                                </div>

                        </form>
                    </div>

                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('select[name="country_id"]').on('change', function() {
                var id = $(this).val();
                $.ajax({
                    url: '/get/cities/' + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('#register_city').empty();
                        // $('select[name="city_id"]').append("<option disabled selected> choose </option>");
                        // $('select[name="city"]').append('<option value>المدينة</option>');
                        $('select[name="city_id"]').append(
                            "<option disabled selected> @lang('messages.choose_one') </option>");
                        $.each(data, function(index, cities) {
                            console.log(cities);
                            @if (app()->getLocale() == 'ar')
                                $('select[name="city_id"]').append('<option value="' +
                                    cities.id + '">' + cities.name_ar + '</option>');
                            @else
                                $('select[name="city_id"]').append('<option value="' +
                                    cities.id + '">' + cities.name_en + '</option>');
                            @endif
                        });
                    }
                });
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

        function clsAlphaNoOnly (e) {  // Accept only alpha numerics, no special characters
            var regex = new RegExp("^[a-zA-Z0-9 ]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }

            e.preventDefault();
            return false;
        }
        function clsAlphaNoOnly2 () {  // Accept only alpha numerics, no special characters
            return clsAlphaNoOnly (this.event); // window.event
        }
    </script>
@endsection
