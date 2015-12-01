@extends('layout')

@section('content')

	<a href="/" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Takaisin pääsivulle</a>
	
	<h1>Kurssi: {{ $course->title }}</h1>
	<div>
		{!! nl2br($course->description) !!}
	</div>
	<p>
		Alla lista kokeista joita valitsemallasi kurssilta löytyy.
	</p>
	<div class="list">
		@foreach($course->tests as $test)
			<div class="test list-item<?php echo (@$user_completed[$test->id] ? ' ' . ( $user_completed[$test->id]->all_correct ? 'completed' : 'in-progress' ) : '') ?>">
				<div class="title">
					<a href="/test/{{ $test->id }}">
						{{ $test->title }}
						<?php if(@$user_completed[$test->id]): ?>
							<div class="completion">
								<?php if($user_completed[$test->id]->all_correct): ?>
									<span class="glyphicon glyphicon-ok-circle"></span>
									<p>Suoritettu</p>
								<?php else: ?>
									<span class="glyphicon glyphicon-remove-circle"></span>
									<p>Kesken</p>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</a>
				</div>
				<div class="description">
					{!! nl2br($test->description) !!}
				</div>
			</div>
		@endforeach
	</div>

@endsection