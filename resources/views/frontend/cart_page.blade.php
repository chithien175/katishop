@extends('layouts.frontend_layout.frontend_design')

@section('css')
<meta name="_token" content="{{csrf_token()}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_responsive.css') }}">
@endsection

@section('content')
<div class="cart_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('layouts.admin_layout.admin_flash_message')
            </div>
        </div>
        @if($totalItems == 0)
            <div class="row">
                <div class="col-md-12">
                    <p>Giỏ hàng không có sản phẩm. Vui lòng thực hiện lại.</p>
                </div>
            </div> 
        @else
        <div class="row">
            <div class="cart_container col-lg-9 col-sm-12 col-xs-12 order-lg-1">
                <div class="cart_title">GIỎ HÀNG <span class="total_items">({{ $totalItems }} sản phẩm)</span></div>
                <div class="cart_items">
                    <ul class="cart_list">
                        @foreach($userCart as $key => $cart)
                        <li class="cart_item clearfix">
                            <div class="cart_item_image">
                                @if(file_exists('images/products/medium/'.$cart->products->image))
                                <img src="{{ asset('images/products/small/'.$cart->products->image) }}" alt="{{ $cart->products->name }}">
                                @else
                                <div class="image_selected"><img src="{{ asset('images/products/default/default.jpg') }}" alt="{{ $cart->products->name }}"></div>
                                @endif
                            </div>
                            <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                <div class="cart_item_name cart_info_col">
                                    <a class="cart_item_text" href="{{ renderProductDetailLink($cart->products->url, $cart->product_id) }}">
                                        {{ $cart->products->name }} ({{ $cart->attributes->name }})
                                    </a>
                                    <div class="seller-by mt-1">
                                            Cung cấp bởi <a href="javascript:void(0);">Katishop</a>
                                    </div>
                                    <div class="action mt-1">
                                        <a class="del-cart" href="javascript:void(0);" data-item-id="{{ $cart->id }}" data-item-quantity="{{ $cart->quantity }}">Xóa</a>
                                    </div>
                                </div>
                                <div class="cart_item_price cart_info_col">
                                    @php
                                        $price1 = $cart->attributes->price;
                                        $price2 = $cart->products->price;
                                        $sale = ratioDiscountCalculator($price1, $price2);
                                    @endphp
                                    <div class="cart_item_text price1">{{ number_format($price1, 0, ',', '.') }} ₫</div>
                                    <div class="cart_item_text price2">{{ number_format($price2, 0, ',', '.') }} ₫</div>
                                    <div class="cart_item_text sale">-{{ $sale }}%</div>
                                </div>
                                <div class="input-group cart_item_quantity cart_info_col">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[{{$key}}]">
                                            <span class="fas fa-minus"></span>
                                        </button>
                                    </span>
                                    <input type="text" name="quant[{{$key}}]" class="form-control input-number" value="{{ $cart->quantity }}" min="1" max="99" data-item-id="{{ $cart->id }}">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[{{$key}}]">
                                            <span class="fas fa-plus"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12 col-xs-12 order-lg-2">
                <p>Tạm tính</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('frontend/js/cart_custom.js') }}"></script>
<script>
    $( document ).ready(function() {
        $('.btn-number').click(function(e){
            e.preventDefault();
            
            fieldName = $(this).attr('data-field');
            type      = $(this).attr('data-type');
            var input = $("input[name='"+fieldName+"']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if(type == 'minus') {
                    if(currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                        
                        // Số lương -1 và update quantity trong bảng cart
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        jQuery.ajax({
                            url: "{{ route('post.update_quantity') }}",
                            method: 'post',
                            data: {
                                id: input.data('item-id'),
                                action: 'minus',
                                quantity: 1
                            },
                            success: function(result){
                                if(result.status == 1){
                                    location.reload();
                                }
                            }
                        });
                    } 
                    if(parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }
                } else if(type == 'plus') {
                    if(currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();

                        // Số lương +1 và update quantity trong bảng cart
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        jQuery.ajax({
                            url: "{{ route('post.update_quantity') }}",
                            method: 'post',
                            data: {
                                id: input.data('item-id'),
                                action: 'plus',
                                quantity: 1
                            },
                            success: function(result){
                                if(result.status == 1){
                                    location.reload();
                                }
                            }
                        });
                    }
                    if(parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }
                }
            } else {
                input.val(0);
            }
        });
        $('.input-number').focusin(function(){
            $(this).data('oldValue', $(this).val());
        });
        $('.input-number').focusout(function(){
            valueCurrent = parseInt($(this).val());
            // Số lương tự nhập và update quantity trong bảng cart
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ route('post.update_quantity') }}",
                method: 'post',
                data: {
                    id: $(this).data('item-id'),
                    action: 'manual',
                    quantity: valueCurrent
                },
                success: function(result){
                    if(result.status == 1){
                        location.reload();
                    }
                }
            });
        });
        $('.input-number').change(function() {
            minValue =  parseInt($(this).attr('min'));
            maxValue =  parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());
            
            name = $(this).attr('name');
            if(valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
            } else {
                alert('Xin lỗi, Số lượng vượt quá giới hạn tối thiểu');
                $(this).val($(this).data('oldValue'));
            }
            if(valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
            } else {
                alert('Xin lỗi, Số lượng vượt quá giới hạn tối đa');
                $(this).val($(this).data('oldValue'));
            }
        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) || 
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)){
                e.preventDefault();
            }
        });

        // Delete item from cart
        $('.action .del-cart').click(function(e){
            e.preventDefault();
            var obj = $(this);
            var itemId = $(obj).data("item-id");
            var cartQuantity = $(obj).data("item-quantity");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ route('post.del_item') }}",
                method: 'post',
                data: {
                    id: itemId
                },
                success: function(result){
                    if(result.status == 1){
                        location.reload();
                    }
                }
            });
        });
    });
</script>
@endsection