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
use App\Http\Services\PromotionService;
use App\Http\Services\LibService;
use App\Http\Forms\PromotionForm;
use App\Http\Services\StoreService;
use App\Http\Services\StoreBranchService;
use App\Http\Forms\StoreForm;

class PromotionController extends BaseController {
    
    private $libService;
    private $promotionService;
    private $storeService;
    private $storeBranchService;
    public function __construct() {
        parent::__construct();
        $this->promotionService = new PromotionService();
        $this->libService = new LibService();
        $this->storeService = new StoreService();
        $this->storeBranchService = new StoreBranchService();
    }
    
    /*
     * list
     */
    public function getList(){
        try {
            $searchForm = new PromotionForm();
            if(Session::has('SESSION_SEARCH_PROMOTION')){
                $searchForm = Session::get('SESSION_SEARCH_PROMOTION');
            }
            // set page
            $page=1;
            if(isset($_GET['page'])){
                $page = intval($_GET['page']);
                if($page==0)$page=1; 
            }
            $searchForm->setPageSize(env('PAGE_SIZE'));
            $searchForm->setMerchantId($this->merchantFormSession->getId());
            $listObj = $this->promotionService->searchListData($searchForm);
            $countObj = $this->promotionService->countList($searchForm);
            return view('AdminMerchant.Promotion.list',  compact('listObj','countObj','searchForm','page'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postList(Request $data) {
        try {
            $response = $data->input();
            $searchForm = new PromotionForm();
            $searchForm->setStatus($response['status']);
            $searchForm->setName($response['name']);
            Session::put('SESSION_SEARCH_PROMOTION',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/promotion/list");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    public function getClearSearch(){
        try {
            Session::forget('SESSION_SEARCH_PROMOTION');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/promotion/list");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    
    /*
     * add
     */
    public function getAdd(){ 
        try {
            $addForm = new PromotionForm();
            $storeForm = new StoreForm();
            $storeForm->setMerchantId($this->merchantFormSession->getId());
            $storeForm->setStatus(env('COMMON_STATUS_ACTIVE'));
            $listStore = $this->storeService->searchListData($storeForm);
            $listBranch = $this->storeBranchService->searchListData($storeForm);
            return view('AdminMerchant.Promotion.add',  compact('addForm','listStore','listBranch'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    /*
     * add confirm
     */
    public function postAddConfirm(Request $data){
        try {
            $request = $data->input();
            $addForm = new PromotionForm();
            $addForm->setType($request['type']);
            $addForm->setIdRef($request['idRef']);
            $addForm->setName($request['name']);
            $addForm->setDateFrom($request['dateFrom']);
            $addForm->setDateTo($request['dateTo']);
            $addForm->setDescription($request['description']);
            $addForm->setStatus($request['status']);
            if($data->file('dataFile')!=null){
                $nameImage = $this->libService->uploadImageTmp($data->file('dataFile'), 'merchant/tmp','img');
                $addForm->setImages($nameImage);
                $addForm->setLinkImage('/public/uploads/merchant/tmp/'.$nameImage);
            }
            /*
             * validate
             */
            $err = "";
            if($addForm->getType()==null){
                $err = "Chon kiểu khuyến mại.";
            }elseif($addForm->getIdRef()==null){
                $err = "Chọn hệ thống.";
            }elseif($addForm->getName()==null){
                $err = "Tiêu đề là bắt buộc.";
            }elseif($data->file('dataFile')==null){
                $err = "Chọn ảnh.";
            }elseif($addForm->getDateFrom()==null){
                $err = "Ngày bắt đầu là bát buộc.";
            }
            /*
             * end validate
             */
            if($err!=""){
                $storeForm = new StoreForm();
                $storeForm->setMerchantId($this->merchantFormSession->getId());
                $storeForm->setStatus(env('COMMON_STATUS_ACTIVE'));
                $listStore = $this->storeService->searchListData($storeForm);
                $listBranch = $this->storeBranchService->searchListData($storeForm);
                return view('AdminMerchant.Promotion.add',  compact('addForm','err','listStore','listBranch'));
            }else{
                Session::put('SESSION_ADD_PROMOTION',$addForm);
                return view('AdminMerchant.Promotion.add-confirm',  compact('addForm'));
            }
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    /*
     * add finish
     */
    public function postAddFinish(){
        DB::beginTransaction();
        try {
            $addForm = new PromotionForm();
            if(Session::has("SESSION_ADD_PROMOTION")){
                $addForm = Session::get("SESSION_ADD_PROMOTION");
            }
            $merchantFolder = $this->merchantFormSession->getHashcode();
            // move file
            if($addForm->getImages()!=null){
                $fileLogo = base_path().'/public/uploads/merchant/tmp/'.$addForm->getImages();
                rename($fileLogo, base_path() . '/public/uploads/merchant/'.$merchantFolder.'/'.$addForm->getImages());
                $addForm->setLinkImage('/public/uploads/merchant/'.$merchantFolder.'/'.$addForm->getImages());
            }
            $addForm->setMerchantId($this->merchantFormSession->getId());
            $addForm->setDateFrom($this->formatDateInsert($addForm->getDateFrom()));
            if($addForm->getDateTo()!=null && $addForm->getDateTo()!=""){
                $addForm->setDateTo($this->formatDateInsert($addForm->getDateTo()));
            }
            $store = $this->promotionService->insert($addForm);
            $addForm->setCreatedAt($this->formatDate($store->created_at));
            Session::forget('SESSION_ADD_PROMOTION');
            DB::commit(); 
            return view('AdminMerchant.Promotion.add-finish',  compact('addForm'));
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    public function getDetail($hashcode){
        try {
            $store = $this->storeService->getDataByHashcode($hashcode);
            if($store==null){
                throw new Exception(trans('exception.DATA_NOT_FOUND'));
            }
            $detailForm = new StoreForm();
            $detailForm->setName($store->name);
            $detailForm->setHashcode($store->hashcode);
            $detailForm->setLinkLogo($store->logo);
            $detailForm->setStatus($store->status);
            $detailForm->setCreatedAt($this->formatDate($store->created_at));
            if($store->updated_at!=null)
                $detailForm->setUpdatedAt($this->formatDate($store->updated_at));
            // list branch
            $storeForm = new StoreForm();
            $storeForm->setStoreId($store->id);
            $listStoreBranch = $this->storeBranchService->searchListData($storeForm);
            return view('AdminMerchant.Store.detail',  compact('detailForm','listStoreBranch'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    public function getEdit($hashcode){
        try {
            $store = $this->storeService->getDataByHashcode($hashcode);
            if($store==null){
                throw new Exception(trans('exception.DATA_NOT_FOUND'));
            }
            $editForm = new StoreForm();
            $editForm->setName($store->name);
            $editForm->setHashcode($store->hashcode);
            $editForm->setLinkLogo($store->logo);
            $editForm->setStatus($store->status);
            
            return view('AdminMerchant.Store.edit',  compact('editForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    public function postEditConfirm(Request $data){
        try {
            $request = $data->input();
            $editForm = new StoreForm();
            $editForm->setName($request['name']);
            $editForm->setStatus($request['status']);
            $editForm->setHashcode($request['hashcode']);
            $editForm->setLinkLogo($request['linkLogo']);
            if($data->file('dataFileLogo')!=null){
                $nameLogo = $this->libService->uploadImageTmp($data->file('dataFileLogo'), 'merchant/tmp','logo_store');
                $editForm->setLogo($nameLogo);
                $editForm->setLinkLogo('/public/uploads/merchant/tmp/'.$nameLogo);
            }
            /*
             * validate
             */
            $err = "";
            if($editForm->getName()==null){
                $err = "Tên cửa hàng là bát buộc.";
            }
            /*
             * end validate
             */
            if($err!=""){
                return view('AdminMerchant.Store.edit',  compact('editForm','err'));
            }else{
                Session::put('SESSION_EDIT_STORE',$editForm);
                return view('AdminMerchant.Store.edit-confirm',  compact('editForm'));
            }
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    public function postEditFinish(){
        DB::beginTransaction();
        try {
            $editForm = new StoreForm();
            if(Session::has("SESSION_EDIT_STORE")){
                $editForm = Session::get("SESSION_EDIT_STORE");
            }
            $merchantFolder = $this->merchantFormSession->getHashcode();
            // move file
            if($editForm->getLogo()!=null){
                $fileLogo = base_path().'/public/uploads/merchant/tmp/'.$editForm->getLogo();
                rename($fileLogo, base_path() . '/public/uploads/merchant/'.$merchantFolder.'/'.$editForm->getLogo());
                $editForm->setLinkLogo('/public/uploads/merchant/'.$merchantFolder.'/'.$editForm->getLogo());
            }
            $store = $this->storeService->editStore($editForm);
            $editForm->setCreatedAt($this->formatDate($store->created_at));
            if($store->updated_at!=null)
                $editForm->setUpdatedAt($this->formatDate($store->updated_at));
            Session::forget('SESSION_EDIT_STORE');
            DB::commit();   
            return view('AdminMerchant.Store.edit-finish',  compact('editForm'));
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
}

