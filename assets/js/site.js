(function($) {

	/**
	 * add aria-haspopup="true" to all sub-menu li's
	 */
	 $('.menu-item-has-children').each(function() {
	 	$(this).attr( 'aria-haspopup', 'true' );
	 });

	/**
	 * ScrollTop
	 */
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
			$('body').attr('tabindex', '-1').focus();
			$(this).blur();
			$('body, html').animate({ scrollTop: 0 }, 500);
		});
	}

	/**
	 * Search Menu Item
	 */
	 $('.wpbf-menu-item-search').click(function(event) {

		event.stopPropagation();

		$('.wpbf-navigation .wpbf-menu > li').slice(-3).addClass('calculate-width');
    	var itemWidth = 0;
		$('.calculate-width').each(function() {
			itemWidth += $(this).outerWidth();
		});
		if( itemWidth < 200 ) {
			var itemWidth = 250;
		}

		if( $(this).hasClass('active') ) {
			$(this).removeClass('active').attr('aria-expanded', 'false');
			$('.wpbf-menu-search', this).stop().animate({opacity:'0', width:'0px'}, 250, function() {
				$(this).css({display:'none'});
			});
		} else {
			$(this).addClass('active').attr('aria-expanded', 'true');
			$('.wpbf-menu-search', this).stop().css({display:'block'}).animate({width : itemWidth, opacity : '1'}, 200);
			$('input[type=search]', this).val('').focus();
		}

	});

	 function searchClose() {

		if ( $('.wpbf-menu-item-search').hasClass('active') ) {

			$('.wpbf-menu-search').stop().animate({opacity:'0', width:'0px'}, 250, function() {
				$(this).css({display:'none'});
			});

			setTimeout(function(){
				$('.wpbf-menu-item-search').removeClass('active').attr('aria-expanded', 'false');
			}, 400);
		}

	 }

	$(window).click(function() {
		searchClose();
	});

	$(document).keyup(function(e) {
		if (e.keyCode === 27) {
			searchClose();
		}
	});

	/**
	 * Contact Form 7 Tips
	 */
	$('.wpcf7-form-control-wrap').hover(function(){
		$('.wpcf7-not-valid-tip', this).fadeOut();
	});	

	/**
	 * Sub Menu Animation – Fade
	 */
	var duration = $(".wpbf-navigation").data('sub-menu-animation-duration');

	// Fade Animation
	$('.wpbf-sub-menu-animation-fade > .menu-item-has-children').hover(function() {
		$('.sub-menu', this).first().stop().fadeIn(duration);
	},
	function(){
		$('.sub-menu', this).first().stop().fadeOut(duration);
	});

	/**
	 * Sub Menu Animation – Second Level
	 *
	 * Excluding Mega Menu – this is always going to be a Fade effect
	 */
    $('.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children').hover(function() {
		$('.sub-menu', this).first().stop().css({display:'block'}).animate({opacity:'1'}, duration);
	},
	function(){
		$('.sub-menu', this).first().stop().animate({opacity:'0'}, duration, function() {
			$(this).css({display:'none'});
		});
	});

	/**
	 * Window Load
	 *
	 * Firing triggers after page has been loaded
	 */
	$(window).load(function(){

		$('.opacity').delay(200).animate({opacity:'1'}, 200);
		$('.display-none').show();
		$(window).trigger('resize');
		$(window).trigger('scroll');

	});

	/**
	 * Remove Boxed Layout
	 */
	var mtpagemargin = $('.wpbf-page').css('margin-top');

	$(window).resize(function(){
		var mtpagewidth = $('.wpbf-page').width();

		if(mtpagewidth >= $(window).width()) {
			$('.wpbf-page').css({'margin-top':'0','margin-bottom':'0'})
		} else {
			$('.wpbf-page').css({'margin-top': mtpagemargin,'margin-bottom':mtpagemargin})
		}
	});

	/**
	 * Centered Menu
	 */
	if ( $('.wpbf-menu-centered').length ) {
		var menu_items = $('.wpbf-navigation .wpbf-menu > li > a').length;
		var divided = menu_items/2;
		var divided = Math.floor(divided);
		var divided = divided -1;

		$('.wpbf-menu-centered .logo-container').insertAfter('.wpbf-navigation .wpbf-menu >li:eq('+ divided +')').css({'display':'block'});
	}

	$('body').mousedown(function() {
		$(this).addClass('using-mouse');
		$('.menu-item-has-children').removeClass('wpbf-sub-menu-focus');
	});
	$('body').keydown(function() {
		$(this).removeClass('using-mouse');
	});

	function wpbf_on_focus() {

		if( $('body').hasClass('using-mouse') ) return;
		if( !$('#navigation > ul').hasClass('wpbf-sub-menu') ) return;

		$('.menu-item-has-children').removeClass('wpbf-sub-menu-focus');
		$(this).parents('.menu-item-has-children').addClass('wpbf-sub-menu-focus');

	}

	$('.wpbf-menu-container #navigation a').on('focus', wpbf_on_focus );
	$('.wpbf-menu-container #navigation a').on('blur', wpbf_on_focus );

})( jQuery );