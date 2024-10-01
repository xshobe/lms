@extends('layouts.admin.admin_template')

@section('content')
<?php //pr($model->Loan);?>
  
<div class="row">

    <!-- left column -->
    <div class="col-md-12">

        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-body">
                
                <a title="Back"  href="{{url('/admin/accounts/DepositedLoans')}}"><i class="btn btn-block btn-info pull-right back_button"></i></a>
            
                   <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('loan_id', 'Loan id') !!}
                        </div>
                        <div class="col-md-3">
                        {{$model->loan_id}}
                        </div>       
                    </div>              
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('loan_amount', 'Loan amount') !!}
                        </div>
                        <div class="col-md-3">
                        {{ $currency_symbol . $model->loan_amount }}
                        </div>       
                    </div>              
                </div> 


                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('requested_amount', 'Requested amount') !!}
                        </div>
                        <div class="col-md-3">
                        {{ $currency_symbol . numberFormat($model->Loan->loan_amount) }}
                        </div>       
                    </div>              
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('payment_method', 'Payment method') !!}
                        </div>
                        <div class="col-md-3">
                        {{$payment_method[$payment_type]}}
                        </div>       
                    </div>              
                </div> 
                @if($model->cheque_no!="")
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('cheque', 'Cheque Number') !!}
                        </div>
                        <div class="col-md-3">
                        {{$model->cheque_no}}
                        </div>       
                    </div>              
                </div> 
                @endif

                @if($model->Loan)
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('Customer', 'Customer') !!}
                        </div>
                        <div class="col-md-3">
                        {{$model->Loan->Customer->first_name.' '.$model->Loan->Customer->last_name}}
                        </div>       
                    </div>              
                </div>

                 <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('Tpf', 'Tpf Number') !!}
                        </div>
                        <div class="col-md-3">
                        {{$model->Loan->Customer->tpf_number}}
                        </div>       
                    </div>              
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('status', 'Status') !!}
                        </div>
                        <div class="col-md-3">
                        {{$loan_status[$model->status]}}
                        </div>       
                    </div>              
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('created_by', 'Created by') !!}
                        </div>
                        <div class="col-md-3">
                        {{$model->CreatedBy->first_name.' '.$model->CreatedBy->last_name}}
                        </div>       
                    </div>              
                </div>

                @endif

                 <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('created_at', 'Created at') !!}
                        </div>
                        <div class="col-md-3">
                        {{date('d-m-Y',strtotime($model->created_at))}}
                        </div>       
                    </div>              
                </div>

               
            </div><!-- /.box-body -->
         
        </div><!-- /.box -->
    </div><!-- /.col-md-12 -->
</div><!-- /.row -->

@endsection