@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.control_panel')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{trans('messages.control_panel')}}</h1>
                </div><!-- /.col -->
                <!--<div class="col-sm-6">-->
                <!--    <ol class="breadcrumb float-sm-right">-->

                <!--        <li class="breadcrumb-item active">-->
            <!--            {{trans('messages.control_panel')}}-->
                <!--        </li>-->
                <!--    </ol>-->
                <!--</div><!- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    @include('flash::message')
    <!-- /.content-header -->
    @php
        $user = Auth::guard('restaurant')->user();
        $subscription = App\Models\AzSubscription::whereRestaurantId($user->id)->first();
    @endphp
    @if(auth('restaurant')->check() and $user->type == 'restaurant')
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <h3>
                    @lang('messages.welcome') {{app()->getLocale() == 'ar' ? $user->name_ar : $user->name_en}}
                </h3>
                <!-- /.row (main row) -->
                @if($subscription == null or ($subscription and $subscription->status == 'finished'))
                    <a href="{{route('AzmakSubscription' , $user->id)}}" class="btn btn-success"> active azmak </a>
                @endif
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    @else
        <h1>
            @lang('messages.welcome')
            {{$user->name_ar}}
        </h1>
    @endif
@endsection
