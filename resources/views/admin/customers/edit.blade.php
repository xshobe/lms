@extends('layouts.admin.admin_template')

@section('content')
    @include('partials.list_errors')
    {!! Form::open([
        'route' => ['customers.update', $model->id],
        'id' => 'edit-customer',
        'autocomplete' => 'off',
        'files' => true,
        'method' => 'PUT',
    ]) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">&nbsp;</h3>
            <div class="box-tools pull-right">
                <a href="{!! url('admin/customers') !!}" class="btn btn-box-tool" title="Manage Members">Manage Members</a>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('customer_category', 'Member Category') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::select('customer_category', $model->customer_types, $model->customer_category_id, [
                                    'placeholder' => 'Select Member Category',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('', 'TPF No') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('', $model->tpf_number) !!}
                                {!! Form::hidden('tpf_number', $model->tpf_number, ['class' => 'tpf_number']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('first_name', 'First Name') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('first_name', $model->first_name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('last_name', 'Last Name') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('last_name', $model->last_name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('job_title', 'Job Title') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('job_title', $model->job_title, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('ministry', 'Ministry') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('ministry', $model->ministry, ['class' => 'form-control ministry']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="school-container" style="display:none;">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('school', 'School') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('school', $model->school, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('salary_level', 'Salary Level') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::select('salary_level', $model->SalaryLevel, $model->salary_level, [
                                    'placeholder' => 'Select Salary Level',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('email', 'Email') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::email('email', $model->email, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('gender', 'Gender') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::select('gender', $gender_array, $model->gender, [
                                    'placeholder' => 'Select Gender',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('dob', 'DOB') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('dob', $model->dob != '' ? getFormattedDate($model->dob) : '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'dd/mm/yyyy',
                                    'onblur' => 'getCurrentAge(this)',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('current_age', 'Current Age') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('current_age', $model->current_age, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('mobile', 'Mobile') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('mobile', $model->mobile, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('contact', 'Address') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('contact', $model->contact, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('width_date', 'Withdrawal Date') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('width_date', $model->width_date != '' ? getFormattedDate($model->width_date) : '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'dd/mm/yyyy',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('bank_type', 'Select Bank') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::select('bank_type', $model->banks, $model->bank_id, [
                                    'placeholder' => 'Select Bank',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('account_no', 'Account No') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('account_no', $model->account_no, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('retirement_date', 'Date of Retirement') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text(
                                    'retirement_date',
                                    $model->retirement_date != '' ? getFormattedDate($model->retirement_date) : '',
                                    ['class' => 'form-control', 'readonly' => 'readonly', 'placeholder' => 'dd/mm/yyyy'],
                                ) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('status', 'Status') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::select('status', $status, $model->status, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->
                <div class="col-md-2">
                    <img width="100%" src="{!! getProfileImageUrl($model) !!}" />
                    <div class="form-group">
                        {!! Form::file('profile_image') !!}
                    </div>
                </div>
            </div>
            <div class="row">

                <?php $i = 1; ?>
                @forelse ($beneficiaries as $row)
                    <div class="existing-nominee">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('beneficiary', 'Nominated Beneficiaries/ Dependant for claims') !!}
                                {!! Form::text('beneficiary[]', $row->beneficiary, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('relationship', 'Relationship') !!}
                                {!! Form::text('relationship[]', $row->relationship, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('portion', 'Portion %') !!}
                                {!! Form::text('portion[]', $row->portion, ['class' => 'form-control']) !!}
                                <?php if($i != 1):?>
                                <button type="button" class="btn btn-box-tool remove-exist-nominee"><i
                                        class="fa fa-minus"></i> Remove Beneficiary</button>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <?php $i++; ?>
                @empty
                @endforelse

                <div id="more-nominee"></div>
                <div class="col-md-12" style="text-align:right">
                    <button type="button" class="btn btn-box-tool add-nominee"><i class="fa fa-plus"></i> Add
                        Beneficiary</button>
                    <button type="button" class="btn btn-box-tool remove-nominee"><i class="fa fa-minus"></i> Remove
                        Beneficiary</button>
                </div>
            </div><!-- /.row -->
        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="pull-right"><button type="submit" class="btn btn-primary">Submit</button></div>
        </div>
    </div>
    {!! Form::close() !!}
    <script src="{!! asset('js/jquery-validation/dist/jquery.validate.js') !!}"></script>
    <script src="{!! asset('js/jquery-validation/dist/additional-methods.min.js') !!}"></script>
    <script src="{!! asset('admin_panel/plugins/input-mask/jquery.inputmask.js') !!}"></script>
    <script src="{!! asset('admin_panel/plugins/input-mask/jquery.inputmask.date.extensions.js') !!}"></script>
    <script src="{!! asset('admin_panel/plugins/input-mask/jquery.inputmask.extensions.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery.validator.addMethod("check_tpf_number", function(value, element, param) {
                var option = $("" + param + " option:selected").text().toLowerCase();
                var myval = $('.tpf_number').val().toString().charAt(0);
                switch (option) {
                    case 'police':
                        return this.optional(element) || (myval == 3);
                        break;
                    case 'teachers':
                        return this.optional(element) || (myval == 2);
                        break;
                    case 'established':
                        return this.optional(element) || (myval == 1);
                        break;
                    case 'non-establised':
                        return this.optional(element) || (myval == 7);
                        break;
                    default:
                        return true;
                        break;
                }
            }, "Please provide correct series of TPF number.");

            jQuery.validator.addMethod("check_dob", function(value, element, param) {
                if (value != '') {
                    var dobSegments = value.split('/');
                    var myDate = dobSegments[1] + '/' + dobSegments[0] + '/' + dobSegments[2];
                    if (jQuery.isNumeric(dobSegments[0]) && jQuery.isNumeric(dobSegments[1]) && jQuery
                        .isNumeric(dobSegments[2])) {
                        var age = getAge(myDate);
                        if (age > 0) {
                            $('#current_age').val(age);
                            setRetirementDate(myDate);
                            return true;
                        } else {
                            $('#current_age').val('');
                            return false;
                        }
                    }
                } else {
                    $('#current_age').val('');
                    return true;
                }
            }, "Either dob is not correct format (or) must be lesser than today date.");

            jQuery.validator.addMethod("check_widthdraw", function(value, element, param) {
                if (value != '') {
                    var widthdraw = value.split('/');
                    if (jQuery.isNumeric(widthdraw[0]) && jQuery.isNumeric(widthdraw[1]) && jQuery
                        .isNumeric(widthdraw[2])) {
                        var today = new Date();
                        var myDate = widthdraw[1] + '/' + widthdraw[0] + '/' + widthdraw[2];
                        var inputDate = new Date(myDate);
                        return (today.getTime() < inputDate.getTime());
                    }
                } else {
                    return true;
                }
            }, "Either withdrawal date is not correct format (or) must be future date.");

            jQuery.validator.addMethod("check_retirement", function(value, element, param) {
                if (value != '') {
                    var retirement = value.split('/');
                    if (jQuery.isNumeric(retirement[0]) && jQuery.isNumeric(retirement[1]) && jQuery
                        .isNumeric(retirement[2])) {
                        var today = new Date();
                        return (today.getFullYear() < retirement[2]);
                    }
                } else {
                    return true;
                }
            }, "Either retirement date is not correct format (or) must be future date.");

            // validate form on keyup and submit
            $("#edit-customer").validate({
                rules: {
                    customer_category: {
                        required: true,
                        check_tpf_number: "#customer_category"
                    },
                    salary_level: {
                        required: true
                    },
                    first_name: {
                        required: true,
                        alpha: true
                    },
                    last_name: {
                        required: true,
                        alpha: true
                    },
                    email: {
                        email: true
                    },
                    dob: {
                        required: true,
                        check_dob: true
                    },
                    mobile: {
                        number: true
                    },
                    width_date: {
                        check_widthdraw: true
                    },
                    bank_type: {
                        required: true
                    },
                    account_no: {
                        required: true,
                        number: true
                    },
                    retirement_date: {
                        check_retirement: true
                    },
                    "beneficiary[]": {
                        required: true
                    },
                    "relationship[]": {
                        required: true
                    },
                    "portion[]": {
                        required: true,
                        number: true,
                        max: 100
                    },
                    profile_image: {
                        extension: "jpg|jpeg|png"
                    }
                },
                messages: {
                    customer_category: {
                        required: "Please select member category.",
                        check_tpf_number: "Please provide correct series of TPF number."
                    },
                    salary_level: {
                        required: "Please select salary level."
                    },
                    first_name: {
                        required: "Please enter first name.",
                        alpha: "Please enter the first name in alphabets."
                    },
                    last_name: {
                        required: "Please enter last name.",
                        alpha: "Please enter the last name in alphabets."
                    },
                    email: {
                        email: "Please enter a valid email address."
                    },
                    dob: {
                        required: "Please enter DOB."
                    },
                    mobile: {
                        number: "Please enter mobile number as numeric."
                    },
                    bank_type: {
                        required: "Please select bank.",
                    },
                    account_no: {
                        required: "Please enter account number."
                    },
                    "beneficiary[]": {
                        required: "Please enter beneficiary."
                    },
                    "relationship[]": {
                        required: "Please enter relationship."
                    },
                    "portion[]": {
                        required: "Please enter portion."
                    },
                    profile_image: {
                        extension: "Please choose valid file type(jpg, jpeg (or) png)."
                    }
                },
                errorPlacement: function(error, element) {
                    error.fadeIn(600).appendTo(element.parent());
                },
                submitHandler: function(form) {
                    form.submit();
                },
                errorClass: "error_msg",
                errorElement: "div"
            });
            $("#dob,#width_date").inputmask("dd/mm/yyyy", {
                "placeholder": "dd/mm/yyyy"
            });
            $('#customer_category').trigger('change');
        });

        function getAge(dateString) {
            var today = new Date();
            var birthDate = new Date(dateString);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }

        function setRetirementDate(dateString) {
            var retirementDate = new Date(dateString);
            retirementDate.setYear(retirementDate.getFullYear() + 65);
            var day = ("0" + retirementDate.getDate()).slice(-2);
            var month = ("0" + (retirementDate.getMonth() + 1)).slice(-2);
            var today = (day) + '/' + (month) + '/' + retirementDate.getFullYear();
            $('#retirement_date').val(today);
        }
        $(document).on('click', '.add-nominee', function() {
            $('#more-nominee').append(
                '<div class="block"><div class="col-md-4"><div class="form-group"><label for="beneficiary">Nominated Beneficiaries/ Dependant for claims</label><input class="form-control" name="beneficiary[]" type="text"></div></div><div class="col-md-4"><div class="form-group"><label for="relationship">Relationship</label><input class="form-control" name="relationship[]" type="text"></div></div><div class="col-md-4"><div class="form-group"><label for="portion">Portion %</label><input class="form-control" name="portion[]" type="text"></div></div></div>'
                );
        });
        $(document).on('click', '.remove-nominee', function() {
            $('#more-nominee .block').last().remove();
        });
        $(document).on('click', '.remove-exist-nominee', function() {
            $(this).closest('.existing-nominee').remove();
        });
        $(document).on('change', '#customer_category', function() {
            if ($(this).val() == '3') {
                $('#school-container').show();
            } else {
                $('#school-container').hide();
            }
        });
    </script>
@endsection
