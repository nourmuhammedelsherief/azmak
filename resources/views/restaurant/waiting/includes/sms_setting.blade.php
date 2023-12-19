{{-- @if (!empty($restaurant->sms_method))
<div class="sms-balance">
	<h2 class="text-center mt-3 mb-3">{{ trans('dashboard._sms_method.' . $restaurant->sms_method) }}</h2>
	@if ($restaurant->sms_method == 'taqnyat')
		@if (isset($smsBalance['statusCode']) and $smsBalance['statusCode'] == 200)
			<p class="text-center alert alert-{{$smsBalance['accountStatus'] == 'active' ? 'info' : 'error'}}">{{ trans('dashboard.sms_taqnyat_success_balance'  , [
				'balance' => $smsBalance['balance']  , 
				'points' => $smsBalance['points']  , 
				"currency" => $smsBalance['currency'], 
				'expire' => $smsBalance['accountExpiryDate']  , 
			]) }}</p>
		@elseif(isset($smsBalance['message']) )
			<p class="text-center alert alert-error">{{$smsBalance['message']}}</p>
		@endif
	@endif
</div>
@endif --}}
<div class="card">
    <div class="card-header text-center">{{ trans('dashboard.sms_settings') }}</div>
    <div class="card-body">
        {{-- sms_method --}}
        <div class="form-group">
            <label class="control-label"> @lang('dashboard.entry.sms_method') </label>
            <select name="sms_method" id="sms_method" class="form-control select2" data-placeholder="اختر ">
                <option value="" disabled selected></option>
                <option value="taqnyat" {{ $restaurant->sms_method == 'taqnyat' ? 'selected' : '' }}>
                    {{ trans('dashboard._sms_method.taqnyat') }}</option>
            </select>
            @if ($errors->has('sms_method'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('sms_method') }}</strong>
                </span>
            @endif
        </div>

        {{-- sms_sender --}}
        <div class="form-group hide sms_sender">
            <label class="control-label"> @lang('dashboard.entry.sms_sender') </label>
            <input name="sms_sender" type="text" class="form-control" value="{{ $restaurant->sms_sender }}"
                placeholder="@lang('dashboard.entry.sms_sender')">
            @if ($errors->has('sms_sender'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('sms_sender') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group hide sms_token">
            <label class="control-label"> @lang('dashboard.entry.sms_token') </label>
            <input name="sms_token" type="text" class="form-control" value="{{ $restaurant->sms_token }}"
                placeholder="@lang('dashboard.entry.sms_token')">
            @if ($errors->has('sms_token'))
                <span class="help-block">
                    <strong style="color: red;">{{ $errors->first('sms_token') }}</strong>
                </span>
            @endif
        </div>

    </div>
</div>
