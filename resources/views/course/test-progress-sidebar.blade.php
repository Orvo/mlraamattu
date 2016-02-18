<h4>{{ $test->course->title }}</h4>
<ul class="sidebar-course-progress">
	@foreach($test->course->tests as $course_test)
		<li class="test-title">
			<h5>{{ $course_test->title }}</h5>
		</li>
		
		@if($course_test->page()->exists())
			<li class="material {{ css([
				'active' => $course_test->id == $test->id && @$isMaterialPage
			]) }}">
				<a href="/test/{{ $course_test->id }}/material">
					<i class="fa fa-bookmark"></i>
					<span>Koemateriaali</span>
				</a>
			</li>
		@endif
		
		<li class="test {{ css([
			'active' 		=> $course_test->id == $test->id && @!$isMaterialPage,
			'no-material' 	=> !$course_test->page()->exists()
		]) }}">
			<a href="/test/{{ $course_test->id }}">
				<i class="fa fa-file-text-o"></i>
				<span>Koe</span>
			</a>
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