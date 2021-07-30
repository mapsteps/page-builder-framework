/**
 * This module is intended to handle the desktop menu JS functionality.
 *
 * Along with the site.js and mobile-menu.js, this file will be combined to site-min.js file.
 * 
 * @param {Object} $ jQuery object.
 * @return {Object}
 */
WpbfTheme.desktopMenu = (function ($) {

	/**
	 * Whether we're inside customizer or not.
	 * 
	 * @var bool
	 */
	var isInsideCustomizer = WpbfTheme.isInsideCustomizer;

	/**
	 * The sub-menu animation duration.
	 *
	 * @var int
	 */
	var duration = parseInt($(".wpbf-navigation").data("sub-menu-animation-duration"), 10);

	// Run the module.
	init();

	/**
	 * Initialize the module, call the main functions.
	 *
	 * This function is the only function that should be called on top level scope.
	 * Other functions are called / hooked from this function.
	 */
	function init() {

		setupMenuItemSearchButton();
		setupCenteredMenu();
		setup2ndLevelSubmenuAnimation();
		setupSubmenuFadeAnimation();
		setupAccessibility();

		// If we're inside customizer, then listen to the customizer's partial refresh.
		if (isInsideCustomizer) {
			wp.customize.bind('preview-ready', function () {
				listenPartialRefresh();
			});
		}

	}

	/**
	 * Setup search interaction of the search button inside the menu item.
	 */
	function setupMenuItemSearchButton() {

		// Expand search field on click.
		$(document).on('click', '.wpbf-menu-item-search', function (e) {
			e.stopPropagation();

			$('.wpbf-navigation .wpbf-menu > li').slice(-3).addClass('calculate-width');

			var itemWidth = 0;

			$('.calculate-width').each(function (i, el) {
				itemWidth += $(el).outerWidth();
			});

			if (itemWidth < 200) {
				itemWidth = 250;
			}

			if (!this.classList.contains('active')) {
				this.classList.add('active')
				this.setAttribute('aria-expanded', 'true');
				$('.wpbf-menu-search', this).stop().css({ display: 'block' }).animate({ width: itemWidth, opacity: '1' }, 200);
				$('input[type=search]', this).val('').focus();
			}
		});

		// Close search on window click.
		window.addEventListener('click', function (e) {
			closeSearchField();
		});

		// Close search on escape or tab.
		document.addEventListener('keyup', function (e) {
			if (e.key === 'Escape' || e.key === 'Esc') {
				closeSearchField();
			} else if (e.key === 'Tab') {
				if (!e.target.classList.contains('wpbff-search')) {
					closeSearchField();
				}
			}
		});

	}

	/**
	 * Close search field functionality.
	 */
	function closeSearchField() {

		if ($('.wpbf-menu-item-search').hasClass('active')) {

			$('.wpbf-menu-search').stop().animate({ opacity: '0', width: '0px' }, 250, function () {
				$(this).css({ display: 'none' });
			});

			setTimeout(function () {
				$('.wpbf-menu-item-search').removeClass('active').attr('aria-expanded', 'false');
			}, 400);
		}

	}

	/**
	 * Listen to WordPress selective refresh (partial refresh) inside customizer.
	 */
	function listenPartialRefresh() {

		wp.customize.selectiveRefresh.bind('partial-content-rendered', function (placement) {
			/**
			 * A lot of partial refresh registered to work on header area.
			 * Better to not checking the "placement.partial.id".
			 */
			duration = parseInt($(".wpbf-navigation").data("sub-menu-animation-duration"), 10);
			setupCenteredMenu();
		});

	}

	/**
	 * Setup centered menu.
	 */
	function setupCenteredMenu() {

		if (!document.querySelector('.wpbf-menu-centered')) return;

		var totalMenuItems = $('.wpbf-navigation .wpbf-menu-centered .wpbf-menu > li > a').length;
		var divided = totalMenuItems / 2;
		var divided = Math.floor(divided);
		var divided = divided - 1;

		// Place the logo in the center of the menu.
		$('.wpbf-menu-centered .logo-container')
			.insertAfter('.wpbf-navigation .wpbf-menu-centered .wpbf-menu >li:eq(' + divided + ')')
			.css({ 'display': 'block' });

	}

	/**
	 * Setup sub-menu animation - second level.
	 */
	function setup2ndLevelSubmenuAnimation() {

		$(document)
			.on('mouseenter', '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children', function () {
				$('.sub-menu', this).first().stop().css({ display: 'block' }).animate({ opacity: '1' }, duration);
			})
			.on('mouseleave', '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .menu-item-has-children', function () {
				$('.sub-menu', this).first().stop().animate({ opacity: '0' }, duration, function () {
					$(this).css({ display: 'none' });
				});
			});

	}

	/**
	 * Setup sub-menu animation - fade.
	 */
	function setupSubmenuFadeAnimation() {

		$(document)
			.on('mouseenter', '.wpbf-sub-menu-animation-fade > .menu-item-has-children', function () {
				$('.sub-menu', this).first().stop().fadeIn(duration);
			})
			.on('mouseleave', '.wpbf-sub-menu-animation-fade > .menu-item-has-children', function () {
				$('.sub-menu', this).first().stop().fadeOut(duration);
			});

	}

	/**
	 * Setup accessibility.
	 * 
	 * This functionality has gone through a stage of deep discussion and thought.
	 * We think this has been highly optimized.
	 * If we want to optimize it again, think again. Or, discuss it first.
	 */
	function setupAccessibility() {

		// Add aria-haspopup="true" to all sub-menu li's
		$('.menu-item-has-children').each(function (i, el) {
			$(el).attr('aria-haspopup', 'true');
		});

		// Add using-mouse class on mousedown.
		document.body.addEventListener('mousedown', function () {
			this.classList.add('using-mouse');
			$('.menu-item-has-children').removeClass('wpbf-sub-menu-focus');
		});

		// Remove using-mouse class on keydown.
		document.body.addEventListener('keydown', function () {
			this.classList.remove('using-mouse');
		});

		/**
		 * General logic for tab/hover navigation on desktop navigations that contain sub-menus.
		 */
		$(document)
			// Apply only to sub-menus that are not triggered by tab navigation.
			.on('mouseenter', '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-sub-menu-focus)', function () {

				// Remove visual focus if tab-navigation was used earlier.
				document.body.classList.add('using-mouse');

				// Remove "wpbf-sub-menu-focus" class if tab-navigation was used earlier.
				$('.menu-item-has-children').removeClass('wpbf-sub-menu-focus');

				// Focus on the current menu item. This will help if tab-navigation was used earlier.
				$(this).find('> a').focus();

			})

			/**
			 * On mouseleave of tab navigation triggered sub-menu, let's remove the "wpbf-sub-menu-focus" class.
			 * Fixes issue where sub-menu stayed open after switching from tab to mouse navigation.
			 */
			.on('mouseleave', '.wpbf-sub-menu > .menu-item-has-children.wpbf-sub-menu-focus', function () {

				$(this).removeClass('wpbf-sub-menu-focus');

			});

		// Setup tab navigation.
		$(document).on('focus', '.wpbf-sub-menu a', onNavLinkFocus);

	}

	/**
	 * Function to run on navigation-link focus for tab navigation.
	 */
	function onNavLinkFocus() {

		// Stop here if body has "using-mouse" class.
		if ($('body').hasClass('using-mouse')) return;

		// Remove "wpbf-sub-menu-focus" class everywhere.
		$('.wpbf-sub-menu > .menu-item-has-children').removeClass('wpbf-sub-menu-focus');

		// Hide other sub-menus that could be open due to mouse hover interference.
		$('.wpbf-sub-menu > .menu-item-has-children > .sub-menu').stop().hide();

		// Add "wpbf-sub-menu-focus" class to the current parent menu item that has children.
		$(this).parents('.menu-item-has-children').addClass('wpbf-sub-menu-focus');

	}

})(jQuery);
