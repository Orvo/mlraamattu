$(function(){
	
	$('div.question .answer input, div.question .answer label').click(function()
	{
		if($(this).parent().find('input').is(':checked'))
		{
			$(this).parent().parent().find('.radio').removeClass('has-answer');
			// console.log($(this).parent().parent().find('input[type="radio"]'));
			$(this).parent().addClass('has-answer');
		}
		else
		{
			$(this).parent().removeClass('has-answer');
		}
		
	});
	
	$('div.question .row.has-success input, div.question .row.has-error input').keypress(function()
	{
		$(this).parent().parent().removeClass('has-success has-error');
	});
	
	////////////////////////////////////
	
	var updateScroll = function()
	{
		if($(document).scrollTop() >= 110)
		{
			$('header').addClass('fixed');
		}
		else
		{
			$('header').removeClass('fixed');
		}
	}
	
	$(document).scroll(function()
	{
		updateScroll();
	});
	
	updateScroll();
	
});
