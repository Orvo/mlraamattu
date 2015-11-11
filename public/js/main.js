$(function(){
	
	$('ul.dropdown').each(function(){
		var that = this;
		$(this).parent().hover(function()
		{
			$(that).stop().fadeTo(150, 1.0);
		},
		function()
		{
			$(that).stop().fadeTo(250, 0.0, function()
			{
				$(this).hide();
			});
		});
	});
	
	var updateNavbarScroll = function()
	{
		var ypos = 150 - $(window).scrollTop();
		$("nav").css('top', Math.max(0, ypos) + 'px');
		
		var op = Math.max(0.0, Math.min(1.0, (150-(ypos+150))/50.0));
		
		$('#top-link').css({
			'opacity': op
		});
	}
	
	updateNavbarScroll();
	
	$(window).scroll(function()
	{
		updateNavbarScroll();
	});
	
	$('#top-link a').click(function(e)
	{
		$('html').animate({scrollTop: 0}, 250, 'easeOutCirc');
		e.preventDefault();
	});
	
	$.fn.accordionToggle = function(duration, easing, complete)
	{
		duration = duration || 200;
		easing = easing || null;
		complete = complete || null;
		
		var toggle = $(this).attr('data-toggle') || 0;
		if(!toggle)
		{
			$(this).accordionOpen(duration, easing, complete);
		}
		else
		{
			$(this).accordionClose(duration, easing, complete);
		}
		
		return this;
	}
	
	$.fn.accordionOpen = function(duration, easing, complete)
	{
		duration = duration || 200;
		easing = easing || null;
		complete = complete || null;
		
		$(this).stop().animate({
				height: $(this).attr('data-height')
			}, duration, easing, complete)
			.attr('data-toggle', 1)
			.addClass('open').removeClass('collapsed');
		
		$(this).find('div.readmore').stop().fadeTo(200, 0.0, function()
		{
			$(this).hide();
		});
	}
	
	$.fn.accordionClose = function(duration, easing, complete)
	{
		if($(this).hasClass('sticky')) return;
		
		minheight = $(this).parent().attr('data-min-height') || 0;
		minheight = Math.min(minheight, $(this).attr('data-height'));
		
		duration = duration || 200;
		easing = easing || null;
		complete = complete || function(){};
		
		var that = this;
		
		$(this).stop().animate({
				height: minheight
			}, duration, easing, function(a, b, c, d, e)
			{
				complete(a, b, c, d, e);
				
				$(that).addClass('collapsed').removeClass('open');
			})
			.attr('data-toggle', null);
		
		$(this).find('div.readmore').stop().fadeTo(200, 1.0);
	}
	
	var opened = false;
	
	$('.accordion > div').each(function(index)
	{
		var height = $(this).height();
		var minheight = $('.accordion').attr('data-min-height') || 0;
		
		minheight = Math.min(minheight, height);
		
		if(!$(this).hasClass('sticky') && opened == false)
		{
			$(this).addClass('open');
			opened = true;
		}
		
		if(index == 0)
		{
			$(this).addClass('open');
		}
		
		if(!($(this).hasClass('open') || $(this).hasClass('sticky')))
		{
			$(this).css('height', minheight+'px');
			$(this).addClass('collapsed');
		}
		else
		{
			$(this).find('div.readmore').hide();
		}
		
		$(this).attr('data-height', height);
		
		var that = this;
		
		$(this).find('div.actions a.collapse').click(function(e)
		{
			$(that).accordionClose(400, 'easeOutExpo');
			e.preventDefault();
		});
	});
	
	$('.accordion h2').click(function()
	{
		$(this).next().click();
	});
	
	$('.accordion > div').click(function()
	{
		if($(this).hasClass('sticky')) return;
		
		var that = this;
		
		$('.accordion > div.open').each(function()
		{
			if(that != this)
			{
				$(this).accordionClose(400, 'easeOutExpo');	
			}
		});
		
		if($(this).hasClass('collapsed'))
		{
			$(this).accordionOpen(400, 'easeOutExpo');	
		}
		
		// var pos = $(this).prev().offset();
		// $('html').animate({scrollTop: pos.top - 150}, 500, 'easeOutExpo');
		
	});
	
});
