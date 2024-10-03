@extends('layouts.admin.admin_list_template')

@section('content')
    @include('partials.flash_success_msg')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <div class="tab-btn">
                            <a class="btn btn-info" href="{!! url('admin/loan/customerLoanRequests') !!}">Loan Scheme</a>&nbsp;&nbsp;
                            <a class="btn btn-info" href="{!! url('admin/loan/customerAdvanceRequests') !!}">Adavnce Scheme</a>
                        </div>
                    </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="thisTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Loan Id</th>
                                <th>Loan Scheme</th>
                                <th>Loan Requested({!! trim($currency_symbol) !!})</th>
                                <th>Member</th>
                                <th>TPF No</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created On</th>
                                <th>Approved By</th>
                                <th>Approved On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($LoanDetails as $val)
                                <tr>
                                    <td>{!! $val->id !!}</td>
                                    <td>{!! $loan_scheme[$val->scheme_id] or '&mdash;' !!}</td>
                                    <td>{!! $val->amount_requested !!}</td>
                                    <td>{!! getCustomerName($val->Customer) !!}</td>
                                    <td>{!! $val->Customer->tpf_number !!}</td>
                                    <td>{!! $loan_status[$val->status] or '&mdash;' !!}</td>
                                    <td>{!! getCustomerName($val->CreatedBy) !!}</td>
                                    <td>{!! date('d-m-Y', strtotime($val->created_at)) !!}</td>
                                    <td>{!! $val->approved_by != '' ? getCustomerName($val->ApprovedBy) : '&mdash;' !!}</td>
                                    <td>{!! $val->approved_at != '' ? date('d-m-Y', strtotime($val->approved_at)) : '&mdash;' !!}</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination-container">{{ $LoanDetails->links() }}</div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    <script>
        $(document).ready(function() {
            $("#thisTable").DataTable({
                "order": [],
                "paging": false,
                "bInfo": false
            });
        });
    </script>
@endsection
