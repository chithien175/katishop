@extends('layouts.frontend_layout.frontend_design')

@section('css')
<meta name="_token" content="{{csrf_token()}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/login_register_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/cart_responsive.css') }}">
@endsection

@section('content')
<div class="account_section mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                Thông tin tài khoản
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('frontend/js/cart_custom.js') }}"></script>
<script src="{{ asset('frontend/plugins/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script>
    $( document ).ready(function() {
        
    });
</script>
@endsection