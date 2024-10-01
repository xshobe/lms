@extends('layouts.admin.admin_template')

@section('content')
@include('partials.confirm_approve_modal')
@include('partials.list_errors')

<?php
$maxAdvanceAllowed=$customerObj->Salary_Level->eligibility - $unPaidAdvanceAmt;
$interest=($scheme_id==2) ? $customerObj->Salary_Level->interest : 0;
$currency=trim($currency_symbol);
?>

{!! Form::open(array('route'=>array('admin.loan_section.saveLoanDetails'),'name'=>'Loanform','id'=>'Loanform','autocomplete'=>'off')) !!}
<!-- customer detail starts here -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Member Details</h3>
        <div class="box-tools pull-right">
            <a href="{!! url('admin/members/statement/'. md5($customerObj->id)) !!}" title="Print Member Statement"><i class="fa fa-print"></i> Print Member Statement</a>
        </div>
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
                        {{ getCustomerName($customerObj) }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('customer_type', 'Member Category') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $customerObj->customer_types[$customerObj->customer_category_id] or '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('tpf_number', 'TPF No') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->tpf_number != '') ? $customerObj->tpf_number : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('job_title', 'Job Title') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->job_title != '') ? $customerObj->job_title : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('ministry', 'Ministry') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->ministry != '') ? $customerObj->ministry : '&ndash;' }}
                        </div>
                    </div>
                </div>

                @if($customerObj->customer_category_id == '3')
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('school', 'School') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->school != '') ? $customerObj->school : '&ndash;' }}
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
                        {{ $customerObj->SalaryLevel[$customerObj->salary_level] or '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('email', 'Email') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->email != '') ? $customerObj->email : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('gender', 'Gender') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $gender_array[$customerObj->gender] or '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('dob', 'DOB') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->dob != '') ? getFormattedDate($customerObj->dob) : '&ndash;' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('mobile', 'Mobile') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->mobile != '') ? $customerObj->mobile : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('address', 'Address') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->contact != '') ? $customerObj->contact : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('register_date', 'Register Date') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->register_date != '') ? getFormattedDate($customerObj->register_date) : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('width_date', 'Withdrawal Date') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->width_date != '') ? getFormattedDate($customerObj->width_date) : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('retirement_date', 'Date of Retirement') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->retirement_date != '') ? getFormattedDate($customerObj->retirement_date) : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('bank_type', 'Bank Name') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $customerObj->banks[$customerObj->bank_id] or '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('account_no', 'Account No') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->account_no != '') ? $customerObj->account_no : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('status', 'Status') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $status[$customerObj->status] or '&ndash;' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <img width="100%" src="{!! getProfileImageUrl($customerObj) !!}" />
            </div>
        </div><!-- /.row -->
    </div><!-- /.box-body -->
</div>
<!-- customer detail ends here -->

<!-- saving detail starts here -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Savings Details</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
            <b>Savings A/C No :</b>
            {{ ($customerObj->account_no != '') ? $customerObj->account_no : '&ndash;' }}
            </div>

            <div class="col-md-4">
            <b>Savings Amount :</b>
            {!! $currency_symbol . $savings_amt !!}
            </div>

            <div class="col-md-4">
            <b>Date :</b>
            {!! date('d/m/Y') !!}
            </div>
        </div>
    </div>
</div>
<!-- saving detail ends here -->

