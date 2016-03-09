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
		<link rel="shortcut icon" type="image/png" href="/favicon.png">
        <link rel="stylesheet" href="/css/normalize.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
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
						<div class="col-xs-5">
							<h3>Media7 Raamattuopisto &copy; 2016</h3>
							<p>Suomen Adventtikirkko</p>
						</div>
						<div class="col-xs-7">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt illo magni consequuntur esse, corrupti similique nam. Laudantium sit possimus dolores!
						</div>
					</div>
				</div>
				<div class="inner row">
					<div class="col-xs-2">
						<ul>
							<li><a href="#">Linkki 1</a></li>
							<li><a href="#">Linkki 2</a></li>
							<li><a href="#">Linkki 3</a></li>
						</ul>
					</div>
					<div class="col-xs-2">
						<ul>
							<li><a href="#">Linkki 4</a></li>
							<li><a href="#">Linkki 5</a></li>
							<li><a href="#">Linkki 6</a></li>
						</ul>
					</div>
					<div class="col-xs-8">
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