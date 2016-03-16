<?php
	$is_test_page = false;
	if(isset($test))
	{
		$course = $test->course;
		$tests = $course->tests;
		$current_test = $test;
		$is_test_page = true;
	}
	else
	{
		$tests = $course->tests;
		$current_test = false;
	}
	
?>
<h4 class="hide-in-desktop-width">Kurssikartta</h4>
<ul class="sidebar-course-progress fixed">

	<li class="course-title {{ css([
			'active' => !$is_test_page
		]) }}">
		<a href="/course/{{ $course->id }}" class="anchor">
			{{ $course->title }}
		</a>
	</li>
	
	@for($i=0;$i<1;++$i)
	@foreach($tests as $key => $test)
		<?php if(!$test->hasQuestions()) break; ?>
		
		@if($test->progress->status == \App\Test::LOCKED && !@$hasLockSpacer)
			<li class="lock-spacer"></li>
			<?php $hasLockSpacer = true; ?>
		@endif
		
		<li class="test-title">
			<div>{{ ($key+1) }}. {{ $test->title }}</div>
		</li>
		
		@if($test->page()->exists() && !$test->page->hidden)
			<li class="material {{ css([
				'active' => $is_test_page && $test->id == $current_test->id && @$isMaterialPage
			]) }}">
				@if($test->progress->status != \App\Test::LOCKED)
					<a href="/test/{{ $test->id }}/material" class="anchor">
				@else
					<div class="anchor">
				@endif
					<i class="fa fa-bookmark"></i>
					<span>
						@if($test->progress->status == \App\Test::LOCKED)
							<span class="glyphicon glyphicon-lock"></span>
						@elseif($is_test_page && $test->id == $current_test->id && @$isMaterialPage)
							<span class="glyphicon glyphicon-record"></span>
						@endif
						Opintomateriaali
					</span>
				@if($test->progress->status != \App\Test::LOCKED)
					</a>
				@else
					</div>
				@endif
			</li>
		@endif
		
		<li class="test {{ css([
			'active' 		=> $is_test_page && $test->id == $current_test->id && @!$isMaterialPage,
			'no-material' 	=> !$test->page()->exists()
		]) }}">
			@if($test->progress->status != \App\Test::LOCKED)
				<a href="/test/{{ $test->id }}" class="anchor">
			@else
				<div class="anchor">
			@endif
				<i class="fa fa-file-text-o"></i>
				<span>
					@if($test->progress->status == \App\Test::LOCKED)
						<span class="glyphicon glyphicon-lock"></span>
					@elseif($is_test_page && $test->id == $current_test->id && @!$isMaterialPage)
						<span class="glyphicon glyphicon-record"></span>
					@endif
					Koe
				</span>
			@if($test->progress->status != \App\Test::LOCKED)
				</a>
			@else
				</div>
			@endif
		</li>
		<!-- 
		<li class="test-progress">
			<div class="status {{
					css([
						'locked' 		=> $test->progress->status == \App\Test::LOCKED,
						'new-test'		=> $test->progress->status == \App\Test::UNSTARTED,
						'in-progress'	=> $test->progress->status == \App\Test::IN_PROGRESS,
						'completed'		=> $test->progress->status == \App\Test::COMPLETED,
					])
				}}">
				@if($test->progress->status == \App\Test::LOCKED)
					Lukittu
				@elseif($test->progress->status == \App\Test::UNSTARTED)
					Aloittamatta
				@elseif($test->progress->status == \App\Test::IN_PROGRESS)
					Kesken
				@elseif($test->progress->status == \App\Test::COMPLETED)
					Suoritettu
				@endif
			</div>
		</li>
		 -->
		<li class="spacer"></li>
	@endforeach
	@endfor
</ul>