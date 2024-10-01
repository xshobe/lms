@extends('layouts.admin.admin_template')

@section('content')
@include('partials.confirm_approve_modal')   
<script src="{!! asset('js/jquery-validation/dist/jquery.validate.js') !!}"></script>
<script>
  $(document).ready(function() {    
    // validate form on keyup and submit
    $("#customer_loan_status").validate({
      ignore: [],
      rules: { 
        status: {
          required:true
        },
         comments: {
          check_comments:'#status',
        },
        loan_amount: {
            required:true,
            number:true,
            max:{{ intval($loanMasterObj->amount_requested) }}
        }
      },
      messages: {     
      
        status: {
          required:"Please select status."            
        }    
        ,
        comments: {
          check_comments:'Please enter comments.',                 
        },
        loan_amount: {
            required:"Please enter loan amount.",
            number:"Loan amount must be a number.",
            max:"Loan amount should not exceed {{ intval($loanMasterObj->amount_requested) }}"
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

        $('#confirm-approve .content_msg').html('You are about to approve the Credit Loan for member {{ getCustomerName($loanMasterObj->Customer) }}.');
        $('#confirm-approve .modal-title').html('<i class="icon fa fa-warning text-yellow"></i> Attention');                 
       
      },
      errorClass: "error_msg",    
      errorElement: "div"
    });

    $('#confirm-approve').find('.modal-footer #confirm').on('click', function(){
        document.customer_loan_status.submit();
    });   

    $("#status").change(function(){
        var current_val=$(this).val();
       
        if(current_val==2){
            $("#comments_field").show();
        }else{
            $("#comments_field").hide();
        }
    });

        $.validator.addMethod("check_comments", function(value, element, param) {
            var option = $(""+param+" option:selected").val();
            var myval = value;        
            switch(option){
                case '2':            
                 return (myval!=='');
                break;           
                default:
                return true;
                break;
            }
        },"Please enter comments.");
    

  });

  </script>

<?php $currency=trim($currency_symbol);?>

@include('partials.list_errors')
{!! Form::open(array('route' => array('admin.committee.approval',md5($loanMasterObj->id)),'id'=>'customer_loan_status','name'=>'customer_loan_status')) !!}
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
                        {{ $customerObj->customer_types[$loanMasterObj->Customer->customer_category_id] or '&ndash;' }}
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
                        {{ $customerObj->SalaryLevel[$loanMasterObj->Customer->salary_level] or '&ndash;' }}
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
                        {{ $customerObj->banks[$loanMasterObj->Customer->bank_id] or '&ndash;' }}
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
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('amount_requested', "Loan Requested Amount($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {{ $loanMasterObj->amount_requested }}
                        </div>
                    </div>
                </div>
                {{-- <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_fee', "Loan Fee($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! $loan_fee .' (deducted from member savings)' !!}
                        </div>
                    </div>
                </div> --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_amount', 'Enter Amount') !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('loan_amount','',['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('status', 'Status') !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::select('status',$loan_status,$loanMasterObj->status, ['placeholder' => 'Select Status','class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group" id="comments_field" style="display:none;">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('comments', 'Comments') !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::textarea('comments',null,['class'=>"form-control", 'rows'=>'3', 'style'=>'resize:none;']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="text-align:center;">{!! Form::submit('Approve Loan Now', ['class'=>'btn btn-primary']) !!}</div>
        </div><!-- /.row -->
    </div><!-- /.box-body -->
</div><!-- /.box -->
{!! Form::hidden('max_amt', intval($loanMasterObj->amount_requested)) !!}
{!! Form::close() !!}
@endsection