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
use DB;
use Exception;
use App\Http\Services\UserService;
use App\Http\Forms\UserInfoForm;
use App\Http\Forms\FileForm;
use App\Http\Models\FileDAO;
use App\Http\Services\FileService;
use App\Http\Services\LibService;
use App\Http\Forms\UserForm;

class UserController extends BaseController {
    
    private $userService;
    private $fileService;
    private $libservice;
    public function __construct() {
        parent::__construct();
        $this->userService = new UserService();
        $this->fileService = new FileService();
        $this->libservice = new LibService();
    }
    
    private function getFileImport($type){
        $fileForm = new FileForm();
        $fileForm->setPartnerId($this->merchantFormSession->getPartnerDefault());
        $fileForm->setMerchantId($this->merchantFormSession->getId());
        $fileForm->setType($type);
        $fileForm->setStatus(env('COMMON_STATUS_PENDING'));
        return $this->fileService->getListByCondition($fileForm);
    }
    
    /*
     * view list user rating
     */
    public function getViewList(){
        try {
            $titlePage = $this->configuration->titlePageAdminMerchant.  trans('user.title_page');
            $userInfo = new UserInfoForm();
            $userInfo->setMerchantId($this->merchantFormSession->getId());
            $listUser = $this->userService->getViewListRatingUser($userInfo);
            return view('AdminMerchant.User.view-rating',  compact('titlePage','listUser'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
        /*
         $titlePage = $this->configuration->titlePageAdminMerchant.  trans('user.title_page');
            $userInfo = new UserInfoForm();
            $userInfo->setPartnerId($this->merchantFormSession->getPartnerDefault());
            $userInfo->setMerchantId($this->merchantFormSession->getId());
            $listUser = $this->userService->getViewListRatingUser($userInfo);
            return view('AdminMerchant.User.view-rating',  compact('titlePage','listUser'));
         */
    }
    
    /*
     * process csv data
     */
    public function getUploadDataCsv(){
        $titlePage = $this->configuration->titlePageAdminMerchant.  trans('user.title_page');
        $fileForm = new FileForm();
        $listFile= null;
        try {
            $listFile = $this->getFileImport('USER_TRANSACTION');
            return view('AdminMerchant.User.upload-data-csv',  compact('titlePage','listFile','fileForm'));
        } catch (Exception $ex) {
            $error = trans('error.error_system');
            return view('AdminMerchant.User.upload-data-csv',  compact('titlePage','listFile','fileForm'));
        }
    }
    
    public function postUploadDataCsv(Request $request){
        $titlePage = $this->configuration->titlePageAdminMerchant.  trans('user.title_page');
        $fileForm = new FileForm();
        $data = $request->input();
        $fileForm->setHashcode($data['hashcode']);
        $listFile = null;
        try {
            $listFile = $this->getFileImport('USER_TRANSACTION');
            if($fileForm->getHashcode()==null || $fileForm->getHashcode()==""){
                $error = "Chọn file thực thi.";
                return view('AdminMerchant.User.upload-data-csv',  compact('titlePage','listFile','fileForm','error'));
            }
            $this->userService->processFileCsv($fileForm);
            return view('AdminMerchant.User.upload-data-csv-finish',  compact('titlePage','listFile','fileForm'));
        } catch (Exception $ex) {
            $this->logs_custom($ex->getMessage()." Line : ".$ex->getLine()." File : ".$ex->getFile());
            $error = trans('error.error_system');
            return view('AdminMerchant.User.upload-data-csv',  compact('titlePage','listFile','fileForm','error'));
        }
    }
    
    
    /* ******************************* version 1.1 ********** */
    public function getList(){
        try {
            $searchForm = new UserForm();
            if(Session::has('SESSION_SEARCH_USER')){
                $searchForm = Session::get('SESSION_SEARCH_USER');
            }
            // set page
            $page=1;
            if(isset($_GET['page'])){
                $page = intval($_GET['page']);
                if($page==0)$page=1; 
            }
            $searchForm->setPageSize(env('PAGE_SIZE'));
            $searchForm->setMerchantId($this->merchantFormSession->getId());
            $listObj = $this->userService->searchData($searchForm);
            $countObj = $this->userService->countListData($searchForm);
            return view('AdminMerchant.User.list',  compact('listObj','countObj','page'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    /*
     * import csv
     */
    public function getImportCsv(){
        try {
            /*
             * danh sách file
             */
            $fileForm = new FileForm();
            $fileForm->setMerchantId($this->merchantFormSession->getId());
            $fileForm->setType('CREATE_USER');
            $listFile = $this->fileService->searchListData($fileForm);
            return view('AdminMerchant.User.import-csv',  compact('listFile'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    /*
     * imporrt csv confirm
     */
    public function postImportCsvConfirm(Request $data){
        
        try {
            $request = $data->input();
            $fileForm = new FileForm();
            $fileForm->setHashcode($request['file']);
            /*
             * validate
             */
            $err = "";
            if(!isset($request['file']) || $request['file']==null){
                $err = "Mời chọn dữ liệu thực thi";
            }
            /*
             * end validate
             */
            if($err!=""){
                $fileForm = new FileForm();
                $fileForm->setMerchantId($this->merchantFormSession->getId());
                $fileForm->setType('CREATE_USER');
                $listFile = $this->fileService->searchListData($fileForm);
                return view('AdminMerchant.User.import-csv',  compact('err','listFile'));
            }else{
                $file = $this->fileService->findDataByHashcode($fileForm->getHashcode());
                $fileForm->setName($file['name']);
                //$this->userService->processFileCsv($fileForm);
                Session::put('SESSION_ADD_USER_CSV',$fileForm);
                return view('AdminMerchant.User.import-csv-confirm',  compact('fileForm'));
                
            }
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    public function postImportCsvFinish(){
        DB::beginTransaction();
        try {
            $addForm = new FileForm();
            if(Session::has("SESSION_ADD_USER_CSV")){
                $addForm = Session::get("SESSION_ADD_USER_CSV");
            }
            $merchantFolder = $this->merchantFormSession->getHashcode();
            $addForm->setMerchantHashcode($merchantFolder);
            $this->userService->processFileCsv($addForm);
            Session::forget('SESSION_ADD_USER_CSV');
            DB::commit();  
            return view('AdminMerchant.User.import-csv-finish',  compact('addForm'));
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
}

