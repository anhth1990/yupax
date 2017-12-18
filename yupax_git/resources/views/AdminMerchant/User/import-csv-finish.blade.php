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
            <h1>Nhập liệu CSV
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
            <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/user/list')}}">Danh sách</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Thêm mới</span>
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
                        <span class="caption-subject font-dark bold uppercase">Thêm mới</span>
                        <span class="caption-helper"></span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- ** -->
                    <div class="mt-element-step">
                        <div class="row step-thin">
                            <div class="col-md-4 bg-grey mt-step-col">
                                <div class="mt-step-number bg-white font-grey">1</div>
                                <div class="mt-step-title uppercase font-grey-cascade">Bước 1</div>
                                <div class="mt-step-content font-grey-cascade">Nhập dữ liệu</div>
                            </div>
                            <div class="col-md-4 bg-grey mt-step-col ">
                                <div class="mt-step-number bg-white font-grey">2</div>
                                <div class="mt-step-title uppercase font-grey-cascade">Bước 2</div>
                                <div class="mt-step-content font-grey-cascade">Xác nhận</div>
                            </div>
                            <div class="col-md-4 bg-grey mt-step-col ">
                                <div class="mt-step-number bg-white font-grey active">3</div>
                                <div class="mt-step-title uppercase font-grey-cascade">Bước 3</div>
                                <div class="mt-step-content font-grey-cascade">Hoàn thành</div>
                            </div>
                        </div>
                    </div>
                    <!-- BEGIN FORM-->
                    <form class="form-horizontal form-bordered" >
                        
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Dữ liệu thực thi</label>
                                <div class="col-md-4">
                                    {{$addForm->getName()}}
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group last">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-3">
                                    <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/user/list')}}" class="btn green btn-xs">
                                            <i class="fa fa-check"></i> Danh sách</a>
                                </div>
                            </div>
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

    <!-- END PAGE BASE CONTENT -->
</div>
<!-- END CONTENT BODY -->

@stop
@section('css')

@stop
@section('javascript')

<script type="text/javascript">
$(document).ready(function(){
    
});

</script>
@stop