@extends('layout.public')

@section('title', 'Ei käyttöoikeutta')

@section('content')
	<div class="big-error">
		<h1>Ei käyttöoikeutta</h1>
		<p>
			Sinulla ei ole käyttöoikeutta tälle sivulle.
		</p>
		<p>
			<a href="/">Palaa etusivulle</a>
		</p>
	</div>
@endsection