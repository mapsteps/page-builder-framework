(function () {
	function init() {
		window.addEventListener('load', function () {
			setupProductQuantities();
			setupQuickView();
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

	function setupProductQuantities() {
		var quantities = document.querySelectorAll('form.cart .quantity');

		if (!quantities.length) return;

		[].slice.call(quantities).forEach(function (quantity) {
			setupProductQuantity(quantity);
		});
	}

	function setupProductQuantitiesOnQuickView() {
		var quantities = document.querySelector('.wpbf-woo-quick-view-modal-content .quantity');

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

		decrease.addEventListener('click', function () {
			var value = parseInt(qty.value, 10) - 1;

			value = value < 1 ? 1 : value;
			qty.value = value;
		});

		increase.addEventListener('click', function () {
			qty.value = parseInt(qty.value, 10) + 1;
		});
	}

	init();
})();