@extends('layouts.admin.admin_template')

@section('content')
@include('partials.flash_success_msg')
@include('partials.list_errors')

<?php
$withdraw_fee=isset($settingObj->withdraw_fee) ? $settingObj->withdraw_fee : NULL;
$administration_fee=isset($settingObj->administration_fee) ? $settingObj->administration_fee : NULL;
$membership_fee=isset($settingObj->membership_fee) ? $settingObj->membership_fee : NULL;
$loan_fee=isset($settingObj->loan_fee) ? $settingObj->loan_fee : NULL;
$currency=trim($currency_symbol);
?>

{!! Form::open(array('url'=>'admin/settings','id'=>'admin-settings','autocomplete'=>'off')) !!}
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('withdraw_fee', "Withdraw Fee($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('withdraw_fee',$withdraw_fee,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('administration_fee', "Administration Fee($currency) / Monthly") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('administration_fee',$administration_fee,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('membership_fee', "Membership Fee($currency)") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('membership_fee',$membership_fee,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
                {{-- <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                        {!! Form::label('loan_fee', "Loan Fee($currency) / Loan") !!}
                        </div>
                        <div class="col-md-6">
                        {!! Form::text('loan_fee',$loan_fee,['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div> --}}
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
    $("#admin-settings").validate({
        rules: {       
            withdraw_fee: {
            number:true
            },
            administration_fee: {
            number:true
            },
            membership_fee: {
            number:true
            }, 
            loan_fee: {
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
