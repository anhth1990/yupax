<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;

/**
 * Class ImportTransactionsDAO
 * @package App\Http\Models
 */
class ImportTransactionsDAO extends BaseDAO
{
    /**
     * ImportTransactionsDAO constructor.
     */
    public function __construct()
    {
        parent::__construct("tb_import_transactions");
    }

    /**
     * Get report total
     *
     * @param $company
     * @param $area
     * @param $year
     * @param $reportTime
     * @return mixed
     * @throws Exception
     */
    public function getReportTotal($company, $area, $year, $reportTime)
    {
        try {
            $data = DB::table('tb_import_transactions AS t')
                ->select(
                    DB::raw('SUM(t.total_transaction) as revenue_total'),
                    DB::raw('COUNT(DISTINCT id) as transactions_total')
                )
                ->where('t.organization_id', '=', $company)
                ->where('t.location_id', '=', $area)
                ->whereYear('t.created_date', '=', $year)
                ->first();

            return $data;
        } catch (Exception $e) {
            throw new Exception(trans("error.error_system"));
        }
    }

    /**
     * Get highlighted number
     *
     * @param $company
     * @param $area
     * @param $year
     * @param $reportTime
     * @return mixed
     * @throws Exception
     */
    public function getMaxTransactionData($company, $area, $year, $reportTime)
    {
        try {
            $data = DB::selectOne("
                SELECT MAX(temp.total_transaction) as max_total_transaction, max(temp.number_transaction) as max_number_transaction
                FROM (
                    SELECT MAX(t.total_transaction) as total_transaction, count(*) as number_transaction
                    FROM tb_import_transactions  AS t
                    WHERE t.organization_id = {$company} AND t.location_id = '{$area}' AND year(t.created_date) = {$year}
                    GROUP BY t.created_date
                ) as temp"
            );

            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get revenue high chart
     *
     * @param $company
     * @param $area
     * @param $year
     * @return mixed
     * @throws Exception
     */
    public function getTransactionByDates($company, $area, $year)
    {
        try {
            $data = DB::select("
                SELECT t.created_date, sum(t.total_transaction) as total_transaction, count(*) as number_transaction
                FROM tb_import_transactions AS t
                WHERE t.organization_id = {$company} AND t.location_id = '{$area}' AND year(t.created_date) = {$year}
                GROUP BY created_date"
            );
            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get transactions
     *
     * @param $company
     * @param $area
     * @param $year
     * @return mixed
     * @throws Exception
     */
    public function getTransactions($company, $area, $year)
    {
        try {
            $data = DB::select(
                "SELECT t.category_id, t.created_date, t.total_transaction, c.name
                FROM tb_import_transactions AS t
                INNER JOIN tb_category as c ON c.id = t.category_id
                WHERE t.organization_id = {$company} AND t.location_id like '%{$area}%' AND year(t.created_date) = {$year}"
            );

            return $data;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
