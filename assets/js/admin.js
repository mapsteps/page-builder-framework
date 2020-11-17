/**
 * Global variables used:
 * - ajaxurl
 */
(function ($) {
	var ajax = {};

	function init() {
		window.addEventListener('load', function (e) {
			setupActivationNoticeDismissal();
		});
	}

	function setupActivationNoticeDismissal() {
		var panel = document.querySelector('.wpbf-activation-notice.is-dismissible');
		if (!panel) return;
		panel.querySelector('.notice-dismiss').addEventListener('click', ajax.saveDismissal);
	}

	ajax.saveDismissal = function (e) {
		$.ajax({
			url: ajaxurl,
			type: 'post',
			data: {
				action: 'wpbf_activation_notice_dismissal',
				nonce: wpbfOpts.activationNotice.dismissalNonce,
				dismiss: 1
			}
		}).always(function (r) {
			if (r.success) console.log(r.data);
		});
	};

	init();

	$('.wpbf-admin-page-nav-item').on('click', function(event) {
		// event.preventDefault();
		$('.wpbf-admin-page-nav-item').removeClass('active');
		$(this).addClass('active');
	});

	$('.settings-panel').on('click', function(event) {
		// event.preventDefault();
		$('.wpbf-admin-panel').css('display', 'none');
		$('.wpbf-settings-panel').css('display', 'flex');
	});

	$('.recommended-panel').on('click', function(event) {
		// event.preventDefault();
		$('.wpbf-admin-panel').css('display', 'none');
		$('.wpbf-recommended-panel').css('display', 'flex');
	});

	$('.premium-panel').on('click', function(event) {
		// event.preventDefault();
		$('.wpbf-admin-panel').css('display', 'none');
		$('.wpbf-premium-panel').css('display', 'flex');
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

	});

})(jQuery);
