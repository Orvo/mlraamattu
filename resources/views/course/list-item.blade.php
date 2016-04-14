<div class="course list-item">
	<div class="title">
		<a href="/course/{{ $course->id }}" class="title-anchor">
			{{ $course->title }}
			<div class="status {{
				css([
					'completed'		=> $course->progressStatus == \App\Course::COMPLETED,
					'in-progress'	=> $course->progressStatus == \App\Course::IN_PROGRESS,
					'started'		=> $course->progressStatus == \App\Course::STARTED,
					'new-test'		=> $course->progressStatus == \App\Course::UNSTARTED,
				])
			}}">
				@if($course->progressStatus == \App\Course::COMPLETED)
					<span class="glyphicon glyphicon-ok-circle"></span>
					<p>Suoritettu</p>
				@elseif($course->progressStatus == \App\Course::IN_PROGRESS)
					<span class="glyphicon glyphicon-remove-circle"></span>
					<p>Kesken ({{ @$course->courseProgress->numCompleted }}/{{ @$course->courseProgress->numTotal }} suoritettu)</p>
				@elseif($course->progressStatus == \App\Course::STARTED)
					<span class="glyphicon glyphicon-remove-circle"></span>
					<p>Aloitettu</p>
				@elseif($course->progressStatus == \App\Course::UNSTARTED)
					<span class="glyphicon glyphicon-star"></span>
					<p>Aloittamatta</p>
				@endif
			</div>
		</a>
	</div>
	<div class="description">
		@if($course->published == 0)
			<div class="alert alert-danger unpublish-alert">
				Tämä kurssi ei ole vielä julkinen. Voit nähdä sen koska olet kirjautunut sisään.
			</div>
		@endif
		<div class="inner">
			{!! $course->description !!}
		</div>
		@if($course->progressStatus != \App\Course::COMPLETED && $course->nextTest)
			<div class="pull-right continue-button">
				<a href="test/{{ $course->nextTest->id }}/{{ $course->nextTest->goToMaterial ? 'material' : '' }}" class="btn quick-start-course {{ css([
						'btn-primary' => $course->progressStatus == \App\Course::UNSTARTED,
						'btn-default' => $course->progressStatus == \App\Course::IN_PROGRESS || $course->progressStatus == \App\Course::STARTED
					]) }}">
					@if($course->progressStatus == \App\Course::IN_PROGRESS || $course->progressStatus == \App\Course::STARTED)
						Jatka kurssia
					@elseif($course->progressStatus == \App\Course::UNSTARTED)
						Aloita ensimmäisestä osasta
					@endif
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
			</div>
			<div class="clearfix"></div>
		@endif
	</div>
</div>