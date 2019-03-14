(function ($) {

	$(document).on('click', '.single_add_to_cart_button', function(e) {
		e.preventDefault();

		var $thisbutton      = $(this),
				$form        = $thisbutton.closest('form.cart'),
				id           = $thisbutton.val(),
				product_qty  = $form.find('input[name=quantity]').val() || 1,
				product_id   = $form.find('input[name=product_id]').val() || id,
				variation_id = $form.find('input[name=variation_id]').val() || 0;

		var data = {
			action: 'wpbf_woo_single_add_to_cart_ajax',
			product_id: product_id,
			product_sku: '',
			quantity: product_qty,
			variation_id: variation_id,
		};

		$(document.body).trigger('adding_to_cart', [$thisbutton, data]);

		$.ajax({
			type: 'post',
			url: wc_add_to_cart_params.ajax_url,
			data: data,
			beforeSend: function(response) {
				$thisbutton.removeClass('added').addClass('loading');
			},
			complete: function(response) {
				$thisbutton.addClass('added').removeClass('loading');
			},
			success: function(response) {

				if (response.error & response.product_url) {
					window.location = response.product_url;
					return;
				} else {
					$(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
				}
			},
		});

		return false;
	});

})(jQuery);