import hooks from "@wordpress/hooks";
import {
	AnyWpbfCustomizeControl,
	WpbfCustomize,
} from "../../Base/src/interface";
import "./typography-control.scss";
import {
	FontProperties,
	FontProperty,
	FontVariantsCollection,
	GoogleFontEntity,
	GoogleFontsCollection,
	LabelValuePair,
	WpbfCustomizeTypographyControlValue,
} from "./interface";
import {
	SelectControlChoices,
	WpbfCustomizeSelectControl,
} from "../../Select/src/interface";

declare var wp: {
	customize: WpbfCustomize;
	hooks: typeof hooks;
};

/**
 * These var declarations are for the global variables that are set in the PHP file.
 * That means, the `undefined` union has to be added to the declaration to be safer.
 */
declare var wpbfFontProperties: FontProperties | undefined;
declare var wpbfTypographyControlIds: string[] | undefined;
declare var wpbfGoogleFonts: GoogleFontsCollection | undefined;
declare var wpbfFontVariantOptions: FontVariantsCollection | undefined;
declare var wpbfFieldsFontVariants:
	| Record<string, Record<string, LabelValuePair[]>>
	| undefined;

wp.customize.bind("ready", function () {
	setupTypographyFields();
});

function setupTypographyFields() {
	if (!Array.isArray(wpbfTypographyControlIds)) return;

	wpbfTypographyControlIds.forEach((id) => {
		if (!wp.customize.control(id)) return;

		wp.customize(id, function (setting) {
			setting.bind(function (value) {
				composeFontProperties(id, undefined, undefined, value);
			});
		});

		composeFontProperties(id, undefined, undefined, undefined);
		listenFontPropertyFieldsChange(id);
	});
}

function listenFontPropertyFieldsChange(typographyControlId: string) {
	if (!Array.isArray(wpbfFontProperties)) return;

	wpbfFontProperties.forEach((property) => {
		const propertyControlId = `${typographyControlId}[${property}]`;
		if (!wp.customize.control(propertyControlId)) return;

		wp.customize(propertyControlId, function (setting) {
			setting.bind(function (value) {
				composeFontProperties(typographyControlId, property, value, undefined);
			});
		});
	});
}

function findGoogleFont(fontFamily: string): GoogleFontEntity | undefined {
	if (!wpbfGoogleFonts) return undefined;
	if (wpbfGoogleFonts.items[fontFamily]) {
		return wpbfGoogleFonts.items[fontFamily];
	}

	return undefined;
}

function variantFoundInChoices(
	variantValue: string,
	variants: SelectControlChoices,
) {
	return variants.some((variant) => variant.id == variantValue);
}

function composeFontProperties(
	id: string,
	triggerPropertyName?: FontProperty,
	triggerPropertyValue?: string,
	value?: WpbfCustomizeTypographyControlValue,
) {
	const control = wp.customize.control(id);
	if (!control || !control.setting) return;

	value = value || control.setting.get();
	if ("undefined" === typeof value) return;
	if ("string" !== typeof value["font-family"]) return;

	if (
		triggerPropertyName === "font-family" ||
		triggerPropertyName === "variant"
	) {
		value[triggerPropertyName] = triggerPropertyValue;
	}

	const variantValue =
		"undefined" === typeof value.variant ? "regular" : value.variant;

	const maybeVariantControl = wp.customize.control(id + "[variant]");

	const variantControl =
		maybeVariantControl && "wpbf-select" === maybeVariantControl.params.type
			? (maybeVariantControl as WpbfCustomizeSelectControl)
			: undefined;

	// Set the font-style value.
	if (-1 !== variantValue.indexOf("i")) {
		value["font-style"] = "italic";
	} else {
		value["font-style"] = "normal";
	}

	// Set the font-weight value.
	value["font-weight"] =
		"regular" === variantValue || "italic" === variantValue
			? 400
			: parseInt(variantValue, 10);

	if (
		variantControl &&
		(triggerPropertyName === undefined || triggerPropertyName === "font-family")
	) {
		const variantChoices = collectVariantChoices(id, value);

		// Hide/show variant options depending on which are available for this font-family.
		if (variantChoices.length > 1 && control.active()) {
			variantControl.activate();
		} else {
			// If there's only 1 variant to choose from, we can hide the control.
			variantControl.deactivate();
		}

		const updatedOptionValue = variantFoundInChoices(
			variantValue,
			variantChoices,
		)
			? variantValue
			: "regular";

		variantControl.$selectbox?.empty();
		variantControl.$selectbox?.append(
			variantChoices.map((choice) => {
				return new Option(choice.text, choice.id, false, false);
			}),
		);
		variantControl.$selectbox?.val(updatedOptionValue);
		variantControl.$selectbox?.trigger("change");
	}

	wp.customize(id).set(value);

	wp.hooks.addAction(
		"wpbf.dynamicControl.initWpbfControl",
		"wpbf",
		function (controlInit: AnyWpbfCustomizeControl) {
			if (variantControl && id + "[variant]" === controlInit.id) {
			}
		},
	);
}

function collectVariantChoices(
	id: string,
	value: WpbfCustomizeTypographyControlValue,
) {
	const fontFamily = value["font-family"];
	if (!fontFamily) return [];

	const googleFont = findGoogleFont(fontFamily);

	const variantChoices: SelectControlChoices = [];

	if (googleFont) {
		if (!wpbfFontVariantOptions) return variantChoices;
		let googleFontVariants = googleFont.variants;

		let i = 0;

		for (; i < wpbfFontVariantOptions.complete.length; ++i) {
			if (
				!googleFontVariants.includes(wpbfFontVariantOptions.complete[i].value)
			) {
				continue;
			}

			variantChoices.push({
				text: wpbfFontVariantOptions.complete[i].label,
				id: wpbfFontVariantOptions.complete[i].value,
			});
		}
	} else {
		let fieldVariantKey = id.replace(/]/g, "");
		fieldVariantKey = fieldVariantKey.replace(/\[/g, "_");

		const customVariantsGroup =
			wpbfFieldsFontVariants && wpbfFieldsFontVariants[fieldVariantKey]
				? wpbfFieldsFontVariants[fieldVariantKey]
				: undefined;

		if (customVariantsGroup && "object" === typeof customVariantsGroup) {
			for (const variantFamily in customVariantsGroup) {
				if (!customVariantsGroup.hasOwnProperty(variantFamily)) continue;
				if (value["font-family"] !== variantFamily) continue;

				const variants = customVariantsGroup[variantFamily];
				if (!variants.length) continue;

				let i = 0;

				for (; i < variants.length; ++i) {
					variantChoices.push({
						text: variants[i].label,
						id: variants[i].value,
					});
				}
			}
		} else {
			variantChoices.length = 0;
			if (!wpbfFontVariantOptions) return variantChoices;

			let i = 0;

			for (; i < wpbfFontVariantOptions.standard.length; ++i) {
				variantChoices.push({
					text: wpbfFontVariantOptions.standard[i].label,
					id: wpbfFontVariantOptions.standard[i].value,
				});
			}
		}
	}

	return variantChoices;
}
