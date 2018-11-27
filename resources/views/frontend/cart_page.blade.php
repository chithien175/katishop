@extends('layouts.frontend_layout.frontend_design')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_responsive.css') }}">
@endsection

@section('content')
<div class="cart_section">
    <div class="container">
        <div class="row">
            <div class="cart_container col-md-8 order-lg-1">
                <div class="cart_title">Giỏ hàng</div>
                <div class="cart_items">
                    <ul class="cart_list">
                        <li class="cart_item clearfix">
                            <div class="cart_item_image"><img src="{{ asset('frontend/images/shopping_cart.jpg') }}" alt=""></div>
                            <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                <div class="cart_item_name cart_info_col">
                                    <a class="cart_item_text" href="#">
                                        MacBook Air 13
                                    </a>
                                </div>
                                <div class="cart_item_price cart_info_col">
                                    <div class="cart_item_text">$2000</div>
                                </div>
                                <div class="cart_item_quantity cart_info_col">
                                    <div class="cart_item_text">1</div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 order-lg-2">
                <p>Tạm tính</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('frontend/js/cart_custom.js') }}"></script>
@endsection