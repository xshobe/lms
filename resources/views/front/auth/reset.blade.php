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
		{!! Form::open(array('url'=>'reset-password','id'=>'resetform','autocomplete'=>'off')) !!}
		<div class="innerpad">
			<div class="user-credentials-container">
				<h3><span>Reset Password Details</span></h3>
				<ul class="col4">
					<li>
						{{ Form::label('email', 'Email') }}
						<font>*</font>
						{!! Form::email('email','',['class'=>'validate[required,custom[email]]','placeholder'=>'Email']) !!}
					</li>
					<li>
						{{ Form::label('password', 'Password') }}
						<font>*</font>
						{!! Form::password('password',['class'=>"validate[required]",'placeholder'=>"Password",'onkeyup'=>"passwordStrength(this.value)",'id'=>"password"]) !!}
			            {!! Form::hidden('token',$token) !!}
			             <label for="passwordStrength">Password strength</label>
                        <div id="passwordDescription">Password not entered</div>
                        <div id="passwordStrength" class="strength0"></div>
					</li>
					<li>
						{{ Form::label('password_confirmation', 'Confirm Password') }}
						<font>*</font>
						{!! Form::password('password_confirmation',['class'=>"validate[required,equals[password]]",'placeholder'=>"Confirm Password",'id'=>"password_confirmation"]) !!}

					</li>
				</ul>
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
	$("#resetform").validationEngine('attach', {promptPosition : "topLeft"});
});
function passwordStrength(password){
    var desc = new Array();
    desc[0] = "Very Weak";
    desc[1] = "Weak";
    desc[2] = "Better";
    desc[3] = "Medium";
    desc[4] = "Strong";
    desc[5] = "Strongest";

    var score = 0;

    //if password bigger than 6 give 1 point
    if (password.length > 6) score++;

    //if password has both lower and uppercase characters give 1 point  
    if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;

    //if password has at least one number give 1 point
    if (password.match(/\d+/)) score++;

    //if password has at least one special caracther give 1 point
    if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;

    //if password bigger than 12 give another 1 point
    if (password.length > 12) score++;

    document.getElementById("passwordDescription").innerHTML = desc[score];
    document.getElementById("passwordStrength").className = "strength" + score;
}
</script>
@endsection