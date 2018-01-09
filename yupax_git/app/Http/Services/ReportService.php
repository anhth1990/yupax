<?php

namespace App\Http\Services;

use App\Helpers\Utility;
use App\Http\Models\ImportTransactionsDAO;
use App\Http\Models\ProvinceDAO;
use App\Http\Models\StoreDAO;

/**
 * Class ReportService
 * @package App\Http\Services
 */
class ReportService extends BaseService
{
    /**
     * $provinceDao
     *
     * @var ProvinceDAO
     */
    protected $provinceDao;

    /**
     * $importTransactionsDAO
     *
     * @var ImportTransactionsDAO
     */
    protected $importTransactionsDAO;

    /**
     * $storeDao
     *
     * @var StoreDAO
     */
    protected $storeDao;

    /**
     * ReportService constructor.
     */
    public function __construct()
    {
        $this->provinceDao = new ProvinceDAO();
        $this->storeDao = new StoreDAO();
        $this->importTransactionsDAO = new ImportTransactionsDAO();
    }

    /**
     * Init report data
     *
     * @return array
     */
    public function initReportData()
    {
        $provinces = $this->provinceDao->getProvince()->toArray();
        $stores = $this->storeDao->getAllStores()->toArray();
        $areas = [];

        foreach ($provinces as $province) {
            $areas[$province['provinceid']] = $province['name'];
        }

        foreach ($stores as $store) {
            $areas[$store['id']] = $store['name'];
        }

        return [
            'areas' => $areas
        ];
    }

    /**
     * Load report data
     *
     * @param array $requestData
     * @return array
     */
    public function loadReportData($requestData = [])
    {
        $result = [];
        $company = isset($requestData['company']) ? $requestData['company'] : 'redsun';
        $area = isset($requestData['area']) ? $requestData['area'] : 'hà nội';
        $year = isset($requestData['year']) ? $requestData['year'] : 2017;
        $reportTime = isset($requestData['report-time']) ? $requestData['report-time'] : 'quy';
        $reportTotal = $this->importTransactionsDAO->getReportTotal($company, $area, $year, $reportTime);

        $result['revenue_total'] = number_format($reportTotal->revenue_total);
        $result['transactions_total'] = number_format($reportTotal->transactions_total);
        $highlightedNumber = $this->importTransactionsDAO->getMaxTransactionData($company, $area, $year, $reportTime);
        $result['average_invoice'] = ($reportTotal->transactions_total) ?
            number_format($reportTotal->revenue_total / $reportTotal->transactions_total) : 0;
        $result['highest_invoice'] = number_format($highlightedNumber->max_total_transaction);
        $result['maximum_transaction_per_day'] = number_format($highlightedNumber->max_number_transaction);
        $result['refund'] = 0.1;
        $highChartData = $this->importTransactionsDAO->getTransactionByDates($company, $area, $year);
        $result['high_chart'] = $this->prepareHighChartResponse($company, $year, $reportTime, $highChartData);
        $barChartData = $this->importTransactionsDAO->getTransactions($company, $area, $year);
        $result['bar_chart']['transaction_by_hours'] = $this->prepareNumberTransactionByHours($company, $year, $reportTime, $barChartData);
        $result['bar_chart']['average_invoice_by_hours'] = $this->prepareTotalTransactionByHours($company, $year, $reportTime, $barChartData);
        $result['pie_chart'] = $this->preparePieChartResponse($barChartData);

        return $result;
    }

