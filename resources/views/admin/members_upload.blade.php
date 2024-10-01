@extends('layouts.admin.admin_template')

@section('content')
@include('partials.flash_success_msg')
@include('partials.list_errors')
{!! Form::open(array('url'=>'admin/import/members','id'=>'upload-form','autocomplete'=>'off','files'=>true)) !!}
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">&nbsp;</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('file','Choose File') !!}
                        </div>
                        <div class="col-md-3">
                        {!! Form::file('file') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection