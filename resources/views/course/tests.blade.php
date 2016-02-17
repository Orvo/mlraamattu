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
			<?php if(!$test->hasQuestions()): continue; endif;?>
			
			@if($test->page()->exists())
				<div class="test list-item list-item-flat">
					<div class="title title-dual-row">
						<div class="title-anchor">
							<i class="fa fa-bookmark material-icon"></i>
							<div>
								<span class="small-title">Koemateriaali</span>
								{{ $test->title }}
							</div>
						</div>
					</div>
					<div class="description">
						{{ $test->page->description }}
						<div class="read-more">
							@if($test->progress->status != \App\Test::LOCKED)
								<a href="/test/{{ $test->id }}/material">
									Lue lisää <span class="glyphicon glyphicon-chevron-right"></span>
								</a>
							@else
								Suorita edellinen koe ensin.
							@endif
						</div>
					</div>
				</div>
			@endif
			
			<div class="test list-item">
				<div class="title">
					@if($test->progress->status != \App\Test::LOCKED)
						<a href="/test/{{ $test->id }}" class="title-anchor">
					@else
						<div class="title-anchor">
					@endif
					<i class="fa fa-file-text-o test-icon"></i>
					{{ $test->title }}
					
					<div class="status {{
						css([
							'locked' 		=> $test->progress->status == \App\Test::LOCKED,
							'new-test'		=> $test->progress->status == \App\Test::UNSTARTED,
							'in-progress'	=> $test->progress->status == \App\Test::IN_PROGRESS,
							'completed'		=> $test->progress->status == \App\Test::COMPLETED,
						])
					}}">
						@if($test->progress->status == \App\Test::COMPLETED)
							<span class="glyphicon glyphicon-ok-circle"></span>
							<p>Suoritettu</p>
						@elseif($test->progress->status == \App\Test::IN_PROGRESS)
							<span class="glyphicon glyphicon-remove-circle"></span>
							<p>Kesken ({{ $test->progress->data->num_correct }}/{{ $test->progress->data->total }} oikein)</p>
						@elseif($test->progress->status == \App\Test::UNSTARTED)
							<span class="glyphicon glyphicon-star-empty"></span>
							<p>Suorittamaton</p>
						@elseif($test->progress->status == \App\Test::LOCKED)
							<span class="glyphicon glyphicon-lock"></span>
							<p>Lukittu</p>
						@endif
					</div>
						
					@if($test->progress->status != \App\Test::LOCKED)
						</a>
					@else
						</div>
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