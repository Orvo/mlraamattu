<?php
	$current_test_order = 0;
	
	$is_test_page = false;
	if(isset($test))
	{
		$course = $test->course;
		$tests = $course->tests;
		
		$current_test = $test;
		$current_test_order = $current_test->order;
		
		$is_test_page = true;
	}
	else
	{
		$tests = $course->tests;
		$current_test = false;
	}
	
	$hiding = [
		'backward' => 3,
		'forward' => 6,
	];
	
	$backward_hidden = 0;
	
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
	
	@foreach($tests as $key => $test)
		<?php if(!$test->hasQuestions()) break; ?>
		
		<?php
			$distance = $test->order - $current_test_order;
		?>
		
		@if($distance <= -$hiding['backward'])
			@if($distance == -$hiding['backward'])
				<li class="test-title">
					<div>...</div>
				</li>
				<li class="lock-spacer"></li>
			@endif
			<?php 
				$backward_hidden = min($hiding['backward'], $backward_hidden+1);
				continue;
			?>
		@endif
			
		@if($distance >= ($hiding['forward']-$backward_hidden))
			@if($distance == ($hiding['forward']-$backward_hidden))
				<li class="lock-spacer"></li>
				<li class="test-title">
					<div>
						<?php $num_hidden = count($tests) + 1 - $test->order; ?>
						+ {{ $num_hidden }} osa{{ $num_hidden != 1 ? 'a' : '' }} lisää
					</div>
				</li>
			@endif
			<?php continue; ?>
		@endif
		
		@if(!$test->isUnlocked() && !@$hasLockSpacer)
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
				@if($test->isUnlocked())
					<a href="/test/{{ $test->id }}/material" class="anchor {{ css([
							'material-popup' => $is_test_page && $test->id == $current_test->id && !@$isMaterialPage
						]) }}">
				@else
					<div class="anchor">
				@endif
					<i class="fa fa-bookmark"></i>
					<span>
						@if(!$test->isUnlocked())
							<span class="glyphicon glyphicon-lock"></span>
						@elseif($is_test_page && $test->id == $current_test->id && @$isMaterialPage)
							<span class="glyphicon glyphicon-record"></span>
						@endif
						Opintomateriaali
					</span>
				@if($test->isUnlocked())
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
			@if($test->isUnlocked())
				<a href="/test/{{ $test->id }}" class="anchor">
			@else
				<div class="anchor">
			@endif
				<i class="fa fa-file-text-o"></i>
				<span>
					@if(!$test->isUnlocked())
						<span class="glyphicon glyphicon-lock"></span>
					@elseif($is_test_page && $test->id == $current_test->id && @!$isMaterialPage)
						<span class="glyphicon glyphicon-record"></span>
					@endif
					Koe
				</span>
			@if($test->isUnlocked())
				</a>
			@else
				</div>
			@endif
		</li>
		<li class="spacer"></li>
	@endforeach
</ul>