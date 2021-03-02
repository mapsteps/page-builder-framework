(function ($) {

	function init() {
		window.addEventListener('load', function () {
			setupProductQuantities();
			quantityChange();
			setupQuickView();
		});

		// Make the code work after executing AJAX.
		$(document).ajaxComplete(function () {
			setupProductQuantities();
			quantityChange();
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

	function setupProductQuantitiesOnQuickView() {
		var quantities = document.querySelectorAll('.wpbf-woo-quick-view-modal-content .quantity');

		if (!quantities.length) return;

		[].slice.call(quantities).forEach(function (quantity) {
			setupProductQuantity(quantity);
		});
	}

	function setupProductQuantities() {
		var quantities;

		quantities = document.querySelectorAll('.quantity');

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
	}

	function quantityChange() {
		$(document).off("click", ".wpbf-qty-control").on( "click", ".wpbf-qty-control", function() {

			// Find quantity input field corresponding to increment button clicked.
			var qty = $( this ).parent().find( '.qty' );
			// Read value and attributes min, max, step.
			var val = parseFloat(qty.val());
			var max = parseFloat(qty.attr( "max" ));
			var min = parseFloat(qty.attr( "min" ));
			var step = parseFloat(qty.attr( "step" ));

			// Change input field value if result is in min and max range.
			// If the result is above max then change to max and alert user about exceeding max stock.
			// If the field is empty, fill with min for "-" (0 possible) and step for "+".
			if ( $( this ).is( ".wpbf-qty-increase" ) ) {
				if ( val === max ) return false;
				if( isNaN(val) ) {
					qty.val( step );
				} else if ( val + step > max ) {
					qty.val( max );
				} else {
					qty.val( val + step );
				}
			} else {
				if ( val === min ) return false;
				if( isNaN(val) ) {
					qty.val( min );
				} else if ( val - step < min ) {
					qty.val( min );
				} else {
					qty.val( val - step );
				}
			}

			qty.val( Math.round( qty.val() * 100 ) / 100 );
			qty.trigger("change");

		});
	}

	init();

})(jQuery);
