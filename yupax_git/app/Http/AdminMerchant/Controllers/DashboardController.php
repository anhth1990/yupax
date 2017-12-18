<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\AdminMerchant\Controllers;

use App\Http\AdminMerchant\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use DB;

class DashboardController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Index
     */

    public function getIndex() {
        //echo $this->distance(21.0004107, 105.8576917, 20.993912, 105.8049673,'K');
        //die();
        try {
            $config = false;
            if ($this->merchantFormSession->getLastLogin() == null) {
                $config = true;
            }
            $config = false;
            return view('AdminMerchant.Dashboard.index', compact('config'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public static function vincentyGreatCircleDistance(
    $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
                pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

}
