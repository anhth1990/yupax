@if (isset($errBlock) && $errBlock!="")
<div class="modal fade" id="modalAlertBlock" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông báo từ Yupax</h4>
            </div>
            <div class="modal-body"> {{$errBlock}} </div>
            <div class="modal-footer">
                @if (isset($linkBlock) && $linkBlock!="")
                <a href="{{$linkBlock}}">Click vào đây để chuyển trang</a>
                @else
                <a href="{{Asset('/'.env('PREFIX_ADMIN_MERCHANT'))}}">Click vào đây để chuyển trang</a>
                @endif
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endif