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
            <form class="form-horizontal" role="form" id="reportForm" name="reportForm" action="{{ route('report.index') }}" method="GET">
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

                        <label class="control-label col-md-1">NĂM</label>
                        <div class="col-md-2">
                            <select class="form-control" name="year">
                                <option value="2017" {{ app('request')->input('year') == 2017 ? "selected" : "" }}>
                                    2017
                                </option>
                                <option value="2016" {{ app('request')->input('year') == 2016 ? "selected" : "" }}>
                                    2016
                                </option>
                            </select>
                        </div>

                        <label class="control-label col-md-1">THỜI GIAN</label>
                        <div class="col-md-2">
                            <select class="form-control" name="report-time">
                                <option value="quy" {{ app('request')->input('report-time') === "quy" ? "selected" : "" }}>
                                    Quý
                                </option>
                                <option value="thang" {{ app('request')->input('report-time') === "thang" ? "selected" : "" }}>
                                    Tháng
                                </option>
                                <option value="nam" {{ app('request')->input('report-time') === "nam" ? "selected" : "" }}>
                                    Năm
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row same-height-parent">
            <div class="col-md-2 padding-right-0">
                <div class="highlight-yellow-box">
                    <div class="title">TỔNG DOANH THU</div>
                    <div class="highlight-number">
                        {{ $data['revenue_total'] }}
                        <hr>
                        <div>VND</div>
                    </div>
                </div>

                <div class="highlight-blue-box">
                    <div class="title">TỔNG SỐ GIAO DỊCH</div>
                    <div class="highlight-number">
                        {{ $data['transactions_total'] }}
                        <hr>
                        <div>giao dịch</div>
                    </div>
                </div>
            </div>

            @if (isset($data['revenue_highchart']))
            <div class="col-md-5 padding-right-0">
                <div class="portlet light portlet-fit bordered">
                    <div class="portlet-body">
                        <div id="revenue_highchart" class="highchart" data-content="{{ $data['revenue_highchart'] }}"></div>
                    </div>
                </div>
            </div>
            @endif

            @if (isset($data['transaction_hightchart']))
            <div class="col-md-5">
                <div class="portlet light portlet-fit bordered">
                    <div class="portlet-body">
                        <div id="transaction_hightchart" class="highchart" data-content="{{ $data['transaction_hightchart'] }}"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @if (isset($data['highlighted_number']))
        <div class="row same-height-parent">
            <div class="col-md-12">
                <div class="statistic-number">
                    <table class="report-table">
                        <tr class="header">
                            <td width="25%">HOÁ ĐƠN TRUNG BÌNH</td>
                            <td width="25%">HOÁ ĐƠN CAO NHẤT/NGÀY</td>
                            <td width="25%">MAX SỐ GIAO DỊCH/NGÀY</td>
                            <td width="25%">ĐỔI TRẢ/KHIẾU NẠI</td>
                        </tr>
                        <tr>
                            <td class="border-right">{{ $data['highlighted_number']['average_invoice'] }}</td>
                            <td class="border-right">{{ $data['highlighted_number']['highest_invoice'] }}</td>
                            <td class="border-right">{{ $data['highlighted_number']['maximum_transaction_per_day'] }}</td>
                            <td class="border-right-none">{{ $data['highlighted_number']['refund'] }}%</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <div class="row margin-top-15" >
            @if (isset($data['transaction_by_hours']))
            <div class="col-md-6 padding-right-7">
                <div class="portlet light portlet-fit bordered">
                    <div class="portlet-title">
                        <div class="caption text-center">
                            <span class="caption-subject uppercase">SỐ LƯỢNG GIAO DỊCH THEO KHUNG GIỜ</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="transaction_by_hours" data-content="{{ $data['transaction_by_hours'] }}"></div>
                    </div>
                </div>
            </div>
            @endif

            @if (isset($data['average_invoice_by_hours']))
            <div class="col-md-6 padding-left-7">
                <div class="portlet light portlet-fit bordered">
                    <div class="portlet-title">
                        <div class="caption text-center">
                            <span class="caption-subject uppercase">HOÁ ĐƠN TRUNG BÌNH THEO KHUNG GIỜ</span>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div id="average_invoice_by_hours" data-content="{{ $data['average_invoice_by_hours'] }}"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row same-height-parent padding-right-0">
            @if (isset($data['products_ration_by_week']))
            <div class="col-md-6 padding-right-7">
                <div class="portlet light portlet-fit bordered">
                    <div class="portlet-title">
                        <div class="caption text-center">
                            <span class="caption-subject uppercase">Nhóm sản phẩm bán theo tỷ lệ</span><br/>
                            <span class="italic">ngày trong tuần</span>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div id="products_ration_by_week" class="chart" data-content="{{ $data['products_ration_by_week'] }}"></div>
                    </div>
                </div>
            </div>
            @endif

            @if (isset($data['products_ration_by_weekend']))
            <div class="col-md-6 padding-left-7">
                <div class="portlet light portlet-fit bordered">
                    <div class="portlet-title">
                        <div class="caption text-center">
                            <span class="caption-subject uppercase">Nhóm sản phẩm bán theo tỷ lệ</span><br/>
                            <span class="italic">ngày cuối tuần</span>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div id="products_ration_by_weekend" class="chart" data-content="{{ $data['products_ration_by_week'] }}"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- END PIE CHART PORTLET-->
    </div>
    <!-- END CONTENT BODY -->
@stop
@section('css')
    <link href="{{Asset('public/AdminMerchant/assets/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{Asset('public/AdminMerchant/assets/pages/css/report.css')}}" rel="stylesheet" type="text/css"/>
@stop
@section('javascript')
    <script src="{{Asset('public/Admin/plugins/flot/jquery.flot.min.js')}}" type="text/javascript"></script>
    <script src="{{Asset('public/Admin/plugins/flot/jquery.flot.resize.min.js')}}" type="text/javascript"></script>
    <script src="{{Asset('public/Admin/plugins/flot/jquery.flot.pie.min.js')}}" type="text/javascript"></script>
    <script src="{{Asset('public/Admin/plugins/highcharts/js/highcharts.js')}}" type="text/javascript"></script>
    <script src="{{Asset('public/AdminMerchant/assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
    <script src="{{Asset('public/AdminMerchant/assets/global/plugins/morris/raphael-min.js')}}" type="text/javascript"></script>
    <script src="{{Asset('public/AdminMerchant/assets/pages/scripts/report.js')}}" type="text/javascript"></script>
@stop