@extends('layouts.admin.admin_ajax_template')

@section('content')
<table id="example1" class="table table-bordered table-striped">
	@if($customer != 'not-numeric')
		<thead>
			<tr>
				<th>First name</th>
				<th>Last name</th>
				<th>TPF number</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@if($customer)
			<tr>
				<td>{{ $customer->first_name }}</td>
				<td>{{ $customer->last_name }}</td>
				<td>{{ $customer->tpf_number }}</td> 
				<td><div class="col-xs-1"><a title="View History"  href="{{url('/admin/loan_section/viewDetails')."/".md5($customer->id)}}"><i class="fa fa-list"></i></a></div></td>                        
			</tr>
			@else
			<tr>
				<td colspan="3" style="vertical-align:middle;">No results found...</td>
				<td colspan="1"><a class="btn btn-primary btn-block" title="Add" href="{!! URL("admin/customers/create/$user_input") !!}"><i class="fa fa-plus"></i> Add Member</a></td>
			</tr>
			@endif
		</tbody>
	@else
		<tr><td style="color:#F00;">Please input valid TPF number</td></tr>
	@endif
</table>
@endsection
