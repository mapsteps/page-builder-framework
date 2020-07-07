( function( $ ) {

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

	/* Layout */

	// Page width.
	wp.customize( 'page_max_width', function( value ) {
		var styleTag = setupStyleTag('page_max_width');
		
		value.bind( function( newval ) {
			newval = !newval ? '1200px' : newval;
			styleTag.innerHTML = '.wpbf-container, .wpbf-boxed-layout .wpbf-page {max-width: ' + newval + ';}';
		} );
	} );

	// Boxed margin.
	wp.customize( 'page_boxed_margin', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-page').css('margin-top', newval + 'px' ).css('margin-bottom', newval + 'px' );
		} );
	} );

	// Boxed padding.
	wp.customize( 'page_boxed_padding', function( value ) {
		var styleTag = setupStyleTag('page_boxed_padding');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-container {padding-left: ' + newval + 'px; padding-right: ' + newval + 'px;}';
		} );
	} );

	// Boxed background color.
	wp.customize( 'page_boxed_background', function( value ) {
		var styleTag = setupStyleTag('page_boxed_background');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-page {background-color: ' + newval + ';}';
		} );
	} );

	// ScrollTop position.
	wp.customize( 'scrolltop_position', function( value ) {
		var styleTag = setupStyleTag('scrolltop_position');

		value.bind( function( newval ) {
			if( newval === 'left' ) {
				styleTag.innerHTML = '.scrolltop {left: 20px; right: auto;}';
			} else {
				styleTag.innerHTML = '.scrolltop {left: auto; right: 20px;}';
			}
		} );
	} );

	// ScrollTop background color.
	wp.customize( 'scrolltop_bg_color', function( value ) {
		var styleTag = setupStyleTag('scrolltop_bg_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.scrolltop {background-color: ' + newval + ';}';
		} );
	} );

	// ScrollTop background color.
	wp.customize( 'scrolltop_bg_color_alt', function( value ) {
		var styleTag = setupStyleTag('scrolltop_bg_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.scrolltop:hover {background-color: ' + newval + ';}';
		} );
	} );

	// ScrollTop icon color.
	wp.customize( 'scrolltop_icon_color', function( value ) {
		var styleTag = setupStyleTag('scrolltop_icon_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.scrolltop {color: ' + newval + ';}';
		} );
	} );

	// ScrollTop icon color.
	wp.customize( 'scrolltop_icon_color_alt', function( value ) {
		var styleTag = setupStyleTag('scrolltop_icon_color_alt');
		
		value.bind( function( newval ) {
			styleTag.innerHTML = '.scrolltop:hover {color: ' + newval + ';}';
		} );
	} );

	// ScrollTop border radius.
	wp.customize( 'scrolltop_border_radius', function( value ) {
		var styleTag = setupStyleTag('scrolltop_border_radius');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.scrolltop {border-radius: ' + newval + 'px;}';
		} );
	} );

	/* Typography */

	wp.customize( 'page_font_color', function( value ) {
		var styleTag = setupStyleTag('page_font_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = 'body {color: ' + newval + ';}';
		} );
	} );

	/* 404 */

	wp.customize( '404_headline', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-404-content .entry-title').text( newval );
		} );
	} );

	wp.customize( '404_text', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-404-content p').text( newval );
		} );
	} );

	/* Navigation */

	// Width.
	wp.customize( 'menu_width', function( value ) {
		var styleTag = setupStyleTag('menu_width');

		value.bind( function( newval ) {
			newval = !newval ? '1200px' : newval;
			styleTag.innerHTML = '.wpbf-nav-wrapper {max-width: ' + newval + ';}';
		} );
	} );

	// Menu height.
	wp.customize( 'menu_height', function( value ) {
		var styleTag = setupStyleTag('menu_height');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-nav-wrapper {padding-top: ' + newval + 'px; padding-bottom: ' + newval + 'px;}';
		} );
	} );

	// Menu padding.
	wp.customize( 'menu_padding', function( value ) {
		var styleTag = setupStyleTag('menu_padding');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-navigation .wpbf-menu > .menu-item > a {padding-left: ' + newval + 'px; padding-right: ' + newval + 'px;}';
		} );
	} );

	// Background color.
	wp.customize( 'menu_bg_color', function( value ) {
		var styleTag = setupStyleTag('menu_bg_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-navigation {background-color: ' + newval + ';}';
		} );
	} );

	// Font color.
	wp.customize( 'menu_font_color', function( value ) {
		var styleTag = setupStyleTag('menu_font_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a, .wpbf-close {color: ' + newval + ';}';
		} );
	} );

	// Font color hover.
	wp.customize( 'menu_font_color_alt', function( value ) {
		var styleTag = setupStyleTag('menu_font_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-navigation .wpbf-menu a:hover, .wpbf-mobile-menu a:hover {color: ' + newval + ';}\
				.wpbf-navigation .wpbf-menu > .current-menu-item > a, .wpbf-mobile-menu > .current-menu-item > a {color: ' + newval + '!important;}\
			';
		} );
	} );

	// Font size.
	wp.customize( 'menu_font_size', function( value ) {
		var styleTag = setupStyleTag('menu_font_size');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-navigation .wpbf-menu a, .wpbf-mobile-menu a {font-size: ' + newval + suffix + ';}';
		} );
	} );

	/* Sub Menu */

	// Padding top.
	wp.customize( 'sub_menu_padding_top', function( value ) {
		var styleTag = setupStyleTag('sub_menu_padding_top');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a {padding-top: ' + newval + 'px;}';
		} );
	} );

	// Padding right.
	wp.customize( 'sub_menu_padding_right', function( value ) {
		var styleTag = setupStyleTag('sub_menu_padding_right');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a {padding-right: ' + newval + 'px;}';
		} );
	} );

	// Padding bottom.
	wp.customize( 'sub_menu_padding_bottom', function( value ) {
		var styleTag = setupStyleTag('sub_menu_padding_bottom');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a {padding-bottom: ' + newval + 'px;}';
		} );
	} );

	// Padding left.
	wp.customize( 'sub_menu_padding_left', function( value ) {
		var styleTag = setupStyleTag('sub_menu_padding_left');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu a {padding-left: ' + newval + 'px;}';
		} );
	} );

	// Width.
	wp.customize( 'sub_menu_width', function( value ) {
		var styleTag = setupStyleTag('sub_menu_width');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu {width: ' + newval + 'px;}';
		} );
	} );

	// Background color.
	wp.customize( 'sub_menu_bg_color', function( value ) {
		var styleTag = setupStyleTag('sub_menu_bg_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li,\
				.wpbf-sub-menu > .wpbf-mega-menu > .sub-menu {\
					background-color: ' + newval + ';\
				}\
			';
		} );
	} );

	// Background color hover.
	wp.customize( 'sub_menu_bg_color_alt', function( value ) {
		var styleTag = setupStyleTag('sub_menu_bg_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li:hover {\
					background-color: ' + newval + ';\
				}\
			';
		} );
	} );

	// Accent color.
	wp.customize( 'sub_menu_accent_color', function( value ) {
		var styleTag = setupStyleTag('sub_menu_accent_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-menu .sub-menu a {color: ' + newval + ';}';
		} );
	} );

	// Accent color hover.
	wp.customize( 'sub_menu_accent_color_alt', function( value ) {
		var styleTag = setupStyleTag('sub_menu_accent_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-navigation .wpbf-menu .sub-menu a:hover {color: ' + newval + ';}';
		} );
	} );

	// Font size.
	wp.customize( 'sub_menu_font_size', function( value ) {
		var styleTag = setupStyleTag('sub_menu_font_size');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-menu .sub-menu a {font-size: ' + newval + suffix + ';}';
		} );
	} );

	// Separator color.
	wp.customize( 'sub_menu_separator_color', function( value ) {
		var styleTag = setupStyleTag('sub_menu_separator_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) li {border-bottom-color: ' + newval + ';}';
		} );
	} );

	/* Mobile Navigation */

	// Height.
	wp.customize( 'mobile_menu_height', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_height');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-mobile-nav-wrapper {padding-top: ' + newval + 'px; padding-bottom: ' + newval + 'px;}';
		} );
	} );

	// Background color.
	wp.customize( 'mobile_menu_background_color', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_background_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-mobile-nav-wrapper {background-color: ' + newval + ';}';
		} );
	} );

	// Icon color.
	wp.customize( 'mobile_menu_hamburger_color', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_hamburger_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-mobile-nav-item, .wpbf-mobile-nav-item a {color: ' + newval + ';}';
		} );
	} );

	// Hamburger size.
	wp.customize( 'mobile_menu_hamburger_size', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_hamburger_size');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-mobile-nav-item {font-size: ' + newval + suffix + ';}';
		} );
	} );

	// Hamburger border radius (filled).
	wp.customize( 'mobile_menu_hamburger_border_radius', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_hamburger_border_radius');
		
		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-mobile-nav-item {border-radius: ' + newval + 'px;}';
		} );
	} );

	// Padding top.
	wp.customize( 'mobile_menu_padding_top', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_padding_top');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-mobile-menu a,\
				.wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {\
					padding-top: ' + newval + 'px;\
				}\
			';
		} );
	} );

	// Padding right.
	wp.customize( 'mobile_menu_padding_right', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_padding_right');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-mobile-menu a,\
				.wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {\
					padding-right: ' + newval + 'px;\
				}\
			';
		} );
	} );

	// Padding bottom.
	wp.customize( 'mobile_menu_padding_bottom', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_padding_bottom');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-mobile-menu a,\
				.wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {\
					padding-bottom: ' + newval + 'px;\
				}\
			';
		} );
	} );

	// Padding left.
	wp.customize( 'mobile_menu_padding_left', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_padding_left');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-mobile-menu a,\
				.wpbf-mobile-menu .menu-item-has-children .wpbf-submenu-toggle {\
					padding-left: ' + newval + 'px;\
				}\
			';
		} );
	} );

	// Menu item background color.
	wp.customize( 'mobile_menu_bg_color', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_bg_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-mobile-menu > .menu-item a {background-color: ' + newval + ';}';
		} );
	} );

	// Menu item background color hover.
	wp.customize( 'mobile_menu_bg_color_alt', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_bg_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-mobile-menu > .menu-item a:hover {background-color: ' + newval + ';}';
		} );
	} );

	// Menu item font color.
	wp.customize( 'mobile_menu_font_color', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_font_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-mobile-menu a, .wpbf-mobile-menu-container .wpbf-close {color: ' + newval + ';}';
		} );
	} );

	// Menu item font color hover.
	wp.customize( 'mobile_menu_font_color_alt', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_font_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-mobile-menu a:hover, .wpbf-mobile-menu > .current-menu-item > a {color: ' + newval + '!important;}';
		} );
	} );

	// Menu item divider color.
	wp.customize( 'mobile_menu_border_color', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_border_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-mobile-menu .menu-item {border-top-color: ' + newval + ';}\
				.wpbf-mobile-menu > .menu-item:last-child {border-bottom-color: ' + newval + ';}\
			';
		} );
	} );

	// Sub menu arrow color.
	wp.customize( 'mobile_menu_submenu_arrow_color', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_submenu_arrow_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-submenu-toggle {color: ' + newval + ';}';
		} );
	} );

	// Menu item font size.
	wp.customize( 'mobile_menu_font_size', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_font_size');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-mobile-menu a {font-size: ' + newval + suffix + ';}';
		} );
	} );

	/* Logo */

	// Width desktop.
	wp.customize( 'menu_logo_size_desktop', function( value ) {
		var styleTag = setupStyleTag('menu_logo_size_desktop');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-logo img, .wpbf-mobile-logo img {width: ' + newval + suffix + ';}';
		} );
	} );

	// Width tablet.
	wp.customize( 'menu_logo_size_tablet', function( value ) {
		var styleTag = setupStyleTag('menu_logo_size_tablet');
		
		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '\
				@media (' + mediaQueries.tablet + ') {\
					.wpbf-mobile-logo img {width: ' + newval + suffix + ';\
				}\
			';
		} );
	} );

	// Width mobile.
	wp.customize( 'menu_logo_size_mobile', function( value ) {
		var styleTag = setupStyleTag('menu_logo_size_mobile');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '\
				@media (' + mediaQueries.mobile + ') {\
					.wpbf-mobile-logo img {width: ' + newval + suffix + ';}\
				}\
			';
		} );
	} );

	// Font size desktop.
	wp.customize( 'menu_logo_font_size_desktop', function( value ) {
		var styleTag = setupStyleTag('menu_logo_font_size_desktop');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-logo a, .wpbf-mobile-logo a {font-size: ' + newval + suffix + ';}';
		} );
	} );

	// Font size tablet.
	wp.customize( 'menu_logo_font_size_tablet', function( value ) {
		var styleTag = setupStyleTag('menu_logo_font_size_tablet');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '\
				@media (' + mediaQueries.tablet + ') {\
					.wpbf-mobile-logo a {font-size: ' + newval + suffix + ';\
				}\
			';
		} );
	} );

	// Font size mobile.
	wp.customize( 'menu_logo_font_size_mobile', function( value ) {
		var styleTag = setupStyleTag('menu_logo_font_size_mobile');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '\
				@media (' + mediaQueries.mobile + ') {\
					.wpbf-mobile-logo a {font-size: ' + newval + suffix + ';}\
				}\
			';
		} );
	} );

	// Color.
	wp.customize( 'menu_logo_color', function( value ) {
		var styleTag = setupStyleTag('menu_logo_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-logo a, .wpbf-mobile-logo a {color: ' + newval + ';}';
		} );
	} );

	// Color hover.
	wp.customize( 'menu_logo_color_alt', function( value ) {
		var styleTag = setupStyleTag('menu_logo_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-logo a:hover, .wpbf-mobile-logo a:hover {color: ' + newval + ';}';
		} );
	} );

	// Container width.
	wp.customize( 'menu_logo_container_width', function( value ) {
		var styleTag = setupStyleTag('menu_logo_container_width');

		value.bind( function( newval ) {
			var calculation = 100 - newval;
			styleTag.innerHTML = '\
				.wpbf-navigation .wpbf-1-4 {width: ' + newval + '%;}\
				.wpbf-navigation .wpbf-3-4 {width: ' + calculation + '%;}\
			';
		} );
	} );

	// Mobile container width.
	wp.customize( 'mobile_menu_logo_container_width', function( value ) {
		var styleTag = setupStyleTag('mobile_menu_logo_container_width');

		value.bind( function( newval ) {
			var calculation = 100 - newval;
			styleTag.innerHTML = '\
				@media (' + mediaQueries.tablet + ') {\
					.wpbf-navigation .wpbf-2-3 {width: ' + newval + '%;}\
					.wpbf-navigation .wpbf-1-3 {width: ' + calculation + '%;}\
				}\
			';
		} );
	} );

	/* Tagline */

	// Font size desktop.
	wp.customize( 'menu_logo_description_font_size_desktop', function( value ) {
		var styleTag = setupStyleTag('menu_logo_description_font_size_desktop');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-logo .wpbf-tagline, .wpbf-mobile-logo .wpbf-tagline {font-size: ' + newval + suffix + ';}';
		} );
	} );

	// Font size tablet.
	wp.customize( 'menu_logo_description_font_size_tablet', function( value ) {
		var styleTag = setupStyleTag('menu_logo_description_font_size_tablet');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '\
				@media (' + mediaQueries.tablet + ') {\
					.wpbf-mobile-logo .wpbf-tagline {font-size: ' + newval + suffix + ';}\
				}\
			';
		} );
	} );

	// Font size mobile.
	wp.customize( 'menu_logo_description_font_size_mobile', function( value ) {
		var styleTag = setupStyleTag('menu_logo_description_font_size_mobile');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '\
				@media (' + mediaQueries.mobile + ') {\
					.wpbf-mobile-logo .wpbf-tagline {font-size: ' + newval + suffix + ';}\
				}\
			';
		} );
	} );

	// Font color.
	wp.customize( 'menu_logo_description_color', function( value ) {
		var styleTag = setupStyleTag('menu_logo_description_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-tagline {color: ' + newval + ';}';
		} );
	} );

	/* Pre Header */

	// Width.
	wp.customize( 'pre_header_width', function( value ) {
		var styleTag = setupStyleTag('pre_header_width');

		value.bind( function( newval ) {
			newval = !newval ? '1200px' : newval;
			styleTag.innerHTML = '.wpbf-inner-pre-header {max-width: ' + newval + ';}';
		} );
	} );

	// Height.
	wp.customize( 'pre_header_height', function( value ) {
		var styleTag = setupStyleTag('pre_header_height');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-inner-pre-header {padding-top: ' + newval + 'px; padding-bottom: ' + newval + 'px;}';
		} );
	} );

	// Background color.
	wp.customize( 'pre_header_bg_color', function( value ) {
		var styleTag = setupStyleTag('pre_header_bg_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-pre-header {background-color: ' + newval + ';}';
		} );
	} );

	// Font color.
	wp.customize( 'pre_header_font_color', function( value ) {
		var styleTag = setupStyleTag('pre_header_font_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-pre-header {color: ' + newval + ';}';
		} );
	} );

	// Accent color.
	wp.customize( 'pre_header_accent_color', function( value ) {
		var styleTag = setupStyleTag('pre_header_accent_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-pre-header a {color: ' + newval + ';}';
		} );
	} );

	// Accent color hover.
	wp.customize( 'pre_header_accent_color_alt', function( value ) {
		var styleTag = setupStyleTag('pre_header_accent_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-pre-header a:hover, .wpbf-pre-header .wpbf-menu > .current-menu-item > a {color: ' + newval + '!important;}';
		} );
	} );

	// Font size.
	wp.customize( 'pre_header_font_size', function( value ) {
		var styleTag = setupStyleTag('pre_header_font_size');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '\
				.wpbf-pre-header,\
				.wpbf-pre-header .wpbf-menu,\
				.wpbf-pre-header .wpbf-menu .sub-menu a {\
					font-size: ' + newval + suffix + ';\
				}\
			';
		} );
	} );

	/* Blog – Pagination */

	// Border radius.
	wp.customize( 'blog_pagination_border_radius', function( value ) {
		var styleTag = setupStyleTag('blog_pagination_border_radius');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.pagination .page-numbers {border-radius: ' + newval + 'px;}';
		} );
	} );

	// Background color.
	wp.customize( 'blog_pagination_background_color', function( value ) {
		var styleTag = setupStyleTag('blog_pagination_background_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.pagination .page-numbers:not(.current) {background-color: ' + newval + ';}';
		} );
	} );

	// Background color hover.
	wp.customize( 'blog_pagination_background_color_alt', function( value ) {
		var styleTag = setupStyleTag('blog_pagination_background_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.pagination .page-numbers:not(.current):hover {background-color: ' + newval + ';}';
		} );
	} );

	// Background color active.
	wp.customize( 'blog_pagination_background_color_active', function( value ) {
		var styleTag = setupStyleTag('blog_pagination_background_color_active');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.pagination .page-numbers.current {background-color: ' + newval + ';}';
		} );
	} );

	// Font color.
	wp.customize( 'blog_pagination_font_color', function( value ) {
		var styleTag = setupStyleTag('blog_pagination_font_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.pagination .page-numbers:not(.current) {color: ' + newval + ';}';
		} );
	} );

	// Font color hover.
	wp.customize( 'blog_pagination_font_color_alt', function( value ) {
		var styleTag = setupStyleTag('blog_pagination_font_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.pagination .page-numbers:not(.current):hover {color: ' + newval + ';}';
		} );
	} );

	// Font color active.
	wp.customize( 'blog_pagination_font_color_active', function( value ) {
		var styleTag = setupStyleTag('blog_pagination_font_color_active');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.pagination .page-numbers.current {color: ' + newval + ';}';
		} );
	} );

	// Font size.
	wp.customize( 'blog_pagination_font_size', function( value ) {
		var styleTag = setupStyleTag('blog_pagination_font_size');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.pagination .page-numbers {font-size: ' + newval + suffix + ';}';
		} );
	} );

	/* Sidebar */

	// Width.
	wp.customize( 'sidebar_width', function( value ) {
		var styleTag = setupStyleTag('sidebar_width');

		value.bind( function( newval ) {
			var calculation = 100 - newval;
			styleTag.innerHTML = '\
				.wpbf-sidebar-wrapper {width: ' + newval + '%;}\
				.wpbf-sidebar-left .wpbf-main, .wpbf-sidebar-right .wpbf-main {width: ' + calculation + '%;}\
			';
		} );
	} );

	// Background color.
	wp.customize( 'sidebar_bg_color', function( value ) {
		var styleTag = setupStyleTag('sidebar_bg_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-sidebar .widget, .elementor-widget-sidebar .widget {background-color: ' + newval + ';}';
		} );
	} );

	/* Buttons */

	// Background color.
	wp.customize( 'button_bg_color', function( value ) {
		var styleTag = setupStyleTag('button_bg_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-button:not(.wpbf-button-primary), input[type="submit"] {background-color: ' + newval + ';}';
		} );
	} );

	// Background color hover.
	wp.customize( 'button_bg_color_alt', function( value ) {
		var styleTag = setupStyleTag('button_bg_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover {background-color: ' + newval + ';}';
		} );
	} );

	// Text color.
	wp.customize( 'button_text_color', function( value ) {
		var styleTag = setupStyleTag('button_text_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-button:not(.wpbf-button-primary), input[type="submit"] {color: ' + newval + ';}';
		} );
	} );

	// Text color hover.
	wp.customize( 'button_text_color_alt', function( value ) {
		var styleTag = setupStyleTag('button_text_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover {color: ' + newval + ';}';
		} );
	} );

	// Primary background color.
	wp.customize( 'button_primary_bg_color', function( value ) {
		var styleTag = setupStyleTag('button_primary_bg_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-button-primary {background-color: ' + newval + ';}\
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background) {background-color: ' + newval + ';}\
				.is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background) {border-color: ' + newval + '; color: ' + newval + ';}\
			';
		} );
	} );

	// Primary background color hover.
	wp.customize( 'button_primary_bg_color_alt', function( value ) {
		var styleTag = setupStyleTag('button_primary_bg_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-button-primary:hover {background-color: ' + newval + ';}\
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover {background-color: ' + newval + ';}\
				.is-style-outline .wp-block-button__link:not(.has-text-color):not(.has-background):hover {border-color: ' + newval + '; color: ' + newval + ';}\
			';
		} );
	} );

	// Primary text color.
	wp.customize( 'button_primary_text_color', function( value ) {
		var styleTag = setupStyleTag('button_primary_text_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-button-primary {color: ' + newval + ';}\
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-text-color) {color: ' + newval + ';}\
			';
		} );
	} );

	// Primary text color hover.
	wp.customize( 'button_primary_text_color_alt', function( value ) {
		var styleTag = setupStyleTag('button_primary_text_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-button-primary:hover {color: ' + newval + ';}\
				.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(.has-background):not(.has-text-color):hover {color: ' + newval + ';}\
			';
		} );
	} );

	// Border radius.
	wp.customize( 'button_border_radius', function( value ) {
		var styleTag = setupStyleTag('button_border_radius');
		
		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-button, input[type="submit"] {border-radius: ' + newval + 'px;}';
		} );
	} );

	// Border width.
	wp.customize( 'button_border_width', function( value ) {
		var styleTag = setupStyleTag('button_border_width');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-button, input[type="submit"] {border-width: ' + newval + 'px; border-style: solid;}';
		} );
	} );

	// Border color.
	wp.customize( 'button_border_color', function( value ) {
		var styleTag = setupStyleTag('button_border_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-button:not(.wpbf-button-primary), input[type="submit"] {border-color: ' + newval + ';}';
		} );
	} );

	// Border color hover.
	wp.customize( 'button_border_color_alt', function( value ) {
		var styleTag = setupStyleTag('button_border_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-button:not(.wpbf-button-primary):hover, input[type="submit"]:hover {border-color: ' + newval + ';}';
		} );
	} );

	// Primary border color.
	wp.customize( 'button_primary_border_color', function( value ) {
		var styleTag = setupStyleTag('button_primary_border_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-button-primary {border-color: ' + newval + ';}';
		} );
	} );

	// Primary border color hover.
	wp.customize( 'button_primary_border_color_alt', function( value ) {
		var styleTag = setupStyleTag('button_primary_border_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-button-primary:hover {border-color: ' + newval + ';}';
		} );
	} );

	/* Breadcrumbs */

	// Background background color.
	wp.customize( 'breadcrumbs_background_color', function( value ) {
		var styleTag = setupStyleTag('breadcrumbs_background_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-breadcrumbs-container {background-color: ' + newval + ';}';
		} );
	} );

	// Alignment.
	wp.customize( 'breadcrumbs_alignment', function( value ) {
		var styleTag = setupStyleTag('breadcrumbs_alignment');

		value.bind( function( newval ) {text-align
			styleTag.innerHTML = '.wpbf-breadcrumbs-container {text-align: ' + newval + ';}';
		} );
	} );

	// Font color.
	wp.customize( 'breadcrumbs_font_color', function( value ) {
		var styleTag = setupStyleTag('breadcrumbs_font_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-breadcrumbs {color: ' + newval + ';}';
		} );
	} );

	// Accent color.
	wp.customize( 'breadcrumbs_accent_color', function( value ) {
		var styleTag = setupStyleTag('breadcrumbs_accent_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-breadcrumbs a {color: ' + newval + ';}';
		} );
	} );

	// Accent color hover.
	wp.customize( 'breadcrumbs_accent_color_alt', function( value ) {
		var styleTag = setupStyleTag('breadcrumbs_accent_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-breadcrumbs a:hover {color: ' + newval + ';}';
		} );
	} );

	/* Footer */

	// Width.
	wp.customize( 'footer_width', function( value ) {
		var styleTag = setupStyleTag('footer_width');

		value.bind( function( newval ) {
			newval = !newval ? '1200px' : newval;
			styleTag.innerHTML = '.wpbf-inner-footer {max-width: ' + newval + ';}';
		} );
	} );

	// Height.
	wp.customize( 'footer_height', function( value ) {
		var styleTag = setupStyleTag('footer_height');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-inner-footer {padding-top: ' + newval + 'px; padding-bottom: ' + newval + 'px;}';
		} );
	} );

	// Background color.
	wp.customize( 'footer_bg_color', function( value ) {
		var styleTag = setupStyleTag('footer_bg_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-page-footer {background-color: ' + newval + ';}';
		} );
	} );

	// Font color.
	wp.customize( 'footer_font_color', function( value ) {
		var styleTag = setupStyleTag('footer_font_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-inner-footer {color: ' + newval + ';}';
		} );
	} );

	// Accent color.
	wp.customize( 'footer_accent_color', function( value ) {
		var styleTag = setupStyleTag('footer_accent_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-inner-footer a {color: ' + newval + ';}';
		} );
	} );

	// Accent color hover.
	wp.customize( 'footer_accent_color_alt', function( value ) {
		var styleTag = setupStyleTag('footer_accent_color_alt');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.wpbf-inner-footer a:hover, .wpbf-inner-footer .wpbf-menu > .current-menu-item > a {color: ' + newval + ';}';
		} );
	} );

	// Font size.
	wp.customize( 'footer_font_size', function( value ) {
		var styleTag = setupStyleTag('footer_font_size');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.wpbf-inner-footer, .wpbf-inner-footer .wpbf-menu {font-size: ' + newval + suffix + ';}';
		} );
	} );

	/* WooCommerce - Defaults */

	// Button border radius.
	wp.customize( 'button_border_radius', function( value ) {
		var styleTag = setupStyleTag('button_border_radius');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce a.button, .woocommerce button.button {border-radius: ' + newval + 'px;}';
		} );
	} );

	// Custom width.
	wp.customize( 'woocommerce_loop_custom_width', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_custom_width');

		value.bind( function( newval ) {
			newval = !newval ? '1200px' : newval;
			styleTag.innerHTML = '.archive.woocommerce #inner-content {max-width: ' + newval + ';}';
		} );
	} );

	/* WooCommerce - Menu Item */

	// Desktop color.
	wp.customize( 'woocommerce_menu_item_desktop_color', function( value ) {
		var styleTag = setupStyleTag('woocommerce_menu_item_desktop_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count {background-color: ' + newval + ';}\
				.wpbf-menu .wpbf-woo-menu-item .wpbf-woo-menu-item-count:before {color: ' + newval + ';}\
			';
		} );
	} );

	// Mobile color.
	wp.customize( 'woocommerce_menu_item_mobile_color', function( value ) {
		var styleTag = setupStyleTag('woocommerce_menu_item_mobile_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count {background-color: ' + newval + ';}\
				.wpbf-mobile-nav-wrapper .wpbf-woo-menu-item .wpbf-woo-menu-item-count:before {color: ' + newval + ';}\
			';
		} );
	} );

	/* WooCommerce - Loop */

	// Content alignment.
	wp.customize( 'woocommerce_loop_content_alignment', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_content_alignment');

		value.bind( function( newval ) {
			if( newval === 'center' ) {
				styleTag.innerHTML = '\
						.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: ' + newval + ';}\
						.woocommerce .products .star-rating {margin: 0 auto 10px auto;}\
					';
			} else if( newval === 'right' ) {
				styleTag.innerHTML = '\
						.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: ' + newval + ';}\
						.woocommerce .products .star-rating {display: inline-block; text-align: right;}\
					';
			} else {
				styleTag.innerHTML = '.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {text-align: ' + newval + ';}';
			}
		} );
	} );

	// Image alignment.
	wp.customize( 'woocommerce_loop_image_alignment', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_image_alignment');

		value.bind( function( newval ) {
			if( newval == 'left' ) {
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
		} );
	} );

	// Image width.
	wp.customize( 'woocommerce_loop_image_width', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_image_width');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-woo-list-view .wpbf-woo-loop-thumbnail-wrapper {width: ' + (newval - 2) + '%;}\
				.wpbf-woo-list-view .wpbf-woo-loop-summary {width: ' + (98 - newval) + '%;}\
			';
		} );
	} );

	// Title font size.
	wp.customize( 'woocommerce_loop_title_size', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_title_size');
		
		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';

			styleTag.innerHTML = '\
				.woocommerce ul.products li.product h3,\
				.woocommerce ul.products li.product .woocommerce-loop-product__title,\
				.woocommerce ul.products li.product .woocommerce-loop-category__title {\
					font-size: ' + newval + suffix + ';\
				}\
			';
		} );
	} );

	// Title font color.
	wp.customize( 'woocommerce_loop_title_color', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_title_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.woocommerce ul.products li.product h3,\
				.woocommerce ul.products li.product .woocommerce-loop-product__title,\
				.woocommerce ul.products li.product .woocommerce-loop-category__title {\
					color: ' + newval + ';\
				}\
			';
		} );
	} );

	// Price font size.
	wp.customize( 'woocommerce_loop_price_size', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_price_size');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.woocommerce ul.products li.product .price {font-size: ' + newval + suffix + ';}';
		} );
	} );

	// Price font color.
	wp.customize( 'woocommerce_loop_price_color', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_price_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce ul.products li.product .price {color: ' + newval + ';}';
		} );
	} );

	// Out of stock notice.
	wp.customize( 'woocommerce_loop_out_of_stock_font_size', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_out_of_stock_font_size');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {font-size: ' + newval + suffix + ';}';
		} );
	} );

	// Out of stock color.
	wp.customize( 'woocommerce_loop_out_of_stock_font_color', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_out_of_stock_font_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {color: ' + newval + ';}';
		} );
	} );

	// Out of stock background color.
	wp.customize( 'woocommerce_loop_out_of_stock_background_color', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_out_of_stock_background_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce ul.products li.product .wpbf-woo-loop-out-of-stock {background-color: ' + newval + ';}';
		} );
	} );

	// Sale font size.
	wp.customize( 'woocommerce_loop_sale_font_size', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_sale_font_size');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.woocommerce span.onsale {font-size: ' + newval + suffix + ';}';
		} );
	} );

	// Sale font color.
	wp.customize( 'woocommerce_loop_sale_font_color', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_sale_font_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce span.onsale {color: ' + newval + ';}';
		} );
	} );

	// Sale background color.
	wp.customize( 'woocommerce_loop_sale_background_color', function( value ) {
		var styleTag = setupStyleTag('woocommerce_loop_sale_background_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce span.onsale {background-color: ' + newval + ';}';
		} );
	} );

	/* WooCommerce - Single */

	// Custom width.
	wp.customize( 'woocommerce_single_custom_width', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_custom_width');

		value.bind( function( newval ) {
			newval = !newval ? '1200px' : newval;
			styleTag.innerHTML = '.single.woocommerce #inner-content {max-width: ' + newval + ';}';
		} );
	} );

	// Image alignment.
	wp.customize( 'woocommerce_single_alignment', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_alignment');

		value.bind( function( newval ) {
			if( newval === 'right' ) {
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
		} );
	} );

	// Image width.
	wp.customize( 'woocommerce_single_image_width', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_image_width');

		value.bind( function( newval ) {
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
		} );
	} );

	// Price font size.
	wp.customize( 'woocommerce_single_price_size', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_price_size');

		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.woocommerce div.product span.price, .woocommerce div.product p.price {font-size: ' + newval + suffix + ';}';
		} );
	} );

	// Price font color.
	wp.customize( 'woocommerce_single_price_color', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_price_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce div.product span.price, .woocommerce div.product p.price {color: ' + newval + ';}';
		} );
	} );

	// Tabs background color.
	wp.customize( 'woocommerce_single_tabs_background_color', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_background_color');
		
		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li {background-color: ' + newval + ';}';
		} );
	} );

	// Tabs background color hover.
	wp.customize( 'woocommerce_single_tabs_background_color_alt', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_background_color_alt');
		
		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li:hover {background-color: ' + newval + '; border-bottom-color: ' + newval + ';}';
		} );
	} );

	// Tabs background color active.
	wp.customize( 'woocommerce_single_tabs_background_color_active', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_background_color_active');
		
		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li.active:hover {background-color: ' + newval + '; border-bottom-color: ' + newval + ';}';
		} );
	} );

	// Tabs font color.
	wp.customize( 'woocommerce_single_tabs_font_color', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_font_color');
		
		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a {color: ' + newval + ';}';
		} );
	} );

	// Tabs font color hover.
	wp.customize( 'woocommerce_single_tabs_font_color_alt', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_font_color_alt');
		
		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a:hover {color: ' + newval + ';}';
		} );
	} );

	// Tabs font color active.
	wp.customize( 'woocommerce_single_tabs_font_color_active', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_font_color_active');
		
		value.bind( function( newval ) {
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a {color: ' + newval + ';}';
		} );
	} );

	// Tabs font size.
	wp.customize( 'woocommerce_single_tabs_font_size', function( value ) {
		var styleTag = setupStyleTag('woocommerce_single_tabs_font_size');
		
		value.bind( function( newval ) {
			var suffix = $.isNumeric(newval) ? 'px' : '';
			styleTag.innerHTML = '.woocommerce div.product .woocommerce-tabs ul.tabs li a {font-size: ' + newval + suffix + ';}';
		} );
	} );

	/* EDD - Menu Item */

	// Desktop color.
	wp.customize( 'edd_menu_item_desktop_color', function( value ) {
		var styleTag = setupStyleTag('edd_menu_item_desktop_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count {background-color: ' + newval + ';}\
				.wpbf-menu .wpbf-edd-menu-item .wpbf-edd-menu-item-count:before {color: ' + newval + ';}\
			';
		} );
	} );

	// Mobile color.
	wp.customize( 'edd_menu_item_mobile_color', function( value ) {
		var styleTag = setupStyleTag('edd_menu_item_mobile_color');

		value.bind( function( newval ) {
			styleTag.innerHTML = '\
				.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count {background-color: ' + newval + ';}\
				.wpbf-mobile-nav-wrapper .wpbf-edd-menu-item .wpbf-edd-menu-item-count:before {color: ' + newval + ';}\
			';
		} );
	} );

	/* Easy Digital Downloads - Defaults */

	// Button border radius.
	wp.customize( 'button_border_radius', function( value ) {
		var styleTag = setupStyleTag('button_border_radius');

		value.bind( function( newval ) {
			styleTag.innerHTML = '.edd-submit.button {border-radius: ' + newval + 'px;}';
		} );
	} );

} )( jQuery );
