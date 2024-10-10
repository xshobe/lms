@extends('layouts.admin.admin_template')

@section('content')
    @include('partials.confirm_approve_modal')
    {!! Form::open([
        'url' => 'admin/import/credit-loan',
        'id' => 'upload-form',
        'autocomplete' => 'off',
        'files' => true,
    ]) !!}
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">&nbsp;</h3>
                    <div class="box-tools pull-right">
                        <a href="{!! url('download/sample-credit-loan-import-file') !!}"><button type="button" class="btn btn-sm btn-primary">Sample
                                File</button></a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('quarter', 'Quarter') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::select('quarter', $quarter, null, ['placeholder' => 'Select Quarter', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('file', 'Choose File') !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::file('file') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <!-- detailed report starts here -->
    <div class="row">
        <div class="col-xs-12 ml-3">
            <div id="output-display"></div>
        </div>
    </div>
    <!-- detailed report ends here -->

    <script src="{!! asset('js/jquery-validation/dist/jquery.validate.js') !!}"></script>
    <script src="{!! asset('js/jquery-validation/dist/additional-methods.min.js') !!}"></script>
    <script src="{!! asset('public/js/jquery.form.min.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var options = {
                beforeSubmit: showLoader,
                success: showResponse,
                clearForm: true
            };
            // validate form on keyup and submit
            $("#upload-form").validate({
                rules: {
                    quarter: {
                        required: true
                    },
                    file: {
                        required: true,
                        extension: "xls|xlsx|ods"
                    }
                },
                messages: {
                    quarter: {
                        required: "Please select quarter."
                    },
                    file: {
                        required: "Please choose file for import.",
                        extension: "Please choose valid file type(xls (or) xlsx)."
                    },
                    debug: true
                },
                errorPlacement: function(error, element) {
                    error.fadeIn(600).appendTo(element.parent());
                },
                submitHandler: function() {
                    $('#confirm-approve').modal('show').on('show.bs.modal', function(e) {
                        var form = $(e.relatedTarget).closest('form');
                        $(this).find('.modal-footer #confirm').data('form', form);
                    });
                    $('#confirm-approve .content_msg').html(
                        'You are about to upload a payment list. <br>Before upload please verify entire list.<br><b>Important:</b> This action can\'t be undone.'
                    );
                    $('#confirm-approve .modal-title').html(
                        '<i class="icon fa fa-warning text-yellow"></i> Attention');
                },
                errorClass: "error_msg",
                errorElement: "div"
            });
            $('#confirm-approve').find('.modal-footer #confirm').on('click', function() {
                $('#confirm-approve').modal('hide');
                $("#upload-form").ajaxSubmit(options);
            });
        });

        function showLoader() {
            $('#output-display').html(
                "<p>This might take some amount of time to process based on the payment list. Please be patient...</p>");
        }

        function showResponse(responseText, statusText, xhr, $form) {
            $('#output-display').fadeIn('slow', function() {
                $(this).html(responseText);
            });
        }
    </script>
@endsection
