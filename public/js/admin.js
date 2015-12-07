$(function()
{

	$(document).scroll(function()
	{
		if($('#content-sidebar').hasClass('fixed'))
		{
			$('#content-sidebar').css({'padding-top': $(document).scrollTop() + 'px'});
		}
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
