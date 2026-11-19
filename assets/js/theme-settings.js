/**
 * Theme Settings page: tabs and the "Clear Font Cache" button.
 */
(function () {
	var page = document.querySelector(".wpbf-theme-settings-page");

	if (!page) return;

	// Tabs: each tab and its panel share data-panel; the address' #hash picks the tab.
	var tabs = page.querySelectorAll(".heatbox-tab-nav-item");
	var panels = page.querySelectorAll(".heatbox-admin-panel");

	function showPanel(name) {
		var found = false;

		panels.forEach(function (panel) {
			if (panel.dataset.panel === name) found = true;
		});

		if (!found) name = "settings";

		panels.forEach(function (panel) {
			panel.style.display = panel.dataset.panel === name ? "block" : "none";
		});

		tabs.forEach(function (tab) {
			var active = tab.dataset.panel === name;
			var link = tab.querySelector("a");

			tab.classList.toggle("active", active);

			if (active) {
				link.setAttribute("aria-current", "page");
			} else {
				link.removeAttribute("aria-current");
			}
		});
	}

	window.addEventListener("hashchange", function () {
		showPanel(window.location.hash.slice(1));
	});

	showPanel(window.location.hash.slice(1));

	// Clear font cache.
	var button = page.querySelector(".wpbf-remove-downloaded-fonts");
	var notice = page.querySelector(".wpbf-remove-downloaded-fonts-notice");
	var noticeTimer;

	if (!button || !notice) return;

	function showNotice(text, type) {
		notice.textContent = text;
		notice.classList.remove("is-success", "is-error");
		notice.classList.add("is-shown", "is-" + type);
		clearTimeout(noticeTimer);
		noticeTimer = setTimeout(function () {
			notice.classList.remove("is-shown");
		}, 4000);
	}

	button.addEventListener("click", function () {
		if (button.classList.contains("is-loading")) return;

		button.classList.add("is-loading");

		fetch(window.ajaxurl, {
			method: "POST",
			credentials: "same-origin",
			body: new URLSearchParams({
				action: "wpbf_clear_font_cache",
				nonce: button.dataset.nonce,
			}),
		})
			.then(function (response) {
				return response.json();
			})
			.then(function (response) {
				showNotice(response.data || notice.dataset.error, response.success ? "success" : "error");
			})
			.catch(function () {
				showNotice(notice.dataset.error, "error");
			})
			.finally(function () {
				button.classList.remove("is-loading");
			});
	});
})();
