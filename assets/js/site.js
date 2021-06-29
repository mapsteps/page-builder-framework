var WPBFSite = (function ($) {
	var isInsideCustomizer = window.wp && wp.customize ? true : false;
	var breakpoints = {
		desktop: 1024,
		tablet: 768,
		mobile: 480
	};
	var activeBreakpoint = 'desktop';
	var duration = $(".wpbf-navigation").data("sub-menu-animation-duration");

	/**
	 * Init main functions.
	 */
	function init() {
		setupBreakpoints();
		setupBodyClasses();
		buildCenteredMenu();

		if (isInsideCustomizer) {
			wp.customize.bind('preview-ready', function () {
				listenPartialRefresh();
			});
		}

		window.addEventListener('resize', function (e) {
			setupBodyClasses();
		});
	}

	/**
	 * Setup breakpoints for desktop, tablet, and mobile.
	 */
	function setupBreakpoints() {
		setupBreakpoint('desktop');
		setupBreakpoint('tablet');
		setupBreakpoint('mobile');
	}

	/**
	 * Setup body classes based on breakpoint.
	 */
	function setupBodyClasses() {
		var windowWidth = $(window).width();
		var bodyClass = '';

		if (windowWidth > breakpoints.desktop) {
			bodyClass = 'wpbf-is-desktop';
			activeBreakpoint = 'desktop';
		} else {
			if (windowWidth > breakpoints.tablet) {
				bodyClass = 'wpbf-is-tablet';
				activeBreakpoint = 'tablet';
			} else {
				bodyClass = 'wpbf-is-mobile';
				activeBreakpoint = 'mobile';
			}
		}

		document.body.classList.remove('wpbf-is-desktop');
		document.body.classList.remove('wpbf-is-tablet');
		document.body.classList.remove('wpbf-is-mobile');

		document.body.classList.add(bodyClass);
	}

	/**
	 * Setup breakpoint.
	 * Retrieve breakpoint based on body class.
	 * 
	 * @param {string} device The device class.
	 */
	function setupBreakpoint(device) {
		var matchRule = "wpbf-" + device + "-breakpoint-[\\w-]*\\b";
		var breakpointClass = $('body').attr("class").match(matchRule);

		if (breakpointClass != null) {
			breakpoints[device] = breakpointClass.toString().match(/\d+/);
			breakpoints[device] = Array.isArray(breakpoints[device]) ? breakpoints[device][0] : breakpoints[device];
		}
	}

	// Execute init.
	init();

	/**
	 * ScrollTop.
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

		$(document).on('click', '.scrolltop', function () {
			$('body').attr('tabindex', '-1').focus();
			$(this).blur();
			$('body, html').animate({ scrollTop: 0 }, 500);
		});
	}

	/**
	 * Search menu item.
	 */
	$(document).on('click', '.wpbf-menu-item-search', function (e) {

		e.stopPropagation();

		$('.wpbf-navigation .wpbf-menu > li').slice(-3).addClass('calculate-width');
		var itemWidth = 0;
		$('.calculate-width').each(function () {
			itemWidth += $(this).outerWidth();
		});
		if (itemWidth < 200) {
			var itemWidth = 250;
		}

		if (!this.classList.contains('active')) {
			$(this).addClass('active').attr('aria-expanded', 'true');
			$('.wpbf-menu-search', this).stop().css({ display: 'block' }).animate({ width: itemWidth, opacity: '1' }, 200);
			$('input[type=search]', this).val('').focus();
		}

	});

	/**
	* Function to close search.
	*/
	function searchClose() {

		if ($('.wpbf-menu-item-search').hasClass('active')) {

			$('.wpbf-menu-search').stop().animate({ opacity: '0', width: '0px' }, 250, function () {
				$(this).css({ display: 'none' });
			});

			setTimeout(function () {
				$('.wpbf-menu-item-search').removeClass('active').attr('aria-expanded', 'false');
			}, 400);
		}

	}

	// Close search on window click.
	window.addEventListener('click', function (e) {
		searchClose();
	});

	// Close search on escape or tab.
	document.addEventListener('keyup', function (e) {
		if (e.key === 'Escape' || e.key === 'Esc') {
			searchClose();
		} else if (e.key === 'Tab') {
			if (!e.target.classList.contains('wpbff-search')) {
				searchClose();
			}
		}
	});

	/**
	 * Contact Form 7 tips.
	 */
	$('.wpcf7-form-control-wrap').on('mouseenter', function () {
		$('.wpcf7-not-valid-tip', this).fadeOut();
	});

	/**
	 * Remove boxed layout on resize.
	 */
	var mtpagemargin = $('.wpbf-page').css('margin-top');

	$(window).on( 'resize', function () {
		var mtpagewidth = $('.wpbf-page').width();

		if (mtpagewidth >= $(window).width()) {
			$('.wpbf-page').css({ 'margin-top': '0', 'margin-bottom': '0' })
		} else {
			$('.wpbf-page').css({ 'margin-top': mtpagemargin, 'margin-bottom': mtpagemargin })
		}
	});

	/**
	 * Listen to WordPress selective refresh inside customizer.
	 */
	function listenPartialRefresh() {
		wp.customize.selectiveRefresh.bind('partial-content-rendered', function (placement) {
			/**
			 * A lot of partial refresh registered to work on header area.
			 * Better to not checking the "placement.partial.id".
			 */
			duration = $(".wpbf-navigation").data("sub-menu-animation-duration");
			buildCenteredMenu();
		});
	}

	/**
	 * Centered menu.
	 */
	function buildCenteredMenu() {
		if (!document.querySelector('.wpbf-menu-centered')) return;

		var menu_items = $('.wpbf-navigation .wpbf-menu-centered .wpbf-menu > li > a').length;
		var divided = menu_items / 2;
		var divided = Math.floor(divided);
		var divided = divided - 1;

		$('.wpbf-menu-centered .logo-container').insertAfter('.wpbf-navigation .wpbf-menu-centered .wpbf-menu >li:eq(' + divided + ')').css({ 'display': 'block' });
	}

	/**
	 * Sub menu animation – second level.
	 */
	$(document)
		.on('mouseenter', '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children', function () {
			$('.sub-menu', this).first().stop().css({ display: 'block' }).animate({ opacity: '1' }, duration);
		})
		.on('mouseleave', '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children', function () {
			$('.sub-menu', this).first().stop().animate({ opacity: '0' }, duration, function () {
				$(this).css({ display: 'none' });
			});
		});

	/**
	 * Sub menu animation - fade.
	 */
	$(document)
		.on('mouseenter', '.wpbf-sub-menu-animation-fade > .menu-item-has-children', function () {
			$('.sub-menu', this).first().stop().fadeIn(duration);

			// Remove visual focus if tab-navigation was used earlier.
			document.body.classList.add('using-mouse');

			// Remove .wpbf-sub-menu-focus class if tab-navigation was used earlier.
			$('.menu-item-has-children').removeClass('wpbf-sub-menu-focus');

			// Focus on the current menu item. This will help if tab-navigation was used earlier.
			$(this).find('> a').focus();
		})
		.on('mouseleave', '.wpbf-sub-menu-animation-fade > .menu-item-has-children', function () {
			$('.sub-menu', this).first().stop().fadeOut(duration);
		});

	/**
	 * Accessibility.
	 */

	// Add aria-haspopup="true" to all sub-menu li's
	$('.menu-item-has-children').each(function () {
		$(this).attr('aria-haspopup', 'true');
	});

	// Add using-mouse class on mousedown.
	$('body').mousedown(function () {
		$(this).addClass('using-mouse');
		$('.menu-item-has-children').removeClass('wpbf-sub-menu-focus');
	});

	// Remove using-mouse class on keydown.
	$('body').keydown(function () {
		$(this).removeClass('using-mouse');
	});

	/**
	 * onFocus function for tab navigation.
	 */
	function onFocus() {

		if ($('body').hasClass('using-mouse')) return;
		if (!$('#navigation > ul').hasClass('wpbf-sub-menu')) return;

		$('.menu-item-has-children').removeClass('wpbf-sub-menu-focus');
		$(this).parents('.menu-item-has-children').addClass('wpbf-sub-menu-focus');
		
		/**
		 * This is needed to fix the multiple popup issue (accessibility thing).
		 * It's when you mix the your navigation using tab & mouseenter.
		 */
		$('#navigation > ul > .menu-item-has-children.wpbf-sub-menu-focus > .sub-menu').first().stop().fadeOut(duration);

	}

	/**
	 * onBlur function for tab navigation.
	 */
	function onBlur() {

		if ($('body').hasClass('using-mouse')) return;
		if (!$('#navigation > ul').hasClass('wpbf-sub-menu')) return;

		$('.menu-item-has-children').removeClass('wpbf-sub-menu-focus');
		$(this).parents('.menu-item-has-children').addClass('wpbf-sub-menu-focus');

	}

	// Tab navigation.
	$('#navigation a').on('focus', onFocus);
	$('#navigation a').on('blur', onBlur);

	/**
	 * Executing various triggers on load.
	 */
	$(window).on( 'load', function () {
		$('.opacity').delay(200).animate({ opacity: '1' }, 200);
		$('.display-none').show();
		$(window).trigger('resize');
		$(window).trigger('scroll');
	});

	return {
		breakpoints: breakpoints,
		activeBreakpoint: activeBreakpoint
	};

})(jQuery);
