@extends('layouts.admin.admin_template')

@section('content')
  @include('partials.list_errors')
<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                           <!-- form start -->
              
                  <div class="box-body">
                    <div class="col-md-2 pull-right">
                    <a title="Manage Salary Level" href="{{url('/admin/salarylevels')}}"><i class="btn btn-block btn-info pull-right back_button">Manage Salary Level</i></a>
                </div>
                     <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('salary_start', 'Salary Level') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->salary_from.' to '.$model->salary_to}}
                      </div>                    
                    </div>
                  </div>
                
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('eligibility', 'Eligibility') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->eligibility}}
                      </div>                    
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('interest', 'Interest') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->interest_amount}}
                      </div>                    
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('interest_amount', 'Interest amount') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->interest_amount}}
                      </div>                    
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      {!! Form::label('total_to_be_repaid', 'Total to be repaid') !!}
                       </div>
                      <div class="col-md-3">
                      {{$model->total_to_be_repaid}}
                      </div>                    
                    </div>
                  </div>
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