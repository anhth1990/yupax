<div class="row margin-top-15">
    <div class="col-md-12">
        <div class="group-title light-yellow">
            NHÓM KHÁCH HÀNG MỚI
        </div>
    </div>
</div>

<div class="row same-height-parent">
    <div class="col-md-2 padding-right-0">
        <div class="highlight-light-yellow-box" style="height: 46%">
            <div class="title">TỔNG DOANH THU</div>
            <div class="group-highlight-number">
                30%
                <hr>
                <div>TỔNG DOANH THU</div>
            </div>
        </div>

        <div class="highlight-light-yellow-box" style="height: 46%">
            <div class="title">TỔNG SỐ GIAO DỊCH</div>
            <div class="group-highlight-number">
                5.000
                <hr>
                <div>giao dịch</div>
            </div>
        </div>
    </div>

    @if (isset($data['new_group']))
        <div class="col-md-10">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption text-center">
                        <span class="caption-subject uppercase">SỐ LƯỢNG GIAO DỊCH THEO KHUNG GIỜ</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div id="new_group" data-content="{{ $data['new_group'] }}"
                         style="height: 250px;"></div>
                </div>
            </div>
        </div>
    @endif
</div>

@if (isset($data['highlighted_number']))
    <div class="row same-height-parent">
        <div class="col-md-12">
            <div class="group-statistic-number">
                <table class="group-report-table">
                    <tr class="header">
                        <td class="border-right" width="25%">HOÁ ĐƠN TRUNG BÌNH (VND)</td>
                        <td class="border-right" width="25%">TẦN SUẤT GD TRUNG BÌNH</td>
                        <td class="border-right" width="25%">TỔNG SỐ THÀNH VIÊN</td>
                        <td class="border-right-none" width="25%">TĂNG TRƯỞNG THÀNH VIÊN</td>
                    </tr>
                    <tr>
                        <td class="border-right">
                            <b>{{ $data['highlighted_number']['average_invoice'] }}</b>
                        </td>
                        <td class="border-right">
                            <b>{{ $data['highlighted_number']['highest_invoice'] }}<br>lần/tháng</b>
                        </td>
                        <td class="border-right">
                            <b>{{ $data['highlighted_number']['maximum_transaction_per_day'] }}</b>
                        </td>
                        <td class="border-right-none font-green-dark">
                            <b>+5%</b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endif