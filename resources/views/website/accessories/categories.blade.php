<div class="card__container swiper">
    <div class="card__content">
        <div class="swiper-wrapper">
            @if($categories->count() > 0)
                @foreach($categories as $category)
                    @if($category->time == 'false')
                        <article class="card__article swiper-slide">
                            <div class="card__image {{$category->id == $category_id ? 'active_categery' : ''}}">
                                <a href="javascript:;" id="{{$category->id}}" class="category_item">
                                    <img src="{{asset('/uploads/menu_categories/' . $category->photo)}}" alt="image"
                                         width="200" height="200" class="card__img"/>
                                </a>
                            </div>

                            <div class="card__data">
                                <h3 class="card__name">
                                    <a href="javascript:;" id="{{$category->id}}" class="category_item">
                                        {{app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en}}
                                    </a>
                                </h3>
                            </div>
                        </article>
                    @elseif($category->time == 'true' and check_time_between($category->start_at , $category->end_at))
                        <article class="card__article swiper-slide">
                            <div class="card__image">
                                <a href="javascript:;" id="{{$category->id}}" class="category_item">
                                    <img src="{{asset('/uploads/menu_categories/' . $category->photo)}}" alt="image"
                                         class="card__img"/>
                                </a>
                            </div>

                            <div class="card__data">
                                <h3 class="card__name">
                                    <a href="javascript:;" id="{{$category->id}}" class="category_item">
                                        {{app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en}}
                                    </a>
                                </h3>
                            </div>
                        </article>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    <!-- Navigation buttons -->
    <div class="swiper-button-next">
        <i class="ri-arrow-right-s-line"></i>
    </div>

    <div class="swiper-button-prev">
        <i class="ri-arrow-left-s-line"></i>
    </div>

    <!-- Pagination -->
    <div class="swiper-pagination"></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('.category_item').on('click', function () {
            var id = $(this).attr('id');
            var url = '/restaurants/'+ '{{$restaurant->name_barcode}}' + '/' + '{{$branch->name_en}}' + '/' + id
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                data: {
                    is_category: true,
                },
                success: function (json) {
                    $('#restaurant-products').html(json.data.products);
                }
            });
        });
    });
</script>
