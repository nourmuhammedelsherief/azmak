@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.control_panel')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{trans('messages.control_panel')}}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    @include('flash::message')
    <!-- /.content-header -->
    @php
        $user = Auth::guard('restaurant')->user();
        $subscription = App\Models\AzSubscription::whereRestaurantId($user->id)->first();
    @endphp
    @if(auth('restaurant')->check())
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <h3>
                    @lang('messages.welcome') {{app()->getLocale() == 'ar' ? $user->name_ar : $user->name_en}}
                </h3>
                <!-- /.row (main row) -->
                @if($subscription == null)
                    <a href="{{route('AzmakSubscription' , $user->id)}}" class="btn btn-success">
                        {{trans('messages.activeAzmak')}}
                    </a>
                @elseif($subscription and $subscription->status == 'finished')
                    <br>
                    <h4 style="color: red"> @lang('messages.finished_subscription') </h4>
                    <br>
                    <a href="{{route('AzmakSubscription' , $user->id)}}" class="btn btn-success">
                        {{trans('messages.activeAzmak')}}
                    </a>
                @elseif($subscription and $subscription->status == 'active' )
                    <h4 >@lang('messages.subscription_price') :
                        <span style="color: red">
                            {{$subscription->price}}
                            {{app()->getLocale() == 'ar' ? $subscription->restaurant->country->currency_ar : $subscription->restaurant->country->currency_en}}
                        </span>
                    </h4>
                    <h4 >@lang('messages.tax_value') :
                        <span style="color: red">
                            {{$subscription->tax_value}}
                            {{app()->getLocale() == 'ar' ? $subscription->restaurant->country->currency_ar : $subscription->restaurant->country->currency_en}}
                        </span>
                    </h4>
                    @if($subscription->discount_value)
                        <h4 >@lang('messages.discount_value') :
                            <span style="color: red">
                            {{$subscription->discount_value}}
                                {{app()->getLocale() == 'ar' ? $subscription->restaurant->country->currency_ar : $subscription->restaurant->country->currency_en}}
                        </span>
                        </h4>
                    @endif
                    @if($subscription->seller_code)
                        <h4 >@lang('messages.seller_code') :
                            <span style="color: red">
                            {{$subscription->seller_code->seller_name}}
                        </span>
                        </h4>
                    @endif
                    <h4 >@lang('messages.subscription_end_at') :
                        <span style="color: red">
                            {{$subscription->end_at->format('Y-m-d')}}
                        </span>
                    </h4>
                    <h4 class="text-center"></h4>
                @elseif($subscription and $subscription->status == 'free' )
                    <h4>
                        @lang('messages.subscription_type') :
                        <span style="color: red">@lang('messages.free_subscription')</span>
                    </h4>
                @endif
            </div><!-- /.container-fluid -->
        </section>
        <div class="col-sm-6">
            <form action="{{ route('RestaurantUpdateLogo') }}" class="form-horizontal"
                  method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group type_image ">
                    <label class="control-label col-md-3"> @lang('messages.photo') </label>
                    <div class="col-md-9">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                 style="width: 200px; height: 150px; border: 1px solid black;">
                                @if ($user->az_logo != null)
                                    <img src="{{ asset('/uploads/restaurants/logo/' . $user->az_logo) }}">
                                @endif
                            </div>
                            <div>
                                <span class="btn red btn-outline btn-file">
                                    <span class="fileinput-new btn btn-info"> @lang('messages.choose_photo') </span>
                                    <span class="fileinput-exists btn btn-primary"> @lang('messages.change')
                                    </span>
                                    <input type="file" name="logo">
                                </span>
                                <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                   data-dismiss="fileinput">
                                    @lang('messages.remove')
                                </a>
                            </div>
                        </div>
                        @if ($errors->has('logo'))
                            <span class="help-block">
                                <strong style="color: red;">{{ $errors->first('logo') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">@lang('messages.save')</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.content -->
    @endif
@endsection
@section('scripts')
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-fileinput.js') }}"></script>
@endsection

