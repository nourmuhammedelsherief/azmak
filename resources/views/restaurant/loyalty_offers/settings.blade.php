@extends('restaurant.lteLayout.master')

@section('title')
    @lang('dashboard.loyalty_offer_settings')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <!-- Theme style -->
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.loyalty_offer_settings')</h1>
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
                        <form role="form" id="post-form" action="{{ route('restaurant.loyalty-offer.settings') }}"
                            method="post" enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{ Session::token() }}'>

                            <div class="card-body">
                                @if ($errors->any())
                                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                                @endif


                                <div class="form-group">

                                    <label class="control-label"> @lang('dashboard.enable_loyalty_offer') </label>

                                    <select name="enable_loyalty_offer" id="" class="form-control">

                                        <option value="false"{{ $restaurant->enable_loyalty_offer == 'false' ? 'selected' : '' }}>
                                            {{ trans('dashboard.no') }}</option>
                                        <option value="true" {{ $restaurant->enable_loyalty_offer == 'true' ? 'selected' : '' }}>
                                            {{ trans('dashboard.yes') }}</option>


                                    </select>


                                </div>


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
    <script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>
    <script src="{{ asset('dist/js/html2canvas.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.checkhidden').on('change', function() {
                var tag = $(this);
                console.log(typeof tag.val(), tag.val());
                if (tag.val() == 'false')
                    $(tag.data('target')).fadeOut(400);
                else
                    $(tag.data('target')).fadeIn(400);
            });


        });
    </script>
@endsection
