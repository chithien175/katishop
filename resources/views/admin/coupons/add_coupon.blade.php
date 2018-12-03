@extends('layouts.admin_layout.admin_design')

@section('title', 'Thêm mã giảm giá')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title"><i class="mdi mdi-tag-multiple"></i> Thêm Mới Mã Giảm Giá</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mã giảm giá</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-md-12">
            @include('layouts.admin_layout.admin_flash_message')
        </div>
    </div>
    

        <form class="form-horizontal" action="{{ route('coupon.store') }}" method="post" name="add_coupon" id="add_coupon">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Mã giảm giá</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="text" class="form-control" id="coupon_code" name="coupon_code">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Giá giảm</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="text" class="form-control" id="coupon_amount" name="coupon_amount">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Loại giảm giá</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <select name="coupon_type" id="coupon_type" class="select2 form-control">
                                    <option value="percentage">Tỉ lệ phần trăm</option>
                                    <option value="fixed">Số tiền giảm giá</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Thời hạn mã giảm giá</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="date" class="form-control" id="coupon_expiry_date" name="coupon_expiry_date">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tạo mới</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-md-12 mb-2">
                                <span class="">Trạng thái</span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <select name="coupon_status" id="coupon_status" class="select2 form-control">
                                    <option value="1">Kích hoạt</option>
                                    <option value="0">Vô hiệu hóa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

@endsection

@section('js')
    <script src="{{ asset('backend/assets/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script>
       $( document ).ready(function() {
            //***********************************
            //*  Validate form #add_coupon    *
            //***********************************
            $('#add_coupon').validate({
                rules:{
                    coupon_code:{
                        required: true
                    },
                    coupon_amount:{
                        required: true
                    },
                    coupon_type:{
                        required: true
                    },
                    coupon_expiry_date:{
                        required: true
                    }
                },
                errorElement: "div"
            });
        });
    </script>
@endsection