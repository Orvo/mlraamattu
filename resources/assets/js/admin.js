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
	
	var doResize = function()
	{
		var width = $(window).width();
		var height = $(window).height();
		
		if(width >= 1200)
		{
			$('#main-container').css({
				'padding-left': '3%',
				'padding-right': '3%',
			});
		}
		else
		{
			$('#main-container').css({
				'padding-left': '3%',
				'padding-right': '3%',
			});
		}
	}
	
	doResize();
	
	$(window).resize(function()
	{
		doResize();
	});
	
	$('nav.navbar .dropdown-toggle, .list-actions a').click(function(e)
	{
		e.preventDefault();
	});

});
