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
					@if (isset($test) && $share_history && count($share_history) > 0)
					@foreach ($share_history as $history)
					<tr>
						<td>{{ $history->loan_id }}</td>
						<td>{{ $user_data->tpf_number }}</td>
						<td>{{ $loan_scheme[$history->scheme_id] }}</td>
						<td>{{ '$'.@number_format($history->loan_amount) }}</td>
						<td>{{ date("d/m/Y", strtotime($history->created_at)) }}</td>
						<td>{{ $loan_status[$history->status] or '' }}</td>
						<td><a title="View Detail" href="{!! URL::route('customers.loan.detail', md5($history->loan_id)) !!}">View Detail</a></td>
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