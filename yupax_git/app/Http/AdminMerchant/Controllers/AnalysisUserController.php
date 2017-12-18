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
use App\Http\Services\ConfigService;
use App\Http\Services\AnalysisService;
use App\Http\Forms\AnalysisForm;
class AnalysisUserController extends BaseController {
    
    private $configService;
    private $analysisService;
    public function __construct() {
        parent::__construct();
        $this->configService =  new ConfigService();
        $this->analysisService = new AnalysisService();
    }
    
    /*
     * RFM
     */
    public function getRfmConfig() {
        try {
            $merchantId = $this->merchantFormSession->getId();
            $rankUser = $this->configService->getDataByKey('rank_user', $merchantId);
            $recensy = $this->configService->getDataByKey('recensy', $merchantId);
            $frequency = $this->configService->getDataByKey('frequency', $merchantId);
            $monetary = $this->configService->getDataByKey('monetary', $merchantId);
            // list recensy
            $recensyForm = new AnalysisForm();
            $recensyForm->setCode('RECENSY');
            $recensyForm->setMerchantId($merchantId);
            $listRecensyData = $this->analysisService->searchListData($recensyForm);
            $listRecensy=null;
            if($listRecensyData!=null){
                $key = 0;
                for ($i = count($listRecensyData)-1 ; $i >= 0 ; $i--){
                    if($i==count($listRecensyData)-1){
                        $listRecensy[$key]=$listRecensyData[$i]->minValue;
                    }else{
                        $listRecensy[$key]=$listRecensyData[$i]->maxValue;
                    }
                    $key++;
                }
            }
            // list frequency
            $frequencyForm = new AnalysisForm();
            $frequencyForm->setCode('FREQUENCY');
            $frequencyForm->setMerchantId($merchantId);
            $listFrequencyData = $this->analysisService->searchListData($frequencyForm);
            $listFrequency=null;
            if($listFrequencyData!=null){
                $key = 0;
                for ($i = count($listFrequencyData)-1 ; $i >= 0 ; $i--){
                    if($i==0){
                        $listFrequency[$key]=$listFrequencyData[$i]->minValue;
                    }else{
                        $listFrequency[$key]=$listFrequencyData[$i]->maxValue;
                    }
                    $key++;
                }
            }
            
            // list monetary
            $monetaryForm = new AnalysisForm();
            $monetaryForm->setCode('MONETARY');
            $monetaryForm->setMerchantId($merchantId);
            $listMonetaryData = $this->analysisService->searchListData($monetaryForm);
            $listMonetary=null;
            if($listMonetaryData!=null){
                $key = 0;
                for ($i = count($listMonetaryData)-1 ; $i >= 0 ; $i--){
                    if($i==0){
                        $listMonetary[$key]=$listMonetaryData[$i]->minValue;
                    }else{
                        $listMonetary[$key]=$listMonetaryData[$i]->maxValue;
                    }
                    $key++;
                }
            }
            
            $errBlock = "";
            $linkBlock = "";
            if($rankUser==null){
                $errBlock = "Cài đặt cấu hình mức xếp hạng .";
                $linkBlock = asset('/'.env('PREFIX_ADMIN_MERCHANT').'/config');
            }
            return view('AdminMerchant.AnalysisUser.rfm.config',  compact('errBlock','linkBlock','rankUser','recensy','frequency','monetary','listRecensy','listFrequency','listMonetary'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }
    
    public function postRfmConfigConfirm(Request $data){
        try {
            $request = $data->input();
            $analysisForm = new AnalysisForm();
            
            /*
             * validate
             */
            $err = "";
            $listRecensy=null;
            $checkRecensy = true;
            if(isset($request['recensy'])){
                $listRecensy = $request['recensy'];
                foreach ($listRecensy as $recensyKey=>$recensyValue){
                    $recensyValue = str_replace(',', '', $recensyValue);
                    $listRecensy[$recensyKey]= $recensyValue;
                    if($recensyValue=="")$checkRecensy=false;
                }
            }
            $analysisForm->setListRecensy($listRecensy);
            
            $listFrequency=null;
            $checkFrequency = true;
            if(isset($request['frequency'])){
                $listFrequency = $request['frequency'];
                foreach ($listFrequency as $frequencyKey=>$frequencyValue){
                    $frequencyValue = str_replace(',', '', $frequencyValue);
                    $listFrequency[$frequencyKey]= $frequencyValue;
                    if($frequencyValue=="")$checkFrequency=false;
                }
            }
            $analysisForm->setListFrequency($listFrequency);
            
            $listMonetary=null;
            $checkMonetary = true;
            if(isset($request['monetary'])){
                $listMonetary = $request['monetary'];
                foreach ($listMonetary as $monetaryKey=>$monetaryValue){
                    $monetaryValue = str_replace(',', '', $monetaryValue);
                    $listMonetary[$monetaryKey]= $monetaryValue;
                    if($monetaryValue=="")$checkMonetary=false;
                }
            }
            $analysisForm->setListMonetary($listMonetary);
            
            if(!$checkRecensy){
                $err = "Nhập đầy đủ dữ liệu Sự Gần Đây";
            }elseif(!$checkFrequency){
                $err = "Nhập đầy đủ dữ liệu Tần Suất";
            }elseif(!$checkMonetary){
                $err = "Nhập đầy đủ dữ liệu Chi Tiêu";
            }
            
            /*
             * end validate
             */
            $merchantId = $this->merchantFormSession->getId();
            $rankUser = $this->configService->getDataByKey('rank_user', $merchantId);
            $recensy = $this->configService->getDataByKey('recensy', $merchantId);
            $frequency = $this->configService->getDataByKey('frequency', $merchantId);
            $monetary = $this->configService->getDataByKey('monetary', $merchantId);
            if($err!=""){
                return view('AdminMerchant.AnalysisUser.rfm.config',  compact('analysisForm','err','rankUser','recensy','frequency','monetary','listRecensy','listFrequency','listMonetary'));
            }else{
                Session::put('SESSION_ANALYSIS_CONFIG',$analysisForm);
                return view('AdminMerchant.AnalysisUser.rfm.config-confirm',  compact('analysisForm','rankUser','recensy','frequency','monetary'));
            }
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    public function postRfmConfigFinish(){
        
        DB::beginTransaction();
        try {
            $analysisForm = new AnalysisForm();
            if(Session::has("SESSION_ANALYSIS_CONFIG")){
                $analysisForm = Session::get("SESSION_ANALYSIS_CONFIG");
            }
            
            $merchantId = $this->merchantFormSession->getId();
            $rankUser = $this->configService->getDataByKey('rank_user', $merchantId);
            $recensy = $this->configService->getDataByKey('recensy', $merchantId);
            $frequency = $this->configService->getDataByKey('frequency', $merchantId);
            $monetary = $this->configService->getDataByKey('monetary', $merchantId);
            
            $analysisForm->setMerchantId($merchantId);
            // list Analysis
            $listForm = new AnalysisForm();
            $listForm->setMerchantId($merchantId);
            $analysisList = $this->analysisService->searchListData($listForm);
            // xóa tất cả dữ liệu cũ
            foreach ($analysisList as $key=>$value){
                $this->analysisService->delete($value->id);
            }
            // insert dữ liệu
            // insert Recency
            if($analysisForm->getListRecensy()!=null){
                foreach ($analysisForm->getListRecensy() as $key=>$value){
                    $addForm = new AnalysisForm();
                    $addForm->setMerchantId($merchantId);
                    $addForm->setCode('RECENSY');
                    if($key==0){
                        $addForm->setMinValue($analysisForm->getListRecensy()[$key+1]+1);
                    }else{
                        if(isset($analysisForm->getListRecensy()[$key+1])){
                            $addForm->setMaxValue($value);
                            $addForm->setMinValue($analysisForm->getListRecensy()[$key+1]+1);
                        }else{
                            $addForm->setMinValue(0);
                            $addForm->setMaxValue($value);
                        }
                        
                    }
                    
                    $addForm->setStatus(env('COMMON_STATUS_ACTIVE'));
                    $addForm->setPoint($key+1);
                    $this->analysisService->insert($addForm);
                }
            }
            // insert frequency
            if($analysisForm->getListFrequency()!=null){
                foreach ($analysisForm->getListFrequency() as $key=>$value){
                    $addForm = new AnalysisForm();
                    $addForm->setMerchantId($merchantId);
                    $addForm->setCode('FREQUENCY');
                    if($key==0){
                        $addForm->setMinValue(0);
                        $addForm->setMaxValue($value);
                    }else{
                        if(isset($analysisForm->getListFrequency()[$key+1])){
                            $addForm->setMinValue($analysisForm->getListFrequency()[$key-1]+1);
                            $addForm->setMaxValue($value);
                        }else{
                            $addForm->setMinValue($analysisForm->getListFrequency()[$key-1]+1);
                        }
                        
                    }
                    
                    $addForm->setStatus(env('COMMON_STATUS_ACTIVE'));
                    $addForm->setPoint($key+1);
                    $this->analysisService->insert($addForm);
                }
            }
            // insert monetary
            if($analysisForm->getListMonetary()!=null){
                foreach ($analysisForm->getListMonetary() as $key=>$value){
                    $addForm = new AnalysisForm();
                    $addForm->setMerchantId($merchantId);
                    $addForm->setCode('MONETARY');
                    if($key==0){
                        $addForm->setMinValue(0);
                        $addForm->setMaxValue($value);
                    }else{
                        if(isset($analysisForm->getListMonetary()[$key+1])){
                            $addForm->setMinValue($analysisForm->getListMonetary()[$key-1]+1);
                            $addForm->setMaxValue($value);
                        }else{
                            $addForm->setMinValue($analysisForm->getListMonetary()[$key-1]+1);
                        }
                        
                    }
                    
                    $addForm->setStatus(env('COMMON_STATUS_ACTIVE'));
                    $addForm->setPoint($key+1);
                    $this->analysisService->insert($addForm);
                }
            }
            Session::forget('SESSION_ANALYSIS_CONFIG');
            DB::commit();  
            return view('AdminMerchant.AnalysisUser.rfm.config-finish',  compact('analysisForm','rankUser','recensy','frequency','monetary'));
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
   
}

