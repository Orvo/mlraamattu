$(function(){
	
	$('nav.navbar a').click(function()
	{
		$('nav.navbar li').removeClass('active');
		$(this).getParent().addClass('active');
	});
	
});
