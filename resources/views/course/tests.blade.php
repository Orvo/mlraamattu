@extends('layout')

@section('content')
	
	<h1>Kurssi: {{ $course->title }}</h1>
	<div class="course-description">
		{!! nl2br($course->description) !!}
	</div>
	
	@if(session('error'))
		<div class="alert alert-danger alert-icon">
			<span class="glyphicon glyphicon-remove-sign"></span>
			<div>
				<p>{!! session('error') !!}</p>
				<p>Jos olet jo edennyt kurssissa, <a href="/auth/login"><span class="ul">kirjaudu sisään</span> <span class="glyphicon glyphicon-log-in"></span></a> ja yritä uudelleen!</p>
			</div>
			<div class="clearfix"></div>
		</div>
	@endif
	
	@if(!Auth::check())
		<div class="alert alert-info alert-icon login-note">
			<span class="glyphicon glyphicon-info-sign"></span>
			<div>
				<p>
					Jatkaaksesi siitä mihin jäit, <a href="/auth/login"><span class="ul">kirjaudu sisään</span> <span class="glyphicon glyphicon-log-in"></span></a>
				</p>
				<p>
					Jos et ole vielä rekisteröitynyt voit tehdä sen vastatessasi ensimmäiseen kokeeseen.
				</p>
			</div>
			<div class="clearfix"></div>
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
							<span class="glyphicon glyphicon-star-empty"></span>
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