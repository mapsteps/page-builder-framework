/**
 * Global variables used:
 * - ajaxurl
 */
(function ($) {

	var ajax = {};

	function init() {
		window.addEventListener('load', function (e) {
			setTimeout(setupActivationNoticeDismissal, 1000);
			setTimeout(setupBfcmNoticeDismissal, 1000);
		});
	}

	function setupActivationNoticeDismissal() {
		var panel = document.querySelector('.wpbf-activation-notice.is-dismissible');
		if (!panel) return;
		panel.querySelector('.notice-dismiss').addEventListener('click', ajax.saveActivationDismissal);
	}

	ajax.saveActivationDismissal = function (e) {
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

	function setupBfcmNoticeDismissal() {
		var panel = document.querySelector('.wpbf-bfcm-notice.is-dismissible');
		if (!panel) return;
		panel.querySelector('.notice-dismiss').addEventListener('click', ajax.saveBfcmDismissal);
	}

	ajax.saveBfcmDismissal = function (e) {
		$.ajax({
			url: ajaxurl,
			type: 'post',
			data: {
				action: 'wpbf_bfcm_notice_dismissal',
				nonce: wpbfOpts.bfcmNotice.dismissalNonce,
				dismiss: 1
			}
		}).always(function (r) {
			if (r.success) console.log(r.data);
		});
	};

	init();

})(jQuery);
