<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\AdminMerchant\Controllers;
use App\Http\AdminMerchant\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Forms\UserDetailForm;
use App\Http\Forms\UserForm;
use App\Http\Forms\UserInfoForm;
use App\Http\Forms\MerchantForm;
use App\Http\Models\MerchantDAO;
use App\Http\Services\MerchantService;
//use App\Http\Models\PartnerDAO;
//use App\Http\Services\PartnerService;
use App\Http\Forms\PartnerForm;
use App\Http\Forms\ImportDataCsvForm;
use App\Http\Services\ImportCsvService;
use Exception;
use App\Http\Services\NotiEmailService;

class TestController_1 extends BaseController {
    private $importService;
    private $notiEmailService;
    public function __construct() {
        parent::__construct();
        $this->userService = new UserService();
        $this->merchantService = new MerchantService();
        //$this->partnerService = new PartnerService();
        $this->importService = new ImportCsvService();
        $this->notiEmailService = new NotiEmailService();
    }

    /*
     * Index
     */
    public function importData(ImportDataCsvForm $importDataCsvForm){
        $userForm = new UserForm();
        $userDetailForm = new UserDetailForm();
        /*
         * validate data
         */
        if($importDataCsvForm->getHashcodeMerchant()!=null){
            $merchantDao = new MerchantDAO();
            $merchantDao = $this->merchantService->getMerchantByHashcode($importDataCsvForm->getHashcodeMerchant());
            if($merchantDao==null){
                throw new Exception("import_data -> merchant_ko_ton_tai");
            }
            /*
             * merchant tồn tại
             * kiểm tra partner chuyền vào có phải của 
             * merchant không nêu không thì lấy partner mặc định của merchant
             */
            $partnerDao = new PartnerDAO();
            if($importDataCsvForm->getHashcodePartner()!=null){
                $partnerDao = $this->partnerService->getPartnerByHashcode($importDataCsvForm->getHashcodePartner());
                if($partnerDao==null){
                    throw new Exception("import_data -> partner_ko_ton_tai");
                }else{
                    /*
                     * partner không hợp lệ với merchant
                     * lay parner default cua merchant
                     */
                    $partnerDao = $this->partnerService->getPartnerByType($merchantDao->id,env('PARTNER_DEFAULT'));
                    if($partnerDao==null){
                        throw new Exception("import_data -> merchant_ko_co_partner_default");
                    }
                    //throw new Exception("import_data -> partner_ko_phu_hop_voi_merchant");
                }
            }else{
                /*
                 * lấy partner default của merchant
                 */
                $partnerDao = $this->partnerService->getPartnerByType($merchantDao->id,env('PARTNER_DEFAULT'));
                if($partnerDao==null){
                    throw new Exception("import_data -> merchant_ko_co_partner_default");
                }
            }
            $userDetailForm->setMerchantId($merchantDao->id);
            $userDetailForm->setPartnerId($partnerDao->id);
            $userDetailForm->setEmail($importDataCsvForm->getEmail());
            $userDetailForm->setMobile($importDataCsvForm->getMobile());
            $userInfoForm = new UserInfoForm();
            $userInfoForm = $this->userService->createUser($userForm,$userDetailForm);
        }else{
            throw new Exception("import_data -> thieu_du_lieu_merchant_code");
        }
        
        var_dump($userInfoForm);
        
    }
    
    public function getIndex(){
        echo "oke";
        die();
        $row = 1;
        $handle = fopen(base_path()."/public/uploads/merchant/B03149B1EB2027152795/import_csv_user_transaction_da114964694387f18666.csv", "r");
        if (($handle) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                //echo "<p> $num fields in line $row: <br /></p>\n";   
                $row++;
                for ($c=0; $c < $num; $c++) {
                    $blackpowder = $data;
                    $dynamit = implode(";", $blackpowder);
                    $pieces = explode(";", $dynamit);
                    $col1 = $pieces[0];
                    $col2 = $pieces[1];
                    $col3 = $pieces[2];
                    $col4 = $pieces[3];
                    $col5 = $pieces[4];
                    $col6 = $pieces[5];
                    $col7 = $pieces[6];
                }
                //idRef,email,mobile,amount,createdTime,hashcodeMerchant,hashcodePartner
                $importDataCsvForm = new ImportDataCsvForm();
                $importDataCsvForm->setHashcodeMerchant($col6);
                $importDataCsvForm->setEmail($col2);
                $importDataCsvForm->setMobile($col3);

                $importDataCsvForm->setIdRef($col1);
                $importDataCsvForm->setAmount($col4);
                $importDataCsvForm->setCreatedTime($col5);
                try {
                    $this->importService->importDataCsv($importDataCsvForm);
                    $this->logs_custom("insert_csv_thanh_cong (".$importDataCsvForm->getIdRef().")");
                } catch (Exception $ex) {
                    $this->logs_custom("import csv error (".$importDataCsvForm->getIdRef().")".$ex->getMessage());
                }
            }
        }
    }
    
    function read_file_docx($filename){

        $striped_content = '';
        $content = '';

        if(!$filename || !file_exists($filename)) return false;

        $zip = zip_open($filename);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        //echo $content;
        //echo "<hr>";
        //file_put_contents('1.xml', $content);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }
    
    public function readFile(){
        
    }
    
    public function testMail(){
        echo "oke";die();
         // thu nghiem send mail
        //require_once 'App/Http/Services/Mail/sendmail.php';
        //$merchantForm = new MerchantForm();
        //$merchantForm->setEmail("hoanganh18121990@gmail.com");
        //$merchantForm->setPassword("1234567");
        //sendMail($merchantForm);  
        $this->notiEmailService->sendMail("14A14986B72310C71429");
    }

    
    
}

