@extends('layouts.admin.admin_list_template')

@section('content')
    @include('partials.confirm_delete_modal')
    <div class="row">
        <div class="col-md-2"><a class="btn btn-primary btn-block margin-bottom" title="Add"
                href="{!! URL::route('customers.create') !!}"><i class="fa fa-plus"></i> Add Member</a></div>
        <div class="col-xs-12">
            @include('partials.flash_success_msg')
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th>TPF No</th>
                                <th>Salary Level</th>
                                <th>Member Category</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->first_name . ' ' . $customer->last_name }}</td>
                                    <td>{{ $customer->tpf_number }}</td>
                                    <td>{{ $customerObj->SalaryLevel or '&ndash;' }}</td>
                                    <td>{{ $customerObj->customer_types[$customer->customer_category_id] or '&ndash;' }}
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($customer->created_at)) }}</td>
                                    <td>{{ $status[$customer->status] or '&ndash;' }}</td>
                                    <td>
                                        <div class="col-xs-1"><a title="View" href="{!! URL::route('customers.show', $customer->id) !!}"><i
                                                    class="fa fa-external-link"></i></a></div>
                                        <div class="col-xs-1"><a title="Edit" href="{!! URL::route('customers.edit', $customer->id) !!}"><i
                                                    class="fa fa-edit"></i></a></div>
                                        <div class="col-xs-1">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['customers.destroy', $customer->id]]) !!}
                                            {!! Form::button('<i class="fa fa-remove"></i>', [
                                                'type' => 'button',
                                                'class' => 'delete_btn',
                                                'data-href' => URL::route('customers.destroy', $customer->id),
                                                'data-target' => '#confirm-delete',
                                                'data-toggle' => 'modal',
                                            ]) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    @if ($customers->hasPages())
                        <div class="pagination-wrapper" style="text-align: end;">
                            {{ $customers->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#example1").DataTable({
                "order": [],
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [6]
                }],
                "paging": false,
                "bInfo": false
            });
        });
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $('.content_msg').html('Are you sure you want to delete this member?');
            $('.modal-title').html('<i class="icon fa fa-warning text-yellow"></i> Confirm delete');
            var form = $(e.relatedTarget).closest('form');
            $(this).find('.modal-footer #confirm').data('form', form);
        });
        $('#confirm-delete').find('.modal-footer #confirm').on('click', function() {
            $(this).data('form').submit();
        });
    </script>
@endsection
