
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

app.controller('IndexController', function($scope, $window, $location, $routeParams, QuestionsModel)
{
	QuestionsModel.query(function(data)
	{
		$scope.questions = data;
		
		angular.forEach($scope.questions, function(value, key)
		{
			$scope.questions[key].type = translate_type(value.type);
			$scope.questions[key].subtitle = nl2br(value.subtitle);
		});
	});
		
	$scope.sortableOptions = {
		axis: 'y',
	};
});

app.controller('CoursesController', function($scope, $window, $location, $routeParams, CoursesModel)
{
	$scope.loaded = false;
	$scope.courses = CoursesModel.query(function(data)
	{
		$scope.loaded = true;
	});
		
	$scope.sortableOptions = {
		axis: 'y',
	};
});

app.controller('CourseDisplayController', function($scope, $window, $location, $routeParams, CoursesModel)
{
	$scope.id = $routeParams.id;

	CoursesModel.get({id: $scope.id}, function(data)
	{
		if(!data.error)
		{
			$scope.course = data;
			$scope.loaded = true;
		}
		else
		{
			if(data.status == 404)
			{
				// alert("NOT FOUNDS");
			}
		}
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

app.controller('UsersController', function($scope, $window, $location, $routeParams, UsersModel)
{
	$scope.users = UsersModel.query(function(data)
	{
		$scope.loaded = true;
	});
});

app.controller('TestsFormController', function($scope, $window, $location, $routeParams, CoursesModel, TestsModel)
{
	$scope.id = $routeParams.id;
	$scope.course_id = $routeParams.course_id;

	$scope.bulk_actions = [];

	$scope.question_types = [
		'CHOICE',
		'MULTI',
		'TEXT',
		'MULTITEXT',
		'TEXTAREA',
	];

	$scope.translate_type = translate_type;
	
	$scope.submit = function(data)
	{
		if($scope.id) // existing entry
		{
			$scope.data.test = TestsModel.update({id: $scope.id}, $scope.data.test, function(data, h)
			{
				console.log("ASD", data, h);
			});
		}
		else // new entry
		{
			$scope.data.test.$save(function(data, h)
			{
				console.log(data, h);
			});
		}
	}

	if($scope.id)
	{
		TestsModel.get({id: $scope.id}, function(data)
		{
			console.log(data);
			$scope.data = {
				test: data,
			};

			$scope.loaded = true;
		});
	}
	else
	{
		$scope.data = {
			test: {
				questions: [],
			},
		}

		CoursesModel.get({id: $scope.course_id}, function(data)
		{
			$scope.data.test.course = data;
			$scope.loaded = true;
		});

		$("#test-title").focus();
	}

	$scope.edit_data = false;
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

		$('.question.active').removeClass('active');
		$('#question-' + key).addClass('active');

		$("html, body").stop().delay(50).animate({
			scrollTop: $('#question-' + key).position().top
		}, 400);
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

		console.log('#question-' + key, $('#question-' + key).html());
		console.log($scope.data.test.questions, $scope.data.test.questions.length);

		$scope.edit(key);

		$('#question-' + key).addClass('active');
	}

	$scope.add_answer = {
		do: function(key)
		{
			var text = $scope.add_answer.text.trim();

			if(text.length > 0)
			{
				$scope.data.test.questions[key].answers.push({
					title: text,
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
	
});
