@extends('layouts.admin.admin_list_template')

@section('content')
    @include('partials.confirm_delete_modal')

    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $('.content_msg').html('You are about to delete this Salary level.');
            $('.modal-title').html('<i class="icon fa fa-warning text-yellow"></i> Confirm delete');
            var form = $(e.relatedTarget).closest('form');
            $(this).find('.modal-footer #confirm').data('form', form);
        });
        $('#confirm-delete').find('.modal-footer #confirm').on('click', function() {
            $(this).data('form').submit();
        });
    </script>
    <div class="row">
        <div class="col-md-2"><a class="btn btn-primary btn-block margin-bottom" title="Add"
                href="{{ URL::route('salarylevels.create') }}"><i class="fa fa-plus"></i> Add salary level</a></div>


        <div class="col-xs-12">
            @include('partials.flash_success_msg')
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Salary level</th>
                                <th>Eligibility</th>
                                <th>Interest(%)</th>
                                <!--    <th>Interest amount</th>
                                                     <th>total to be repaid</th> -->
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($Salary)
                                @foreach ($Salary as $val)
                                    <tr>
                                        <td>{{ $val->salary_from . ' to ' . $val->salary_to }}</td>
                                        <td>{{ $val->eligibility }}</td>
                                        <td>{{ $val->interest }}</td>
                                        <!-- <td>{{ $val->interest_amount }}</td>
                                                    <td>{{ $val->total_to_be_repaid }}</td> -->
                                        <td>{{ $status[$val->status] }}</td>
                                        <td>{{ date('d-m-Y', strtotime($val->created_at)) }}</td>
                                        <td>

                                            <!-- <div class="col-xs-1"><a title="View" href="{{ URL::route('salarylevels.show', $val->id) }}"><i class="fa fa-external-link"></i></a></div> -->
                                            <div class="col-xs-1"><a title="Edit"
                                                    href="{{ URL::route('salarylevels.edit', $val->id) }}"><i
                                                        class="fa fa-edit"></i></a></div>
                                            <div class="col-xs-1">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['salarylevels.destroy', $val->id]]) !!}
                                                {!! Form::button('<i class="fa fa-remove"></i>', [
                                                    'type' => 'button',
                                                    'class' => 'delete_btn',
                                                    'data-href' => URL::route('salarylevels.destroy', $val->id),
                                                    'data-target' => '#confirm-delete',
                                                    'data-toggle' => 'modal',
                                                ]) !!}

                                                {!! Form::close() !!}
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    <script>
        $(document).ready(function() {
            $("#example1").DataTable({
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [5]
                }]
            });

        });
    </script>
@endsection
