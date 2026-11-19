/**
 * Customizer preview of the theme options that change more than CSS without a reload (texts, classes).
 * CSS is drawn by preview-css.js from the same declarations as the front end (inc/customizer/styles/).
 */
(function ($) {

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

})(jQuery);
