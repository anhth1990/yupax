<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\AdminMerchant\Controllers;
use App\Http\AdminMerchant\Controllers\BaseController;
use Illuminate\Http\Request;
use Session;
use Exception;
use App\Http\Services\TransactionService;
use App\Http\Forms\TransactionForm;

class TransactionController extends BaseController {
    
    private $transactionService;
    public function __construct() {
        parent::__construct();
        $this->transactionService = new TransactionService();
    }
    
    public function getList(){
        try {
            $transactionForm = new TransactionForm();
            $transactionForm->setUserDetailId(15);
            $data = $this->transactionService->getList($transactionForm);
            var_dump($data);
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            echo $ex->getMessage();
        }
    }
}

