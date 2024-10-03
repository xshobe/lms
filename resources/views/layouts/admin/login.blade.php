<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ \Config::get('constants.app_name') }} | {{ $page_title }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('admin_panel/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin_panel/dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->

    <link rel="stylesheet" href="{{ asset('admin_panel/plugins/iCheck/square/blue.css') }}">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <![endif]-->


</head>

<body class="hold-transition login-page">
    @yield('content')

    <!-- jQuery 2.1.4 -->
    <script src="{{ asset('admin_panel/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ asset('admin_panel/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin_panel/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/jquery-validation/dist/jquery.validate.js') }}"></script>

    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
            // validate form on keyup and submit
            $("#userloginform").validate({
                rules: {

                    user_name: {
                        required: true

                    },
                    password: {
                        required: true

                    }
                },
                messages: {

                    user_name: {
                        required: "Please enter user name."

                    },
                    password: {
                        required: "Please enter password."

                    },
                    debug: true
                },
                errorPlacement: function(error, element) {
                    error.fadeIn(600).appendTo(element.parent());
                },
                submitHandler: function() {
                    document.userloginform.submit();
                },
                errorClass: "error_msg",
                errorElement: "div"
            });

            $("#forgotpasswordform").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email address.",
                        email: "Please enter a valid email address."
                    },
                    debug: true
                },
                errorPlacement: function(error, element) {
                    error.fadeIn(600).appendTo(element.parent());
                },
                submitHandler: function() {
                    document.userloginform.submit();
                },
                errorClass: "error_msg",
                errorElement: "div"
            });
            $("#resetform").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6

                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email address.",
                        email: "Please enter a valid email address."
                    },
                    password: {
                        required: "Please enter password.",
                        minlength: "Password name must consist of at least 6 characters.",

                    },
                    password_confirmation: {
                        required: "Please enter confirm password.",
                        equalTo: "Please enter confirm password same as password.",
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
    </script>
</body>

</html>
