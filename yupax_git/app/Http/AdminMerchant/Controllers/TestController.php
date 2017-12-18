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
use App\Http\Services\NotiEmailService;

class TestController extends BaseController {
    
    private $notiEmailService;
    public function __construct() {
        parent::__construct();
        
        $this->notiEmailService = new NotiEmailService();
    }

    
    
    public function testMail(){
         // thu nghiem send mail
        //require_once 'App/Http/Services/Mail/sendmail.php';
        //$merchantForm = new MerchantForm();
        //$merchantForm->setEmail("hoanganh18121990@gmail.com");
        //$merchantForm->setPassword("1234567");
        //sendMail($merchantForm);  
        $this->notiEmailService->sendMail("14A14986B72310C71429");
    }

    
    
}

