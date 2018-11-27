<!-- Deals of the week -->
<div class="deals_featured">
	<div class="container">
		<div class="row">
            <div class="col-lg-12" style="z-index:1;">
                <!-- Deals featured title -->
                <div class="deals_featured_title">
                    Deal Chớp Nhoáng
                </div>
                <!-- Product Panel -->
                <div class="product_panel panel active">
                    <div class="arrivals_slider slider">
                        @foreach($newProducts as $product)
                        @php
                            $first_attribute = $product->attributes->first();
                        @endphp
                        <!-- Slider Item -->

                        <div class="arrivals_slider_item">
                            <div class="product_item discount d-flex flex-column align-items-center justify-content-center">
                            <a href="{{ renderProductDetailLink($product->url, $product->id) }}">
                                @if(file_exists('images/products/small/'.$product->image))
                                    <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset('images/products/small/'.$product->image) }}" alt="{{ $product->name }}"></div>
                                @else
                                    <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset('images/products/default/default.jpg') }}" alt="{{ $product->name }}"></div>
                                @endif
                            </a>
                                <div class="product_content">
                                    <div class="product_name"><div><a href="{{ renderProductDetailLink($product->url, $product->id) }}">{{ $product->name }}</a></div></div>
                                    <div class="product_price">
                                        @if($first_attribute)
                                            {{ number_format($first_attribute->price, 0, ',', '.') }} ₫ <span class="price-regular">{{ number_format($product->price, 0, ',', '.') }} ₫</span><span class="sale-tag sale-tag-square">-{{ ratioDiscountCalculator($first_attribute->price, $product->price) }}%</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="product_fav"><i class="fas fa-heart"></i></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="arrivals_slider_dots_cover"></div>
                </div>
            </div>
		</div>
	</div>		
</div>