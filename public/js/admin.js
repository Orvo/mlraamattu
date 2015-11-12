$(function(){
	
	$('nav.navbar a').click(function()
	{
		$('nav.navbar li').removeClass('active');
		$(this).getParent().addClass('active');
	});

	console.log($('#content-sidebar.fixed').top());

});
