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
})(jQuery);
