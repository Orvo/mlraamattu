@section('footer-copyright')
	<h3>{{ Config::get('site.title') }} &copy; {{ date('Y') }}</h3>
	<p>Suomen Adventtikirkko</p>
@endsection

@section('footer-links')
	<ul>
		<li><a href="http://media7.fi">Media7 Raamattuopisto<br>(kirjeitse käytävät kurssit)</a></li>
		<li><a href="http://www.nykyaika.fi">Media7 Julkaisut </a></li>
		<li><a href="http://media7.adventist.fi">Media7 Verkkomedia</a></li>
		<li><a href="http://adventist.fi">Suomen Adventtikirkko</a></li>
	</ul>
@endsection

@section('footer-side-top')
	<p>
		Ilmaiset kirjeitse ja Internetissä käyttävät raamattu- ja terveysaiheiset kurssit, raamattuleirit ja nettiraamattukoulu.
	</p>
@endsection

@section('footer-side-bottom')
	<p>
		Media7 Raamattuopisto on Suomen Adventtikirkon mediapohjaiseen raamattuopistukseen keskittyvä yksikkö.
	</p>
	<p>
		Muita Media7:n yksikköjä ovat Media7 Julkaisut (ent. Kirjatoimi) ja Media7 Verkkomedia (Radio, TV ja nettipohjaiset palvelut, mm. nettilähetykset).
	</p>
@endsection