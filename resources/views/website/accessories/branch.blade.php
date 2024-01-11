<div>
    <button
        class="btn btn_custom"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasBottom"
        aria-controls="offcanvasBottom"
    >
        @lang('messages.change_branch')
    </button>

    <div
        class="offcanvas offcanvas-bottom"
        tabindex="-1"
        id="offcanvasBottom"
        aria-labelledby="offcanvasBottomLabel"
    >
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel">
                @lang('messages.choose_branch')
            </h5>
            <button
                type="button"
                class="btn-close text-reset"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
            ></button>
        </div>
        <div class="offcanvas-body small">
            <form method="get" action="{{route('homeBranch' , $restaurant->name_barcode)}}">
                @csrf
                @foreach($branches as $zbranch)
                    <div>
                        <input
                            type="radio"
                            id="city{{$zbranch->id}}"
                            name="branch"
                            value="{{$zbranch->id}}"
                        />
                        <label for="city{{$zbranch->id}}">
                            {{app()->getLocale() == 'ar' ? $zbranch->name_ar : $zbranch->name_en}}
                        </label>
                    </div>
                    <hr/>
                @endforeach
                <input type="submit" value="@lang('messages.change')"/>
            </form>
        </div>
    </div>
</div>
