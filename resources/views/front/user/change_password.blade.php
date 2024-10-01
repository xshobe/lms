@extends('layouts.front.front_template')

@section('content')
<section class="contentarea">
   <div class="row">
      @include('partials.flash_success_msg')
      @include('partials.list_errors')
      {!! Form::open(array('url'=>'change-password','id'=>'userspwdchangeform','autocomplete'=>'off')) !!}
      <div class="innerpad">
         <div class="user-password-container">
            <h3><span>Change Password</span></h3>
            <ul class="col4">
               <li>
                  {{ Form::label('current_password', 'Current Password') }}
                  <font>*</font>
                  {{ Form::password('current_password',['class'=>'validate[required]','id'=>'current_password']) }}
               </li>
               <li>
                  {{ Form::label('password', 'New Password') }}
                  <font>*</font>
                  {{ Form::password('password',['class'=>'validate[required,minSize[6]]','id'=>'password']) }}
               </li>
               <li>
                  {{ Form::label('password_confirmation', 'Confirm New Password') }}
                  <font>*</font>
                  {{ Form::password('password_confirmation',['class'=>'validate[required,minSize[6],equals[password]]','id'=>'password_confirmation']) }}
               </li>
            </ul>
         </div>
      </div><!-- /.innerpad -->
      <div class="btndiv">
         {{ Form::submit('Update') }}
      </div><!-- /.btndiv -->
      {!! Form::close() !!}
   </div><!-- /.row -->
</section><!-- /.contentarea -->
<link rel="stylesheet" type="text/css" href="{!! asset('public/css/validationEngine.jquery.css') !!}" />
<script type="text/javascript" charset="utf-8" src="{!! asset('public/js/jquery.validationEngine-en.js') !!}"></script>
<script type="text/javascript" charset="utf-8" src="{!! asset('public/js/jquery.validationEngine.js') !!}"></script>
<script>
$(document).ready(function(){
   $("#userspwdchangeform").validationEngine('attach', {
      promptPosition:"topLeft",
      showOneMessage:true,
      'custom_error_messages' : {
         '#current_password' : {
            'required' : {
               'message': "The current password field is required."
            }
         },
         '#password' : {
            'required' : {
               'message': "The new password field is required."
            },
            'minSize' : {
               'message': "The new password must be atleast 6 characters."
            }
         },
         '#password_confirmation' : {
            'required' : {
               'message': "The confirm new password field is required."
            },
            'minSize' : {
               'message': "The confirm new password must be atleast 6 characters."
            },
            'equals' : {
               'message': "The password(s) do not match."
            }
         }
      }
   });
});
</script>
@endsection