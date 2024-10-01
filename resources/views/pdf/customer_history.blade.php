@extends('layouts.pdf.main_template')

<?php $currency=trim($currency_symbol);?>

@section('content')
<div class="row">
	<!-- customer detail starts here -->
	<table border="1" width="100%">
		<thead>
			<tr><th colspan="2" style="text-align:center;font-size:18px;">Member Details</th></tr>
		</thead>
		<tbody>
			<tr>
				<td class="left"><strong>{!! Form::label('member', 'Member') !!}</strong></td>
				<td class="right">{{ getCustomerName($customerObj) }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('customer_type', 'Member Category') !!}</strong></td>
				<td class="right">{{ $customerObj->customer_types[$customerObj->customer_category_id] or '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('tpf_number', 'TPF No') !!}</strong></td>
				<td class="right">{{ ($customerObj->tpf_number != '') ? $customerObj->tpf_number : '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('job_title', 'Job Title') !!}</strong></td>
				<td class="right">{{ ($customerObj->job_title != '') ? $customerObj->job_title : '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('ministry', 'Ministry') !!}</strong></td>
				<td class="right">{{ ($customerObj->ministry != '') ? $customerObj->ministry : '&ndash;' }}</td>
			</tr>

			@if($customerObj->customer_category_id == '3')
			<tr>
				<td class="left"><strong>{!! Form::label('school', 'School') !!}</strong></td>
				<td class="right">{{ ($customerObj->school != '') ? $customerObj->school : '&ndash;' }}</td>
			</tr>
			@endif
			
			<tr>
				<td class="left"><strong>{!! Form::label('salary_level', 'Salary Level') !!}</strong></td>
				<td class="right">{{ $customerObj->SalaryLevel[$customerObj->salary_level] or '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('email', 'Email') !!}</strong></td>
				<td class="right">{{ ($customerObj->email != '') ? $customerObj->email : '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('gender', 'Gender') !!}</strong></td>
				<td class="right">{{ $gender_array[$customerObj->gender] or '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('dob', 'DOB') !!}</strong></td>
				<td class="right">{{ ($customerObj->dob != '') ? getFormattedDate($customerObj->dob) : '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('mobile', 'Mobile') !!}</strong></td>
				<td class="right">{{ ($customerObj->mobile != '') ? $customerObj->mobile : '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('address', 'Address') !!}</strong></td>
				<td class="right">{{ ($customerObj->contact != '') ? $customerObj->contact : '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('register_date', 'Register Date') !!}</strong></td>
				<td class="right">{{ ($customerObj->register_date != '') ? getFormattedDate($customerObj->register_date) : '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('width_date', 'Withdrawal Date') !!}</strong></td>
				<td class="right">{{ ($customerObj->width_date != '') ? getFormattedDate($customerObj->width_date) : '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('retirement_date', 'Date of Retirement') !!}</strong></td>
				<td class="right">{{ ($customerObj->retirement_date != '') ? getFormattedDate($customerObj->retirement_date) : '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('bank_type', 'Bank Name') !!}</strong></td>
				<td class="right">{{ $customerObj->banks[$customerObj->bank_id] or '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>{!! Form::label('account_no', 'Account No') !!}</strong></td>
				<td class="right">{{ ($customerObj->account_no != '') ? $customerObj->account_no : '&ndash;' }}</td>
			</tr>
		</tbody>
	</table>
	<!-- customer detail ends here -->

	<!-- saving detail starts here -->
	<table border="1" width="100%" style="margin-top:20px;">
		<thead>
			<tr><th colspan="2" style="text-align:center;font-size:18px;">Savings Details</th></tr>
		</thead>
		<tbody>
			<tr>
				<td class="left"><strong>Savings A/C No</strong></td>
				<td class="right">{{ ($customerObj->account_no != '') ? $customerObj->account_no : '&ndash;' }}</td>
			</tr>
			<tr>
				<td class="left"><strong>Savings Amount</strong></td>
				<td class="right">{!! $currency_symbol . $savings_amt !!}</td>
			</tr>
		</tbody>
	</table>
	<!-- saving detail ends here -->

	<!-- loan and repayment detail starts here -->
	<table border="1" width="100%" style="margin-top:20px;">
		<thead>
			<tr><th colspan="2" style="text-align:center;font-size:18px;">Loan and Payment Details</th></tr>
		</thead>
		<tbody>
			<tr>
				<td class="left"><strong>Loan Recevied</strong></td>
				<td class="right" align="right">+{!! $currency_symbol . $generalLoanInfo['creditLoan']['amt_approved'] !!}</td>
			</tr>
			<tr>
				<td class="left"><strong>Advance Borrowed</strong></td>
				<td class="right" align="right">+{!! $currency_symbol . $generalLoanInfo['advanceLoan']['amt_approved'] !!}</td>
			</tr>
			{{-- <tr>
				<td class="left"><strong>Loan Fee(deducted from savings)</strong></td>
				<td class="right" align="right">{!! $currency_symbol . $generalLoanInfo['allLoanInfo']['tot_fee'] !!}</td>
			</tr> --}}
			<tr>
				<td class="left"><strong>Interest</strong></td>
				<td class="right" align="right">+{!! $currency_symbol . $generalLoanInfo['allLoanInfo']['tot_interest'] !!}</td>
			</tr>
			<tr>
				<td class="left"><strong>Repayment</strong></td>
				<td class="right" align="right">-{!! $currency_symbol . $generalLoanInfo['allLoanInfo']['amt_paid'] !!}</td>
			</tr>
			<tr>
				<td class="left"><strong>Total Outstanding</strong></td>
				<td class="right" align="right"><strong>{!! $currency_symbol . $generalLoanInfo['allLoanInfo']['amt_to_pay'] !!}</strong></td>
			</tr>
		</tbody>
	</table>
	<!-- loan and repayment detail ends here -->

	<!-- saving statement starts here -->
	<table border="1" width="100%" style="margin-top:20px;">
		<thead>
			<tr><th colspan="4" style="text-align:center;font-size:18px;">Savings</th></tr>
		</thead>
		<tbody>
			<tr>
				<th>Date</th>
				<th>Transaction</th>
				<th>Savings({!! $currency !!})</th>
				<th>Savings R/B({!! $currency !!})</th>
			</tr>
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
	<!-- saving statement ends here -->

	<!-- deduction statement starts here -->
	<table border="1" width="100%" style="margin-top:20px;">
		<thead>
			<tr><th colspan="3" style="text-align:center;font-size:18px;">Deductions</th></tr>
		</thead>
		<tbody>
			<tr>
				<th>Date</th>
				<th>Transaction</th>
				<th>Amount deducted({!! $currency !!})</th>
			</tr>
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
	<!-- deduction statement ends here -->

	<!-- credit loan statement starts here -->
	<table border="1" width="100%" style="margin-top:20px;">
		<thead>
			<tr><th colspan="4" style="text-align:center;font-size:18px;">Credit Loan Transaction History</th></tr>
		</thead>
		<tbody>
		@forelse($customer_loans as $val)
		    <tr>
		        <td colspan="4"><h4><strong>Loan ID:</strong> {!! $val->loan_id !!}</h4></td>
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
		</tbody>
	</table>
	<!-- credit loan statement ends here -->

	<!-- advance loan statement starts here -->
	<table border="1" width="100%" style="margin-top:20px;">
		<thead>
			<tr><th colspan="7" style="text-align:center;font-size:18px;">Advance Loan Transaction History</th></tr>
		</thead>
		<tbody>
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
			@if (count($customer_advances)>0)
			    @foreach($customer_advances as $val)
			    <tr>
					<td id="{!! $val->loan_id !!}">{!! $val->loan_id !!}</td>
			        <td>{!! getFormattedDate($val->created_at) !!}</td>
			        <td>{!! $val->amount_approved !!}</td>
			        <td>{!! $val->initial_interest !!}</td>
			        {{-- <td>{!! $val->loan_fee !!}</td> --}}
			        <td>{!! $val->amount_paid !!}</td>
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
			        <td colspan="7" align="center">No history found.</td>
			    </tr>
			@endif
		</tbody>
	</table>
	<!-- advance loan statement ends here -->
</div>
@endsection