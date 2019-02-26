(function($) {

	/**
	 * Mobile Toggle
	 */
	function mobileToggle() {

		var mobileToggle = $('.wpbf-mobile-menu-toggle');

		if(mobileToggle.hasClass("active")) {
			$('.wpbf-mobile-menu-container').removeClass('active').slideUp();
			mobileToggle.removeClass("active").attr( 'aria-expanded', 'false' );
		} else {
			$('.wpbf-mobile-menu-container').addClass('active').slideDown();
			mobileToggle.addClass("active").attr( 'aria-expanded', 'true' );
			$(window).trigger('resize');
		}

	}

	function mobileToggleClose() {

		var mobileToggle = $('.wpbf-mobile-menu-toggle');

		if(mobileToggle.hasClass("active")) {
			$('.wpbf-mobile-menu-container').removeClass('active').slideUp();
			mobileToggle.removeClass("active").attr( 'aria-expanded', 'false' );
		}

	}

	$('.wpbf-mobile-menu-toggle').click(function() {
		mobileToggle();
	});

	// close mobile menu on anchor link clicks
	// only if menu item doesn't have submenus
	$('.wpbf-mobile-menu a').click(function() {

		var attribute  = $(this).attr('href');
		var HasSubMenu = $(this).parent().hasClass('menu-item-has-children');

		if((attribute.match("^#") || attribute.match("^/#")) && HasSubMenu == false ) {
			mobileToggle();
		}

	});

	/**
	 * Desktop Breakpoint
	 *
	 * Retrieve Desktop Breakpoint from Body Class
	 */
	var DesktopBreakpointClass = $('body').attr("class").match(/wpbf-desktop-breakpoint-[\w-]*\b/);

	if( DesktopBreakpointClass !== null ) {
		var string = DesktopBreakpointClass.toString();
		var DesktopBreakpoint = string.match(/\d+/);
	} else {
		var DesktopBreakpoint = '1024';
	}

	/**
	 * Resize Fallback
	 *
	 * Hide open mobile menu on window resize
	 */
	$(window).resize(function() {

		// vars
		var windowHeight           = $(window).height();
		var windowWidth            = $(window).width();
		var mobileNavWrapperHeight = $('.wpbf-mobile-nav-wrapper').outerHeight();

		$('.wpbf-mobile-menu-container.active nav').css({'max-height' : windowHeight - mobileNavWrapperHeight });

		if(windowWidth > DesktopBreakpoint) {
			mobileToggleClose();
			if($('.wpbf-mobile-mega-menu').length) {
				$('.wpbf-mobile-mega-menu').removeClass('wpbf-mobile-mega-menu').addClass('wpbf-mega-menu');
			}
		} else {
			if($('.wpbf-mega-menu').length) {
				$('.wpbf-mega-menu').removeClass('wpbf-mega-menu').addClass('wpbf-mobile-mega-menu');
			}
		}

	});

	/**
	 * Submenu Toggle Arrow
	 */
	function SubMenuMobileToggle(that) {

		if($(that).hasClass("active")) {
			$('i', that).removeClass('wpbff-arrow-up').addClass('wpbff-arrow-down');
			$(that).removeClass('active').attr( 'aria-expanded', 'false' ).siblings('.sub-menu').slideUp();
		} else {
			$('i', that).removeClass('wpbff-arrow-down').addClass('wpbff-arrow-up');
			$(that).addClass('active').attr( 'aria-expanded', 'true' ).siblings('.sub-menu').slideDown();
		}

	}

	$('.wpbf-mobile-menu-default .wpbf-submenu-toggle').click(function(event) {
		event.preventDefault();
		SubMenuMobileToggle(this);
	});

	function SubMenuToggleOnEmtyLink(that) {

		var toggle = $(that).siblings('.wpbf-submenu-toggle');

		if(toggle.hasClass("active")) {
			$('i', toggle).removeClass('wpbff-arrow-up').addClass('wpbff-arrow-down');
			toggle.removeClass('active').attr( 'aria-expanded', 'false' ).siblings('.sub-menu').slideUp();
		} else {
			$('i', toggle).removeClass('wpbff-arrow-down').addClass('wpbff-arrow-up');
			toggle.addClass('active').attr( 'aria-expanded', 'true' ).siblings('.sub-menu').slideDown();
		}

	}

	$('.wpbf-mobile-menu a').click(function() {

		var attribute  = $(this).attr('href');
		var HasSubMenu = $(this).parent().hasClass('menu-item-has-children');

		if((attribute.match("^#") || attribute.match("^/#")) && HasSubMenu == true ) {
			SubMenuToggleOnEmtyLink(this);
		}
	});

})( jQuery );