<!DOCTYPE html>
<html>
<head>
	<title>Media7 Raamattuopisto - salasanan uusiminen</title>
</head>
<body>
	<h2>Salasanan uusiminen</h2>
	<p>
		Hei, {{ $user->name }}! Olet pyytänyt salasanan uusimista raamattuopiston tilillesi.
	</p>
	<p>
		Voit uusia salasanasi klikkaamalla alla olevaa linkkiä ja syöttämällä sivulla uuden salasanan:
	</p>
	<p>
		<a href="{{ url('/auth/reset/' . $token) }}">{{ url('/auth/reset/' . $token) }}</a>
	</p>
	<p>
		Jos et itse pyytänyt salasanan uusimista, voit olla huomioimatta tätä viestiä. Linkki vanhenee tunnin kuluessa.
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