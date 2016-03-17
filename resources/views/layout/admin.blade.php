@section('layout-body')
	<!DOCTYPE html>
	<html ng-app="adminpanel">
		<head>
			<title ng-bind="(title ? title() + ' - ' : '') + '{{ Config::get('site.title') }} Ylläpitopaneeli'">
				{{ Config::get('site.title') }} Ylläpitopaneeli
			</title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=1000, initial-scale=1">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<link rel="shortcut icon" type="image/ico" href="/favicon.ico">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
			<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
			<link rel="stylesheet" href="/css/admin.min.css">
		</head>
		<body>
			<nav class="navbar navbar-default navbar-fixed-top" ng-controller="NavbarController">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#/">
							<span class="glyphicon glyphicon-home"></span>
						</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<li class="dropdown dropdown-hover" ng-if="userData.user.access_level == 'ADMIN'">
								<a href="#/courses">
									Kurssit <span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#/courses/">Kurssit</a>
									</li>
									<li role="separator" class="divider"></li>
									<li ng-repeat="course in courses">
										<a href="#/courses/[[ course.id ]]">[[ course.title ]]</a>
									</li>
									<li role="separator" class="divider" ng-if="courses.length > 0"></li>
									<li>
										<a href="#/courses/new"><span class="glyphicon glyphicon-plus"></span> Lisää uusi kurssi</a>
									</li>
								</ul>
							</li>
							<li>
								<a href="#/groups">
									Ryhmät
								</a>
							</li>
							<li>
								<a href="#/archive">
									Koesuoritukset
									<span class="badge glow-animation ng-cloak" ng-show="test_records !== undefined && test_records.new > 0">
										[[ test_records.new ]] [[ test_records.new > 0 ? 'uutta' : 'uusi' ]]!
									</span>
								</a>
							</li>
						</ul>
						
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="/" target="_blank">
									<span class="glyphicon glyphicon-globe"></span> Näytä sivu
								</a>
							</li>
							<li ng-if="userData.user.access_level == 'ADMIN'">
								<a href="#/files">
									<span class="glyphicon glyphicon-file"></span> Tiedostonhallinta
								</a>
							</li>
							<li ng-if="userData.user.access_level == 'ADMIN'">
								<a href="#/users">
									<span class="glyphicon glyphicon-user"></span> Käyttäjät
								</a>
							</li>
							<li class="dropdown ng-cloak" ng-show="userData">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<b>[[ userData.user.name ]]</b> <span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#/users/[[ userData.user.id ]]/edit">Muokkaa tietoja</a>
									</li>
									<li role="separator" class="divider"></li>
									<li><a href="/auth/logout"><span class="glyphicon glyphicon-log-out"></span> Kirjaudu ulos</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<div id="main-container">
				<div class="wrapper" ng-view>
					@yield('content')
				</div>
				
				<div class="breadcrumbs" ng-controller="Breadcrumbs">
					<ol class="breadcrumb">
						<li><a href="#/">Ylläpitopaneeli</a></li>
						<li ng-repeat="(key, item) in breadcrumbs">
							<span ng-if="!item.hasOwnProperty('loaded') || item.loaded">
								<a href="[[ item.link ]]" ng-if="item.hasOwnProperty('link')">[[ item.title ]]</a>
								<span ng-if="!item.hasOwnProperty('link')">[[ item.title ]]</span>
							</span>
							<span ng-if="item.hasOwnProperty('loaded') && !item.loaded">
								<img src="/img/ajax-loader-breadcrumb.gif" alt="">
							</span>
						</li>
					</ol>
				</div>
				
				@include('layout.admin.ajax-login-form')
			</div>
			
			<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
			
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
			
			<script src="/js/vendor/ckeditor/ckeditor.js"></script>
			
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-resource.min.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-route.min.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-sanitize.min.js"></script>
			
			<script src="/js/admin-angular.min.js"></script>
			<script src="/js/admin.min.js"></script>
		</body>

	</html>
@show