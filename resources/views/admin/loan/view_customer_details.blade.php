@extends('layouts.admin.admin_template')

@section('content')
@include('partials.confirm_approve_modal')
@include('partials.alert_modal')
        
<!-- customer detail starts here -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Member Details</h3>
        <div class="box-tools pull-right">
            <a href="{!! url('admin/members/statement/'. md5($customerObj->id)) !!}" title="Print Member Statement"><i class="fa fa-print"></i></a>
            <a href="{!! url('admin/loan_section') !!}" class="btn btn-box-tool" title="Search Members">Search Members</a>
        </div>
    </div>
    <div class="box-body heightfixdiv">
        <div class="row" id="print_area1">
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
                        {!! Form::label('member_type', 'Member Category') !!}
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
            </div><!-- /.col -->
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
            </div><!-- /.col -->
            <div class="col-md-2">
                <img width="100%" src="{!! getProfileImageUrl($customerObj) !!}" />
            </div><!-- /.col -->
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
        </div>
    </div>
</div>
<!-- loan and repayment detail ends here -->
	 
<!-- action panel starts here -->
<div class="box box-primary">
    <div class="box-body">
        <div class="col-md-4">
            <input type="radio" name="loan_type" value="1" class="minimal">&nbsp;Credit Loan Scheme
        </div>
        @if ($generalLoanInfo['advanceLoan']['amt_to_pay'] > 0)
        <div class="col-md-4">
            <input disabled type="radio" name="loan_type" value="2" class="minimal">&nbsp;Advance Loan Scheme<br />
            <span style="color:red;">(Member still has an outstanding Advance loan)</span>
        </div>
        @else
        <div class="col-md-4">
            <input type="radio" name="loan_type" value="2" class="minimal">&nbsp;Advance Loan Scheme
        </div>
        @endif
        <div class="col-md-4">
            <a href="javascript:checkApply();" class="btn btn-primary">Apply for Loan <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
</div>
<!-- action panel ends here -->

<script src="{{ asset("admin_panel/plugins/iCheck/icheck.min.js") }}"></script>
<link rel="stylesheet" href="{{ asset("admin_panel/plugins/iCheck/all.css") }}">
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass:'icheckbox_minimal-blue',
      radioClass:'iradio_minimal-blue'
    });

    $('#confirm-approve').find('.modal-footer #confirm').on('click', function(){
        var loan_scheme=$('input[type="radio"].minimal:checked').val();   
        var url='{!! url('/admin/loan_section/applyLoan').'/'.md5($customerObj->id).'/' !!}'
        if(loan_scheme){
            window.location.href=url+loan_scheme;
        }
    });
});
function checkApply(){
    var loan_scheme=$('input[type="radio"].minimal:checked').val();
    if(!loan_scheme){
        $('#confirm-alert').modal('show').on('show.bs.modal', function(e) {});

        $('#confirm-alert .content_msg').html('Please select a scheme to apply for loan.');
        $('#confirm-alert .modal-title').html('<i class="icon fa fa-warning text-yellow"></i> Attention');                 
    }else{
        $('#confirm-approve').modal('show').on('show.bs.modal', function(e) {});

        if(loan_scheme == 1){
            $('#confirm-approve .content_msg').html('{{ $customerObj->full_name }} is applying for a Credit Loan.');
        }else{
            $('#confirm-approve .content_msg').html('{{ $customerObj->full_name }} is applying for a Salary Advance Loan.');
        }
        $('#confirm-approve .modal-title').html('<i class="icon fa fa-warning text-yellow"></i> Attention');
    }
}
</script>
@endsection