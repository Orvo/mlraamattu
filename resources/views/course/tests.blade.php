@extends('layout')

@section('content')

	<a href="/" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Takaisin pääsivulle</a>
	
	<h1>Kurssi: {{ $course->title }}</h1>
	<div>
		{!! nl2br($course->description) !!}
	</div>
	<p>
		Alla lista kokeista joita valitsemallasi kurssilta löytyy.
	</p>
	<div class="list">
		@foreach($course->tests as $test)
			<div class="test list-item">
				<div class="title">
					<a href="/test/{{ $test->id }}">
						{{ $test->title }}
					</a>
				</div>
				<div class="description">
					{!! nl2br($test->description) !!}
				</div>
			</div>
		@endforeach
	</div>

@endsection