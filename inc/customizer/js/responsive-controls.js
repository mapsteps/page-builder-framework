jQuery(document).ready(function ($) {
	// Let's use the API.
	var api = wp.customize;

	syncPreviewButtons();

	/**
	 * Sync device preview button from WordPress to WPBF and vice versa.
	 */
	function syncPreviewButtons() {
		// Bind device changes from WordPress default.
		api.previewedDevice.bind(function (newDevice) {
			wpbfResponsivePreview(newDevice);
		});
	}

	/**
	 * Setup WPBF device preview.
	 *
	 * @param string device The device (mobile, tablet, or desktop).
	 * @param bool modifyOverlay Whether or not to modify the wp-full-overlay.
	 */
	function wpbfResponsivePreview(device) {
		$(".wpbf-responsive-options button").removeClass("active");
		$(".wpbf-responsive-options .preview-" + device).addClass("active");
		$(".wpbf-control-device").removeClass("active");
		$(".wpbf-control-" + device).addClass("active");
	}

	// Display desktop control by default.
	$(".wpbf-control-desktop").addClass("active");

	// Loop through wpbf device buttons and assign the event.
	$(document).on("click", ".wpbf-responsive-options button", function (e) {
		var device = this.getAttribute("data-device");

		wpbfResponsivePreview(device);
		// Trigger WordPress device event.
		api.previewedDevice.set(device);
	});
});
