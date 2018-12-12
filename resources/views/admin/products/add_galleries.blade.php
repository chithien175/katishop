@extends('layouts.admin_layout.admin_design')

@section('title', 'Thư viện ảnh sản phẩm')

@section('css')
<link href="{{ asset('backend/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/libs/bootstrap-sweetalert/sweetalert.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title"><i class="mdi mdi-shopping"></i> Thêm Thư Viện Ảnh Sản Phẩm</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thư viện ảnh sản phẩm</li>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3 align-items-center">
                        <div class="col-lg-3 col-md-12">
                            <span class="">Mã sản phẩm</span>
                        </div>
                        <div class="col-lg-9 col-md-12 font-weight-bold">
                            <span class="">{{ $product->code }}</span>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-lg-3 col-md-12">
                            <span class="">Tên sản phẩm</span>
                        </div>
                        <div class="col-lg-9 col-md-12 font-weight-bold">
                            <span class="">{{ $product->name }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <span class="">Thư viện ảnh</span>
                        </div>
                        @foreach($product->galleries as $gallery)
                            <div class="col-lg-3 col-md-6 mt-3 text-center" style="position: relative;">
                                <img src="{{ asset('images/product_galleries/small/'.$gallery->name) }}" alt="{{ $product->name }}" class="img-thumbnail">
                                <form action="{{ route('post.delete-gallery', $gallery->id) }}" method="post">
                                    @csrf
                                    <button type="button" class="btn btn-danger btn-sm delete-gallery" style="position: absolute; top: 5px; right: 30px;"><i class="mdi mdi-close-circle"></i></button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal dropzone" action="#" method="post" name="add_galleries" id="add_galleries" enctype="multipart/form-data">
                        @csrf
                        <div class="dz-default dz-message">
                            <img src="{{ asset('/backend/assets/images/upload-icon.png') }}" alt="Upload file" width=50px;>
                            <div>Thả hình (600x600 px) vào đây để tải lên</div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <button id="submit-files" type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
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
    <script src="{{ asset('backend/assets/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap-sweetalert/sweetalert.min.js') }}
    "></script>
    <script>
        // Init dropzone instance
        Dropzone.autoDiscover = false
        const myDropzone = new Dropzone('#add_galleries', {
            autoProcessQueue: false
        })

        // Submit
        const $button = document.getElementById('submit-files')
        $button.addEventListener('click', function () {
        // Retrieve selected files
            const acceptedFiles = myDropzone.getAcceptedFiles()
            for (let i = 0; i < acceptedFiles.length; i++) {
                setTimeout(function () {
                myDropzone.processFile(acceptedFiles[i])
                }, i * 2000)
            }
        })
    </script>

    <script>
        $(document).ready(function(){
            /****************************************
            *       Confirm delete gallery         *
            ****************************************/
            $('.delete-gallery').click(function(e){
                e.preventDefault();
                swal({
                    title: "Bạn muốn xóa?",
                    text: "Bạn sẽ không thể khôi phục lại ảnh này!",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Không",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Có, xóa ngay!",
                    closeOnConfirm: false
                    },
                function(){
                    $(e.target).closest('form').submit()
                });
            });
        });
    </script>
    
@endsection