<div class="modal-dialog modal-lg" id="formConfig">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Cấu hình</h4>
        </div>
        <form action="" class="horizontal-form" id="formLevelUser">
            <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
        <div class="modal-body" > 
            <!-- ** -->
            <div class="mt-element-step">
                <div class="row step-thin">
                    <div class="col-md-4 bg-grey mt-step-col active">
                        <div class="mt-step-number bg-white font-grey">1</div>
                        <div class="mt-step-title uppercase font-grey-cascade">Bước 1</div>
                        <div class="mt-step-content font-grey-cascade">Cấu hình thẻ </div>
                    </div>
                    <div class="col-md-4 bg-grey mt-step-col">
                        <div class="mt-step-number bg-white font-grey">2</div>
                        <div class="mt-step-title uppercase font-grey-cascade">Bước 2</div>
                        <div class="mt-step-content font-grey-cascade">Cấu hình chu kỳ</div>
                    </div>
                    <div class="col-md-4 bg-grey mt-step-col ">
                        <div class="mt-step-number bg-white font-grey">3</div>
                        <div class="mt-step-title uppercase font-grey-cascade">Bước 3</div>
                        <div class="mt-step-content font-grey-cascade">Cấu hình tỷ lệ quy đổi</div>
                    </div>
                </div>
            </div>
            <br>
            <!-- BEGIN FORM-->

                <div class="form-body">
                    @if(isset($listLevelUser) && count($listLevelUser)>0)
                    @foreach($listLevelUser as $key=>$obj)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    <label class="mt-checkbox mt-checkbox-outline">
                                        <input type="checkbox" id="level_{{$obj->id}}" class="level" value="{{$obj->id}}" name="level[]" onclick="showInputValueCoin(this);" > {{trans('type.level_user_'.$obj->code)}}
                                    <span></span>
                                </label>
                                </label>
                                <div class="col-md-5">
                                    <img alt="" class="" src="{{Asset('/public/'.$obj->images)}}">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control valueCoin" id="value_{{$obj->id}}" name="valueCoin[]"  placeholder="Số Y-Coin yêu cầu">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <br>
                    @endforeach
                    @endif
                </div>

            <!-- END FORM-->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn dark btn-outline">Để sau</button>
            <button type="button" class="btn green" id="submitForm" onclick="saveChangeLevelUser()" >Lưu thay đổi</button>
        </div>
        </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->