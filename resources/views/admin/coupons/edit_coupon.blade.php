@extends('layouts.admin_layout.admin_design')

@section('title', 'Sửa mã giảm giá')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/libs/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title"><i class="mdi mdi-tag-multiple"></i> Chỉnh Sửa Mã Giảm Giá</h4>
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
    @if ($errors->any())
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form class="form-horizontal" action="{{ route('coupon.update', $coupon->id) }}" method="post" name="add_coupon" id="add_coupon">
        @csrf
        <input name="_method" type="hidden" value="PUT">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Mã giảm giá</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="text" class="form-control" id="coupon_code" name="coupon_code" value="{{ $coupon->coupon_code }}">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Giá giảm / Tỉ lệ</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="number" min="0" class="form-control" id="coupon_amount" name="coupon_amount" value="{{ $coupon->amount }}">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Loại giảm giá</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <select name="coupon_type" id="coupon_type" class="select2 form-control">
                                    <option {{ ($coupon->amount_type == 'percentage')?'selected':'' }} value="percentage">Giảm phần trăm</option>
                                    <option {{ ($coupon->amount_type == 'fixed')?'selected':'' }} value="fixed">Giảm tiền</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Thời hạn mã giảm giá</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="text" class="form-control" id="coupon_expiry_date" name="coupon_expiry_date" value="{{ $coupon->expiry_date }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-md-12 mb-2">
                                <span class="">Trạng thái</span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <select name="coupon_status" id="coupon_status" class="select2 form-control">
                                    <option {{ ($coupon->status == 1)?'selected':'' }} value="1">Kích hoạt</option>
                                    <option {{ ($coupon->status == 0)?'selected':'' }} value="0">Vô hiệu hóa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
                        <a class="btn btn-secondary" href="javascript:history.back()"><i class="fas fa-undo"></i> Trở lại</a>
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
    <script src="{{ asset('backend/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
       $( document ).ready(function() {
            $('#coupon_expiry_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: "yyyy/mm/dd"
            });

            //***********************************
            //*  Validate form #add_coupon    *
            //***********************************
            $('#add_coupon').validate({
                rules:{
                    coupon_code:{
                        required: true,
                        minlength: 5,
                        maxlength: 15
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