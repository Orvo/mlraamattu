@extends('layout.public')

@section('content', $page->body)

@if($page->id == 1)
	@section('sidebar_content')
		<p>
			Aloita tai jatka kurssien suorittamista valitsemalla jokin tarjolla olevista kursseistamme <a href="/course">kurssit</a>-sivulta.
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
				Jos seuraat johdettua kurssiopetusta opettajan kanssa sinulla voi olla ryhmäkoodi. Voit syöttää sen <a href="/groups/manage">täällä</a>.
			</p>
		@endif
	@endsection
@endif