<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			@yield('title') - {{ Config::get('site.title') }}
		</title>
		<link rel="shortcut icon" type="image/png" href="/favicon.png">
        <link rel="stylesheet" href="/css/normalize.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/css/main.css">
	</head>
	<body>
		<div id="content-wrapper-popup">
			<div id="main-content">
				@yield('content')
			</div>
			<div class="clearfix"></div>
		</div>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="/js/main.js"></script>
	</body>
</html>