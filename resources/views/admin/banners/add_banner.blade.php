@extends('layouts.admin_layout.admin_design')

@section('title', 'Thêm banner')

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
            <h4 class="page-title"><i class="mdi mdi-shopping"></i> Thêm Mới Banner</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Banner</li>
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
    <form class="form-horizontal" action="{{ route('banner.store') }}" method="post" name="add_banner" id="add_banner" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Tiêu đề</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="text" class="form-control" id="banner_title" name="banner_title">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Mô tả</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <textarea class="form-control" id="banner_des" name="banner_des" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <span class="">Liên kết</span>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <input type="text" class="form-control" id="banner_link" name="banner_link">
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
                                <span class="">Ảnh banner (500x500 px)</span>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <input type="file" class="form-control" name="banner_image">
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
                                <select name="banner_status" id="banner_status" class="select2 form-control">
                                    <option value="1">Kích hoạt</option>
                                    <option value="0">Vô hiệu hóa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Thêm mới</button>
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
            //*  Validate form #add_banner    *
            //***********************************
            $('#add_banner').validate({
                rules:{
                    banner_title:{
                        required: true
                    },
                    banner_image:{
                        required: true,
                        extension: "jpg,jpeg,png"
                    }
                },
                errorElement: "div"
            });
        });
    </script>
@endsection