@extends('admin.lteLayout.master')

@section('title')
    @lang('messages.azmak_setting')
@endsection

@section('styles')

@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('messages.azmak_setting') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/admin/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('AzmakSetting')}}">
                                @lang('messages.azmak_setting')
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
                            <h3 class="card-title">@lang('messages.azmak_setting') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{route('AzmakSettingUpdate')}}"
                              method="post" enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{Session::token()}}'>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.az_subscription_type') </label>
                                    <select name="type" class="form-control">
                                        <option disabled selected> @lang('messages.choose_one') </option>
                                        <option value="free" {{$settings->subscription_type == 'free' ? 'selected' : ''}}> @lang('messages.free') </option>
                                        <option value="paid" {{$settings->subscription_type == 'paid' ? 'selected' : ''}}> @lang('messages.paid') </option>
                                    </select>
                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.subscription_amount') </label>
                                    <input name="subscription_amount" value="{{$settings->subscription_amount}}" type="number" class="form-control" placeholder="@lang('messages.subscription_amount')">
                                    @if ($errors->has('subscription_amount'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('subscription_amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.subscription_tax') </label>

                                    <div class="row">
                                        <div class="col-sm-10">
                                            <input name="tax" type="number" value="{{$settings->tax}}" class="form-control" placeholder="@lang('messages.subscription_tax')">
                                            @if ($errors->has('tax'))
                                                <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('tax') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <div class="col-sm-2">
                                            %
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.token_payment_type') </label>
                                    <select name="online_payment_type" class="form-control">
                                        <option disabled selected> @lang('messages.choose_one') </option>
                                        <option value="test" {{$settings->online_payment_type == 'test' ? 'selected' : ''}}> @lang('messages.test') </option>
                                        <option value="online" {{$settings->online_payment_type == 'online' ? 'selected' : ''}}> @lang('messages.online') </option>
                                    </select>
                                    @if ($errors->has('online_payment_type'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('online_payment_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.online_token') </label>
                                    <input name="online_token" value="{{$settings->online_token}}" type="text" class="form-control" placeholder="@lang('messages.online_token')">
                                    @if ($errors->has('online_token'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('online_token') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
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
