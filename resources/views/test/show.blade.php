@extends('layout')

@section('register_form')
	<fieldset>
		<legend>Kirjaudu sisään / Rekisteröidy</legend>
		<p style="padding-bottom:1em">
			Jatkaaksesi sinun tulee rekisteröityä, jotta järjestelmä voi pitää kirjaa vastauksistasi ja sinulle voidaan antaa palautetta.
		</p>
		
		@if($errors->any())
			<div class="alert alert-danger" role="alert">
				<b>Hupsis!</b> Rekisteröinnissä tapahtui virhe eikä vastauksiasi ole vielä tallennettu!
				<hr>
				<ul>
					<?php foreach($errors->all() as $error): ?>
						<li>{{ $error }}</li>
					<?php endforeach; ?>
				</ul>
			</div>
		@endif
		
		<div class="form-group">
			<label for="user-name" class="control-label col-xs-3">Nimi</label>
			<div class="col-xs-6">
				<input type="text" class="form-control" id="user-name" name="user-name" value="">
			</div>
		</div>
		<div class="form-group">
			<label for="user-email" class="control-label col-xs-3">Sähköpostiosoite</label>
			<div class="col-xs-6">
				<input type="text" class="form-control" id="user-email" name="user-email" value="">
			</div>
		</div>
		<div class="form-group">
			<label for="user-password" class="control-label col-xs-3">Salasana</label>
			<div class="col-xs-6">
				<input type="password" class="form-control" id="user-password" name="user-password">
			</div>
		</div>
		<div class="form-group">
			<label for="user-password_confirmation" class="control-label col-xs-3">Salasana uudestaan</label>
			<div class="col-xs-6">
				<input type="password" class="form-control" id="user-password_confirmation" name="user-password_confirmation">
			</div>
		</div>
	</fieldset>
@endsection

