
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
							callback: function()
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
				resolve: { factory: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Courses
			
			.when('/courses', {
				controller: 'CoursesController',
				templateUrl: '/ng/courses.list',
				resolve: { factory: authProvider, },
			})
			.when('/courses/new', {
				controller: 'CoursesFormController',
				templateUrl: '/ng/courses.form',
				resolve: { factory: authProvider, },
			})
			.when('/courses/:id', {
				controller: 'CourseShowController',
				templateUrl: '/ng/courses.show',
				resolve: { factory: authProvider, },
			})
			.when('/courses/:id/edit', {
				controller: 'CoursesFormController',
				templateUrl: '/ng/courses.form',
				resolve: { factory: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Tests
			
			.when('/tests/new/:course_id', {
				controller: 'TestsFormController',
				templateUrl: '/ng/tests.form',
				resolve: { factory: authProvider, },
			})
			.when('/tests/:id', {
				controller: 'TestsShowController',
				templateUrl: '/ng/tests.show',
				resolve: { factory: authProvider, },
			})
			.when('/tests/:id/edit', {
				controller: 'TestsFormController',
				templateUrl: '/ng/tests.form',
				resolve: { factory: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Users
			
			.when('/users', {
				controller: 'UsersController',
				templateUrl: '/ng/users.list',
				resolve: { factory: authProvider, },
			})
			.when('/users/new/', {
				controller: 'UsersFormController',
				templateUrl: '/ng/users.form',
				resolve: { factory: authProvider, },
			})
			.when('/users/:id/edit', {
				controller: 'UsersFormController',
				templateUrl: '/ng/users.form',
				resolve: { factory: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Archive
			
			.when('/archive/', {
				controller: 'ArchiveController',
				templateUrl: '/ng/archive.list',
				resolve: { factory: authProvider, },
				reloadOnSearch: false,
			})
			.when('/archive/:id/reply', {
				controller: 'ArchiveFormController',
				templateUrl: '/ng/archive.form',
				resolve: { factory: authProvider, },
			})
			
			////////////////////////////////////////////////
			// Files
			
			.when('/files/', {
				controller: 'FilesController',
				templateUrl: '/ng/files',
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
				console.log(response.status, response.data);
				
				if(response.data.success)
				{
					if(!response.data.isAdmin)
					{
						$window.location = '/';
					}
					
					$rootScope.userData = response.data;
					$scope.errors = [];
					
					$scope.email = '';
					$scope.password = '';
					$scope.remember_me = false;
					
					$('#modal-login').modal('hide');
					
					if($rootScope.login_callback)
					{
						$rootScope.login_callback();	
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
});;
/*
 * Controllers
 */

var question_type_names = {
	CHOICE: 'Monivalinta (yksi)',
	MULTI: 'Monivalinta (moni)',
	TEXT: 'Teksti',
	MULTITEXT: 'Moniteksti',
	TEXTAREA: 'Pitkä teksti',
};

var translate_type = function(type)
{
	if(question_type_names[type])
	{
		return question_type_names[type];
	}

	return "Tuntematon tyyppi: " + type;
}

function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
	
var popError = function(data)
{
	var pop = window.open('', 'Error', 'width=1280,height=720');
	pop.document.write(data);
	pop.document.close();
	
	console.log("ERROR", data);
}

var convertToDate = function(timestamp)
{
	var t = timestamp.split(/[- :]/);
	return new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
}

// ----------------------------------------------------------------------------------------------------
// Index controller

app.controller('IndexController', function($scope, $window, $location, $routeParams, $http, $breadcrumbs)
{
	$breadcrumbs.reset();
	
	$http.get('/ajax/recent')
	.then(function success(response)
	{
		$scope.recent = response.data;
		
		angular.forEach($scope.recent.tests, function(value, key)
		{
			value.updated_at = convertToDate(value.updated_at);
		});
		
		angular.forEach($scope.recent.courses, function(value, key)
		{
			value.updated_at = convertToDate(value.updated_at);
		});
		
		$scope.loaded = true;
	},
	function error(response)
	{
		console.log("error", response);
	});
});

// ----------------------------------------------------------------------------------------------------
// File controllers

app.controller('FilesController', function($rootScope, $scope, $window, $location, $routeParams, $breadcrumbs)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Tiedostonhallinta');
	$breadcrumbs.title('Tiedostonhallinta');
	
	$scope.loaded = false;
	$scope.file_type = 'images';
	
	$scope.setFileType = function(type)
	{
		if(type == $scope.file_type) return;
		
		$scope.loaded = false;
		$scope.file_type = type;
	}
	
	$scope.kcfinderLoaded = function()
	{
		$scope.$apply(function()
		{
			$scope.loaded = true;
		});
	}
});

// ----------------------------------------------------------------------------------------------------
// Course controllers

app.filter('coursefilter', function()
{
	return function(list, settings)
	{
		var out = [];
		
		angular.forEach(list, function(value, key)
		{
			if(settings.published === undefined || settings.published == value.published || (settings.published == 0 && value.tests.length == 0))
			{
				out.push(value);
			}
		});
		
		return out;
	}
});

app.controller('CoursesController', function($scope, $window, $location, $routeParams, $breadcrumbs, $sce, CoursesModel)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Kurssit');
	$breadcrumbs.title('Kurssit');
	
	$scope.courseFilter = {
			
	};
	
	$scope.modal_info = false;
	
	$scope.delete = function(course)
	{
		$scope.modal_info = {
			course: course,
		}
		
		$('#modal-delete-confirmation').modal('show');
	}
	
	$scope.confirmed_delete = function()
	{
		if($scope.modal_info === false) return;
		
		CoursesModel.delete({id: $scope.modal_info.course.id});
		
		$scope.processing = true;
		
		CoursesModel.query(function(data)
		{
			$scope.courses = data;
			$scope.processing = false;
			
			$('#modal-delete-confirmation').modal('hide');
		
			$scope.modal_info = false;
		});
	}
	
	$scope.loaded = false;
	$scope.courses = CoursesModel.query(function(data)
	{
		$scope.loaded = true;
	});
		
	$scope.sortableOptions = {
		axis: 'y',
	};
});

app.controller('CourseShowController', function($scope, $window, $location, $routeParams, $http, $breadcrumbs, CoursesModel, TestsModel)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Kurssit', '#/courses/');
	$breadcrumbs.title('Kurssi');
	
	$scope.id = $routeParams.id;
	
	$scope.modal_info = false;
	
	$scope.delete = function(test)
	{
		$scope.modal_info = {
			test: test,
		}
		
		$('#modal-delete-confirmation').modal('show');
	}
	
	$scope.confirmed_delete = function()
	{
		if($scope.modal_info === false) return;
		
		TestsModel.delete({id: $scope.modal_info.test.id});
		
		$scope.processing = true;
		
		CoursesModel.get({id: $scope.id}, function(data)
		{
			$scope.course = data;
			$scope.processing = false;
			
			$('#modal-delete-confirmation').modal('hide');
		
			$scope.modal_info = false;
		});
	}

	CoursesModel.get({id: $scope.id}, function(data)
	{
		$scope.course = data;
		$scope.loaded = true;
		
		$breadcrumbs.segment(
			function title() 	{ return 'Kurssi: ' + $scope.course.title; },
			null,
			function loaded() 	{ return $scope.loaded; }
		);
		
		$breadcrumbs.title(function title(){ return 'Kurssi: ' + $scope.course.title; });
	},
	function(data)
	{
		if(data.status == 404)
		{
			$location.path('/tests').search({error: 404});
		}
	});
	
	$scope.sortableOptions = {
		axis: 'y',
	};
});

app.controller('CoursesFormController', function($rootScope, $scope, $window, $location, $routeParams, $http, $breadcrumbs, CoursesModel)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Kurssit', '#/courses/');
	
	$scope.id = $routeParams.id;
	
	if(!$scope.id)
	{
		$breadcrumbs.title('Uusi kurssi');
	}
	else
	{
		$breadcrumbs.title('Muokataan kurssia');
	}
	
	$scope.data = {};
	
	$scope.editor_options = {
		language: 'fi',
		autoGrow_minHeight: 200,
		autoGrow_maxHeight: 350,
		autoGrow_bottomSpace: 50,
	};
	
	////////////////////////////////////////////////////
	
	$scope.activeTab = 1;
	$scope.setActiveTab = function(index)
	{
		$scope.activeTab = index;
	}
	
	////////////////////////////////////////////////////
	
	if($scope.id)
	{
		CoursesModel.get({id: $scope.id}, function(data)
		{
			$scope.data.course = data;
			$scope.loaded = true;
			
			$breadcrumbs.segment('Muokataan kurssia');
			$breadcrumbs.title('Muokataan kurssia ' + $scope.data.course.title);
		},
		function(data)
		{
			if(data.status == 404)
			{
				$location.path('/courses').search({error: 404});
			}
		});
		
		$scope.sortableOptions = {
			axis: 'y',
		};
	}
	else
	{
		$scope.data.course = new CoursesModel();
		$scope.data.course.published = 0;
		
		$scope.loaded = true;
			
		$breadcrumbs.segment('Uusi kurssi');
	}
	
	$scope.submit = function(data)
	{
		$scope.processing = true;
		
		var do_submit = function()
		{
			$scope.edit_data = false;
			$scope.save_success = false;
			// $scope.data.errors = [];
			
			if($scope.id) // existing entry
			{
				$scope.data.course = CoursesModel.update({id: $scope.id}, $scope.data.course, function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.course_edited !== undefined)
					{
						$scope.save_success = true;
					}
				}, function(data)
				{
					popError(data.data);
					$scope.processing = false;
				});
			}
			else // new entry
			{
				$scope.data.course.$save(function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.course_created)
					{
						$location.path('/tests/new/' + data.course_created);
					}
				}, function(data)
				{
					popError(data.data);
					$scope.processing = false;
				});
			}
		}
		
		// Check authentication and show login form if not authenticated
		$http.get('/ajax/auth')
			.then(function success(response)
			{
				if(response.data.authenticated)
				{
					do_submit();
				}
				else
				{
					$rootScope.promptLogin(true, function()
					{
						do_submit();
					});
				}
			});
	}
});

// ----------------------------------------------------------------------------------------------------
// Users controllers

app.controller('UsersController', function($scope, $window, $location, $routeParams, $breadcrumbs, UsersModel)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Käyttäjät');
	$breadcrumbs.title('Käyttäjät');
	
	$scope.usersFilter = {
		accessLevel: undefined,
	};
	
	$scope.users = UsersModel.query(function(data)
	{
		$scope.loaded = true;
	});
	
	$scope.modal_info = false;
	
	$scope.delete = function(user)
	{
		$scope.modal_info = {
			user: user,
		};

		$('#modal-delete-confirmation').modal('show');
	}
	
	$scope.confirmed_delete = function()
	{
		var index;
		angular.forEach($scope.users, function(value, key)
		{
			if(value.id == $scope.modal_info.user.id)
			{
				$scope.users.splice(key, 1);
			}
		});
		
		UsersModel.delete({id: $scope.modal_info.user.id});
		$scope.modal_info = false;

		$('#modal-delete-confirmation').modal('hide');
	}
});

app.controller('UsersFormController', function($rootScope, $scope, $window, $location, $routeParams, $breadcrumbs, $http, UsersModel)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Käyttäjät', '#/users/');
	
	$scope.id = $routeParams.id;
	
	if(!$scope.id)
	{
		$breadcrumbs.title('Uusi käyttäjä');
	}
	else
	{
		$breadcrumbs.title('Muokataan käyttäjää');
	}
	
	$scope.data = {};
	
	$scope.access_levels = {
		'USER': {
			level: 'USER',
			description: 'Tavallinen käyttäjä (voi vastata kokeisiin)',
		},
		'TEACHER': {
			level: 'TEACHER',
			description: 'Opettaja (voi tarkistaa kokeiden suorituksia)',
		},
		'ADMIN': {
			level: 'ADMIN',
			description: 'Ylläpitäjä (voi luoda ja muokata kokeita, hallita käyttäjiä)',
		},
	};
	
	$scope.access_level_change = function()
	{
		$scope.data.user.access_level = $scope.access_level.level;
	}
	
	if(!$scope.id)
	{
		$scope.data.user = new UsersModel;
		$scope.loaded = true;
		
		$scope.access_level = $scope.access_levels[0];
		
		$breadcrumbs.segment('Uusi käyttäjä');
	}
	else
	{
		UsersModel.get({id: $routeParams.id}, function(data)
		{
			$scope.data.user = data;
			$scope.loaded = true;
			
			$scope.access_level = $scope.access_levels[$scope.data.user.access_level];
			
			$breadcrumbs.title('Muokataan käyttäjää ' + $scope.data.user.name);
			$breadcrumbs.segment('Muokataan käyttäjää');
		});
	}
	
	$scope.submit = function(data)
	{
		$scope.processing = true;
		
		var do_submit = function()
		{
			$scope.save_success = false;
			// $scope.data.errors = [];
			
			if($scope.id) // existing entry
			{
				$scope.data.user = UsersModel.update({id: $scope.id}, $scope.data.user, function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if($scope.data.user.id == $rootScope.userData.user.id)
					{
						$rootScope.updateUserData();
					}
					
					if(data.user_edited !== undefined)
					{
						$scope.save_success = true;
						
						$scope.data.user.password = '';
						$scope.data.user.password_confirmation = '';
					}
				}, function(data)
				{
					popError(data.data);
					$scope.processing = false;
				});
			}
			else // new entry
			{
				$scope.data.user.$save(function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.user_created)
					{
						$location.path('/users/');
					}
				}, function(data)
				{
					popError(data.data);
					$scope.processing = false;
				});
			}
		}
		
		// Check authentication and show login form if not authenticated
		$http.get('/ajax/auth')
			.then(function success(response)
			{
				if(response.data.authenticated)
				{
					do_submit();
				}
				else
				{
					$rootScope.promptLogin(true, function()
					{
						do_submit();
					});
				}
			});
	}
});

