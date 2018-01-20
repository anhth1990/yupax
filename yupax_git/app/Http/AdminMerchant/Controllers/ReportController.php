<?php

namespace App\Http\AdminMerchant\Controllers;

use App\Http\Services\ReportService;
use Illuminate\Http\Request;
use Session;
use Exception;

/**
 * Class ReportController
 * @package App\Http\AdminMerchant\Controllers
 */
class ReportController extends BaseController
{
    /**
     * $reportService
     *
     * @var ReportService
     */
    protected $reportService;

    /**
     * ReportController constructor.
     */
    public function __construct()
    {
        $this->reportService = new ReportService();
        parent::__construct();
    }

    /**
     * Report action
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report(Request $request)
    {
        try {
            $requestData = $request->all();
            $data = $this->reportService->initReportData();
            $reportData = $this->reportService->loadReportData($requestData, $data['merchants']);

            $data['revenue_total'] = $reportData['revenue_total'];
            $data['transactions_total'] = $reportData['transactions_total'];
            $data['highlighted_number']['average_invoice'] = $reportData['average_invoice'];
            $data['highlighted_number']['highest_invoice'] = $reportData['highest_invoice'];
            $data['highlighted_number']['maximum_transaction_per_day'] = $reportData['maximum_transaction_per_day'];
            $data['highlighted_number']['refund'] = $reportData['refund'];
            $data['transaction_by_hours'] = json_encode($reportData['bar_chart']['transaction_by_hours']);
            $data['average_invoice_by_hours'] = json_encode($reportData['bar_chart']['average_invoice_by_hours']);
            $data['products_ration_by_week'] = json_encode($reportData['pie_chart']['day_in_week'], JSON_UNESCAPED_UNICODE);
            $data['products_ration_by_weekend'] = json_encode($reportData['pie_chart']['weekend'], JSON_UNESCAPED_UNICODE);
            $data['revenue_highchart'] = json_encode($reportData['high_chart']['total_transaction']);
            $data['transaction_hightchart'] = json_encode($reportData['high_chart']['number_transaction']);

            return view('AdminMerchant.Report.dashboard', compact('data'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    /**
     * Report action
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportGroup(Request $request)
    {
        try {
            $requestData = $request->all();
            $data = $this->reportService->initReportData();
            $data['revenue_total'] = number_format(15000);
            $data['transactions_total'] = number_format(25000);
            $data['transactions_total'] = number_format(25000);
            $data['highlighted_number']['average_invoice'] = number_format(1525000);
            $data['highlighted_number']['highest_invoice'] = 1.25;
            $data['highlighted_number']['maximum_transaction_per_day'] = number_format(281);
            $data['highlighted_number']['refund'] = 0.1;
            $data['coming_out_group'] = json_encode($this->getTransactionByHours());
            $data['loyal_group'] = json_encode($this->getTransactionByHours());
            $data['new_group'] = json_encode($this->getTransactionByHours());
            $data['vip_group'] = json_encode($this->getTransactionByHours());

            return view('AdminMerchant.Report.group', compact('data'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    /**
     * @return array
     */
    public function getTransactionByHours()
    {
        return [
            'data' => [
                ['y' => '9h - 11h', 'day_in_week' => 100, 'weekend' => 90],
                ['y' => '11h - 14h', 'day_in_week' => 75, 'weekend' => 65],
                ['y' => '14h - 17h', 'day_in_week' => 50, 'weekend' => 40],
                ['y' => '17h - 20h', 'day_in_week' => 75, 'weekend' => 65],
                ['y' => '20h - 22h', 'day_in_week' => 50, 'weekend' => 40],
            ],
            'labels' => ['Ngày trong tuần', 'Ngày cuối tuần']
        ];
    }
}
