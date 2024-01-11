<div class="slider">
    <div
        id="carouselExampleControls"
        class="carousel slide"
        data-bs-ride="carousel"
    >
        <div class="carousel-inner">

            @if($sliders->count() > 0)
                @php
                    $FS = \App\Models\RestaurantSlider::whereRestaurantId($restaurant->id)
                     ->whereSliderType('home')
                     ->whereStop('false')
                     ->first();
                @endphp
                @foreach($sliders as $slider)
                    @if ($slider->type == 'youtube')
                        <iframe style="width:100%; height: 170px" class="close-menu"
                                src="https://www.youtube.com/embed/{{$slider->youtube}}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    @else
                        <div class="carousel-item {{$FS->id == $slider->id ? 'active' : ''}}">
                            <img src="{{asset('/uploads/sliders/' . $slider->photo)}}" height="170" class="d-block w-100" alt="..."/>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="carousel-item active">
                    <img src="{{asset('site/image/cover1.jpg')}}" class="d-block w-100" alt="..."/>
                </div>
                <div class="carousel-item">
                    <img src="{{asset('site/image/cover1.jpg')}}" class="d-block w-100" alt="..."/>
                </div>
            @endif
        </div>
        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExampleControls"
            data-bs-slide="prev"
        >
              <span
                  class="carousel-control-prev-icon"
                  aria-hidden="true"
              ></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExampleControls"
            data-bs-slide="next"
        >
              <span
                  class="carousel-control-next-icon"
                  aria-hidden="true"
              ></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
