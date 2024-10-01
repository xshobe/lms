@extends('layouts.front.front_template')

@section('content')
<section class="contentarea">
	<div class="row">
		<div class="innerpad">
			{!! $loan_status !!}
			<div class="loan-basic-info-container">
				<h1>Loan Information&nbsp;<span style="font-size:14px;">(Download report as PDF)&nbsp;<a href="{!! url('loan-pdf/'. md5($loan_data->id)) !!}"><img src="{!! asset('public/images/pdf-download.png') !!}" title="Download report as PDF" alt="" /></a></span></h1>
				<div class="loaninfo">
					<ul class="col5 loanul">
                    	<li><strong>Customer</strong><span>{{ $user_data->first_name .' '. $user_data->last_name }}</span></li>
                    	<li><strong>TPF Number</strong><span>{{ $user_data->tpf_number }}</span></li>
                        <li><strong>Loan Number</strong><span>{{ $loan_data->id }}</span></li>
                        <li><strong>Scheme</strong><span>{{ $loan_scheme[$loan_data->scheme_id] or '' }}</span></li>
						
						@if($loan_data->scheme_id == 1)
							@if($loan_data->classifications!='')
							<li><strong>Loan Type</strong><span>{{ '' }}</span></li>
							@endif
							@if($loan_data->Loancat)
							<li><strong>Loan Category</strong><span>{{ $loan_data->Loancat->title }}</span></li>
							@endif
						@endif	
                        
                        <li><strong>Amount Requested</strong><span>{{ $currency_symbol . numberFormat($loan_data->amount_requested) }}</span></li>
                        
                        @if($loan_data->LoanAccount)
	                        <li><strong>Amount Approved</strong><span>{{ $currency_symbol . numberFormat($loan_data->LoanAccount->amount_approved) }}</span></li>
							<li><strong>Payment Type</strong><span>{{ $payment_method[$loan_data->LoanAccount->payment_type] or '' }}</span></li>
							@if($loan_data->LoanAccount->payment_type == 2)
							<li><strong>Cheque Number</strong><span>{{ $loan_data->LoanAccount->cheque_no }}</span></li>
							@endif
						@endif
					</ul>
				</div>
			</div>

			<style type="text/css">
			table tr th{text-align:left;font-weight:bold;background-color: rgba(239,159,1,0.4);}
			table, table tr, table tr td{border:1px solid rgba(239, 159, 1, 0.6);}
			</style>
			@if(count($loan_activity = $loan_data->LoanActivity)>0)
			<h1>Loan History</h1>
			<table width="100%" border="1" style="margin:0 0 30px;">
				<thead>
					<tr>
						<th>Date</th>
						<th>Action</th>
						<th>Reason</th>
					</tr>
				</thead>
				<tbody>
					@foreach($loan_activity as $activity)
					<tr>
						<td>{{ date('d/m/Y H:i:s A', strtotime($activity->created_at)) }}</td>
						<td>{{ $activity->action }}</td>
						<td>{{ $activity->reason }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endif

			<h1>Payment History</h1>
			<table width="100%" border="1">
				<thead>
					<tr>
						<th>Date</th>
						<th>Amount Paid</th>
					</tr>
				</thead>
				<tbody>
					@if(count($payment_log = $loan_data->LoanPaymentLog)>0)
					@foreach($payment_log as $log)
					<tr>
						<td>{{ date('d/m/Y', strtotime($log->created_at)) }}</td>
						<td>{{ $currency_symbol.$log->amount_paid }}</td>
					</tr>
					@endforeach
					<tr>
						<td style="font-weight:bold;">Total</td>
						<td>{!! $currency_symbol . $loan_data->LoanAccount->amount_paid !!}</td>
					</tr>
					@else
					<tr>
						<td colspan="2">No repayment was done for this loan.</td>
					</tr>
					@endif
				</tbody>
			</table>
			<table width="100%" border="1" style="text-align:right;">
				<tbody>
					<tr>
						<td style="font-weight:bold;">Loan Amount</td>
						<td>{!! $currency_symbol.$loan_data->LoanAccount->amount_approved !!}</td>
					</tr>
					<tr>
						<td style="font-weight:bold;">Amount Paid</td>
						<td>{!! $currency_symbol.$loan_data->LoanAccount->amount_paid !!}</td>
					</tr>
					<tr>
						<td style="font-weight:bold;">Amount to Pay</td>
						<td>{!! $currency_symbol.$loan_data->LoanAccount->amount_to_pay !!}</td>
					</tr>
				</tbody>
			</table>
		</div><!-- /.innerpad -->
	</div><!-- /.row -->
</section><!-- /.contentarea -->
@endsection