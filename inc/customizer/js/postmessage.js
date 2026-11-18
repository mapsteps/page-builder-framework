(function ($) {

	var customizeBreakpoints = {
		desktop: 1024,
		tablet: 768,
		mobile: 480
	};

	var mediaQueries = {
		tablet: 'max-width: ' + (customizeBreakpoints.desktop - 1).toString() + 'px',
		mobile: 'max-width: ' + (customizeBreakpoints.tablet - 1).toString() + 'px'
	};

	/**
	 * Setup style tag.
	 *
	 * @param {string} id The style data id.
	 * @return {HTMLElement} The style tag.
	 */
	function setupStyleTag(id) {
		var tag = document.createElement('style');
		tag.dataset.id = id;
		tag.className = 'wpbf-customize-live-style';

		document.head.append(tag);
		return tag;
	}

	/* Typography */

	wp.customize('page_font_color', function (value) {
		var styleTag = setupStyleTag('page_font_color');

		value.bind(function (newval) {
			styleTag.innerHTML = 'body {color: ' + newval + ';}';
		});
	});

	/* 404 */

	wp.customize('404_headline', function (value) {
		value.bind(function (newval) {
			$('.wpbf-404-content .entry-title').text(newval);
		});
	});

	wp.customize('404_text', function (value) {
		value.bind(function (newval) {
			$('.wpbf-404-content p').text(newval);
		});
	});

	/* Navigation */

	// Width.
	wp.customize('menu_width', function (value) {
		var styleTag = setupStyleTag('menu_width');

		value.bind(function (newval) {
			newval = !newval ? '1200px' : newval;
			styleTag.innerHTML = '.wpbf-nav-wrapper {max-width: ' + newval + ';}';
		});
	});

	// Menu height.
	wp.customize('menu_height', function (value) {
		var styleTag = setupStyleTag('menu_height');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-nav-wrapper {padding-top: ' + newval + 'px; padding-bottom: ' + newval + 'px;}';
		});
	});

	// Menu padding.
	wp.customize('menu_padding', function (value) {
		var styleTag = setupStyleTag('menu_padding');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-navigation .wpbf-menu > .menu-item > a {padding-left: ' + newval + 'px; padding-right: ' + newval + 'px;}';
		});
	});

	// Background color.
	wp.customize('menu_bg_color', function (value) {
		var styleTag = setupStyleTag('menu_bg_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-navigation:not(.wpbf-navigation-transparent):not(.wpbf-navigation-active) {background-color: ' + newval + ';}';
		});
	});

	// Font color.
	wp.customize('menu_font_color', function (value) {
		var styleTag = setupStyleTag('menu_font_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a, .wpbf-close {color: ' + newval + ';}';
		});
	});

	// Font color hover.
	wp.customize('menu_font_color_alt', function (value) {
		var styleTag = setupStyleTag('menu_font_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '\
				.wpbf-navigation .wpbf-menu a:hover, .wpbf-mobile-menu a:hover {color: ' + newval + ';}\
				.wpbf-navigation .wpbf-menu > .current-menu-item > a, .wpbf-mobile-menu > .current-menu-item > a {color: ' + newval + '!important;}\
			';
		});
	});

	// Font size.
	wp.customize('menu_font_size', function (value) {
		var styleTag = setupStyleTag('menu_font_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a {font-size: ' + newval + suffix + ';}';
		});
	});

	/* Sub Menu */

	// Text alignment.
	wp.customize('sub_menu_text_alignment', function (value) {

		var styleTag = setupStyleTag('sub_menu_text_alignment');

		value.bind(function (newval) {

			styleTag.innerHTML = '\
				.wpbf-sub-menu .sub-menu {\
					text-align: ' + newval + '\
				}\
			';

		});

	});

	// Padding.
	wp.customize('sub_menu_padding', function (value) {

		var styleTag = setupStyleTag('sub_menu_padding');

		value.bind(function (newval) {

			var obj = JSON.parse(newval),
				top = obj.top,
				right = obj.right,
				bottom = obj.bottom,
				left = obj.left;

			styleTag.innerHTML = '\
				.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a {\
					padding-top: ' + top + 'px;\
					padding-right: ' + right + 'px;\
					padding-bottom: ' + bottom + 'px;\
					padding-left: ' + left + 'px;\
				}\
			';

		});

	});

	// Width.
	wp.customize('sub_menu_width', function (value) {
		var styleTag = setupStyleTag('sub_menu_width');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu {width: ' + newval + 'px;}';
		});
	});

	// Background color.
	wp.customize('sub_menu_bg_color', function (value) {
		var styleTag = setupStyleTag('sub_menu_bg_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '\
				.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li,\
				.wpbf-sub-menu > .wpbf-mega-menu > .sub-menu {\
					background-color: ' + newval + ';\
				}\
			';
		});
	});

	// Background color hover.
	wp.customize('sub_menu_bg_color_alt', function (value) {
		var styleTag = setupStyleTag('sub_menu_bg_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '\
				.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li:hover {\
					background-color: ' + newval + ';\
				}\
			';
		});
	});

	// Accent color.
	wp.customize('sub_menu_accent_color', function (value) {
		var styleTag = setupStyleTag('sub_menu_accent_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-menu .sub-menu a {color: ' + newval + ';}';
		});
	});

	// Accent color hover.
	wp.customize('sub_menu_accent_color_alt', function (value) {
		var styleTag = setupStyleTag('sub_menu_accent_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-navigation .wpbf-menu .sub-menu a:hover {color: ' + newval + ';}';
		});
	});

	// Font size.
	wp.customize('sub_menu_font_size', function (value) {
		var styleTag = setupStyleTag('sub_menu_font_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-menu .sub-menu a {font-size: ' + newval + suffix + ';}';
		});
	});

	// Separator color.
	wp.customize('sub_menu_separator_color', function (value) {
		var styleTag = setupStyleTag('sub_menu_separator_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li {border-bottom-color: ' + newval + ';}';
		});
	});

	/* Mobile Navigation */

	// Height.
	wp.customize('mobile_menu_height', function (value) {
		var styleTag = setupStyleTag('mobile_menu_height');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-nav-wrapper {padding-top: ' + newval + 'px; padding-bottom: ' + newval + 'px;}';
		});
	});

	// Background color.
	wp.customize('mobile_menu_background_color', function (value) {
		var styleTag = setupStyleTag('mobile_menu_background_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-nav-wrapper {background-color: ' + newval + ';}';
		});
	});

	// Icon color.
	wp.customize('mobile_menu_hamburger_color', function (value) {
		var styleTag = setupStyleTag('mobile_menu_hamburger_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-nav-item, .wpbf-mobile-nav-item a {color: ' + newval + ';}';
		});
	});

	// Hamburger size.
	wp.customize('mobile_menu_hamburger_size', function (value) {
		var styleTag = setupStyleTag('mobile_menu_hamburger_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-mobile-nav-item {font-size: ' + newval + suffix + ';}';
		});
	});

	// Hamburger border radius (filled).
	wp.customize('mobile_menu_hamburger_border_radius', function (value) {
		var styleTag = setupStyleTag('mobile_menu_hamburger_border_radius');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-nav-item {border-radius: ' + newval + 'px;}';
		});
	});

	// Padding.
	wp.customize('mobile_menu_padding', function (value) {

		var styleTag = setupStyleTag('mobile_menu_padding');

		value.bind(function (newval) {

			var obj = JSON.parse(newval),
				top = obj.top,
				right = obj.right,
				bottom = obj.bottom,
				left = obj.left;

			styleTag.innerHTML = '\
				.wpbf-mobile-menu a,\
				.wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {\
					padding-top: ' + top + 'px;\
					padding-right: ' + right + 'px;\
					padding-bottom: ' + bottom + 'px;\
					padding-left: ' + left + 'px;\
				}\
			';

		});

	});

	// Menu item background color.
	wp.customize('mobile_menu_bg_color', function (value) {
		var styleTag = setupStyleTag('mobile_menu_bg_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-menu > .menu-item a {background-color: ' + newval + ';}';
		});
	});

	// Menu item background color hover.
	wp.customize('mobile_menu_bg_color_alt', function (value) {
		var styleTag = setupStyleTag('mobile_menu_bg_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-menu > .menu-item a:hover {background-color: ' + newval + ';}';
		});
	});

	// Menu item font color.
	wp.customize('mobile_menu_font_color', function (value) {
		var styleTag = setupStyleTag('mobile_menu_font_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-menu a, .wpbf-mobile-menu-container .wpbf-close {color: ' + newval + ';}';
		});
	});

	// Menu item font color hover.
	wp.customize('mobile_menu_font_color_alt', function (value) {
		var styleTag = setupStyleTag('mobile_menu_font_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-menu a:hover, .wpbf-mobile-menu > .current-menu-item > a {color: ' + newval + '!important;}';
		});
	});

	// Menu item divider color.
	wp.customize('mobile_menu_border_color', function (value) {
		var styleTag = setupStyleTag('mobile_menu_border_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '\
				.wpbf-mobile-menu .menu-item {border-top-color: ' + newval + ';}\
				.wpbf-mobile-menu > .menu-item:last-child {border-bottom-color: ' + newval + ';}\
			';
		});
	});

	// Sub menu arrow color.
	wp.customize('mobile_menu_submenu_arrow_color', function (value) {
		var styleTag = setupStyleTag('mobile_menu_submenu_arrow_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-submenu-toggle {color: ' + newval + ';}';
		});
	});

	// Menu item font size.
	wp.customize('mobile_menu_font_size', function (value) {
		var styleTag = setupStyleTag('mobile_menu_font_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-mobile-menu a, .wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {font-size: ' + newval + suffix + ';}';
		});
	});

	/* Mobile sub menu */

	// Submenu auto collapse.
	wp.customize('mobile_sub_menu_auto_collapse', function (value) {
		value.bind(function (newval) {
			if (!document.querySelector('#mobile-navigation')) return;

			if (newval) {
				$('#mobile-navigation').closest('.wpbf-navigation').addClass('wpbf-mobile-sub-menu-auto-collapse');
			} else {
				$('#mobile-navigation').closest('.wpbf-navigation').removeClass('wpbf-mobile-sub-menu-auto-collapse');
			}
		});
	});

	// Indent.
	wp.customize('mobile_sub_menu_indent', function (value) {
		var styleTag = setupStyleTag('mobile_sub_menu_indent');

		value.bind(function (newval) {
			var padding = wp.customize('mobile_menu_padding').get();
			padding = JSON.parse(padding);

			var calculation = parseInt(newval, 10) + parseInt(padding.left, 10);
			styleTag.innerHTML = '.wpbf-mobile-menu .sub-menu a {padding-left: ' + calculation + 'px;}';
		});
	});

	// Menu item background color.
	wp.customize('mobile_sub_menu_bg_color', function (value) {
		var styleTag = setupStyleTag('mobile_sub_menu_bg_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-menu .sub-menu a {background-color: ' + newval + ';}';
		});
	});

	// Menu item background color hover.
	wp.customize('mobile_sub_menu_bg_color_alt', function (value) {
		var styleTag = setupStyleTag('mobile_sub_menu_bg_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-menu .sub-menu a:hover {background-color: ' + newval + ';}';
		});
	});

	// Menu item font color.
	wp.customize('mobile_sub_menu_font_color', function (value) {
		var styleTag = setupStyleTag('mobile_sub_menu_font_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-menu .sub-menu a {color: ' + newval + ';}';
		});
	});

	// Menu item font color hover.
	wp.customize('mobile_sub_menu_font_color_alt', function (value) {
		var styleTag = setupStyleTag('mobile_sub_menu_font_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-menu .sub-menu a:hover, .wpbf-mobile-menu .sub-menu > .current-menu-item > a {color: ' + newval + '!important;}';
		});
	});

	// Menu item divider color.
	wp.customize('mobile_sub_menu_border_color', function (value) {
		var styleTag = setupStyleTag('mobile_sub_menu_border_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-menu .sub-menu .menu-item {border-top-color: ' + newval + ';}';
		});
	});

	// Sub menu arrow color.
	wp.customize('mobile_sub_menu_arrow_color', function (value) {
		var styleTag = setupStyleTag('mobile_sub_menu_arrow_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-mobile-menu .sub-menu .wpbf-submenu-toggle {color: ' + newval + ';}';
		});
	});

	// Menu item font size.
	wp.customize('mobile_sub_menu_font_size', function (value) {
		var styleTag = setupStyleTag('mobile_sub_menu_font_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-mobile-menu .sub-menu a, .wpbf-mobile-menu .sub-menu .menu-item-has-children .wpbf-submenu-toggle {font-size: ' + newval + suffix + ';}';
		});
	});

	/* Logo */

	// Width.
	wp.customize('menu_logo_size', function (value) {

		var styleTag = setupStyleTag('menu_logo_size');

		value.bind(function (newval) {

			var obj = JSON.parse(newval),
				desktop = obj.desktop,
				tablet = obj.tablet,
				mobile = obj.mobile,
				desktopsuffix = $.isNumeric(desktop) ? 'px' : '',
				tabletsuffix = $.isNumeric(tablet) ? 'px' : '',
				mobilesuffix = $.isNumeric(mobile) ? 'px' : '';

			styleTag.innerHTML = '\
				.wpbf-logo img, .wpbf-mobile-logo img {\
					width: ' + desktop + desktopsuffix + ';\
				}\
				@media (' + mediaQueries.tablet + ') {\
					.wpbf-mobile-logo img {width: ' + tablet + tabletsuffix + ';}\
				}\
				@media (' + mediaQueries.mobile + ') {\
					.wpbf-mobile-logo img {width: ' + mobile + mobilesuffix + ';}\
				}\
			';

		});

	});

	// Font size.
	wp.customize('menu_logo_font_size', function (value) {

		var styleTag = setupStyleTag('menu_logo_font_size');

		value.bind(function (newval) {

			var obj = JSON.parse(newval),
				desktop = obj.desktop,
				tablet = obj.tablet,
				mobile = obj.mobile,
				desktopsuffix = $.isNumeric(desktop) ? 'px' : '',
				tabletsuffix = $.isNumeric(tablet) ? 'px' : '',
				mobilesuffix = $.isNumeric(mobile) ? 'px' : '';

			styleTag.innerHTML = '\
				.wpbf-logo a, .wpbf-mobile-logo a {\
					font-size: ' + desktop + desktopsuffix + ';\
				}\
				@media (' + mediaQueries.tablet + ') {\
					.wpbf-mobile-logo a {font-size: ' + tablet + tabletsuffix + ';}\
				}\
				@media (' + mediaQueries.mobile + ') {\
					.wpbf-mobile-logo a {font-size: ' + mobile + mobilesuffix + ';}\
				}\
			';

		});

	});

	// Color.
	wp.customize('menu_logo_color', function (value) {
		var styleTag = setupStyleTag('menu_logo_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-logo a, .wpbf-mobile-logo a {color: ' + newval + ';}';
		});
	});

	// Color hover.
	wp.customize('menu_logo_color_alt', function (value) {
		var styleTag = setupStyleTag('menu_logo_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-logo a:hover, .wpbf-mobile-logo a:hover {color: ' + newval + ';}';
		});
	});

	// Container width.
	wp.customize('menu_logo_container_width', function (value) {
		var styleTag = setupStyleTag('menu_logo_container_width');

		value.bind(function (newval) {
			var calculation = 100 - newval;
			styleTag.innerHTML = '\
				.wpbf-navigation .wpbf-1-4 {width: ' + newval + '%;}\
				.wpbf-navigation .wpbf-3-4 {width: ' + calculation + '%;}\
			';
		});
	});

	// Mobile container width.
	wp.customize('mobile_menu_logo_container_width', function (value) {
		var styleTag = setupStyleTag('mobile_menu_logo_container_width');

		value.bind(function (newval) {
			var calculation = 100 - newval;
			styleTag.innerHTML = '\
				@media (' + mediaQueries.tablet + ') {\
					.wpbf-navigation .wpbf-2-3 {width: ' + newval + '%;}\
					.wpbf-navigation .wpbf-1-3 {width: ' + calculation + '%;}\
				}\
			';
		});
	});

	/* Tagline */

	// Font size.
	wp.customize('menu_logo_description_font_size', function (value) {

		var styleTag = setupStyleTag('menu_logo_description_font_size');

		value.bind(function (newval) {

			var obj = JSON.parse(newval),
				desktop = obj.desktop,
				tablet = obj.tablet,
				mobile = obj.mobile,
				desktopsuffix = $.isNumeric(desktop) ? 'px' : '',
				tabletsuffix = $.isNumeric(tablet) ? 'px' : '',
				mobilesuffix = $.isNumeric(mobile) ? 'px' : '';

			styleTag.innerHTML = '\
				.wpbf-logo .wpbf-tagline, .wpbf-mobile-logo .wpbf-tagline {\
					font-size: ' + desktop + desktopsuffix + ';\
				}\
				@media (' + mediaQueries.tablet + ') {\
					.wpbf-mobile-logo .wpbf-tagline {font-size: ' + tablet + tabletsuffix + ';}\
				}\
				@media (' + mediaQueries.mobile + ') {\
					.wpbf-mobile-logo .wpbf-tagline {font-size: ' + mobile + mobilesuffix + ';}\
				}\
			';

		});

	});

	// Font color.
	wp.customize('menu_logo_description_color', function (value) {
		var styleTag = setupStyleTag('menu_logo_description_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-tagline {color: ' + newval + ';}';
		});
	});

	/* Pre Header */

	// Width.
	wp.customize('pre_header_width', function (value) {
		var styleTag = setupStyleTag('pre_header_width');

		value.bind(function (newval) {
			newval = !newval ? '1200px' : newval;
			styleTag.innerHTML = '.wpbf-inner-pre-header {max-width: ' + newval + ';}';
		});
	});

	// Height.
	wp.customize('pre_header_height', function (value) {
		var styleTag = setupStyleTag('pre_header_height');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-inner-pre-header {padding-top: ' + newval + 'px; padding-bottom: ' + newval + 'px;}';
		});
	});

	// Background color.
	wp.customize('pre_header_bg_color', function (value) {
		var styleTag = setupStyleTag('pre_header_bg_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-pre-header {background-color: ' + newval + ';}';
		});
	});

	// Font color.
	wp.customize('pre_header_font_color', function (value) {
		var styleTag = setupStyleTag('pre_header_font_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-pre-header {color: ' + newval + ';}';
		});
	});

	// Accent color.
	wp.customize('pre_header_accent_color', function (value) {
		var styleTag = setupStyleTag('pre_header_accent_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-pre-header a {color: ' + newval + ';}';
		});
	});

	// Accent color hover.
	wp.customize('pre_header_accent_color_alt', function (value) {
		var styleTag = setupStyleTag('pre_header_accent_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-pre-header a:hover, .wpbf-pre-header .wpbf-menu > .current-menu-item > a {color: ' + newval + '!important;}';
		});
	});

	// Font size.
	wp.customize('pre_header_font_size', function (value) {
		var styleTag = setupStyleTag('pre_header_font_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '\
				.wpbf-pre-header,\
				.wpbf-pre-header .wpbf-menu,\
				.wpbf-pre-header .wpbf-menu .sub-menu a {\
					font-size: ' + newval + suffix + ';\
				}\
			';
		});
	});

	/* Blog – Pagination */

	// Border radius.
	wp.customize('blog_pagination_border_radius', function (value) {
		var styleTag = setupStyleTag('blog_pagination_border_radius');

		value.bind(function (newval) {
			styleTag.innerHTML = '.pagination .page-numbers {border-radius: ' + newval + 'px;}';
		});
	});

	// Background color.
	wp.customize('blog_pagination_background_color', function (value) {
		var styleTag = setupStyleTag('blog_pagination_background_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.pagination .page-numbers:not(.current) {background-color: ' + newval + ';}';
		});
	});

	// Background color hover.
	wp.customize('blog_pagination_background_color_alt', function (value) {
		var styleTag = setupStyleTag('blog_pagination_background_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.pagination .page-numbers:not(.current):hover {background-color: ' + newval + ';}';
		});
	});

	// Background color active.
	wp.customize('blog_pagination_background_color_active', function (value) {
		var styleTag = setupStyleTag('blog_pagination_background_color_active');

		value.bind(function (newval) {
			styleTag.innerHTML = '.pagination .page-numbers.current {background-color: ' + newval + ';}';
		});
	});

	// Font color.
	wp.customize('blog_pagination_font_color', function (value) {
		var styleTag = setupStyleTag('blog_pagination_font_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.pagination .page-numbers:not(.current) {color: ' + newval + ';}';
		});
	});

	// Font color hover.
	wp.customize('blog_pagination_font_color_alt', function (value) {
		var styleTag = setupStyleTag('blog_pagination_font_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.pagination .page-numbers:not(.current):hover {color: ' + newval + ';}';
		});
	});

	// Font color active.
	wp.customize('blog_pagination_font_color_active', function (value) {
		var styleTag = setupStyleTag('blog_pagination_font_color_active');

		value.bind(function (newval) {
			styleTag.innerHTML = '.pagination .page-numbers.current {color: ' + newval + ';}';
		});
	});

	// Font size.
	wp.customize('blog_pagination_font_size', function (value) {
		var styleTag = setupStyleTag('blog_pagination_font_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.pagination .page-numbers {font-size: ' + newval + suffix + ';}';
		});
	});

	/* Footer */

	// Width.
	wp.customize('footer_width', function (value) {
		var styleTag = setupStyleTag('footer_width');

		value.bind(function (newval) {
			newval = !newval ? '1200px' : newval;
			styleTag.innerHTML = '.wpbf-inner-footer {max-width: ' + newval + ';}';
		});
	});

	// Height.
	wp.customize('footer_height', function (value) {
		var styleTag = setupStyleTag('footer_height');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-inner-footer {padding-top: ' + newval + 'px; padding-bottom: ' + newval + 'px;}';
		});
	});

	// Background color.
	wp.customize('footer_bg_color', function (value) {
		var styleTag = setupStyleTag('footer_bg_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-page-footer {background-color: ' + newval + ';}';
		});
	});

	// Font color.
	wp.customize('footer_font_color', function (value) {
		var styleTag = setupStyleTag('footer_font_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-inner-footer {color: ' + newval + ';}';
		});
	});

	// Accent color.
	wp.customize('footer_accent_color', function (value) {
		var styleTag = setupStyleTag('footer_accent_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-inner-footer a {color: ' + newval + ';}';
		});
	});

	// Accent color hover.
	wp.customize('footer_accent_color_alt', function (value) {
		var styleTag = setupStyleTag('footer_accent_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.wpbf-inner-footer a:hover, .wpbf-inner-footer .wpbf-menu > .current-menu-item > a {color: ' + newval + ';}';
		});
	});

	// Font size.
	wp.customize('footer_font_size', function (value) {
		var styleTag = setupStyleTag('footer_font_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-inner-footer, .wpbf-inner-footer .wpbf-menu {font-size: ' + newval + suffix + ';}';
		});
	});

	/* WooCommerce - Defaults */

	// Button border radius.
	wp.customize('button_border_radius', function (value) {
		var styleTag = setupStyleTag('button_border_radius');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce a.button, .woocommerce button.button {border-radius: ' + newval + 'px;}';
		});
	});

	// Custom width.
	wp.customize('woocommerce_loop_custom_width', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_custom_width');

		value.bind(function (newval) {
			newval = !newval ? '1200px' : newval;
			styleTag.innerHTML = '.archive.woocommerce #inner-content {max-width: ' + newval + ';}';
		});
	});

	/* WooCommerce - Menu Item */

	// Desktop color.
	wp.customize('woocommerce_menu_item_desktop_color', function (value) {
		var styleTag = setupStyleTag('woocommerce_menu_item_desktop_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '\
				.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count {background-color: ' + newval + ';}\
			';
		});
	});

	// Mobile color.
	wp.customize('woocommerce_menu_item_mobile_color', function (value) {
		var styleTag = setupStyleTag('woocommerce_menu_item_mobile_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '\
				.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count {background-color: ' + newval + ';}\
			';
		});
	});

	/* WooCommerce - Loop */

	// Content alignment.
	wp.customize('woocommerce_loop_content_alignment', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_content_alignment');

		value.bind(function (newval) {
			if (newval === 'center') {
				styleTag.innerHTML = '\
						.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: ' + newval + ';}\
						.woocommerce .products .star-rating {margin: 0 auto 10px auto;}\
					';
			} else if (newval === 'right') {
				styleTag.innerHTML = '\
						.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: ' + newval + ';}\
						.woocommerce .products .star-rating {display: inline-block; text-align: right;}\
					';
			} else {
				styleTag.innerHTML = '.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: ' + newval + ';}';
			}
		});
	});

	// Image alignment.
	wp.customize('woocommerce_loop_image_alignment', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_image_alignment');

		value.bind(function (newval) {
			if (newval == 'left') {
				styleTag.innerHTML = '\
					.wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper {float: left;}\
					.wpbf-woo-list-view .wpbf-woo-loop-summary {float: right;}\
				';
			} else {
				styleTag.innerHTML = '\
					.wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper {float: right;}\
					.wpbf-woo-list-view .wpbf-woo-loop-summary {float: left;}\
				';
			}
		});
	});

	// Image width.
	wp.customize('woocommerce_loop_image_width', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_image_width');

		value.bind(function (newval) {
			styleTag.innerHTML = '\
				.wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper {width: ' + (newval - 2) + '%;}\
				.wpbf-woo-list-view .wpbf-woo-loop-summary {width: ' + (98 - newval) + '%;}\
			';
		});
	});

	// Title font size.
	wp.customize('woocommerce_loop_title_size', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_title_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';

			styleTag.innerHTML = '\
				.woocommerce ul.products li.product h3,\
				.woocommerce ul.products li.product .woocommerce-loop-product__title,\
				.woocommerce ul.products li.product .woocommerce-loop-category__title {\
					font-size: ' + newval + suffix + ';\
				}\
			';
		});
	});

	// Title font color.
	wp.customize('woocommerce_loop_title_color', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_title_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '\
				.woocommerce ul.products li.product h3,\
				.woocommerce ul.products li.product .woocommerce-loop-product__title,\
				.woocommerce ul.products li.product .woocommerce-loop-category__title {\
					color: ' + newval + ';\
				}\
			';
		});
	});

	// Price font size.
	wp.customize('woocommerce_loop_price_size', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_price_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.woocommerce ul.products li.product .price {font-size: ' + newval + suffix + ';}';
		});
	});

	// Price font color.
	wp.customize('woocommerce_loop_price_color', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_price_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce ul.products li.product .price {color: ' + newval + ';}';
		});
	});

	// Out of stock notice.
	wp.customize('woocommerce_loop_out_of_stock_font_size', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_out_of_stock_font_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {font-size: ' + newval + suffix + ';}';
		});
	});

	// Out of stock color.
	wp.customize('woocommerce_loop_out_of_stock_font_color', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_out_of_stock_font_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {color: ' + newval + ';}';
		});
	});

	// Out of stock background color.
	wp.customize('woocommerce_loop_out_of_stock_background_color', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_out_of_stock_background_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {background-color: ' + newval + ';}';
		});
	});

	// Sale font size.
	wp.customize('woocommerce_loop_sale_font_size', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_sale_font_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.woocommerce span.onsale {font-size: ' + newval + suffix + ';}';
		});
	});

	// Sale font color.
	wp.customize('woocommerce_loop_sale_font_color', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_sale_font_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce span.onsale {color: ' + newval + ';}';
		});
	});

	// Sale background color.
	wp.customize('woocommerce_loop_sale_background_color', function (value) {
		var styleTag = setupStyleTag('woocommerce_loop_sale_background_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce span.onsale {background-color: ' + newval + ';}';
		});
	});

	/* WooCommerce - Single */

	// Custom width.
	wp.customize('woocommerce_single_custom_width', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_custom_width');

		value.bind(function (newval) {
			newval = !newval ? '1200px' : newval;
			styleTag.innerHTML = '.single.woocommerce #inner-content {max-width: ' + newval + ';}';
		});
	});

	// Image alignment.
	wp.customize('woocommerce_single_alignment', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_alignment');

		value.bind(function (newval) {
			if (newval === 'right') {
				styleTag.innerHTML = '\
					.woocommerce div.product div.summary,\
					.woocommerce #content div.product div.summary,\
					.woocommerce-page div.product div.summary,\
					.woocommerce-page #content div.product div.summary {float: left;}\
					\
					.woocommerce div.product div.images,\
					.woocommerce #content div.product div.images,\
					.woocommerce-page div.product div.images,\
					.woocommerce-page #content div.product div.images {float: right;}\
					\
					.single-product.woocommerce span.onsale {display: none;}\
				';
			} else {
				styleTag.innerHTML = '\
					.woocommerce div.product div.summary,\
					.woocommerce #content div.product div.summary,\
					.woocommerce-page div.product div.summary,\
					.woocommerce-page #content div.product div.summary {float: right;}\
					\
					.woocommerce div.product div.images,\
					.woocommerce #content div.product div.images,\
					.woocommerce-page div.product div.images,\
					.woocommerce-page #content div.product div.images {float: left;}\
					\
					.single-product.woocommerce span.onsale {display: block;}\
				';
			}
		});
	});

	// Image width.
	wp.customize('woocommerce_single_image_width', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_image_width');

		value.bind(function (newval) {
			styleTag.innerHTML = '\
				.woocommerce div.product div.images,\
				.woocommerce #content div.product div.images,\
				.woocommerce-page div.product div.images,\
				.woocommerce-page #content div.product div.images {width: ' + (newval - 2) + '%;}\
				\
				.woocommerce div.product div.summary,\
				.woocommerce #content div.product div.summary,\
				.woocommerce-page div.product div.summary,\
				.woocommerce-page #content div.product div.summary {width: ' + (98 - newval) + '%;}\
			';
		});
	});

	// Price font size.
	wp.customize('woocommerce_single_price_size', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_price_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.woocommerce div.product span.price, .woocommerce div.product p.price {font-size: ' + newval + suffix + ';}';
		});
	});

	// Price font color.
	wp.customize('woocommerce_single_price_color', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_price_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce div.product span.price, .woocommerce div.product p.price {color: ' + newval + ';}';
		});
	});

	// Tabs background color.
	wp.customize('woocommerce_single_tabs_background_color', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_background_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li {background-color: ' + newval + ';}';
		});
	});

	// Tabs background color hover.
	wp.customize('woocommerce_single_tabs_background_color_alt', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_background_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li:hover {background-color: ' + newval + '; border-bottom-color: ' + newval + ';}';
		});
	});

	// Tabs background color active.
	wp.customize('woocommerce_single_tabs_background_color_active', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_background_color_active');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li.active:hover {background-color: ' + newval + '; border-bottom-color: ' + newval + ';}';
		});
	});

	// Tabs font color.
	wp.customize('woocommerce_single_tabs_font_color', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_font_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a {color: ' + newval + ';}';
		});
	});

	// Tabs font color hover.
	wp.customize('woocommerce_single_tabs_font_color_alt', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_font_color_alt');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a:hover {color: ' + newval + ';}';
		});
	});

	// Tabs font color active.
	wp.customize('woocommerce_single_tabs_font_color_active', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_font_color_active');

		value.bind(function (newval) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a {color: ' + newval + ';}';
		});
	});

	/** Woocommerce Store & Notices */

	// Woocommerce info notice's accent color.
	wp.customize("woocommerce_info_notice_color", function (value) {
		var styleTag = setupStyleTag("woocommerce_info_notice_color");

		value.bind(function (newval) {
			styleTag.innerHTML = "\
				.woocommerce-info {border-top-color: " + newval + ";}\
				.woocommerce-info:before, .woocommerce-info a {color: " + newval + "}\
			";
		});
	});

	// Woocommerce success notice's accent color.
	wp.customize("woocommerce_message_notice_color", function (value) {
		var styleTag = setupStyleTag("woocommerce_message_notice_color");

		value.bind(function (newval) {
			styleTag.innerHTML = "\
				.woocommerce-message {border-top-color: " + newval + ";}\
				.woocommerce-message:before, .woocommerce-message a {color: " + newval + "}\
			";
		});
	});

	// Woocommerce error notice's accent color.
	wp.customize("woocommerce_error_notice_color", function (value) {
		var styleTag = setupStyleTag("woocommerce_error_notice_color");

		value.bind(function (newval) {
			styleTag.innerHTML = "\
				.woocommerce-error {border-top-color: " + newval + ";}\
				.woocommerce-error:before, .woocommerce-error a {color: " + newval + "}\
			";
		});
	});

	// Woocommerce general notice's background color.
	wp.customize("woocommerce_notice_bg_color", function (value) {
		var styleTag = setupStyleTag("woocommerce_notice_bg_color");

		value.bind(function (newval) {
			styleTag.innerHTML = ".woocommerce-message {background-color: " + newval + ";}";
		});
	});

	// Woocommerce general notice's text color.
	wp.customize("woocommerce_notice_text_color", function (value) {
		var styleTag = setupStyleTag("woocommerce_notice_text_color");

		value.bind(function (newval) {
			styleTag.innerHTML = ".woocommerce-message {color: " + newval + ";}";
		});
	});

	// Tabs font size.
	wp.customize('woocommerce_single_tabs_font_size', function (value) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_font_size');

		value.bind(function (newval) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li a {font-size: ' + newval + suffix + ';}';
		});
	});

	/* EDD - Menu Item */

	// Desktop color.
	wp.customize('edd_menu_item_desktop_color', function (value) {
		var styleTag = setupStyleTag('edd_menu_item_desktop_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '\
				.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count {background-color: ' + newval + ';}\
			';
		});
	});

	// Mobile color.
	wp.customize('edd_menu_item_mobile_color', function (value) {
		var styleTag = setupStyleTag('edd_menu_item_mobile_color');

		value.bind(function (newval) {
			styleTag.innerHTML = '\
				.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count {background-color: ' + newval + ';}\
			';
		});
	});

	/* Easy Digital Downloads - Defaults */

	// Button border radius.
	wp.customize('button_border_radius', function (value) {
		var styleTag = setupStyleTag('button_border_radius');

		value.bind(function (newval) {
			styleTag.innerHTML = '.edd-submit.button {border-radius: ' + newval + 'px;}';
		});
	});

})(jQuery);
