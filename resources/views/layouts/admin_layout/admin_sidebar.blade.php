<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard red"></i><span class="hide-menu">Bảng điều khiển</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-tag-multiple"></i><span class="hide-menu">Danh mục </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ route('category.create') }}" class="sidebar-link"><i class="mdi mdi-library-plus"></i><span class="hide-menu"> Thêm mới </span></a></li>
                        <li class="sidebar-item"><a href="{{ route('category.index') }}" class="sidebar-link"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu"> Xem tất cả </span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-shopping"></i><span class="hide-menu">Sản phẩm </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ route('product.create') }}" class="sidebar-link"><i class="mdi mdi-library-plus"></i><span class="hide-menu"> Thêm mới </span></a></li>
                        <li class="sidebar-item"><a href="{{ route('product.index') }}" class="sidebar-link"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu"> Xem tất cả </span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-sale"></i><span class="hide-menu">Mã giảm giá </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ route('coupon.create') }}" class="sidebar-link"><i class="mdi mdi-library-plus"></i><span class="hide-menu"> Thêm mới </span></a></li>
                        <li class="sidebar-item"><a href="{{ route('coupon.index') }}" class="sidebar-link"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu"> Xem tất cả </span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-folder-multiple-image"></i><span class="hide-menu">Banners </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ route('banner.create') }}" class="sidebar-link"><i class="mdi mdi-library-plus"></i><span class="hide-menu"> Thêm mới </span></a></li>
                        <li class="sidebar-item"><a href="{{ route('banner.index') }}" class="sidebar-link"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu"> Xem tất cả </span></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->