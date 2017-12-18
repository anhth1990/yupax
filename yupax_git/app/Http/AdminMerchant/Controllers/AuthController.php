<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\AdminMerchant\Controllers;
use App\Http\AdminMerchant\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Forms\MerchantForm;
use App\Http\AdminMerchant\Validates\AuthValidate;
use Session;
use App\Http\Services\MerchantService;
use Exception;

class AuthController extends BaseController {
    private $authValidate;
    private $merchantService;
    public function __construct() {
        $this->authValidate = new AuthValidate();
        $this->merchantService = new MerchantService();
    }

    /*
     * Login
     */
    public function getLogin(){
        if (Session::has("login_admin_merchant")){
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT'));
        }      
        $merchantForm = new MerchantForm();
        return view('AdminMerchant.Auth.login',  compact('merchantForm'));
    }
    
    public function postLogin(Request $data){
        try {
            $request = $data->input();
            $merchantForm = new MerchantForm();
            $merchantForm->setEmail($request['email']);
            $merchantForm->setPassword($request['password']);
            //$validate = $this->authValidate->validateLogin($merchantForm);
            $error="";
            if($merchantForm->getEmail()==null){
                $error = trans('validate.email_is_required');
            }elseif(!preg_match($this->PATTERN_FORMAT_EMAIL, $merchantForm->getEmail())){
                $error = trans('validate.email_invalid');
            }elseif($merchantForm->getPassword()==null){
                $error = trans('validate.password_is_required');
            }else{
                $merchant = $this->merchantService->getFirstData($merchantForm);
                if($merchant==null){
                    $error = trans('validate.email_or_password_invalid');
                }elseif($merchant->status == env('COMMON_STATUS_INACTIVE')){
                    $error = trans('validate.account_inactive');
                }
            }
            
            if($error!=""){
                return view('AdminMerchant.Auth.login',  compact('merchantForm','error'));
            }else{
                /*
                 * tài khoản hợp lệ được đăng nhập
                 */
                $merchantForm->setId($merchant->id);
                $merchantForm->setEmail($merchant->email);
                $merchantForm->setMobile($merchant->mobile);
                $merchantForm->setLastLogin($merchant->lastLogin);
                $merchantForm->setStatus($merchant->status);
                $merchantForm->setFirstName($merchant->firstName);
                $merchantForm->setLastName($merchant->lastName);
                $merchantForm->setAddress($merchant->address);
                $merchantForm->setHashcode($merchant->hashcode);
                Session::put("login_admin_merchant", $merchantForm);
                return redirect("/" . env('PREFIX_ADMIN_MERCHANT'));
            }
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    
    /*
     * logout
     */
    public function getLogout(){
            Session::forget('login_admin_merchant');
            return redirect('/' . env('PREFIX_ADMIN_MERCHANT'));
    }
    
    public function copyMerchantForm(Request $request){
        $merchantForm = new MerchantForm();
        $data = $request->input();
        $keyStr = "email,password,saveLogin";
        $dataFormat = $this->getInput($data, $keyStr,1);
        $merchantForm->setEmail($dataFormat["email"]);
        $merchantForm->setPassword($dataFormat["password"]);
        if(isset($dataFormat["saveLogin"]))
            $merchantForm->setSaveLogin($dataFormat["saveLogin"]);
        return $merchantForm;
    }
    
}

