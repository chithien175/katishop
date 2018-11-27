@extends('layouts.admin_layout.admin_design')

@section('title', 'Danh sách sản phẩm')

@section('css')
<link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/libs/bootstrap-sweetalert/sweetalert.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title"><i class="mdi mdi-shopping"></i> Danh Sách Sản Phẩm</h4>
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="product_table" class="table table-striped table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mã SP</th>
                                    <th>Tên SP</th>
                                    <th>Danh mục</th>
                                    <th>Giá thị trường</th>
                                    <th>Hình ảnh</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Mã SP</th>
                                    <th>Tên SP</th>
                                    <th>Danh mục</th>
                                    <th>Giá thị trường</th>
                                    <th>Hình ảnh</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
<script src="{{ asset('backend/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
<script>
    /****************************************
    *       Basic Table                     *
    ****************************************/
    $( document ).ready(function() {
        // $('#product_table').DataTable();
        $('#product_table').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('ajax.getProducts') }}",
            "order": [[ 0, "desc" ]],
            "columns":[
                {"data": "id"},
                {"data": "code"},
                {"data": "name"},
                {"data": "category_id"},
                {"data": "price"},
                {"data": "image", orderable:false, searchable:false},
                {"data": "action", orderable:false, searchable:false}
            ]
        } );
    });

    /****************************************
    *       Confirm delete product         *
    ****************************************/
    $(document).on('click', '.delete-product', function(e){
        e.preventDefault();
        swal({
            title: "Bạn muốn xóa?",
            text: "Bạn sẽ không thể khôi phục lại sản phẩm này!",
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
</script>
@endsection