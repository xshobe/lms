@extends('layouts.front.front_template')

@section('content')
<section class="innerbanner">
	<div class="row">
		<h1>{!! $page_title !!}</h1>
		<p>tempor incididunt ut labore et dolore magna aliqua</p>
	</div>
</section><!-- /.innerbanner -->
<section class="contentarea">
	<div class="row">
		<img src="{!! asset('public/images/coming-soon.jpg') !!}" alt="Coming soon" />
	</div>
</section><!-- /.contentarea -->
@endsection