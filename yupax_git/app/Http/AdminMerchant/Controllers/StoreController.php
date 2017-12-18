<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\AdminMerchant\Controllers;
use App\Http\AdminMerchant\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Forms\StoreForm;
use Session;
use Exception;
use DB; 
use App\Http\Services\AddressService;
use App\Http\Services\LibService;
use App\Http\Services\StoreService;
use App\Http\Services\StoreBranchService;

class StoreController extends BaseController {
    
    private $addressService;
    private $libService;
    private $storeService;
    private $storeBranchService;
    public function __construct() {
        parent::__construct();
        $this->addressService = new AddressService();
        $this->libService = new LibService();
        $this->storeService = new StoreService();
        $this->storeBranchService = new StoreBranchService();
    }
    
    /*
     * list
     */
    public function getList(){
        try {
            $searchForm = new StoreForm();
            if(Session::has('SESSION_SEARCH_STORE')){
                $searchForm = Session::get('SESSION_SEARCH_STORE');
            }
            // set page
            $page=1;
            if(isset($_GET['page'])){
                $page = intval($_GET['page']);
                if($page==0)$page=1; 
            }
            $searchForm->setPageSize(env('PAGE_SIZE'));
            $searchForm->setMerchantId($this->merchantFormSession->getId());
            $listObj = $this->storeService->searchListData($searchForm);
            $countObj = $this->storeService->countList($searchForm);
            return view('AdminMerchant.Store.list',  compact('listObj','countObj','searchForm','page'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postList(Request $data) {
        try {
            $response = $data->input();
            $searchForm = new StoreForm();
            $searchForm->setStatus($response['status']);
            $searchForm->setName($response['name']);
            Session::put('SESSION_SEARCH_STORE',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/store/list");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    public function getClearSearch(){
        try {
            Session::forget('SESSION_SEARCH_STORE');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/store/list");
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
            $addForm = new StoreForm();
            $listProvince = $this->addressService->getProvince();
            $listDistrict = $this->addressService->getDistrict();
            $listWard = $this->addressService->getWard();
            return view('AdminMerchant.Store.add',  compact('addForm','listProvince','listDistrict','listWard'));
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
            $addForm = new StoreForm();
            $addForm->setName($request['name']);
            $addForm->setDescription($request['description']);
            $addForm->setNameBranch($request['nameBranch']);
            $addForm->setMobile($request['mobile']);
            $addForm->setEmail($request['email']);
            $addForm->setOpenTime($request['openTime']);
            $addForm->setCloseTime($request['closeTime']);
            $addForm->setProvinceId($request['provinceId']);
            $addForm->setDistrictId($request['districtId']);
            $addForm->setWardId($request['wardId']);
            $addForm->setAddress($request['address']);
            $addForm->setStatus($request['status']);
            $addForm->setLat($request['lat']);
            $addForm->setLong($request['long']);
            if($data->file('dataFileLogo')!=null){
                $nameLogo = $this->libService->uploadImageTmp($data->file('dataFileLogo'), 'merchant/tmp','logo_store');
                $addForm->setLogo($nameLogo);
                $addForm->setLinkLogo('/public/uploads/merchant/tmp/'.$nameLogo);
            }
            if($data->file('dataFileImages')!=null){
                $nameImage = $this->libService->uploadImageTmp($data->file('dataFileImages'), 'merchant/tmp','store');
                $addForm->setImages($nameImage);
                $addForm->setLinkImages('/public/uploads/merchant/tmp/'.$nameImage);
            }
            /*
             * validate
             */
            $err = "";
            if($addForm->getName()==null){
                $err = "Tên cửa hàng là bát buộc.";
            }elseif($addForm->getLogo()==null){
                $err = "Logo là bát buộc.";
            }elseif($addForm->getNameBranch()==null){
                $err = "Tên chi nhánh là bắt buộc.";
            }elseif($addForm->getMobile()==null){
                $err = "Số điện thoại là bát buộc.";
            }elseif($addForm->getProvinceId()==null){
                $err = "Tỉnh/thành phố là bát buộc.";
            }elseif($addForm->getDistrictId()==null){
                $err = "Quận/Huyện là bát buộc.";
            }elseif($addForm->getWardId()==null){
                $err = "Phường/Xã là bát buộc.";
            }elseif($addForm->getAddress()==null){
                $err = "Địa chỉ là bắt buộc là bát buộc.";
            }
            /*
             * end validate
             */
            if($err!=""){
                $listProvince = $this->addressService->getProvince();
                $listDistrict = $this->addressService->getDistrict();
                $listWard = $this->addressService->getWard();
                return view('AdminMerchant.Store.add',  compact('addForm','err','listProvince','listDistrict','listWard'));
            }else{
                $addForm->setProvinceName($this->addressService->getProvinceById($addForm->getProvinceId())->name);
                $addForm->setDistrictName($this->addressService->getDistrictById($addForm->getDistrictId())->name);
                $addForm->setWardName($this->addressService->getWardById($addForm->getWardId())->name);
                Session::put('SESSION_ADD_STORE',$addForm);
                return view('AdminMerchant.Store.add-confirm',  compact('addForm'));
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
            $addForm = new StoreForm();
            if(Session::has("SESSION_ADD_STORE")){
                $addForm = Session::get("SESSION_ADD_STORE");
            }
            $merchantFolder = $this->merchantFormSession->getHashcode();
            // move file
            if($addForm->getLogo()!=null){
                $fileLogo = base_path().'/public/uploads/merchant/tmp/'.$addForm->getLogo();
                rename($fileLogo, base_path() . '/public/uploads/merchant/'.$merchantFolder.'/'.$addForm->getLogo());
                $addForm->setLinkLogo('/public/uploads/merchant/'.$merchantFolder.'/'.$addForm->getLogo());
            }
            if($addForm->getImages()!=null){
                $fileImages = base_path().'/public/uploads/merchant/tmp/'.$addForm->getImages();
                rename($fileImages, base_path() . '/public/uploads/merchant/'.$merchantFolder.'/'.$addForm->getImages());
                $addForm->setLinkImages('/public/uploads/merchant/'.$merchantFolder.'/'.$addForm->getImages());
            }
            $addForm->setMerchantId($this->merchantFormSession->getId());
            $store = $this->storeService->insertStore($addForm);
            $addForm->setStoreId($store->id);
            $storeBranch = $this->storeBranchService->insertStoreBranch($addForm);
            $addForm->setCreatedAt($this->formatDate($store->created_at));
            Session::forget('SESSION_ADD_STORE');
            DB::commit();  
            return view('AdminMerchant.Store.add-finish',  compact('addForm'));
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    
    /*
     * add branch
     */
    public function getBranchAdd($storeHashcode){
        try {
            $store = $this->storeService->getDataByHashcode($storeHashcode);
            if($store==null){
                throw new Exception(trans('exception.DATA_NOT_FOUND'));
            }  
            $addForm = new StoreForm();
            $addForm->setName($store->name);
            $addForm->setLinkLogo($store->logo);
            $addForm->setStoreId($store->id);
            $addForm->setStoreHashcode($storeHashcode);
            $listProvince = $this->addressService->getProvince();
            $listDistrict = $this->addressService->getDistrict();
            $listWard = $this->addressService->getWard();
            return view('AdminMerchant.Store.branch.add',  compact('addForm','listProvince','listDistrict','listWard'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    /*
     * add branch confirm 
     */
    public function postAddBranchConfirm(Request $data){
        try {
            $request = $data->input();
            $addForm = new StoreForm();
            $addForm->setName($request['name']);
            $addForm->setLinkLogo($request['linkLogo']);
            $addForm->setStoreId($request['storeId']);
            $addForm->setStoreHashcode($request['storeHashcode']);
            $addForm->setNameBranch($request['nameBranch']);
            $addForm->setMobile($request['mobile']);
            $addForm->setEmail($request['email']);
            $addForm->setOpenTime($request['openTime']);
            $addForm->setCloseTime($request['closeTime']);
            $addForm->setProvinceId($request['provinceId']);
            $addForm->setDistrictId($request['districtId']);
            $addForm->setWardId($request['wardId']);
            $addForm->setAddress($request['address']);
            $addForm->setStatus($request['status']);
            $addForm->setLat($request['lat']);
            $addForm->setLong($request['long']);
            if($data->file('dataFileImages')!=null){
                $nameImage = $this->libService->uploadImageTmp($data->file('dataFileImages'), 'merchant/tmp','store');
                $addForm->setImages($nameImage);
                $addForm->setLinkImages('/public/uploads/merchant/tmp/'.$nameImage);
            }
            /*
             * validate
             */
            $err = "";
            if($addForm->getMobile()==null){
                $err = "Số điện thoại là bát buộc.";
            }elseif($addForm->getProvinceId()==null){
                $err = "Tỉnh/thành phố là bát buộc.";
            }elseif($addForm->getDistrictId()==null){
                $err = "Quận/Huyện là bát buộc.";
            }elseif($addForm->getWardId()==null){
                $err = "Phường/Xã là bát buộc.";
            }elseif($addForm->getAddress()==null){
                $err = "Địa chỉ là bắt buộc là bát buộc.";
            }
            /*
             * end validate
             */
            if($err!=""){
                $listProvince = $this->addressService->getProvince();
                $listDistrict = $this->addressService->getDistrict();
                $listWard = $this->addressService->getWard();
                return view('AdminMerchant.Store.branch.add',  compact('addForm','err','listProvince','listDistrict','listWard'));
            }else{
                $addForm->setProvinceName($this->addressService->getProvinceById($addForm->getProvinceId())->name);
                $addForm->setDistrictName($this->addressService->getDistrictById($addForm->getDistrictId())->name);
                $addForm->setWardName($this->addressService->getWardById($addForm->getWardId())->name);
                Session::put('SESSION_ADD_STORE_BRANCH',$addForm);
                return view('AdminMerchant.Store.branch.add-confirm',  compact('addForm'));
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
    public function postAddBranchFinish(){
        DB::beginTransaction();
        try {
            $addForm = new StoreForm();
            if(Session::has("SESSION_ADD_STORE_BRANCH")){
                $addForm = Session::get("SESSION_ADD_STORE_BRANCH");
            }
            $merchantFolder = $this->merchantFormSession->getHashcode();
            // move file
            if($addForm->getImages()!=null){
                $fileImages = base_path().'/public/uploads/merchant/tmp/'.$addForm->getImages();
                rename($fileImages, base_path() . '/public/uploads/merchant/'.$merchantFolder.'/'.$addForm->getImages());
                $addForm->setLinkImages('/public/uploads/merchant/'.$merchantFolder.'/'.$addForm->getImages());
            }
            $addForm->setMerchantId($this->merchantFormSession->getId());
            $storeBranch = $this->storeBranchService->insertStoreBranch($addForm);
            $addForm->setCreatedAt($this->formatDate($storeBranch->created_at));
            Session::forget('SESSION_ADD_STORE_BRANCH');
            DB::commit();   
            return view('AdminMerchant.Store.branch.add-finish',  compact('addForm'));
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
            $editForm->setDescription($store->description);
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
            $editForm->setDescription($request['description']);
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
    
    public function getBranchEdit($hashcode){
        try {
            $storeBranch = $this->storeBranchService->getDataByHashcode($hashcode);
            if($storeBranch==null){
                throw new Exception(trans('exception.DATA_NOT_FOUND'));
            }
            $store = $this->storeService->getDataByHashcode($storeBranch->store->hashcode);
            if($store==null){
                throw new Exception(trans('exception.DATA_NOT_FOUND'));
            }
            //location
            $listProvince = $this->addressService->getProvince();
            $listDistrict = $this->addressService->getDistrict();
            $listWard = $this->addressService->getWard();
            // --- end location
            $editForm = new StoreForm();
            $editForm->setName($store->name);
            $editForm->setLinkLogo($store->logo);
            $editForm->setStoreHashcode($store->hashcode);
            $editForm->setNameBranch($storeBranch->name);
            $editForm->setLinkImages($storeBranch->images);
            $editForm->setMobile($storeBranch->mobile);
            $editForm->setEmail($storeBranch->email);
            $editForm->setLat($storeBranch->lat);
            $editForm->setLong($storeBranch->long);
            $editForm->setOpenTime($storeBranch->openTime);
            $editForm->setCloseTime($storeBranch->closeTime);
            $editForm->setProvinceId($storeBranch->provinceId);
            $editForm->setDistrictId($storeBranch->districtId);
            $editForm->setWardId($storeBranch->wardId);
            $editForm->setHashcode($storeBranch->hashcode);
            $editForm->setAddress($storeBranch->address);
            $editForm->setStatus($storeBranch->status);
            
            return view('AdminMerchant.Store.branch.edit',  compact('editForm','listProvince','listDistrict','listWard'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    /*
     * edit confirm
     */
    public function postEditBranchConfirm(Request $data){
        try {
            $request = $data->input();
            $editForm = new StoreForm();
            $editForm->setName($request['name']);
            $editForm->setLinkLogo($request['linkLogo']);
            $editForm->setStoreHashcode($request['storeHashcode']);
            $editForm->setHashcode($request['hashcode']);
            $editForm->setNameBranch($request['nameBranch']);
            $editForm->setLinkImages($request['linkImages']);
            $editForm->setMobile($request['mobile']);
            $editForm->setEmail($request['email']);
            $editForm->setOpenTime($request['openTime']);
            $editForm->setCloseTime($request['closeTime']);
            $editForm->setProvinceId($request['provinceId']);
            $editForm->setDistrictId($request['districtId']);
            $editForm->setWardId($request['wardId']);
            $editForm->setAddress($request['address']);
            $editForm->setStatus($request['status']);
            $editForm->setLat($request['lat']);
            $editForm->setLong($request['long']);
            if($data->file('dataFileImages')!=null){
                $nameImage = $this->libService->uploadImageTmp($data->file('dataFileImages'), 'merchant/tmp','store');
                $editForm->setImages($nameImage);
                $editForm->setLinkImages('/public/uploads/merchant/tmp/'.$nameImage);
            }
            /*
             * validate
             */
            $err = "";
            if($editForm->getNameBranch()==null){
                $err = "Tên chi nhánh là bắt buộc.";
            }elseif($editForm->getMobile()==null){
                $err = "Số điện thoại là bát buộc.";
            }elseif($editForm->getProvinceId()==null){
                $err = "Tỉnh/thành phố là bát buộc.";
            }elseif($editForm->getDistrictId()==null){
                $err = "Quận/Huyện là bát buộc.";
            }elseif($editForm->getWardId()==null){
                $err = "Phường/Xã là bát buộc.";
            }elseif($editForm->getAddress()==null){
                $err = "Địa chỉ là bắt buộc là bát buộc.";
            }
            /*
             * end validate
             */
            if($err!=""){
                $listProvince = $this->addressService->getProvince();
                $listDistrict = $this->addressService->getDistrict();
                $listWard = $this->addressService->getWard();
                return view('AdminMerchant.Store.branch.edit',  compact('editForm','err','listProvince','listDistrict','listWard'));
            }else{
                $editForm->setProvinceName($this->addressService->getProvinceById($editForm->getProvinceId())->name);
                $editForm->setDistrictName($this->addressService->getDistrictById($editForm->getDistrictId())->name);
                $editForm->setWardName($this->addressService->getWardById($editForm->getWardId())->name);
                Session::put('SESSION_EDIT_STORE_BRANCH',$editForm);
                return view('AdminMerchant.Store.branch.edit-confirm',  compact('editForm'));
            }
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postEditBranchFinish(){
        DB::beginTransaction();
        try {
            $editForm = new StoreForm();
            if(Session::has("SESSION_EDIT_STORE_BRANCH")){
                $editForm = Session::get("SESSION_EDIT_STORE_BRANCH");
            }
            $merchantFolder = $this->merchantFormSession->getHashcode();
            // move file
            if($editForm->getImages()!=null){
                $fileImages = base_path().'/public/uploads/merchant/tmp/'.$editForm->getImages();
                rename($fileImages, base_path() . '/public/uploads/merchant/'.$merchantFolder.'/'.$editForm->getImages());
                $editForm->setLinkImages('/public/uploads/merchant/'.$merchantFolder.'/'.$editForm->getImages());
            }
            $storeBranch = $this->storeBranchService->editStoreBranch($editForm);
            $editForm->setCreatedAt($this->formatDate($storeBranch->created_at));
            if($storeBranch->updated_at!=null)
                $editForm->setUpdatedAt($this->formatDate($storeBranch->updated_at));
            Session::forget('SESSION_EDIT_STORE_BRANCH');
            DB::commit();   
            return view('AdminMerchant.Store.branch.edit-finish',  compact('editForm'));
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStoreBranchDelete(Request $data){
        DB::beginTransaction();
        try {
            $request = $data->input();
            $hashcode = $request['hashcode'];
            $this->storeBranchService->deleteData($hashcode);
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
    
    public function postStoreDelete(Request $data){
        DB::beginTransaction();
        try {
            $request = $data->input();
            $hashcode = $request['hashcode'];
            $this->storeService->deleteData($hashcode);
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

