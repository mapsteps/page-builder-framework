init();

function init() {
	window.addEventListener("load", function (e) {
		setTimeout(setupActivationNoticeDismissal, 1000);
		setTimeout(setupBfcmNoticeDismissal, 1000);
	});
}

function setupActivationNoticeDismissal() {
	const panel = document.querySelector(
		".wpbf-activation-notice.is-dismissible",
	);
	if (!panel) return;

	const dismiss = panel.querySelector(".notice-dismiss");
	if (!dismiss || !(dismiss instanceof HTMLElement)) return;

	dismiss.addEventListener("click", saveActivationDismissal);
}

/**
 * @param {MouseEvent} e - Click event.
 */
function saveActivationDismissal(e) {
	jQuery
		.ajax({
			// @ts-ignore
			url: window.ajaxurl,
			type: "post",
			data: {
				action: "wpbf_activation_notice_dismissal",
				// @ts-ignore
				nonce: window.wpbfOpts.activationNotice.dismissalNonce,
				dismiss: 1,
			},
		})
		.always(function (r) {
			if (r.success) console.log(r.data);
		});
}

function setupBfcmNoticeDismissal() {
	const dismisser = document.querySelector(
		".wpbf-bfcm-notice.is-dismissible .notice-dismiss",
	);
	if (!dismisser) return;
	dismisser.addEventListener("click", saveBfcmDismissal);
}

/**
 * Save BFCM notice dismissal.
 *
 * @this {HTMLElement}
 */
function saveBfcmDismissal() {
	$.ajax({
		// @ts-ignore
		url: window.ajaxurl,
		type: "post",
		data: {
			action: "wpbf_bfcm_notice_dismissal",
			// @ts-ignore
			nonce: window.wpbfOpts.bfcmNotice.dismissalNonce,
			dismiss: 1,
		},
	}).always(function (r) {
		if (r.success) console.log(r.data);
	});
}
