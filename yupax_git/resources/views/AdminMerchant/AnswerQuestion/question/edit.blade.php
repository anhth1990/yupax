@extends('AdminMerchant.Layouts.default')
@section('slidebar')
@include('AdminMerchant.Layouts.slidebar',[
    'nav'=>'9',
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
            <h1>Khảo sát - Câu trả lời
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
            <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/answer-question/detail/'.$editForm->getHashcodeAnswer())}}">Danh sách</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Chỉnh sửa</span>
        </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
             <!-- BEGIN PORTLET-->
             <div class="portlet light bordered" id="blockui_sample_1_portlet_body">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Chỉnh sửa</span>
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
                                <div class="mt-step-content font-grey-cascade">Nhập dữ liệu</div>
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
                    <form action="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/answer/question/edit-confirm')}}" class="form-horizontal form-bordered" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                        <input type="hidden" name="hashcode" value="{{$editForm->getHashcode()}}">
                        <input type="hidden" name="hashcodeAnswer" value="{{$editForm->getHashcodeAnswer()}}">
                        <div class="form-body">
                            <h3>Câu hỏi</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Câu hỏi</label>
                                <div class="col-md-6">
                                    {{$editForm->getAnswer()}}
                                    <input type="hidden" name="answer" value="{{$editForm->getAnswer()}}">
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Kiểu</label>
                                <div class="col-md-4">
                                    {{trans('common.answer_question_type_'.$editForm->getType())}}
                                    <input type="hidden" name="type" value="{{$editForm->getType()}}">
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Trạng thái</label>
                                <div class="col-md-4">
                                    {{trans('common.COMMON_STATUS_'.$editForm->getStatusAnswer())}}
                                    <input type="hidden" name="statusAnswer" value="{{$editForm->getStatusAnswer()}}">
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <h3>Câu trả lời</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Câu trả lời</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Câu trả lời" name="name" value="{{$editForm->getName()}}">
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Kết quả</label>
                                <div class="col-md-6">
                                    <input type="checkbox" value="1" name="result" @if($editForm->getResult()==1) checked  @endif />
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Trạng thái</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="status" id="">
                                        <option value="ACTIVE" @if($editForm->getStatus()=='ACTIVE')selected @endif >Hoạt động</option>
                                        <option value="INACTIVE" @if($editForm->getStatus()=='INACTIVE')selected @endif >Không hoạt động</option>
                                    </select>
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group last">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-3">
                                    <button type="submit" class="btn green btn-xs">
                                        <i class="fa fa-check"></i> Xác nhận</button>
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
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/clockface/css/clockface.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
@stop
@section('javascript')
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>

<script src="{{Asset('public/AdminMerchant/assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/jquery.pulsate.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/pages/scripts/form_custom.js')}}" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
    
});
</script>
@stop