(function () {
	function init() {
		setupProductQuantity();
	}

	function setupProductQuantity() {
		var qty = document.querySelector('.quantity .qty');
		var decrease = document.querySelector('.wpbf-qty-decrease');
		var increase = document.querySelector('.wpbf-qty-increase');
		
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