@extends('layouts.front.front_template')

@section('content')
<link rel="stylesheet" href="{!! asset('admin_panel/bootstrap/css/bootstrap.min.css') !!}" />
<link rel="stylesheet" href="{!! asset('admin_panel/plugins/datatables/dataTables.bootstrap.css') !!}" />
<script type="text/javascript" src="{!! asset('admin_panel/plugins/datatables/jquery.dataTables.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('admin_panel/plugins/datatables/dataTables.bootstrap.min.js') !!}"></script>
<section class="contentarea">
	<div class="row">
		@include('partials.flash_error_msg')
		<div class="innerpad loanhistroy">
			<div class="user-loan-history-container">
				<div class="sighead"><h3><span>Loan History</span></h3></div>
				<table width="100%" id="loan_history" class="table table-bordered table-striped" border="1" style="text-align:left;margin:77px 0 0 0;">
					<thead>
					<tr>
						<th>Loan Number</th>
						<th>TPF Number</th>
						<th>Scheme</th>
						<th>Amount Requested</th>
						<th>Requested On</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					@if ($loan_history && count($loan_history) > 0)
					@foreach ($loan_history as $val)
					<tr>
						<td>{{ $val->id }}</td>
						<td>{{ $user_data->tpf_number }}</td>
						<td>{{ $loan_scheme[$val->scheme_id] }}</td>
						<td>{{ $currency_symbol . numberFormat($val->amount_requested, 2) }}</td>
						<td>{{ date("d/m/Y", strtotime($val->created_at)) }}</td>
						<td>{{ $loan_status[$val->status] or '' }}</td>
						<td><a title="View Detail" href="{!! URL::route('customers.loan.detail', md5($val->id)) !!}">View Detail</a></td>
					</tr>
					@endforeach
					@endif
					</tbody>
				</table>
			</div>
		</div><!-- /.innerpad -->
	</div><!-- /.row -->
</section><!-- /.contentarea -->
<script>
$(document).ready(function(){       
	$("#loan_history").DataTable({
		"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 6 ] }] 
	});
});
</script>
@endsection
