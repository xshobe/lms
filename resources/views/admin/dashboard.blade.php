@extends('layouts.admin.admin_template')

@section('content')
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-user-plus"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Members</span>
                <span class="info-box-number">{!! $tot_members !!}</span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-star"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Loan Requested: <strong>{!! $tot_loan_requested !!}</strong></span>
                <span class="info-box-text">Adv Requested: <strong>{!! $tot_advance_requested !!}</strong></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Loan Amt Requested: <strong>{!! numberFormat($loan_amt_requested) !!}</strong></span>
                <span class="info-box-text">Adv Amt Requested: <strong>{!! numberFormat($advance_amt_requested) !!}</strong></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
</div><!-- /.row -->
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-star"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Loan Approved: <strong>{!! $tot_loan_approved !!}</strong></span>
                <span class="info-box-text">Adv Approved: <strong>{!! $tot_advance_approved !!}</strong></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Loan Amt Approved: <strong>{!! numberFormat($loan_amt_approved) !!}</strong></span>
                <span class="info-box-text">Adv Amt Approved: <strong>{!! numberFormat($advance_amt_approved) !!}</strong></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
