@extends('restaurant.lteLayout.master')

@section('title')
     @lang('messages.azSubscription')
@endsection

@section('styles')
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.azSubscription') </h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> @lang('messages.azSubscription') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('AzmakPaymentMethod' , auth('restaurant')->user()->id) }}"
                              method="get"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{ Session::token() }}'>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.online_payment_type') </label>
                                    <select name="payment_type" class="form-control" required>
                                        <option disabled selected> @lang('messages.choose_one') </option>
                                        <option value="1"> @lang('messages.kent') </option>
                                        <option value="2"> @lang('messages.visa') </option>
                                        <option value="3"> @lang('messages.amex') </option>
                                        <option value="5"> @lang('messages.benefit') </option>
                                        <option value="6"> @lang('messages.mada') </option>
                                        <option value="11"> @lang('messages.apple_pay') </option>
                                        <option value="14"> @lang('messages.stc_pay') </option>
                                    </select>
                                    @if ($errors->has('payment_type'))
                                        <span class="help-block">
                                                <strong
                                                    style="color: red;">{{ $errors->first('payment_type') }}</strong>
                                            </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.seller_code') </label>
                                    <input type="text" name="seller_code" class="form-control"
                                           value="{{ old('seller_code') }}"
                                           placeholder="{{ app()->getLocale() == 'ar' ? 'أذا لديك كود خصم أكتبه هنا' : 'Put Your Seller Code Here' }}">
                                    @if ($errors->has('seller_code'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('seller_code') }}</strong>
                                        </span>
                                    @endif
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
@endsection
