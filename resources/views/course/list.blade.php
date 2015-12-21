@extends('layout')

@section('content')

	<h1>Kurssit</h1>
	<p>
		Alla lista tarjolla olevista kursseista.
	</p>
	
	<div class="list">
		@foreach($courses as $course)
			<?php if($course->tests->count() == 0): continue; endif;?>
			<div class="course list-item">
				<div class="title">
					<a href="/course/{{ $course->id }}" class="title-anchor">
						{{ $course->title }}
						<div class="status {{
							css([
								'completed'		=> $course->courseProgress()->completed,
								'in-progress'	=> !$course->courseProgress()->completed && $course->courseProgress()->num_completed > 0,
							])
						}}">
							@if($course->courseProgress()->completed)
								<span class="glyphicon glyphicon-ok-circle"></span>
								<p>Suoritettu</p>
							@elseif(!$course->courseProgress()->completed && $course->courseProgress()->num_completed > 0)
								<span class="glyphicon glyphicon-remove-circle"></span>
								<p>Kesken ({{ @$course->courseProgress()->num_completed }}/{{ @$course->courseProgress()->total }} suoritettu)</p>
							@endif
						</div>
					</a>
				</div>
				<div class="description">
					{!! nl2br($course->description) !!}
				</div>
			</div>
		@endforeach
	</div>

@endsection