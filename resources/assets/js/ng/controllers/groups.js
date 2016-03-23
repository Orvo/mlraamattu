// ----------------------------------------------------------------------------------------------------
// Users controllers

app.controller('GroupsController', function($scope, $window, $location, $routeParams, $breadcrumbs, authorization, GroupsModel, UsersModel)
{
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

app.controller('GroupsFormController', function($rootScope, $scope, $window, $location, $filter, $routeParams, $breadcrumbs, $http, GroupsModel, UsersModel, authorization)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Ryhmät', '#/groups/');
	
	$scope.id = $routeParams.id;
	
	if(!$scope.id)
	{
		$breadcrumbs.title('Uusi ryhmä');
	}
	else
	{
		$breadcrumbs.title('Muokataan ryhmää');
	}
	
	$scope.data = {};
	
	$scope.group_teacher = null;
	
	UsersModel.query(function(data)
	{
		$scope.users = $filter('filter')(data, {access_level: '!USER'});
		
		angular.forEach($scope.users, function(value, key)
		{
			if(value.id == authorization.user.id)
			{
				$scope.group_teacher = value;
			}
		});
	});
	
	$scope.group_teacher_change = function()
	{
		$scope.data.group.teacher_id = $scope.group_teacher.id;
	}
	
	if(!$scope.id)
	{
		$scope.data.group = new GroupsModel;
		$scope.data.group.teacher_id = authorization.user.id;
		
		$scope.loaded = true;
		
		$breadcrumbs.segment('Uusi ryhmä');
	}
	else
	{
		GroupsModel.get({id: $routeParams.id}, function(data)
		{
			$scope.data.group = data;
			$scope.loaded = true;
			
			$breadcrumbs.title('Muokataan ryhmää ' + $scope.data.group.title);
			$breadcrumbs.segment('Muokataan ryhmää');
			
			angular.forEach($scope.users, function(value, key)
			{
				if(value.id == $scope.data.group.teacher_id)
				{
					$scope.group_teacher = value;
				}
			});
		});
	}
	
	$scope.submit = function(data)
	{
		$scope.processing = true;
		
		var do_submit = function()
		{
			$scope.save_success = false;
			
			if($scope.id) // existing entry
			{
				$scope.data.group = GroupsModel.update({id: $scope.id}, $scope.data.group, function(data)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.group_edited !== undefined)
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
				$scope.data.group.$save(function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.group_created)
					{
						$location.path('/groups/');
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
