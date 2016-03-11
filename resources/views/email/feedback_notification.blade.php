<!DOCTYPE html>
<html>
<head>
	<title>Media7 Raamattuopisto - koepalautteen vastaanotto</title>
	<style type="text/css">
		html, body
		{
			font-family: Arial, Helvetica, Tahoma, sans-serif;
		}
	</style>
</head>
<body>
	<h2>Koepalautetta suorittamastasi kokeesta</h2>
	<p>
		Hei, {{ $user->name }}!
	</p>
	<p>
		Olet saanut koepalautetta suorittamastasi kokeesta <a href="{{ url('/test/' . $test->id) }}">{{ $test->title }}</a> kurssilla {{ $test->course->title }}.
	</p>
	<h3>Kysymyskohtainen palaute</h3>
	@foreach($test->questions as $key => $question)
		@if(strlen(@$feedback[$question->id]) > 0)
			<div style="border-bottom: 1px solid #eee;padding-bottom:1em;margin-bottom:1em">
				<h3 style="margin-bottom:0.2em;">{{ $key+1 }}. {{ $question->title }}</h3>
				<p>
					{!! nl2br(strip_tags($question->subtitle)) !!}
				</p>
				<h4>Vastauksesi</h4>
				<p>
					<ul>
						@if($question->type == 'MULTI')
							@foreach($data['given_answers'][$question->id] as $answer_id)
								<li>
									<?php
										$answer = findByProperty($question->answers, 'id', $answer_id);
									?>
									@if($answer !== false)
										{{ $answer->text }}
									@else
										Virhe: vastausta ei löytynyt.
									@endif
								</li>
							@endforeach
						@elseif($question->type == 'CHOICE')
							<li>
								<?php
									$answer = findByProperty($question->answers, 'id', $data['given_answers'][$question->id]);
								?>
								@if($answer !== false)
									{{ $answer->text }}
								@else
									Virhe: vastausta ei löytynyt.
								@endif
							</li>
						@elseif($question->type == 'MULTITEXT')
							@foreach($data['given_answers'][$question->id] as $answer)
								<li>
									{!! alt($answer, '<i>Ei vastausta</i>') !!}
								</li>
							@endforeach
						@else
							<li>{!! alt($data['given_answers'][$question->id], '<i>Ei vastausta</i>') !!}</li>
						@endif
					</ul>
				</p>
				@if($question->type != 'TEXTAREA')
					<p>
						Vastasit kysymykseen
						@if($validation[$question->id]['correct'])
							<b>oikein</b>.
						@elseif(!$validation[$question->id]['correct'] && @$validation[$question->id]['partial'] > 0)
							<b>osittain oikein</b>.
						@elseif(!$validation[$question->id]['correct'])
							<b>väärin</b>.
						@endif
					</p>
					@if(!$validation[$question->id]['correct'])
						<h4>Oikea vastaus</h4>
						<ul>
							@foreach($question->answers()->where('is_correct', 1)->get() as $answer)
								<li>{{ $answer->text }}</li>
							@endforeach
						</ul>
					@endif
					@if($question->type == 'MULTITEXT')
						Vastauksien järjestyksellä ei ole väliä.
					@endif
				@endif
				<h4>Palaute:</h4>
				<p>
					{!! nl2br($feedback[$question->id]) !!}
				</p>
			</div>
		@endif
	@endforeach
	<p>
		<b>Kokeen tarkistaja:</b> {{ $reviewer->name }}
	</p>
	<p>
		Halutessasi voit nähdä kokeen <a href="{{ url('/test/' . $test->id) }}">täällä</a>.
		Voit myös jatkaa <a href="{{ url('/course/' . $test->course->id) }}">kurssin suorittamista</a>.
	</p>
	<p>
		Terveisin, Media7 Raamattuopisto.
	</p>
	<hr>
	<p>
		Tämä viesti on lähetetty automaattisesti eikä siihen tule vastata.
	</p>
</body>
</html>