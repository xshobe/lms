@extends('layouts.front.front_template')

@section('content')
<section class="contentarea">
	<div class="row">
		@include('partials.flash_success_msg')
		@include('partials.list_errors')
		{!! Form::open(array('url'=>'profile','id'=>'userprofileupdateform','autocomplete'=>'off')) !!}
		<div class="innerpad">
			<div class="user-profile-edit-container">
				<h3><span>{{ $user_data->user_name .'&#39;s Profile' }}</span></h3>
				<ul class="col4">
					<li>
						{{ Form::label('email', 'Email') }}
						<font>*</font>
						{{ Form::text('email',$user_data->email,['class'=>'validate[required,custom[email]]','id'=>'email']) }}
					</li>
					<li>
						{{ Form::label('contact', 'Contact') }}
						{{ Form::text('contact',$user_data->contact,['id'=>'contact']) }}
					</li>
					<li>
						{{ Form::label('mobile', 'Mobile') }}
						{{ Form::text('mobile',$user_data->mobile,['class'=>'validate[custom[onlyNumber]]','id'=>'mobile']) }}
					</li>
					<li>
						{{ Form::label('account_no', 'Account No') }}
						<font>*</font>
						{{ Form::text('account_no',$user_data->account_no,['class'=>'validate[required,custom[onlyNumber]]','id'=>'account_no']) }}
					</li>
					<li>
						{{ Form::label('beneficiary', 'Beneficiary') }}
						<font>*</font>
						{{ Form::text('beneficiary',$user_data->beneficiary,['class'=>'validate[required]','id'=>'beneficiary']) }}
					</li>
				</ul>
			</div>
		</div><!-- /.innerpad -->
		<div class="btndiv">
			{{ Form::submit('Update') }}
		</div><!-- /.btndiv -->
		{!! Form::close() !!}
	</div><!-- /.row -->
</section><!-- /.contentarea -->
<link rel="stylesheet" type="text/css" href="{!! asset('public/css/validationEngine.jquery.css') !!}" />
<script type="text/javascript" charset="utf-8" src="{!! asset('public/js/jquery.validationEngine-en.js') !!}"></script>
<script type="text/javascript" charset="utf-8" src="{!! asset('public/js/jquery.validationEngine.js') !!}"></script>
<script>
$(document).ready(function(){
	$("#userprofileupdateform").validationEngine('attach', {
		promptPosition:"topLeft",
		showOneMessage:true,
		'custom_error_messages' : {
			'#email' : {
				'required' : {
					'message': "The email field is required."
				}
			},
			'#mobile' : {
				'custom[onlyNumber]' : {
					'message': "The mobile must be number."
				}
			},
			'#account_no' : {
				'required' : {
					'message': "The account number field is required."
				},
				'custom[onlyNumber]' : {
					'message': "The account number must be number."
				}
			},
			'#beneficiary' : {
				'required' : {
					'message': "The beneficiary field is required."
				}
			}
		}
	});
});
</script>
@endsection