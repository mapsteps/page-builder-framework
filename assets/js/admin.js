/**
 * Global variables used:
 * - ajaxurl
 */
(function ($) {

	$('.wpbf-admin-page-nav-item').on('click', function(event) {
		$('.wpbf-admin-page-nav-item').removeClass('active');
		$(this).addClass('active');
	});

	$('.settings-panel').on('click', function(event) {
		$('.wpbf-admin-panel').css('display', 'none');
		$('.wpbf-settings-panel').css('display', 'block');
	});

	$('.recommended-panel').on('click', function(event) {
		$('.wpbf-admin-panel').css('display', 'none');
		$('.wpbf-recommended-panel').css('display', 'block');
	});

	$('.premium-panel').on('click', function(event) {
		$('.wpbf-admin-panel').css('display', 'none');
		$('.wpbf-premium-panel').css('display', 'block');
	});

	$('.documentation-panel').on('click', function(event) {
		$('.wpbf-admin-panel').css('display', 'none');
		$('.wpbf-documentation-panel').css('display', 'block');
	});

	$(window).on('load', function(event) {

		var hash = window.location.hash;

		if ( ! hash ) {
			hash = '#settings';
		}

		if ( "#settings" === hash ) {
			$('.wpbf-admin-page-nav-item.settings-panel').addClass('active');
			$('.wpbf-settings-panel').css('display', 'block');
		}

		if ( "#recommended" === hash ) {
			$('.wpbf-admin-page-nav-item.recommended-panel').addClass('active');
			$('.wpbf-recommended-panel').css('display', 'block');
		}

		if ( "#premium" === hash ) {
			$('.wpbf-admin-page-nav-item.premium-panel').addClass('active');
			$('.wpbf-premium-panel').css('display', 'block');
		}

		if ( "#documentation" === hash ) {
			$('.wpbf-admin-page-nav-item.documentation-panel').addClass('active');
			$('.wpbf-documentation-panel').css('display', 'block');
		}

	});

})(jQuery);
