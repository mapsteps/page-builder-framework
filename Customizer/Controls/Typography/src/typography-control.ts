import hooks from "@wordpress/hooks";
import { WpbfCustomize } from "../../Base/src/interface";
import "./typography-control.scss";
import {
	FontProperties,
	FontVariantsCollection,
	GoogleFontEntity,
	GoogleFontsCollection,
	LabelValuePair,
	WpbfCustomizeTypographyControlValue,
} from "./interface";
import {
	SelectChoices,
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
	| Record<string, LabelValuePair[]>
	| undefined;

wp.customize.bind("ready", function () {
	setupTypographyFields();
});

function setupTypographyFields() {
	if (!Array.isArray(wpbfTypographyControlIds)) return;

	wpbfTypographyControlIds.forEach((id) => {
		if (!wp.customize.control(id)) return;
		composeFontProperties(id);
		listenFontPropertyFieldsChange(id);

		wp.customize(id, function (setting) {
			setting.bind(function (value) {
				composeFontProperties(id, value);
			});
		});
	});
}

function listenFontPropertyFieldsChange(typographyControlId: string) {
	if (!Array.isArray(wpbfFontProperties)) return;

	wpbfFontProperties.forEach((property) => {
		// Only listen to changes on the `font-family` and `variant` properties.
		if ("font-family" !== property && "variant" !== property) return;
		const propertyControlId = `${typographyControlId}[${property}]`;
		if (!wp.customize.control(propertyControlId)) return;

		wp.customize(propertyControlId, function (setting) {
			setting.bind(function (newval) {
				const typographyValue = wp.customize(typographyControlId).get() || {};
				typographyValue[property] = newval;

				// Unfortunately, this doesn't trigger change event to the control with typographyControlId.
				wp.customize
					.control(typographyControlId)
					?.setting?.set(typographyValue);

				console.log(
					`"${property}" new value is: ${newval}, and "${typographyControlId}" new value is:`,
					wp.customize(typographyControlId).get(),
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

function variantFoundInChoices(variantValue: string, variants: SelectChoices) {
	return variants.some((variant) => variant.v === variantValue);
}

function composeFontProperties(
	id: string,
	value?: WpbfCustomizeTypographyControlValue,
) {
	const control = wp.customize.control(id);
	if (!control || !control.setting) return;

	value = value || control.setting.get();

	if ("undefined" === typeof value) return;
	if ("string" !== typeof value["font-family"]) return;

	const variantValue =
		"undefined" === typeof value.variant ? "regular" : value.variant;

	const maybeVariantControl = wp.customize.control(id + "[variant]");

	const variantControl =
		maybeVariantControl && "wpbf-select" === maybeVariantControl.params.type
			? (maybeVariantControl as WpbfCustomizeSelectControl)
			: undefined;

	const googleFont = findGoogleFont(value["font-family"]);

	const variantChoices: SelectChoices = [];

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
				l: wpbfFontVariantOptions.complete[i].label,
				v: wpbfFontVariantOptions.complete[i].value,
			});
		}
	} else {
		let fieldVariantKey = id.replace(/]/g, "");
		fieldVariantKey = fieldVariantKey.replace(/\[/g, "_");

		const fieldVariants =
			wpbfFieldsFontVariants && wpbfFieldsFontVariants[fieldVariantKey]
				? wpbfFieldsFontVariants[fieldVariantKey]
				: undefined;

		if (fieldVariants && fieldVariants.length) {
			let i = 0;

			for (; i < fieldVariants.length; ++i) {
				variantChoices.push({
					l: fieldVariants[i].label,
					v: fieldVariants[i].value,
				});
			}
		} else {
			variantChoices.length = 0;
			if (!wpbfFontVariantOptions) return variantChoices;

			let i = 0;

			for (; i < wpbfFontVariantOptions.standard.length; ++i) {
				variantChoices.push({
					l: wpbfFontVariantOptions.standard[i].label,
					v: wpbfFontVariantOptions.standard[i].value,
				});
			}
		}
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
			: parseInt(variantValue, 10);

	if (variantControl) {
		// Hide/show variant options depending on which are available for this font-family.
		if (variantChoices.length > 1 && control.active()) {
			variantControl.activate();
		} else {
			// If there's only 1 variant to choose from, we can hide the control.
			variantControl.deactivate();
		}

		variantControl.parseSelectChoices?.(variantChoices);
		variantControl.destroy?.();

		if (variantFoundInChoices(variantValue, variantChoices)) {
			variantControl.doSelectAction?.("selectOption", variantValue);
		} else {
			// If the selected font-family doesn't support the currently selected variant, switch to "regular".
			variantControl.doSelectAction?.("selectOption", "regular");
		}
	}

	wp.customize(id).set(value);

	wp.hooks.addAction(
		"wpbf.dynamicControl.initKirkiControl",
		"wpbf",
		function (controlInit) {
			if (variantControl && id + "[variant]" === controlInit.id) {
			}
		},
	);
}
