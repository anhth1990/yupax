<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;

/**
 * Class ProvinceDAO
 * @package App\Http\Models
 */
class ProvinceDAO extends BaseDAO
{
    /**
     * ProvinceDAO constructor.
     */
    public function __construct()
    {
        parent::__construct("tb_province");
    }

    /**
     * Get province list
     * @return mixed
     * @throws Exception
     */
    public function getProvince()
    {
        try {
            $data = ProvinceDAO::select('*');
            $data = $data->get();
            return $data;
        } catch (Exception $ex) {
            throw new Exception(trans('error.error_system'));
        }
    }

    /**
     * Get province by id
     * @param $id
     * @return string
     */
    public function getProvinceById($id)
    {
        try {
            return ProvinceDAO::select("*")->where("provinceid", "=", $id)->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
