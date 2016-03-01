@extends('layout.main')

@section('title')
	Kurssit
@endsection

@section('sidebar_content')
	<p>
		Aloita tai jatka kurssien suorittamista valitsemalla jokin tarjolla olevista kursseistamme.
	</p>
	<p>
		Voit päästä alkuun nopeasti klikkaamalla <b>Aloita ensimmäisestä kokeesta</b> -painiketta. Jos olet jo aloittanut kurssin niin pääset nopeasti jatkamaan sitä <b>Jatka kurssia</b> -painikkeella.
	</p>
	@if(!Auth::check())
		<hr>
		<p>
			Jos sinulla ei ole vielä tunnusta niin ei hätää!
		</p>
		<p>
			Voit luoda uuden käyttäjätunnuksen suorittaessasi ensimmäistä koetta. Koesivun lopussa voit syöttää tietosi ja järjestelmä tallentaa siitä lähtien koesuorituksesi muistiin.
		</p>
	@endif
@endsection

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