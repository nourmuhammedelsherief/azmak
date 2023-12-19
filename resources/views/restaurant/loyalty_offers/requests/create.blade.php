@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.add') @lang('dashboard.loyalty_requests')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> --}}
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.add') @lang('dashboard.loyalty_requests') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/restaurant/home') }}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('restaurant.loyalty-offer.request.index') }}">
                                @lang('dashboard.loyalty_requests')
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
                            <h3 class="card-title">@lang('messages.add') @lang('dashboard.loyalty_requests') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="post-form" action="{{ route('restaurant.loyalty-offer.request.store') }}"
                            method="post" enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{ Session::token() }}'>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.loyalty_offer_items') *</label>
                                    <select name="offer_id" class="form-control" required>
                                        <option disabled selected> @lang('messages.choose_one') </option>
                                        @foreach ($offers as $offer)
                                            <option value="{{ $offer->id }}">
                                                {{ $offer->branch->name }} - {{ $offer->required_quantity }}
                                                {{ $offer->product->name }} للحصول علي {{ $offer->prize }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('offer_id'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('offer_id') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.user_phone') *</label>
                                    <input name="user_phone" type="text" class="form-control"
                                        value="{{ old('user_phone') }}" placeholder="@lang('dashboard.user_phone')">
                                    @if ($errors->has('user_phone'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('user_phone') }}</strong>
                                        </span>
                                    @endif
                                    <p class="mt-2" id="user-hint" style="font-size:14px;"></p>
                                </div>
                                {{-- prize --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.quantity') *</label>
                                    <input name="quantity" type="text" class="form-control"
                                        value="{{ old('quantity') }}" placeholder="@lang('dashboard.quantity')">
                                    @if ($errors->has('quantity'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{-- cacher_name --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.cacher_name') </label>
                                    <input type="text" name="cacher_name" class="form-control"
                                        value="{{ old('cacher_name') }}">
                                    {{-- <select name="cacher_id" id="cacher_id" class="form-control select2">
                                        <option value="" selected disabled>اختر كاشير</option>
                                        @foreach ($cachers as $item)
                                            <option value="{{$item->id}}" {{old('cacher_id') == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                                        @endforeach
                                    </select> --}}
                                    @if ($errors->has('cacher_name'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('cacher_name') }}</strong>
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
@section('scripts')
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-fileinput.js') }}"></script>
    <script>
        var myTimeOut = null;
        $(document).ready(function() {

            $('select[name="branch_id"]').on('change', function() {
                var id = $(this).val();
                $.ajax({
                    url: "{{ route('restaurant.loyalty-offer.get-products') }}?id=" + id,
                    type: "GET",
                    dataType: "json",

                    success: function(data) {
                        console.log(data);
                        if (data.status == true) {
                            var content = '<option selected disabled>-- اختر --</option>';
                            $.each(data.products, function(k, product) {
                                content += '<option value="' + product.id + '">' +
                                    product.name + '</option>'
                            });
                            $('select[name=product_id]').html(content);
                            $('select[name=product_id]').select2();
                        } else {
                            toastr.error(data.message);
                            $('select[name=product_id]').html('');
                            $('select[name=product_id]').select2();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        toastr.error('Fail');
                    },
                });
            });

            $('input[name=user_phone]').on('keyup' , function(){
                var tag = $(this);
                if(myTimeOut){
                    clearTimeout(myTimeOut);
                }
                myTimeOut = setTimeout(() => {
                    $.ajax({
                        url : "{{route('restaurant.loyalty-offer.request.search-phone')}}" ,
                        method : 'GET' ,
                        data : {
                            phone : tag.val() ,
                        } ,
                        beforeSend : function(){
                            $('#user-hint').html('loading ...') ;
                            $('#user-hint').removeClass('text-danger' , 'text-primary');
                        },
                        success : function(json){
                            console.log(json);
                            if(json.status){
                                $('#user-hint').html(json.message) ;
                                $('#user-hint').addClass( 'text-primary');
                            }else{
                                $('#user-hint').html(json.error) ;
                                $('#user-hint').addClass( 'text-danger');
                            }
                        } ,
                        error : function(xhr){
                            console.log(xhr);

                        } ,
                    });

                }, 1000);
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
    </script>
    <script>
        $("#select-all").click(function() {
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
    </script>
@endsection
