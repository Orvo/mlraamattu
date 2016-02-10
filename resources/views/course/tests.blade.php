@extends('layout')

@section('content')
	
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
	
	@if(!Auth::check())
		<div class="alert alert-info login-note">
			<p>
				Jos olet jo rekisteröitynyt, <a href="/auth/login">kirjaudu sisään</a> jatkaaksesi siitä mihin jäit.
			</p>
			<p>
				Rekisteröityminen tapahtuu ensimmäisen kokeen vastaamisen yhteydessä.
			</p>
		</div>
	@endif
	
	<div class="list">
		@foreach($course->tests as $test)
			<?php if($test->questions->count() == 0): continue; endif;?>
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
					@if($test->hasFeedback())
						<div class="alert alert-success alert-icon alert-icon-small">
							<span class="glyphicon glyphicon-ok-sign"></span>
							<div>
								Olet vastaanottanut koepalautetta tämän kokeen suorittamisesta.
							</div>
							<div class="clearfix"></div>
						</div>
					@endif
				</div>
			</div>
		@endforeach
	</div>

@endsection