<?php

namespace App\Http\AdminMerchant\Validates;
use App\Http\Validates\BaseValidate;
use App\Http\Models\FileDAO;
use App\Http\Forms\FileForm;
use App\Http\Services\FileService;
use Exception;

class FileValidate extends BaseValidate  {
    private $fileService;
    public function __construct() {
        $this->fileService = new FileService();
    }

    public function validate(FileForm $validateForm){
        /*
         * validate form
         */
        if($validateForm->getName()==null){
            throw new Exception(trans("error.name_required"));
        }else if($validateForm->getType()==""){
            throw new Exception(trans("error.type_choice"));
        }else if($validateForm->getDataFile()==null){
            throw new Exception(trans("error.file_upload_choice"));
        }
        $file = $validateForm->getDataFile();
        $extension =$file->getClientOriginalExtension();
        if($validateForm->getType()=="USER_TRANSACTION"){
            if($extension!="csv"){
                throw new Exception(trans("error.file_extension_is_csv"));
            }
        }
    }
    

}
