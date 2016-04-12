// ----------------------------------------------------------------------------------------------------
// Pages controllers

var tagify = function(input)
{
	if(!input) return "";
	
	var input = input.toLowerCase();
	input = input.replace(/( )+/g, "-");
	input = input.replace(/[åä]/g, "a");
	input = input.replace(/[ö]/g, "o");
	input = input.replace(/[^a-zA-Z0-9\-]/g, "");
	
	return input;
}

app.controller('PagesController', function($scope, $window, $location, $routeParams, $breadcrumbs, PagesModel)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Sisältösivut');
	$breadcrumbs.title('Sisältösivut');
	
	$scope.searchFilter = '';
	
	$scope.pages = PagesModel.query(function(data)
	{
		$scope.loaded = true;
	});
	
	$scope.modal_info = false;
	
	$scope.delete = function(page)
	{
		$scope.modal_info = {
			page: page,
		};

		$('#modal-delete-confirmation').modal('show');
	}
	
	$scope.confirmed_delete = function()
	{
		var index;
		angular.forEach($scope.pages, function(value, key)
		{
			if(value.id == $scope.modal_info.page.id)
			{
				$scope.pages.splice(key, 1);
			}
		});
		
		PagesModel.delete({id: $scope.modal_info.page.id});
		$scope.modal_info = false;

		$('#modal-delete-confirmation').modal('hide');
	}
});

app.controller('PagesFormController', function($rootScope, $scope, $window, $location, $routeParams, $breadcrumbs, $http, PagesModel)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Sisältösivut', '#/pages/');
	
	$scope.id = $routeParams.id;
	
	if(!$scope.id)
	{
		$breadcrumbs.title('Uusi sivu');
	}
	else
	{
		$breadcrumbs.title('Muokataan sivua');
	}
	
	$scope.data = {};
	
	$scope.editor_options = {
		language: 'fi',
		autoGrow_minHeight: 250,
		autoGrow_maxHeight: 500,
		autoGrow_bottomSpace: 50,
	};
	
	$scope.$watch('data.page.title', function(new_value, old_value)
	{
		if(!$scope.data.page) return;
		if($scope.id) return;
		if(tagify(old_value) != $scope.data.page.tag && $scope.data.page.tag.length > 0) return;
		
		$scope.data.page.tag = tagify(new_value);
	});
	
	$scope.$watch('data.page.tag', function(new_value, old_value)
	{
		if(!$scope.data.page) return;
		
		$scope.data.page.tag = tagify(new_value);
	});
	
	if(!$scope.id)
	{
		$scope.data.page = new PagesModel;
		$scope.data.page.pinned = 0;
		
		$scope.loaded = true;
		
		$breadcrumbs.segment('Uusi sivu');
	}
	else
	{
		PagesModel.get({id: $routeParams.id}, function(data)
		{
			$scope.data.page = data;
			$scope.loaded = true;
			
			$breadcrumbs.title('Muokataan sivua ' + $scope.data.page.name);
			$breadcrumbs.segment('Muokataan sivua');
		});
	}
	
	$scope.submit = function(data)
	{
		$scope.processing = true;
		
		var do_submit = function()
		{
			$scope.save_success = false;
			// $scope.data.errors = [];
			
			if($scope.data.page.tag.length == 0)
			{
				$scope.data.page.tag = tagify($scope.data.page.title);
			}
			
			if($scope.id) // existing entry
			{
				$scope.data.page = PagesModel.update({id: $scope.id}, $scope.data.page, function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.page_edited !== undefined)
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
				$scope.data.page.$save(function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.page_created)
					{
						$location.path('/pages/');
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
