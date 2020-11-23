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
		$('.wpbf-settings-panel').css('display', 'flex');
	});

	$('.recommended-panel').on('click', function(event) {
		$('.wpbf-admin-panel').css('display', 'none');
		$('.wpbf-recommended-panel').css('display', 'flex');
	});

	$('.premium-panel').on('click', function(event) {
		$('.wpbf-admin-panel').css('display', 'none');
		$('.wpbf-premium-panel').css('display', 'flex');
	});

	$('.documentation-panel').on('click', function(event) {
		$('.wpbf-admin-panel').css('display', 'none');
		$('.wpbf-documentation-panel').css('display', 'flex');
	});

	$(window).on('load', function(event) {

		var hash = window.location.hash;

		if ( ! hash ) {
			hash = '#settings';
		}

		if ( "#settings" === hash ) {
			$('.wpbf-admin-page-nav-item.settings-panel').addClass('active');
			$('.wpbf-settings-panel').css('display', 'flex');
		}

		if ( "#recommended" === hash ) {
			$('.wpbf-admin-page-nav-item.recommended-panel').addClass('active');
			$('.wpbf-recommended-panel').css('display', 'flex');
		}

		if ( "#premium" === hash ) {
			$('.wpbf-admin-page-nav-item.premium-panel').addClass('active');
			$('.wpbf-premium-panel').css('display', 'flex');
		}

		if ( "#documentation" === hash ) {
			$('.wpbf-admin-page-nav-item.documentation-panel').addClass('active');
			$('.wpbf-documentation-panel').css('display', 'flex');
		}

	});

})(jQuery);
