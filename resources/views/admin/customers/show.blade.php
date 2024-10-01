@extends('layouts.admin.admin_template')

<?php $currency=trim($currency_symbol);?>

@section('content')
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
            	<img width="150" height="150" src="{!! getProfileImageUrl($customerObj) !!}" />
            </div>
        </div>
    </div>
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

<!-- credit loan statement starts here -->
<div class="box box-primary">
    <div class="box-body heightfixdiv">
        <p style="text-align:center;font-size:18px;">Loan Statement &ndash; {{ getCustomerName($customerObj) }}</p>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('department', 'Ministry of') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->ministry != '') ? $customerObj->ministry : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('level', 'Level') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $customerObj->SalaryLevel[$customerObj->salary_level] or '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('max_allowed', 'Maximum Allowed') !!}
                        </div>
                        <div class="col-md-7">
                        {!! $currency_symbol . $maxAllowedAmt !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('outstanding_loan', 'Outstanding Loan') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $currency_symbol . $generalLoanInfo['creditLoan']['amt_to_pay'] }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('eligibility', 'Eligibility ') !!}
                        </div>
                        <div class="col-md-7">
                        {!! $currency_symbol . $maxAllowedAmt !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr><th colspan="4" style="text-align:center;font-size:18px;">SAVINGS</th></tr>
                        <tr>
                            <th>Date</th>
                            <th>Transaction</th>
                            <th>Savings({!! $currency !!})</th>
                            <th>Savings R/B({!! $currency !!})</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{!! getFormattedDate($customerObj->created_at) !!}</td>
                            <td>{!! 'Salary' !!}</td>
                            <td>{!! '0.00' !!}</td>
                            <td>{!! '0.00' !!}</td>
                        </tr>
                        <?php $savingAmt=0;?>
                        @forelse($customerObj->getSavingsLog as $val)
                        <tr>
                            <?php $savingAmt += $val->amount_paid;?>
                            <td>{!! getFormattedDate($val->created_at) !!}</td>
                            <td>{!! 'Salary' !!}</td>
                            <td>{!! $val->amount_paid !!}</td>
                            <td>{!! numberFormat($savingAmt) !!}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr><th colspan="4" style="text-align:center;font-size:18px;">DEDUCTIONS</th></tr>
                        <tr>
                            <th>Date</th>
                            <th>Transaction</th>
                            <th>Amount deducted({!! $currency !!})</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customerObj->getDeductionsLog as $val)
                        <tr>
                            <td>{!! getFormattedDate($val->created_at) !!}</td>
                            <td>{!! $deduction_type[$val->type] or '&mdash;' !!}</td>
                            <td>{!! $val->amount_deducted !!}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" align="center">No history found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered table-striped">
                <thead>
                    <tr><th colspan="4" style="text-align:center;font-size:18px;">Transaction History</th></tr>
                </thead>
                <tbody>
                    @forelse($customer_loans as $val)
                        <tr>
                            <td id="{!! $val->loan_id !!}" colspan="4"><h4><strong>Loan ID:</strong> {!! $val->loan_id !!}</h4></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <th>Transaction</th>
                            <th>Amount({!! $currency !!})</th>
                            <th>Outstanding Balance({!! $currency !!})</th>
                        </tr>
                        <?php $payments = $loanMasterObj->getTransactionLog($val->loan_id);?>
                        <?php foreach ($payments as $payment):?>
                        <tr>
                            <td>{!! getFormattedDate($payment->created_at) !!}</td>
                            <td>{!! $payment->transaction !!}</td>
                            <td>{!! $payment->amount !!}</td>
                            <td>{!! $payment->balance_amount !!}</td>
                        </tr>
                        <?php endforeach;?>
                        <?php if ($val->flag==2):?>
                        <tr>
                            <td colspan="2" align="right">
                                <strong>Total Amount Borrowed({!! $currency !!})</strong><br/>
                                <strong>Interest Calculated({!! $currency !!})</strong>
                            </td>
                            <td colspan="2" align="right">
                                {!! $val->total_loan_amount !!}<br/>
                                {!! $val->total_interest !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"><strong>Repayment({!! $currency !!})</strong></td>
                            <td colspan="2" align="right">{!! $val->amount_paid !!}</td>
                        </tr>
                        <?php endif;?>
                    @empty
                        <tr>
                            <td colspan="4" align="center">No history found.</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>
<!-- credit loan statement ends here -->

<!-- advance loan statement starts here -->
<div class="box box-primary">
    <div class="box-body heightfixdiv">
        <p style="text-align:center;font-size:18px;">Advance Statement &ndash; {{ getCustomerName($customerObj) }}</p>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('department', 'Ministry of') !!}
                        </div>
                        <div class="col-md-7">
                        {{ ($customerObj->ministry != '') ? $customerObj->ministry : '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('level', 'Level') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $customerObj->SalaryLevel[$customerObj->salary_level] or '&ndash;' }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('max_allowed', 'Maximum Allowed') !!}
                        </div>
                        <div class="col-md-7">
                        {!! $currency_symbol . $maxAllowedAmt !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-5">
                        {!! Form::label('amt_borrowed', 'Amount Borrowed') !!}
                        </div>
                        <div class="col-md-7">
                        {{ $currency_symbol . $generalLoanInfo['advanceLoan']['amt_approved'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Loan ID</th>
                <th>Date Borrowed</th>
                <th>Amount Borrowed({!! $currency !!})</th>
                <th>Interest({!! $currency !!})</th>
                {{-- <th>Loan Fee({!! $currency !!})</th> --}}
                <th>Amount Paid({!! $currency !!})</th>
                {{-- <th>For F/N</th> --}}
                <th>Due({!! $currency !!})</th>
            </tr>
        </thead>
        <tbody>
            @if (count($customer_advances)>0)
                @foreach($customer_advances as $val)
                <tr>
                    <td id="{!! $val->loan_id !!}"><a href="javascript:void(0);" style="text-decoration: underline;" class="showTransactionLog" data-loan-id="{!! $val->loan_id !!}">{!! $val->loan_id !!}</a></td>
                    <td>{!! getFormattedDate($val->created_at) !!}</td>
                    <td>{!! $val->amount_approved !!}</td>
                    <td>{!! $val->total_interest !!}</td>
                    {{-- <td>{!! $val->loan_fee !!}</td> --}}
                    <td>{!! $val->amount_paid or '&ndash;' !!}</td>
                    {{-- <td>{!! getFormattedDate($val->repaid_date) !!}</td> --}}
                    <td>{!! $val->amount_to_pay !!}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="2" align="right"><strong>Total</strong></td>
                    <td><strong>{!! $generalLoanInfo['advanceLoan']['amt_approved'] !!}</strong></td>
                    <td><strong>{!! $generalLoanInfo['advanceLoan']['tot_interest'] !!}</strong></td>
                    {{-- <td><strong>{!! $generalLoanInfo['advanceLoan']['tot_fee'] !!}</strong></td> --}}
                    <td><strong>{!! $generalLoanInfo['advanceLoan']['amt_paid'] !!}</strong></td>
                    {{-- <td>&nbsp;</td> --}}
                    <td><strong>{!! $generalLoanInfo['advanceLoan']['amt_to_pay'] !!}</strong></td>
                </tr>
            @else
                <tr>
                    <td colspan="6" align="center">No history found.</td>
                </tr>
            @endif
        </table>
    </div>
</div>
<!-- advance loan statement ends here -->
<script>
$(document).on("click", ".showTransactionLog", function() {
    var ele = $(this), parentTag = ele.closest("tr"), loanID = ele.attr("data-loan-id");
    if (ele.hasClass("visible")) {
        ele.removeClass("visible");
        parentTag.next().fadeOut();
    } else {
        ele.addClass("visible");
        parentTag.next().fadeIn();
        if (!parentTag.next().hasClass("transaction-loaded")) {
            parentTag.after('<tr><td colspan="6" align="center"><p>Please wait...</p></td></tr>');
            $.get("{!! url('admin/members/advance-transaction-history/'. $customerObj->id) !!}/" +loanID, function(data) {
                var obj = JSON.parse(data);
                if (obj.status == 1) {
                    parentTag.next().remove();
                    parentTag.after('<tr class="transaction-loaded"><td colspan="6" align="right">'+ obj.data +'</td></tr>');
                }
            });
        }
    }
})
</script>
@endsection
