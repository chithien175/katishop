@extends('layouts.admin_layout.admin_design')

@section('title', 'Danh sách mã giảm giá')

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
            <h4 class="page-title"><i class="mdi mdi-tag-multiple"></i> Danh Sách Mã Giảm Giá</h4>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="coupon_table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mã giảm giá</th>
                                    <th>Giá giảm / Tỉ lệ</th>
                                    <th>Loại giảm giá</th>
                                    <th>Thời hạn</th>
                                    <th>Trạng thái</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->id }}</td>
                                    <td>{{ $coupon->coupon_code }}</td>
                                    @if($coupon->amount_type == 'fixed')
                                        <td>{{ number_format($coupon->amount, 0, ",", ".") }} ₫</td>
                                    @else
                                        <td>{{ $coupon->amount }}%</td>
                                    @endif
                                    
                                    <td>{{ ($coupon->amount_type == 'fixed')?'Giảm tiền':'Phần trăm' }}</td>
                                    <td>{{ $coupon->expiry_date }}</td>
                                    <td>{{ ($coupon->status == '1')?'Kích hoạt':'Vô hiệu hóa' }}</td>
                                    <td class="center">
                                        <a class="btn btn-warning btn-xs mb-1" href="{{ route('coupon.edit', $coupon->id) }}"><i class="fas fa-edit"></i> Sửa</a>
                                        <form action="{{ route('coupon.destroy', $coupon->id) }}" method="post">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="button" class="btn btn-danger btn-xs delete-coupon"><i class="fas fa-trash-alt"></i> Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Mã giảm giá</th>
                                    <th>Giá giảm / Tỉ lệ</th>
                                    <th>Loại giảm giá</th>
                                    <th>Thời hạn</th>
                                    <th>Trạng thái</th>
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
        $( document ).ready(function() {
            
            /****************************************
            *       Basic Table                     *
            ****************************************/
            $('#coupon_table').DataTable({
                "order": [[ 0, "desc" ]],
                "columnDefs": [
                    { "orderable": false, "searchable": false, "targets": 6 }
                ]
            });
        });
    </script>
@endsection