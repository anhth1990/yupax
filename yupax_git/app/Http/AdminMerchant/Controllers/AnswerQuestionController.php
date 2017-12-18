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
use App\Http\Forms\AnswerQuestionForm;
use App\Http\Services\AnswerQuestionService;

class AnswerQuestionController extends BaseController {

    private $answerQuestionService;

    public function __construct() {
        parent::__construct();
        $this->answerQuestionService = new AnswerQuestionService();
    }

    public function getList() {
        try {
            $searchForm = new AnswerQuestionForm();
            if (Session::has('SESSION_SEARCH_ANSWER_QUESTION')) {
                $searchForm = Session::get('SESSION_SEARCH_ANSWER_QUESTION');
            }
            // set page
            $page = 1;
            if (isset($_GET['page'])) {
                $page = intval($_GET['page']);
                if ($page == 0)
                    $page = 1;
            }
            $searchForm->setPageSize(env('PAGE_SIZE'));
            $searchForm->setMerchantId($this->merchantFormSession->getId());
            $listObj = $this->answerQuestionService->searchListData($searchForm);
            $countObj = $this->answerQuestionService->countList($searchForm);
            return view('AdminMerchant.AnswerQuestion.list', compact('listObj', 'countObj', 'searchForm', 'page'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function postList(Request $data) {
        try {
            $response = $data->input();
            $searchForm = new AnswerQuestionForm();
            $searchForm->setStatus($response['status']);
            $searchForm->setAnswer($response['answer']);
            Session::put('SESSION_SEARCH_ANSWER_QUESTION', $searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT') . "/answer-question/list");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function getClearSearch() {
        try {
            Session::forget('SESSION_SEARCH_ANSWER_QUESTION');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT') . "/answer-question/list");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    /*
     * add
     */

    public function getAdd() {
        try {
            $addForm = new AnswerQuestionForm();

            return view('AdminMerchant.AnswerQuestion.add', compact('addForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function getAnswerView() {
        try {
            return view('AdminMerchant.AnswerQuestion.answer-view')->render();
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    /*
     * add confirm
     */

    public function postAddConfirm(Request $data) {
        try {
            $request = $data->input();
            $addForm = new AnswerQuestionForm();
            $addForm->setAnswer($request['answer']);
            $addForm->setType($request['type']);
            $addForm->setStatus($request['status']);
            if (isset($request['question'])) {
                $addForm->setListQuestion($request['question']);
            }
            if (isset($request['result'])) {
                $addForm->setListResult($request['result']);
            }
            /*
             * validate
             */
            $err = "";
            if ($addForm->getAnswer() == null) {
                $err = "Câu hỏi là bắt buộc";
            } elseif ($addForm->getType() == null) {
                $err = "Chọn kiểu";
            } elseif ($addForm->getListQuestion() == null) {
                $err = "Thêm một câu trả lời";
            }
            /*
             * end validate
             */
            if ($err != "") {
                return view('AdminMerchant.AnswerQuestion.add', compact('addForm', 'err'));
            } else {
                Session::put('SESSION_ADD_ANSWER_QUESTION', $addForm);
                return view('AdminMerchant.AnswerQuestion.add-confirm', compact('addForm'));
            }
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    /*
     * add finish
     */

    public function postAddFinish() {
        DB::beginTransaction();
        try {
            $addForm = new AnswerQuestionForm();
            if (Session::has("SESSION_ADD_ANSWER_QUESTION")) {
                $addForm = Session::get("SESSION_ADD_ANSWER_QUESTION");
            }
            $addForm->setMerchantId($this->merchantFormSession->getId());
            $answer = $this->answerQuestionService->insertAnswer($addForm);
            foreach ($addForm->getListQuestion() as $key => $value) {
                $questionForm = new AnswerQuestionForm();
                $questionForm->setName($value);
                $questionForm->setResult($addForm->getListResult()[$key]);
                $questionForm->setAnswerId($answer->id);
                $questionForm->setStatus($addForm->getStatus());
                $this->answerQuestionService->insertQuestion($questionForm);
            }
            $addForm->setCreatedAt($this->formatDate($answer->created_at));
            Session::forget('SESSION_ADD_ANSWER_QUESTION');
            DB::commit();
            return view('AdminMerchant.AnswerQuestion.add-finish', compact('addForm'));
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function getDetail($hashcode) {
        try {
            $answer = $this->answerQuestionService->getAnswerByHashcode($hashcode);
            if ($answer == null) {
                throw new Exception(trans('exception.DATA_NOT_FOUND'));
            }
            $detailForm = new AnswerQuestionForm();
            $detailForm->setAnswer($answer->answer);
            $detailForm->setType($answer->type);
            $detailForm->setHashcode($answer->hashcode);
            $detailForm->setStatus($answer->status);
            $detailForm->setCreatedAt($this->formatDate($answer->created_at));
            if ($answer->updated_at != null)
                $detailForm->setUpdatedAt($this->formatDate($answer->updated_at));
            // list question
            $questionForm = new AnswerQuestionForm();
            $questionForm->setAnswerId($answer->id);
            $listQuestion = $this->answerQuestionService->searchListQuestion($questionForm);
            return view('AdminMerchant.AnswerQuestion.detail', compact('detailForm', 'listQuestion'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function getEdit($hashcode) {
        try {
            $answer = $this->answerQuestionService->getAnswerByHashcode($hashcode);
            if ($answer == null) {
                throw new Exception(trans('exception.DATA_NOT_FOUND'));
            }
            $editForm = new AnswerQuestionForm();
            $editForm->setAnswer($answer->answer);
            $editForm->setType($answer->type);
            $editForm->setHashcode($answer->hashcode);
            $editForm->setStatus($answer->status);

            return view('AdminMerchant.AnswerQuestion.edit', compact('editForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function postEditConfirm(Request $data) {
        try {
            $request = $data->input();
            $editForm = new AnswerQuestionForm();
            $editForm->setAnswer($request['answer']);
            $editForm->setStatus($request['status']);
            $editForm->setType($request['type']);
            $editForm->setHashcode($request['hashcode']);
            /*
             * validate
             */
            $err = "";
            if ($editForm->getAnswer() == null) {
                $err = "Câu hỏi là bắt buộc";
            } elseif ($editForm->getType() == null) {
                $err = "Chọn kiểu";
            }
            /*
             * end validate
             */
            if ($err != "") {
                return view('AdminMerchant.AnswerQuestion.edit', compact('editForm', 'err'));
            } else {
                Session::put('SESSION_EDIT_ANSWER_QUESTION', $editForm);
                return view('AdminMerchant.AnswerQuestion.edit-confirm', compact('editForm'));
            }
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function postEditFinish() {
        DB::beginTransaction();
        try {
            $editForm = new AnswerQuestionForm();
            if (Session::has("SESSION_EDIT_ANSWER_QUESTION")) {
                $editForm = Session::get("SESSION_EDIT_ANSWER_QUESTION");
            }
            $answer = $this->answerQuestionService->editAnswer($editForm);
            $editForm->setCreatedAt($this->formatDate($answer->created_at));
            if ($answer->updated_at != null)
                $editForm->setUpdatedAt($this->formatDate($answer->updated_at));
            Session::forget('SESSION_EDIT_ANSWER_QUESTION');
            DB::commit();
            return view('AdminMerchant.AnswerQuestion.edit-finish', compact('editForm'));
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function getQuestionEdit($hashcode) {
        try {
            $question = $this->answerQuestionService->getQuestionByHashcode($hashcode);
            if ($question == null) {
                throw new Exception(trans('exception.DATA_NOT_FOUND'));
            }
            $answer = $this->answerQuestionService->getAnswerByHashcode($question->answer->hashcode);
            if ($answer == null) {
                throw new Exception(trans('exception.DATA_NOT_FOUND'));
            }

            $editForm = new AnswerQuestionForm();
            $editForm->setAnswer($answer->answer);
            $editForm->setType($answer->type);
            $editForm->setStatusAnswer($answer->status);
            $editForm->setHashcodeAnswer($answer->hashcode);
            $editForm->setName($question->name);
            $editForm->setResult($question->result);
            $editForm->setHashcode($question->hashcode);
            $editForm->setStatus($question->status);

            return view('AdminMerchant.AnswerQuestion.question.edit', compact('editForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function postQuestionEditConfirm(Request $data) {
        try {
            $request = $data->input();
            $editForm = new AnswerQuestionForm();
            $editForm->setAnswer($request['answer']);
            $editForm->setStatusAnswer($request['statusAnswer']);
            $editForm->setHashcodeAnswer($request['hashcodeAnswer']);
            $editForm->setType($request['type']);
            $editForm->setName($request['name']);
            $editForm->setStatus($request['status']);
            if (isset($request['result'])) {
                $editForm->setResult($request['result']);
            } else {
                $editForm->setResult(0);
            }
            $editForm->setHashcode($request['hashcode']);
            /*
             * validate
             */
            $err = "";
            if ($editForm->getName() == null) {
                $err = "Câu trả lời là bắt buộc";
            }
            /*
             * end validate
             */
            if ($err != "") {
                return view('AdminMerchant.AnswerQuestion.question.edit', compact('editForm', 'err'));
            } else {
                Session::put('SESSION_EDIT_QUESTION', $editForm);
                return view('AdminMerchant.AnswerQuestion.question.edit-confirm', compact('editForm'));
            }
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }
    
    public function postQuestionEditFinish() {
        DB::beginTransaction();
        try {
            $editForm = new AnswerQuestionForm();
            if (Session::has("SESSION_EDIT_QUESTION")) {
                $editForm = Session::get("SESSION_EDIT_QUESTION");
            }
            $answer = $this->answerQuestionService->editQUestion($editForm);
            $editForm->setCreatedAt($this->formatDate($answer->created_at));
            if ($answer->updated_at != null)
                $editForm->setUpdatedAt($this->formatDate($answer->updated_at));
            Session::forget('SESSION_EDIT_QUESTION');
            DB::commit();
            return view('AdminMerchant.AnswerQuestion.question.edit-finish', compact('editForm'));
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }
    
    public function getQuestionAdd($hashcodeAnswer) {
        try {
            $answer = $this->answerQuestionService->getAnswerByHashcode($hashcodeAnswer);
            if ($answer == null) {
                throw new Exception(trans('exception.DATA_NOT_FOUND'));
            }

            $addForm = new AnswerQuestionForm();
            $addForm->setAnswer($answer->answer);
            $addForm->setType($answer->type);
            $addForm->setStatusAnswer($answer->status);
            $addForm->setHashcodeAnswer($answer->hashcode);

            return view('AdminMerchant.AnswerQuestion.question.add', compact('addForm'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }
    
    public function postQuestionAddConfirm(Request $data) {
        try {
            
            $request = $data->input();
            $addForm = new AnswerQuestionForm();
            $addForm->setAnswer($request['answer']);
            $addForm->setStatusAnswer($request['statusAnswer']);
            $addForm->setHashcodeAnswer($request['hashcodeAnswer']);
            $addForm->setType($request['type']);
            $addForm->setName($request['name']);
            $addForm->setStatus($request['status']);
            if (isset($request['result'])) {
                $addForm->setResult($request['result']);
            } else {
                $addForm->setResult(0);
            }
            /*
             * validate
             */
            $err = "";
            if ($addForm->getName() == null) {
                $err = "Câu trả lời là bắt buộc";
            }
            /*
             * end validate
             */
            if ($err != "") {
                return view('AdminMerchant.AnswerQuestion.question.add', compact('addForm', 'err'));
            } else {
                Session::put('SESSION_ADD_QUESTION', $addForm);
                return view('AdminMerchant.AnswerQuestion.question.add-confirm', compact('addForm'));
            }
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }
    
    public function postQuestionAddFinish() {
        DB::beginTransaction();
        try {
            $addForm = new AnswerQuestionForm();
            if (Session::has("SESSION_ADD_QUESTION")) {
                $addForm = Session::get("SESSION_ADD_QUESTION");
            }
            $answer = $this->answerQuestionService->getAnswerByHashcode($addForm->getHashcodeAnswer());
            $addForm->setAnswerId($answer->id);
            $question = $this->answerQuestionService->insertQuestion($addForm);
            $addForm->setCreatedAt($this->formatDate($question->created_at));
            if ($question->updated_at != null)
                $addForm->setUpdatedAt($this->formatDate($question->updated_at));
            Session::forget('SESSION_ADD_QUESTION');
            DB::commit();
            return view('AdminMerchant.AnswerQuestion.question.add-finish', compact('addForm'));
        } catch (Exception $ex) {
            DB::rollback();
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }
    
    public function postQuestionDelete(Request $data){
        DB::beginTransaction();
        try {
            $request = $data->input();
            $hashcode = $request['hashcode'];
            $this->answerQuestionService->deleteQuestion($hashcode);
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
    
    public function postAnswerDelete(Request $data){
        DB::beginTransaction();
        try {
            $request = $data->input();
            $hashcode = $request['hashcode'];
            $this->answerQuestionService->deleteAnswer($hashcode);
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
    
    /*
     * getUserQuestionList
     */
    public function getUserQuestionList() {
        try {
            $searchForm = new AnswerQuestionForm();
            if (Session::has('SESSION_SEARCH_USER_QUESTION')) {
                $searchForm = Session::get('SESSION_SEARCH_USER_QUESTION');
            }
            // set page
            $page = 1;
            if (isset($_GET['page'])) {
                $page = intval($_GET['page']);
                if ($page == 0)
                    $page = 1;
            }
            $searchForm->setPageSize(env('PAGE_SIZE'));
            $listObj = $this->answerQuestionService->searchListUserQuestion($searchForm);
            $countObj = $this->answerQuestionService->countListUserQuestion($searchForm);
            return view('AdminMerchant.AnswerQuestion.user-question.list', compact('listObj', 'countObj', 'searchForm', 'page'));
        } catch (Exception $ex) {
            $this->logs_custom("\nController ****\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }
    
    public function postUserQuestionList(Request $data) {
        try {
            $response = $data->input();
            $searchForm = new AnswerQuestionForm();
            $searchForm->setStatus($response['status']);
            $searchForm->setAnswer($response['answer']);
            Session::put('SESSION_SEARCH_USER_QUESTION', $searchForm);
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT') . "/answer-question/user/list");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

    public function getUserQuestionClearSearch() {
        try {
            Session::forget('SESSION_SEARCH_USER_QUESTION');
            return redirect("/" . env('PREFIX_ADMIN_MERCHANT') . "/answer-question/user/list");
        } catch (Exception $ex) {
            $this->logs_custom("\nMessage : " . $ex->getMessage() . "\nFile : " . $ex->getFile() . "\nLine : " . $ex->getLine());
            $error = $ex->getMessage();
            return view('errors.503', compact('error'));
        }
    }

}
