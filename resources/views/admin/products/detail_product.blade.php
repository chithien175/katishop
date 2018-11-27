@extends('layouts.admin_layout.admin_design')

@section('title', 'Chi tiết sản phẩm')

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
            <h4 class="page-title"><i class="mdi mdi-shopping"></i> {{ $product->name }}</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
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
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3 align-items-center">
                        <div class="col-lg-3 col-md-12">
                            <span class="">Mã sản phẩm</span>
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <span>{{ $product->code }}</span>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-lg-3 col-md-12">
                            <span class="">Danh mục</span>
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <span>{{ $product->categories->name }}</span>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-lg-3 col-md-12">
                            <span class="">Giá thị trường</span>
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <span>{{ number_format($product->price, 0, ",", ".") }} VNĐ</span>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-lg-3 col-md-12">
                            <span class="">Mô tả ngắn</span>
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <span>{!! $product->description !!}</span>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-lg-3 col-md-12">
                            <span class="">Thông tin chi tiết</span>
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <span>{!! $product->info !!}</span>
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
                            <span class="">Ảnh sản phẩm</span>
                        </div>
                        @if(file_exists('images/products/small/'.$product->image))
                        <div class="col-lg-12 col-md-12">
                            <img src="{{ asset('/images/products/small/'.$product->image) }}" alt="{{ $product->name }}" width="100%">
                        </div>
                        @else
                            <img src="{{ asset('images/products/default/default.jpg') }}" width="100%">
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-md-12 mb-2">
                                <span class="">Trạng thái</span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                @if($product->status == 1)
                                    <span>Kích hoạt</span>
                                @else
                                    <span>Vô hiệu hóa</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-danger" href="{{ route('product.edit', $product->id) }}"><i class="fas fa-edit"></i> Chỉnh sửa</a>
                    <a class="btn btn-secondary" href="javascript:history.back()"><i class="fas fa-undo"></i> Trở lại</a>
                </div>
            </div>
        </div>
    </div>
 
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
    <script src="{{ asset('backend/assets/libs/jquery-validation/dist/additional-methods.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/select2/dist/js/select2.min.js') }}"></script>
@endsection