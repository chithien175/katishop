@extends('layouts.admin_layout.admin_design')

@section('title', 'Thuộc tính sản phẩm')

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
            <h4 class="page-title"><i class="mdi mdi-shopping"></i> Thêm Thuộc Tính Sản Phẩm</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thuộc tính sản phẩm</li>
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
                    <div class="row mb-2 align-items-center">
                        <div class="col-md-12">
                            <span class="">Danh sách thuộc tính</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="attribute_table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã SKU</th>
                                    <th>Tên thuộc tính</th>
                                    <th>Giá bán</th>
                                    <th>Số lượng</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $stt = 1;
                                @endphp
                                @foreach($product->attributes as $key => $attribute)
                                    <tr>
                                        <td>{{ $stt }}</td>
                                        <td>{{ $attribute->sku }}</td>
                                        <td>{{ $attribute->name }}</td>
                                        <td>{{ number_format($attribute->price, 0, ",", ".").' ₫' }}</td>
                                        <td>{{ $attribute->stock }}</td>
                                        <td>
                                            <a href="#" data-attribute-key="{{ $key }}" class="btn btn-warning btn-xs mb-1 edit_attribute"><i class="fas fa-edit"></i> Sửa</a>
                                            <form action="{{ route('post.delete-attribute', $attribute->id) }}" method="post">
                                                @csrf
                                                <button type="button" class="btn btn-danger btn-xs delete-attribute"><i class="fas fa-trash-alt"></i> Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @php
                                        $stt ++;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã SKU</th>
                                    <th>Tên thuộc tính</th>
                                    <th>Giá bán</th>
                                    <th>Số lượng</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form class="form-horizontal" action="{{ route('post.add-attributes', $product->id) }}" method="post" name="add_attributes" id="add_attributes" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="field_wrapper">
                            <span class="">Thêm thuộc tính</span>
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-3 col-md-12">
                                    <input class="form-control" type="text" name="product_sku[]" placeholder="Mã SKU" required />
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <input class="form-control" type="text" name="product_name[]" placeholder="Tên thuộc tính" required />
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <input class="form-control" type="number" min="0" name="product_stock[]" placeholder="Hàng trong kho" required />
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <input class="form-control" type="number" min="0" name="product_price[]" placeholder="Giá bán" required />
                                </div>
                                <div class="col-lg-2 col-md-12">
                                    <a href="javascript:void(0);" class="add_button btn btn-success" title="Thêm"><i class="mdi mdi-plus-circle"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
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

<!-- The Modal -->
<form id="edit_attribute_form" class="form-horizontal" method="post" action="">
    @csrf
    <div class="modal" id="editAttributeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-boxes"></i> Chỉnh sửa thuộc tính</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="sku" class="col-sm-3 text-right control-label col-form-label">Mã SKU</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="sku" name="sku" value="" placeholder="Mã SKU" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 text-right control-label col-form-label">Tên thuộc tính</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" value="" name="name" placeholder="Tên thuộc tính" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="stock" class="col-sm-3 text-right control-label col-form-label">Hàng trong kho</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" class="form-control" id="stock" value="" name="stock" placeholder="Hàng trong kho" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-sm-3 text-right control-label col-form-label">Giá bán</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" class="form-control" id="price" value="" name="price" placeholder="Giá bán" required>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" ><i class="fa fa-save"></i> Cập nhật</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Đóng</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
    <script src="{{ asset('backend/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $( document ).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div class="row mb-3 align-items-center"><div class="col-lg-3 col-md-12"><input class="form-control" type="text" name="product_sku[]" placeholder="Mã SKU" /></div><div class="col-lg-3 col-md-12"><input class="form-control" type="text" name="product_name[]" placeholder="Tên thuộc tính" /></div><div class="col-lg-3 col-md-12"><input class="form-control" type="number" min="0" name="product_stock[]" placeholder="Hàng trong kho" /></div><div class="col-lg-3 col-md-12"><input class="form-control" type="number" min="0" name="product_price[]" placeholder="Giá bán" /></div><div class="col-lg-2 col-md-12"><a title="Hủy" href="javascript:void(0);" class="remove_button btn btn-danger"><i class="mdi mdi-close-circle"></i></a></div></div></div>'; //New input field html 
            var x = 1; //Initial field counter is 1
            
            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){ 
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });
            
            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).closest('div.row').remove(); //Remove field html
                x--; //Decrement field counter
            });

            

            /****************************************
            *       Basic Table                     *
            ****************************************/
            $('#attribute_table').DataTable();
        });

        $( document ).ready(function() {
            /****************************************
            *       Confirm delete attribute         *
            ****************************************/
            $('.delete-attribute').click(function(e){
                e.preventDefault();
                swal({
                    title: "Bạn muốn xóa?",
                    text: "Bạn sẽ không thể khôi phục lại thuộc tính này!",
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

        $( document ).ready(function() {
            /****************************************
            *       Click edit_attribute button         *
            ****************************************/
            $('.edit_attribute').click(function(e){
                e.preventDefault();
                var attributeKey = $(this).data('attribute-key');
                var attributes = <?= $product->attributes; ?>;
                var attribute = attributes[attributeKey];
                // console.log(attribute);
                var url = '<?= url('/system-cpanel/edit-attribute/'); ?>'+'/'+attribute.id;
                $("#edit_attribute_form").attr("action", url);
                $('#sku').val(attribute.sku);
                $('#name').val(attribute.name);
                $('#stock').val(attribute.stock);
                $('#price').val(attribute.price);
                $("#editAttributeModal").modal()
            });
        });
    </script>
@endsection