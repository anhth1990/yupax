<?php

namespace App\Http\AdminMerchant\Validates;

use App\Http\Forms\MerchantForm;
use App\Http\Services\MerchantService;
use App\Http\Validates\BaseValidate;
use App\Http\Models\MerchantDAO;
use Exception;

class AuthValidate extends BaseValidate  {
    
    public function __construct() {
        $this->merchantService = new MerchantService();
    }

    public function validateLogin(MerchantForm $validateForm){
        /*
         * validate form
         */
        $error = null;
        if($validateForm->getEmail()==null || $validateForm->getEmail()==""){
            $error = trans('error.email_required');
        }else if(!preg_match($this->PATTERN_FORMAT_EMAIL, $validateForm->getEmail())){
            $error = trans('error.email_incorrect');
        }else if($validateForm->getPassword()==null || $validateForm->getPassword()==""){
            $error = trans('error.password_required');
        }else{
            try {
                $merchantDao = new MerchantDAO();
                $merchantDao = $this->merchantService->checkLogin($validateForm->getEmail(),$validateForm->getPassword());
                if($merchantDao==null){
                    $error = trans('error.email_or_password_incorrect');
                }else if($merchantDao->status!=  env('COMMON_STATUS_ACTIVE')){
                    $error = trans('error.account_inactive');
                }
            } catch (Exception $ex) {
                $error = $ex->getMessage();
            }
        } 
        return $error;
    }

}