// ----------------------------------------------------------------------------------------------------
// Tests controllers

app.controller('TestsController', function($scope, $window, $location, $routeParams, $breadcrumbs, TestsModel)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Kokeet');
	$breadcrumbs.title('Kokeet');
	
	$scope.routeError = $routeParams.error;
	
	$scope.tests = TestsModel.query(function(data)
	{
		
	});
});

app.controller('TestsFormController', function($rootScope, $scope, $window, $location, $routeParams, $q, $http, $breadcrumbs, CoursesModel, TestsModel)
{
	$scope.num_max_questions = 25;
	
	$scope.id = $routeParams.id;

	$scope.edit_data = false;

	$scope.question_types = [
		'CHOICE',
		'MULTI',
		'TEXT',
		'MULTITEXT',
		'TEXTAREA',
	];
	
	$breadcrumbs.reset();
	$breadcrumbs.segment('Kurssit', '#/courses/');
	$breadcrumbs.segment(
		function title() 	{ return $scope.loaded && $scope.data.test.course ? 'Kurssi: ' + $scope.data.test.course.title : ''; },
		function link()		{ return $scope.loaded && $scope.data.test.course ? '#/courses/' + $scope.data.test.course.id : ''; },
		function loaded() 	{ return $scope.loaded && $scope.courses_loaded; }
	);
	
	if(!$scope.id)
	{
		$breadcrumbs.title('Uusi koe');
	}
	else
	{
		$breadcrumbs.title('Muokataan koetta');
	}
	
	////////////////////////////////////////////////////
	
	$scope.activeTab = 1;
	$scope.setActiveTab = function(index)
	{
		$scope.activeTab = index;
	}
		
	////////////////////////////////////////////////////
	
	$scope.isSorting = false;
	
	$scope.startSorting = function()
	{
		$scope.isSorting = true;
		$scope.edit_data = false;
		
		$scope.setActiveTab(2);
	}
	
	$scope.stopSorting = function()
	{
		$scope.isSorting = false;
		$scope.edit_data = false;
	}
	
	$scope.sortableOptions = { axis: 'y', };
	
	//////////////
	
	$scope.editor_options = {
		language: 'fi',
		autoGrow_minHeight: 350,
		autoGrow_maxHeight: 500,
		autoGrow_bottomSpace: 50,
	};
	
	
	$scope.description_editor_options = {
		language: 'fi',
		autoGrow_minHeight: 150,
		autoGrow_maxHeight: 300,
		autoGrow_bottomSpace: 20,
	};
	
	$scope.test_material = '';

	$scope.translate_type = translate_type;
	
	$scope.data = {};
	
	$scope.selected_course = undefined;
	$scope.select_course = function(course_id)
	{
		angular.forEach($scope.data.courses, function(value, key){
			if(value.id == course_id)
			{
				$scope.selected_course = value;
				return false;
			}
		});
		
		$scope.update_course_selection($scope.selected_course);
	}
	
	$scope.update_course_selection = function(new_value)
	{
		$scope.data.test.course = new_value;
	}
	
	var query_courses = function(callback)
	{
		CoursesModel.query(function(data)
		{
			$scope.data.courses = data;
			
			$scope.select_course($scope.course_id);
			
			$scope.courses_loaded = true;
			$scope.loaded = true;
			
			if(callback)
			{
				callback();
			}
		});
	}
	
	if($scope.id)
	{
		TestsModel.get({id: $scope.id}, function(data)
		{
			$scope.data.test = data;
			$scope.course_id = $scope.data.test.course.id;
			
			query_courses(function()
			{
				$breadcrumbs.segment('Muokataan koetta');
				$breadcrumbs.title('Muokataan koetta ' + $scope.data.test.title);
			});
		},
		function(data)
		{
			if(data.status == 404)
			{
				$location.path('/tests').search({error: 404});
			}
		});
	}
	else
	{
		$scope.data.test = new TestsModel();
		$scope.data.test.autodiscard = 0;
		$scope.data.test.questions = [];
		
		$scope.course_id = parseInt($routeParams.course_id);
		
		query_courses(function()
		{
			$breadcrumbs.segment('Uusi koe');
		});
		
		$("#test-title").focus();
	}
	
	$scope.submit = function(data)
	{
		$scope.processing = true;
		
		var do_submit = function()
		{
			$scope.edit_data = false;
			$scope.save_success = false;
			// $scope.data.errors = [];
			
			if($scope.id) // existing entry
			{
				$scope.data.test = TestsModel.update({id: $scope.id}, $scope.data.test, function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.test_edited !== undefined)
					{
						$scope.save_success = true;
					}
				}, function(data)
				{
					popError(data.data);
					$scope.processing = false;
				});
			}
			else // new entry
			{
				$scope.data.test.$save(function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.test_created)
					{
						$location.path('/tests/' + data.test_created + '/edit');
					}
				}, function(data)
				{
					popError(data.data);
					$scope.processing = false;
				});
			}
		}
		
		// Check authentication and show login form if not authenticated
		$http.get('/ajax/auth')
			.then(function success(response)
			{
				if(response.data.authenticated)
				{
					do_submit();
				}
				else
				{
					$rootScope.promptLogin(true, function()
					{
						do_submit();
					});
				}
			});
	}
	
	$scope.edit = function(key)
	{
		if($scope.edit_data !== false)
		{
			$scope.cancel();
			// var edit_key = $scope.edit_data.key;
			// var question = $scope.data.test.questions[edit_key];
		
			// $scope.modal_info = {
			// 	key: edit_key,
			// 	newKey: key,
			// 	question: question,
			// };

			// $('#modal-cancel-confirmation').modal('show');

			// return;
		}

		$scope.edit_data = {
			key: key,
			copy: angular.copy($scope.data.test.questions[key]),
		};
		
		setTimeout(function()
		{
			$("html, body").stop().delay(50).animate({
				scrollTop: $('#question-' + key).position().top
			}, 400);
			
			$('#question-' + key + ' .question-title').select();
		}, 20);
	}
	
	$scope.accept = function(key)
	{
		$scope.edit_data = false;
	}

	$scope.confirmed_cancel = function()
	{
		$scope.cancel();
		$scope.edit($scope.modal_info.newKey);
		$scope.modal_info = false;
		
		$('#modal-cancel-confirmation').modal('hide');
	}

	$scope.cancel = function()
	{
		$('.question.active').removeClass('active');

		$scope.add_answer.text = '';

		if($scope.edit_data)
		{
			if($scope.edit_data.copy)
			{
				$scope.data.test.questions[$scope.edit_data.key] = angular.copy($scope.edit_data.copy);
			}
		}

		$scope.edit_data = false;
	}

	$scope.delete = function(key, id)
	{
		var question = $scope.data.test.questions[key];
		
		$scope.modal_info = {
			key: key,
			question: question,
		};

		$('#modal-delete-confirmation').modal('show');
	}

	$scope.confirmed_delete = function()
	{
		if(!$scope.modal_info || $scope.modal_info === false) return;

		$scope.data.test.questions.splice($scope.modal_info.key, 1);
		$scope.modal_info = false;

		$('#modal-delete-confirmation').modal('hide');
	}

	$scope.add_question = function()
	{
		$scope.setActiveTab(2);
		
		$scope.data.test.questions.push({
			type: 'CHOICE',
			title: 'Uusi kysymys',
			subtitle: '',
			correct_answer: 0,
			answers: [
				{
					text: "",
					is_correct: true,
				},
				{
					text: "",
					is_correct: false,
				},
			],
		});

		var key = $scope.data.test.questions.length-1;

		$scope.data.test.questions[key].order = key+1;
		
		if($scope.data.errors && $scope.data.errors.fields.add_questions)
		{
			$scope.data.errors.fields.add_questions = false;
		}

		$scope.edit(key);

		$('#question-' + key).addClass('active');
	}
	
	$scope.changing_type = function(question, newType)
	{
		// Add new blank answers if changing type to specific types
		switch(newType)
		{
			case 'CHOICE':
			case 'MULTI':
			case 'MULTITEXT':
				if(question.answers.length < 2)
				{
					for(var i=0; i < 2-question.answers.length; ++i)
					{
						question.answers.push({
							text: '',
						});
					}
				}
			break;
		}
	}

	$scope.add_answer = {
		do: function(key)
		{
			var text = $scope.add_answer.text.trim();

			if(text.length > 0)
			{
				$scope.data.test.questions[key].answers.push({
					text: text,
				});
			}

			$scope.add_answer.text = '';
		},
		text: '',
	};

	$scope.remove_answer = function(qkey, ckey)
	{
		$scope.data.test.questions[qkey].answers.splice(ckey, 1);
	}
});

