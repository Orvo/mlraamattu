
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
	
var popError = function(data)
{
	var pop = window.open('', 'Error', 'width=1280,height=720');
	pop.document.write(data);
	pop.document.close();
	
	console.log("ERROR", data);
}

var convertToDate = function(timestamp)
{
	var t = timestamp.split(/[- :]/);
	return new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
}

// ----------------------------------------------------------------------------------------------------
// Index controller

app.controller('IndexController', function($scope, $window, $location, $routeParams, $http)
{
	$http.get('/ajax/recent')
	.then(function success(response)
	{
		console.log(response);
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

// ----------------------------------------------------------------------------------------------------
// Course controllers

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

app.controller('CourseShowController', function($scope, $window, $location, $routeParams, CoursesModel)
{
	$scope.id = $routeParams.id;
			
	$scope.isEditing = false;
	$scope.startEditing = function()
	{
		$scope.isEditing = true;
	}
	
	$scope.saveCourseInfo = function()
	{
		$scope.isEditing = false;
	}

	CoursesModel.get({id: $scope.id}, function(data)
	{
		$scope.course = data;
		$scope.loaded = true;
	}, function(data)
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

app.controller('CoursesFormController', function($scope, $window, $location, $routeParams, CoursesModel)
{
	$scope.id = $routeParams.id;
	console.log($routeParams.id);
	
	if($scope.id)
	{
		CoursesModel.get({id: $scope.id}, function(data)
		{
			$scope.data.course = data;
			$scope.loaded = true;
		}, function(data)
		{
			if(data.status == 404)
			{
				$location.path('/tests').search({error: 404});
			}
		});
	}
	else
	{
		$scope.data = {
			course: new CoursesModel(),
		};
		
		$scope.loaded = true;
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
				$scope.data.test = TestsModel.update({id: $scope.id}, $scope.data.test, function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.test_edited !== undefined)
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
				$scope.data.test.$save(function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.test_created)
					{
						$location.path('/tests/' + data.test_created + '/edit');
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

// ----------------------------------------------------------------------------------------------------
// Users controllers

app.controller('UsersController', function($scope, $window, $location, $routeParams, UsersModel)
{
	$scope.users = UsersModel.query(function(data)
	{
		$scope.loaded = true;
	});
});

app.controller('UsersFormController', function($scope, $window, $location, $routeParams, UsersModel)
{
	$scope.id = $routeParams.id;
	$scope.data = {};
	
	UsersModel.get({id: $routeParams.id}, function(data)
	{
		$scope.data.user = data;
		$scope.loaded = true;
	});
});

// ----------------------------------------------------------------------------------------------------
// Tests controllers

app.controller('TestsController', function($scope, $window, $location, $routeParams, TestsModel)
{
	$scope.routeError = $routeParams.error;
	
	$scope.tests = TestsModel.query(function(data)
	{
		
	});
});

app.controller('TestsFormController', function($rootScope, $scope, $window, $location, $routeParams, $http, CoursesModel, TestsModel)
{
	$scope.id = $routeParams.id;
	$scope.course_id = $routeParams.course_id;

	$scope.edit_data = false;

	$scope.question_types = [
		'CHOICE',
		'MULTI',
		'TEXT',
		'MULTITEXT',
		'TEXTAREA',
	];
	
	$scope.isSorting = false;
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

	$scope.translate_type = translate_type;

	if($scope.id)
	{
		TestsModel.get({id: $scope.id}, function(data)
		{
			console.log(data);
			$scope.data = {
				test: data,
			};

			$scope.loaded = true;
		}, function(data)
		{
			if(data.status == 404)
			{
				$location.path('/tests').search({error: 404});
			}
		});
	}
	else
	{
		$scope.data = {
			test: new TestsModel(),
		};
		
		$scope.data.test.questions = [];

		CoursesModel.get({id: $scope.course_id}, function(data)
		{
			$scope.data.test.course = data;
			$scope.loaded = true;
		});

		$("#test-title").focus();
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
				$scope.data.test = TestsModel.update({id: $scope.id}, $scope.data.test, function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.test_edited !== undefined)
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
				$scope.data.test.$save(function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.test_created)
					{
						$location.path('/tests/' + data.test_created + '/edit');
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
		
		setTimeout(function()
		{
			$("html, body").stop().delay(50).animate({
				scrollTop: $('#question-' + key).position().top
			}, 400);
			
			$('#question-' + key + ' .question-title').select();
		}, 20);
	}
	
	$scope.accept = function(key)
	{
		$scope.edit_data = false;
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
		
		if($scope.data.errors && $scope.data.errors.fields.add_questions)
		{
			$scope.data.errors.fields.add_questions = false;
		}

		$scope.edit(key);

		$('#question-' + key).addClass('active');
	}
	
	$scope.changing_type = function(question, newType)
	{
		// Add new blank answers if changing type to specific types
		switch(newType)
		{
			case 'CHOICE':
			case 'MULTI':
			case 'MULTITEXT':
				if(question.answers.length < 2)
				{
					for(var i=0; i < 2-question.answers.length; ++i)
					{
						question.answers.push({
							text: '',
						});
					}
				}
			break;
		}
	}

	$scope.add_answer = {
		do: function(key)
		{
			var text = $scope.add_answer.text.trim();

			if(text.length > 0)
			{
				$scope.data.test.questions[key].answers.push({
					text: text,
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
});

// ----------------------------------------------------------------------------------------------------
// Archive controllers

app.controller('ArchiveController', function($rootScope, $scope, $window, $location, $routeParams, $http)
{
	$http.get('/ajax/archive').then(function success(response)
	{
		if(response)
		{
			$scope.archive = response.data;
		}
	})
});

// ----------------------------------------------------------------------------------------------------
// Navbar controllers

app.controller('NavbarController', function($rootScope, $scope, $window, $location, $routeParams, $http)
{
	$rootScope.update_archive_stats = function()
	{
		$http.get('/ajax/archive/stats').then(function success(response)
		{
			$scope.test_records = response.data;
		});
	}
	
	setInterval(function()
	{
		$rootScope.update_archive_stats();
	}, 15 * 60 * 1000);
	
	$rootScope.update_archive_stats();
});
