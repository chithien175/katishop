<!-- Banner -->

@php
    $banners = getAllBanners();
@endphp
@if($banners->count() > 0)
<div class="banner_2">
    <div class="banner_2_background" style="background-image:url({{ asset('frontend/images/banner_2_background.jpg')}} )"></div>
    <div class="banner_2_container">
        <div class="banner_2_dots"></div>
        <!-- Banner 2 Slider -->
        <div class="owl-carousel owl-theme banner_2_slider">
            @foreach($banners as $banner)
            <!-- Banner 2 Slider Item -->
            <div class="owl-item">
                <div class="banner_2_item">
                    <div class="container fill_height nopadding">
                        <div class="row fill_height">
                            <div class="banner_product_image"><img src="{{ asset('images/home_banners/'.$banner->image) }}" alt="{{ $banner->title }}"></div>
                            <div class="col-lg-5 offset-lg-4 fill_height">
                                <div class="banner_2_content">
                                    <div class="banner_2_title">{{ $banner->title }}</div>
                                    <div class="banner_2_text">{{ $banner->description }}</div>
                                    @if($banner->link)
                                    <div class="button banner_2_button"><a href="{{ $banner->link }}">Xem thêm</a></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>			
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif