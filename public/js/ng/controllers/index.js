// ----------------------------------------------------------------------------------------------------
// Index controllers

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