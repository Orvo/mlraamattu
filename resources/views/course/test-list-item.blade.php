<?php //if(!$test->hasQuestions()): continue; endif;?>
<div class="test list-item">
	<div class="title">
		@if($test->progress->status != \App\Test::LOCKED)
			<a href="/test/{{ $test->id }}" class="title-anchor">
		@else
			<span class="title-anchor">
		@endif
		{{ $test->id }}
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
			</span>
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