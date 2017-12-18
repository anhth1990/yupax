<div class="form-group answer">
    <label class="control-label col-md-3">
        <a href="javascript:;" class="btn btn-xs red bt-delete-answer" onclick="removeQuestion(this);">
                                                <i class="fa fa-close"></i>
                                            </a></label>
    <div class="col-md-6">
        <input type="text" name="question[]" class="form-control" placeholder="Câu trả lời">
        <input type="hidden" name="result[]" class="form-control result" value="0">
    </div>
    <label class="control-label col-md-2"> 
        <input type="checkbox" value="1" name="res" onclick="checkResult(this);" />
        <span></span>
    </label>
   
</div>