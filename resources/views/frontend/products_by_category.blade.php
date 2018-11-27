@extends('layouts.frontend_layout.frontend_design')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/jquery-ui-1.12.1.custom/jquery-ui.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/shop_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/shop_responsive.css') }}">
@endsection

@section('content')


<!-- Shop -->
<div class="shop">
    <div class="container">
        <div class="row">
            <div class="col-lg-3" style="padding: 0 0 0 15px;">
                <!-- Shop Sidebar -->
                <div class="shop_sidebar">
                    <div class="sidebar_section">
                        <div class="sidebar_title">DANH MỤC SẢN PHẨM</div>
                        <ul class="sidebar_categories">
                            @foreach($parentCategories as $parent_category)
                                <li class="active"><a href="{{ route('get.products_by_category', $parent_category->url) }}">{{ $parent_category->name }}</a></li>
                                @foreach($parent_category->categories as $sub_cate)
                                    <li class="subcate {{ ($sub_cate->id == $category->id)?'active':'' }}"><a href="{{ route('get.products_by_category', $sub_cate->url) }}">{{ $sub_cate->name }} ({{ countProductsByCategoryId($sub_cate->id) }})</a></li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                    <div class="sidebar_section">
                        <div class="sidebar_subtitle brands_subtitle">THƯƠNG HIỆU</div>
                        <ul class="brands_list">
                            <li class="brand"><a href="#">Apple</a></li>
                            <li class="brand"><a href="#">Beoplay</a></li>
                            <li class="brand"><a href="#">Google</a></li>
                            <li class="brand"><a href="#">Meizu</a></li>
                            <li class="brand"><a href="#">OnePlus</a></li>
                            <li class="brand"><a href="#">Samsung</a></li>
                            <li class="brand"><a href="#">Sony</a></li>
                            <li class="brand"><a href="#">Xiaomi</a></li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="col-lg-9">
                <!-- Count products -->
                <div class="count-products-box">
                    <h1>
                        {{ $category->name }}:        
                    </h1>
                    <h4 class="results-count"> {{ countProductsByCategoryId($category->id) }} kết quả</h4>
                </div>
                <!-- Home -->
                <div class="home">
                    <div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{ asset('frontend/images/shop_background.jpg') }}"></div>
                    <div class="home_overlay"></div>
                    <div class="home_content d-flex flex-column align-items-center justify-content-center">
                        <h2 class="home_title">{{ $category->name }}</h2>
                    </div>
                </div>
                <!-- Shop Content -->
                <div class="shop_content">
                    <div class="option-box">
                        <div class="sort-box-holder">
                            <div class="btn-group pull-left sort-box">
                                <span>Ưu tiên xem: </span>
                                <ul class="sort-list">
                                    <li class="active" data-order="newest">
                                        <a href="javascript:void(0);">HÀNG MỚI</a>
                                    </li>
                                    <li class="" data-order="top_seller">
                                        <a href="javascript:void(0);">BÁN CHẠY</a>
                                    </li>
                                    <li class="" data-order="discount_percent,desc">
                                        <a href="javascript:void(0);">GIẢM GIÁ NHIỀU</a>
                                    </li>

                                    <li class="" data-order="price,asc">
                                        <a href="javascript:void(0);">GIÁ THẤP</a>
                                    </li>
                                    <li class="" data-order="price,desc">
                                        <a href="javascript:void(0);">GIÁ CAO</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="product_grid">
                        @foreach($products as $product)
                        @php
                            $first_attribute = $product->attributes->first();
                        @endphp
                        <!-- Product Item -->
                        
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
                        @endforeach
                    </div>
                    <!-- Shop Page Navigation -->
                    <div class="shop_page_nav d-flex flex-row">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	@include('frontend.home_sections.recently_viewed')

    @include('frontend.home_sections.brands')

    @include('frontend.home_sections.newsletter')

@endsection

@section('js')
<script src="{{ asset('frontend/plugins/Isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/plugins/jquery-ui-1.12.1.custom/jquery-ui.js') }}"></script>
<script src="{{ asset('frontend/plugins/parallax-js-master/parallax.min.js') }}"></script>
<script src="{{ asset('frontend/js/shop_custom.js') }}"></script>
@endsection