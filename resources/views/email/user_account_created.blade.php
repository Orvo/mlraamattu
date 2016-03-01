<!DOCTYPE html>
<html>
<head>
	<title>Media7 Raamattuopisto - uusi käyttäjätunnus</title>
	<style type="text/css">
		html, body
		{
			font-family: Arial, Helvetica, Tahoma, sans-serif;
		}
	</style>
</head>
<body>
	<h2>Uusi käyttäjätunnus!</h2>
	<p>
		Hei, {{ $user->name }}!
	</p>
	<p>
		Käyttäjätunnuksesi on luotu ja voit nyt suorittaa kokeita huoletta. Voit kirjautua sisään <a href="{{ url('auth/login') }}">täällä</a>.
	</p>
	<p>
		Käyttäjätunnuksenasi toimii sähköpostiosoitteesi: {{ $user->email }}
	</p>
	<p>
		Jos olet unohtanut salasanasi voit suorittaa salasanan palautuksen <a href="{{ url('auth/reset') }}">tällä sivulla</a>.
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