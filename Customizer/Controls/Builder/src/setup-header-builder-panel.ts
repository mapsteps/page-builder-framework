export default function setupHeaderBuilderPanel() {
	if (!window.wp || !window.wp.customize) return;

	const api = window.wp.customize;
	const panelId = "header_panel";
	const toggleFieldId = "wpbf_use_header_builder";

	api.panel(panelId, function (panel) {
		if (panel.expanded()) {
			// Check for the toggleFieldId: if it's enabled, then open the panel.
			api.control(toggleFieldId, function (control) {
				if (control?.setting?.get()) {
					openBuilderPanel();
				}
			});
		} else {
			closeBuilderPanel();
		}
	});

	api.control(toggleFieldId, function (control) {
		control?.setting?.bind(function (enabled) {
			if (enabled) {
				// Check for the panelId: if it's expanded, then open the panel.
				api.panel(panelId, function (panel) {
					if (panel.expanded()) {
						openBuilderPanel();
					}
				});
			} else {
				closeBuilderPanel();
			}
		});
	});

	function openBuilderPanel() {
		//
	}

	function closeBuilderPanel() {
		//
	}
}
