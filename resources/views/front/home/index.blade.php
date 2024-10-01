@extends('layouts.front.home_template')

@section('content')
<section class="banner">
	<div class="row">
		@if (empty($user_data))
		<div class="formpad">
			<img class="padbg" src="{!! asset('public/images/loginpadbg.png') !!}" alt="">
			{!! Form::open(array('url'=>'do-login','id'=>'usersloginform','autocomplete'=>'off')) !!}
			@include('partials.list_errors')
			@include('partials.flash_error_msg')
			<table>
				<tr>
					<td><p>Username</p></td>
					<td>{{ Form::text('user_name','',['class'=>'validate[required]','id'=>'user_name']) }}</td>
				</tr>
				<tr>
					<td><p>Password</p></td>
					<td>{{ Form::password('password',['class'=>'validate[required]','id'=>'password']) }}</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						{!! app('captcha')->display(); !!}
						<p class="forgot">Reset your password? <a href="{!! url('forgot-password') !!}">Click here</a></p>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						{{ Form::submit('Login') }}<br>
						<a class="termslink" href="#">Terms of use, Privacy Policy & Disclaimer </a>
					</td>
				</tr>
			</table>
			{!! Form::close() !!}
		</div>
		@endif
	</div>
</section>
<section class="homecontentpad">
  <div class="row">
    <div class="latestnews">
      <h1>Latest News</h1>
      <div class="newscarousel">
        <div id="owl-demo" class="owl-carousel owl-theme">
          <div class="item"> <img src="{!! asset('public/images/news1.png') !!}" alt="" align=""/>
            <p>Contrary to popular belief, Lorem dummy Ipsum Also, if you're </p>
            <a href="#">Read More</a> </div>
          <div class="item"> <img src="{!! asset('public/images/news2.png') !!}" alt="" align=""/>
            <p>Contrary to popular belief, Lorem dummy Ipsum Also, if you're </p>
            <a href="#">Read More</a> </div>
          <div class="item"> <img src="{!! asset('public/images/news3.png') !!}" alt="" align=""/>
            <p>Contrary to popular belief, Lorem dummy Ipsum Also, if you're </p>
            <a href="#">Read More</a> </div>
          <div class="item"> <img src="{!! asset('public/images/news1.png') !!}" alt="" align=""/>
            <p>Contrary to popular belief, Lorem dummy Ipsum Also, if you're </p>
            <a href="#">Read More</a> </div>
          <div class="item"> <img src="{!! asset('public/images/news2.png') !!}" alt="" align=""/>
            <p>Contrary to popular belief, Lorem dummy Ipsum Also, if you're </p>
            <a href="#">Read More</a> </div>
          <div class="item"> <img src="{!! asset('public/images/news3.png') !!}" alt="" align=""/>
            <p>Contrary to popular belief, Lorem dummy Ipsum Also, if you're </p>
            <a href="#">Read More</a> </div>
        </div>
        <div class="customNavigation"> <a class="btn prev"><img align="" alt="" src="{!! asset('public/images/arrowleft.png') !!}"></a> <a class="btn next"><img align="" alt="" src="{!! asset('public/images/arrowright.png') !!}"></a> </div>
      </div>
    </div>
    <div class="addpad">
      <h2>FIND OUR LOCATION BELOW</h2>
      <ul>
        <li>Lorem ipsum dummy address<br>
          Street 123 , City, <br>
          Country - 605014.</li>
        <li>123-456-7890 / +123 345 567 7890</li>
        <li>123-456-7890 </li>
        <li><a href="mailto:info@sipec.com">info@sipec.com</a></li>
      </ul>
      <h2>Follow us now</h2>
      <p><a href="#"><img src="{!! asset('public/images/fb.png') !!}"></a><a href="#"><img src="{!! asset('public/images/twitter.png') !!}"></a><a href="#"><img src="{!! asset('public/images/googleplus.png') !!}"></a><a href="#"><img src="{!! asset('public/images/in.png') !!}"></a></p>
    </div>
    <div class="welcomepad">
      <div class="scince">
        <div>
          <p><span>The standard Lorem Ipsum</span> <font>since the 1500s</font></p>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
        </div>
      </div>
      <h1>Welcome to SIPEU</h1>
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley. Lorem Ipsum is simply 
        dummy text of the printing and typesetting. </p>
      <a href="#" class="orangebtn">Read more</a> </div>
  </div>
</section>
<link rel="stylesheet" type="text/css" href="{!! asset('public/css/validationEngine.jquery.css') !!}" />
<script type="text/javascript" charset="utf-8" src="{!! asset('public/js/jquery.validationEngine-en.js') !!}"></script>
<script type="text/javascript" charset="utf-8" src="{!! asset('public/js/jquery.validationEngine.js') !!}"></script>
<script type="text/javascript" src="{!! asset('public/js/owl.carousel.js') !!}"></script>
<script type="text/javascript">
$(document).ready(function(){
	var owl = $("#owl-demo");
	owl.owlCarousel({
		autoplay:true,
		items:3, //10 items above 1000px browser width
		itemsDesktop:[1023,2],
		itemsDesktopSmall:[980,2],
		itemsTablet:[768,2],
		itemsTabletSmall:false,
		itemsMobile:[639,1],
		pagination:false,
	});
	// Custom Navigation Events
	$(".next").click(function(){
		owl.trigger('owl.next');
	});
	$(".prev").click(function(){
		owl.trigger('owl.prev');
	});
	// Validation
	$("#usersloginform").validationEngine('attach', {
		promptPosition:"topLeft",
		showOneMessage:true,
		'custom_error_messages' : {
			'#user_name' : {
				'required' : {
					'message': "The username field is required."
				}
			},
			'#password' : {
				'required' : {
					'message': "The password field is required."
				}
			}
		}
	});
});
</script>
@endsection