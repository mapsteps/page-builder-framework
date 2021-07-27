var WPBFMobile = (function ($) {
	var breakpoints = WPBFSite.breakpoints;
	var menuType;

	/**
	 * Init the main functions.
	 */
	function init() {
		window.addEventListener('resize', function (e) {
			breakpoints = WPBFSite.breakpoints;
		});

		setupMenuType();
		setupMobileMenu();
		setupMobileSubmenu();
	}

	/**
	 * Setup menu type.
	 */
	function setupMenuType() {
		var menu = document.querySelector('.wpbf-mobile-menu-hamburger');

		if (menu) {
			menuType = 'hamburger';
			return;
		}

		menu = document.querySelector('.wpbf-mobile-menu-default');

		if (menu) {
			menuType = 'default';
			return;
		}

		menuType = 'premium';
	}

	/**
	 * Setup mobile menu both for default and hamburger menu.
	 */
	function setupMobileMenu() {
		$(document).on('click', '.wpbf-mobile-menu-toggle', function () {
			setupMenuType();
			toggleMobileMenu(menuType);
		});

		// Close mobile menu on anchor link clicks but only if menu item doesn't have submenus.
		$(document).on('click', '.wpbf-mobile-menu a', function () {

			var hasSubmenu = this.parentNode.classList.contains('menu-item-has-children');

			if (this.href.match("#") || this.href.match("/#")) {
				
				if (!hasSubmenu) {
					toggleMobileMenu(menuType);
				} else {
					if (!$(this).closest('.wpbf-mobile-mega-menu').length) {
						toggleSubmenuOnHashLinkClick(this);
					}
				}
			}

		});

		// Hide open mobile menu on window resize.
		$(window).resize(function () {

			var windowHeight = $(window).height();
			var windowWidth = $(window).width();
			var mobileNavWrapperHeight = $('.wpbf-mobile-nav-wrapper').outerHeight();

			$('.wpbf-mobile-menu-container.active nav').css({ 'max-height': windowHeight - mobileNavWrapperHeight });

			if (windowWidth > breakpoints.desktop) {
				closeMobileMenu(menuType);
			}

		});
	}

	/**
	 * Toggle mobile menu.
	 * This won't run if the menu type is 'premium'.
	 *
	 * @param {string} type Default menu or hamburger menu.
	 */
	function toggleMobileMenu(type) {
		if (type === 'premium') return;

		var menuToggle = $('.wpbf-mobile-menu-toggle');

		if (menuToggle.hasClass("active")) {
			$('.wpbf-mobile-menu-container').removeClass('active').slideUp();
			menuToggle.removeClass("active");

			if (type === 'hamburger') {
				menuToggle.removeClass('wpbff-times').addClass('wpbff-hamburger').attr('aria-expanded', 'false');
			} else {
				menuToggle.attr('aria-expanded', 'false');
			}
		} else {
			$('.wpbf-mobile-menu-container').addClass('active').slideDown();
			menuToggle.addClass("active");

			if (type === 'hamburger') {
				menuToggle.removeClass('wpbff-hamburger').addClass('wpbff-times').attr('aria-expanded', 'true');
			} else {
				menuToggle.attr('aria-expanded', 'true');
			}
		}
	}

	/**
	 * Close mobile menu.
	 * 
	 * @param {string} type Default menu or hamburger menu.
	 */
	function closeMobileMenu(type) {

		var menuToggle = $('.wpbf-mobile-menu-toggle');

		if (menuToggle.hasClass("active")) {
			$('.wpbf-mobile-menu-container').removeClass('active').slideUp();
			menuToggle.removeClass("active");

			if (type === 'hamburger') {
				menuToggle.removeClass('wpbff-times').addClass('wpbff-hamburger').attr('aria-expanded', 'false');
			} else {
				menuToggle.attr('aria-expanded', 'false');
			}
		}

	}

	/**
	 * Setup mobile submenu for both default and hamburger menu.
	 */
	function setupMobileSubmenu() {
		setupSubmenuToggle('default');
		setupSubmenuToggle('hamburger');
	}

	/**
	 * Setup submenu toggle.
	 *
	 * @param {string} type Default menu or hamburger menu.
	 */
	function setupSubmenuToggle(type) {
		var menuClass = type === 'hamburger' ? '.wpbf-mobile-menu-hamburger .wpbf-submenu-toggle' : '.wpbf-mobile-menu-default .wpbf-submenu-toggle';

		$(document).on('click', menuClass, function (e) {
			e.preventDefault();
			toggleMobileSubmenu(this);
		});
	}

	/**
	 * Toggle mobile submenu.
	 * 
	 * @param {HTMLElement} toggle The submenu's toggle button.
	 */
	function toggleMobileSubmenu(toggle) {

		if (toggle.classList.contains("active")) {
			closeMobileSubmenu(toggle);
		} else {
			openMobileSubmenu(toggle);
		}

	}

	/**
	 * Open mobile submenu.
	 *
	 * @param {HTMLElement} toggle The submenu's toggle button.
	 */
	function openMobileSubmenu(toggle) {

		$('i', toggle).removeClass('wpbff-arrow-down').addClass('wpbff-arrow-up');
		toggle.classList.add('active')
		toggle.setAttribute('aria-expanded', 'true');
		$(toggle).siblings('.sub-menu').stop().slideDown();

		var $sameLevelItems = $(toggle).closest('.menu-item-has-children').siblings('.menu-item-has-children');

		$sameLevelItems.each(function (i, menuItem) {
			closeMobileSubmenu(menuItem.querySelector('.wpbf-submenu-toggle'));
		});

	}

	/**
	 * Close mobile submenu.
	 *
	 * @param {HTMLElement} toggle The submenu's toggle button.
	 */
	function closeMobileSubmenu(toggle) {
		
		$('i', toggle).removeClass('wpbff-arrow-up').addClass('wpbff-arrow-down');
		toggle.classList.remove('active')
		toggle.setAttribute('aria-expanded', 'false');
		$(toggle).siblings('.sub-menu').stop().slideUp();

	}

	/**
	 * Toggle submenu on hash link click.
	 *
	 * @param {HTMLElement} link The anchor element of a menu item.
	 */
	function toggleSubmenuOnHashLinkClick(link) {
	
		var toggle = $(link).siblings('.wpbf-submenu-toggle');
		if (!toggle.length) return;
		toggle = toggle[0];

		if (toggle.classList.contains("active")) {
			closeMobileSubmenu(toggle);
		} else {
			openMobileSubmenu(toggle);
		}

	}

	init();
})(jQuery);
