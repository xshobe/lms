@extends('layouts.admin.admin_template')

@section('content')
@include('partials.flash_success_msg')
@include('partials.list_errors')

<?php $currency=trim($currency_symbol);?>

{!! Form::open(array('url'=>'admin/advance-reconciliation','id'=>'adv-reconcile','autocomplete'=>'off')) !!}
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('opening_balance', "Opening balance brought forward($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('opening_balance',NULL,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('additional_fund', "Additional Fund Receipts from refund($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('additional_fund',NULL,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('advance_payments', "Advance Payments($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('advance_payments',NULL,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('outstanding', "Outstanding($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('outstanding',NULL,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('closing_balance', "Closing balance brought down($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('closing_balance',NULL,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('petty_cash', "Petty Cash($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('petty_cash',NULL,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('withdrawals', "Withdrawals($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('withdrawals',NULL,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('advance', "Advance($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('advance',NULL,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('overpayment', "Overpayment - Fotilewale($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('overpayment',NULL,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('fund_brought_forward', "Total funds brought forward($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('fund_brought_forward',NULL,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="pull-right"><button type="submit" class="btn btn-primary">Submit</button></div>
    </div>
</div>
{!! Form::close() !!}
<script src="{!! asset('js/jquery-validation/dist/jquery.validate.js') !!}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#adv-reconcile").validate({
        rules: {       
            opening_balance: {
            required:true,
            number:true
            },
            additional_fund: {
            required:true,
            number:true
            },
            advance_payments: {
            required:true,
            number:true
            },
            outstanding: {
            required:true,
            number:true
            },
            closing_balance: {
            required:true,
            number:true
            },
            petty_cash: {
            required:true,
            number:true
            },
            withdrawals: {
            required:true,
            number:true
            },
            advance: {
            required:true,
            number:true
            },
            overpayment: {
            required:true,
            number:true
            },
            fund_brought_forward: {
            required:true,
            number:true
            }
        },
        errorPlacement: function(error, element) {
            error.fadeIn(600).appendTo(element.parent());
        },
        submitHandler: function(form) {
            form.submit();
        },
        errorClass: "error_msg",
        errorElement: "div"
    });
});
</script>
@endsection
