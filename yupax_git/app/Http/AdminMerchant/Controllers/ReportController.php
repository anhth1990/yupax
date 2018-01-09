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
            $reportData = $this->reportService->loadReportData($requestData);

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
            $data['highlighted_number']['highest_invoice'] = number_format(5000000);
            $data['highlighted_number']['maximum_transaction_per_day'] = number_format(281);
            $data['highlighted_number']['refund'] = 0.1;
            $data['transaction_by_hours'] = json_encode($this->getTransactionByHours());
            $data['average_invoice_by_hours'] = json_encode($this->getAverageInvoiceByHours());
            $data['revenue_highchart'] = json_encode($this->getRevenueHighchart());
            $data['transaction_hightchart'] = json_encode($this->getTransactionHighchart());

            return view('AdminMerchant.Report.group', compact('data'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function getDataProductsRationByWeekend()
    {
        return [
            [
                'label' => 'Series 1',
                'data' => 10,
            ],
            [
                'label' => 'Series 2',
                'data' => 20,
            ],
            [
                'label' => 'Series 3',
                'data' => 30,
            ],
            [
                'label' => 'Series 4',
                'data' => 40,
            ],
        ];
    }

    public function getRevenueHighchart()
    {
        return [
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'series' => [
                [
                    'name' => 'Tokyo',
                    'data' => [6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                ],
                [

                    'name' => 'New York',
                    'data' => [0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
                ]
            ]
        ];
    }

    public function getTransactionHighchart()
    {
        return [
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'series' => [
                [
                    'name' => 'Tokyo',
                    'data' => [6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                ],
                [

                    'name' => 'New York',
                    'data' => [0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
                ]
            ]
        ];
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

    /**
     * @return array
     */
    public function getAverageInvoiceByHours()
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
