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
            $data = $this->reportService->getReportData();
            $data['revenue_total'] = number_format(15000);
            $data['transactions_total'] = number_format(25000);
            $data['transactions_total'] = number_format(25000);
            $data['highlighted_number']['average_invoice'] = number_format(1525000);
            $data['highlighted_number']['highest_invoice'] = number_format(5000000);
            $data['highlighted_number']['maximum_transaction_per_day'] = number_format(281);
            $data['highlighted_number']['refund'] = 0.1;
            $data['transaction_by_hours'] = json_encode($this->getTransactionByHours());
            $data['average_invoice_by_hours'] = json_encode($this->getAverageInvoiceByHours());
            $data['products_ration_by_week'] = json_encode($this->getDataProductsRationByWeekend());
            $data['products_ration_by_weekend'] = json_encode($this->getDataProductsRationByWeekend());
            $data['revenue_highchart'] = json_encode($this->getRevenueHighchart());
            $data['transaction_hightchart'] = json_encode($this->getTransactionHighchart());

            return view('AdminMerchant.Report.dashboard', compact('data'));
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
                'data' => 96,
            ],
            [
                'label' => 'Series 2',
                'data' => 7,
            ],
            [
                'label' => 'Series 3',
                'data' => 54,
            ],
            [
                'label' => 'Series 4',
                'data' => 39,
            ],
            [
                'label' => 'Series 5',
                'data' => 11,
            ],
            [
                'label' => 'Series 6',
                'data' => 90,
            ],
            [
                'label' => 'Series 7',
                'data' => 44,
            ],
            [
                'label' => 'Series 1',
                'data' => 42,
            ],
            [
                'label' => 'Series 8',
                'data' => 11,
            ],
            [
                'label' => 'Series 9',
                'data' => 36,
            ],
            [
                'label' => 'Series 10',
                'data' => 96,
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

    public function getTransactionByHours()
    {
        return [
            'data' => [
                ['y' => '2006', 'a' => 100, 'b' => 90],
                ['y' => '2007', 'a' => 75, 'b' => 65],
                ['y' => '2008', 'a' => 50, 'b' => 40],
                ['y' => '2009', 'a' => 75, 'b' => 65],
                ['y' => '2010', 'a' => 50, 'b' => 40],
                ['y' => '2011', 'a' => 75, 'b' => 65]
            ],
            'labels' => ['Series A', 'Series B']
        ];
    }

    public function getAverageInvoiceByHours()
    {
        return [
            'data' => [
                ['y' => '2006', 'a' => 100, 'b' => 90],
                ['y' => '2007', 'a' => 75, 'b' => 65],
                ['y' => '2008', 'a' => 50, 'b' => 40],
                ['y' => '2009', 'a' => 75, 'b' => 65],
                ['y' => '2010', 'a' => 50, 'b' => 40],
                ['y' => '2011', 'a' => 75, 'b' => 65]
            ],
            'labels' => ['Series A', 'Series B']
        ];
    }
}
