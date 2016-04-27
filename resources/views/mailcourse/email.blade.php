<!DOCTYPE html>
<html>
<head>
	<title>Media7 Raamattuopisto - Kirjekurssin tilaus</title>
	<style type="text/css">
		html, body
		{
			font-family: Arial, Helvetica, Tahoma, sans-serif;
		}
	</style>
</head>
<body>
	<h2>Vastaanotettu kirjekurssin tilaus</h2>
	<p>
		Käyttäjä on tilannut kirjekurssin <b>{{ $data['course'] }}</b> postiinsa.
	</p>
	<h3>Tilauksen tiedot</h3>
	<div>
		<p>
			<b>Tilattu kurssi:</b> {{ $data['course'] }}
		</p>
		<p>
			<b>Tilaaja:</b> {{ $data['name'] }}<br/>
			<b>Lähiosoite:</b> {{ $data['address'] }}<br/>
			<b>Postinumero ja -toimipaikka:</b> {{ $data['city'] }}<br/>
			<b>Puhelinnumero:</b> {{ isset($data['phone']) && strlen($data['phone']) > 0 ? $data['phone'] : 'Ei annettu' }}<br/>
			<b>Sähköposti:</b> {{ isset($data['email']) && strlen($data['email']) > 0 ? $data['email'] : 'Ei annettu' }}<br/>
		</p>
	</div>
	<hr>
	<p>
		Tämä viesti on lähetetty automaattisesti eikä siihen tule vastata. Jos viesti ei koske sinua voit jättää sen huomioimatta.
	</p>
</body>
</html>