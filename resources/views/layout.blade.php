<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>M7 Laravel</title>
		<link rel="shortcut icon" type="image/png" href="/favicon.png">
        <link rel="stylesheet" href="/css/normalize.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
		<link rel="stylesheet" href="/css/main.css">
	</head>
	<body>
		<div id="login-status">
			@if(Auth::check())
				Terve, {{ Auth::user()->name }}!
				@if(Auth::user()->isAdmin())
					<a href="/admin#/users/{{ Auth::user()->id }}/edit" target="_blank">Muokkaa tietoja</a>
					<a href="/admin">Ylläpito</a>
				@else
					<a href="/auth/edit">Muokkaa tietoja</a>
				@endif
				<a href="/auth/logout">Kirjaudu ulos!</a>
			@else
				<a href="/auth/login">Kirjaudu sisään</a>
			@endif
		</div>
		
		<div id="main-wrapper">
			<header>
				<div class="inner">
					<div class="title">
						<h1>Raamattu avautuu</h1>
						<h3>Media7 Raamattuopisto</h3>
					</div>
				</div>
				<nav>
					<div class="inner">
						<ul>
							<li><a href="/">Etusivu</a></li>
							<li><a href="/">Kurssit</a></li>
							@yield('extra_navigation')
						</ul>
					</div>
				</nav>
			</header>
			<div id="main-content">
				@yield('content')
			</div>
		</div>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="/js/main.js"></script>
	</body>
</html>