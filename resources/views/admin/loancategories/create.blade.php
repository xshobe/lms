@extends('layouts.admin.admin_template')

@section('content')
    <script src="{{ asset('js/jquery-validation/dist/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function() {
            // validate form on keyup and submit
            $("#loancategoryform").validate({
                rules: {
                    loan_title: {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    loan_title: {
                        required: "Please enter loan title.",
                        minlength: "Loan title must consist of at least 2 characters.",
                        maxlength: "Loan title should not exceed 30 characters."
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
                    document.loancategoryform.submit();
                },
                errorClass: "error_msg",
                errorElement: "div"
            });


        });
    </script>
    @include('partials.list_errors')
    {!! Form::open(['route' => ['loancategories.store'], 'id' => 'loancategoryform', 'name' => 'loancategoryform']) !!}
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->

                <div class="box-body">
                    <div class="col-md-3 pull-right">
                        <a title="Manage Loan Categories" href="{{ url('/admin/loancategories') }}"><i
                                class="btn btn-block btn-info pull-right back_button">Manage Loan Categories</i></a>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('loan_title', 'Loan Title') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('loan_title', '', ['class' => 'form-control']) !!}
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
