$(window).load(function()
{

	$(document).scroll(function()
	{
		if($('#content-sidebar').hasClass('fixed'))
		{
			$('#content-sidebar').css({'margin-top': $(document).scrollTop() + 'px'});
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
		
		$('#content-sidebar .sidebar-help').height(height - 120 - $('#content-sidebar .sidebar-actions').height());
	}
	
	doResize();
	doResize();
	
	$(window).resize(function()
	{
		doResize();
	});
	
	$('.search-filter').focus(function()
	{
		console.log($(this));
		$(this).addClass('focused');
	});
	
	// $('nav.navbar a').click(function()
	// {
	// 	$('nav.navbar li').removeClass('active');
	// 	$(this).parent().addClass('active');
	// });
	
	$('nav.navbar .dropdown-toggle, .list-actions a').click(function(e)
	{
		e.preventDefault();
	});

});
