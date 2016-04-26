@extends('layout.public')

@section('title', 'Istunto vanhentunut')

@section('content')
	<div class="big-error">
		<h1>Istunto vanhentunut</h1>
		<p>
			Päivitä sivu ja yritä uudelleen.
		</p>
		<p>
			<a href="{{ \URL::previous() }}">Palaa takaisin</a>
		</p>
	</div>
@endsection