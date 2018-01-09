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

        <div class="row">
            <div class="col-md-12">
                <div class="group-title">
                    NHÓM KHÁCH HÀNG VIP
                </div>
            </div>
        </div>

        <div class="row same-height-parent">
            <div class="col-md-2 padding-right-0">
                <div class="highlight-yellow-box" style="height: 46%">
                    <div class="title">TỔNG DOANH THU</div>
                    <div class="highlight-number">
                        {{ $data['revenue_total'] }}
                        <hr>
                        <div>VND</div>
                    </div>
                </div>

                <div class="highlight-blue-box" style="height: 46%">
                    <div class="title">TỔNG SỐ GIAO DỊCH</div>
                    <div class="highlight-number">
                        {{ $data['transactions_total'] }}
                        <hr>
                        <div>giao dịch</div>
                    </div>
                </div>
            </div>

            @if (isset($data['revenue_highchart']))
                <div class="col-md-10">
                    <div class="portlet light portlet-fit bordered">
                        <div class="portlet-title">
                            <div class="caption text-center">
                                <span class="caption-subject uppercase">SỐ LƯỢNG GIAO DỊCH THEO KHUNG GIỜ</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="transaction_by_hours" data-content="{{ $data['transaction_by_hours'] }}"
                                 style="height: 280px;"></div>
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

        <div class="row margin-top-15">
            <div class="col-md-12">
                <div class="group-title">
                    NHÓM KHÁCH HÀNG VIP
                </div>
            </div>
        </div>

        <div class="row same-height-parent">
            <div class="col-md-2 padding-right-0">
                <div class="highlight-yellow-box" style="height: 46%">
                    <div class="title">TỔNG DOANH THU</div>
                    <div class="highlight-number">
                        {{ $data['revenue_total'] }}
                        <hr>
                        <div>VND</div>
                    </div>
                </div>

                <div class="highlight-blue-box" style="height: 46%">
                    <div class="title">TỔNG SỐ GIAO DỊCH</div>
                    <div class="highlight-number">
                        {{ $data['transactions_total'] }}
                        <hr>
                        <div>giao dịch</div>
                    </div>
                </div>
            </div>

            @if (isset($data['transaction_hightchart']))
                <div class="col-md-10">
                    <div class="portlet light portlet-fit bordered">
                        <div class="portlet-title">
                            <div class="caption text-center">
                                <span class="caption-subject uppercase">HOÁ ĐƠN TRUNG BÌNH THEO KHUNG GIỜ</span>
                            </div>
                        </div>

                        <div class="portlet-body">
                            <div id="average_invoice_by_hours" data-content="{{ $data['average_invoice_by_hours'] }}"
                                 style="height: 280px;"></div>
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