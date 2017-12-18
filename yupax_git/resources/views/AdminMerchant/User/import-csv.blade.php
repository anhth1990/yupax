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
            <a href="{{Asset('/merchant')}}">Tổng quan</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{Asset('/merchant/user/list')}}">Danh sách</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Nhập dữ liệu CSV</span>
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
                        <span class="caption-subject font-dark bold uppercase">Nhập dữ liệu CSV</span>
                        <span class="caption-helper"></span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- ** -->
                    <div class="mt-element-step">
                        <div class="row step-thin">
                            <div class="col-md-4 bg-grey mt-step-col active">
                                <div class="mt-step-number bg-white font-grey">1</div>
                                <div class="mt-step-title uppercase font-grey-cascade">Bước 1</div>
                                <div class="mt-step-content font-grey-cascade">Chọn dữ liệu thực thi</div>
                            </div>
                            <div class="col-md-4 bg-grey mt-step-col ">
                                <div class="mt-step-number bg-white font-grey">2</div>
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
                    <form action="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/user/import-csv-confirm')}}" method="POST" class="horizontal-form">
                        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Dữ liệu</label>
                                        <select class="form-control select2" data-placeholder="Mời chọn" tabindex="1" name="file">
                                            <option value="">Mời chọn</option>
                                            @if(isset($listFile) && count($listFile)>0)
                                                @foreach($listFile as $key=>$obj)
                                            <option value="{{$obj->hashcode}}">{{$obj->name}} - <?php echo date_format(date_create($obj->created_at),"d/m/Y H:i:s"); ?> - {{trans('common.COMMON_STATUS_'.$obj->status)}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->

                        </div>
                        <div class="form-actions ">
                            <button type="submit" class="btn green btn-xs">
                                <i class="fa fa-check"></i> Xác nhận</button>
                            <button type="button" class="btn default btn-xs" onclick="history.go(-1);">Quay lại</button>

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