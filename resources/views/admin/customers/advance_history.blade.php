<?php $currency=trim($currency_symbol);?>

<table class="table table-bordered table-striped" style="width: 70%; background-color: #d2d6de;">
    <tr>
        <th>Amount({!! $currency !!})</th>
        <th>Amount Paid({!! $currency !!})</th>
        <th>Outstanding Balance({!! $currency !!})</th>
        <th>Paid Quarter</th>
    </tr>
    @foreach ($advanceHistory as $key => $val)
    <tr>
        <td>{!! $val->actual_amount !!}</td>
        <td>{!! $val->amount_paid !!}</td>
        <td>{!! $val->amount_to_pay !!}</td>
        <td>{!! getFormattedDate($val->quarter) !!}</td>
    </tr>
    @endforeach
</table>