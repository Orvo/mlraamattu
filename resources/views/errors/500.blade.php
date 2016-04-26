@extends('layout.public')

@section('title', 'Sisäinen järjestelmän virhe')

@section('content')
	<div class="big-error">
		<h1>Sisäinen järjestelmän virhe</h1>
		<p>
			Hups! Järjestelmä kohtasi virheen. Kokeile ladata sivu uudelleen tai palaa myöhemmin takaisin.
		</p>
		<p>
			<a href="{{ \URL::previous() }}">Palaa takaisin</a>
		</p>
	</div>
@endsection