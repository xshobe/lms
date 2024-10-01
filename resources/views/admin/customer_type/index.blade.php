@extends('layouts.admin.admin_list_template')

@section('content')
    @include('partials.confirm_delete_modal')
    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $('.content_msg').html('You are about to delete this customer type.');
            $('.modal-title').html('<i class="icon fa fa-warning text-yellow"></i> Confirm delete');
            var form = $(e.relatedTarget).closest('form');
            $(this).find('.modal-footer #confirm').data('form', form);
        });
        $('#confirm-delete').find('.modal-footer #confirm').on('click', function() {
            $(this).data('form').submit();
        });
    </script>
    <div class="row">
        <!--<div class="col-md-2"><a class="btn btn-primary btn-block margin-bottom" title="Add" href="{{ URL::route('customer_type.create') }}"><i class="fa fa-plus"></i> Add customer type</a></div>-->


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
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($customer_type)
                                @foreach ($customer_type as $val)
                                    <tr>
                                        <td>{{ $val->name }}</td>
                                        <td>{{ $status[$val->status] }}</td>

                                        <td>

                                            <div class="col-xs-1"><a title="Edit"
                                                href="{{ URL::route('customer_type.edit', $val->id) }}"><i
                                                        class="fa fa-edit"></i></a></div>
                                            <div class="col-xs-1">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['customer_type.destroy', $val->id]]) !!}


                                                {!! Form::button('<i class="fa fa-remove"></i>', [
                                                    'type' => 'button',
                                                    'class' => 'delete_btn',
                                                    'data-href' => URL::route('customer_type.destroy', $val->id),
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
                    "aTargets": [2]
                }]
            });

        });
    </script>
@endsection
