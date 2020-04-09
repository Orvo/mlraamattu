@section('footer-copyright')
	<h3>{{ Config::get('site.title') }} &copy; {{ date('Y') }}</h3>
	<p>Suomen Adventtikirkko</p>
@endsection

@section('footer-links')
	<ul>
		<li><a href="https://www.nykyaika.fi">Nykyaika – hengellisiä uutisia</a></li>
		<li><a href="https://hopechannel.fi">Hopechannel – suoratoistopalvelu</a></li>
		<li><a href="https://media7.adventist.fi">Media7 Verkkomedia – opetus- ja hartausohjelmia</a></li>
		<li><a href="https://adventist.fi">Suomen Adventtikirkko</a></li>
	</ul>
@endsection

@section('footer-side-top')
	<p>
		Ilmaiset kirjeitse ja Internetissä käytävät raamattu- ja terveysaiheiset kurssit, raamattuleirit ja nettiraamattukoulu.
	</p>
@endsection

@section('footer-side-bottom')
	<p>
		Media7 Raamattuopisto on Suomen Adventtikirkon mediapohjaiseen raamattuopetukseen keskittyvä yksikkö.
	</p>
	<p>
		Muita Media7:n yksikköjä ovat Media7 Julkaisut (ent. Kirjatoimi) ja Media7 Verkkomedia (Radio, TV ja nettipohjaiset palvelut, mm. nettilähetykset).
	</p>
@endsection
