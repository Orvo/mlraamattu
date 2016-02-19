@extends('layout')

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
				<span>{{ $test->title }} asdfasd fasdf sdfds sdfasd fsadf sdf gdsfgd fgdfg df adfg dfgadfg</span>
			</div>
		</h3>
		<div class="clearfix"></div>
	</div>
	<div class="test-material-body">
		{!! $test->page->body !!}
	</div>
	<hr>
	<div>
		<a href="/test/{{ $test->id }}" class="btn btn-primary btn-block">
			Jatka kokeen suorittamiseen <span class="glyphicon glyphicon-chevron-right"></span>
		</a>
	</div>
@endsection