@extends('layouts.frontend_layout.frontend_design')

@section('css')
<meta name="_token" content="{{csrf_token()}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/login_register_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_responsive.css') }}">
@endsection

@section('content')
<div class="login_section mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form id="login_form" name="login_form" action="{{ route('post.user_login') }}" method="post">
                    @csrf()
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu từ 6 đến 32 ký tự" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
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