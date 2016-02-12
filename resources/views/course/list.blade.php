@extends('layout')

@section('content')

	<h1>Kurssit</h1>
	<p>
		Alla lista tarjolla olevista kursseista.
	</p>
	
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
		@foreach($courses as $course)
			<div class="course list-item">
				<div class="title">
					<a href="/course/{{ $course->id }}" class="title-anchor">
						{{ $course->title }}
						<div class="status {{
							css([
								'completed'		=> $course->progressStatus == \App\Course::COMPLETED,
								'in-progress'	=> $course->progressStatus == \App\Course::IN_PROGRESS,
								'started'		=> $course->progressStatus == \App\Course::STARTED,
								'new-test'		=> $course->progressStatus == \App\Course::UNSTARTED,
							])
						}}">
							@if($course->progressStatus == \App\Course::COMPLETED)
								<span class="glyphicon glyphicon-ok-circle"></span>
								<p>Suoritettu</p>
							@elseif($course->progressStatus == \App\Course::IN_PROGRESS)
								<span class="glyphicon glyphicon-remove-circle"></span>
								<p>Kesken ({{ @$course->courseProgress->numCompleted }}/{{ @$course->courseProgress->numTotal }} suoritettu)</p>
							@elseif($course->progressStatus == \App\Course::STARTED)
								<span class="glyphicon glyphicon-remove-circle"></span>
								<p>Aloitettu</p>
							@elseif($course->progressStatus == \App\Course::UNSTARTED)
								<span class="glyphicon glyphicon-star-empty"></span>
								<p>Aloittamaton</p>
							@endif
						</div>
					</a>
				</div>
				<div class="description">
					<p>
						{!! nl2br($course->description) !!}
					</p>
					@if($course->progressStatus != \App\Course::COMPLETED && $course->nextTest)
						<div class="pull-right">
							<a href="test/{{ $course->nextTest->id }}" class="btn btn-default quick-start-course">
								@if($course->progressStatus == \App\Course::IN_PROGRESS || $course->progressStatus == \App\Course::STARTED)
									Jatka kurssia
								@elseif($course->progressStatus == \App\Course::UNSTARTED)
									Aloita ensimmäisestä kokeesta
								@endif
								<span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</div>
						<div class="clearfix"></div>
					@endif
				</div>
			</div>
		@endforeach
	</div>

@endsection