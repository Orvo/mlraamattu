
/*
 * Application
 */
 
var app = angular.module('adminpanel', ['ngResource', 'ngRoute', 'ngSanitize', 'ngOnload', 'ui.sortable', 'ckeditor'],
	function($interpolateProvider)
	{
		$interpolateProvider.startSymbol('[[');
		$interpolateProvider.endSymbol(']]');
	}
);

app.run(function($rootScope, $http)
{
	$rootScope.updateUserData = function()
	{
		$http.get('/ajax/auth')
			.then(function success(response)
			{
				$rootScope.userData = response.data;
				$rootScope.userData.lastCheck = Date.now();
			});
	}
});

app.config(
	function($routeProvider)
	{
		var userData;
		
		var authProvider = function($rootScope, $window, $q, $http)
		{
			var deferred = $q.defer();
			
			$http.get('/ajax/auth')
				.then(function success(response)
				{
					if(!response.data.authenticated)
					{
						$rootScope.promptLogin({
							unsavedData: false,
							redirectURL: '/auth/login/?ref=admin&route=' + $window.location.hash.substr(1),
							callback: function(response)
							{
								deferred.resolve(response.data);
								
								$rootScope.userData = response.data;
								$rootScope.userData.lastCheck = Date.now();
							}
						});
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
					
					var hash = $window.location.hash.substr(1);
					$window.location.hash = '';
					$window.location = "/auth/login/?ref=admin&route=" + hash;
				});
			
			return deferred.promise;
		}
		
		$routeProvider
			.when('/', {
				controller: 'IndexController',
				templateUrl: '/ng/index',
				resolve: { authorization: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Courses
			
			.when('/courses', {
				controller: 'CoursesController',
				templateUrl: '/ng/courses.list',
				resolve: { authorization: authProvider, },
			})
			.when('/courses/new', {
				controller: 'CoursesFormController',
				templateUrl: '/ng/courses.form',
				resolve: { authorization: authProvider, },
			})
			.when('/courses/:id', {
				controller: 'CourseShowController',
				templateUrl: '/ng/courses.show',
				resolve: { authorization: authProvider, },
			})
			.when('/courses/:id/edit', {
				controller: 'CoursesFormController',
				templateUrl: '/ng/courses.form',
				resolve: { authorization: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Tests
			
			.when('/tests/new/:course_id', {
				controller: 'TestsFormController',
				templateUrl: '/ng/tests.form',
				resolve: { authorization: authProvider, },
			})
			.when('/tests/:id', {
				controller: 'TestsShowController',
				templateUrl: '/ng/tests.show',
				resolve: { authorization: authProvider, },
			})
			.when('/tests/:id/edit', {
				controller: 'TestsFormController',
				templateUrl: '/ng/tests.form',
				resolve: { authorization: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Users
			
			.when('/users', {
				controller: 'UsersController',
				templateUrl: '/ng/users.list',
				resolve: { authorization: authProvider, },
			})
			.when('/users/new/', {
				controller: 'UsersFormController',
				templateUrl: '/ng/users.form',
				resolve: { authorization: authProvider, },
			})
			.when('/users/:id/edit', {
				controller: 'UsersFormController',
				templateUrl: '/ng/users.form',
				resolve: { authorization: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Groups
			
			.when('/groups', {
				controller: 'GroupsController',
				templateUrl: '/ng/groups.list',
				resolve: { authorization: authProvider, },
			})
			.when('/groups/new/', {
				controller: 'GroupsFormController',
				templateUrl: '/ng/groups.form',
				resolve: { authorization: authProvider, },
			})
			.when('/groups/:id/edit', {
				controller: 'GroupsFormController',
				templateUrl: '/ng/groups.form',
				resolve: { authorization: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Archive
			
			.when('/archive/', {
				controller: 'ArchiveController',
				templateUrl: '/ng/archive.list',
				resolve: { authorization: authProvider, },
				reloadOnSearch: false,
			})
			.when('/archive/:id/reply', {
				controller: 'ArchiveFormController',
				templateUrl: '/ng/archive.form',
				resolve: { authorization: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Contentpage
			
			.when('/pages', {
				controller: 'PagesController',
				templateUrl: '/ng/pages.list',
				resolve: { authorization: authProvider, },
			})
			.when('/pages/new/', {
				controller: 'PagesFormController',
				templateUrl: '/ng/pages.form',
				resolve: { authorization: authProvider, },
			})
			.when('/pages/:id/edit', {
				controller: 'PagesFormController',
				templateUrl: '/ng/pages.form',
				resolve: { authorization: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Files
			
			.when('/files/', {
				controller: 'FilesController',
				templateUrl: '/ng/files',
				resolve: { authorization: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Misc
			
			.otherwise({
				redirectTo: '/',
				resolve: { authorization: authProvider, },
			});
	}
);

app.controller('AjaxLogin', function($rootScope, $scope, $window, $location, $routeParams, $http)
{
	$rootScope.promptLogin = function(options, callback)
	{
		if(typeof options == 'object')
		{
			$scope.unsavedData = options.unsavedData;
			$scope.redirectURL = options.redirectURL;
			$rootScope.login_callback = options.callback;
		}
		else
		{
			$scope.unsavedData = options;
			$rootScope.login_callback = callback;
		}
		
		$('#modal-login').modal({
			show: true,
			keyboard: false,
			backdrop: 'static',
		});
	}
	
	$scope.do_login = function()
	{
		$scope.verifying = true;
		$('#modal-login .errors').stop().fadeOut(200);
		
		$http.post('/ajax/login', {
			email: $scope.email,
			password: $scope.password,
			remember_me: $scope.remember_me
		}).then(function success(response)
			{
				$scope.verifying = false;
				
				if(response.data.success)
				{
					if(!response.data.canAccessAdminPanel)
					{
						$window.location = '/';
					}
					
					console.log("$rootScope.userData", $rootScope.userData);
					
					console.log("LOGIN DATA", response.data);
					
					console.log("$rootScope.userData", $rootScope.userData);
					
					$rootScope.userData = response.data;
					$scope.errors = [];
					
					$scope.email = '';
					$scope.password = '';
					$scope.remember_me = false;
					
					$('#modal-login').modal('hide');
					
					if($rootScope.login_callback)
					{
						$rootScope.login_callback(response);
					}
				}
				else
				{
					$('#modal-login .errors').stop().fadeIn(200);
					$scope.errors = response.data.errors;
				}
				
			}, function error(response)
			{
				$scope.verifying = false;
				console.log(response.status, response.data);
			});
	}
});

app.factory('$breadcrumbs', function($rootScope)
{
	var list = [];
	
	var title = false;
	
	return {
		title: function(title)
		{
			$rootScope.title = function()
			{
				if(typeof title == "function")
				{
					return title();
				}
				else
				{
					return title;
				}
			}
		},
		
		get: function()
		{
			return list;
		},
		reset: function()
		{
			list = [];
			$rootScope.$broadcast('breadcrumb_change');
			
			title = false;
			$rootScope.title = false;
		},
		segment: function(title, link, loaded)
		{
			var item = {};
			
			if(title !== undefined && title !== null)
			{
				Object.defineProperty(item, "title", {
					get: function() { return typeof title == "function" ? title() : title; },
				});
			}
			
			if(link !== undefined && link !== null)
			{
				Object.defineProperty(item, "link", {
					get: function() { return typeof link == "function" ? link() : link; },
				});
			}
			
			if(loaded !== undefined && loaded !== null)
			{
				Object.defineProperty(item, "loaded", {
					get: function() { return typeof loaded == "function" ? loaded() : loaded; },
				});
			}
			
			list.push(item);
			
			$rootScope.$broadcast('breadcrumb_change');
		},
	};
});

app.controller('Breadcrumbs', function($rootScope, $scope, $breadcrumbs)
{
	$rootScope.$on('breadcrumb_change', function()
	{
		$scope.breadcrumbs = $breadcrumbs.get();
	});
});

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

app.directive('elastic', [
    '$timeout',
    function($timeout) {
        return {
            restrict: 'A',
            link: function($scope, element) {
                $scope.initialHeight = $scope.initialHeight || element[0].style.height;
                var resize = function() {
                    element[0].style.height = $scope.initialHeight;
                    element[0].style.height = "" + element[0].scrollHeight + "px";
                };
                element.on("input change", resize);
                $timeout(resize, 0);
            }
        };
    }
]);

app.filter('trusted', function($sce)
{
	return function(html)
	{
		return $sce.trustAsHtml(html);
	}
});