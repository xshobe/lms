@extends('layouts.admin.admin_template')

@section('content')
    <style>
        .dash-pad {
            position: relative;
            text-align: center;
            left: 0;
        }

        .dash-down {
            left: 33%;
        }
    </style>
    <div class="row">
        <div class="dash-pad">
            <h2>SIPEU</h2>
            <p>Public Employees Management Information Systems</p>
        </div>
        <div class="dash-down">
            <ul>
                <li>*Save Regularly*</li>
                <li>*Borrow Wisely*</li>
                <li>*Repay Promptly*</li>
            </ul>
        </div>

    </div><!-- /.row -->
@endsection
