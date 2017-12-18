@extends('AdminMerchant.Layouts.default')
@section('slidebar')
@include('AdminMerchant.Layouts.slidebar',[
'nav'=>'10',
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
            <h1>Cấu hình
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
            <span class="active">Cấu hình</span>
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
                        <span class="caption-subject font-dark bold uppercase">Cấu hình</span>
                        <span class="caption-helper"></span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- ** -->
                    <div class="mt-element-step">
                        <div class="row step-thin">
                            <div class="col-md-4 bg-grey mt-step-col ">
                                <div class="mt-step-number bg-white font-grey">1</div>
                                <div class="mt-step-title uppercase font-grey-cascade">Bước 1</div>
                                <div class="mt-step-content font-grey-cascade">Nhập dữ liệu</div>
                            </div>
                            <div class="col-md-4 bg-grey mt-step-col active">
                                <div class="mt-step-number bg-white font-grey ">2</div>
                                <div class="mt-step-title uppercase font-grey-cascade">Bước 2</div>
                                <div class="mt-step-content font-grey-cascade">Xác nhận</div>
                            </div>
                            <div class="col-md-4 bg-grey mt-step-col ">
                                <div class="mt-step-number bg-white font-grey">3</div>
                                <div class="mt-step-title uppercase font-grey-cascade">Bước 3</div>
                                <div class="mt-step-content font-grey-cascade">Hoàn thành</div>
                            </div>
                        </div>
                    </div>
                    <!-- BEGIN FORM-->
                    <form class="form-horizontal form-bordered">
                        <div class="form-body">
                            <h3>Đánh giá người dùng</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Mức xếp hạng</label>
                                <div class="col-md-4">
                                    {{$configForm->getRankUser()}}
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Sự gần đây</label>
                                <div class="col-md-4">
                                    @if($configForm->getRecensy()==1) 
                                    <a href="javascript:;" class="btn btn-xs blue bt-delete-answer">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    @endif
                                    @if($configForm->getRecensy()==0) 
                                    <a href="javascript:;" class="btn btn-xs red bt-delete-answer">
                                        <i class="fa fa-close"></i>
                                    </a>
                                    @endif
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tần suất</label>
                                <div class="col-md-4">
                                    @if($configForm->getFrequency()==1) 
                                    <a href="javascript:;" class="btn btn-xs blue bt-delete-answer">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    @endif
                                    @if($configForm->getFrequency()==0) 
                                    <a href="javascript:;" class="btn btn-xs red bt-delete-answer">
                                        <i class="fa fa-close"></i>
                                    </a>
                                    @endif
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Chi tiêu</label>
                                <div class="col-md-4">
                                    @if($configForm->getMonetary()==1) 
                                    <a href="javascript:;" class="btn btn-xs blue bt-delete-answer">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    @endif
                                    @if($configForm->getMonetary()==0) 
                                    <a href="javascript:;" class="btn btn-xs red bt-delete-answer">
                                        <i class="fa fa-close"></i>
                                    </a>
                                    @endif
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group last">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-3">
                                    <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/config-finish')}}" class="btn green btn-xs">
                                        <i class="fa fa-check"></i> Lưu</a>
                                    <button type="button" class="btn default btn-xs" onclick="history.go(-1);">Quay lại</button>
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
</script>
@stop