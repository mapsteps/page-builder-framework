( function( $ ) {

	/* Layout */

	// Page Boxed Margin
	wp.customize( 'page_boxed_margin', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-page').css('margin-top', newval + 'px' );
			$('.wpbf-page').css('margin-bottom', newval + 'px' );
		} );
	} );

	// Page Boxed Padding
	wp.customize( 'page_boxed_padding', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-container').css('padding-left', newval + 'px' );
			$('.wpbf-container').css('padding-right', newval + 'px' );
		} );
	} );

	// Page Boxed Background Color
	wp.customize( 'page_boxed_background', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-page').css('background-color', newval );
		} );
	} );

	// ScrollTop Background Color
	wp.customize( 'scrolltop_bg_color', function( value ) {
		value.bind( function( newval ) {
			$('.scrolltop').css('background', newval );
		} );
	} );

	// ScrollTop Background Color
	wp.customize( 'scrolltop_border_radius', function( value ) {
		value.bind( function( newval ) {
			$('.scrolltop').css('border-radius', newval + 'px' );
		} );
	} );

	/* Sub Menu */

	// Background Color
	wp.customize( 'sub_menu_bg_color', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-sub-menu > .menu-item-has-children:not(.wpbf-mega-menu) .sub-menu li, .wpbf-sub-menu > .wpbf-mega-menu > .sub-menu').css('background-color', newval );
		} );
	} );

	// Font Color
	wp.customize( 'sub_menu_accent_color', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-menu .sub-menu a').css('color', newval );
		} );
	} );

	// Font Size
	wp.customize( 'sub_menu_font_size', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-menu .sub-menu a').css('font-size', newval );
		} );
	} );

	/* Mobile Navigation */

	// Hamburger Size
	wp.customize( 'mobile_menu_hamburger_size', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-mobile-menu-toggle').css('font-size', newval + 'px' );
		} );
	} );

	/* Logo */

	// logo size
	wp.customize( 'menu_logo_size', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-logo img').css('height', newval );
		} );
	} );

	// logo mobile size
	wp.customize( 'menu_mobile_logo_size', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-mobile-logo img').css('height', newval );
		} );
	} );

	// Logo Container Width
	wp.customize( 'menu_logo_container_width', function( value ) {
		value.bind( function( newval ) {
			var calculation = 100-newval;
			$('.wpbf-navigation .wpbf-1-4').css('width', newval + '%' );
			$('.wpbf-navigation .wpbf-3-4').css('width', calculation + '%' );
		} );
	} );

	/* Tagline */

	// tagline color
	wp.customize( 'menu_logo_description_color', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-tagline').css('color', newval );
		} );
	} );

	// tagline font size
	wp.customize( 'menu_logo_description_font_size', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-tagline').css('font-size', newval );
		} );
	} );

	/* Navigation */

	/* Mobile Menu */
	wp.customize( 'mobile_menu_height', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-mobile-nav-wrapper').css('padding-top', newval + 'px' );
			$('.wpbf-mobile-nav-wrapper').css('padding-bottom', newval + 'px' );
		} );
	} );

	wp.customize( 'mobile_menu_submenu_arrow_color', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-submenu-toggle').css('color', newval );
		} );
	} );

	/* Pre Header */

	wp.customize( 'pre_header_bg_color', function( value ) {
		value.bind( function( newval ) {
			$('#wpbf-pre-header').css('background-color', newval );
		} );
	} );

	wp.customize( 'pre_header_height', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-inner-pre-header').css('padding-top', newval + 'px' );
			$('.wpbf-inner-pre-header').css('padding-bottom', newval + 'px' );
		} );
	} );

	wp.customize( 'pre_header_font_color', function( value ) {
		value.bind( function( newval ) {
			$('#wpbf-pre-header').css('color', newval );
		} );
	} );

	/* Sidebar */

	wp.customize( 'sidebar_bg_color', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-sidebar .widget').css('background-color', newval );
		} );
	} );

	wp.customize( 'sidebar_width', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-sidebar-wrapper').css('width', newval + '%' );
			$('.wpbf-main').css('width', 100 - newval + '%' );
		} );
	} );

	/* Buttons */

	wp.customize( 'button_border_radius', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-button, input[type="submit"], .woocommerce a.button, .woocommerce button.button').css('border-radius', newval + 'px' );
		} );
	} );

	wp.customize( 'button_border_width', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-button, input[type="submit"]').css('border-width', newval + 'px' );
			$('.wpbf-button, input[type="submit"]').css('border-type', 'solid' );
		} );
	} );

	wp.customize( 'button_border_color', function( value ) {
		value.bind( function( newval ) {
			$('.wpbf-button, input[type="submit"]').css('border-color', newval );
		} );
	} );

} )( jQuery );