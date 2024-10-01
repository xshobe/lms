@extends('layouts.admin.admin_template')

@section('content')

<script src="{{ asset("js/jquery-validation/dist/jquery.validate.js")}}"></script>
<script>
  $(document).ready(function() {    
    // validate form on keyup and submit
    $("#userform").validate({
      rules: {       
        
        current_password: {
          required:true
        },
        password: {
        required:true,
          minlength: 6
          
        },
        password_confirmation: {
         required: true,            
            equalTo: "#password"
        }        
      },
      messages: {
         
        current_password: {
          required:"Please enter current password.",
        },
        password: {
          required:"Please enter password.",
          minlength:"Password name must consist of at least 6 characters.", 
          
        },    
        password_confirmation: {
            required:"Please enter confirm password.",            
            equalTo:"Please enter confirm password same as password.",
        },      
        debug:true
      },
      errorPlacement: function(error, element)
      {     
        error.fadeIn(600).appendTo(element.parent());       
      },
      submitHandler: function()
      {
       document.userform.submit();      
      },
      errorClass: "error_msg",    
      errorElement: "div"
    }); 
    $('#show_password').click(function() {
     
       if($(this).is(':checked')==true){
         $('#password').attr('type','text');
       }else{
         $('#password').attr('type','password');
       }
    });   
  });
function passwordStrength(password)
{
  var desc = new Array();
  desc[0] = "Very Weak";
  desc[1] = "Weak";
  desc[2] = "Better";
  desc[3] = "Medium";
  desc[4] = "Strong";
  desc[5] = "Strongest";

  var score   = 0;

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
@include('partials.flash_success_msg') 
@include('partials.list_errors')
{!! Form::open(array('url' => array('admin/changePassword',$model->user_id),'id'=>'userform','name'=>'userform')) !!}
<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                           <!-- form start -->
              
                  <div class="box-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('current_password','Current Password') !!}
                      </div>
                      <div class="col-md-3">
                      {!! Form::password('current_password',['class'=>"form-control"]) !!}
                      </div>                       
                    </div>              
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('password','Password') !!}
                      </div>
                      <div class="col-md-3">
                      {!! Form::password('password',['class'=>"form-control",'onkeyup'=>"passwordStrength(this.value)",'title'=>"Please enter secure password eg:Unlock123$"]) !!}
                      <input type="checkbox" id="show_password"> show password
                      </div> 
                      <div class="col-md-3">
                      <label for="passwordStrength">Password strength</label>
                        <div id="passwordDescription">Password not entered</div>
                        <div id="passwordStrength" class="strength0"></div>
                      </div> 

                    </div>              
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('confirm_password','Confirm Password') !!}
                      </div>
                      <div class="col-md-3">
                      {!! Form::password('password_confirmation',['class'=>"form-control"]) !!}
                      </div>       
                    </div>              
                  </div>              

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                  </div>
             
              </div><!-- /.box -->              
           
          </div>   <!-- /.row -->
{!! Form::close() !!}
@endsection