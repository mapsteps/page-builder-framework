(function () {
	function init() {
		window.addEventListener('load', function () {
			setupProductQuantities();
			setupQuickView();
		});
	}

	function setupQuickView() {
		var quickViews = document.querySelectorAll('.wpbf-woo-quick-view');

		if (!quickViews.length) return;

		[].slice.call(quickViews).forEach(function (quickView) {
			quickView.addEventListener('click', function () {
				setTimeout(function () {
					setupProductQuantitiesOnQuickView();
				}, 500); // The fadeIn in premium add-on is 300ms.
			})
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
		var quantity = document.querySelector('.wpbf-woo-quick-view-modal-content .quantity');

		if (!quantity) return;
		setupProductQuantity(quantity);
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