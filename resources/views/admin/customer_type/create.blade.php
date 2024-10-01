@extends('layouts.admin.admin_template')

@section('content')
    <script src="{{ asset('js/jquery-validation/dist/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function() {
            // validate form on keyup and submit
            $("#customer_type_form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2,
                        maxlength: 50
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter customer type",
                        alpha: "Please enter the customer type in alphabets.",
                        minlength: "Customer type must consist of at least 2 characters.",
                        maxlength: "Customer type should not exceed 50 characters."
                    },
                    status: {
                        required: "Please select status."
                    },
                    debug: true
                },
                errorPlacement: function(error, element) {
                    error.fadeIn(600).appendTo(element.parent());
                },
                submitHandler: function() {
                    document.customer_type_form.submit();
                },
                errorClass: "error_msg",
                errorElement: "div"
            });


        });
    </script>
    @include('partials.list_errors')
    {!! Form::open([
        'route' => ['customer_type.store'],
        'id' => 'customer_type_form',
        'name' => 'customer_type_form',
    ]) !!}
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->

                <div class="box-body">
                    <div class="col-md-3 pull-right">
                        <a title="Manage customer types" href="{{ url('/admin/customer_type') }}"><i
                                class="btn btn-block btn-info pull-right back_button">Manage customer types</i></a>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('name', 'Name') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('name', '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('status', 'Status') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::select('status', $status, null, ['placeholder' => 'Select Status', 'class' => 'form-control']) !!}
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