    /**
     * Prepare High Chart Response
     *
     * @param $company
     * @param $year
     * @param $reportTime
     * @param $data
     * @return array
     */
    public function prepareHighChartResponse($company, $year, $reportTime, $data)
    {
        $month = (int)date('m');
        $result = [];

        switch ($reportTime) {
            case 'quy':
                for ($i = 1; $i <= 4; $i++) {
                    $result['Q.' . $i] = [
                        'total_transaction' => 0,
                        'number_transaction' => 0,
                    ];
                }

                if ((int)date('Y') <= $year) {
                    if ($month < 4) {
                        unset($result['Q.2']);
                        unset($result['Q.3']);
                        unset($result['Q.4']);
                    } elseif ($month < 7) {
                        unset($result['Q.3']);
                        unset($result['Q.4']);
                    } elseif ($month < 10) {
                        unset($result['Q.4']);
                    }
                }

                foreach ($data as $item) {
                    $itemMonth = (int)date('m', strtotime($item->created_date));
                    if ($itemMonth < 4) {
                        $result['Q.1']['total_transaction'] += $item->total_transaction;
                        $result['Q.1']['number_transaction'] += $item->number_transaction;
                    } elseif ($itemMonth < 7) {
                        $result['Q.2']['total_transaction'] += $item->total_transaction;
                        $result['Q.2']['number_transaction'] += $item->number_transaction;
                    } elseif ($itemMonth < 10) {
                        $result['Q.3']['total_transaction'] += $item->total_transaction;
                        $result['Q.3']['number_transaction'] += $item->number_transaction;
                    } else {
                        $result['Q.4']['total_transaction'] += $item->total_transaction;
                        $result['Q.4']['number_transaction'] += $item->number_transaction;
                    }
                }

                break;
            case 'thang':
                $months = (int)date('Y') <= $year ? $month : 12;
                for ($i = 0; $i < $months; $i++) {
                    $result["T." . ($i + 1)] =
                        [
                            'total_transaction' => 0,
                            'number_transaction' => 0,
                        ];
                }

                foreach ($data as $item) {
                    $itemMonth = (int)date('m', strtotime($item->created_date));
                    $result['T.' . $itemMonth]['total_transaction'] += $item->total_transaction;
                    $result['T.' . $itemMonth]['number_transaction'] += $item->number_transaction;
                }
                break;
            case 'nam':
                $months = (int)date('Y') <= $year ? $month : 12;
                for ($i = 0; $i < $months; $i++) {
                    $result["T." . ($i + 1)] =
                        [
                            'total_transaction' => 0,
                            'number_transaction' => 0,
                        ];
                }

                foreach ($data as $item) {
                    $itemMonth = (int)date('m', strtotime($item->created_date));
                    $result['T.' . $itemMonth]['total_transaction'] += $item->total_transaction;
                    $result['T.' . $itemMonth]['number_transaction'] += $item->number_transaction;
                }
                break;
        }

        $response['total_transaction']['categories'] = $response['number_transaction']['categories'] = array_keys($result);
        $response['number_transaction']['series'][] = [
            'name' => strtoupper($company),
            'data' => []
        ];

        $response['total_transaction']['series'][] = [
            'name' => strtoupper($company),
            'data' => []
        ];

        foreach ($result as $item) {
            $response['total_transaction']['series'][0]['data'][] = $item['total_transaction'];
            $response['number_transaction']['series'][0]['data'][] = $item['number_transaction'];
        }

        return $response;
    }

    /**
     * @param $company
     * @param $year
     * @param $reportTime
     * @param $data
     * @return array
     */
    public function prepareTotalTransactionByHours($company, $year, $reportTime, $data)
    {
        $result = [
            '9h - 11h' => [
                'day_in_week' => 0,
                'weekend' => 0,
            ],
            '11h - 14h' => [
                'day_in_week' => 0,
                'weekend' => 0,
            ],
            '14h - 17h' => [
                'day_in_week' => 0,
                'weekend' => 0,
            ],
            '17h - 20h' => [
                'day_in_week' => 0,
                'weekend' => 0,
            ],
            '20h - 22h' => [
                'day_in_week' => 0,
                'weekend' => 0,
            ],
        ];

        foreach ($data as $item) {
            $hour = (int)(date('H', strtotime($item->created_date)));
            if (!Utility::isWeekend($item->created_date)) {
                if ($hour >= 9 && $hour < 11) {
                    $result['9h - 11h']['day_in_week'] = $item->total_transaction;
                } elseif ($hour >= 11 && $hour < 14) {
                    $result['11h - 14h']['day_in_week'] = $item->total_transaction;
                } elseif ($hour >= 14 && $hour < 17) {
                    $result['14h - 17h']['day_in_week'] = $item->total_transaction;
                } elseif ($hour >= 17 && $hour < 20) {
                    $result['17h - 20h']['day_in_week'] = $item->total_transaction;
                } elseif ($hour >= 20 && $hour < 22) {
                    $result['20h - 22h']['day_in_week'] = $item->total_transaction;
                }
            } else {
                if ($hour >= 9 && $hour < 11) {
                    $result['9h - 11h']['weekend'] = $item->total_transaction;
                } elseif ($hour >= 11 && $hour < 14) {
                    $result['11h - 14h']['weekend'] = $item->total_transaction;
                } elseif ($hour >= 14 && $hour < 17) {
                    $result['14h - 17h']['weekend'] = $item->total_transaction;
                } elseif ($hour >= 17 && $hour < 20) {
                    $result['17h - 20h']['weekend'] = $item->total_transaction;
                } elseif ($hour >= 20 && $hour < 22) {
                    $result['20h - 22h']['weekend'] = $item->total_transaction;
                }
            }
        }

        $response = [
            'data' => [
                [
                    'y' => '9h - 11h',
                    'day_in_week' => $result['9h - 11h']['day_in_week'],
                    'weekend' => $result['9h - 11h']['weekend']
                ],
                [
                    'y' => '11h - 14h',
                    'day_in_week' => $result['11h - 14h']['day_in_week'],
                    'weekend' => $result['11h - 14h']['weekend']
                ],
                [
                    'y' => '14h - 17h',
                    'day_in_week' => $result['14h - 17h']['day_in_week'],
                    'weekend' => $result['14h - 17h']['weekend']
                ],
                [
                    'y' => '17h - 20h',
                    'day_in_week' => $result['17h - 20h']['day_in_week'],
                    'weekend' => $result['17h - 20h']['weekend']
                ],
                [
                    'y' => '20h - 22h',
                    'day_in_week' => $result['20h - 22h']['day_in_week'],
                    'weekend' => $result['20h - 22h']['weekend']
                ],
            ],
            'labels' => ['Ngày trong tuần', 'Ngày cuối tuần']
        ];

        return $response;
    }

