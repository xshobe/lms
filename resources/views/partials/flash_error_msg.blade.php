@if(Session::has('error_flash_message'))
<div class="callout callout-danger">
<h4>{{ Session::get('error_flash_message') }} </h4>
</div>
@endif  