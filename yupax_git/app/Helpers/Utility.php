<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

/**
 * Class Utility
 * @package App\Helpers
 */
class Utility
{
    /**
     * Get list of roles by string that using for ACL
     *
     * @param $roles array/string list roles from tca configs
     *
     * @return string list of roles that using for ACL
     * @author Quoc Phan
     */
    public static function roles($roles)
    {
        if (is_string($roles)) {
            return config(sprintf('tca.role.%s.slug', $roles));
        }

        if (is_array($roles)) {
            $list = [];
            foreach ($roles as $role) {
                $list[] = config('tca.role.%s.slug', $role);
            }
            return implode('|', $list);
        }
        return '';
    }

    /**
     * Get column from array list
     *
     * @param $array
     * @param $column
     * @return array
     */
    public static function getColumnFromArrayList($array, $column)
    {
        $result = [];
        foreach ($array as $row) {
            if (isset($row[$column])) {
                $result[] = $row[$column];
            }
        }
        return $result;
    }

    /**
     * Parse permissions from role->getPermissions to array for datatable
     *
     * @param $permissions
     * @return array
     */
    public static function parsePermissions($permissions)
    {
        $result = [];
        $allPermissions = config('permissions');
        foreach ($allPermissions as $permission) {
            $slug = $permission['name'];
            $description = $permission['description'];
            $result[] = [
                'permission' => $slug,
                'name' => $description,
                'view' => (!isset($permissions[$slug]) || !isset($permissions[$slug]['view'])) ? false
                    : $permissions[$slug]['view'],
                'create' => (!isset($permissions[$slug]) || !isset($permissions[$slug]['create'])) ? false
                    : $permissions[$slug]['create'],
                'update' => (!isset($permissions[$slug]) || !isset($permissions[$slug]['update'])) ? false
                    : $permissions[$slug]['update'],
                'delete' => (!isset($permissions[$slug]) || !isset($permissions[$slug]['delete'])) ? false
                    : $permissions[$slug]['delete'],
            ];
        }
        return $result;
    }

    /**
     * Parse error list to string
     * @param array $errors
     * @return string
     */
    public static function parseErrorsToString(array $errors)
    {
        return !empty($errors) ? '<br/> ✗ ' . implode('<br/> ✗ ', $errors) : '';
    }

    /**
     * Check current tab is active
     * @param $module
     * @return bool
     */
    public static function isActiveTab($module, $tabName = 'application')
    {
        if (!empty($module)) {
            switch ($tabName) {
                case config('tca.tab.application'):
                    if ($module === config('tca.module.dashboard') ||
                        $module === config('tca.module.user')
                    ) {
                        return true;
                    }
                    break;
                case config('tca.tab.product'):
                    if ($module === config('tca.module.order_recap') ||
                        $module === config('tca.module.line') ||
                        $module === config('tca.module.order_recap_setting')
                    ) {
                        return true;
                    }
                    break;
                case config('tca.tab.product_plan'):
                    if ($module === config('tca.module.product_plan') ||
                        $module === config('tca.module.line_map')
                    ) {
                        return true;
                    }
                    break;
            }
        }

        return false;
    }

    /**
     * Handle pagination params
     * @param  Request $request
     * @return array
     */
    public static function pagination($request)
    {
        $pagingConfig = config('pagination');
        $pagination = [
            'count' => $pagingConfig['default_count'],
            'order_by' => $pagingConfig['default_order'],
            'skip' => $request->get('start', 0)
        ];

        $count = $request->get('length');
        if ($count === (string)(int)$count && in_array($count, $pagingConfig['count_values'])) {
            $pagination['count'] = $count;
        }

        $orderBy = $request->get('orderBy');
        if (in_array($orderBy, $pagingConfig['order_values'])) {
            $pagination['order_by'] = $orderBy;
        }

        return $pagination;
    }

    /**
     * @param $request
     * @param $key
     */
    public static function parseDayFromDatePicker(&$request, $key)
    {
        $input = $request->all();
        $input[$key] = Carbon::createFromFormat('d/m/Y', $input[$key])->format('Y-m-d');
        $request->replace($input);
    }

    /**
     * @param $date
     * @return bool
     */
    public static function isWeekend($date)
    {
        return (date('N', strtotime($date)) >= 6);
    }
}
