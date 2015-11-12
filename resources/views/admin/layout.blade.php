<!DOCTYPE html>
<html ng-app="adminpanel">
	<head>
		<title>M7R Admin</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=1000, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="shortcut icon" type="image/png" href="/favicon.png">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="/css/admin.css">
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#/">Ylläpitopaneeli</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="#/courses">Kurssit</a></li>
						<li><a href="#/tests">Kokeet</a></li>
					</ul>
					
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Kirjaudu ulos</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div id="main-container">
			<div class="wrapper" ng-view>
				@yield('content')
			</div>
		</div>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-resource.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-route.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
		
		<script src="/js/ng/main.js"></script>
		<script src="/js/ng/controllers.js"></script>
		<!-- 
		<script src="/js/ng/directives.js"></script>
		 -->
		<script src="/js/ng/models.js"></script>
		<script src="/js/ng/modules/sortable.js"></script>
		
		<script src="/js/admin.js"></script>
	</body>
</html>

