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
                <h1>Admin Dashboard
                    <small>...</small>
                </h1>
            </div>
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">Charts</span>
            </li>
        </ul>
        <!-- END PAGE BREADCRUMB -->

        <div class="row">
            <form class="form-horizontal" role="form" id="reportForm" name="reportForm"
                  action="{{ route('report.reportGroup') }}" method="GET">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-1 uppercase">BÁO CÁO</label>
                        <div class="col-md-2">
                            <select class="form-control" name="company">
                                <option value="redsun" {{ strtolower(app('request')->input('company')) === "redsun" ? "selected" : "" }}>
                                    Redsun
                                </option>
                                <option value="canifa" {{ strtolower(app('request')->input('company')) === "canifa" ? "selected" : "" }}>
                                    CANIFA
                                </option>
                            </select>
                        </div>

                        <label class="control-label col-md-1">KHU VỰC</label>
                        <div class="col-md-2">
                            <select class="form-control" name="area">
                                @foreach($data['areas'] as $key => $value)
                                    <option value="{{ $value }}" {{ strtolower(app('request')->input('area')) === strtolower($value) ? "selected" : "" }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @include('AdminMerchant.Report.vip-group')

        @include('AdminMerchant.Report.loyal-group')

        @include('AdminMerchant.Report.new-group')

        @include('AdminMerchant.Report.coming-out-group')
    </div>
    <!-- END CONTENT BODY -->
@stop
@section('css')
    <link href="{{Asset('public/AdminMerchant/assets/global/plugins/morris/morris.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{Asset('public/AdminMerchant/assets/pages/css/report.css')}}" rel="stylesheet" type="text/css"/>
@stop
@section('javascript')
    <script src="{{Asset('public/Admin/plugins/flot/jquery.flot.min.js')}}" type="text/javascript"></script>
    <script src="{{Asset('public/Admin/plugins/flot/jquery.flot.resize.min.js')}}" type="text/javascript"></script>
    <script src="{{Asset('public/Admin/plugins/highcharts/js/highcharts.js')}}" type="text/javascript"></script>
    <script src="{{Asset('public/AdminMerchant/assets/global/plugins/morris/morris.min.js')}}"
            type="text/javascript"></script>
    <script src="{{Asset('public/AdminMerchant/assets/global/plugins/morris/raphael-min.js')}}"
            type="text/javascript"></script>
    <script src="{{Asset('public/AdminMerchant/assets/pages/scripts/report-group.js')}}"
            type="text/javascript"></script>
@stop