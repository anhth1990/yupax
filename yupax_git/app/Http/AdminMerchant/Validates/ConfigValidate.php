<?php

namespace App\Http\AdminMerchant\Validates;

use App\Http\Forms\ConfigRatingForm;
use App\Http\Services\ConfigService;
use App\Http\Validates\BaseValidate;
use App\Http\Models\ConfigRatingDAO;
use App\Http\Forms\ConfigRatingGroupForm;
use App\Http\Forms\RatingForm;
use Exception;

class ConfigValidate extends BaseValidate  {
    private $configService;
    public function __construct() {
        $this->configService = new ConfigService();
    }

    public function validateConfigRating(ConfigRatingForm $validateForm){
        /*
         * validate form
         */
        $error = null;
        if($validateForm->getName()==null || $validateForm->getName()==""){
            $error = trans('error.name_required');
        }else if($validateForm->getType()==null || $validateForm->getType()==""){
            $error = trans('error.type_required');
        }else {
            if($validateForm->getType()!=env('RATING_TYPE_RECENSY')){
                if($validateForm->getPeriodic()==null || $validateForm->getPeriodic()==""){
                    $error = trans('error.periodic_required');
                }else if(!preg_match($this->PATTERN_IS_NUMBER, $validateForm->getPeriodic())){
                    $error = trans('error.periodic_must_be_number');
                }else if($validateForm->getMinValue()==null || $validateForm->getMinValue()==""){
                    $error = trans('error.min_value_required');
                }else if(!preg_match($this->PATTERN_IS_NUMBER, $validateForm->getMinValue())){
                    $error = trans('error.min_value_must_be_number');
                }else if($validateForm->getMaxValue()==null || $validateForm->getMaxValue()==""){
                    $error = trans('error.max_value_required');
                }else if(!preg_match($this->PATTERN_IS_NUMBER, $validateForm->getMaxValue())){
                    $error = trans('error.max_value_must_be_number');
                }else if(!$this->configService->checkExist($validateForm->getType(), $validateForm->getMinValue(), $validateForm->getMaxValue(),$validateForm->getPeriodic(), $validateForm->getId())){
                    $error = trans('error.there_are_similar_records');
                }
            }else if($validateForm->getMinValue()==null || $validateForm->getMinValue()==""){
                $error = trans('error.min_value_required');
            }else if(!preg_match($this->PATTERN_IS_NUMBER, $validateForm->getMinValue())){
                $error = trans('error.min_value_must_be_number');
            }else if($validateForm->getMaxValue()==null || $validateForm->getMaxValue()==""){
                $error = trans('error.max_value_required');
            }else if(!preg_match($this->PATTERN_IS_NUMBER, $validateForm->getMaxValue())){
                $error = trans('error.max_value_must_be_number');
            }else if(!$this->configService->checkExist($validateForm->getType(), $validateForm->getMinValue(), $validateForm->getMaxValue(),null, $validateForm->getId())){
                    $error = trans('error.there_are_similar_records');
                }
        }
        return $error;
    }
    
    public function validateConfigRatingGroup(ConfigRatingGroupForm $validateForm){
        /*
         * validate form
         */
        $error = null;
        if($validateForm->getName()==null || $validateForm->getName()==""){
            $error = trans('error.name_required');
        }else if($validateForm->getRecensyId() == 0 && $validateForm->getFrequencyId()==0 && $validateForm->getMonetaryId() ==0){
            $error = trans('error.choose_config_Rating');
        }else if(!$this->configService->checkExistRatingGroup($validateForm->getRecensyId(), $validateForm->getFrequencyId(), $validateForm->getMonetaryId(), $validateForm->getId())){
            $error = trans('error.there_are_similar_records');
        }
        return $error;
    }
    
    public function validateConfigRatingSetup(RatingForm $validateForm){
        /*
         * validate form
         */
        $error = null;
        if($validateForm->getCode()==null || $validateForm->getCode()==""){
            $error = trans('error.code_required');
        }else if(count($validateForm->getListRatingGroupId())<=0){
            $error = trans('error.choose_config_rating_group');
        }
        return $error;
    }

}
