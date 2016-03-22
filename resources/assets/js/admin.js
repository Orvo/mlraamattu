$(window).load(function()
{
	var sidebar_height = $('#content-sidebar').height();
	var maincontent_height = $('#content-main').height();
	
	$(document).scroll(function()
	{
		var sidebar_height = $('#content-sidebar').height();
		var maincontent_height = $('#content-main').height();
		
		if($('#content-sidebar.fixed'))
		{
			var offset = Math.max(0, Math.min(maincontent_height-sidebar_height, $(document).scrollTop()));
			$('#content-sidebar.fixed').css({'margin-top': offset + 'px'});
		}
	});
	
	$('nav.navbar .dropdown-toggle, .list-actions a').click(function(e)
	{
		e.preventDefault();
	});

});
