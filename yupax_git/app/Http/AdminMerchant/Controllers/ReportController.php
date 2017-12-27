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

            return view('AdminMerchant.Report.dashboard', compact('data'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            return view('errors.503', compact('error'));
        }
    }
}
