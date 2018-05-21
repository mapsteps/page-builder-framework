(function($) {

	function mobileToggle() {
		if($('.wpbf-mobile-menu-toggle').hasClass("active")) {
			$('.wpbf-mobile-menu-container').removeClass('active').slideUp();
			$('.wpbf-mobile-menu-toggle').removeClass("active");
		} else {
			$('.wpbf-mobile-menu-container').addClass('active').slideDown();
			$('.wpbf-mobile-menu-toggle').addClass("active");
			$(window).trigger('resize');
		}
	}

	$('.wpbf-mobile-menu-toggle').click(function() {
		mobileToggle();
	});

	$('.wpbf-mobile-menu a').click(function() {
		var attribute = $(this).attr('href');
		if(attribute.match("^#") || attribute.match("^/#") ) {
			mobileToggle();
		}
	});

	// get desktop breakpoint value from body class
	var DesktopBreakpointClass = $('body').attr("class").match(/wpbf-desktop-breakpoint-[\w-]*\b/);
	if( DesktopBreakpointClass !== null ) {
		var string = DesktopBreakpointClass.toString();
		var DesktopBreakpoint = string.match(/\d+/);
	} else {
		DesktopBreakpoint = '1024';
	}
	
    // hide open mobile menu on resize
	$(window).resize(function() {

		// vars
		var windowHeight = $(window).height();
		var windowWidth = $(window).width();
		var mobileNavWrapperHeight = $('.wpbf-mobile-nav-wrapper').outerHeight();

		$('.wpbf-mobile-menu-container.active nav').css({'max-height' : windowHeight - mobileNavWrapperHeight });

		// resize fallback
		if(windowWidth > DesktopBreakpoint) {
			if($('.wpbf-mobile-menu-toggle').hasClass('active')) {
				$('.wpbf-mobile-menu-container').removeClass('active').css({'display':'none'});
				$('.wpbf-mobile-menu-toggle').removeClass('active');
			}
			if($('.wpbf-mobile-mega-menu').length) {
				$('.wpbf-mobile-mega-menu').removeClass('wpbf-mobile-mega-menu').addClass('wpbf-mega-menu');
			}
		} else {
			if($('.wpbf-mega-menu').length) {
				$('.wpbf-mega-menu').removeClass('wpbf-mega-menu').addClass('wpbf-mobile-mega-menu');
			}
		}

	});

	// add toggle arrow
	$('.wpbf-mobile-menu .menu-item-has-children').each(function() {
		$(this).append('<span class="wpbf-submenu-toggle"><i class="wpbff wpbff-arrow-down"></i></span>');
	});

	// mobile submenu animation
	$('.wpbf-submenu-toggle').click(function(event) {

		event.preventDefault();

		if($(this).hasClass("active")) {
			$('i', this).removeClass('wpbff-arrow-up').addClass('wpbff-arrow-down');
			$(this).removeClass('active').siblings('.sub-menu').slideUp();
		} else {
			$('i', this).removeClass('wpbff-arrow-down').addClass('wpbff-arrow-up');
			$(this).addClass('active').siblings('.sub-menu').slideDown();
		}

	});

})( jQuery );