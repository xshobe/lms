@extends('layouts.front.front_template')

@section('content')
<section class="innerbanner">
	<div class="row">
		<h1>{!! $page_title or '' !!}</h1>
		<p>tempor incididunt ut labore et dolore magna aliqua</p>
	</div>
</section><!-- /.innerbanner -->
<section class="contentarea">
	<div class="row">
		@if(session()->has('status'))
			@include('partials/error', ['type' => 'success', 'message' => session('status')])
		@endif
		@if(session()->has('error'))
			@include('partials/error', ['type' => 'danger', 'message' => session('error')])
		@endif	
		@include('partials.list_errors')          
		{!! Form::open(array('url'=>'forgot-password','id'=>'forgotpasswordform','autocomplete'=>'off')) !!}
		<div class="innerpad">
			<div class="user-credentials-container">
				<h3><span>Reset Password</span></h3>
				<ul class="col4">
					<li>
						{{ Form::label('email', 'Email') }}
						<font>*</font>
						{!! Form::text('email','',['class'=>'validate[required,custom[email]]','id'=>'email','placeholder'=>'Email']) !!}
					</li>
					<li>
						{!! app('captcha')->display(); !!}
					</li>
				</ul>
				<div><p>Note: Submit your email to reset password</p></div>
			</div>
		</div><!-- /.innerpad -->
		<div class="btndiv">
			{{ Form::submit('Submit') }}
			<p><a href="{!! url('login') !!}">Back to login</a></p>
		</div><!-- /.btndiv -->
		{!! Form::close() !!}
	</div><!-- /.row -->
</section><!-- /.contentarea -->
<link rel="stylesheet" type="text/css" href="{!! asset('public/css/validationEngine.jquery.css') !!}" />
<script type="text/javascript" charset="utf-8" src="{!! asset('public/js/jquery.validationEngine-en.js') !!}"></script>
<script type="text/javascript" charset="utf-8" src="{!! asset('public/js/jquery.validationEngine.js') !!}"></script>
<script>
$(document).ready(function(){
	$("#forgotpasswordform").validationEngine('attach', {
		promptPosition:"topLeft",
		showOneMessage:true,
		'custom_error_messages' : {
			'#email' : {
				'required' : {
					'message': "The email field is required."
				}
			}
		}
	});
});
</script>
@endsection