// ----------------------------------------------------------------------------------------------------
// Archive controllers

app.filter('archiveSelectFilter', function()
{
	return function(list, settings)
	{
		var out = [];
		var matchKeys = ['discarded', 'replied_to'];
		
		angular.forEach(list, function(value, key)
		{
			if(value.id === undefined)
			{
				out.push(value);
			}
			else
			{
				var hasMatch = false;
				
				for(x in matchKeys)
				{
					var key_name = matchKeys[x];
					
					if(settings[key_name] === undefined || value[key_name] == settings[key_name])
					{
						hasMatch = true;
						break;
					}
				}
				
				if(hasMatch)
				{
					out.push(value);
				}
			}
		});
		
		return out;
	}
});

app.filter('keyfilter', function()
{
	return function(list, settings)
	{
		var out = [];
		
		var resolveObjectKey = function(keypath, object)
		{
			var tokens = keypath.split('.');
			
			var value = object;
			for(var x in tokens)
			{
				value = value[tokens[x]];
			}
			
			return value;
		}
		
		angular.forEach(list, function(value, key)
		{
			var resolved = resolveObjectKey(settings.key, value);
			
			if(settings.value === undefined || resolved.toLowerCase().indexOf(settings.value.toLowerCase()) > -1)
			{
				out.push(value);
			}
		});
		
		return out;
	}
});

