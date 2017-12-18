<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item  <?php if($nav==1)echo'active'; ?>">
                <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT'))}}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Tổng Quan</span>
                </a>
            </li>
            <!--
            <li class="heading">
                <h3 class="uppercase">Features</h3>
            </li>
        -->
            <li class="nav-item <?php if($nav==2)echo'active'; ?>">
                <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/user/list')}}" class="nav-link nav-toggle">
                    <i class="icon-user"></i>
                    <span class="title">Thành viên</span>
                </a>
            </li>
            <li class="nav-item <?php if($nav==3)echo'active'; ?>">
                <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/store/list')}}" class="nav-link nav-toggle">
                    <i class="icon-star"></i>
                    <span class="title">Cửa hàng</span>
                </a>
            </li>
            <li class="nav-item <?php if($nav==4)echo'active'; ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-equalizer"></i>
                    <span class="title">Phân tích người dùng</span>
                    <span class=""></span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start <?php if($nav==4 && $sub==1)echo'active'; ?>">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/analysis-user/rfm/config')}}" class="nav-link ">
                            <span class="title">Cài đặt RFM</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-plus"></i>
                    <span class="title">Tỷ lệ quy đổi</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-energy"></i>
                    <span class="title">Giao dịch</span>
                    <span class=""></span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start ">
                        <a href="javascript:;" class="nav-link ">
                            <span class="title">Giao dịch thường</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="javascript:;" class="nav-link ">
                            <span class="title">Giao dịch tích lũy điểm</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="javascript:;" class="nav-link ">
                            <span class="title">Giao dịch tiêu điểm</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?php if($nav==6)echo'active'; ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-present"></i>
                    <span class="title">Sự kiện & Khuyến mại</span>
                    <span class=""></span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start <?php if($nav==6 && $sub==1)echo'active'; ?>">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/news/list')}}" class="nav-link ">
                            <span class="title">Tin tức</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==6 && $sub==2)echo'active'; ?>">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/promotion/list')}}" class="nav-link ">
                            <span class="title">Khuyến mại</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?php if($nav==7)echo'active'; ?>">
                <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/file/list')}}" class="nav-link nav-toggle">
                    <i class="icon-book-open"></i>
                    <span class="title">Dữ liệu</span>
                </a>
            </li>
            <li class="nav-item <?php if($nav==9)echo'active'; ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-pie-chart"></i>
                    <span class="title">Khảo sát người dùng</span>
                    <span class=""></span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start <?php if($nav==9 && $sub==1)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/answer-question/list')}}" class="nav-link ">
                            <span class="title">Câu hỏi khảo sát</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==9 && $sub==2)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/answer-question/user/list')}}" class="nav-link ">
                            <span class="title">Người dùng trả lời</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?php if($nav==8)echo'active'; ?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Thống kê</span>
                    <span class=""></span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start <?php if($nav==8 && $sub==12)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical')}}" class="nav-link ">
                            <span class="title">Tổng quan</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==8 && $sub==1)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/revenue')}}" class="nav-link ">
                            <span class="title">Tổng doanh thu</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==8 && $sub==2)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/revpash')}}" class="nav-link ">
                            <span class="title">Chỉ số REVPASH (vnd/bàn/giờ)</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==8 && $sub==3)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/revtab')}}" class="nav-link ">
                            <span class="title">Chỉ số REVTAB (vnd/bàn/ngày)</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==8 && $sub==4)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/revbill')}}" class="nav-link ">
                            <span class="title">Chỉ số REVBILL (vnd/hóa đơn)</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==8 && $sub==5)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/revpam')}}" class="nav-link ">
                            <span class="title">Chỉ số REVPAM (vnd/m2)</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==8 && $sub==6)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/guests')}}" class="nav-link ">
                            <span class="title">Tổng số khách</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==8 && $sub==7)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/guestbill')}}" class="nav-link ">
                            <span class="title">Chỉ số khách/hóa đơn</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==8 && $sub==8)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/timeturn')}}" class="nav-link ">
                            <span class="title">Thời gian TB khách ăn</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==8 && $sub==9)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/meal')}}" class="nav-link ">
                            <span class="title">Đặt món</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==8 && $sub==10)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/complaintbill')}}" class="nav-link ">
                            <span class="title">Phàn nàn/hóa đơn</span>
                        </a>
                    </li>
                    <li class="nav-item start <?php if($nav==8 && $sub==11)echo'active'; ?> ">
                        <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/unavailabilityitem')}}" class="nav-link ">
                            <span class="title">Thiếu món</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="heading">
                <h3 class="uppercase">Hệ thống</h3>
            </li>
            <li class="nav-item <?php if($nav==10)echo'active'; ?>">
                <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/config')}}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">Cấu hình</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-logout"></i>
                    <span class="title">Đăng xuất</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>