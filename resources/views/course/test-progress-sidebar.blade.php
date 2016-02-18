<h4>{{ $test->course->title }}</h4>
<ul class="sidebar-course-progress">
	@foreach($test->course->tests as $course_test)
		@if($course_test->progress->status == \App\Test::LOCKED && !@$hasLockSpacer)
			<li class="lock-spacer"></li>
			<?php $hasLockSpacer = true; ?>
		@endif
		
		<li class="test-title">
			<h5>{{ $course_test->title }}</h5>
		</li>
		
		@if($course_test->page()->exists())
			<li class="material {{ css([
				'active' => $course_test->id == $test->id && @$isMaterialPage
			]) }}">
				@if($course_test->progress->status != \App\Test::LOCKED)
					<a href="/test/{{ $course_test->id }}/material" class="anchor">
				@else
					<div class="anchor">
				@endif
					<i class="fa fa-bookmark"></i>
					<span>Koemateriaali</span>
				@if($course_test->progress->status != \App\Test::LOCKED)
					</a>
				@else
					</div>
				@endif
			</li>
		@endif
		
		<li class="test {{ css([
			'active' 		=> $course_test->id == $test->id && @!$isMaterialPage,
			'no-material' 	=> !$course_test->page()->exists()
		]) }}">
			@if($course_test->progress->status != \App\Test::LOCKED)
				<a href="/test/{{ $course_test->id }}" class="anchor">
			@else
				<div class="anchor">
			@endif
				<i class="fa fa-file-text-o"></i>
				<span>
					@if($course_test->progress->status == \App\Test::LOCKED)
						<span class="glyphicon glyphicon-lock"></span>
					@endif
					Koe
				</span>
			@if($course_test->progress->status != \App\Test::LOCKED)
				</a>
			@else
				</div>
			@endif
		</li>
		
		<li class="test-progress">
			<div class="status {{
					css([
						'locked' 		=> $course_test->progress->status == \App\Test::LOCKED,
						'new-test'		=> $course_test->progress->status == \App\Test::UNSTARTED,
						'in-progress'	=> $course_test->progress->status == \App\Test::IN_PROGRESS,
						'completed'		=> $course_test->progress->status == \App\Test::COMPLETED,
					])
				}}">
				@if($course_test->progress->status == \App\Test::LOCKED)
					Lukittu
				@elseif($course_test->progress->status == \App\Test::UNSTARTED)
					Aloittamatta
				@elseif($course_test->progress->status == \App\Test::IN_PROGRESS)
					Kesken
				@elseif($course_test->progress->status == \App\Test::COMPLETED)
					Suoritettu
				@endif
			</div>
		</li>
		
		<li class="spacer"></li>
	@endforeach
</ul>