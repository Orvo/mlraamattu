@include('layout.public.footer-text')

@section('extra_navigation')
	@foreach($content_pages as $page)
		@if($page->id == 1)
			<?php continue; ?>
		@endif
		
		<li><a href="/page/{{ $page->id }}/{{ $page->tag }}">{{ $page->title }}</a></li>
	@endforeach
@append

@section('layout-body')
	<!doctype html>
	<html>
		<head>
			<meta charset="utf-8">
			<meta name="description" content="">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>
				<?php if(isset($__env->getSections()['title'])): ?>@yield('title') - <?php endif; ?>{{ Config::get('site.title') }}
			</title>
			<link rel="shortcut icon" type="image/ico" href="/favicon.ico">
	        <link rel="stylesheet" href="/css/normalize.css">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
			<link rel="stylesheet" href="{{ resource_url('/css/build/public.min.css') }}">
		</head>
		<body>
			<div id="login-status">
				@if(Auth::check())
					Terve, {{ Auth::user()->name }}!
					@if(Auth::user()->canAccessAdminPanel())
						<a href="/admin#/users/{{ Auth::user()->id }}/edit" target="_blank" class="hide-in-mobile-width">Muokkaa tietoja</a>
						<a href="/auth/edit" class="hide-in-desktop-width">Muokkaa tietoja</a>
						<a href="/admin" class="hide-in-mobile-width">Ylläpito</a>
					@else
						<a href="/auth/edit">Muokkaa tietoja</a>
					@endif
					<a href="/auth/logout">
						<span class="glyphicon glyphicon-log-out" title="Kirjaudu ulos!"></span>
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
					</div>
					<nav>
						<div class="inner">
							<ul>
								<li><a href="/">Etusivu</a></li>
								<li><a href="/course">Nettikurssit</a></li>
								<li><a href="/mailcourse">Kirjekurssit</a></li>
								@yield('extra_navigation')
							</ul>
						</div>
					</nav>
				</header>
				<div id="content-wrapper" class="row {{ isset($sidebar_before) && $sidebar_before ? 'sidebar_before' : 'sidebar_after' }}">
					@if(isset($__env->getSections()['sidebar_content']))
						<div id="sidebar-content" class="col-xs-3">
							@yield('sidebar_content')
						</div>
					@endif
					<div id="main-content" class="{{ css([
							'col-xs-9' 	=> isset($__env->getSections()['sidebar_content']),
							'col-xs-12' => !isset($__env->getSections()['sidebar_content']),
						]) }}">
						@yield('content')
					</div>
					@if(isset($__env->getSections()['sidebar_content']))
						<div id="sidebar-content-after" class="hide-in-desktop-width">
							@yield('sidebar_content')
						</div>
					@endif
					<div class="clearfix"></div>
				</div>
				<footer>
					<div class="inner-dark">
						<div class="inner row">
							<div class="col-md-5">
								@yield('footer-copyright')
							</div>
							<div class="col-md-7">
								@yield('footer-side-top')
							</div>
						</div>
					</div>
					<div class="inner row">
						<div class="col-md-4 external-links">
							<h4>Linkkejä</h4>
							@yield('footer-links')
						</div>
						<div class="col-md-8">
							@yield('footer-side-bottom')
						</div>
					</div>
				</footer>
			</div>
			
			<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
			<script src="{{ resource_url('/js/build/public.min.js') }}"></script>
		</body>
	</html>
@show