@extends('layouts.admin.admin_list_template')

<?php $currency=trim($currency_symbol);?>

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table id="thisTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Loan Id</th>
                            <th>Loan Scheme</th>
                            <th>Member</th>
                            <th>TPF No</th>
                            <th>Loan Requested({!! $currency !!})</th>
                            <th>Amount Sanctioned({!! $currency !!})</th>
                            <th>Interest({!! $currency !!})</th>
                            <th>Amount Paid({!! $currency !!})</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($total_loans)>0)
                            <?php $tot_requested=$tot_sanctioned=$tot_interest=$tot_paid=0;?>
                            @foreach($total_loans as $val)
                            <?php $tot_requested += $val->amount_requested;
                            $tot_sanctioned += $val->amount_approved;
                            $tot_interest += $val->total_interest;
                            $tot_paid += $val->amount_paid;?>
                            <tr>
                                <td>{!! $val->loan_id !!}</td>
                                <td>{!! $loan_scheme[$val->scheme_id] or '&mdash;' !!}</td>
                                <td>{!! getCustomerName($val->Customer) !!}</td>
                                <td>{!! $val->Customer->tpf_number !!}</td>
                                <td align="right">{!! ($val->amount_requested!='') ? $val->amount_requested : '&mdash;' !!}</td>
                                <td align="right">{!! ($val->amount_approved!='') ? $val->amount_approved : '&mdash;' !!}</td>
                                <td align="right">{!! ($val->total_interest!='') ? $val->total_interest : '&mdash;' !!}</td>
                                <td align="right">{!! ($val->amount_paid!='') ? $val->amount_paid : '&mdash;' !!}</td>
                                <td><?php echo ($val->flag==2) ? 'Completed' : 'Active';?></td>
                                <td><div class="col-xs-1"><a title="View Loan Detail" href="{!! url("admin/customers/$val->customer_id#$val->loan_id") !!}"><i class="fa fa-external-link"></i></a></div></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td><strong>Total({!! $currency !!})</strong></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="right">{!! numberFormat($tot_requested) !!}</td>
                                <td align="right">{!! numberFormat($tot_sanctioned) !!}</td>
                                <td align="right">{!! numberFormat($tot_interest) !!}</td>
                                <td align="right">{!! numberFormat($tot_paid) !!}</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="pagination-container">{!! $total_loans->render() !!}</div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script>
$(document).ready(function(){
    $("#thisTable").DataTable({
        "order": [],
        "aoColumnDefs": [{"bSortable": false, "aTargets": [9]}],
        "paging": false,
        "bInfo": false,
        "searching": false
    });
});
</script>
@endsection
