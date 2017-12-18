<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\AdminPortal\Controllers;
use App\Http\AdminPortal\Controllers\BaseController;
use Illuminate\Http\Request;

class DashboardController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }

    /*
     * Index
     */
    public function getIndex(){
        $titlePage = $this->configuration->titlePageAdminPortal.  trans('dashboard.title_page');
        return view('AdminPortal.Dashboard.index',  compact('titlePage'));
    }
    
    
}

