@extends('layout')

@section('content')
	
	@if(!Auth::check())
		<div class="alert alert-info alert-icon login-note">
			<span class="glyphicon glyphicon-info-sign"></span>
			<div>
				<p>
					Jatkaaksesi siitä mihin jäit, <a href="/auth/login"><span class="ul">kirjaudu sisään</span> <span class="glyphicon glyphicon-log-in"></span></a>
				</p>
				<p>
					Jos et ole vielä rekisteröitynyt voit tehdä sen vastatessasi ensimmäiseen kokeeseen.
				</p>
			</div>
			<div class="clearfix"></div>
		</div>
	@endif
	
	@if(count($my_courses) > 0)
		<h3>Kurssini</h3>
		<p>
			Jatka kurssien suorittamista valitsemalla joku alla olevista kursseista.
		</p>
		
		<div class="list">
			@foreach($my_courses as $course)
				@include('course.list-item')
			@endforeach
		</div>
	@endif
	
	@if(count($available_courses) > 0)
		<h3>Tarjolla olevat kurssit</h3>
		<p>
			Alla kurssit joita et ole vielä suorittanut.
		</p>
		
		<div class="list">
			@foreach($available_courses as $course)
				@include('course.list-item')
			@endforeach
		</div>
	@endif

@endsection