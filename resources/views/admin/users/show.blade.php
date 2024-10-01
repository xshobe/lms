@extends('layouts.admin.admin_template')

@section('content')

{!! Form::open(array('')) !!}
<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                           <!-- form start -->
              
                  <div class="box-body">
                    <div class="col-md-2 pull-right">
                    <a title="Manage Admin Users" href="{{url('/admin/users')}}"><i class="btn btn-block btn-info pull-right back_button">Manage Admin Users</i></a>
                </div>
                    <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('role', 'Role') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->Role->role_name}}
                      </div>                    
                    </div>
                  </div> 

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('name', 'Name') !!}
                       </div>
                      <div class="col-md-3">
                      {{$salutation_array[$model->salutation].' '.$model->first_name.' '.$model->last_name}}
                      </div>                    
                    </div>
                  </div>  
                  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('email', 'Email') !!}
                      </div>
                      <div class="col-md-3">
                      {{$model->email}}
                      </div>       
                    </div>              
                  </div>
                  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3"></div>
                         
                    </div>              
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('mobile', 'Mobile') !!}
                      </div>
                      <div class="col-md-3">
                      {{$model->mobile}}
                      </div>       
                    </div>              
                  </div>  
                @if($model->Address)  
                 @if($model->Address->address1!='')
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('address1', 'Address 1') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->Address->address1}}
                      </div>                    
                    </div>
                  </div>
                  @endif
                  @if($model->Address->address2!='')
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('address2', 'Address 2') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->Address->address2}}
                      </div>                    
                    </div>
                  </div> 
                  @endif
                  @if($model->Address->city!='')
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('city', 'City') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->Address->city}}
                      </div>                    
                    </div>
                  </div> 
                  @endif
                  @if($model->Address->state!='') 
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('state', 'State') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->Address->state}}
                      </div>                    
                    </div>
                  </div>  
                  @endif
                  @if($model->Address->country!='')
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('country', 'Country') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->Address->country}}
                      </div>                    
                    </div>
                  </div>  
                  @endif
                  @if($model->Address->zip_code!='')
                   <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('zip_code', 'Zip code') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->Address->zip_code}}
                      </div>                    
                    </div>
                  </div> 
                  @endif   
                   @endif                
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('status', 'Status') !!}
                       </div>
                      <div class="col-md-3">
                      {{$status[$model->status]}}
                      </div>                    
                    </div>
                  </div>                    

                 
              </div><!-- /.box -->              
           
          </div>   <!-- /.row -->
{!! Form::close() !!}
@endsection