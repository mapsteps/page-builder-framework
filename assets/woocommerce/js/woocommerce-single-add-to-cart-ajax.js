if (!window.Wpbf) window.Wpbf = {};

/**
 * Global objects used:
 * - wc_add_to_cart_params
 * - WpbfObj
 */
Wpbf.singleAddToCart = (function ($) {

	if (!wc_add_to_cart_params) return;

	var state = {
		isRequesting: false
	};

	var loading = {};
	var ajax = {};

	/**
	 * Init the module.
	 */
	function init() {
		$(document).on('click', '.single-product .single_add_to_cart_button', ajax.addToCart);
	}

	loading.start = function (button) {
		button.classList.add('is-loading');
	};

	loading.stop = function (button) {
		button.classList.remove('is-loading');
	};

	/**
	 * Add to cart.
	 * 
	 * This function uses our `add_to_cart` ajax handler in woocommerce-functions.php file.
	 * However, our handler is only about preparing the response & adjusting wc notices.
	 *
	 * The core functionality is using Woocommerce's default `add_to_cart_action` function
	 * inside  class-wc-form-handler.php file.
	 * 
	 * The `add_to_cart_action` is hooked into `wp_loaded` by Woocommerce.
	 *
	 * @see wp-content/plugins/woocommerce/includes/class-wc-form-handler.php
	 * @see wp-content/themes/Page-Builder-Framework/inc/integration/woocommerce/woocommerce-functions.php
	 *
	 * @param Event e The event object.
	 */
	ajax.addToCart = function (e) {
		var button = this;

		var product = button.closest('.product.type-product');
		if (!product) return;

		e.preventDefault();

		var isVariable = product.classList.contains('product-type-variable');
		var isGrouped = product.classList.contains('product-type-grouped');

		if (state.isRequesting) return;
		state.isRequesting = true;

		loading.start(button);

		var cartForm = product.querySelector("form.cart");
		var addToCartField = cartForm.querySelector('[name="add-to-cart"]');
		var qtyField = cartForm.querySelector('[name="quantity"]');

		var isVariable = product.classList.contains('product-type-variable');
		var isGrouped = product.classList.contains('product-type-grouped');

		var productId = addToCartField.value;

		/**
		 * The submission payload format.
		 * 
		 * Below are the payload format for simple, variable, and grouped products.
		 * The value of `add-to-cart` (by Woocommerce) is product_id.
		 * 
		 * Simple product (doesn't require `product_id`):
		 * {
		 * 		add-to-cart: 200,
		 * 		quantity: 1
		 * }
		 * 
		 * Variable product:
		 * {
		 * 		add-to-cart: 200,
		 * 		product_id: 200,
		 * 		quantity: 1,
		 * 		variation_id: 100,
		 * 		attribute_sample: sampleValue,
		 * 		attribute_another: anotherValue,
		 * 		attribute_more: moreValue
		 * }
		 * 
		 * Grouped product (doesn't require `product_id`):
		 * {
		 * 		add-to-cart: 200,
		 * 		quantity: {
		 * 			205: 1,
		 * 			206: 2,
		 * 			207: 1
		 * 		}
		 * }
		 */
		var payload = {};

		payload.action = 'wpbf_woo_single_add_to_cart';
		payload['add-to-cart'] = productId;

		var groupItems;

		// If current product is a grouped products.
		if (isGrouped) {
			groupItems = cartForm.querySelectorAll('.woocommerce-grouped-product-list-item');
			payload.quantity = {};

			groupItems.forEach(function (productItem) {
				var productId = productItem.id.replace('product-', '');
				var qtyField = productItem.querySelector('input.qty');

				payload.quantity[productId] = qtyField ? qtyField.value : 0;
			});
		} else {
			payload.quantity = qtyField ? qtyField.value : 0;
		}

		var variationFields;
		var variationIdField;

		// If current product is a variable product.
		if (isVariable) {
			variationIdField = cartForm.querySelector('[name="variation_id"]');
			variationFields = cartForm.querySelectorAll('.variations .value select[data-attribute_name]');

			payload.product_id = productId;
			payload.variation_id = variationIdField ? variationIdField.value : 0;

			variationFields.forEach(function (field) {
				payload[field.name] = field.value;
			});
		}

		$.ajax({
			url: WpbfObj.ajaxurl,
			type: 'post',
			dataType: 'json',
			data: payload
		}).done(function (response) {
			if (!response) return;

			// Trigger event so themes can refresh other areas.
			$(document.body).trigger('wc_fragment_refresh');
			$(document.body).trigger('added_to_cart', [{}, '', $(button)]);
			if (response.data) printWcNotices(response.data, 'success');
		}).fail(function (jqXHR) {
			if (jqXHR.responseJSON && jqXHR.responseJSON.data) {
				printWcNotices(jqXHR.responseJSON.data, 'error');
			}
		}).always(function () {
			loading.stop(button);
			state.isRequesting = false;
		});
	}

	/**
	 * Build error message.
	 *
	 * @param {object} jqXHR The jQuery XHR object.
	 * @returns The error message.
	 */
	function buildErrorMsg(jqXHR) {
		var msg = 'Error ' + jqXHR.status.toString() + ' (' + jqXHR.statusText + ')';
		msg = jqXHR.responseJSON && jqXHR.responseJSON.data ? msg + ': ' + jqXHR.responseJSON.data : msg;

		return msg;
	}

	/**
	 * Print Woocommerce notices.
	 *
	 * @param {object} jqXHR The jQuery XHR object.
	 * @returns The error message.
	 */
	function printWcNotices(data, type) {
		if (!Array.isArray(data) || !data.length) return;
		if (!type) type = "success";

		var $noticesWrapper = $('.woocommerce-notices-wrapper');
		var noticeClass = 'success' === type ? 'woocommerce-message' : 'woocommerce-error';

		data.forEach(function (item) {
			if (!item.notice) return;
			$noticesWrapper.append('<div class="' + noticeClass + '">' + item.notice + '</div>');
		});
	}

	init();

	return {};

})(jQuery);
