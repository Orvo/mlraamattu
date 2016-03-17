// ----------------------------------------------------------------------------------------------------
// Files controllers

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