@extends('layouts.admin_layout.admin_design')

@section('title', 'Chỉnh sửa sản phẩm')

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
            <h4 class="page-title"><i class="mdi mdi-shopping"></i> Chỉnh Sửa Sản Phẩm</h4>
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
    <form class="form-horizontal" action="{{ route('product.update', $product->id) }}" method="post" name="edit_product" id="edit_product" enctype="multipart/form-data">
        @csrf
        <input name="_method" type="hidden" value="PUT">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Mã sản phẩm</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="text" class="form-control" id="product_code" name="product_code" value="{{ $product->code }}">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Tên sản phẩm</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->name }}">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Slug</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="text" class="form-control" id="product_url" name="product_url" value="{{ $product->url }}">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Mô tả ngắn</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <textarea class="form-control" id="product_description" name="product_description" rows="5">{{ $product->description }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Thông tin chi tiết</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <textarea class="form-control" id="product_info" name="product_info" rows="5">{{ $product->info }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Giá thị trường</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="text" class="form-control" id="product_price" name="product_price" value="{{ $product->price }}">
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
                                <span class="">Danh mục</span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <select name="category_id" id="category_id" class="select2 form-control">
                                    {!! $categoriesDropdown !!}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-md-12 mb-2">
                                <span class="">Ảnh sản phẩm</span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                            @if(file_exists('images/products/small/'.$product->image))
                                <img src="{{ asset('/images/products/small/'.$product->image) }}" alt="{{ $product->name }}" width="100%">
                            @else
                                <img src="{{ asset('/images/products/default/default.jpg') }}" alt="{{ $product->name }}" width="100%">
                            @endif
                                <input type="hidden" name="product_current_image" value="{{ $product->image }}">
                                <input type="file" class="form-control" name="product_image">
                            </div>
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
                                <select name="product_status" id="product_status" class="select2 form-control">
                                    <option value="1" {{ ($product->status == 1)?'selected':'' }}>Kích hoạt</option>
                                    <option value="0" {{ ($product->status == 0)?'selected':'' }}>Vô hiệu hóa</option>
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
    <script src="{{ asset('backend/assets/libs/jquery-validation/dist/additional-methods.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script>
       $( document ).ready(function() {
            //***********************************
            //*      For select 2               *
            //***********************************
            $(".select2").select2();

            //***********************************
            //*  Validate form #edit_product    *
            //***********************************
            $('#edit_product').validate({
                rules:{
                    product_code:{
                        required: true
                    },
                    product_name:{
                        required: true
                    },
                    product_url:{
                        required: true
                    },
                    product_description:{
                        required: true
                    },
                    product_info:{
                        required: true
                    },
                    product_price:{
                        required: true,
                        number: true
                    },
                    product_image:{
                        extension: "jpg,jpeg,png"
                    }
                },
                errorElement: "div"
            });
        });
    </script>
@endsection