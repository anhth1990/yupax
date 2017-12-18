@extends('AdminMerchant.Layouts.default')
@section('slidebar')
@include('AdminMerchant.Layouts.slidebar',[
    'nav'=>'2',
    'sub'=>'1'
])
@stop
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Thành viên
                <small><!-- ** --></small>
            </h1>
        </div>
        <!-- END PAGE TITLE -->
        <!-- BEGIN PAGE TOOLBAR -->
        <!-- ** -->
        <!-- END PAGE TOOLBAR -->
    </div>
    <!-- END PAGE HEAD-->
    <!-- BEGIN PAGE BREADCRUMB -->
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT'))}}">Tổng quan</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Danh sách</span>
        </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
             <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Thống kê</span>
                        <span class="caption-helper"></span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- ** -->
                    <!-- BEGIN FORM-->
                    <form action="4-scan.html" class="horizontal-form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Họ tên</label>
                                        <input type="text" id="firstName" class="form-control" placeholder="Họ tên">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Số điện thoại</label>
                                        <input type="text" id="firstName" class="form-control" placeholder="Số điện thoại">
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="text" id="firstName" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Giới tính</label>
                                        <select class="form-control">
                                            <option value="">Tất cả</option>
                                            <option value="">Nam</option>
                                            <option value="">Nữ</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Ngày sinh</label>
                                        <input type="text" class="form-control" placeholder="dd/mm/yyyy"> </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Trạng thái</label>
                                        <select class="form-control">
                                            <option value="">Tất cả</option>
                                            <option value="">Đang hoạt động</option>
                                            <option value="">Chưa kích hoạt</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Hạng thành viên</label>
                                        <select class="form-control select2" data-placeholder="Choose a Category" tabindex="1">
                                            <option value="Category 1">Hạng bạch kim</option>
                                            <option value="Category 2">Hạng vàng</option>
                                            <option value="Category 3">Hạng bạc</option>
                                            <option value="Category 4">Hạng đồng</option>
                                            <option value="Category 4">Khách hàng thường</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nguồn khách hàng</label>
                                        <select class="form-control">
                                            <option value="">Tất cả</option>
                                            <option value="">Vietjet nhập</option>
                                            <option value="">Tự đăng ký</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->

                                <!--/span-->
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-xs-12 col-sm-12">
                                    <div id="" style="padding:5px;"> Có {{$countObj}} bản ghi được tìm thấy </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions ">
                            <button type="submit" class="btn green">
                                <i class="fa fa-check"></i> Thống kê</button>
                            <button type="button" class="btn default">Xóa</button>

                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Danh sách</span>
                        <span class="caption-helper"></span>
                    </div>
                    <div class="actions ">
                        <a href="javascript:;" class="btn green">
                            <i class="fa fa-plus"></i> Thêm mới</a>
                        <a href="{{Asset('/merchant/user/import-csv')}}" class="btn green">
                            <i class="fa fa-plus"></i> Nhập dữ liệu csv</a>

                    </div>
                </div>
                <div class="portlet-body">
                    <!-- ** -->
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        STT 
                                    </th>
                                    <th colspan="2">
                                        Thông tin 
                                    </th>
                                    <th>
                                        Xếp hạng 
                                    </th>
                                    <th> 
                                        Trạng thái
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                 @if(isset($listObj) && count($listObj)>0)
                                    @foreach($listObj as $key=>$obj)
                                <tr>
                                    <td>
                                        <a href="javascript:;"> {{($page-1)*env('PAGE_SIZE')+intval($key)+1}} </a>
                                    </td>
                                    <td class="hidden-xs">
                                        <img alt="" width="100px" class="img-thumbnail" src="{{Asset('/public/uploads/images/default.png')}}">
                                    </td>
                                    <td> 
                                        <!--
                                        <i class="glyphicon glyphicon-user"></i> <br>
                                        -->
                                        <i class="glyphicon glyphicon-user"></i> {{$obj->firstName}} {{$obj->lastName}}<br>
                                        <i class="glyphicon glyphicon-phone"></i> {{$obj->mobile}}<br>
                                        <i class="glyphicon glyphicon-envelope"></i> {{$obj->email}}<br>
                                        <i class="glyphicon glyphicon-rub"></i> {{$obj->balance}} y-coin
                                    </td>
                                    <td> 
                                        @if($obj->balance<=100)
                                            <span class="label label-sm label-success label-mini"> Thành viên thường </span>
                                        @elseif($obj->balance>100 && $obj->balance<=500)
                                            <span class="label label-sm label-default label-mini">Hạng Bạc </span>
                                        @elseif($obj->balance>500 && $obj->balance<=1200)
                                            <span class="label label-sm label-warning label-mini"> Hạng Vàng </span>
                                        @elseif($obj->balance>1200 && $obj->balance<=2000)
                                            <span class="label label-sm label-primary label-mini"> Hạng Bạch Kim </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="label label-sm label-success label-mini"> Đang hoạt động </span>
                                    </td>
                                    <td>
                                        <a href="javascript:;" class="btn green btn-sm btn-outline sbold uppercase">
                                            <i class="fa fa-share"></i> View </a>
                                    </td>
                                </tr>

                                @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                    @if(isset($listObj) && count($listObj)>0)
                        <?php echo $listObj->render(); ?>
                      @endif
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
    <!-- END PAGE BASE CONTENT -->
</div>
<!-- END CONTENT BODY -->

@stop
@section('css')
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
@stop
@section('javascript')
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/jquery.pulsate.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-summernote/summernote.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/pages/scripts/form_custom.js')}}" type="text/javascript"></script>

@stop