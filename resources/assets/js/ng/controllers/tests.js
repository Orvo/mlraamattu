// ----------------------------------------------------------------------------------------------------
// Tests controllers

app.controller('TestsController', function($scope, $window, $location, $routeParams, $breadcrumbs, TestsModel)
{
	$breadcrumbs.reset();
	$breadcrumbs.segment('Kokeet');
	$breadcrumbs.title('Kokeet');
	
	$scope.routeError = $routeParams.error;
	
	$scope.tests = TestsModel.query(function(data)
	{
		
	});
});

app.controller('TestsFormController', function($rootScope, $scope, $window, $location, $routeParams, $q, $http, $breadcrumbs, CoursesModel, TestsModel)
{
	$scope.num_max_questions = 25;
	
	$scope.id = $routeParams.id;

	$scope.edit_data = false;

	$scope.question_types = [
		'CHOICE',
		'MULTI',
		'TEXT',
		'MULTITEXT',
		'TEXTAREA',
	];
	
	$breadcrumbs.reset();
	$breadcrumbs.segment('Kurssit', '#/courses/');
	$breadcrumbs.segment(
		function title() 	{ return $scope.loaded && $scope.data.test.course ? 'Kurssi: ' + $scope.data.test.course.title : ''; },
		function link()		{ return $scope.loaded && $scope.data.test.course ? '#/courses/' + $scope.data.test.course.id : ''; },
		function loaded() 	{ return $scope.loaded && $scope.courses_loaded; }
	);
	
	if(!$scope.id)
	{
		$breadcrumbs.title('Uusi koe');
	}
	else
	{
		$breadcrumbs.title('Muokataan koetta');
	}
	
	////////////////////////////////////////////////////
	
	$scope.activeTab = 2;
	$scope.setActiveTab = function(index)
	{
		$scope.activeTab = index;
	}
		
	////////////////////////////////////////////////////
	
	$scope.isSorting = false;
	
	$scope.startSorting = function()
	{
		$scope.isSorting = true;
		$scope.edit_data = false;
		
		$scope.setActiveTab(2);
	}
	
	$scope.stopSorting = function()
	{
		$scope.isSorting = false;
		$scope.edit_data = false;
	}
	
	$scope.sortableOptions = { axis: 'y', };
	
	//////////////
	
	$scope.editor_options = {
		language: 'fi',
		autoGrow_minHeight: 350,
		autoGrow_maxHeight: 500,
		autoGrow_bottomSpace: 50,
	};
	
	
	$scope.description_editor_options = {
		language: 'fi',
		autoGrow_minHeight: 150,
		autoGrow_maxHeight: 300,
		autoGrow_bottomSpace: 20,
	};
	
	$scope.test_material = '';

	$scope.translate_type = translate_type;
	
	$scope.data = {};
	
	$scope.selected_course = undefined;
	$scope.select_course = function(course_id)
	{
		angular.forEach($scope.data.courses, function(value, key){
			if(value.id == course_id)
			{
				$scope.selected_course = value;
				return false;
			}
		});
		
		$scope.update_course_selection($scope.selected_course);
	}
	
	$scope.update_course_selection = function(new_value)
	{
		$scope.data.test.course = new_value;
	}
	
	var query_courses = function(callback)
	{
		CoursesModel.query(function(data)
		{
			$scope.data.courses = data;
			
			$scope.select_course($scope.course_id);
			
			$scope.courses_loaded = true;
			$scope.loaded = true;
			
			if(callback)
			{
				callback();
			}
		});
	}
	
	if($scope.id)
	{
		TestsModel.get({id: $scope.id}, function(data)
		{
			$scope.data.test = data;
			$scope.course_id = $scope.data.test.course.id;
			
			if($scope.data.test.page.body.length == 0)
			{
				$scope.setActiveTab(1);
			}
			
			query_courses(function()
			{
				$breadcrumbs.segment('Muokataan koetta');
				$breadcrumbs.title('Muokataan koetta ' + $scope.data.test.title);
			});
		},
		function(data)
		{
			if(data.status == 404)
			{
				$location.path('/courses').search({error: 404});
			}
		});
	}
	else
	{
		$scope.data.test = new TestsModel();
		$scope.data.test.autodiscard = 0;
		$scope.data.test.questions = [];
		
		$scope.course_id = parseInt($routeParams.course_id);
		
		query_courses(function()
		{
			$breadcrumbs.segment('Uusi koe');
		});
		
		$("#test-title").focus();
	}
	
	$scope.updateQuestionData = function(question)
	{
		if(question.type == "MULTITEXT")
		{
			$scope.multitext_required = [];
			for(var i=2; i <= question.answers.length; ++i)
			{
				$scope.multitext_required.push(i);
			}
			
			if(!question.data.multitext_required || question.data.multitext_required > question.answers.length)
			{
				question.data.multitext_required = question.answers.length;
			}
		}
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
				console.log("Data", $scope.data.test);
				
				$scope.data.test = TestsModel.update({id: $scope.id}, $scope.data.test, function(data, h)
				{
					$scope.processing = false;
					$scope.data.errors = data.errors;
					
					if(data.test_edited !== undefined)
					{
						$scope.save_success = true;
						
						setTimeout(function()
						{
							$scope.save_success = false;
						}, 1500);
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
		}
		
		$scope.updateQuestionData($scope.data.test.questions[key]);

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
		$scope.setActiveTab(2);
		
		$scope.data.test.questions.push({
			type: 'CHOICE',
			title: 'Uusi kysymys',
			subtitle: '',
			correct_answer: 0,
			answers: [
				{
					text: "",
					error_margin: 10,
					is_correct: true,
				},
				{
					text: "",
					error_margin: 10,
					is_correct: false,
				},
			],
			data: {},
		});

		var key = $scope.data.test.questions.length-1;

		$scope.data.test.questions[key].order = key+1;
		
		$scope.updateQuestionData($scope.data.test.questions[key]);
		
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
							error_margin: 10,
						});
					}
				}
			break;
		}
		
		$scope.updateQuestionData(question);
	}

	$scope.add_answer = {
		do: function(key)
		{
			var text = $scope.add_answer.text.trim();

			if(text.length > 0)
			{
				$scope.data.test.questions[key].answers.push({
					text: text,
					error_margin: 10,
				});
			}

			$scope.add_answer.text = '';
			
			$scope.updateQuestionData($scope.data.test.questions[key]);
		},
		text: '',
	};

	$scope.remove_answer = function(qkey, akey)
	{
		var question = $scope.data.test.questions[qkey];
		
		question.answers.splice(akey, 1);
		
		$scope.updateQuestionData(question);
	}
	
	$scope.floor = Math.floor;
	
});
