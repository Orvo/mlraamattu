
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

	$scope.bulk_actions = [];

	TestsModel.get({id: $scope.id}, function(test)
	{
		console.log(test);
		$scope.data = {
			test: test,
		};

		$scope.loaded = true;
	});

	$scope.edit_data = false;

	$scope.edit = function(key)
	{
		if($scope.edit_data)
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

		$('.question.active').removeClass('active');
		$('#question-' + key).addClass('active');

		$scope.edit_data = {
			key: key,
			copy: angular.copy($scope.data.test.questions[key]),
		};
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
		$('button.edit-btn').show();

		if($scope.edit_data || $scope.edit_data !== false)
		{
			if($scope.edit_data.copy)
			{
				$scope.data.test.questions[$scope.edit_data.key] = angular.copy($scope.edit_data.copy);
			}
			
			$scope.edit_data = false;
		}
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
		$scope.data.test.questions.push({
			type: 'MULTI',
			title: 'Uusi kysymys',
			subtitle: '',
			answers: [],
		});

		var key = $scope.data.test.questions.length-1;

		// $scope.edit(key);

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
