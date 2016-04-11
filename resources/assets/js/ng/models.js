
/*
 * Models
 */
 
app.factory('QuestionsModel', function($resource)
{
	return $resource('/ajax/questions/:id', { id: '@_id' },
	{
		'get': { method: 'GET' },
		'new': { method: 'POST' },
		'update': { method: 'PUT' },
	});
});
 
app.factory('CoursesModel', function($resource)
{
	return $resource('/ajax/courses/:id', { id: '@_id' },
	{
		'get': { method: 'GET' },
		'update': { method: 'PUT' },
	});
});
 
app.factory('TestsModel', function($resource)
{
	return $resource('/ajax/tests/:id', { id: '@_id' },
	{
		'get': { method: 'GET' },
		'update': { method: 'PUT' },
		'delete': { method: 'DELETE' },
	});
});

app.factory('UsersModel', function($resource)
{
	return $resource('/ajax/users/:id', { id: '@_id' },
	{
		'get': { method: 'GET' },
		'update': { method: 'PUT' },
	});
});

app.factory('GroupsModel', function($resource)
{
	return $resource('/ajax/groups/:id', { id: '@_id' },
	{
		'get': { method: 'GET' },
		'update': { method: 'PUT' },
	});
});

app.factory('PagesModel', function($resource)
{
	return $resource('/ajax/pages/:id', { id: '@_id' },
	{
		'get': { method: 'GET' },
		'update': { method: 'PUT' },
	});
});

app.factory('ArchiveModel', function($resource)
{
	return $resource('/ajax/archive/:id', { id: '@_id' },
	{
		'get': { method: 'GET' },
		'update': { method: 'PUT' },
	});
});
