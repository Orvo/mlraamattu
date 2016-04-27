@extends('layout.public')

@section('title', 'Kirjekurssi tilattu')

@section('content')
	<div class="big-info">
		<h2>Kirjekurssin tilaus onnistui</h2>
		
		<p>
			Kiitos! Olet tilannut kirjekurssin <b>{{ $data['course'] }}</b>. Lähetämme sen muutaman työpäivän kuluessa.
		</p>
		
		<p>
			<a href="/mailcourse">Palaa takaisin tilaussivulle</a>
		</p>
	</div>

@endsection