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
		@include('partials.list_errors')
		@include('partials.flash_error_msg')
		{!! Form::open(array('url'=>'do-login','id'=>'usersloginform','autocomplete'=>'off')) !!}
		<div class="innerpad">
			<div class="user-credentials-container">
				<h3><span>Login Details</span></h3>
				<ul class="col4">
					<li>
						{{ Form::label('user_name', 'Username') }}
						<font>*</font>
						{{ Form::text('user_name','',['class'=>'validate[required]','id'=>'user_name']) }}
					</li>
					<li>
						{{ Form::label('password', 'Password') }}
						<font>*</font>
						{{ Form::password('password',['class'=>'validate[required]','id'=>'password']) }}
					</li>
					<li>
						{!! app('captcha')->display(); !!}
					</li>					
				</ul>
			</div>
		</div><!-- /.innerpad -->
		<div class="btndiv">
			{{ Form::submit('Login') }}
			<p><a href="{!! url('forgot-password') !!}">Reset your password?</a></p>
		</div><!-- /.btndiv -->
		{!! Form::close() !!}
	</div><!-- /.row -->
</section><!-- /.contentarea -->
<link rel="stylesheet" type="text/css" href="{!! asset('public/css/validationEngine.jquery.css') !!}" />
<script type="text/javascript" charset="utf-8" src="{!! asset('public/js/jquery.validationEngine-en.js') !!}"></script>
<script type="text/javascript" charset="utf-8" src="{!! asset('public/js/jquery.validationEngine.js') !!}"></script>
<script>
$(document).ready(function(){
	$("#usersloginform").validationEngine('attach', {
		promptPosition:"topLeft",
		showOneMessage:true,
		'custom_error_messages' : {
			'#user_name' : {
				'required' : {
					'message': "The username field is required."
				}
			},
			'#password' : {
				'required' : {
					'message': "The password field is required."
				}
			}
		}
	});
});
</script>
@endsection