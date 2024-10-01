@extends('layouts.admin.admin_template')

@section('content')
@include('partials.confirm_approve_modal')   
<script src="{{ asset("js/jquery-validation/dist/jquery.validate.js")}}"></script>
<script>
  $(document).ready(function() {    
    // validate form on keyup and submit
    if($('#payment_method').val()==2){
      $('#cheque_field').show();
    }
    $("#pay_loan_status").validate({
      ignore: [],
      rules: {
        payment_method: {
          required:true
        
        }, 
        cheque_number: {
          check_payment_method:'#payment_method',
          alpha_numeric:true
        
        }          
      },
      messages: {
        payment_method: {
          required:"Please select loan payment method.",
          
        },
        cheque_number: {
          check_payment_method:"Please enter cheque number.", 
          alpha_numeric:"Please enter cheque number in alpha numeric."
        },       
        debug:true
      },
      errorPlacement: function(error, element)
      {     
        error.fadeIn(600).appendTo(element.parent());       
      },
      submitHandler: function()
      {
        
       $('#confirm-approve').modal('show').on('show.bs.modal', function(e) {
          
             var form = $(e.relatedTarget).closest('form');
            $(this).find('.modal-footer #confirm').data('form', form);
        });

         $('#confirm-approve .content_msg').html('You are about to do payment for member {{ getCustomerName($loanMasterObj->Customer) }}.');
           $('#confirm-approve .modal-title').html('<i class="icon fa fa-warning text-yellow"></i> Attention');                 
       
      },
      errorClass: "error_msg",    
      errorElement: "div"
    });

$('#confirm-approve').find('.modal-footer #confirm').on('click', function(){
            document.pay_loan_status.submit();
    });

$.validator.addMethod("check_payment_method", function(value, element, param) {
        var option = $(""+param+" option:selected").text().toLowerCase();

        var myval = value;
        switch(option){
            case 'paid cheque':            
             return (myval!== '');
            break;           
            default:
            return true;
            break;
        }
    },"Please enter cheque number.");



   $('#payment_method').click(function(){
      var payment_method_val=$(this).val();
      if(payment_method_val!='' && payment_method_val=='2'){
        $('#cheque_field').show();
      }else{
        $('#cheque_field').hide();
      }
   });

  });

  </script>

<?php $currency=trim($currency_symbol);?>

