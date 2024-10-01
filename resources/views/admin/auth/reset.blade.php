@extends('layouts.admin.login')
@section('content')
<div class="login-box">
      <div class="login-logo">
        <a href="javascript:void(0);">
        	<b style="font-size:40px;">{{ \Config::get('constants.app_slug_name') }}</b><br />
        	<b style="font-size:30px;">{{ \Config::get('constants.company_name') }}</b>
        </a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
      	@if(session()->has('error'))
					@include('partials/error', ['type' => 'danger', 'message' => session('error')])
				@endif
      	  @include('partials.list_errors') 
				{!! Form::open(['url' => 'admin/reset-password', 'method' => 'post','id'=>"resetform",'name'=>"resetform"]) !!}	

					<div class="form-group has-feedback">	

						{!! Form::email('email','',['class'=>"form-control",'placeholder'=>"Email"]) !!}
						 <span class="glyphicon glyphicon-envelope form-control-feedback"></span>						
					</div>
					 <div class="form-group has-feedback">
			          	{!! Form::password('password',['class'=>"form-control",'placeholder'=>"Password",'onkeyup'=>"passwordStrength(this.value)",'id'=>"password"]) !!}
			            {!! Form::hidden('token',$token) !!}
			            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
			         </div>
			         <div class="form-group has-feedback">	
			         {!! Form::password('password_confirmation',['class'=>"form-control",'placeholder'=>"Confirm Password",'id'=>"password_confirmation"]) !!}
			         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
			          </div>
			          <div class="form-group has-feedback">
			           <label for="passwordStrength">Password strength</label>
                        <div id="passwordDescription">Password not entered</div>
                        <div id="passwordStrength" class="strength0"></div>
                      </div> 
			           <div class="row">        
            			<div class="col-xs-5 pull-right">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
						</div>
						</div>
				{!! Form::close() !!}

			</div>
		</div>
	</div>
@stop