app.controller('ArchiveController', function($rootScope, $scope, $window, $location, $routeParams, $filter, $http, $breadcrumbs, $filter, TestsModel, CoursesModel)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Koesuoritukset');
	$breadcrumbs.title('Koesuoritukset');
	
	$scope.tests = { 0: { id: undefined, title: 'Rajaa kokeen mukaan', } };
 	$scope.courses = { 0: { id: undefined, title: 'Rajaa kurssin mukaan', } };
	
	$http.get('/ajax/archive').then(function success(response)
	{
		if(response)
		{
			$scope.archive = response.data;
			
			angular.forEach($scope.archive, function(item, key)
			{
				item.created_at = convertToDate(item.created_at);
				
				// item.test_id = parseInt(item.test.id);
				item.course_id = parseInt(item.test.course.id);
				
				item.replied_to = parseInt(item.replied_to);
				item.discarded = parseInt(item.discarded);
				
				if($scope.tests[item.test.id] === undefined)
				{
					$scope.tests[item.test.id] = item.test;
				}
				
				if($scope.courses[item.test.course.id] === undefined)
				{
					$scope.courses[item.test.course.id] = item.test.course;
				}
			});
			
			if($location.search().course)
			{
				$scope.select_filters.course = $scope.courses[$location.search().course];
				$scope.course_filter_changed();
			}
			else if($location.search().test)
			{
				$scope.select_filters.test = $scope.tests[$location.search().test];
				$scope.test_filter_changed();
			}
		}
	});
	
	var replied_translate = { hide: 0, show: 1, all: undefined, };
	var discarded_translate = { hide: 0, only: 1, show: undefined, };
	
	$scope.archiveFilter = {
		replied_to: $location.search().replied ? replied_translate[$location.search().replied] : 0,
		discarded: $location.search().discarded ? discarded_translate[$location.search().discarded] : 0,
	};
	
	$scope.$watch('searchFilter', function(new_value)
	{
		var query = $.trim(new_value);
		$location.search('q', query.length > 0 ? query : undefined);
		
		var pattern = /nimi:\"(.*?)\"/;
		var regex_match = query.match(pattern);
		
		if(regex_match !== null)
		{
			$scope.searchName = $.trim(regex_match[1]);
			$scope.searchFilterParsed = query.replace(pattern, '');
		}
		else
		{
			$scope.searchName = '';
			$scope.searchFilterParsed = query;
		}
	});
	
	$scope.searchFilter = $location.search().q;
	
	$scope.$watch('archiveFilter.replied_to', function(new_value)
	{
		var translated = '';
		if(new_value == 0) 			translated = 'hide';
		if(new_value == 1) 			translated = 'show';
		if(new_value === undefined) translated = 'all';
		
		$location.search('replied', translated);
	});
	
	$scope.$watch('archiveFilter.discarded', function(new_value)
	{
		var translated = '';
		if(new_value == 0) 			translated = 'hide';
		if(new_value == 1) 			translated = 'only';
		if(new_value === undefined) translated = 'show';
		
		$location.search('discarded', translated);
	});
	
	$scope.reset_select_filter = function(no_reset_search)
	{
		$scope.select_filters = {
			test: $scope.tests[0],
			course: $scope.courses[0],
		};
		
		$scope.archiveFilter.course_id = undefined;
		$scope.archiveFilter.test_id = undefined;
		
		if(!no_reset_search)
		{
			$location.search('course', undefined);
			$location.search('test', undefined);
		}
	}
	
	$scope.reset_select_filter(true);
	
	$scope.course_filter_changed = function()
	{
		$scope.archiveFilter.course_id = $scope.select_filters.course.id;
		
		$scope.select_filters.test = $scope.tests[0];
		$scope.archiveFilter.test_id = undefined;
		
		$location.search('course', $scope.archiveFilter.course_id);
		$location.search('test', undefined);
	}
	
	$scope.test_filter_changed = function()
	{
		$scope.archiveFilter.test_id = $scope.select_filters.test.id;
		
		if($scope.archiveFilter.test_id)
		{
			$scope.select_filters.course = $scope.select_filters.test.course;
			$scope.archiveFilter.course_id = $scope.select_filters.test.course.id;
		}
		else
		{
			$scope.select_filters.course = $scope.courses[0];
			$scope.archiveFilter.course_id = undefined;
		}
		
		$location.search('test', $scope.archiveFilter.test_id);
		$location.search('course', undefined);
	}
	
	$scope.save_success = $rootScope.archiveFeedbackSent;
	$rootScope.archiveFeedbackSent = false;
	
	$scope.discard = function(item)
	{
		$http.post('/ajax/archive/' + item.id + '/discard').then(function success(response)
		{
			if(response && response.data.success == true)
			{
				//$scope.archive[$scope.archive.indexOf(item)].discarded = true;
				item.discarded = 1;
				$rootScope.update_archive_stats();
			}
		});
	}
	
	$scope.show_feedback = function(item)
	{
		$scope.modal_info = item;
		$('#modal-display-feedback').modal('show');
	}
});