@section('content')
	<a href="/course/{{ $test->course->id }}" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Takaisin pääsivulle</a>

	<form action="/test/{{ $test->id }}" method="post" class="test-form form-horizontal">
		{!! csrf_field() !!}

		<div class="form-group">
			<h1 class="test-title"><?php echo $test->title; ?></h1>
			<?php if($test->description && strlen($test->description) > 0): ?>
				<div class="test-description"><?php echo $test->description; ?></div>
			<?php endif; ?>
			<input type="hidden" name="test_id" value="<?php echo $test->id; ?>">
		</div>
		
		@if(!Auth::check() && $errors->any())
			@yield('register_form')
			
			<div class="form-group">
				<button class="btn btn-primary btn-block">
					Tarkista vastaukset
					@if(!Auth::check())
						ja rekisteröidy
					@endif
				</button>
			</div>
			<hr>
		@endif
		
		<fieldset class="questions">
			<legend>Kysymykset</legend>
			<?php foreach($test->questions as $qkey => $question): ?>
				<div class="question {{
					css([
						'correct'			=> @$validation && @$validation[$question->id]['correct'],
						'partially-correct'	=> @$validation && !@$validation[$question->id]['correct'] && @$validation[$question->id]['partial'] > 0,
						'incorrect'			=> @$validation && !@$validation[$question->id]['correct'] && !@$validation[$question->id]['partial']
					])
				}}">
					<input type="hidden" name="questions[]" value="{{ $question->id }}">
					<div class="header">
						@if(@$validation)
							<div class="big-validation-icon">
								@if(@$validation[$question->id]['correct'])
									<span class="glyphicon glyphicon-ok-circle"></span>
								@else
									<span class="glyphicon glyphicon-remove-circle"></span>
								@endif
							</div>
						@endif
						
						<div class="number">
							{{ ($qkey + 1) . '. ' }}
						</div>
						<div class="title">
							{{ $question->title }}
							@if($question->subtitle)
								<div class="subtitle">
									{!! nl2br($question->subtitle) !!}
									<div class="clearfix"></div>
								</div>
							@endif
						</div>
						<div class="clearfix"></div>
					</div>
					
					@if(@$validation[$question->id]['correct'])
						<div class="validation correct">
							<span class="glyphicon glyphicon-ok"></span> Oikein!
						</div>
					@elseif(!@$validation[$question->id]['correct'] && @$validation[$question->id]['partial'] > 0)
						<div class="validation partially-correct">
							<span class="glyphicon glyphicon-remove"></span>
							<?php if($question->type == "MULTITEXT"): ?>
								<?php echo $validation[$question->id]['partial'] ?> oikein!
							<?php else: ?>
								Osittain oikein!
							<?php endif; ?>
						</div>
					@elseif(@$validation[$question->id] && !@$validation[$question->id]['correct'])
						<div class="validation incorrect">
							<span class="glyphicon glyphicon-remove"></span> Väärin!
						</div>
					@endif
					
					<div class="form-group has-feedback">
						<div class="answer">
							<?php
								switch($question->type): 
									case 'MULTI':
								?>
									<?php foreach($question->answers as $answer): ?>
										<div class="checkbox {{
											css([
												'has-answer' => @in_array($answer->id, @$given_answers[$question->id]),
											])
										}}">
											<label>
												{!! Form::checkbox('answer-' . $question->id . '[]', $answer->id, @in_array($answer->id, @$given_answers[$question->id])) !!}
												<?php echo $answer->text; ?>
												<?php if(@$validation && @in_array($answer->id, @$given_answers[$question->id])): ?>
													<?php if($answer->is_correct): ?>
														<span class="glyphicon glyphicon-ok" style="color:#329f07"></span>
													<?php else: ?>
														<span class="glyphicon glyphicon-remove" style="color:#af000d"></span>
													<?php endif; ?>
												<?php endif; ?>
											</label>
										</div>
									<?php endforeach; ?>

									<?php if(@$validation && @$validation[$question->id]['correct_answers']): ?>
										<div class="correct-answers">
											<span class="glyphicon glyphicon-exclamation-sign"></span>
											<p>Oikeat vastaukset:</p>
											<ul>
												<?php foreach($validation[$question->id]['correct_answers'] as $answer): ?>
													<li>{{ $answer['text'] }}</li>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php endif; ?>
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'CHOICE':
								?>
									<?php foreach($question->answers as $answer): ?>
										<div class="radio {{
											css([
												'has-answer' => (@$given_answers[$question->id] == $answer->id),
											])
										}}">
											<label>
												{!! Form::radio('answer-' . $question->id, $answer->id, @$given_answers[$question->id] == $answer->id) !!}
												<?php echo $answer->text; ?>
												<?php if(@$validation && @$given_answers[$question->id] == $answer->id): ?>
													<?php if($answer->is_correct): ?>
														<span class="glyphicon glyphicon-ok" style="color:#329f07"></span>
													<?php else: ?>
														<span class="glyphicon glyphicon-remove" style="color:#af000d"></span>
													<?php endif; ?>
												<?php endif; ?>
											</label>
										</div>
									<?php endforeach; ?>

									<?php if(@$validation && @$validation[$question->id]['correct_answers']): ?>
										<div class="correct-answers">
											<span class="glyphicon glyphicon-exclamation-sign"></span>
											<p>Oikea vastaus:</p>
											<ul>
												<li>{{ $validation[$question->id]['correct_answers']['text'] }}</li>
											</ul>
										</div>
									<?php endif; ?>
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'TEXT':
								?>
									<div class="row {{
										css([
											'has-success' 	=> (@$validation && @$validation[$question->id]['correct']),
											'has-error'		=> (@$validation && !@$validation[$question->id]['correct']),
										])
									}}">
										<div class="col-xs-12">
											{!! Form::text('answer-' . $question->id, @$given_answers[$question->id], [
												'class' => 'form-control',
												'placeholder' => 'Vastaus tähän'
											]) !!}
											@if(@$validation)
												@if(@$validation[$question->id]['correct'])
													<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
												@else
													<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
												@endif
											<?php endif; ?>
										</div>
									</div>
									
									@if(@$validation && @$validation[$question->id]['correct_answers'])
										<div class="correct-answers">
											<span class="glyphicon glyphicon-exclamation-sign"></span>
											<p>Oikea vastaus:</p>
											<ul>
												<li>{{ $validation[$question->id]['correct_answers']['text'] }}</li>
											</ul>
										</div>
									@endif
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'MULTITEXT':
								?>
									<div class="multitext">
										@for($i=0; $i < $question->answers->count(); ++$i)
											<div class="row {{
												css([
													'has-success' 	=> (@$validation && @$validation[$question->id]['correct_rows'][$i]),
													'has-error'		=> (@$validation && !@$validation[$question->id]['correct_rows'][$i]),
												])
											}}">
												<label for="answer-{{ $question->id .'-'. $i }}" class="col-xs-1 control-label"><?php echo $i+1; ?>.</label>
												<div class="col-xs-11">
													{!! Form::text('answer-' . $question->id . '[]', @$given_answers[$question->id][$i], [
														'class' => 'form-control',
														'placeholder' => 'Vastaus tähän',
														'id' => 'answer-' . $question->id .'-'. $i
													]) !!}
													@if(@$validation)
														@if(@$validation[$question->id]['correct_rows'][$i])
	  														<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
	  													@else
															<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
	  													@endif
	  												@endif
												</div>
											</div>
										@endfor

										<?php if(@$validation && @$validation[$question->id]['correct_answers']): ?>
											<div class="correct-answers">
											<span class="glyphicon glyphicon-exclamation-sign"></span>
												<p>Oikeat vastaukset:</p>
												<ul>
													<?php foreach($validation[$question->id]['correct_answers'] as $answer): ?>
														<li>{{ $answer['text'] }}</li>
													<?php endforeach; ?>
												</ul>
											</div>
										<?php endif; ?>
									</div>
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'TEXTAREA':
								?>
								    {!! Form::textarea('answer-' . $question->id, @$given_answers[$question->id], [
								    	'class' => 'form-control',
								    	'placeholder' => 'Vastaus tähän'
								    ]) !!}

									<?php if(@$validation): ?>
										<div class="correct-answers">
											<span class="glyphicon glyphicon-exclamation-sign"></span>
											<p>Oikea vastaus:</p>
											<ul>
												<li>Syöttämäsi vastaus tarkistetaan erikseen, mutta vastauksen ei tule olla tyhjä.</li>
											</ul>
										</div>
									<?php endif; ?>
								<?php
									break;
								?>
							<?php endswitch; ?>
						</div>
					</div>

				</div>
			<?php endforeach; ?>
		</fieldset>
		
		@if(!Auth::check() && !$errors->any())
			@yield('register_form')
		@endif
		
		<hr>
		<div class="form-group">
			<button class="btn btn-primary btn-block">
				Tarkista vastaukset
				@if(!Auth::check())
					ja rekisteröidy
				@endif
			</button>
		</div>
	</form>

@endsection