<!DOCTYPE html>
<html>
<head>
	<title>Media7 Raamattuopisto - käyttäjätietojasi on muokattu</title>
	<style type="text/css">
		html, body
		{
			font-family: Arial, Helvetica, Tahoma, sans-serif;
		}
	</style>
</head>
<body>
	<h2>Käyttäjätietojasi on muokattu!</h2>
	<p>
		Hei, {{ $user->name }}!
	</p>
	<p>
		Käyttäjätietojasi on muokattu ylläpidon toimesta, mahdollisesti omasta pyynnöstäsi. Voit kirjautua sisään <a href="{{ url('auth/login') }}">täällä</a>.
	</p>
	<p>
		<b>Käyttäjätunnus:</b> {{ $user->email }}
		<br>
		@if($password)
			<b>Uusi väliaikainen salasanasi:</b> {{ $password }}
		@else
			<b>Salasanaasi ei ole muutettu.</b>
		@endif
		@if($userAccessChanged)
			<br>
			<b>Käyttäjäoikeudet muuttuivat:</b> Olet nyt
			@if($user->access_level == 'ADMIN')
				ylläpitäjä
			@elseif($user->access_level == 'TEACHER')
				opettaja
			@else
				peruskäyttäjä
			@endif
		@endif
	</p>
	@if($password)
		<p>
			<b>On erityisen suositeltavaa</b>, että vaihdat salasanasi <b>heti</b> kirjauduttuasi sisään.
		</p>
	@else
		<p>
			Jos olet unohtanut salasanasi voit suorittaa salasanan palautuksen <a href="{{ url('auth/reset') }}">tällä sivulla</a>.
		</p>
	@endif
	<p>
		Terveisin, Media7 Raamattuopisto.
	</p>
	<hr>
	<p>
		Tämä viesti on lähetetty automaattisesti eikä siihen tule vastata.
	</p>
</body>
</html>