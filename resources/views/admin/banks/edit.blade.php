@extends('layouts.admin.admin_template')

@section('content')
    <script src="{{ asset('js/jquery-validation/dist/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function() {
            // validate form on keyup and submit
            $("#bankform").validate({
                rules: {
                    bank_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 60
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    bank_name: {
                        required: "Please enter bank ",
                        alpha: "Please enter the bank in alphabets.",
                        minlength: "Bank must consist of at least 2 characters.",
                        maxlength: "Bank should not exceed 60 characters."
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
                    document.bankform.submit();
                },
                errorClass: "error_msg",
                errorElement: "div"
            });


        });
    </script>
    @include('partials.list_errors')
    {!! Form::open([
        'route' => ['banks.update', $model->id],
        'id' => 'bankform',
        'name' => 'bankform',
        'method' => 'PUT',
    ]) !!}
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->

                <div class="box-body">
                    <div class="col-md-2 pull-right">
                        <a title="Manage Banks" href="{{ url('/admin/banks') }}"><i
                                class="btn btn-block btn-info pull-right back_button">Manage Banks</i></a>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('bank_name', 'Bank Name') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('bank_name', $model->bank_name, ['class' => 'form-control']) !!}
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
