@extends('AdminMerchant.Layouts.default')
@section('slidebar')
@include('AdminMerchant.Layouts.slidebar',[
    'nav'=>'8',
    'sub'=>'9'
])
@stop
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Đặt món
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
            <span class="active">Thống kê</span>
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
                    <form action="" class="form-horizontal form-bordered" method="POST">
                        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Lựa chọn khoảng thời gian</label>
                                <div class="col-md-4">
                                    <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="dd/mm/yyyy">
                                        <input type="text" class="form-control" name="fromDate" value="{{$searchForm->getFromDate()}}">
                                        <span class="input-group-addon"> đến </span>
                                        <input type="text" class="form-control" name="toDate" value="{{$searchForm->getToDate()}}" > </div>
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Cửa hàng</label>
                                <div class="col-md-4">
                                    <select class="form-control select2" name="store">
                                        <option></option>
                                        <option value="1" @if ($searchForm->getTimeSlot() ==1)selected @endif >King BBQ</option>
                                        <option value="2" @if ($searchForm->getTimeSlot() ==2)selected @endif >CarricciosA</option>
                                        <option value="3" @if ($searchForm->getTimeSlot() ==3)selected @endif >Tasaki BBQ</option>
                                        <option value="4" @if ($searchForm->getTimeSlot() ==4)selected @endif >Hotpot</option>
                                        <option value="5" @if ($searchForm->getTimeSlot() ==5)selected @endif >SuShi Kei</option>
                                        <option value="6" @if ($searchForm->getTimeSlot() ==6)selected @endif >ThaiExpress</option>
                                        <option value="7" @if ($searchForm->getTimeSlot() ==7)selected @endif >XinWang</option>
                                    </select>
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group last">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-3">
                                    <button type="submit" class="btn green">
                                    <i class="fa fa-check"></i> Thống kê</button>
                                    <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/clear-search-revpash')}}" class="btn default">Đặt món</a>
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
   
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Đặt món</span>
                        <span class="caption-helper">
                            @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getStore()!=null)
                            Từ ngày {{$searchForm->getFromDate()}} - {{$searchForm->getToDate()}}
                            @endif
                        </span>
                    </div>
                </div>
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getStore()!=null)
                <div class="portlet-body">
                    <h4 class="block">King BBQ</h4>
                    <div id="revpash" style="height:500px;"></div>
                </div>
                 @endif
                
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
    
    <!-- END PAGE BASE CONTENT -->
</div>
<!-- END CONTENT BODY -->

@stop
@section('css')
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css" />
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
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/morris/raphael-min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/pages/scripts/charts-morris-custom.js')}}" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){
    
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getStore()!=null)
     // BAR CHART revenue
     new Morris.Bar({
      element: 'revpash',
      data: [
        { y: 'Lẩu', a: 30 , b:65},
        { y: 'Gỏi cuốn', a: 42 , b:55},
        { y: 'Phở', a: 45 , b:35},
        { y: 'Các món rau xào', a: 35 , b:50},
        { y: 'Các món thịt', a: 40 , b:50 },
        { y: 'Cơm chiên', a: 42 , b:40}
      ],
      xkey: 'y',
      ykeys: ['a','b'],
      labels: ['Ngày trong tuần','Ngày cuối tuần'],
      barSizeRatio: 0.3
    });    
    @endif
    
    
    
})
</script>
@stop