@extends('layouts.pdf.main_template')

@section('content')
<div class="row">
	<div><h3>Loan Information</h3></div>
	<table border="1" width="100%">
		<tbody>
			<tr>
				<td class="left"><b>Customer</b></td>
				<td class="right">{{ $user_data->first_name .' '. $user_data->last_name }}</td>
			</tr>
			<tr>
				<td class="left"><b>TPF Number</b></td>
				<td class="right">{{ $user_data->tpf_number }}</td>
			</tr>
			<tr>
				<td class="left"><b>Loan Number</b></td>
				<td class="right">{{ $loan_data->id }}</td>
			</tr>
			<tr>
				<td class="left"><b>Scheme</b></td>
				<td class="right">{{ $loan_scheme[$loan_data->scheme_id] or '' }}</td>
			</tr>
			
			@if ($loan_data->scheme_id == 1)
				@if($loan_data->classifications!='')
				<tr>
					<td class="left"><b>Loan Type</b></td>
					<td class="right">{{ '' }}</td>
				</tr>
				@endif
				@if($loan_data->Loancat)
				<tr>
					<td class="left"><b>Loan Category</b></td>
					<td class="right">{{ $loan_data->Loancat->title }}</td>
				</tr>
				@endif
			@endif
			
			<tr>
				<td class="left"><b>Amount Requested</b></td>
				<td class="right">{{ '$'.numberFormat($loan_data->amount_requested) }}</td>
			</tr>

			@if ($loan_data->LoanAccount)
				<tr>
					<td class="left"><b>Amount Approved</b></td>
					<td class="right">{{ '$'.numberFormat($loan_data->LoanAccount->amount_approved) }}</td>
				</tr>
				<tr>
					<td class="left"><b>Payment Type</b></td>
					<td class="right">{{ $payment_method[$loan_data->LoanAccount->payment_type] or '' }}</td>
				</tr>
				@if ($loan_data->LoanAccount->payment_type == 2)
				<tr>
					<td class="left"><b>Cheque Number</b></td>
					<td class="right">{{ $loan_data->LoanAccount->cheque_no }}</td>
				</tr>
				@endif
			@endif
		</tbody>
	</table>

	@if(count($loan_data->LoanActivity)>0)
	<div><h3>Loan History</h3></div>
	<table border="1" width="100%">
		<thead>
			<tr>
				<th class="head">Date</th>
				<th class="head">Action</th>
				<th class="head">Reason</th>
			</tr>
		</thead>
		<tbody>
			@foreach($loan_data->LoanActivity as $activity)
			<tr>
				<td>{{ date('d/m/Y H:i:s A', strtotime($activity->created_at)) }}</td>
				<td>{{ $activity->action }}</td>
				<td>{{ $activity->reason }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@endif
</div>
@endsection