
/*
 * Application
 */
 
var app = angular.module('adminpanel', ['ngResource', 'ngRoute', 'ngSanitize', 'ui.sortable'],
	function($interpolateProvider)
	{
		$interpolateProvider.startSymbol('[[');
		$interpolateProvider.endSymbol(']]');
	}
);

app.config(
	function($routeProvider)
	{
		var userData;
		
		var authProvider = function($rootScope, $window, $q, $http)
		{
			var deferred = $q.defer();
			
			if($rootScope.userData && $rootScope.userData.authenticated && Date.now()-$rootScope.userData.lastCheck < 30000)
			{
				deferred.resolve($rootScope.userData);
			}
			else
			{
				$http.get('/ajax/auth')
					.then(function success(response)
					{
						if(!response.data.authenticated)
						{
							deferred.reject(false);
							$window.location = "/auth/login/?ref=admin";
						}
						else
						{
							deferred.resolve(response.data);
							$rootScope.userData = response.data;
							$rootScope.userData.lastCheck = Date.now();
						}
					}, function error(response)
					{
						deferred.reject(false);
						$window.location = "/auth/login/?ref=admin";
					});
			}
			
			return deferred.promise;
		}
		
		$routeProvider
			.when('/', {
				controller: 'IndexController',
				templateUrl: '/ng/index.html',
				resolve: { factory: authProvider, },
			})
			
			.when('/courses', {
				controller: 'CoursesController',
				templateUrl: '/ng/courses/list.html',
				resolve: { factory: authProvider, },
			})
			.when('/courses/:id', {
				controller: 'CourseDisplayController',
				templateUrl: '/ng/courses/show.html',
				resolve: { factory: authProvider, },
			})
			.when('/courses/new', {
				controller: 'CoursesFormController',
				templateUrl: '/ng/courses/form.html',
				resolve: { factory: authProvider, },
			})
			.when('/courses/:id/edit', {
				controller: 'CoursesFormController',
				templateUrl: '/ng/courses/form.html',
				resolve: { factory: authProvider, },
			})
			
			.when('/tests', {
				controller: 'TestsController',
				templateUrl: '/ng/tests/list.html',
				resolve: { factory: authProvider, },
			})
			.when('/tests/:id', {
				controller: 'TestsDisplayController',
				templateUrl: '/ng/tests/show.html',
				resolve: { factory: authProvider, },
			})
			.when('/tests/new/:course_id', {
				controller: 'TestsFormController',
				templateUrl: '/ng/tests/form.html',
				resolve: { factory: authProvider, },
			})
			.when('/tests/:id/edit', {
				controller: 'TestsFormController',
				templateUrl: '/ng/tests/form.html',
				resolve: { factory: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Misc
			
			.otherwise({
				redirectTo: '/',
				resolve: { factory: authProvider, },
			});
	}
);



// app.factory('authProvider', function authProviderFactory($q, $http)
// {
// 	var user;
// 	return {
// 		isLoggedIn: function()
// 		{
// 			return $http.get('/ajax/auth')
// 				.then(function success(response)
// 				{
// 					console.log("SUCCESS", response);
// 					return response.data;
// 				}, function error(response)
// 				{
// 					console.log("ERROR", response);
// 					return false;
// 				});
// 		}
// 	};
// });

// app.run([
// 	'$rootScope', '$location', 'authProvider',
// 	function ($rootScope, $location, authProvider)
// 	{
// 		$rootScope.$on('$routeChangeStart', function(event)
// 		{
// 			var loggedIn = authProvider.isLoggedIn();
// 			console.log("ASD", loggedIn)
// 			if (!false)
// 			{
// 				console.log('DENY : Redirecting to Login');
// 				event.preventDefault();
// 				// $location.path('/login');
// 			}
// 			else
// 			{
// 				console.log('ALLOW');
// 			}
// 		});
// 	}
// ]);

app.directive('ngEnter', function()
{
	return function(scope, element, attrs)
	{
		element.bind("keydown keypress", function(event)
		{
			if(event.which === 13) {
				scope.$apply(function(){
					scope.$eval(attrs.ngEnter);
				});
				
				event.preventDefault();
			}
		});
	};
});

// app.directive('ngBlur', ['$parse', function($parse) {
// 	return function(scope, element, attr) {
// 		var fn = $parse(attr['ngBlur']);
// 		element.bind('blur', function(event) {
// 			scope.$apply(function() {
// 				fn(scope, {$event:event});
// 			});
// 		});
// 	}
// }]);
