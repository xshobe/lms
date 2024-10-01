@extends('layouts.admin.admin_template')
@section('content')
    @include('partials.list_errors')

    {!! Form::open([
        'route' => ['roles.set-access', $role->id],
        'id' => 'roleform',
        'name' => 'roleform',
        'method' => 'POST',
    ]) !!}
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->

                <div class="box-body">
                    <div class="col-md-2 pull-right">
                        <a title="Manage Roles" href="{{ url('/admin/roles') }}"><i
                                class="btn btn-block btn-info pull-right back_button">Manage Roles</i></a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Pages</th>
                                <th>Select All<br />&nbsp; &nbsp;
                                    {!! Form::checkbox('select_all', null, null, ['id' => 'selecctall']) !!}

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($privileges as $key => $value)
                                <tr>
                                    <td>{{ $value }}</td>
                                    <td>

                                        <div class="col-xs-1">
                                            {!! Form::checkbox('privilege_id[]', $key, in_array($key, $checked_privilege_ids), ['class' => 'permission']) !!}

                                        </div>


                                </tr>
                            @endforeach

                    </table>


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>

                </div><!-- /.box -->

            </div> <!-- /.row -->
            {!! Form::close() !!}
        @endsection
