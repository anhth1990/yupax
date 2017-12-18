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
use DB;
use App\Http\Services\LevelUserService;
use App\Http\Forms\LevelUserForm;
use App\Http\Forms\ConfigForm;
use App\Http\Services\ConfigService;

class ConfigController extends BaseController {

    private $levelUserService;
    private $configService;

    public function __construct() {
        parent::__construct();
        $this->levelUserService = new LevelUserService();
        $this->configService = new ConfigService();
    }

    public function getConfigLevelUserFast() {
        try {
            $levelUserForm = new LevelUserForm();
            $levelUserForm->setPageSize(null);
            $listLevelUser = $this->levelUserService->searchMultiData($levelUserForm);

            $result = view('AdminMerchant.Config.ConfigFast.level-user-fast', compact('listLevelUser'))->render();
            return $result;
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function postConfigLevelUserFast(Request $data) {
        try {
            $request = $data->input();
            $fail = "";
            if (!isset($request['level'])) {
                $fail = "Bạn có thể bỏ qua hoặc chọn ít nhất 1 loại thẻ";
            } else {
                foreach ($request['level'] as $key => $value) {
                    if (!isset($request['valueCoin'][$key]) || $request['valueCoin'][$key] == null) {
                        $fail = "CHọn thẻ hợp lệ phải bao gồm giá trị";
                        break;
                    }
                }
            }
            $response = array(
                "message" => $fail,
                "code" => 100
            );
            return json_encode($response);
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    /*
     * Config
     */

    public function getConfig() {
        try {
            $configForm = new ConfigForm();
            $configForm->setMerchantId($this->merchantFormSession->getId());
            $configForm->setStatus(env('COMMON_STATUS_ACTIVE'));
            $listConfig = $this->configService->searchListData($configForm);
            foreach ($listConfig as $key=>$value){
                if($value->key=='rank_user'){
                    $configForm->setRankUser($value->value);
                }
                if($value->key=='recensy'){
                    $configForm->setRecensy($value->value);
                }
                if($value->key=='frequency'){
                    $configForm->setFrequency($value->value);
                }
                if($value->key=='monetary'){
                    $configForm->setMonetary($value->value);
                }
            }
            return view('AdminMerchant.Config.config',  compact('configForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }
    
    public function postConfigConfirm(Request $data){
        try {
            $request = $data->input();
            $configForm = new ConfigForm();
            $configForm->setRankUser($request['rankUser']);
            isset($request['recensy'])?$configForm->setRecensy($request['recensy']):$configForm->setRecensy("");
            isset($request['frequency'])?$configForm->setFrequency($request['frequency']):$configForm->setFrequency("");
            isset($request['monetary'])?$configForm->setMonetary($request['monetary']):$configForm->setMonetary("");
            /*
             * validate
             */
            $err = "";
            /*
             * end validate
             */
            if($err!=""){
                return view('AdminMerchant.Config.config',  compact('configForm','err'));
            }else{
                Session::put('SESSION_CONFIG',$configForm);
                return view('AdminMerchant.Config.config-confirm',  compact('configForm'));
            }
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    public function postConfigFinish(){
        
        DB::beginTransaction();
        try {
            $configForm = new ConfigForm();
            if(Session::has("SESSION_CONFIG")){
                $configForm = Session::get("SESSION_CONFIG");
            }
            
            $configForm->setMerchantId($this->merchantFormSession->getId());
            $this->configService->insertOrUpdate($configForm);
            Session::forget('SESSION_CONFIG');
            DB::commit();  
            return view('AdminMerchant.Config.config-finish',  compact('configForm'));
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }

}
