<?php

namespace App\Http\Services;

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
    }

    /**
     * Get report data
     *
     * @return array
     */
    public function getReportData()
    {
        $provinces = $this->provinceDao->getProvince()->toArray();
        $stores = $this->storeDao->getAllStores()->toArray();
        $areas = [];

        foreach ($provinces as $province) {
            $areas[] = $province['name'];
        }

        foreach ($stores as $store) {
            $areas[] = $store['name'];
        }

        return [
            'areas' => $areas
        ];
    }
}
