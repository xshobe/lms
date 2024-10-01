@extends('layouts.admin.login')

@section('content')
<style type="text/css">
.alert-success{
  font-size:13px;
}
</style>
<div class="login-box">
      <div class="login-logo">
        <a href="javascript:void(0);">
            <b style="font-size:40px;">{{ \Config::get('constants.app_slug_name') }}</b><br />
            <b style="font-size:30px;">{{ \Config::get('constants.company_name') }}</b>
        </a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Enter email to reset your password</p>
        @if(session()->has('status'))
      				@include('partials/error', ['type' => 'success', 'message' => session('status')])
				@endif
				@if(session()->has('error'))
					@include('partials/error', ['type' => 'danger', 'message' => session('error')])
				@endif	
        @include('partials.list_errors')          
{!! Form::open(array('url' => 'admin/forgot-password','id'=>'forgotpasswordform','name'=>'forgotpasswordform')) !!}
          <div class="form-group has-feedback">
          	{!! Form::email('email','',['class'=>"form-control",'placeholder'=>"Email"]) !!}          	
            
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
         <!--<div class="form-group has-feedback">{!! app('captcha')->display(); !!}</div>-->
          <div class="row">        
            <div class="col-xs-4 pull-right">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
            </div><!-- /.col -->
          </div>
       {!! Form::close() !!}
       <a href="{{URL::to('admin/login')}}">Back to login</a><br>

        <br>
        

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->   

@endsection