<!-- loan and repayment detail starts here -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Loan and Payment Details</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4 ">
            <b>Loan Recevied :</b>
            <b style="color:green;">{!! $currency_symbol . $generalLoanInfo['creditLoan']['amt_approved'] !!}</b>
            </div>

            <div class="col-md-4 ">
            <b>Advance Borrowed :</b>
            <b style="color:green;">{!! $currency_symbol . $generalLoanInfo['advanceLoan']['amt_approved'] !!}</b>
            </div>

            {{-- <div class="col-md-4">
            <b>Loan Fee :</b>
            {!! $currency_symbol . $generalLoanInfo['allLoanInfo']['tot_fee'] !!}
            </div> --}}

            <div class="col-md-4">
            <b>Interest :</b>
            {!! $currency_symbol . $generalLoanInfo['allLoanInfo']['tot_interest'] !!}
            </div>

            <div class="col-md-4">
            <b>Loan Offset :</b>
            --
            </div>

            <div class="col-md-4">
            <b>Loan Adjustment :</b>
            --
            </div>

            <div class="col-md-4">
            <b>Repayment :</b>
            {!! $currency_symbol . $generalLoanInfo['allLoanInfo']['amt_paid'] !!}
            </div>

            <div class="col-md-6">
            <b>Total Outstanding:</b>
            <b style="color:red;">{!! $currency_symbol . $generalLoanInfo['allLoanInfo']['amt_to_pay'] !!}</b>
            </div>

            <div class="col-md-12"><hr /></div>
            <div class="col-md-6">
        
                @if($scheme_id == 1)
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_classification', 'Loan Classification') !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::select('loan_classification', $loanMasterObj->classification_name, null, ['placeholder' => 'Select Loan Classification','class' => 'form-control','id'=>'loan_classification'])!!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_classification_amount', 'Loan Classification Amount') !!}
                        </div>
                        <div class="col-md-6">
                            <select id="loan_classification_amount" name="loan_classification_amount" class="form-control">
                                <option value="">Select Loan Classification Amount</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_repayment_period', 'Loan Repayment within') !!}
                        </div>
                        <div class="col-md-6">
                        <b style="color:green;"><p id="ln_cl_yr">--</p></b>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_category', 'Loan Category') !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::select('loan_category',$loanMasterObj->loan_types, null, ['placeholder' => 'Select Loan Category','class' => 'form-control'])!!}
                        </div>
                    </div>
                </div> 
                
                @elseif($scheme_id == 2)
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('salary_level', 'Salary level') !!}
                        </div>
                        <div class="col-md-6">
                        {{$customerObj->Salary_Level->salary_from.'-'.$customerObj->Salary_Level->salary_to}}
                        </div>
                    </div>
                </div> 
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('Eligible', 'Eligible Amount') !!}
                        </div>
                        <div class="col-md-6">
                        {{ $customerObj->Salary_Level->eligibility }}
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
                        {!! $loan_fee .' (deducted from member savings)' !!}
                        </div>
                    </div>
                </div> --}}

                @if($scheme_id == 2)
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('interest', 'Interest(%)') !!}
                        </div>
                        <div class="col-md-6">
                        <span>{!! $interest !!}</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-md-6">
                
                @if($scheme_id == 1)
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('max_loan_amount', "Max Loan Amount($currency)") !!}
                        </div>
                        <div class="col-md-6">{!! $maxAllowedAmt !!}</div>
                    </div>
                </div>
                @endif
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_amount', "Enter Loan Amount($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('loan_amount','',['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('tot_loan_amount', "Total Loan Amount($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        <span id="tot_loan_amount"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('reason', 'Reason') !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::textarea('reason','',['class'=>"form-control", 'rows'=>'3']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="text-align:center;">{!! Form::submit('Apply Loan Now', ['class'=>'btn btn-primary']) !!}</div>
        </div>
    </div>
</div>
<!-- loan and repayment detail ends here -->

{!! Form::hidden('customer_id', base64_encode($customerObj->id)) !!}
{!! Form::hidden('scheme_id', base64_encode($scheme_id)) !!}
{!! Form::hidden('interest', $interest, ['id'=>'interest']) !!}
{!! Form::hidden('bal_retire_months', $bal_retire_months, ['id'=>'bal_retire_months']) !!}
{!! Form::hidden('loan_period_months', '', ['id'=>'loan_period_months']) !!}

@if ($scheme_id == 1)
{!! Form::hidden('min_amt', '', ['id'=>'min_amt']) !!}
{!! Form::hidden('max_amt', $maxAllowedAmt, ['id'=>'max_amt']) !!}
@elseif ($scheme_id == 2)
{!! Form::hidden('salary_level_id', base64_encode($customerObj->Salary_Level->id)) !!}
{!! Form::hidden('min_amt', 1) !!}
{!! Form::hidden('max_amt', $maxAdvanceAllowed) !!}
@endif

{!! Form::close() !!}
<script src="{{ asset("js/jquery-validation/dist/jquery.validate.js")}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    jQuery.validator.addMethod("check_period", function(value, element, param) {
        var bal_retire_months = parseInt($('#bal_retire_months').val());
        var loan_period_months = parseInt($('#loan_period_months').val());
        return bal_retire_months > loan_period_months;
    },"Loan repayment period is lesser than the customer retirement period.");
    jQuery.validator.addMethod("calculateInterest", function(value, element, param) {
        var value = parseInt(value);
        var percent = parseInt($('#interest').val());
        var tot_loan = (((percent/100) * value)+value).toFixed(2);
        $('#tot_loan_amount').html(tot_loan);
        return true;
    });
    $("#Loanform").validate({
        rules: {
            loan_amount: {
                required:true,
                number:true,
                @if($scheme_id==1)
                min:function() {return parseInt($('#min_amt').val());},
                max:{!! $maxAllowedAmt !!},
                @elseif($scheme_id==2)
                min:1,
                max:{!! $maxAdvanceAllowed !!},
                @endif
                calculateInterest:true
            },
            @if($scheme_id==1)
            loan_classification: {
                required:true
            },
            loan_category: {
                required:true
            },
            loan_classification_amount: {
                required:true,
                check_period:true
            }
            @endif
        },
        messages: {
            loan_amount:{ 
                required:"Please enter loan amount.",  
                number:"Loan amount must be a number.",
                @if($scheme_id==2)
                max:"The loan amount exceeds maximum allowed. This maximum allowed is based on their salary level minus previously bought unpaid advance loan.",
                @endif
            },
            loan_classification: {
                required:"Please select loan classification"
            },
            loan_category: {
                required:"Please select loan category"
            }
        },
        errorPlacement: function(error, element) {     
            error.fadeIn(600).appendTo(element.parent());       
        },
        submitHandler: function(form) {
            $('#confirm-approve').modal('show').on('show.bs.modal', function(e) {
                var form = $(e.relatedTarget).closest('form');
                $(this).find('.modal-footer #confirm').data('form', form);
            });
            var scheme_id = "{!! $scheme_id !!}";
            if (scheme_id == 1){
                $('#confirm-approve .content_msg').html('{{ $customerObj->full_name }} is applying for a Credit Loan.');
            }else{
                $('#confirm-approve .content_msg').html('{{ $customerObj->full_name }} is applying for a Salary Advance Loan.');
            }
            $('#confirm-approve .modal-title').html('<i class="icon fa fa-warning text-yellow"></i> Attention');
        },
        errorClass: "error_msg",    
        errorElement: "div"
    });
    $('#confirm-approve').find('.modal-footer #confirm').on('click', function(){
        document.Loanform.submit();
    });
    $('#loan_classification').change(function(){
        $.post("{{ url('getamt')}}", { option: $(this).val() }, function(data) {
            $('#loan_classification_amount').html(data);
            $('#ln_cl_yr').html('--');
        });
    });
    $('#loan_classification_amount').change(function(){
        $.post("{{ url('getyr')}}",{ option: $(this).val() }, function(data) {
            $('#ln_cl_yr').html(data.period);
            $('#min_amt').val(data.min);
            $('#loan_period_months').val(data.months);
        });
    });
});
</script>
@endsection
