@extends('AdminMerchant.Layouts.default')
@section('slidebar')
@include('AdminMerchant.Layouts.slidebar',[
    'nav'=>'8',
    'sub'=>'12'
])
@stop
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Tổng quan thống kê
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
            <span class="active">Thống kê - tổng quan</span>
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
                                <label class="control-label col-md-3">Thương hiệu</label>
                                <div class="col-md-4">
                                    <select class="form-control select2" name="timeSlot">
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
                                    <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/statistical/clear-search')}}" class="btn default">Xóa</a>
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
                        <span class="caption-subject font-dark bold uppercase">Tổng quan</span>
                        <span class="caption-helper">
                            @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null)
                            Từ ngày {{$searchForm->getFromDate()}} - {{$searchForm->getToDate()}}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
   
    <div class="row">
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Tổng doanh thu</span>
                    </div>
                </div>
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
                <div class="portlet-body">
                    <div id="morris_chart_3" style="height:500px;"></div>
                </div>
                 @endif
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()!=null)
                <div class="portlet-body">
                    <h4 class="block">King BBQ</h4>
                    <div id="revenue_time_slot" style="height:500px;"></div>
                </div>
                 @endif
            </div>
            <!-- END PORTLET-->
        </div>
        
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Chỉ số REVPASH ( vnd/bàn/giờ )</span>
                        <span class="caption-helper">
                        </span>
                    </div>
                </div>
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
                <div class="portlet-body">
                    <div id="revpash" style="height:500px;"></div>
                </div>
                 @endif
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()!=null)
                <div class="portlet-body">
                    <h4 class="block">King BBQ</h4>
                    <div id="revpash_time_slot" style="height:500px;"></div>
                </div>
                 @endif
            </div>
            <!-- END PORTLET-->
        </div>
        
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Chỉ số REVTAB ( vnd/bàn/ngày )</span>
                        <span class="caption-helper">
                            
                        </span>
                    </div>
                </div>
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
                <div class="portlet-body">
                    <div id="revtab" style="height:500px;"></div>
                </div>
                 @endif
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()!=null)
                <div class="portlet-body">
                    <h4 class="block">King BBQ</h4>
                    <div id="revtab_time_slot" style="height:500px;"></div>
                </div>
                 @endif
            </div>
            <!-- END PORTLET-->
        </div>
        
    </div>
    
    <div class="row">
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Chỉ số REVBILL ( vnd/hóa đơn )</span>
                        <span class="caption-helper">
                           
                        </span>
                    </div>
                </div>
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
                <div class="portlet-body">
                    <div id="revbill" style="height:500px;"></div>
                </div>
                 @endif
                 
            </div>
            <!-- END PORTLET-->
        </div>
        
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Chỉ số REVPAM ( vnd/m2 )</span>
                        <span class="caption-helper">
                            
                        </span>
                    </div>
                </div>
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
                <div class="portlet-body">
                    <div id="revpam" style="height:500px;"></div>
                </div>
                 @endif
                 
            </div>
            <!-- END PORTLET-->
        </div>
        
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Chỉ số khách hàng</span>
                        <span class="caption-helper">
                            
                        </span>
                    </div>
                </div>
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
                <div class="portlet-body">
                    <div id="guest" style="height:500px;"></div>
                </div>
                 @endif
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()!=null)
                <div class="portlet-body">
                    <h4 class="block">King BBQ</h4>
                    <div id="guest_time_slot" style="height:500px;"></div>
                </div>
                 @endif
            </div>
            <!-- END PORTLET-->
        </div>
        
    </div>
    
    
    <div class="row">
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Thời gian TB 1 lượt khách</span>
                        <span class="caption-helper">
                        </span>
                    </div>
                </div>
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
                <div class="portlet-body">
                    <div id="turntime" style="height:500px;"></div>
                </div>
                 @endif
            </div>
            <!-- END PORTLET-->
        </div>
        
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Thiếu món</span>
                        <span class="caption-helper">
                            
                        </span>
                    </div>
                </div>
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
                <div class="portlet-body">
                    <div id="unavaibilyti" style="height:500px;"></div>
                </div>
                 @endif
                 
            </div>
            <!-- END PORTLET-->
        </div>
        
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Phàn nàn / hóa đơn</span>
                        <span class="caption-helper">
                            
                        </span>
                    </div>
                </div>
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
                <div class="portlet-body">
                    <div id="complaint" style="height:500px;"></div>
                </div>
                 @endif
                 
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Đặt món</span>
                        <span class="caption-helper">
                           
                        </span>
                    </div>
                </div>
                 @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()!=null)
                <div class="portlet-body">
                    <h4 class="block">King BBQ</h4>
                    <div id="meal" style="height:500px;"></div>
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
    $('#body_custom').addClass('page-full-width');
    
    
    
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
     // BAR CHART revenue
     new Morris.Bar({
      element: 'morris_chart_3',
      data: [
        { y: 'King BBQ', a: 672000 },
        { y: 'CarricciosA', a: 630000},
        { y: 'Tasaki BBQ', a: 588000},
        { y: 'Hotpot', a: 320000},
        { y: 'SuShi Kei', a: 271765 },
        { y: 'ThaiExpress', a: 320000},
        { y: 'XinWang', a: 588000}
      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['vnd'],
      barSizeRatio: 0.6
    });    
    @endif
    
    
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()!=null)
     // BAR CHART revenue-time-slot
    new Morris.Bar({
      element: 'revenue_time_slot',
      data: [
        { y: '9h - 11h', a: 588 },
        { y: '11h - 14h', a: 4853},
        { y: '14h - 17h', a: 2500},
        { y: '17h - 20h', a: 11000},
        { y: '20h - 22h', a: 7500 }
      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['vnd'],
      barSizeRatio: 0.6
    });
    @endif
    
    // revpash
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
     // BAR CHART revenue
     new Morris.Bar({
      element: 'revpash',
      data: [
        { y: 'King BBQ', a: 240 , b:297},
        { y: 'CarricciosA', a: 225 , b:244},
        { y: 'Tasaki BBQ', a: 210 , b:252},
        { y: 'Hotpot', a: 12 , b:53},
        { y: 'SuShi Kei', a: 97 , b:135 },
        { y: 'ThaiExpress', a: 97 , b:85},
        { y: 'XinWang', a: 110 , b:120}
      ],
      xkey: 'y',
      ykeys: ['a','b'],
      labels: ['Ngày trong tuần','Ngày cuối tuần'],
      barSizeRatio: 0.6
    });    
    @endif
    
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()!=null)
     // BAR CHART revenue-time-slot
    new Morris.Bar({
      element: 'revpash_time_slot',
      data: [
        { y: '9h - 11h', a: 12 },
        { y: '11h - 14h', a: 97},
        { y: '14h - 17h', a: 50},
        { y: '17h - 20h', a: 220},
        { y: '20h - 22h', a: 150 }
      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['vnd'],
      barSizeRatio: 0.6
    });
    @endif
    
    // revtab
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
     // BAR CHART revenue
     new Morris.Bar({
      element: 'revtab',
      data: [
        { y: 'King BBQ', a: 240 , b:297},
        { y: 'CarricciosA', a: 225 , b:244},
        { y: 'Tasaki BBQ', a: 210 , b:252},
        { y: 'Hotpot', a: 12 , b:53},
        { y: 'SuShi Kei', a: 97 , b:135 },
        { y: 'ThaiExpress', a: 97 , b:85},
        { y: 'XinWang', a: 110 , b:120}
      ],
      xkey: 'y',
      ykeys: ['a','b'],
      labels: ['Ngày trong tuần','Ngày cuối tuần'],
      barSizeRatio: 0.6
    });    
    @endif
    
    
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()!=null)
     // BAR CHART revenue-time-slot
    new Morris.Bar({
      element: 'revtab_time_slot',
      data: [
        { y: '9h - 11h', a: 12 },
        { y: '11h - 14h', a: 97},
        { y: '14h - 17h', a: 50},
        { y: '17h - 20h', a: 220},
        { y: '20h - 22h', a: 150 }
      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['vnd'],
      barSizeRatio: 0.6
    });
    @endif
    
    // revbill
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
     // BAR CHART revenue
     new Morris.Bar({
      element: 'revbill',
      data: [
        { y: 'King BBQ', a: 1008 , b:1248},
        { y: 'CarricciosA', a: 1305 , b:1416},
        { y: 'Tasaki BBQ', a: 966 , b:1299},
        { y: 'Hotpot', a: 180 , b:265},
        { y: 'SuShi Kei', a: 252 , b:352 },
        { y: 'ThaiExpress', a: 417 , b:367},
        { y: 'XinWang', a: 510 , b:800}
      ],
      xkey: 'y',
      ykeys: ['a','b'],
      labels: ['Ngày trong tuần','Ngày cuối tuần'],
      barSizeRatio: 0.6
    });    
    @endif
    // revpam
     @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
     // BAR CHART revenue
     new Morris.Bar({
      element: 'revpam',
      data: [
        { y: 'King BBQ', a: 26880 },
        { y: 'CarricciosA', a: 25200},
        { y: 'Tasaki BBQ', a: 27671 },
        { y: 'Hotpot', a: 11757 },
        { y: 'SuShi Kei', a: 13588  },
        { y: 'ThaiExpress', a: 12789 },
        { y: 'XinWang', a: 12789 }
      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['vnd'],
      barSizeRatio: 0.6
    });    
    @endif
    
    // guest
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
     // BAR CHART revenue
     new Morris.Bar({
      element: 'guest',
      data: [
        { y: 'King BBQ', a: 2240},
        { y: 'CarricciosA', a: 2100},
        { y: 'Tasaki BBQ', a: 1960},
        { y: 'Hotpot', a: 325},
        { y: 'SuShi Kei', a:  906},
        { y: 'ThaiExpress', a: 906},
        { y: 'XinWang', a: 800}
      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Khách'],
      barSizeRatio: 0.6
    });    
    @endif
    
    
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()!=null)
     // BAR CHART revenue-time-slot
    new Morris.Bar({
      element: 'guest_time_slot',
      data: [
        { y: '9h - 11h', a: 2 },
        { y: '11h - 14h', a: 16},
        { y: '14h - 17h', a: 8},
        { y: '17h - 20h', a: 37},
        { y: '20h - 22h', a: 25 }
      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Khách'],
      barSizeRatio: 0.6
    });
    @endif
    
    // turntime
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null  && $searchForm->getTimeSlot()==null)
     // BAR CHART revenue
     new Morris.Bar({
      element: 'turntime',
      data: [
        { y: 'King BBQ', a:50  , b:65},
        { y: 'CarricciosA', a:42  , b:56},
        { y: 'Tasaki BBQ', a:45  , b:60},
        { y: 'Hotpot', a:35  , b:50},
        { y: 'SuShi Kei', a:40  , b:50},
        { y: 'ThaiExpress', a:42  , b:55},
        { y: 'XinWang', a:35  , b:53}
      ],
      xkey: 'y',
      ykeys: ['a','b'],
      labels: ['Ngày trong tuần','Ngày cuối tuần'],
      barSizeRatio: 0.6
    });    
    @endif
    
    // dat mon meal
     @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()!=null)
     // BAR CHART revenue
     new Morris.Bar({
      element: 'meal',
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
      barSizeRatio: 0.6
    });    
    @endif
    
    // complaint-bill
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
     // BAR CHART revenue
     new Morris.Bar({
      element: 'complaint',
      data: [
        { y: 'King BBQ', a: 0.17},
        { y: 'CarricciosA', a: 0.23},
        { y: 'Tasaki BBQ', a: 0.18},
        { y: 'Hotpot', a: 0.05},
        { y: 'SuShi Kei', a:  0.10},
        { y: 'ThaiExpress', a: 0.17},
        { y: 'XinWang', a: 0.16}
      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Lần'],
      barSizeRatio: 0.6
    });    
    @endif
    
    //unavaibilyti
    @if($searchForm->getFromDate()!=null && $searchForm->getToDate()!=null && $searchForm->getTimeSlot()==null)
     // BAR CHART revenue
     new Morris.Bar({
      element: 'unavaibilyti',
      data: [
        { y: 'King BBQ', a: 0.17},
        { y: 'CarricciosA', a: 0.23},
        { y: 'Tasaki BBQ', a: 0.18},
        { y: 'Hotpot', a: 0.05},
        { y: 'SuShi Kei', a:  0.10},
        { y: 'ThaiExpress', a: 0.17},
        { y: 'XinWang', a: 0.16}
      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Lần'],
      barSizeRatio: 0.6
    });    
    @endif
    
})
</script>
@stop