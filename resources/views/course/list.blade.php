@extends('layout.public')

@section('title', 'Kurssit')

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
	@else
		<hr>
		<p>
			Jos seuraat johdettua kurssiopetusta opettajan kanssa sinulla voi olla ryhmäkoodi. Voit syöttää sen <a href="/groups/join">täällä</a>.
		</p>
	@endif
@endsection

@section('content')
	@include('alerts.auth-related')
	
	@if(count($my_courses) > 0)
		<h3>Kurssini</h3>
		<p>
			Jatka kurssien suorittamista valitsemalla joku alla olevista kursseista.
		</p>
		
		<div class="list">
			@each('course.list-item', $my_courses, 'course')
		</div>
	@endif
	
	@if(count($available_courses) > 0)
		<h3>Tarjolla olevat kurssit</h3>
		<p>
			Alla kurssit joita et ole vielä suorittanut.
		</p>
		
		<div class="list">
			@each('course.list-item', $available_courses, 'course')
		</div>
	@endif
	
	@if((count($my_courses) + count($available_courses)) == 0)
		<h3>Ei tarjolla olevia kursseja</h3>
		<p>
			Valitettavasti yhtäkään kurssia ei löytynyt.
		</p>
	@endif

@endsection