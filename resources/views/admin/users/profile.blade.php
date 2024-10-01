@extends('layouts.admin.admin_template')

@section('content')

<script src="{{ asset("js/jquery-validation/dist/jquery.validate.js")}}"></script>
<script>
  $(document).ready(function() {    
    // validate form on keyup and submit
    $("#userform").validate({
      rules: {       
        salutation: {
          required:true         
        }, 
        user_name: {
          required:true,
          alpha:true,
          minlength: 2,
          maxlength: 30 
        }, 
        first_name: {
          required:true,
          alpha:true,
          minlength: 2,
          maxlength: 30 
        },
        last_name: {
          required:true,
          alpha:true,          
          maxlength: 30 
        },
        email: {
          required:true,
          email:true
        }
        mobile: {
          required:true,
          number:true          
        }, 
        city: {          
          alpha:true,
          minlength: 2,
          maxlength: 40 
        },  
        state: {        
          alpha:true,
          minlength: 2,
          maxlength: 40 
        },
        country: {         
          alpha:true,
          minlength: 2,
          maxlength: 40 
        }, 
        zip_code: {          
          number:true
        }       
      },
      messages: {
        salutation: {
          required:"Please select salutation."   
        },  
        user_name:{ 
          required:"Please enter user name.",  
          alpha:"Please enter the user name in alphabets.", 
          minlength:"User name must consist of at least 2 characters.", 
          maxlength:"User name should not exceed 30 characters."      
        },       
        first_name:{ 
          required:"Please enter first name.",  
          alpha:"Please enter the first name in alphabets.", 
          minlength:"First name must consist of at least 2 characters.", 
          maxlength:"First name should not exceed 30 characters."      
        },
        last_name:{ 
          required:"Please enter last name.",  
          alpha:"Please enter the last name in alphabets.",          
          maxlength:"Last name should not exceed 30 characters."      
        },
        email: {
          required:"Please enter email address.",
          email:"Please enter a valid email address."
        },
        mobile: {
          required:"Please enter mobile number.",  
          number:"Please enter mobile number as numeric.",   
          
        },       
        city: {         
          alpha:"Please enter the city in alphabets.", 
          minlength:"City must consist of at least 2 characters.", 
          maxlength:"City should not exceed 40 characters."
        },  
        state: {          
          alpha:"Please enter the state in alphabets.", 
          minlength:"State must consist of at least 2 characters.", 
          maxlength:"State should not exceed 40 characters."
        },
        country: {         
          alpha:"Please enter the country in alphabets.", 
          minlength:"Country must consist of at least 2 characters.", 
          maxlength:"Country should not exceed 40 characters."
        }, 
        zip_code: {          
          number:"Please enter zip code as numeric.",   
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
   
  });
  </script>

@include('partials.list_errors')
 @include('partials.flash_success_msg')  
           
{!! Form::open(array('url' => array('admin/profile',$model->user_id),'id'=>'userform','name'=>'userform')) !!}
<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                           <!-- form start -->

              
                  <div class="box-body">
                    
                    <div class="col-md-2 pull-right">
                      <a href="{{URL::to('/admin/changePassword')}}" class="btn btn-block btn-info pull-right back_button">Change Password</a>
                    </div>  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('salutation', 'Salutation') !!}
                       </div>
                      <div class="col-md-3">
                      {!! Form::select('salutation',$salutation_array, $model->salutation, ['placeholder' => 'Select Salutation','class' => 'form-control'])!!}
                      </div>                    
                    </div>
                  </div>  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('first_name', 'First Name') !!}
                      </div>
                      <div class="col-md-3">
                      {!! Form::text('first_name',$model->first_name,['class'=>"form-control"]) !!}
                      </div>       
                    </div>              
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('last_name', 'Last Name') !!}
                      </div>
                      <div class="col-md-3">
                      {!! Form::text('last_name',$model->last_name,['class'=>"form-control"]) !!}
                      </div>       
                    </div>              
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('email', 'Email') !!}
                      </div>
                      <div class="col-md-3">
                      {!! Form::email('email',$model->email,['class'=>"form-control"]) !!}
                      </div>       
                    </div>              
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('user_name', 'User Name') !!}
                      </div>
                      <div class="col-md-3">
                      {!! Form::text('user_name',$model->user_name,['class'=>"form-control"]) !!}
                      </div>       
                    </div>              
                  </div>
                 
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('mobile', 'Mobile') !!}
                      </div>
                      <div class="col-md-3">
                      {!! Form::text('mobile',$model->mobile,['class'=>"form-control"]) !!}
                      </div>       
                    </div>              
                  </div>  
                 
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('address1', 'Address 1') !!}
                       </div>
                      <div class="col-md-3">
                      {!! Form::text('address1',(!empty($model->Address->address1)?$model->Address->address1:''),['class'=>"form-control"]) !!}
                      </div>                    
                    </div>
                  </div>                  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('address2', 'Address 2') !!}
                       </div>
                      <div class="col-md-3">
                      {!! Form::text('address2',(!empty($model->Address->address2)?$model->Address->address2:''),['class'=>"form-control"]) !!}
                      </div>                    
                    </div>
                  </div> 
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('city', 'City') !!}
                       </div>
                      <div class="col-md-3">
                      {!! Form::text('city',(!empty($model->Address->city)?$model->Address->city:''),['class'=>"form-control"]) !!}
                      </div>                    
                    </div>
                  </div>  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('state', 'State') !!}
                       </div>
                      <div class="col-md-3">
                      {!! Form::text('state',(!empty($model->Address->state)?$model->Address->state:''),['class'=>"form-control"]) !!}
                      </div>                    
                    </div>
                  </div>  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('country', 'Country') !!}
                       </div>
                      <div class="col-md-3">
                      {!! Form::text('country',(!empty($model->Address->country)?$model->Address->country:''),['class'=>"form-control"]) !!}
                      </div>                    
                    </div>
                  </div>  
                   <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('zip_code', 'Zip code') !!}
                       </div>
                      <div class="col-md-3">
                      {!! Form::text('zip_code',(!empty($model->Address->zip_code)?$model->Address->zip_code:''),['class'=>"form-control"]) !!}
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