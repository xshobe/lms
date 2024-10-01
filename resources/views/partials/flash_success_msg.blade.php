@if(Session::has('flash_message'))
<div class="alert alert-success alert-dismissable">
<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
<h4>  <i class="icon fa fa-check"></i> Alert!</h4>
{{ Session::get('flash_message') }}
</div>
@endif  