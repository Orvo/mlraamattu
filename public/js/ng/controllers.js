
/*
 * Controllers
 */

app.controller('IndexController', function($scope, $window, $location, $routeParams, QuestionsModel)
{
	QuestionsModel.query(function(data)
	{
		$scope.questions = data;
		
		angular.forEach($scope.questions, function(value, key)
		{
			if(value.type == "CHOICE")
			{
				$scope.questions[key].type = "Yksivalinta";
			}
			else if(value.type == "MULTI")
			{
				$scope.questions[key].type = "Monivalinta";
			}
			else if(value.type == "TEXT")
			{
				$scope.questions[key].type = "Teksti";
			}
			else if(value.type == "TEXTAREA")
			{
				$scope.questions[key].type = "Pitkä teksti";
			}
			else if(value.type == "MULTITEXT")
			{
				$scope.questions[key].type = "Moniteksti";
			}
		});
	});
		
	$scope.sortableOptions = {
		axis: 'y',
	};
});

app.controller('CoursesController', function($scope, $window, $location, $routeParams, CoursesModel)
{
	$scope.courses = CoursesModel.query(function(data)
	{
		
	});
		
	$scope.sortableOptions = {
		axis: 'y',
	};
});

app.controller('CoursesFormController', function($scope, $window, $location, $routeParams, CoursesModel)
{
	$scope.id = $routeParams.id;
});

app.controller('TestsController', function($scope, $window, $location, $routeParams, TestsModel)
{
	$scope.tests = TestsModel.query(function(data)
	{
		
	});
});

app.controller('TestsFormController', function($scope, $window, $location, $routeParams, TestsModel)
{
	$scope.id = $routeParams.id;

	TestsModel.get({id: $scope.id}, function(test)
	{
		console.log(test);
		$scope.data = {
			test: test,
		};
	});

	$scope.edit_data = false;

	$scope.edit = function(key)
	{
		if(!$scope.edit_data || $scope.edit_data !== false)
		{
			$scope.cancel();
		}

		$('.question.active').removeClass('active');
		$('#question-' + key).addClass('active');

		$scope.edit_data = {
			key: key,
			copy: $.extend({}, $scope.data.test.questions[key]),
		};
	}

	$scope.cancel = function()
	{
		$('.question.active').removeClass('active');
		$('button.edit-btn').show();

		if($scope.edit_data !== false)
		{
			$scope.data.test.questions[$scope.edit_data.key] = $.extend({}, $scope.edit_data.copy);
			$scope.edit_data = false;
		}
	}

	$scope.delete = function(key, id)
	{
		var question = $scope.data.test.questions[key];
		
		$scope.delete_info = {
			key: key,
			question: question,
		};

		$('#modal-delete-confirmation').modal('show');
	}

	$scope.confirmed_delete = function()
	{
		if(!$scope.delete_info || $scope.delete_info === false) return;

		$scope.data.test.questions.splice($scope.delete_info.key, 1);
		$scope.delete_info = false;

		$('#modal-delete-confirmation').modal('hide');
	}

	$scope.add_question = function()
	{
		$scope.data.test.questions.push({
			type: 'MULTI',
			title: 'Hello',
			subtitle: 'World',
			answers: [],
		});

		var key = $scope.data.test.questions.length-1;

		console.log($scope.data.test.questions, $scope.data.test.questions.length);

		$('#question-' + key).addClass('active');
	};

	$scope.removeChoice = function(q, c)
	{
		$scope.data.test.questions[q].choices.splice(c, 1);
	}

	$scope.addChoice = {
		do: function(key, qid)
		{
			var text = $scope.addChoice.text.trim();

			if(text.length > 0)
			{
				$scope.questions[key].choices.push({
					title: text,
				});
			}

			$scope.addChoice.text = '';
		},
		text: '',
	};

	$scope.sortableOptions = {
		axis: 'y',
		start: function(e, ui)
		{
			console.log(e, ui);
		},
		update: function(e, ui)
		{
			console.log(e, ui);
			if(ui.item.sortable.model)
			{

			}
		},
	};
});

app.controller('NavbarController', function($rootScope, $scope, $window, $location, $routeParams)
{
	// $scope.categories = CategoryModel.query(null, null, function(data)
	// {
	// 	if(data.status == 401)
	// 	{
	// 		$window.location = '/login';
	// 	}
	// });

	// $scope.changeCategory = function(id, $event)
	// {
	// 	if($location.path() != '/article/') return;

	// 	$event.preventDefault();

	// 	$rootScope.$broadcast('hello', {
	// 		id: id
	// 	});
	// }
});
