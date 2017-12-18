@extends('AdminMerchant.Layouts.default')
@section('slidebar')
@include('AdminMerchant.Layouts.slidebar',[
    'nav'=>'1',
    'sub'=>'1'
])
@stop
@section('content')
<div class="page-content">
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Tổng quan
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
        <!--
        <li>
            <a href="2-dashboard.html">Tổng quán</a>
            <i class="fa fa-circle"></i>
        </li>
    -->
        <li>
            <span class="active">Tổng quan</span>
        </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="987">987</span>
                    </div>
                    <div class="desc"> Khách hàng </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="450">450</span> </div>
                    <div class="desc"> Được xếp hạng</div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="300">300</span>
                    </div>
                    <div class="desc">Giao dịch  </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number"> 
                        <span data-counter="counterup" data-value="89">89</span> </div>
                    <div class="desc">  Đối tác </div>
                </div>
            </a>
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
                        <span class="caption-subject font-dark bold uppercase">Thống kê người dùng</span>
                        <span class="caption-helper"></span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- ** -->
                    <div id="chart_4" class="chart" style="height: 400px;"> </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
    <!-- END PAGE BASE CONTENT -->
</div>
@if($config)
<div class="modal fade bs-modal-lg" id="modalConfig" tabindex="-1" role="dialog" aria-hidden="true">
    
</div>
@endif
@stop
@section('css')
@stop
@section('javascript')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
</script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/amcharts/amcharts/amcharts.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/amcharts/amcharts/serial.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/amcharts/amcharts/themes/light.js')}}" type="text/javascript"></script>
<!-- ui block -->
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="{{Asset('public/AdminMerchant/assets/pages/scripts/dashboard_custom.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $('#modalConfig').modal('show');
    
    function saveChangeLevelUser(){
        
        $.ajax({
            type: "POST",
            url: "{{Asset('/merchant/config/level-user-fast')}}",
            data: $("#formLevelUser").serialize(),
            beforeSend: function() {
                App.blockUI({
                    target: '#formConfig'
                });
            },
            success:function(data){
                response = jQuery.parseJSON(data);
                if(response.code==100){
                    alert(response.message);
                }
                App.unblockUI('#formConfig');
            }
        });
    }
    
    function showInputValueCoin(el){
        $id = $(el).val();
        if($(el).is(":checked")){
            $("#value_"+$id).prop('disabled', false);
        }else{
            $("#value_"+$id).prop('disabled', true);
        }
    }
    
    
    $(window).load(function(){
        @if($config)
            $.ajax({
                type: "GET",
                url: "{{Asset('/merchant/config/level-user-fast')}}",
                success:function(result){
                    $("#modalConfig").html(result);
                    $('.valueCoin').prop('disabled', true);
                }
            });
        @endif
        
    });
</script>
@stop