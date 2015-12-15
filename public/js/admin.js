$(window).load(function()
{

	$(document).scroll(function()
	{
		if($('#content-sidebar').hasClass('fixed'))
		{
			$('#content-sidebar').css({'padding-top': $(document).scrollTop() + 'px'});
		}
	});
	
	var doResize = function(width)
	{
		if(width >= 1200)
		{
			$('#main-container').css('padding', '0 3%');	
		}
		else
		{
			$('#main-container').css('padding', '0 10px');
		}
	}
	doResize($(window).width());
	
	$(window).resize(function()
	{
		doResize($(window).width());
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
