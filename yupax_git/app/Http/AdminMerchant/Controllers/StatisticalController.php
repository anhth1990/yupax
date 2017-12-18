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
use App\Http\Forms\StatisticalForm;

class StatisticalController extends BaseController {
    
    
    public function __construct() {
        parent::__construct();
        
    }
    
    /*
     * Tổng quan
     */
    public function statistical(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICA')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICA');
            }
            return view('AdminMerchant.Statistical.dashboard',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatistical(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['timeSlot'])){
                $searchForm->setTimeSlot($response['timeSlot']);
            }
            Session::put('SESSION_SEARCH_STATISTICA',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatistical(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICA');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    /*
     * Tổng doanh thu $ vnd revenue
     */
    public function statisticalRevenue(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICAL_REVENUE')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICAL_REVENUE');
            }
            return view('AdminMerchant.Statistical.revenue',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatisticalRevenue(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['timeSlot'])){
                $searchForm->setTimeSlot($response['timeSlot']);
            }
            Session::put('SESSION_SEARCH_STATISTICAL_REVENUE',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/revenue");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatisticalRevenue(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICAL_REVENUE');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/revenue");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    /*
     * Doanh thu vnd/bàn/giờ REVPASH
     */
    public function statisticalRevpash(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICAL_REVPASH')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICAL_REVPASH');
            }
            return view('AdminMerchant.Statistical.revpash',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatisticalRevpash(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['timeSlot'])){
                $searchForm->setTimeSlot($response['timeSlot']);
            }
            Session::put('SESSION_SEARCH_STATISTICAL_REVPASH',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/revpash");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatisticalRevpash(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICAL_REVPASH');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/revpash");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    /*
     * Doanh thu vnd/bàn/giờ REVPASH
     */
    public function statisticalRevtab(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICAL_REVTAB')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICAL_REVTAB');
            }
            return view('AdminMerchant.Statistical.revtab',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatisticalRevtab(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['timeSlot'])){
                $searchForm->setTimeSlot($response['timeSlot']);
            }
            Session::put('SESSION_SEARCH_STATISTICAL_REVTAB',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/revtab");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatisticalRevtab(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICAL_REVTAB');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/revtab");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    /*
     * Doanh thu vnd/hóa đơn REVBILL
     */
    public function statisticalRevbill(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICAL_REVBILL')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICAL_REVBILL');
            }
            return view('AdminMerchant.Statistical.revbill',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatisticalRevbill(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['timeSlot'])){
                $searchForm->setTimeSlot($response['timeSlot']);
            }
            Session::put('SESSION_SEARCH_STATISTICAL_REVBILL',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/revbill");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatisticalRevbill(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICAL_REVBILL');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/revbill");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    /*
     * Doanh thu vnd/m2 REVPAM
     */
    public function statisticalRevpam(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICAL_REVPAM')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICAL_REVPAM');
            }
            return view('AdminMerchant.Statistical.revpam',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatisticalRevpam(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['timeSlot'])){
                $searchForm->setTimeSlot($response['timeSlot']);
            }
            Session::put('SESSION_SEARCH_STATISTICAL_REVPAM',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/revpam");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatisticalRevpam(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICAL_REVPAM');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/revpam");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    /*
     * Khách hàng guests
     */
    public function statisticalGuests(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICAL_GUESTS')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICAL_GUESTS');
            }
            return view('AdminMerchant.Statistical.guests',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatisticalGuests(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['timeSlot'])){
                $searchForm->setTimeSlot($response['timeSlot']);
            }
            Session::put('SESSION_SEARCH_STATISTICAL_GUESTS',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/guests");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatisticalGuests(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICAL_GUESTS');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/guests");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    /*
     * Khách hàng guestbill
     */
    public function statisticalGuestbill(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICAL_GUESTBILL')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICAL_GUESTBILL');
            }
            return view('AdminMerchant.Statistical.guestbill',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatisticalGuestbill(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['timeSlot'])){
                $searchForm->setTimeSlot($response['timeSlot']);
            }
            Session::put('SESSION_SEARCH_STATISTICAL_GUESTBILL',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/guestbill");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatisticalGuestbill(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICAL_GUESTBILL');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/guestbill");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
     /*
     * Thời gian trung bình 1 lượt khách timeturn
     */
    public function statisticalTimeturn(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICAL_TIMETURN')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICAL_TIMETURN');
            }
            return view('AdminMerchant.Statistical.timeturn',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatisticalTimeturn(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['timeSlot'])){
                $searchForm->setTimeSlot($response['timeSlot']);
            }
            Session::put('SESSION_SEARCH_STATISTICAL_TIMETURN',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/timeturn");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatisticalTimeturn(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICAL_TIMETURN');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/timeturn");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    /*
     * Đặt món
     */
    public function statisticalMeal(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICAL_MEAL')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICAL_MEAL');
            }
            return view('AdminMerchant.Statistical.meal',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatisticalMeal(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['store'])){
                $searchForm->setStore($response['store']);
            }
            $err="";
            if($searchForm->getStore()==null){
                $err = "Mời bạn chọn cửa hàng";
            }
            if($err!=""){
                return view('AdminMerchant.Statistical.meal',  compact('searchForm','err'));
            }
            Session::put('SESSION_SEARCH_STATISTICAL_MEAL',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/meal");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatisticalMeal(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICAL_MEAL');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/meal");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
     /*
     *  complaintbill
     */
    public function statisticalComplaintbill(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICAL_COMPLAINTBILL')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICAL_COMPLAINTBILL');
            }
            return view('AdminMerchant.Statistical.complaintbill',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatisticalComplaintbill(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['timeSlot'])){
                $searchForm->setTimeSlot($response['timeSlot']);
            }
            Session::put('SESSION_SEARCH_STATISTICAL_COMPLAINTBILL',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/complaintbill");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatisticalComplaintbill(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICAL_COMPLAINTBILL');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/complaintbill");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    /*
     *  Unavailabilityitem
     */
    public function statisticalUnavailabilityitem(){
        try {
            $searchForm = new StatisticalForm();
            if(Session::has('SESSION_SEARCH_STATISTICAL_UNAVAIBILYTIITEM')){
                $searchForm = Session::get('SESSION_SEARCH_STATISTICAL_UNAVAIBILYTIITEM');
            }
            return view('AdminMerchant.Statistical.unavaibilytiitem',  compact('searchForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function postStatisticalUnavailabilityitem(Request $data){
        try {
            $response = $data->input();
            $searchForm = new StatisticalForm();
            $searchForm->setFromDate($response['fromDate']);
            $searchForm->setToDate($response['toDate']);
            if(isset($response['timeSlot'])){
                $searchForm->setTimeSlot($response['timeSlot']);
            }
            
            Session::put('SESSION_SEARCH_STATISTICAL_UNAVAIBILYTIITEM',$searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/unavailabilityitem");
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error')); 
        }
    }
    public function clearSearchStatisticalUnavailabilityitem(){
        try {
            Session::forget('SESSION_SEARCH_STATISTICAL_UNAVAIBILYTIITEM');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT')."/statistical/unavailabilityitem");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : ".$ex->getMessage(). "\nFile : ".$ex->getFile() . "\nLine : ".$ex->getLine() );
            $error = $ex->getMessage();
            return view('errors.503',  compact('error'));
        }
    }
    
}

