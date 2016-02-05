<!DOCTYPE html>
<html>
<head>
	<title>Media7 Raamattuopisto - koepalautteen vastaanotto</title>
</head>
<body>
	<h2>Koepalautteen vastaanotto</h2>
	<p>
		Hei, {{ $user->name }}!
	</p>
	<p>
		Olet saanut koepalautetta suorittamaasi kokeeseen <a href="{{ url('/test/' . $test->id) }}">{{ $test->title }}</a> kurssilla {f{ $course->title }f}.
	</p>
	<h3>Kysymyskohtainen palaute</h3>
	@foreach($test->questions as $key => $question)
		@if(strlen(@$feedback[$question->id]) > 0)
			<div style="border-bottom: 1px solid #eee;padding-bottom:1em;margin-bottom:1em">
				<h3>{{ $key+1 }}. {{ $question->title }}</h3>
				<p>
					{{ $question->subtitle }}
				</p>
				<h4>Vastauksesi</h4>
				<p>
					{{ print_r($data['given_answers'][$question->id], true) }}
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
				@endif
				<h3>Palaute:</h3>
				<p>
					{!! nl2br($feedback[$question->id]) !!}
				</p>
			</div>
		@endif
	@endforeach
	<p>
		Voit nähdä kokeen <a href="{{ url('/test/' . $test->id) }}">täällä</a>.
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