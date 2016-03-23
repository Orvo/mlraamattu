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
		
		angular.forEach($scope.course.tests, function(value, key)
		{
			if(value.id == $scope.modal_info.test.id)
			{
				$scope.course.tests.splice(key, 1);
			}
		});
		
		TestsModel.delete({id: $scope.modal_info.test.id});
		
		
		$scope.processing = false;
		$('#modal-delete-confirmation').modal('hide');
		$scope.modal_info = false;
		
		/*$scope.processing = true;
		CoursesModel.get({id: $scope.id}, function(data)
		{
			$scope.course = data;
			$scope.processing = false;
			
			$('#modal-delete-confirmation').modal('hide');
		
			$scope.modal_info = false;
		});*/
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
