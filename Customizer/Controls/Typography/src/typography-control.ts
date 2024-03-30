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
import { WpbfCustomizeSelectControl } from "../../Select/src/interface";

declare var wp: {
	customize: WpbfCustomize;
	hooks: typeof hooks;
};

declare var wpbfFontProperties: FontProperties;
declare var wpbfTypographyControlIds: string[];
declare var wpbfGoogleFonts: GoogleFontsCollection;
declare var wpbfFontVariants: FontVariantsCollection;
declare var wpbfFieldsFontVariants: Record<string, LabelValuePair[]>;

wp.customize.bind("ready", function () {
	setupTypographyFields();
});

function setupTypographyFields() {
	if (!wpbfTypographyControlIds || !wpbfTypographyControlIds.length) {
		return;
	}

	wpbfTypographyControlIds.forEach((id) => {
		if (!wp.customize.control(id)) return;
		composeFontProperties(id);
		listenFontPropertyFieldsChange(id);
	});
}

function listenFontPropertyFieldsChange(typographyControlId: string) {
	if (!wpbfFontProperties || !wpbfFontProperties.length) return;

	wpbfFontProperties.forEach((property) => {
		const propertyControlId = `${typographyControlId}[${property}]`;
		if (!wp.customize.control(propertyControlId)) return;

		wp.customize(propertyControlId, function (setting) {
			setting.bind(function (newval) {
				const typographyValue = wp.customize(typographyControlId).get() || {};
				typographyValue[property] = newval;

				composeFontProperties(typographyControlId, typographyValue);
			});
		});
	});
}

function findGoogleFont(fontFamily: string): GoogleFontEntity | undefined {
	if (
		wpbfGoogleFonts.items.hasOwnProperty(fontFamily) &&
		wpbfGoogleFonts.items[fontFamily]
	) {
		return wpbfGoogleFonts.items[fontFamily];
	}

	return undefined;
}

function sortVariants(a: string | number, b: string | number): number {
	if (a < b) return -1;
	if (a > b) return 1;

	return 0;
}

function composeFontProperties(
	id: string,
	value?: WpbfCustomizeTypographyControlValue,
) {
	const control = wp.customize.control(id);
	if ("undefined" === typeof control) return;

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

	let variants: Record<string, string> = {};

	if (googleFont) {
		let googleFontVariants = googleFont.variants;
		googleFontVariants.sort(sortVariants);

		for (const variantValue in wpbfFontVariants.complete) {
			if (
				!wpbfFontVariants.complete.hasOwnProperty(variantValue) ||
				!wpbfFontVariants.complete[variantValue]
			) {
				continue;
			}

			variants[variantValue] = wpbfFontVariants.complete[variantValue];
		}
	} else {
		let fieldVariantKey = id.replace(/]/g, "");
		fieldVariantKey = fieldVariantKey.replace(/\[/g, "_");

		const fieldVariants = wpbfFieldsFontVariants.hasOwnProperty(fieldVariantKey)
			? wpbfFieldsFontVariants[fieldVariantKey]
			: undefined;

		if (fieldVariants && fieldVariants.length) {
			fieldVariants.forEach((fieldVariant) => {
				variants[fieldVariant.value] = fieldVariant.label;
			});
		} else {
			variants = wpbfFontVariants.standard;
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
		if (1 < Object.keys(variants).length && control.active()) {
			variantControl.activate();
		} else {
			// If there's only 1 variant to choose from, we can hide the control.
			variantControl.deactivate();
		}

		variantControl.params.choices = variants;
		variantControl.formattedOptions = [];
		variantControl.destroy?.();

		if (variants.hasOwnProperty(variantValue) && variants[variantValue]) {
			variantControl.doSelectAction?.("selectOption", variantValue);
		} else {
			// If the selected font-family doesn't support the currently selected variant, switch to "regular".
			variantControl.doSelectAction?.("selectOption", "regular");
		}
	}

	wp.customize(id).set(value);

	console.log(
		"Done composing font properties. Now the typography value is:",
		value,
	);

	wp.hooks.addAction(
		"wpbf.dynamicControl.initKirkiControl",
		"wpbf",
		function (controlInit) {
			if (variantControl && id + "[variant]" === controlInit.id) {
			}
		},
	);
}
