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
            <h1>Chi nhánh 
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
            <span class="active">Chỉnh sửa</span>
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
                    <form action="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT').'/store/branch/edit-confirm')}}" class="form-horizontal form-bordered" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
                        <input type="hidden" name="lat" id="lat" value="{{$editForm->getLat()}}">
                        <input type="hidden" name="long" id="long" value="{{$editForm->getLong()}}">
                        <input type="hidden" name="hashcode" id="" value="{{$editForm->getHashcode()}}">
                        <input type="hidden" name="storeHashcode" id="" value="{{$editForm->getStoreHashcode()}}">
                        <input type="hidden" name="name" id="" value="{{$editForm->getName()}}">
                        <input type="hidden" name="linkLogo" id="" value="{{$editForm->getLinkLogo()}}">
                        <input type="hidden" name="linkImages" id="" value="{{$editForm->getLinkImages()}}">
                        <div class="form-body">
                            <h3>Thông tin cửa hàng</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tên cửa hàng</label>
                                <div class="col-md-4">
                                    {{$editForm->getName()}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Logo</label>
                                <div class="col-md-4">
                                    <img src="{{Asset($editForm->getLinkLogo())}}" width="200px">
                                </div>
                            </div>
                            <h3>Chi nhánh</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tên chi nhánh</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Tên chi nhánh" name="nameBranch" value="{{$editForm->getNameBranch()}}">
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Hình ảnh</label>
                                <div class="col-md-4">
                                    <input type="file" name="dataFileImages" id="select-image">
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">&nbsp;</label>
                                <div class="col-md-4">
                                    <img id="image-branch" src="{{Asset($editForm->getLinkImages())}}" width="200px"/>
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Số điện thoại</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Số điện thoại" name="mobile" value="{{$editForm->getMobile()}}">
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Email</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Email" name="email" value="{{$editForm->getEmail()}}">
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Giờ mở cửa</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker timepicker-24" name="openTime" value="{{$editForm->getOpenTime()}}">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Giờ đóng cửa</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker timepicker-24" name="closeTime" value="{{$editForm->getCloseTime()}}">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tỉnh / Thành phố</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="provinceId" id="provinceId">
                                        <option value="">{{trans("common.please_choose")}}</option>
                                    </select>
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Quận / Huyện</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="districtId" id="districtId">
                                        <option value="">{{trans("common.please_choose")}}</option>
                                    </select>
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Phường / Xã</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="wardId" id="wardId">
                                        <option value="">{{trans("common.please_choose")}}</option>
                                    </select>
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Địa chỉ</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="address" placeholder="Địa chỉ" name="address" value="{{$editForm->getAddress()}}">
                                    <!-- /input-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">&nbsp;</label>
                                <div class="col-md-4">
                                    <div id='map_canvas' style='width:400px; height:500px;'></div>
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
    $('#select-image').change(function(e){
        var fileName = e.target.files[0].name;
        $("#image-branch").attr('src',window.URL.createObjectURL(e.target.files[0]));
        //console.log(e.target.files[0])
    });
    $("#provinceId").select2();
    $("#districtId").select2();
    $("#wardId").select2();
    $("body").attr("onload","initialize('','')");
    $("#provinceId").html(getProvince());
    $("#provinceId").on("change",function(){
       $provinceId = $(this).val();
       $("#districtId").html(getDistrict($provinceId));
       $("#wardId").html(getWard(''))
    });
    $("#districtId").on("change",function(){
       $districtId = $(this).val();
       $("#wardId").html(getWard($districtId));
    });
    $("#address").on("blur",function(){
        $val = $(this).val();
        getLatLong($val);
    });
    $("#address").on("keyup",function(){
        $val = $(this).val();
        getLatLong($val);
    });
    @if ($editForm->getAddress()!=null)
        getLatLong($("#address").val());
    @endif
    @if ($editForm->getProvinceId()!=null)
        $provinceId = $("#provinceId").val();
        $("#districtId").html(getDistrict($provinceId));
    @endif
    @if ($editForm->getDistrictId()!=null)
        $districtId = $("#districtId").val();
        $("#wardId").html(getWard($districtId));
    @endif
    // time clock
    $('.timepicker-24').timepicker({
        autoclose: true,
        minuteStep: 5,
        showSeconds: false,
        showMeridian: false,
        defaultTime: ''
    });
});

function getLatLong($val){
    $.ajax({
         type: "GET",
         url: "{{Asset('/getLatLong')}}",
         data: "address="+$val,
         cache: false,
         success: function(response)
         {
             var obj = jQuery.parseJSON(response);
             initialize(obj.lat,obj.long);
             $("#lat").val(obj.lat);
             $("#long").val(obj.long);
         }
     });
}

function initialize(latitude,longitude)
{
    var myLatLng = new google.maps.LatLng(latitude,longitude);

    var mapProp = {
        zoom:17,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map=new google.maps.Map(document.getElementById('map_canvas'),mapProp);

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        optimized: false,
        title:'Former About.com Headquarters'
    }); 
}
/*
* list province - district - ward
*/
function getProvince(){
   $html ='<option value="">{{trans("common.please_choose")}}</option>';
   @foreach ($listProvince as $province)
       $selected='';
      @if ($editForm->getProvinceId()!=null && $province->provinceid==$editForm->getProvinceId())
          $selected = 'selected'; 
      @endif 
      $html+='<option value="{{$province->provinceid}}" '+$selected+' >'+unescape("{{$province->type.' '.$province->name}}")+'</option>';
   @endforeach
   return $html;
}

function getDistrict($provinceId){
   $html ='<option value="">{{trans("common.please_choose")}}</option>';
   @foreach ($listDistrict as $district)
      if({{$district->provinceid}} == $provinceId){
          $selected='';
           @if ($editForm->getDistrictId()!=null && $district->districtid==$editForm->getDistrictId())
               $selected = 'selected'; 
           @endif 
           $html+='<option value="{{$district->districtid}}" ' +$selected+ '>'+unescape("{{$district->type.' '.$district->name}}")+'</option>';
   }
   @endforeach
   return $html;
}

function getWard($districtId){
   $html ='<option value="">{{trans("common.please_choose")}}</option>';
   @foreach ($listWard as $ward)
      if({{$ward->districtid}} == $districtId){
          $selected='';
           @if ($editForm->getWardId()!=null && $ward->wardid==$editForm->getWardId())
               $selected = 'selected'; 
           @endif 
           $html+='<option value="{{$ward->wardid}}" ' +$selected+' >'+unescape("{{$ward->type.' '.$ward->name}}")+'</option>';
       }
   @endforeach
   return $html;
}
</script>
@stop