    /**
     * @param $company
     * @param $year
     * @param $reportTime
     * @param $data
     * @return array
     */
    public function prepareNumberTransactionByHours($company, $year, $reportTime, $data)
    {
        $result = [
            '9h - 11h' => [
                'day_in_week' => 0,
                'weekend' => 0,
            ],
            '11h - 14h' => [
                'day_in_week' => 0,
                'weekend' => 0,
            ],
            '14h - 17h' => [
                'day_in_week' => 0,
                'weekend' => 0,
            ],
            '17h - 20h' => [
                'day_in_week' => 0,
                'weekend' => 0,
            ],
            '20h - 22h' => [
                'day_in_week' => 0,
                'weekend' => 0,
            ],
        ];

        foreach ($data as $item) {
            $hour = (int)(date('H', strtotime($item->created_date)));
            if (!Utility::isWeekend($item->created_date)) {
                if ($hour >= 9 && $hour < 11) {
                    $result['9h - 11h']['day_in_week'] += 1;
                } elseif ($hour >= 11 && $hour < 14) {
                    $result['11h - 14h']['day_in_week'] += 1;
                } elseif ($hour >= 14 && $hour < 17) {
                    $result['14h - 17h']['day_in_week'] += 1;
                } elseif ($hour >= 17 && $hour < 20) {
                    $result['17h - 20h']['day_in_week'] += 1;
                } elseif ($hour >= 20 && $hour < 22) {
                    $result['20h - 22h']['day_in_week'] += 1;
                }
            } else {
                if ($hour >= 9 && $hour < 11) {
                    $result['9h - 11h']['weekend'] += 1;
                } elseif ($hour >= 11 && $hour < 14) {
                    $result['11h - 14h']['weekend'] += 1;
                } elseif ($hour >= 14 && $hour < 17) {
                    $result['14h - 17h']['weekend'] += 1;
                } elseif ($hour >= 17 && $hour < 20) {
                    $result['17h - 20h']['weekend'] += 1;
                } elseif ($hour >= 20 && $hour < 22) {
                    $result['20h - 22h']['weekend'] += 1;
                }
            }
        }

        $response = [
            'data' => [
                [
                    'y' => '9h - 11h',
                    'day_in_week' => $result['9h - 11h']['day_in_week'],
                    'weekend' => $result['9h - 11h']['weekend']
                ],
                [
                    'y' => '11h - 14h',
                    'day_in_week' => $result['11h - 14h']['day_in_week'],
                    'weekend' => $result['11h - 14h']['weekend']
                ],
                [
                    'y' => '14h - 17h',
                    'day_in_week' => $result['14h - 17h']['day_in_week'],
                    'weekend' => $result['14h - 17h']['weekend']
                ],
                [
                    'y' => '17h - 20h',
                    'day_in_week' => $result['17h - 20h']['day_in_week'],
                    'weekend' => $result['17h - 20h']['weekend']
                ],
                [
                    'y' => '20h - 22h',
                    'day_in_week' => $result['20h - 22h']['day_in_week'],
                    'weekend' => $result['20h - 22h']['weekend']
                ],
            ],
            'labels' => ['Ngày trong tuần', 'Ngày cuối tuần']
        ];

        return $response;
    }

    /**
     * @param $data
     * @return array
     */
    public function preparePieChartResponse($data)
    {
        $response = $result = [
            'day_in_week' => [],
            'weekend' => []
        ];

        foreach ($data as $item) {
            if (!Utility::isWeekend($item->created_date)) {
                if (!isset($result['day_in_week'][$item->category_id])) {
                    $result['day_in_week'][$item->category_id] = 0;
                }
                $result['day_in_week'][$item->category_id] += $item->total_transaction;
            } else {
                if (!isset($result['weekend'][$item->category_id])) {
                    $result['weekend'][$item->category_id] = 0;
                }
                $result['weekend'][$item->category_id] += $item->total_transaction;
            }
        }

        foreach ($result['day_in_week'] as $key => $item) {
            $response['day_in_week'][] = [
                'label' => $key,
                'data' => $item,
            ];
        }

        foreach ($result['weekend'] as $key => $item) {
            $response['weekend'][] = [
                'label' => $key,
                'data' => $item,
            ];
        }

        return $response;
    }
}
