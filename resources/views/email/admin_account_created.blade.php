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
		Sinulle on luotu käyttäjätunnus, mahdollisesti omasta pyynnöstäsi. Voit kirjautua sisään <a href="{{ url('auth/login') }}">täällä</a>.
	</p>
	<p>
		<b>Käyttäjätunnus:</b> {{ $user->email }}<br>
		<b>Väliaikainen salasanasi:</b> {{ $password }}
	</p>
	<p>
		<b>On erityisen suositeltavaa</b>, että vaihdat salasanasi <b>heti</b> kirjauduttuasi sisään.
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