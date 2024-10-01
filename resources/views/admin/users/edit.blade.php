@extends('layouts.admin.admin_template')

@section('content')
    <script src="{{ asset('js/jquery-validation/dist/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function() {
            // validate form on keyup and submit
            $("#userform").validate({
                rules: {
                    salutation: {
                        required: true
                    },
                    user_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    first_name: {
                        required: true,
                        alpha: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    last_name: {
                        required: true,
                        alpha: true,
                        maxlength: 30
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        //  required:true,
                        minlength: 6

                    },
                    mobile: {
                        number: true
                    },
                    role: {
                        required: true
                    },
                    city: {
                        alpha: true,
                        minlength: 2,
                        maxlength: 40
                    },
                    state: {
                        alpha: true,
                        minlength: 2,
                        maxlength: 40
                    },
                    country: {
                        alpha: true,
                        minlength: 2,
                        maxlength: 40
                    },
                    zip_code: {
                        number: true
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    salutation: {
                        required: "Please select salutation."
                    },
                    user_name: {
                        required: "Please enter user name.",
                        minlength: "User name must consist of at least 2 characters.",
                        maxlength: "User name should not exceed 30 characters."
                    },
                    first_name: {
                        required: "Please enter first name.",
                        alpha: "Please enter the first name in alphabets.",
                        minlength: "First name must consist of at least 2 characters.",
                        maxlength: "First name should not exceed 30 characters."
                    },
                    last_name: {
                        required: "Please enter last name.",
                        alpha: "Please enter the last name in alphabets.",
                        maxlength: "Last name should not exceed 30 characters."
                    },
                    email: {
                        required: "Please enter email address.",
                        email: "Please enter a valid email address."
                    },
                    password: {
                        // required:"Please enter password.",
                        minlength: "Password name must consist of at least 6 characters.",

                    },
                    mobile: {
                        number: "Please enter mobile number as numeric.",

                    },
                    role: {
                        required: "Please select roles."
                    },
                    city: {
                        alpha: "Please enter the city in alphabets.",
                        minlength: "City must consist of at least 2 characters.",
                        maxlength: "City should not exceed 40 characters."
                    },
                    state: {
                        alpha: "Please enter the state in alphabets.",
                        minlength: "State must consist of at least 2 characters.",
                        maxlength: "State should not exceed 40 characters."
                    },
                    country: {
                        alpha: "Please enter the country in alphabets.",
                        minlength: "Country must consist of at least 2 characters.",
                        maxlength: "Country should not exceed 40 characters."
                    },
                    zip_code: {
                        number: "Please enter zip code as numeric.",
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
                    document.userform.submit();
                },
                errorClass: "error_msg",
                errorElement: "div"
            });
            $('#show_password').click(function() {

                if ($(this).is(':checked') == true) {
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
                }
            });
            $(".getNewPass").click(function() {
                var field = $(this).closest('div').find('input[rel="gp"]');
                passwordStrength(randString(field));
                field.val(randString(field));
            });
        });

        function passwordStrength(password) {
            var desc = new Array();
            desc[0] = "Very Weak";
            desc[1] = "Weak";
            desc[2] = "Better";
            desc[3] = "Medium";
            desc[4] = "Strong";
            desc[5] = "Strongest";

            var score = 0;

            //if password bigger than 6 give 1 point
            if (password.length > 6) score++;

            //if password has both lower and uppercase characters give 1 point
            if ((password.match(/[a-z]/)) && (password.match(/[A-Z]/))) score++;

            //if password has at least one number give 1 point
            if (password.match(/\d+/)) score++;

            //if password has at least one special caracther give 1 point
            if (password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) score++;

            //if password bigger than 12 give another 1 point
            if (password.length > 12) score++;

            document.getElementById("passwordDescription").innerHTML = desc[score];
            document.getElementById("passwordStrength").className = "strength" + score;
        }


        function randString(id) {
            var dataSet = $(id).attr('data-character-set').split(',');
            var possible = '';
            if ($.inArray('a-z', dataSet) >= 0) {
                possible += 'abcdefghijklmnopqrstuvwxyz';
            }
            if ($.inArray('A-Z', dataSet) >= 0) {
                possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            }
            if ($.inArray('0-9', dataSet) >= 0) {
                possible += '0123456789';
            }
            if ($.inArray('#', dataSet) >= 0) {
                possible += '![]{}()%&*$#^<>~@|';
            }
            var text = '';
            for (var i = 0; i < $(id).attr('data-size'); i++) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            return text;
        }
    </script>

    @include('partials.list_errors')
    {!! Form::open([
        'route' => ['users.update', $model->user_id],
        'id' => 'userform',
        'name' => 'userform',
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
                        <a title="Manage Admin Users" href="{{ url('/admin/users') }}"><i
                                class="btn btn-block btn-info pull-right back_button">Manage Admin Users</i></a>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('role', 'Role') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::select('role', $model->roles, $model->role_id, [
                                    'placeholder' => 'Select Role',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('salutation', 'Salutation') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::select('salutation', $salutation_array, $model->salutation, [
                                    'placeholder' => 'Select Salutation',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('first_name', 'First Name') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('first_name', $model->first_name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('last_name', 'Last Name') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('last_name', $model->last_name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('email', 'Email') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::email('email', $model->email, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('user_name', 'User Name') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('user_name', $model->user_name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('password', 'Password') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::password('password', [
                                    'class' => 'form-control',
                                    'onkeyup' => 'passwordStrength(this.value)',
                                    'title' => "Please enter secure password eg:Unlock123$",
                                    'rel' => 'gp',
                                    'data-size' => '13',
                                    'data-character-set' => 'a-z,A-Z,0-9,#',
                                ]) !!}
                                <a href="javascript:void(0);" class="getNewPass">Generate random password</a><br>
                                <input type="checkbox" id="show_password"> show password
                            </div>
                            <div class="col-md-3">
                                <label for="passwordStrength">Password strength</label>
                                <div id="passwordDescription">Password not entered</div>
                                <div id="passwordStrength" class="strength0"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('mobile', 'Mobile') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('mobile', $model->mobile, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('address1', 'Address 1') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('address1', !empty($model->Address->address1) ? $model->Address->address1 : '', [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('address2', 'Address 2') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('address2', !empty($model->Address->address2) ? $model->Address->address2 : '', [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('city', 'City') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('city', !empty($model->Address->city) ? $model->Address->city : '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('state', 'State') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('state', !empty($model->Address->state) ? $model->Address->state : '', [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('country', 'Country') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('country', !empty($model->Address->country) ? $model->Address->country : '', [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('zip_code', 'Zip code') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('zip_code', !empty($model->Address->zip_code) ? $model->Address->zip_code : '', [
                                    'class' => 'form-control',
                                ]) !!}
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
