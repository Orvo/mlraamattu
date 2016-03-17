@extends('layout.popup')

@section('title', 'Opintomateriaali - ' . $test->title)

@section('content')
	<div class="centered-titles">
		<h2>Opintomateriaali</h2>
		<h3>
			<div class="line"></div>
			<div class="text">
				<span>{{ $test->title }}</span>
			</div>
		</h3>
		<div class="clearfix"></div>
	</div>
	
	<div class="test-material-body">
		{!! $test->page->body !!}
	</div>
	
	<div style="padding-top:1em">
		<button type="button" class="btn btn-primary btn-block window-close">
			<span class="glyphicon glyphicon-remove"></span> Sulje ikkuna
		</button>
	</div>
@endsection