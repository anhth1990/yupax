<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\AdminMerchant\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Forms\Configurations;
use App\Http\Forms\MerchantForm;
use Session;
use DateTime;

class BaseController extends Controller {
    public $merchantFormSession;
    //public $dateFormat;
    public function __construct() {
        $this->configuration = new Configurations();
        $this->merchantFormSession = new MerchantForm();
        $this->merchantFormSession = Session::get('login_admin_merchant') ;
    }
    
    public function formatDate($date){
        $dateFormat = new DateTime($date);
        return $dateFormat->format("d-m-Y H:i:s");
    }
    
    public function formatDateInsert($date){
        $date = DateTime::createFromFormat('d/m/Y', $date);
        return $date->format('Y-m-d');
    }
    
    
}

