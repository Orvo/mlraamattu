<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>M7 Laravel</title>
		<link rel="shortcut icon" type="image/png" href="/favicon.png">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
		<link rel="stylesheet" href="/css/main.css">
	</head>
	<body>
		<div id="login-status">
			@if(Auth::check())
				Terve, {{ Auth::user()->name }}!
				@if(Auth::user()->access_level == 1)
					<a href="/admin">Ylläpito</a>
				@endif
				<a href="/auth/logout">Kirjaudu ulos!</a>
			@else
				<a href="/auth/login">Kirjaudu sisään</a>
			@endif
		</div>
		<div class="content">
			@yield('content')
		</div>

		<script src="/js/main.js"></script>
	</body>
</html>