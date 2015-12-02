@extends('layout')

@section('content')

	<h1>Kurssit</h1>
	<p>
		Alla lista tarjolla olevista kursseista.
	</p>
	<div class="list">
		@foreach($courses as $course)
			<div class="course list-item">
				<div class="title">
					<a href="/course/{{ $course->id }}" class="title-anchor">
						{{ $course->title }}
					</a>
				</div>
				<div class="description">
					{!! nl2br($course->description) !!}
				</div>
			</div>
		@endforeach
	</div>

@endsection