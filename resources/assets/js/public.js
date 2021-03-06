$(function()
{
	var sidebar_height = $('#sidebar-content .fixed').height();
	var sidebar_float = 0;
	var maincontent_height = $('#main-content').height();

	var stickyThreshold = 112;

	var updateSidebarMargin = function(delta)
	{
		if(delta === undefined) delta = 0;

		var window_height = $(window).height() - stickyThreshold;

		if($('#sidebar-content .fixed'))
		{
			if(sidebar_height > window_height)
			{
				sidebar_float = Math.max(0, Math.min(Math.abs(sidebar_height - window_height), sidebar_float + delta));
			}
			else
			{
				sidebar_float = 0;
			}

			var offset = Math.max(20, Math.min(maincontent_height - sidebar_height, $(document).scrollTop() - stickyThreshold - sidebar_float));
			$('#sidebar-content .fixed').css({'margin-top': offset + 'px'});
		}
	}

	var updateStickyHeader = function()
	{
		if($(document).scrollTop() >= stickyThreshold)
		{
			$('header').addClass('fixed');
		}
		else
		{
			$('header').removeClass('fixed');
		}
	}

	var currentScroll = $(document).scrollTop();

	$(document).scroll(function()
	{
		var delta = $(document).scrollTop() - currentScroll;
		currentScroll = $(document).scrollTop();

		updateSidebarMargin(delta);
		updateStickyHeader();
	});

	updateSidebarMargin();
	updateStickyHeader();

	////////////////////////////////////

	var onResize = function()
	{
		var width = $(window).width();
		if(width < 1000) //768
		{
			$('html').addClass('mobile-width').removeClass('desktop-width');
		}
		else
		{
			$('html').removeClass('mobile-width').addClass('desktop-width');
		}
	}

	$(window).resize(function()
	{
		onResize();
	});

	onResize();

	////////////////////////////////////

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

	$('a.spoiler-warning').click(function()
	{
		$(this).parent().addClass('spoiled');
	});

	$('#top-spoiler-warning a.spoiler-warning').click(function()
	{
		$('.correct-answers').addClass('spoiled');
		$('#top-spoiler-warning').slideUp(400);
	});

	$('a.material-popup').click(function(e)
	{
		var href = $(this).attr('href');

		window.open(href + '/popup', 'material_popup', 'width=800,height=800,resizable,scrollbars');

		e.preventDefault();
	});

	$('.window-close').click(function()
	{
		window.close();
	})

	var getAuthenticationTypeByActiveTab = function()
	{
		if($('#tab-register').hasClass('active'))
		{
			return 0;
		}
		else if($('#tab-login').hasClass('active'))
		{
			return 1;
		}

		$('#tab-register').addClass('active');
		return 0;
	}

	var authentication_type = getAuthenticationTypeByActiveTab();

	$('#tab-register a').click(function(e)
	{
		$('form').removeClass('form-login').addClass('form-register');

		authentication_type = 0;
		$('#authentication_type').val(authentication_type);

		$('div.tabs .tab.active').removeClass('active');
		$(this).parent().addClass('active');

		e.preventDefault();
	});

	$('#tab-login a').click(function(e)
	{
		$('form').removeClass('form-register').addClass('form-login');

		authentication_type = 1;
		$('#authentication_type').val(authentication_type);

		$('div.tabs .tab.active').removeClass('active');
		$(this).parent().addClass('active');

		e.preventDefault();
	});

	$('a.bref').click(function(e)
	{
		var baseurl = "http://raamattu.uskonkirjat.net/servlet/biblesite.Bible?";

		var position = $(this).attr('data-bref').split(',');
		var book = position[0].replace(" ", "+").replace("–","-").replace("—", "-").replace(", ", ",");
		var isFullChapter = book.indexOf(":") < 0;

		if(isFullChapter)
		{
			baseurl += "chp=1&";
		}

		var url = baseurl + "ref=" + book;
		window.open(url, 'bibleReference', 'height=500,width=800,resizable,scrollbars');

		e.preventDefault();
	});

	$('.fancy-radio input[type="radio"]').change(function()
	{
		$(this).parents('.fancy-radio').find('.radio').removeClass('active');
		$(this).parents('.radio').addClass('active');
	});

});
