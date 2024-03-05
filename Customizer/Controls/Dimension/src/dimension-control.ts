import "./dimension-control.scss";
import { WpbfCustomize, WpbfCustomizeSetting } from "../../Base/src/interfaces";
import { WpbfCustomizeDimensionControl } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

declare var wpbfDimensionControlL10n: Record<string, string>;

wp.customize.controlConstructor["wpbf-dimension"] =
	wp.customize.wpbfDynamicControl.extend({
		initWpbfControl: function (control: WpbfCustomizeDimensionControl) {
			let value;
			control = control || this;

			// Notifications.
			control.wpbfNotifications();

			// Save the value
			control.container.on("change keyup paste", "input", function () {
				value = jQuery(this).val();
				control.setting.set(value);
			});
		},

		/**
		 * Handles notifications.
		 */
		wpbfNotifications: function () {
			let control = this;

			const allowUnitless = control.params.allowUnitless;

			wp.customize(control.id, function (setting) {
				setting.bind(function (value) {
					const code = "long_title";

					if (
						!control.validateCssValue(value) &&
						(!allowUnitless || isNaN(value))
					) {
						(setting as WpbfCustomizeSetting<any>).notifications.add(
							code,
							new wp.customize.Notification(code, {
								type: "warning",
								message: wpbfDimensionControlL10n["invalid-value"],
							}),
						);
					} else {
						(setting as WpbfCustomizeSetting<any>).notifications.remove(code);
					}
				});
			});
		},

		validateCssValue: function (value: string | number) {
			const control = this;
			const validUnits = [
				"fr",
				"rem",
				"em",
				"ex",
				"%",
				"px",
				"cm",
				"mm",
				"in",
				"pt",
				"pc",
				"ch",
				"vh",
				"vw",
				"vmin",
				"vmax",
			];

			// Whitelist values.
			if (
				!value ||
				"" === value ||
				0 === value ||
				"0" === value ||
				"auto" === value ||
				"inherit" === value ||
				"initial" === value
			) {
				return true;
			}

			const valueStr = typeof value === "string" ? value : value.toString();

			// Skip checking if calc().
			if (0 <= valueStr.indexOf("calc(") && 0 <= valueStr.indexOf(")")) {
				return true;
			}

			const numericValue = parseFloat(valueStr);

			const unit = valueStr.replace(numericValue.toString(), "");

			// Allow unitless.
			if (!unit) {
				return true;
			}

			// Check for multiple values.
			const multiples = valueStr.split(" ");
			let multiplesValid = true;

			if (2 <= multiples.length) {
				multiples.forEach(function (item) {
					if (item && !control.validateCssValue(item)) {
						multiplesValid = false;
					}
				});

				return multiplesValid;
			}

			// Check the validity of the numeric value and units.
			return !isNaN(numericValue) && -1 !== validUnits.indexOf(unit);
		},
	});