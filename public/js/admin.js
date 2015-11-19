$(function(){
	
	$('nav.navbar a').click(function()
	{
		$('nav.navbar li').removeClass('active');
		$(this).getParent().addClass('active');
	});

	$(document).scroll(function()
	{
		if($('#content-sidebar').hasClass('fixed'))
		{
			$('#content-sidebar').css({'padding-top': $(document).scrollTop() + 'px'});
		}
	});

});
