import { WpbfCustomize } from "../../Base/src/interface";
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
	SelectControlChoice,
	WpbfCustomizeSelectControl,
} from "../../Select/src/interface";
import { WpbfCustomizeAssocArrayControl } from "../../Generic/src/interface";
import { isNumeric } from "../../Generic/src/number-util";

import "./typography-control.scss";

declare var wp: {
	customize: WpbfCustomize;
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

wp.customize?.bind("ready", function () {
	if (!wp.customize) return;

	setupTypographyFields(wp.customize);
});

function setupTypographyFields(customizer: WpbfCustomize) {
	if (!Array.isArray(wpbfTypographyControlIds)) return;

	wpbfTypographyControlIds.forEach((id) => {
		if (!customizer.control(id)) return;

		customizer(id, function (setting) {
			composeFontProperties(id, undefined, undefined, undefined, true);

			setting.bind(function (value) {
				composeFontProperties(id, value, undefined, undefined);
			});

			listenFontPropertyFieldsChange(id);
		});
	});
}

function listenFontPropertyFieldsChange(typographyControlId: string) {
	if (!Array.isArray(wpbfFontProperties)) return;

	wpbfFontProperties.forEach((property) => {
		const propertyControlId = `${typographyControlId}[${property}]`;
		if (!wp.customize.control(propertyControlId)) return;

		wp.customize(propertyControlId, function (setting) {
			setting.bind(function (value) {
				composeFontProperties(
					typographyControlId,
					undefined,
					property,
					value,
				);
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
	variants: SelectControlChoice[],
) {
	return variants.some((variant) => variant.id == variantValue);
}

/**
 * Whether two typography values are the same apart from numbers saved as text ("400" and 400) and key order.
 */
function sameValue(
	a: WpbfCustomizeTypographyControlValue,
	b: WpbfCustomizeTypographyControlValue | undefined,
) {
	if (!b || "object" !== typeof b) return false;

	const keys = new Set([...Object.keys(a), ...Object.keys(b)]);
	const text = (v: unknown) => (null === v || undefined === v ? v : String(v));

	return [...keys].every(
		(key) =>
			text((a as Record<string, unknown>)[key]) ===
			text((b as Record<string, unknown>)[key]),
	);
}

/**
 * Compose the typography value from its font family and variant (font style and weight follow the variant) and show
 * the variants of the chosen font in the variant select.
 *
 * @param onLoad When the Customizer opens: the value is only written when it really changes (a font weight saved as
 *               "400" stays as it is), so opening the Customizer doesn't leave unsaved changes.
 */
function composeFontProperties(
	id: string,
	val?: WpbfCustomizeTypographyControlValue,
	triggerPropertyName?: FontProperty,
	triggerPropertyValue?: string,
	onLoad?: boolean,
) {
	const control: WpbfCustomizeAssocArrayControl | undefined =
		wp.customize?.control(id);
	if (!control || !control.setting) return;

	val = val || control.setting.get();

	const value = { ...val };

	if ("font-backup" in value) delete value["font-backup"];

	if ("undefined" === typeof value) return;
	if ("string" !== typeof value["font-family"]) return;

	if (
		triggerPropertyName === "font-family" ||
		triggerPropertyName === "variant"
	) {
		value[triggerPropertyName] = triggerPropertyValue;
	}

	let variantValue = !value.variant ? "regular" : value.variant;
	value.variant = variantValue;

	const maybeVariantControl = wp.customize.control(id + "[variant]");

	const variantControl =
		maybeVariantControl && "wpbf-select" === maybeVariantControl.params.type
			? (maybeVariantControl as WpbfCustomizeSelectControl)
			: undefined;

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

		// Update the `variantValue` with the updated option value.
		variantValue = updatedOptionValue;

		// The variant select lists this font's variants and shows the variant, without changing its own setting.
		variantControl.setChoices?.(variantChoices);
		variantControl.showValue?.(variantValue);
		value["variant"] = variantValue;
	}

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
			: isNumeric(variantValue)
				? parseInt(variantValue, 10)
				: 400;

	if (onLoad && sameValue(value, control.setting.get())) return;

	control.setting.set(value);
}

function collectVariantChoices(
	id: string,
	value: WpbfCustomizeTypographyControlValue,
) {
	const fontFamily = value["font-family"];
	if (!fontFamily) return [];

	const googleFont = findGoogleFont(fontFamily);

	const variantChoices: SelectControlChoice[] = [];

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