app.controller('ArchiveFormController', function($rootScope, $scope, $window, $location, $routeParams, $http, $breadcrumbs)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Koesuoritukset', '#/archive/');
	$breadcrumbs.title('Koepalautteen lähetys');
	
	$http.get('/ajax/archive/' + $routeParams.id).then(function success(response)
	{
		if(response)
		{
			$scope.data = {
				archive: response.data.data,
				validation: response.data.validation,
				user: response.data.user,
				test: response.data.test,
				course: response.data.test.course,
				indexed_answers: response.data.indexed_answers,
			};
			
			$breadcrumbs.segment('Koepalautteen lähetys');
			
			$scope.feedback = $scope.data.archive.feedback || {};
			
			$scope.loaded = true;
		}
	});
	
	$scope.submit = function()
	{
		$scope.processing = true;
		
		$http.put('/ajax/archive/' + $routeParams.id, {
			feedback: $scope.feedback,
		}).then(function success(response)
		{
			$scope.processing = false;
			$scope.save_success = true;
			
			if(response.data.success == 1)
			{
				$rootScope.archiveFeedbackSent = true;
				$rootScope.update_archive_stats();
				
				$location.path('/archive/');
			}
			else if(response.data.success == 0)
			{
				$scope.save_success = false;
				$scope.errors = response.data.errors;
			}

		}, function error(response)
		{
			$scope.save_success = false;
			$scope.errors = [
				"<b>" + response.status + "</b> " + response.statusText,
			];
			
			$scope.processing = false;
		});
	}
});

