@extends('layout.main')

@section('title')
	Opintomateriaali kokeelle {{ $test->title }}
@endsection

@section('extra_navigation')
	<li>
		<a href="/course/{{ $test->course->id }}">
			{{ $test->course->title }}
		</a>
	</li>
@endsection

@section('sidebar_content')
	@include('course.test-progress-sidebar')
@endsection

@section('content')
	<div class="centered-titles">
		<h2>Opintomateriaali</h2>
		<h3>
			<div class="line"></div>
			<div class="text">
				<span>{{ $test->title }}</span>
			</div>
		</h3>
		<div class="clearfix"></div>
	</div>
	
	<div class="test-material-body">
		{!! $test->page->body !!}
	</div>
	
	<div style="padding-top:1em">
		<a href="/test/{{ $test->id }}" class="btn btn-primary btn-block">
			Jatka kokeen suorittamiseen <span class="glyphicon glyphicon-chevron-right"></span>
		</a>
	</div>
@endsection