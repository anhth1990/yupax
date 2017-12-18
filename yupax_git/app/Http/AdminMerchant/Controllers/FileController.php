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
use App\Http\Forms\FileForm;
use App\Http\Services\FileService;
use App\Http\Services\LibService;
use DB;

class FileController extends BaseController {
    
    private $fileService;
    private $libService;
    public function __construct() {
        parent::__construct();
        $this->libService = new LibService();
        $this->fileService = new FileService();
    }
    
    public function getList(){
        try {
            $searchForm = new FileForm();
            if(Session::has('SESSION_SEARCH_FILE')){
                $searchForm = Session::get('SESSION_SEARCH_FILE');
            }
            // set page
            $page=1;
            if(isset($_GET['page'])){
                $page = intval($_GET['page']);
                if($page==0)$page=1; 
            }
            $searchForm->setPageIndex($page);
            $searchForm->setMerchantId($this->merchantFormSession->getId());
            $searchForm->setPageSize(env('PAGE_SIZE'));
            $listObj = $this->fileService->searchListData($searchForm);
            $countObj = $this->fileService->countList($searchForm);
            return view('AdminMerchant.File.list',  compact('listObj','countObj','page','searchForm')); 
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    public function postList(Request $data) {
        try {
            $response = $data->input();
            $searchForm = new FileForm();
            $searchForm->setStatus($response['status']);
            $searchForm->setName($response['name']);
            $searchForm->setType($response['type']);
            Session::put('SESSION_SEARCH_FILE',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/file/list");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    
    public function getClearSearch(){
        try {
            Session::forget('SESSION_SEARCH_FILE');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/file/list");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    
    public function getAdd(){
        try {
            
            return view('AdminMerchant.File.add'); 
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    public function postAddConfirm(Request $data){
        DB::beginTransaction();
        try {
            $request = $data->input();
            $addForm = new FileForm();
            $addForm->setType($request['type']);
            $addForm->setDataFile($data->file('dataFile'));
            $addForm->setName($request['name']);
            $addForm->setStatus($request['status']);
            /*
             * validate
             */
            $err = "";
            if($addForm->getDataFile()==null){
                $err = "Mời chọn dữ liệu";
            }elseif($addForm->getName()==null){
                $err = "Mời nhập tên dữ liệu";
            }
            if($err==""){
                $type = $addForm->getType();
                $extension =$addForm->getDataFile()->getClientOriginalExtension();
                $addForm->setExtension($extension);
                switch ($type){
                    case "TRANSACTION":
                        if($extension!="csv"){
                            $err = "Loại dữ liệu tải lên phải là csv";
                        }
                        break;
                    case "CREATE_USER":
                        if($extension!="csv"){
                            $err = "Loại dữ liệu tải lên phải là csv";
                        }
                        break;
                    default:
                        $err = "Mời chọn loại dữ liệu";
                }
            }
            /*
             * end validate
             */
            if($err!=""){
                return view('AdminMerchant.File.add',  compact('err'));
            }else{
                $addForm->setMerchantId($this->merchantFormSession->getId());
                $addForm->setFolderName($this->merchantFormSession->getHashcode());
                $file = $this->fileService->createFile($addForm);
                $addForm->setCreatedAt($this->formatDate($file->created_at));
                DB::commit();
                return view('AdminMerchant.File.add-finish',  compact('addForm'));
            }
             
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    public function getDetail($hashcode){
        try {
            $file = $this->fileService->findDataByHashcode($hashcode);
            if($file==null){
                throw new Exception("data not found");
            }
            $detailForm = new FileForm();
            $detailForm->setName($file->name);
            $detailForm->setHashcode($file->hashcode);
            $detailForm->setType($file->type);
            $detailForm->setExtension($file->extension);
            $detailForm->setStatus($file->status);
            $detailForm->setCreatedAt($this->formatDate($file->created_at));
            if($file->updated_at!=null)
                $detailForm->setUpdatedAt($this->formatDate($file->updated_at));
            return view('AdminMerchant.File.detail',  compact('detailForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    public function postDelete(Request $data){
        DB::beginTransaction();
        try {
            $request = $data->input();
            $hashcode = $request['hashcode'];
            $this->fileService->deleteData($hashcode);
            DB::commit();
            $response = array();
            $response['errCode']=200;
            $response['errMess']=  trans('common.action_success');
            return json_encode($response);
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            $response = array();
            $response['errCode']=100;
            $response['errMess']=  $error;
            return json_encode($response);
        }
    }
    
}

