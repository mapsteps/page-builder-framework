(function($) {

	// ScrollTop
	if ($('.scrolltop').length) {

		var scrollTopVal = $('.scrolltop').attr('data-scrolltop-value');

		$(window).scroll(function () {
			if ($(this).scrollTop() > scrollTopVal) {
				$('.scrolltop').fadeIn();
			} else {
				$('.scrolltop').fadeOut();
			}
		});

		$('.scrolltop').click(function() {
			$('body,html').animate({ scrollTop: 0 }, 500);
		});
	}

	// Menu Search
	$('.wpbf-menu-item-search a').click(function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.wpbf-menu-item-search a').addClass('active');
		$('.wpbf-navigation .wpbf-menu > li').slice(-3).addClass('wpbf-menu-item');
    	var itemWidth = 0;
		$('.wpbf-menu-item').each(function() {
			itemWidth += $(this).outerWidth();
		});
		if( itemWidth < 200 ) {
			var itemWidth = 250;
		}
		$('.wpbf-menu-search').stop().css({display:'block'}).animate({width : itemWidth, opacity : '1'}, 200);
		$('.wpbf-menu-search #s').focus();
	});

	$(window).click(function() {
		if ( $('.wpbf-menu-item-search a').hasClass('active') ) {

			$('.wpbf-menu-search').stop().animate({opacity:'0', width:'0px'}, 250, function() {
				$(this).css({display:'none'});
			});

			setTimeout(function(){
				$('.wpbf-menu-item-search a').removeClass('active');
			}, 400);
		}
	});
		
	// CF7
	$('.wpcf7-form-control-wrap').hover(function(){
		$('.wpcf7-not-valid-tip', this).fadeOut();
	});	

	/* Sub Menu Animations */

	var duration = $(".wpbf-navigation").data('sub-menu-animation-duration');

	// Fade Animation
	$('.wpbf-sub-menu-animation-fade > .menu-item-has-children').hover(function() {
		$('.sub-menu', this).first().stop().fadeIn(duration);
	},
	function(){
		$('.sub-menu', this).first().stop().fadeOut(duration);
	});

    // Second Level Submenu Animation | Excluding mega menu
    $('.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) > .sub-menu > .menu-item-has-children').hover(function() {
		$('.sub-menu', this).first().stop().css({display:'block'}).animate({opacity:'1'},duration);
	},
	function(){
		$('.sub-menu', this).first().stop().animate({opacity:'0'}, duration, function() {
			$(this).css({display:'none'});
		});
	});

	// Window Load
	$(window).load(function(){

		$('.opacity').delay(250).animate({opacity:'1'}, 250);
		$('.display-none').show();
		$(window).trigger('resize');
		$(window).trigger('scroll');

	});

	// Boxed Remove
	var mtpagemargin = $('.wpbf-page').css('margin-top');

	$(window).resize(function(){
		var mtpagewidth = $('.wpbf-page').width();

		if(mtpagewidth >= $(window).width()) {
			$('.wpbf-page').css({'margin-top':'0','margin-bottom':'0'})
		} else {
			$('.wpbf-page').css({'margin-top': mtpagemargin,'margin-bottom':mtpagemargin})
		}
	});

	if ( $('.wpbf-menu-centered').length ) {
		var menu_items = $('.wpbf-navigation .wpbf-menu > li > a').length;
		var divided = menu_items/2;
		var divided = Math.floor(divided);
		var divided = divided -1;

		$('.wpbf-menu-centered .logo-container').insertAfter('.wpbf-navigation .wpbf-menu >li:eq('+ divided +')').css({'display':'block'});
	}

})( jQuery );