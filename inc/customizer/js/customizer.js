jQuery(document).ready(function($) {

	$('#customize-control-menu_logo_container_width').on('mousedown', function() {
		$('iframe').contents().find('.wpbf-navigation .wpbf-1-4').css( 'border-right', '3px solid #0085ba' );
	}).on('mouseup', function() {
		$('iframe').contents().find('.wpbf-navigation .wpbf-1-4').css( 'border-right', 'none' );
	});

	$('#customize-control-mobile_menu_logo_container_width').on('mousedown', function() {
		$('iframe').contents().find('.wpbf-navigation .wpbf-2-3').css( 'border-right', '3px solid #0085ba' );
	}).on('mouseup', function() {
		$('iframe').contents().find('.wpbf-navigation .wpbf-2-3').css( 'border-right', 'none' );
	});

});

/**
 * Width fields that follow Page Width when empty (navigation, pre header, footer, and every "..._custom_width": blog,
 * posts, shop, product, Premium's post types) show the current Page Width greyed out, and follow it while it changes.
 */
(function (api) {
	var ownIds = ["menu_width", "pre_header_width", "footer_width"];

	function follows(id) {
		return ownIds.indexOf(id) !== -1 || /_custom_width$/.test(id);
	}

	function pageWidth() {
		var width = String(api("page_max_width") ? api("page_max_width").get() : "").trim();

		if (!width) {
			width = "1200px";
		}

		return /^\d+(\.\d+)?$/.test(width) ? width + "px" : width;
	}

	function showOn(control) {
		control.deferred.embedded.done(function () {
			control.container.find("input").attr("placeholder", pageWidth());
		});
	}

	api.bind("ready", function () {
		api.control.each(function (control) {
			if (follows(control.id)) {
				showOn(control);
			}
		});

		if (api("page_max_width")) {
			api("page_max_width").bind(function () {
				api.control.each(function (control) {
					if (follows(control.id)) {
						control.container.find("input").attr("placeholder", pageWidth());
					}
				});
			});
		}
	});
})(wp.customize);
