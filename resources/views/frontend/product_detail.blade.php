@extends('layouts.frontend_layout.frontend_design')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/jquery-ui-1.12.1.custom/jquery-ui.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/product_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/product_responsive.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/images-grid/images_grid.css') }}">
@endsection

@section('content')
    <!-- Single Product -->
	<div class="single_product">
		<div class="container">
			<div class="row" style="padding: 20px 0; background: #fff;">
				<!-- Images -->
				<div class="col-lg-1 order-lg-1 order-2">
					<ul class="image_list">
                        @if(file_exists('images/products/small/'.$product->image))
                        <li data-image="{{ asset('images/products/medium/'.$product->image) }}"><img src="{{ asset('images/products/small/'.$product->image) }}" alt=""></li>
                        @else
                        <li data-image="{{ asset('images/products/default/default.jpg') }}"><img src="{{ asset('images/products/default/default.jpg') }}" alt=""></li>
						@endif
						
						<!-- Product Galleries -->
						@php $dem_gallery = 1; @endphp
						@foreach($product->galleries as $gallery)
							@if($dem_gallery < 4)
								<li data-image="{{ asset('images/product_galleries/medium/'.$gallery->name) }}"><img src="{{ asset('images/product_galleries/small/'.$gallery->name) }}" alt=""></li>
							@elseif($dem_gallery == 4)
								<div id="imgs"></div>
							@endif
							@php $dem_gallery ++; @endphp
						@endforeach
					</ul>
				</div>
				<!-- Selected Image -->
				<div class="col-lg-4 order-lg-2 order-1">
				@if(file_exists('images/products/medium/'.$product->image))
					<div class="image_selected ">
						<img src="{{ asset('images/products/medium/'.$product->image) }}" alt="{{ $product->name }}">
					</div>
				@else
					<div class="image_selected"><img src="{{ asset('images/products/default/default.jpg') }}" alt="{{ $product->name }}"></div>
				@endif
				</div>
				<!-- Description -->
				<div class="col-lg-7 order-3">
					<div class="product_description">
						<div class="product_name">{{ $product->name }}</div>
						<div class="product_sku">SKU:{{ $firstAttribute->sku }}</div>
                        <hr>
                        <div class="product_price">{{ number_format($firstAttribute->price, 0, ',', '.') }} ₫</div>
                        <div class="price_saleoff">Tiết kiệm: <span>{{ ratioDiscountCalculator($firstAttribute->price, $product->price) }}%</span> ({{ number_format($product->price - $firstAttribute->price, 0, ',', '.') }} ₫)</div>
                        <div class="price_regular">Giá thị trường: {{ number_format($product->price, 0, ',', '.') }} ₫</div>
                        <hr>
                        <div class="product_text"><p>{!! $product->description !!}</p></div>
						<hr>
                        <div class="choose_attribute">
							<div class="stock_status mb-3" style="display: {{ ($firstAttribute->stock > 0 && $firstAttribute->stock <= 5)?'block':'none' }};">
								Chỉ còn {{ $firstAttribute->stock }} sản phẩm
							</div>
							<span>Chọn thuộc tính:</span>
                            @foreach($product->attributes as $attribute)
								@php $active = ($attribute->id == $firstAttribute->id) ? 'active' : ''; @endphp
                                <button type="button" data-attribute-id="{{ $attribute->id }}" class="btn btn-sm btn-outline-primary {{ $active }}">{{ $attribute->name }}</button>
                            @endforeach
						</div>
						
						<div class="order_info" style="display: {{ ($firstAttribute->stock == 0)?'none':'block' }};">
							<form class="form-inline" id="addToCardForm" name="addToCardForm" action="{{ route('post.add_item') }}" method="post">
								@csrf()
								<input type="hidden" name="product_id" value="{{ $product->id }}">
								<input type="hidden" name="attribute_id" value="{{ $firstAttribute->id }}">
								<div style="width: 60px;">
									<div class="form-group">
										<label for="soluong">Số lượng:</label>
									</div>
								</div>
								<div style="width: 40px;">
									<div class="form-group">
										<select class="form-control" id="exampleFormControlSelect1" name="quantity">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
								</div>
								<div style="width: 100px;">
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Chọn mua</button>
									</div>
								</div>
							</form>
						</div>
						<div class="order_chayhang" style="display: {{ ($firstAttribute->stock == 0)?'block':'none' }};">
							<div style="width: 100px;">
								<div class="form-group">
									<button type="button" class="btn btn-danger">Sản phẩm đã hết hàng</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Info -->
				<div class="col-lg-12 order-4 mt-5">
					<h3>Thông Tin Chi Tiết</h3>
					<div class="product_info">
						{!! $product->info !!}
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Related Products -->
	<div class="viewed">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="viewed_title_container">
						<h3 class="viewed_title">Sản Phẩm Thường Được Xem Cùng</h3>
						<div class="viewed_nav_container">
							<div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
							<div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
						</div>
					</div>
					<div class="viewed_slider_container">
						<!-- Recently Viewed Slider -->
						<div class="owl-carousel owl-theme viewed_slider">
							@foreach($relatedProducts as $related_product)
								@php
									$first_attribute = $related_product->attributes->first();
								@endphp
								<!-- Recently Viewed Item -->
								<div class="owl-item">
									<div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
										<div class="viewed_image">
											<a href="{{ renderProductDetailLink($related_product->url, $related_product->id) }}">
												@if(file_exists('images/products/small/'.$related_product->image))
													<img src="{{ asset('images/products/small/'.$related_product->image) }}" alt="{{ $related_product->name }}">
												@else
													<img src="{{ asset('images/products/default/default.jpg') }}" alt="{{ $related_product->name }}">
												@endif
											</a>
										</div>
										@if($first_attribute)
										<div class="viewed_content text-center">
											<div class="viewed_price">{{ number_format($first_attribute->price, 0, ',', '.') }} ₫<span>{{ number_format($related_product->price, 0, ',', '.') }} ₫</span></div>
											<div class="viewed_name"><a href="{{ renderProductDetailLink($related_product->url, $related_product->id) }}">{{ $related_product->name }}</a></div></span><span class="sale-tag sale-tag-square"></span>
										</div>
										<ul class="item_marks">
											<li class="item_mark item_discount">-{{ ratioDiscountCalculator($first_attribute->price, $related_product->price) }}%</li>
											<li class="item_mark item_new">new</li>
										</ul>
										@endif
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    @include('frontend.home_sections.brands')

    @include('frontend.home_sections.newsletter')

