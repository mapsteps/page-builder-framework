import hooks from "@wordpress/hooks";
import { MarginPaddingValue } from "./interface";

declare var wp: {
	hooks: typeof hooks;
};

(() => {
	/**
	 * Function to hook into `wpbfPostMessageStylesOutput` filter.
	 *
	 * @param {string} styles - The styles to be filtered.
	 * @param {MarginPaddingValue|string|number} values - The control's value.
	 * @param {Object} output - The control's output argument.
	 * @param {string} controlType - The control type.
	 *
	 * @return {string} The filtered styles.
	 */
	const stylesOutput = (
		styles: string,
		values: MarginPaddingValue | string | number,
		output: { element: string },
		controlType: string,
	): string => {
		if ("wpbf-margin-padding" !== controlType) {
			return styles;
		}

		if ("string" === typeof values || "number" === typeof values) {
			return styles;
		}

		if (!values.top && !values.right && !values.bottom && !values.left) {
			return styles;
		}

		const property = controlType.replace("wpbf-", "");

		styles += output.element + "{";

		for (const position in values) {
			if (Object.hasOwnProperty.call(values, position)) {
				const value = values[position];

				if ("" !== value) {
					styles += property + "-" + position + ": " + value + ";";
				}
			}
		}

		styles += "}";

		return styles;
	};

	// Hook the function to the `wpbfPostMessageStylesOutput` filter.
	wp.hooks.addFilter("wpbfPostMessageStylesOutput", "wpbf", stylesOutput);
})();
