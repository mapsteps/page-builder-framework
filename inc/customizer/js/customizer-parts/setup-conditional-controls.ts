/**
 * Initializes additional visibility conditions for Customizer controls
 * that are not covered by their default `active_callback` settings.
 *
 * Use case:
 * When the header builder is enabled, some existing controls are moved
 * into header builder sections. These controls already have their own
 * `active_callback` logic, but in some cases we need to apply extra
 * or different visibility conditions beyond those defaults.
 *
 * This function allows defining such custom conditional behaviors.
 *
 * @export
 */
export function setupConditionalControls() {
	init();

	function init() {
		setupMobileMenuTriggerVisibility();
	}

	/**
	 * Toggles visibility of mobile menu trigger controls based on the selected menu style.
	 */
	function setupMobileMenuTriggerVisibility() {
		const styleSettingId = "wpbf_header_builder_mobile_menu_trigger_style";

		const controlsToToggle = [
			"mobile_menu_hamburger_bg_color",
			"mobile_menu_hamburger_border_radius",
		];

		function applyVisibility(buttonStyle: string) {
			const shouldShow = buttonStyle === "outline" || buttonStyle === "solid";

			controlsToToggle.forEach((controlId) => {
				try {
					window.wp.customize?.control(controlId, function (control) {
						if (!control || !control.container) return;
						control.container.toggle(!!shouldShow);
					});
				} catch (e) {
					// ignore if control doesn't exist yet
				}
			});
		}

		// Bind to changes
		window.wp.customize?.(styleSettingId, function (setting) {
			setting.bind(function (val: string) {
				applyVisibility(val);
			});
		});

		// Initial apply (call even when initial is empty string to hide controls for 'simple')
		const initial = window.wp.customize?.(styleSettingId)?.get();
		applyVisibility(typeof initial !== "undefined" ? initial : "");
	}
}
