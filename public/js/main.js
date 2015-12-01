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
	
	$('div.multitext .row.has-success input, div.multitext .row.has-error input').keypress(function()
	{
		$(this).parent().parent().removeClass('has-success has-error');
	});
	
});
