$(window).load(function()
{
	var sidebar_height = $('#content-sidebar').height();
	var sidebar_float = 0;
	var maincontent_height = $('#content-main').height();
	
	var updateSidebarMargin = function(delta)
	{
		if(delta === undefined) delta = 0;
		
		var window_height = $(window).height();
		
		//var sidebar_height = $('#content-sidebar').height();
		//var maincontent_height = $('#content-main').height();
		
		if($('#content-sidebar.fixed'))
		{
			if(sidebar_height > window_height)
			{
				sidebar_float = Math.max(0, Math.min(Math.abs(sidebar_height - window_height), sidebar_float + delta));
			}
			else
			{
				sidebar_float = 0;	
			}
			
			var offset = Math.max(0, Math.min(maincontent_height-sidebar_height, $(document).scrollTop()));
			$('#content-sidebar.fixed').css({'margin-top': offset + 'px'});
		}
	}
	
	var currentScroll = $(document).scrollTop();
	
	$(document).scroll(function()
	{
		var delta = $(document).scrollTop() - currentScroll;
		currentScroll = $(document).scrollTop();
		
		updateSidebarMargin(delta);
	});
	
	updateSidebarMargin();
	
	$('nav.navbar .dropdown-toggle, .list-actions a').click(function(e)
	{
		e.preventDefault();
	});

});
