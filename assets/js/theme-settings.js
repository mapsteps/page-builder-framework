/**
 * Global variables used:
 * - ajaxurl
 */
(function ($) {
	$(".heatbox-tab-nav-item").on("click", function (event) {
		$(".heatbox-tab-nav-item").removeClass("active");
		$(this).addClass("active");
	});

	$(".settings-panel").on("click", function (event) {
		$(".heatbox-admin-panel").css("display", "none");
		$(".wpbf-settings-panel").css("display", "block");
	});

	$(".recommended-panel").on("click", function (event) {
		$(".heatbox-admin-panel").css("display", "none");
		$(".wpbf-recommended-panel").css("display", "block");
	});

	$(".premium-panel").on("click", function (event) {
		$(".heatbox-admin-panel").css("display", "none");
		$(".wpbf-premium-panel").css("display", "block");
	});

	$(".documentation-panel").on("click", function (event) {
		$(".heatbox-admin-panel").css("display", "none");
		$(".wpbf-documentation-panel").css("display", "block");
	});

	$(window).on("load", function (event) {
		var hash = window.location.hash;

		if (!hash) {
			hash = "#settings";
		}

		if ("#settings" === hash) {
			$(".heatbox-tab-nav-item.settings-panel").addClass("active");
			$(".wpbf-settings-panel").css("display", "block");
		}

		if ("#recommended" === hash) {
			$(".heatbox-tab-nav-item.recommended-panel").addClass("active");
			$(".wpbf-recommended-panel").css("display", "block");
		}

		if ("#premium" === hash) {
			$(".heatbox-tab-nav-item.premium-panel").addClass("active");
			$(".wpbf-premium-panel").css("display", "block");
		}

		if ("#documentation" === hash) {
			$(".heatbox-tab-nav-item.documentation-panel").addClass("active");
			$(".wpbf-documentation-panel").css("display", "block");
		}

		setupClearFontCache();

		function setupClearFontCache() {
			var notice = document.querySelector(
				".wpbf-remove-downloaded-fonts-metabox .submission-status"
			);
			if (!notice) return;
			var doingAjax = false;
			$(".wpbf-remove-downloaded-fonts").on("click", clearFontCache);

			function clearFontCache(e) {
				if (doingAjax) return;
				doingAjax = true;
				var button = this;
				button.classList.add("is-loading");

				var data = {
					action: "wpbf_clear_font_cache",
					nonce: button.dataset.nonce,
				};

				$.ajax({
					url: ajaxurl,
					type: "POST",
					data: data,
				})
					.done(function (r) {
						showNotice(r.success ? "success" : "error", r.data);
					})
					.fail(function (r) {
						showNotice("error", "Something went wrong.");
					})
					.always(function (r) {
						doingAjax = false;
						button.classList.remove("is-loading");
						setTimeout(function () {
							hideNotice();
						}, 4000);
					});
			}

			function showNotice(status, textContent) {
				notice.textContent = textContent;
				notice.classList.add(status === "success" ? "is-success" : "is-error");
				notice.classList.remove("is-hidden");
			}

			function hideNotice() {
				notice.textContent = "";
				notice.classList.remove("is-success");
				notice.classList.remove("is-error");
				notice.classList.add("is-hidden");
			}
		}
	});
})(jQuery);
