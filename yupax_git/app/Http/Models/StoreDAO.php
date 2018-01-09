<?php

/*
 * anhth1990
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;
use App\Http\Forms\StoreForm;
use App\Http\Models\StoreCategoryDAO;

/**
 * Class StoreDAO
 * @package App\Http\Models
 */
class StoreDAO extends BaseDAO
{
    /**
     * StoreDAO constructor.
     */
    public function __construct()
    {
        parent::__construct("tb_store");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function branch()
    {
        return $this->hasMany('App\Models\StoreBranchDAO', 'storeId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(new StoreCategoryDAO(), 'categoryId', 'id');
    }

    /**
     * @param StoreForm $searchForm
     * @return mixed
     * @throws Exception
     */
    public function getList(StoreForm $searchForm)
    {
        try {
            $data = StoreDAO::select('*');
            if ($searchForm->getMerchantId() != null) {
                $data = $data->where('merchantId', $searchForm->getMerchantId());
            }

            if ($searchForm->getName() != null) {
                $data = $data->where('name', 'like', '%' . $searchForm->getName() . '%');
            }
            if ($searchForm->getStatus() != null) {
                $data = $data->where('status', '=', $searchForm->getStatus());
            }
            $data = $data->where('status', '!=', env('COMMON_STATUS_DELETED'));
            $data = $data->orderBy('id', 'desc');
            if ($searchForm->getPageSize() != null) {
                $data = $data->paginate($searchForm->getPageSize(), ['*'], 'page', $searchForm->getPageIndex());
            } else {
                $data = $data->get();
            }
            return $data;
        } catch (Exception $ex) {
            $this->logs_custom("\nSQL ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            throw new Exception(trans("error.error_system"));
        }
    }

    /**
     * @return mixed
     */
    public function getAllStores()
    {
        return StoreDAO::select('*')
            ->where('status', '!=', env('COMMON_STATUS_DELETED'))
            ->get();
    }
}
