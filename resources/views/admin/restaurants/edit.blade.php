@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.edit') @lang('messages.restaurants')
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.edit') @lang('messages.restaurants') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/admin/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('restaurants' , 'active')}}">
                                @lang('messages.restaurants')
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
                            <h3 class="card-title">@lang('messages.edit') @lang('messages.restaurants') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('updateRestaurant' , $restaurant->id)}}" method="post"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{Session::token()}}'>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.az_payment_type') </label>
                                    <select name="a_z_orders_payment_type" class="form-control">
                                        <option selected disabled> @lang('messages.choose_one')</option>
                                        <option value="myFatoourah" {{$restaurant->a_z_orders_payment_type == 'myFatoourah' ? 'selected' : ''}}> @lang('messages.myFatoourah') </option>
                                        <option value="tap" {{$restaurant->a_z_orders_payment_type == 'tap' ? 'selected' : ''}}> @lang('messages.tap') </option>
                                        <option value="edfa" {{$restaurant->a_z_orders_payment_type == 'edfa' ? 'selected' : ''}}> @lang('messages.edfa') </option>
                                    </select>
                                    @if ($errors->has('a_z_orders_payment_type'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('a_z_orders_payment_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div id="myFatoourah" style="display: {{$restaurant->a_z_orders_payment_type == 'myFatoourah' ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.a_z_myFatoourah_token') </label>
                                       <input name="a_z_myFatoourah_token" value="{{$restaurant->a_z_myFatoourah_token}}" class="form-control"
                                       placeholder="@lang('messages.a_z_myFatoourah_token')">
                                        @if ($errors->has('a_z_myFatoourah_token'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('a_z_myFatoourah_token') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div id="tap" style="display: {{$restaurant->a_z_orders_payment_type == 'tap' ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.a_z_tap_token') </label>
                                        <input name="a_z_tap_token" value="{{$restaurant->a_z_tap_token}}" class="form-control"
                                               placeholder="@lang('messages.a_z_tap_token')">
                                        @if ($errors->has('a_z_tap_token'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('a_z_tap_token') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div id="edfa" style="display: {{$restaurant->a_z_orders_payment_type == 'edfa' ? 'block' : 'none'}}">
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.a_z_edfa_merchant') </label>
                                        <input name="a_z_edfa_merchant" value="{{$restaurant->a_z_edfa_merchant}}" class="form-control"
                                               placeholder="@lang('messages.a_z_edfa_merchant')">
                                        @if ($errors->has('a_z_edfa_merchant'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('a_z_edfa_merchant') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"> @lang('messages.a_z_edfa_password') </label>
                                        <input name="a_z_edfa_password" value="{{$restaurant->a_z_edfa_password}}" class="form-control"
                                               placeholder="@lang('messages.a_z_edfa_password')">
                                        @if ($errors->has('a_z_edfa_password'))
                                            <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('a_z_edfa_password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('messages.confirm')</button>
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
            $('select[name="a_z_orders_payment_type"]').on('change', function() {
                var id = $(this).val();
                if($(this).val() == 'myFatoourah'){
                    document.getElementById('myFatoourah').style.display = 'block';
                    document.getElementById('edfa').style.display = 'none';
                    document.getElementById('tap').style.display = 'none';
                }else if ($(this).val() == 'tap'){
                    document.getElementById('tap').style.display = 'block';
                    document.getElementById('myFatoourah').style.display = 'none';
                    document.getElementById('edfa').style.display = 'none';
                }else if($(this).val() == 'edfa')
                {
                    document.getElementById('edfa').style.display = 'block';
                    document.getElementById('tap').style.display = 'none';
                    document.getElementById('myFatoourah').style.display = 'none';
                }
            });
        });
    </script>
    <script>
        function showDiv(element) {
            if (element.value == 'online') {
                document.getElementById('hidden_div').style.display = element.value == 'online' ? 'block' : 'none';
            } else if (element.value == 'bank') {
                document.getElementById('hidden_div').style.display = element.value == 'bank' ? 'none' : 'none';
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            // $('select[name=country_id]').trigger('change');
            $(document).on('submit', 'form', function () {
                $('button').attr('disabled', 'disabled');
            });
        });
    </script>
@endsection
