@extends('layout')

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
		
		<fieldset class="questions">
			<legend>Kysymykset</legend>
			<?php foreach($test->questions as $qkey => $question): ?>
				<div class="question">
					<input type="hidden" name="questions[]" value="{{ $question->id }}">
					<div class="header">
						<?php if(is_array($question->validation) && $question->validation['correct'] === true): ?>
							<p class="pull-right" style="color:#329f07"><span class="glyphicon glyphicon-ok"></span> Oikein!</p>
						<?php elseif(is_array($question->validation) && $question->validation['correct'] === false && @$question->validation['partial'] > 0): ?>
							<p class="pull-right" style="color:#D9B614">
								<span class="glyphicon glyphicon-remove"></span>
								<?php if($question->type == "MULTITEXT"): ?>
									<?php echo $question->validation['partial'] ?> oikein!
								<?php else: ?>
									Osittain oikein!
								<?php endif; ?>
							</p>
						<?php elseif($question->validation === false || is_array($question->validation) && $question->validation['correct'] === false): ?>
							<p class="pull-right" style="color:#af000d"><span class="glyphicon glyphicon-remove"></span> Väärin!</p>
						<?php endif; ?>
						
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
					<div class="form-group">
						<div class="answer">
							<?php
								switch($question->type): 
									case 'MULTI':
								?>
									<?php foreach($question->answers as $choice): ?>
										<div class="checkbox">
											<label>
												{!! Form::checkbox('answer-' . $question->id . '[]', $choice->id) !!}
												<?php echo $choice->text; ?> / <?php echo $choice->is_correct; ?>
											</label>
											<small class="text-danger">{{ $errors->first('answer-' . $question->id) }}</small>
										</div>
									<?php endforeach; ?>
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'CHOICE':
								?>
									<?php foreach($question->answers as $choice): ?>
										<div class="radio">
											<label>
												{!! Form::radio('answer-' . $question->id, $choice->id) !!}
												<?php echo $choice->text; ?> / <?php echo $choice->is_correct; ?>
											</label>
											<small class="text-danger">{{ $errors->first('answer-' . $question->id) }}</small>
										</div>
									<?php endforeach; ?>
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'TEXT':
								?>
									{!! Form::text('answer-' . $question->id, null, ['class' => 'form-control', 'placeholder' => 'Vastaus tähän']) !!}
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'MULTITEXT':
								?>
									<div class="multitext">
										<?php for($i=0; $i < $question->answers->count(); ++$i): ?>
											<div class="row">
												<label for="answer-<?php echo $question->id .'-'. $i; ?>" class="col-xs-1 control-label"><?php echo $i+1; ?>.</label>
												<div class="col-xs-11">
													{!! Form::text('answer-' . $question->id, null, ['class' => 'form-control', 'placeholder' => 'Vastaus tähän']) !!}
													<small class="text-danger">{{ $errors->first('answer-' . $question->id) }}</small>
												</div>
											</div>
										<?php endfor; ?>
									</div>
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'TEXTAREA':
								?>
								    {!! Form::textarea('answer-' . $question->ids, null, ['class' => 'form-control', 'placeholder' => 'Vastaus tähän']) !!}
								    <small class="text-danger">{{ $errors->first('answer-' . $question->id) }}</small>
								<?php
									break;
								?>
							<?php endswitch; ?>
						</div>
					</div>

				</div>
			<?php endforeach; ?>
		</fieldset>
		
		@if(!Auth::check())
			<fieldset>
				<legend>Rekisteröidy</legend>
				<p style="padding-bottom:1em">
					Jatkaaksesi sinun tulee rekisteröityä, jotta järjestelmä voi pitää kirjaa vastauksistasi ja sinulle voidaan antaa palautetta.
				</p>
				<?php if(count(@$errors) > 0): ?>
					<div class="alert alert-danger" role="alert">
						<b>Hupsis!</b> Rekisteröinnissä tapahtui virhe:
						<ul>
							<?php foreach($errors as $error): ?>
								<li><?php echo $error; ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<div class="form-group">
					<label for="user-email" class="control-label col-xs-3">Sähköposti</label>
					<div class="col-xs-6">
						<input type="text" class="form-control" id="user-email" name="user-email" value="<?php echo @$fields['email']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="user-password1" class="control-label col-xs-3">Salasana</label>
					<div class="col-xs-6">
						<input type="password" class="form-control" id="user-password1" name="user-password1">
					</div>
				</div>
				<div class="form-group">
					<label for="user-password2" class="control-label col-xs-3">Salasana Uudestaan</label>
					<div class="col-xs-6">
						<input type="password" class="form-control" id="user-password2" name="user-password2">
					</div>
				</div>
			</fieldset>
		@endif
		
		<hr>
		<div class="form-group">
			<button class="btn btn-primary btn-block">
				Tarkista vastaukset
				<?php if(!@$AUTH->logged_in): ?>
					ja rekisteröidy
				<?php endif; ?>
			</button>
		</div>
	</form>

@endsection