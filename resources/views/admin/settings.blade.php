@extends('layouts.admin_layout.admin_design')

@section('title', 'Chính sửa tài khoản')

@section('content')

<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title"><i class="mdi mdi-account-settings-variant"></i> Cài đặt tài khoản</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cài đặt</li>
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
        <div class="col-md-6">
            <div class="card">
                <form class="form-horizontal" action="{{ url('/system-cpanel/update-pwd') }}" method="post" name="password_validate" id="password_validate">
                    @csrf
                    <div class="card-body">
                        <h5 class="card-title">Đổi mật khẩu</h5>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-4 col-md-12">
                                <span class="">Mật khẩu hiện tại</span>
                            </div>
                            <div class="col-lg-8 col-md-12">
                                <input type="password" class="form-control" id="current_pwd" name="current_pwd" placeholder="Nhập mật khẩu hiên tại">
                                <span id="chkPwd"></span>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-4 col-md-12">
                                <span class="">Mật khẩu mới</span>
                            </div>
                            <div class="col-lg-8 col-md-12">
                                <input type="password" class="form-control" id="new_pwd" name="new_pwd" placeholder="Nhập mật khẩu mới">
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-lg-4 col-md-12">
                                <span class="">Xác nhận mật khẩu</span>
                            </div>
                            <div class="col-lg-8 col-md-12">
                                <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" placeholder="Nhập lại mật khẩu mới để xác nhận">
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
                        </div>
                    </div>
                </form>
                
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
    <script>
        $( document ).ready(function() {
            // Validate form #password_validate
            $('#password_validate').validate({
                rules:{
                    current_pwd:{
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    new_pwd:{
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    confirm_pwd:{
                        required: true,
                        minlength: 6,
                        maxlength: 20,
                        equalTo: "#new_pwd"
                    }
                },
                errorElement: "div"
            });

            // Validate current_pwd
            $("#current_pwd").keyup(function(){
                var current_pwd = $("#current_pwd").val();
                $.ajax({
                    type: 'get',
                    url: '/system-cpanel/check-pwd',
                    data: {current_pwd: current_pwd},
                    success: function(resp){
                        // alert(resp);
                        if(resp=="false"){
                            $("#chkPwd").html("<font color='#da542e'>Current Password is Incorrect</font>");
                            $("#current_pwd").removeClass('valid');
                            $("#current_pwd").addClass('error');
                        }else if(resp=="true"){
                            $("#chkPwd").html("<font color='#28b779'>Current Password is Correct</font>");
                        }
                    },error: function(){
                        alert("Error!");
                    }
                });
            });
        });
    </script>
@endsection