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
use App\Http\Services\NewsService;
use App\Http\Services\LibService;
use App\Http\Forms\NewsForm;

class NewsController extends BaseController {
    
    private $libService;
    private $newsService;
    public function __construct() {
        parent::__construct();
        $this->newsService = new NewsService();
        $this->libService = new LibService();
    }
    
    /*
     * list
     */
    public function getList(){
        try {
            $searchForm = new NewsForm();
            if(Session::has('SESSION_SEARCH_NEWS')){
                $searchForm = Session::get('SESSION_SEARCH_NEWS');
            }
            // set page
            $page=1;
            if(isset($_GET['page'])){
                $page = intval($_GET['page']);
                if($page==0)$page=1; 
            }
            $searchForm->setPageSize(env('PAGE_SIZE'));
            $searchForm->setMerchantId($this->merchantFormSession->getId());
            $listObj = $this->newsService->searchListData($searchForm);
            $countObj = $this->newsService->countList($searchForm);
            return view('AdminMerchant.News.list',  compact('listObj','countObj','searchForm','page'));
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
            $addForm = new NewsForm();
            return view('AdminMerchant.News.add',  compact('addForm'));
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
            $addForm = new NewsForm();
            $addForm->setName($request['name']);
            $addForm->setDescription($request['description']);
            $addForm->setStatus($request['status']);
            if($data->file('dataFile')!=null){
                $nameImage = $this->libService->uploadImageTmp($data->file('dataFile'), 'merchant/tmp','news');
                $addForm->setImages($nameImage);
                $addForm->setLinkImage('/public/uploads/merchant/tmp/'.$nameImage);
            }
            /*
             * validate
             */
            $err = "";
            if($addForm->getName()==null){
                $err = "Tiêu đề là bắt buộc.";
            }elseif($data->file('dataFile')==null){
                $err = "Chọn ảnh.";
            }
            /*
             * end validate
             */
            if($err!=""){
                return view('AdminMerchant.News.add',  compact('addForm','err'));
            }else{
                Session::put('SESSION_ADD_NEWS',$addForm);
                return view('AdminMerchant.News.add-confirm',  compact('addForm'));
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
            $addForm = new NewsForm();
            if(Session::has("SESSION_ADD_NEWS")){
                $addForm = Session::get("SESSION_ADD_NEWS");
            }
            $merchantFolder = $this->merchantFormSession->getHashcode();
            // move file
            if($addForm->getImages()!=null){
                $fileLogo = base_path().'/public/uploads/merchant/tmp/'.$addForm->getImages();
                rename($fileLogo, base_path() . '/public/uploads/merchant/'.$merchantFolder.'/'.$addForm->getImages());
                $addForm->setLinkImage('/public/uploads/merchant/'.$merchantFolder.'/'.$addForm->getImages());
            }
            $addForm->setMerchantId($this->merchantFormSession->getId());
            $news = $this->newsService->insert($addForm);
            $addForm->setCreatedAt($this->formatDate($news->created_at));
            Session::forget('SESSION_ADD_NEWS');
            DB::commit();  
            return view('AdminMerchant.News.add-finish',  compact('addForm'));
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

