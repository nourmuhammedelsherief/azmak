@extends('restaurant.lteLayout.master')

@section('title')
    @lang('messages.add') @lang('dashboard.loyalty_offer_items')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />--}}
@endsection


@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> @lang('messages.add') @lang('dashboard.loyalty_offer_items') </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{url('/restaurant/home')}}">@lang('messages.control_panel')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{route('restaurant.loyalty-offer.item.index')}}">
                                @lang('dashboard.loyalty_offer_items')
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
                            <h3 class="card-title">@lang('messages.add') @lang('dashboard.loyalty_offer_items') </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="post-form" action="{{route('restaurant.loyalty-offer.item.update' , $item->id)}}" method="post"
                              enctype="multipart/form-data">
                            <input type='hidden' name='_token' value='{{Session::token()}}'>
                            @method('put')
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label"> @lang('messages.branches') *</label>
                                    <select name="branch_id" class="form-control" required>
                                        <option disabled selected> @lang('messages.choose_one') </option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}" {{$branch->id == $item->branch_id ? 'selected' : ''}}>
                                                {{app()->getLocale() == 'ar' ? $branch->name_ar:$branch->name_en}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('branch_id'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('branch_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{-- product --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.product') *</label>
                                    <select name="product_id" type="text" class="form-control select2" required
                                            >
                                           <option value="">اختر فرع اولا ..</option>
                                    </select>
                                    @if ($errors->has('product_id'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('product_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{-- required_quantity --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.required_quantity_to_prize') *</label>
                                    <input name="required_quantity" type="number" class="form-control"
                                           value="{{$item->required_quantity}}" placeholder="@lang('dashboard.required_quantity_to_prize')">
                                    @if ($errors->has('required_quantity'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('required_quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{-- prize --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.prize') *</label>
                                    <input name="prize" type="text" class="form-control"
                                           value="{{$item->prize}}" placeholder="@lang('dashboard.prize')">
                                    @if ($errors->has('prize'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('prize') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{-- status --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.entry.status') *</label>
                                    <select name="status" type="status" class="form-control"
                                           value="{{$item->status}}" placeholder="@lang('dashboard.entry.status')">
                                           <option value="true" {{$item->status == 'true' ? 'selected' : '' }}>{{ trans('dashboard.yes') }}</option>
                                           <option value="false" {{$item->status == 'false' ? 'selected' : '' }}>{{ trans('dashboard.no') }}</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{-- start_date --}}
                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.entry.start_date') </label>
                                    <input name="start_date" type="datetime-local" class="form-control"
                                           value="{{!empty($item->start_date) ? date('Y-m-d\TH:i' , strtotime($item->start_date)): ''}}" >
                                    @if ($errors->has('start_date'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('start_date') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="control-label"> @lang('dashboard.entry.end_date') </label>
                                    <input name="end_date" type="datetime-local" class="form-control"
                                    value="{{!empty($item->end_date) ? date('Y-m-d\TH:i' , strtotime($item->end_date)): ''}}" >
                                    @if ($errors->has('end_date'))
                                        <span class="help-block">
                                            <strong style="color: red;">{{ $errors->first('end_date') }}</strong>
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
        var selectedProduct = {{$item->product_id}};
        $(document).ready(function () {

            $('select[name="branch_id"]').on('change', function () {
                var id = $(this).val();
                $.ajax({
                    url: "{{route('restaurant.loyalty-offer.get-products')}}?id=" + id ,
                    type: "GET",
                    dataType: "json",

                    success: function (data) {
                        console.log(data);
                        if(data.status == true){
                            var content = '<option selected disabled>-- اختر --</option>';
                            $.each(data.products , function(k , product){
                                content += '<option value="'+product.id+'" '+(selectedProduct == product.id ? 'selected' : '')+'>'+product.name+'</option>'
                            });
                            $('select[name=product_id]').html(content);
                            $('select[name=product_id]').select2();
                        }else{
                            toastr.error(data.message);
                            $('select[name=product_id]').html('');
                            $('select[name=product_id]').select2();
                        }
                    },
                     error : function(xhr){
                        console.log(xhr);
                        toastr.error('Fail');
                     } ,
                });
            });
            $('select[name="branch_id"]').trigger('change');
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
        $("#select-all").click(function () {
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
    </script>
@endsection