@include('partials.list_errors')
{!! Form::open(array('route' => array('admin.accounts.payNow'),'id'=>'pay_loan_status','name'=>'pay_loan_status')) !!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Member Details</h3>
    </div>
    <div class="box-body heightfixdiv">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('member', 'Member') !!}
                        </div>
                        <div class="col-md-7">
                        {{ getCustomerName($loanMasterObj->Customer) }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('member_type', 'Member Category') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $loanMasterObj->Customer->customer_types[$loanMasterObj->Customer->customer_category_id] or '&ndash;' }}
                        </div>
                    </div>
                </div> 
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('tpf_number', 'TPF No') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->tpf_number != '') ? $loanMasterObj->Customer->tpf_number : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('job_title', 'Job Title') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->job_title != '') ? $loanMasterObj->Customer->job_title : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('ministry', 'Ministry') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->ministry != '') ? $loanMasterObj->Customer->ministry : '&ndash;' }}
                        </div>
                    </div>
                </div>

                @if($loanMasterObj->Customer->customer_category_id == '3')
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('school', 'School') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->school != '') ? $loanMasterObj->Customer->school : '&ndash;' }}
                        </div>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('salary_level', 'Salary Level') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $loanMasterObj->Customer->SalaryLevel[$loanMasterObj->Customer->salary_level] or '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('email', 'Email') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->email != '') ? $loanMasterObj->Customer->email : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('gender', 'Gender') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $gender_array[$loanMasterObj->Customer->gender] or '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('dob', 'DOB') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->dob != '') ? getFormattedDate($loanMasterObj->Customer->dob) : '&ndash;' }}
                        </div>
                    </div>
                </div>
            </div><!-- /.col -->
            <div class="col-md-4">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('mobile', 'Mobile') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->mobile != '') ? $loanMasterObj->Customer->mobile : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('address', 'Address') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->contact != '') ? $loanMasterObj->Customer->contact : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('register_date', 'Register Date') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->register_date != '') ? getFormattedDate($loanMasterObj->Customer->register_date) : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('width_date', 'Withdrawal Date') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->width_date != '') ? getFormattedDate($loanMasterObj->Customer->width_date) : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('retirement_date', 'Date of Retirement') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->retirement_date != '') ? getFormattedDate($loanMasterObj->Customer->retirement_date) : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('bank_type', 'Bank Name') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $loanMasterObj->Customer->banks[$loanMasterObj->Customer->bank_id] or '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('account_no', 'Account No') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($loanMasterObj->Customer->account_no != '') ? $loanMasterObj->Customer->account_no : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('status', 'Status') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $status[$loanMasterObj->Customer->status] or '&ndash;' }}
                        </div>
                    </div>
                </div>
            </div><!-- /.col -->
            <div class="col-md-2">
                <img width="100%" src="{!! getProfileImageUrl($loanMasterObj->Customer) !!}" />
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.box-body -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12"><hr /></div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_scheme', 'Loan Scheme') !!}
                        </div>
                        <div class="col-md-6">
                        {{$loan_scheme[$loanMasterObj->scheme_id] or '&ndash;'}}
                        </div>
                    </div>
                </div>
        
                @if ($loanMasterObj->scheme_id == 1)
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_category', 'Loan Category') !!}
                        </div>
                        <div class="col-md-6">
                        {{$loanMasterObj->loan_types[$loanMasterObj->loan_cat_id] or '&ndash;'}}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_size', 'Loan Classification') !!}
                        </div>
                        <div class="col-md-6">
                        {{$loanMasterObj->classification_name[$loanMasterObj->classification_id] or ''}}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_size', 'Loan Classifications Amount') !!}
                        </div>
                        <div class="col-md-6">
                        {{$loanMasterObj->loan_classification[$loanMasterObj->classification_range_id] or ''}}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_size', 'Loan Repayment Period') !!}
                        </div>
                        <div class="col-md-6">
                        {{$loanMasterObj->loan_cl_period[$loanMasterObj->classification_range_id] or ''}}
                        </div>
                    </div>
                </div>
                @endif
        
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('amount_requested', "Loan Requested($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {{ $loanMasterObj->amount_requested }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('amount_approved', "Loan Granted($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {{ $loanMasterObj->LoanAccount->amount_approved }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                
                @if ($loanMasterObj->scheme_id == 2)
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('interest_amount', "Interest($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {{ $loanMasterObj->LoanAccount->initial_interest }}
                        </div>
                    </div>
                </div>
                @endif
                
                {{-- <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_fee', "Loan Fee($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! $loanMasterObj->LoanAccount->loan_fee .' (deducted from member savings)' !!}
                        </div>
                    </div>
                </div> --}}
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('total_loan_amount', "Total Repayment Amount($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {{ $loanMasterObj->LoanAccount->total_loan_amount }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('payment_method', 'Payment Method') !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::select('payment_method',$payment_method,'', ['placeholder' => 'Select Payment Method','class' => 'form-control'])!!}
                        </div>
                    </div>
                </div>
                <div class="form-group" id="cheque_field" style="display:none;">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('cheque', 'Cheque Number') !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('cheque_number','',['class'=>"form-control",'id'=>"cheque_number"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.box-body -->
</div><!-- /.box -->
{!! Form::hidden('loan_id', base64_encode($loanMasterObj->id)) !!}
{!! Form::hidden('customer_id', base64_encode($loanMasterObj->customer_id)) !!}
{!! Form::close() !!}
@endsection