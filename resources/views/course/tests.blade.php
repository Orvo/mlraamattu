@extends('layout')

@section('content')

	<a href="/" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Takaisin pääsivulle</a>
	
	<h1>Kurssi: {{ $course->title }}</h1>
	<div class="course-description">
		{!! nl2br($course->description) !!}
	</div>
	
	@if(session('error'))
		<div class="error-block">
			<p>{!! session('error') !!}</p>
			Jos olet jo edennyt kurssissa, <a href="/auth/login">kirjaudu sisään</a> ja yritä uudelleen!
		</div>
	@endif
	
	<div class="list">
		@foreach($course->tests as $test)
			<div class="test list-item">
				<div class="title">
					@if($test->isUnlocked())
						<a href="/test/{{ $test->id }}" class="title-anchor">
					@else
						<span class="title-anchor">
					@endif
					
					{{ $test->title }}
					<div class="status {{
						css([
							'locked' 		=> !$test->isUnlocked(),
							'completed'		=> (@$user_completed[$test->id] && $user_completed[$test->id]->all_correct),
							'in-progress'	=> (@$user_completed[$test->id] && !$user_completed[$test->id]->all_correct),
							'new-test'		=> ($test->isUnlocked() && !@$user_completed[$test->id]),
						])
					}}">
						@if(@$user_completed[$test->id] && $user_completed[$test->id]->all_correct)
							<span class="glyphicon glyphicon-ok-circle"></span>
							<p>Suoritettu</p>
						@elseif(@$user_completed[$test->id])
							<span class="glyphicon glyphicon-remove-circle"></span>
							<p>Kesken ({{ @$user_completed[$test->id]->num_correct }}/{{ @$user_completed[$test->id]->total }} oikein)</p>
						@elseif(!$test->isUnlocked())
							<span class="glyphicon glyphicon-lock"></span>
							<p>Lukittu</p>
						@else
							<span class="glyphicon glyphicon-star"></span>
							<p>Suorittamaton</p>
						@endif
					</div>
						
					@if($test->isUnlocked())
						</a>
					@else
						</span>
					@endif
				</div>
				<div class="description">
					{!! nl2br($test->description) !!}
				</div>
			</div>
		@endforeach
	</div>

@endsection