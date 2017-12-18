@extends('AdminMerchant.Layouts.default')
@section('slidebar')
@include('AdminMerchant.Layouts.slidebar',[
    'nav'=>'6',
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
            <h1>Tin tức
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
                    <form action="" method="POST" class="form-horizontal form-bordered">
                        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Tiêu đề</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Tiêu đề" name="name" value="{{$searchForm->getName()}}">
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Trạng thái</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="status" id="">
                                        <option value="" >Tất cả</option>
                                        <option value="ACTIVE" @if($searchForm->getStatus()=='ACTIVE')selected @endif >Hoạt động</option>
                                        <option value="INACTIVE" @if($searchForm->getStatus()=='INACTIVE')selected @endif >Không hoạt động</option>
                                    </select>
                                    <!-- /input-group -->
                                </div>
                            </div>

                            <div class="form-group last">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-3">
                                    <button type="submit" class="btn green btn-xs">
                                        <i class="fa fa-check"></i> Thống kê</button>
                                    <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/news/clear-search')}}" class="btn default btn-xs">Xóa</a>
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
                        <span class="caption-subject font-dark bold uppercase">Danh sách</span>
                        <span class="caption-helper"></span>
                    </div>
                    <div class="actions ">
                        <a href="{{Asset('/merchant/news/add')}}" class="btn green btn-xs">
                            <i class="fa fa-plus"></i> Thêm mới</a>

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
                                    <th>
                                        Kiểu
                                    </th>
                                    <th>
                                        Thông tin
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
                                    <td class="">
                                        <img width="200px" alt="" class="img-thumbnail" src="{{Asset($obj->images)}}">
                                    </td>
                                    <td> 
                                        {{$obj->name}}
                                    </td>
                                    <td>
                                         @if($obj->status == env('COMMON_STATUS_ACTIVE'))
                                            <span class="label label-sm label-mini label-success"> {{trans('common.COMMON_STATUS_'.$obj->status)}} </span>
                                          @elseif($obj->status == env('COMMON_STATUS_INACTIVE'))
                                            <span class="label label-sm label-mini label-danger"> {{trans('common.COMMON_STATUS_'.$obj->status)}} </span>
                                          @endif
                                    </td>
                                    <td>
                                        <a href="javascript:;" class="btn green btn-xs btn-outline sbold uppercase">
                                            <i class="fa fa-share"></i> Chi tiết </a>
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