@extends('layouts.admin.admin_template')

@section('content')
    <script src="{{ asset('js/jquery-validation/dist/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function() {
            // validate form on keyup and submit
            $("#salary_form").validate({
                rules: {
                    salary_start: {
                        required: true,
                        alpha_numeric: true,
                        maxlength: 30
                    },
                    salary_end: {
                        required: true,
                        alpha_numeric: true,
                        maxlength: 30,
                        greaterThan: "#salary_start"
                    },
                    eligibility: {
                        required: true,
                        digits: true

                    },
                    interest: {
                        required: true,
                        digits: true

                    },
                    // interest_amount: {
                    //   required:true,
                    //   number:true

                    // },
                    // total_to_be_repaid: {
                    //   required:true
                    // },
                    status: {
                        required: true
                    }
                },
                messages: {

                    salary_start: {
                        required: "Please enter salary range start.",
                        alpha_numeric: "Please enter the user name in alpha numeric.",
                        maxlength: "User name should not exceed 30 characters."
                    },
                    salary_end: {
                        required: "Please enter salary range end.",
                        alpha_numeric: "Please enter the user name in alpha numeric.",
                        maxlength: "User name should not exceed 30 characters."
                    },
                    eligibility: {
                        required: "Please enter eligibility.",
                        digits: "Please enter the eligibility in number."
                    },
                    interest: {
                        required: "Please enter interest.",
                        digits: "Please enter the interest in number."
                    },
                    // ,
                    // interest_amount: {
                    //   required:"Please enter interest amount."

                    // },
                    // total_to_be_repaid: {
                    //   required:"Please enter total."
                    // },
                    status: {
                        required: "Please select status."
                    },
                    debug: true
                },
                errorPlacement: function(error, element) {
                    error.fadeIn(600).appendTo(element.parent());
                },
                submitHandler: function() {
                    document.salary_form.submit();
                },
                errorClass: "error_msg",
                errorElement: "div"
            });

            $.validator.addMethod("greaterThan", function(value, element, params) {

                if (!/Invalid|NaN/.test(parseInt(value))) {
                    return parseInt(value) > parseInt($(params).val());
                }

                return isNaN(value) && isNaN($(params).val()) ||
                    (Number(value) > Number($(params).val()));
            }, 'Must be greater than salary start .');

        });

        function calculate_interest() {

            var eligibility = $('#eligibility').val();
            var interest = $('#interest').val();
            var interest_amount = '';
            var total = '';

            if (eligibility != '' && interest != '') {
                if (!isNaN(eligibility) && !isNaN(interest)) {
                    interest_amount = (parseInt(eligibility) * parseInt(interest)) / 100;
                    total = parseInt(eligibility) + parseInt(interest_amount);

                    $('#interest_amount').val(interest_amount);
                    $('#total_to_be_repaid').val(total);
                } else {
                    $('#interest_amount').val('');
                    $('#total_to_be_repaid').val('');
                }
            } else {
                $('#interest_amount').val('');
                $('#total_to_be_repaid').val('');
            }
        }
    </script>
    @include('partials.list_errors')
    {!! Form::open(['route' => ['salarylevels.store'], 'id' => 'salary_form', 'name' => 'salary_form']) !!}
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->

                <div class="box-body">
                    <div class="col-md-2 pull-right">
                        <a title="Manage Salary Level" href="{{ url('/admin/salarylevels') }}"><i
                                class="btn btn-block btn-info pull-right back_button">Manage Salary Level</i></a>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('salary_start', 'Salary start range') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('salary_start', '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('salary_end', 'Salary end range') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('salary_end', '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('eligibility', 'Eligibility') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('eligibility', '', ['class' => 'form-control', 'onkeyup' => 'calculate_interest()']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('interest', 'Interest') !!} (%)
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('interest', '', ['class' => 'form-control', 'onkeyup' => 'calculate_interest()']) !!}
                                {!! Form::hidden('interest_amount', '', [
                                    'id' => 'interest_amount',
                                    'class' => 'form-control',
                                    'readonly' => '',
                                ]) !!}
                                {!! Form::hidden('total_to_be_repaid', '', [
                                    'id' => 'total_to_be_repaid',
                                    'class' => 'form-control',
                                    'readonly' => '',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <div class="row">
                          <div class="col-md-3">
                          {!! Form::label('interest_amount', 'Interest amount') !!}
                           </div>
                          <div class="col-md-3">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-3">
                          {!! Form::label('total_to_be_repaid', 'Total to be repaid') !!}
                           </div>
                          <div class="col-md-3">
                          </div>
                        </div>
                      </div>-->
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
