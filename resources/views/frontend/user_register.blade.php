@extends('layouts.frontend_layout.frontend_design')

@section('css')
<meta name="_token" content="{{csrf_token()}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/login_register_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_responsive.css') }}">
@endsection

@section('content')
<div class="register_section mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form id="register_form" name="register_form" action="{{ route('post.user_register') }}" method="post">
                    @csrf()
                    <div class="form-group">
                        <label for="fullname">Họ tên</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập họ tên">
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email">
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu từ 6 đến 32 ký tự">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="cb_confirm" value="true">
                        <span>  
                            Nhận các thông tin và chương trình khuyến mãi của Katisoft qua email. Khi bạn nhấn Đăng ký, bạn đã đồng ý thực hiện mọi giao dịch mua bán theo <a href="#">điều kiện sử dụng và chính sách của Katisoft</a>.
                        </span>
                    </div>
                    <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('frontend/js/cart_custom.js') }}"></script>
<script>
    $( document ).ready(function() {
        
    });
</script>
@endsection