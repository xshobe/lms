@extends('layouts.admin.admin_template')

@section('content')
    <script src="{{ asset('js/jquery-validation/dist/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function() {
            // validate form on keyup and submit
            $("#loancategories").validate({
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
                        required: "Please enter user name.",
                        minlength: "User name must consist of at least 2 characters.",
                        maxlength: "User name should not exceed 30 characters."
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
                    document.loancategories.submit();
                },
                errorClass: "error_msg",
                errorElement: "div"
            });

        });
    </script>

    @include('partials.list_errors')
    {!! Form::open([
        'route' => ['loancategories.update', $model->id],
        'id' => 'loancategories',
        'name' => 'loancategories',
        'method' => 'PUT',
    ]) !!}
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
                                {!! Form::text('loan_title', $model->title, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('status', 'Status') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::select('status', $status, $model->status, [
                                    'placeholder' => 'Select Status',
                                    'class' => 'form-control',
                                ]) !!}
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
