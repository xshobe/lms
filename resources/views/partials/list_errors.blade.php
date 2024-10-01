<?php
$errors = $errors->all();?>
@if ( ! empty($errors))
<div class="callout callout-danger">
@foreach ($errors as $err)
	<p>{!! $err !!}</p>
@endforeach
</div>
@endif
