@extends('AdminMerchant.Layouts.default')
@section('slidebar')
@include('AdminMerchant.Layouts.slidebar',[
'nav'=>'4',
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
            <h1>Cấu hình RFM
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
            <span class="active">Cấu hình RFM</span>
        </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
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
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Cấu hình RFM</span>
                        <span class="caption-helper"></span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/analysis-user/rfm/config-confirm')}}" class="form-horizontal form-bordered" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-2">Điểm tương ứng</label>
                                @if($rankUser!=null)
                                @for ($i = 0; $i < $rankUser; $i++)
                                <div class="col-md-2">
                                    {{$i+1}}
                                    <!-- /input-group -->
                                </div>
                                @endfor
                                @endif
                            </div>
                            @if($recensy!=null)
                            <h3>Sự gần đây (R - recensy)</h3>
                            <div class="form-group">
                                <label class="control-label col-md-2">Ngày</label>
                                @if($rankUser!=null)
                                @for ($i = 0; $i < $rankUser; $i++)
                                <div class="col-md-2">
                                    <input type="text" class="form-control number-format" name="recensy[]"  value="{{$listRecensy[$i]}}">
                                    <!-- /input-group -->
                                </div>
                                @endfor
                                @endif
                            </div>
                            @endif
                            @if($frequency!=null)
                            <h3>Tần suất giao dịch (F - frequency)</h3>
                            <div class="form-group">
                                <label class="control-label col-md-2">Lần</label>
                                @if($rankUser!=null)
                                @for ($i = 0; $i < $rankUser; $i++)
                                <div class="col-md-2">
                                    <input type="text" class="form-control number-format" name="frequency[]"  value="{{$listFrequency[$i]}}"  >
                                    <!-- /input-group -->
                                </div>
                                @endfor
                                @endif
                            </div>
                            @endif
                            @if($monetary!=null)
                            <h3>Chi tiêu (M - monetary)</h3>
                            <div class="form-group">
                                <label class="control-label col-md-2">Đồng</label>
                                @if($rankUser!=null)
                                @for ($i = 0; $i < $rankUser; $i++)
                                <div class="col-md-2">
                                    <input type="text" class="form-control number-format" name="monetary[]"  value="{{$listMonetary[$i]}}">
                                    <!-- /input-group -->
                                </div>
                                @endfor
                                @endif
                            </div>
                            @endif
                            <div class="form-group last">
                                <label class="control-label col-md-2"></label>
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
@stop
@section('javascript')
<script src="{{Asset('public/Lib/jquery-number/jquery.number.js')}}" type="text/javascript"></script> 

<script src="{{Asset('public/AdminMerchant/assets/pages/scripts/form_custom.js')}}" type="text/javascript"></script>


<script type="text/javascript">
$(document).ready(function () {
$('.number-format').number( true, 0 );
});
</script>
@stop