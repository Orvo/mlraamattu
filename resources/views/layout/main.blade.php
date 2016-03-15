<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			@if(isset($__env->getSections()['title']))
				@yield('title') - 
			@endif
			{{ Config::get('site.title') }}
		</title>
		<link rel="shortcut icon" type="image/ico" href="/favicon.ico">
        <link rel="stylesheet" href="/css/normalize.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/css/main.css">
		<link rel="stylesheet" href="/css/mobile.css">
	</head>
	<body>
		<div id="login-status">
			@if(Auth::check())
				Terve, {{ Auth::user()->name }}!
				@if(Auth::user()->isAdmin())
					<a href="/admin#/users/{{ Auth::user()->id }}/edit" target="_blank" class="hide-in-mobile-width">Muokkaa tietoja</a>
					<a href="/auth/edit" class="hide-in-desktop-width">Muokkaa tietoja</a>
					<a href="/admin" class="hide-in-mobile-width">Ylläpito</a>
				@else
					<a href="/auth/edit">Muokkaa tietoja</a>
				@endif
				<a href="/auth/logout">
					<span class="hide-in-mobile-width">Kirjaudu ulos!</span>
					<span class="hide-in-desktop-width">
						<span class="glyphicon glyphicon-log-out"></span>
					</span>
				</a>
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
					<div class="people"></div>
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
			<div id="content-wrapper" class="row">
				@if(isset($__env->getSections()['sidebar_content']))
					<div id="sidebar-content" class="col-xs-3">
						@yield('sidebar_content', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.')
					</div>
				@endif
				<div id="main-content" class="{{ css([
						'col-xs-9' 	=> isset($__env->getSections()['sidebar_content']),
						'col-xs-12' => !isset($__env->getSections()['sidebar_content']),
					]) }}">
					@yield('content')
				</div>
				<div class="clearfix"></div>
			</div>
			<footer>
				<div class="inner-dark">
					<div class="inner row">
						<div class="col-md-5">
							<h3>Media7 Raamattuopisto &copy; 2016</h3>
							<p>Suomen Adventtikirkko</p>
						</div>
						<div class="col-md-7">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt illo magni consequuntur esse, corrupti similique nam. Laudantium sit possimus dolores!
						</div>
					</div>
				</div>
				<div class="inner row">
					<div class="col-md-4 external-links">
						<h4>Linkkejä</h4>
						<ul>
							<li><a href="http://media7.adventist.fi">Media7 verkkomedia</a></li>
							<li><a href="http://aitolahti.adventist.fi">Aitolahden adventtiseurakunta</a></li>
							<li><a href="http://adventist.fi">Suomen Adventtikirkko</a></li>
						</ul>
					</div>
					<div class="col-md-8">
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt illo magni consequuntur esse, corrupti similique nam. Laudantium sit possimus dolores!
						</p>
						<p>
							Voluptates deleniti qui nihil a officia consectetur accusamus fugit perferendis corporis eos. Dolore, libero, nesciunt!
						</p>
					</div>
				</div>
			</footer>
		</div>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="/js/main.js"></script>
	</body>
</html>