@endsection

@section('js')
<script src="{{ asset('frontend/plugins/Isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/plugins/jquery-ui-1.12.1.custom/jquery-ui.js') }}"></script>
<script src="{{ asset('frontend/plugins/parallax-js-master/parallax.min.js') }}"></script>
<script src="{{ asset('frontend/js/product_custom.js') }}"></script>
<script src="{{ asset('frontend/plugins/images-grid/images_grid.js') }}"></script>
<script>
	// When click choose_attribute button
	$( document ).ready(function() {
		$('.choose_attribute button').on('click', function(e){
			e.preventDefault();
			var _attributeId = $(this).data("attribute-id");
			$(this).addClass("active").siblings("button").removeClass("active");
			$('input[name="attribute_id"]').val(_attributeId);
			$.ajax({
				type: 'get',
				url: '{{ route("get.attribute") }}',
				data: {id:_attributeId},
				success: function(resp){
					$('.product_description .product_price').html(resp.price +' ₫');
					$('.product_description .price_saleoff').html('<div class="price_saleoff">Tiết kiệm: <span>'+resp.percent+'%</span> ('+resp.price_saleoff+')</div>');
					$('.product_description .product_sku').html('SKU:'+resp.sku);
					
					// Ẩn hiện nút "CHỌN MUA"
					if(resp.stock == 0){
						$(".order_info").hide();
						$(".order_chayhang").show();
					}else{
						$(".order_info").show();
						$(".order_chayhang").hide();
					}

					// Ẩn hiện thông báo gần hết hàng
					if(resp.stock > 0 && resp.stock <=5){
						$('.product_description .stock_status').html("Chỉ còn " + resp.stock + " sản phẩm");
						$(".stock_status").show();
					}else{
						$(".stock_status").hide();
					}
				}, error: function(){
					alert("Error");
				}
			});
		});
	});

	// Show popup galleries (imagesgridjs)
	$( document ).ready(function() {
		var images = [
            @foreach($product->galleries as $gallery)
				'{{ asset('images/product_galleries/medium/'.$gallery->name) }}',
            @endforeach
		];

        $(function() {
            $('#imgs').imagesGrid({
				images: images,
				cells: 1,
				loading: 'đang tải...',
				getViewAllText: function(imagesCount) {
					return 'Xem thêm ' + imagesCount + ' hình';
				}
            });
        });
	});

</script>
@endsection