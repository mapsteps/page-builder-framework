/**
 * Custom Event polyfill for >= IE9
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/API/CustomEvent/CustomEvent#Polyfill
 */
(function () {

	if (typeof window.CustomEvent === "function") return false;

	function CustomEvent(event, params) {
		params = params || { bubbles: false, cancelable: false, detail: null };
		var evt = document.createEvent('CustomEvent');
		evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
		return evt;
	}

	window.CustomEvent = CustomEvent;
})();

(function ($) {

	setTimeout(function () {
		$(document.body).trigger('wc_fragment_refresh');
	}, 150);

})(jQuery);

(function ($) {
	function init() {
		window.addEventListener('load', function () {
			setupProductQuantities();
			setupQuickView();
		});

		$(document.body).on('updated_wc_div', function (e) {
			var cartForm = document.querySelector('.woocommerce-cart-form');
			if (!cartForm) return;
			setupProductQuantities(cartForm);
		});
	}

	/**
	 * The Quickview content is taken via AJAX request.
	 * Currently we manually waiting for the Quickview content to be ready.
	 *
	 * In the future, we might want to add event to the "Premium Add-On",
	 * so we can just listen to the event.
	 */
	function setupQuickView() {
		var quickViews = document.querySelectorAll('.wpbf-woo-quick-view');

		if (!quickViews.length) return;

		[].slice.call(quickViews).forEach(function (quickView) {
			var maxWait = 3000; // Max wait of the ajax request of quickview modal.
			var currentWait = 0;

			quickView.addEventListener('click', waitForQuickViewReponse);

			function waitForQuickViewReponse() {
				console.log('Waiting for the Quickview request...');

				if (!document.querySelector('.wpbf-woo-quick-view-modal-content .type-product')) {
					/**
					 * The content of the quickview is taken from ajax response.
					 * Let's wait until ready (but with maximum waiting time).
					 */
					if (currentWait <= maxWait) {
						setTimeout(function () {
							waitForQuickViewReponse();
							currentWait += 300;
						}, 300);
					}
				} else {
					setupProductQuantitiesOnQuickView();
				}
			}
		});
	}

	function setupProductQuantities(theForm) {
		var quantities;

		if (theForm) {
			quantities = theForm.querySelectorAll('.quantity');
		} else {
			quantities = document.querySelectorAll('form .quantity');
		}

		if (!quantities.length) return;

		[].slice.call(quantities).forEach(function (quantity) {
			setupProductQuantity(quantity);
		});
	}

	function setupProductQuantitiesOnQuickView() {
		var quantities = document.querySelectorAll('.wpbf-woo-quick-view-modal-content .quantity');

		if (!quantities.length) return;

		[].slice.call(quantities).forEach(function (quantity) {
			setupProductQuantity(quantity);
		});
	}

	function setupProductQuantity(quantity) {
		var qty = quantity.querySelector('.qty');
		var decrease = quantity.querySelector('.wpbf-qty-decrease');
		var increase = quantity.querySelector('.wpbf-qty-increase');

		if (!qty || !decrease || !increase) return;

		qty.parentNode.classList.add('wpbf-quantity');

		decrease.addEventListener('click', function (e) {
			e.preventDefault();
			var value = parseInt(qty.value, 10) - 1;

			value = value < 1 ? 0 : value;
			qty.value = value;

			qty.dispatchEvent(new Event('change', { bubbles: true }));
		});

		increase.addEventListener('click', function (e) {
			e.preventDefault();
			qty.value = parseInt(qty.value, 10) + 1;

			qty.dispatchEvent(new Event('change', { bubbles: true }));
		});
	}

	init();
})(jQuery);