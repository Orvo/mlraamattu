@extends('layout')

@section('extra_navigation')
	<li>
		<a href="/course/{{ $test->course->id }}">
			{{ $test->course->title }}
		</a>
	</li>
@endsection

@section('content')
	<h1>Koemateriaali: {{ $test->title }}</h1>
	<div class="test-material-body">
		{!! $test->page->body !!}
	</div>
	<hr>
	<div>
		<a href="/test/{{ $test->id }}" class="btn btn-primary btn-block">
			Jatka kokeen suorittamiseen <span class="glyphicon glyphicon-chevron-right"></span>
		</a>
	</div>
@endsection