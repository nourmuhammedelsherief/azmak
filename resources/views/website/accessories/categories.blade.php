<section
    class="splide my-1 main_dish"
    aria-label="Basic Structure Example">
    <div class="splide__track">
        <ul class="splide__list">
            @if($categories->count() > 0)
                @foreach($categories as $category)
                    @if($category->time == 'false')
                        <li class="splide__slide">
                            <div class="image">
                                <img src="{{asset('/uploads/menu_categories/' . $category->photo)}}" />
                            </div>
                            <h6 class="text-center my-2">
                                {{app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en}}
                            </h6>
                        </li>
                    @elseif($category->time == 'true' and check_time_between($category->start_at , $category->end_at))
                        <li class="splide__slide">
                            <div class="image">
                                <img src="{{asset('/uploads/menu_categories/' . $category->photo)}}" />
                            </div>
                            <h6 class="text-center my-2">
                                {{app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en}}
                            </h6>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</section>
