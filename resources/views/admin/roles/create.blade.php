@extends('layouts.admin.admin_template')
@section('content')
    <script src="{{ asset('js/jquery-validation/dist/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function() {
            // validate form on keyup and submit
            $("#roleform").validate({
                rules: {
                    role_name: {
                        required: true,
                        alpha: true,
                        minlength: 2,
                        maxlength: 25
                    }
                },
                messages: {
                    role_name: {
                        required: "Please enter role name.",
                        alpha: "Please enter the role name in alphabets.",
                        minlength: "role name must consist of at least 2 characters.",
                        maxlength: "role name should not exceed 25 characters."
                    },
                    debug: true
                },
                errorPlacement: function(error, element) {
                    error.fadeIn(600).appendTo(element.parent());
                },
                submitHandler: function() {
                    document.roleform.submit();
                },
                errorClass: "error_msg",
                errorElement: "div"
            });
        });
    </script>
    @include('partials.list_errors')

    {!! Form::open(['route' => ['admin.roles.store'], 'id' => 'roleform', 'name' => 'roleform']) !!}
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
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('role_name', 'Role') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('role_name', '', ['class' => 'form-control']) !!}

                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>

                </div><!-- /.box -->

            </div> <!-- /.row -->
            {!! Form::close() !!}
        @endsection
