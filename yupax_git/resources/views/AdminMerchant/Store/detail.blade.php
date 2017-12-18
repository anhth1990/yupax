@extends('AdminMerchant.Layouts.default')
@section('slidebar')
@include('AdminMerchant.Layouts.slidebar',[
    'nav'=>'3',
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
            <h1>Cửa hàng
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
            <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/store/list')}}">Danh sách</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">Chi tiết</span>
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
                        <span class="caption-subject font-dark bold uppercase">Chi tiết</span>
                        <span class="caption-helper"></span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form class="form-horizontal form-bordered">
                        <div class="form-body">
                            <h3>Thông tin cửa hàng</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tên cửa hàng</label>
                                <div class="col-md-4">
                                    {{$detailForm->getName()}}
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Logo</label>
                                <div class="col-md-4">
                                    <img src="{{Asset($detailForm->getLinkLogo())}}" width="200px">
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Trạng thái</label>
                                <div class="col-md-4">
                                    {{trans('common.COMMON_STATUS_'.$detailForm->getStatus())}}
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Ngày tạo</label>
                                <div class="col-md-4">
                                    {{$detailForm->getCreatedAt()}}
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Ngày cập nhật</label>
                                <div class="col-md-4">
                                    {{$detailForm->getUpdatedAt()}}
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group last">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9">
                                    <a class="btn green btn-xs" href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/store/edit/'.$detailForm->getHashcode())}}">
                                        <i class="fa fa-edit"></i> Chỉnh sửa</a>
                                    <a class="btn red btn-xs deleteActionStore">
                                        <i class="fa fa-close "></i> Xóa</a>
                                    <button type="button" class="btn default btn-xs" onclick="history.go(-1);">Quay lại</button>
                                </div>
                            </div>
                            <h3>Thông tin chi nhánh</h3>
                            <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                STT 
                                            </th>
                                            <th >
                                                Thông tin 
                                            </th>
                                            <th>
                                                Hình ảnh
                                            </th>
                                            <th> 
                                                Trạng thái
                                            </th>
                                            <th>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($listStoreBranch) && count($listStoreBranch)>0)
                                            @foreach($listStoreBranch as $key=>$obj)
                                        <tr>
                                            <td>
                                                <a href="javascript:;"> {{$key+1}} </a>
                                            </td>
                                            <td> 
                                                <i class="glyphicon glyphicon-header"></i> {{$obj->name}}<br>
                                                <i class="glyphicon glyphicon-phone"></i> {{$obj->mobile}}<br>
                                                <i class="glyphicon glyphicon-envelope"></i> {{$obj->email}}<br>
                                                <i class="glyphicon glyphicon-time"></i> {{$obj->openTime}} - {{$obj->closeTime}}
                                            </td>
                                            <td> 
                                                <img width="200px" src="{{Asset($obj->images)}}">
                                            </td>
                                            <td>
                                                @if($obj->status == env('COMMON_STATUS_ACTIVE'))
                                                <span class="label label-sm label-mini label-success"> {{trans('common.COMMON_STATUS_'.$obj->status)}} </span>
                                              @elseif($obj->status == env('COMMON_STATUS_INACTIVE'))
                                                <span class="label label-sm label-mini label-danger"> {{trans('common.COMMON_STATUS_'.$obj->status)}} </span>
                                              @endif
                                            </td>
                                            <td>
                                                <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/store/branch/edit/'.$obj->hashcode)}}" class="btn green btn-xs">
                                                    <i class="fa fa-edit"></i> Chỉnh sửa </a>
                                                    <a class="btn red btn-xs deleteActionBranch" data-id="{{$obj->hashcode}}">
                                                        <i class="fa fa-close"></i> Xóa</a>
                                            </td>
                                        </tr>
                                                @endforeach
                                        @endif
                                        
                                    </tbody>
                                </table>
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
<link href="{{Asset('public/AdminMerchantassets/global/plugins/clockface/css/clockface.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{Asset('public/AdminMerchant/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
@stop
@section('javascript')
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/clockface/js/clockface.js')}}" type="text/javascript"></script>

<script src="{{Asset('public/AdminMerchant/assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/jquery.pulsate.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/global/plugins/bootstrap-summernote/summernote.min.js')}}" type="text/javascript"></script>
<script src="{{Asset('public/AdminMerchant/assets/pages/scripts/form_custom.js')}}" type="text/javascript"></script>

<script type='text/javascript'
src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM&sensor=false'>
</script>
<script type="text/javascript">
$(document).ready(function(){
    $(".deleteActionBranch").on('click',function(){
        $confirm = confirm("Bạn có tiếp tục xóa ?");
        $hashcode = $(this).attr('data-id');
        if($confirm){
            $.ajax({
                type: "POST",
                url: '/stripe/merchant/store/branch/delete',
                data:'hashcode='+$hashcode,
                success:function(data){
                    $response = jQuery.parseJSON(data);
                    alert($response.errMess);
                    if($response.errCode==200){
                        location.reload();
                    }
                }
            });
        }
    })
    
    $(".deleteActionStore").on('click',function(){
        $confirm = confirm("Bạn có tiếp tục xóa ?");
        if($confirm){
            $.ajax({
                type: "POST",
                url: '/stripe/merchant/store/delete',
                data:'hashcode='+'{{$detailForm->getHashcode()}}',
                success:function(data){
                    $response = jQuery.parseJSON(data);
                    alert($response.errMess);
                    if($response.errCode==200){
                        window.location.href = "{{Asset('merchant/store/list')}}";
                    }
                }
            });
        }
    })
})
</script>
@stop