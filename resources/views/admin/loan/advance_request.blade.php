@extends('layouts.admin.admin_list_template')

@section('content')
<div class="row">
	
            <div class="col-xs-12">
          @include('partials.flash_success_msg')
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
                
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Loan Id</th>
                        <th>Loan Scheme</th>
                        <th>Loan Requested({!! trim($currency_symbol) !!})</th>
                        <th>Member</th>
                        <th>TPF No</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Approved By</th>
                        <th>Created On</th>
                     
                      </tr>
                    </thead>
                    <tbody>
                    @if($LoanDetails)	
                    @foreach($LoanDetails as $val)
                      <tr>
                        <td>{{$val->id}}</td>
                        <td>{{$loan_scheme[$val->scheme_id]}}</td>
                        <td>{{$val->amount_requested}}</td>
                        <td>{{$val->Customer->first_name .' '. $val->Customer->last_name}}</td>
                        <td>{{$val->Customer->tpf_number}}</td>
                        <td>{{$loan_status[$val->status]}}</td>
                        
                        <td>{{$val->CreatedBy->first_name.' '.$val->CreatedBy->last_name}}</td>
                        <td> {{(count($val->ApprovedBy)>0)?$val->ApprovedBy->first_name.' '.$val->ApprovedBy->last_name:'----'}}</td>
                        <td>{{date('d-m-Y',strtotime($val->created_at))}}</td>
            
                      </tr>
                      @endforeach
                     @endif
                  </table>
                  <div class="pagination-container">{!! $LoanDetails->render() !!}</div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
<script>
$(document).ready(function(){
    $("#example1").DataTable({
        "order": [[ 8, "desc" ]],
        "paging": false,
        "bInfo": false
    });
});
</script> 
@endsection
