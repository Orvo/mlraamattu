// ----------------------------------------------------------------------------------------------------
// Users controllers

app.controller('GroupsController', function($scope, $window, $location, $routeParams, $breadcrumbs, GroupsModel, authorization)
{
	console.log("authorization", authorization);
	
	$breadcrumbs.reset();
	$breadcrumbs.segment('Ryhmät');
	$breadcrumbs.title('Ryhmät');
	
	$scope.filter = {
		
	};
	
	$scope.groups = GroupsModel.query(function(data)
	{
		$scope.loaded = true;
	});
	
	$scope.modal_info = false;
	
	$scope.showGroupUsers = function(group)
	{
		$scope.modal_info = {
			group: group,
		};

		$('#modal-group-students').modal('show');
	}
	
	$scope.delete = function(group)
	{
		$scope.modal_info = {
			group: group,
		};

		$('#modal-delete-confirmation').modal('show');
	}
	
	$scope.confirmed_delete = function()
	{
		var index;
		angular.forEach($scope.groups, function(value, key)
		{
			if(value.id == $scope.modal_info.group.id)
			{
				$scope.groups.splice(key, 1);
			}
		});
		
		GroupsModel.delete({id: $scope.modal_info.group.id});
		$scope.modal_info = false;

		$('#modal-delete-confirmation').modal('hide');
	}
});

app.controller('GroupsFormController', function($rootScope, $scope, $window, $location, $routeParams, $breadcrumbs, $http, UsersModel)
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
