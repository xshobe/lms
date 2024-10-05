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
            <p class="login-box-msg">Sign in to start your session</p>
            @include('partials.list_errors')
            @include('partials.flash_error_msg')
            @csrf
            {!! Form::open(['url' => '/admin/postLogin', 'id' => 'userloginform', 'name' => 'userloginform']) !!}
            <div class="form-group has-feedback">
                <label for=""></label>
                <input type="text" name="user_name" class="form-control" placeholder="User Name">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <label for=""></label>
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <!--<div class="form-group has-feedback">
                                                {!! app('captcha')->display() !!}
                                              </div>-->
            <div class="row">
                <div class="col-xs-4 pull-right">
                    <button type="submit" class="mt-1 btn btn-primary btn-block btn-flat">Sign In</button>
                </div><!-- /.col -->
            </div>
            {!! Form::close() !!}

            <a href="{{ URL::to('admin/forgot-password') }}">I forgot my password</a><br>



        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
@endsection
