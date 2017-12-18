@if (isset($error))
<div class="alert alert-danger display-show">
    <button class="close" data-close="alert"></button>
    <span>{{$error}}</span>
</div>
@endif