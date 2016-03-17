@extends('layout.public')

@section('title', $course->title)

@section('sidebar_content')
	@include('course.test-progress-sidebar')
@endsection

@section('content')
	
	<div class="centered-titles">
		<h2>Kurssi</h2>
		<h3>
			<div class="line"></div>
			<div class="text">
				<span>{{ $course->title }}</span>
			</div>
		</h3>
		<div class="course-description">
			{!! $course->description !!}
		</div>
		<div class="clearfix"></div>
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
	
	@include('alerts.auth-related')
	
	<div class="list">
		@foreach($course->tests as $test)
			<?php if(!$test->hasQuestions()): continue; endif;?>
			
			@if($test->page()->exists() && !$test->page->hidden)
				<div class="test list-item list-item-flat">
					<div class="title title-dual-row">
						<div class="title-anchor">
							<i class="fa fa-bookmark material-icon"></i>
							<div>
								<span class="small-title">Opintomateriaali</span>
								{{ $test->title }}
							</div>
						</div>
					</div>
					<div class="description">
						{{ $test->page->description }}
						<div class="read-more">
							@if($test->progress->status != \App\Test::LOCKED)
								<a href="/test/{{ $test->id }}/material" class="btn btn-primary">
									Jatka lukemista <span class="glyphicon glyphicon-chevron-right"></span>
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
							<span class="glyphicon glyphicon-star"></span>
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
					<div class="inner">
						{!! $test->description !!}
						<div class="test read-more">
							@if($test->progress->status != \App\Test::LOCKED)
								<a href="/test/{{ $test->id }}" class="btn btn-default">
									Kokeeseen <span class="glyphicon glyphicon-chevron-right"></span>
								</a>
							@else
								<span class="glyphicon glyphicon-lock"></span> Koe lukittu
							@endif
						</div>
					</div>
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