// ----------------------------------------------------------------------------------------------------
// Navbar controllers

app.controller('NavbarController', function($rootScope, $scope, $window, $location, $routeParams, $http, CoursesModel)
{
	$rootScope.update_archive_stats = function()
	{
		$http.get('/ajax/archive/stats').then(function success(response)
		{
			$scope.test_records = response.data;
		});
	}
	
	setInterval(function()
	{
		$rootScope.update_archive_stats();
	}, 5 * 60 * 1000);
	
	$rootScope.update_archive_stats();
	
	$scope.courses = CoursesModel.query();
});
;
/*
 * Models
 */
 
app.factory('QuestionsModel', function($resource)
{
	return $resource('/ajax/questions/:id', { id: '@_id' }, {
		'get': {
			method: 'GET'
		},
		'new': {
			method: 'POST'
		},
		'update': {
			method: 'PUT'
		},
	});
});
 
app.factory('CoursesModel', function($resource)
{
	return $resource('/ajax/courses/:id', { id: '@_id' }, {
		'get': {
			method: 'GET'
		},
		'update': {
			method: 'PUT'
		},
	});
});
 
app.factory('TestsModel', function($resource)
{
	return $resource('/ajax/tests/:id', { id: '@_id' }, {
		'get': {
			method: 'GET'
		},
		'update': {
			method: 'PUT'
		},
		'delete': {
			method: 'DELETE'
		},
	});
});

app.factory('UsersModel', function($resource)
{
	return $resource('/ajax/users/:id', { id: '@_id' }, {
		'get': {
			method: 'GET'
		},
		'update': {
			method: 'PUT'
		},
	});
});

app.factory('ArchiveModel', function($resource)
{
	return $resource('/ajax/archive/:id', { id: '@_id' }, {
		'get': {
			method: 'GET'
		},
		'update': {
			method: 'PUT'
		},
	});
});
