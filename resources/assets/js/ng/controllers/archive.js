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
 	
 	$scope.searchName = '';
 	$scope.searchFilterParsed = '';
 	
 	$scope.currentPage = 1;
 	$scope.pagesList = [];
 	$scope.perPage = 10;
 	
 	$scope.filtered_archive = [];
 	$scope.paginated_archive = [];
 	
 	$scope.sorting = {
 		predicate: 'created_at',
 		reverse: true,
 	};
 	
 	$scope.setPredicate = function(predicate)
 	{
 		if($scope.sorting.predicate == predicate)
 		{
 			$scope.sorting.reverse = !$scope.sorting.reverse;
 		}
 		else
 		{
 			$scope.sorting.reverse = true;
 		}
 		
 		$scope.sorting.predicate = predicate;
 		$scope.update_pagination();
 	}
	
	$scope.update_filtering = function()
	{
		//archive | keyfilter : ({ key: 'user.name', value: searchName }) | filter : searchFilterParsed | filter : archiveFilter : true
		$scope.filtered_archive = $scope.archive;
		$scope.filtered_archive = $filter('filter')($scope.filtered_archive, $scope.searchFilterParsed);
		$scope.filtered_archive = $filter('filter')($scope.filtered_archive, $scope.archiveFilter, true);
		
		if($scope.searchName && $scope.searchName.length > 0)
		{
			$scope.filtered_archive = $filter('keyfilter')($scope.filtered_archive,
				{ key: 'user.name', value: $scope.searchName }
			);
		}
		
		$scope.update_pagination();
	}
	
	$scope.update_pagination = function()
	{
		if(!$scope.filtered_archive) return;
		
		var num_pages = Math.ceil($scope.filtered_archive.length / $scope.perPage);
		if(num_pages < $scope.currentPage)
		{
			$scope.currentPage = Math.max(1, num_pages);
		}
		
		var begin = ($scope.currentPage - 1) * $scope.perPage;
		var end = begin + $scope.perPage;
		
		$scope.filtered_archive = $filter('orderBy')($scope.filtered_archive, $scope.sorting.predicate, $scope.sorting.reverse);
		$scope.paginated_archive = $scope.filtered_archive.slice(begin, end);
		
		$scope.pagesList = [];
		for(var i=0; i<num_pages; ++i)
		{
			$scope.pagesList.push(i+1);
		}
	}
	
	$scope.go_to_page = function(pageNumber)
	{
		$scope.currentPage = pageNumber;
		if($scope.currentPage < 1) $scope.currentPage = 1;
		if($scope.currentPage > $scope.pagesList.length) $scope.currentPage = $scope.pagesList.length;
		
		$scope.update_pagination();
		
		return false;
	}
	
	$scope.$watchGroup(['archiveFilter.discarded', 'archiveFilter.replied_to', 'searchFilter'], function()
	{
		$scope.update_filtering();
	});
	
	$http.get('/ajax/archive').then(function success(response)
	{
		if(response)
		{
			console.log(response.data);
			
			$scope.archive = response.data;
			
			angular.forEach($scope.archive, function(item, key)
			{
				item.test_id = parseInt(item.test_id);
				item.course_id = parseInt(item.test.course.id);
				
				item.replied_to = parseInt(item.replied_to);
				item.discarded = parseInt(item.discarded) ? 1 : 0;
				
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
			
			$scope.update_filtering();
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
		
		$scope.update_filtering();
	}
	
	$scope.reset_select_filter(true);
	
	$scope.course_filter_changed = function()
	{
		$scope.archiveFilter.course_id = $scope.select_filters.course.id;
		
		$scope.select_filters.test = $scope.tests[0];
		$scope.archiveFilter.test_id = undefined;
		
		$location.search('course', $scope.archiveFilter.course_id);
		$location.search('test', undefined);
		
		$scope.update_filtering();
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
		
		$scope.update_filtering();
	}
	
	$scope.save_success = $rootScope.archiveFeedbackSent;
	$rootScope.archiveFeedbackSent = false;
	
	$scope.discard = function(item)
	{
		$http.post('/ajax/archive/' + item.id + '/discard').then(function success(response)
		{
			if(response && response.data.success)
			{
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
	
	$scope.revalidate_test = function(item)
	{
		item.processing = true;
		
		$http.post('/ajax/archive/' + item.id + '/revalidate')
		.then(function success(response)
		{
			item.processing = false;
			
			if(response.data.success)
			{
				item.data = response.data.data;
			}
		}, function error(response)
		{
			item.processing = false;
		});
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
