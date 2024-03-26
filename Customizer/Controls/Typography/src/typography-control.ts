import _ from "lodash";
import { WpbfCustomize } from "../../Base/src/interface";
import "./typography-control.scss";
import {
	FontVariantsCollection,
	GoogleFontEntity,
	GoogleFontsCollection,
	ValueLabelPair,
	WpbfCustomizeTypographyControlValue,
} from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

declare var wpbfTypographyControlIds: string[];
declare var wpbfGoogleFonts: GoogleFontsCollection;
declare var wpbfFontVariants: FontVariantsCollection;
declare var wpbfFieldsFontVariants: Record<string, ValueLabelPair[]>;

wp.customize.bind("ready", function () {
	_.each(wpbfTypographyControlIds, function (id) {
		compositeControlFontProperties(id);

		wp.customize(id, function (value) {
			value.bind(function (newval) {
				compositeControlFontProperties(id, newval);
			});
		});
	});
});

function findGoogleFont(fontFamily: string): GoogleFontEntity | undefined {
	return wpbfGoogleFonts.items.find((font) => font.family === fontFamily);
}

function sortVariants(a: string | number, b: string | number): number {
	if (a < b) return -1;
	if (a > b) return 1;

	return 0;
}

function compositeControlFontProperties(
	id: string,
	value?: WpbfCustomizeTypographyControlValue,
) {
	const control = wp.customize.control(id);
	if ("undefined" === typeof control) return;

	value = value || control.setting.get();
	if ("undefined" === typeof value) return;
	if ("string" !== typeof value["font-family"]) return;

	const googleFont = findGoogleFont(value["font-family"]);

	const variantValue =
		"undefined" === typeof value.variant ? "regular" : value.variant;

	const variantControl = wp.customize.control(id + "[variant]");

	let variants = [];

	if (googleFont) {
		let googleFontVariants = googleFont.variants;
		googleFontVariants.sort(sortVariants);

		wpbfFontVariants.complete.forEach(function (variant) {
			if (googleFontVariants.includes(variant.value)) {
				variants.push({
					value: variant.value,
					label: variant.label,
				});
			}
		});
	} else {
		let fieldVariantKey = id.replace(/]/g, "");
		fieldVariantKey = fieldVariantKey.replace(/\[/g, "_");

		const fieldVariants = wpbfFieldsFontVariants.hasOwnProperty(fieldVariantKey)
			? wpbfFieldsFontVariants[fieldVariantKey]
			: undefined;

		if (fieldVariants) {
			if (fieldVariants.value["font-family"]]) {
				variants = kirkiCustomVariants[fieldVariantKey][value["font-family"]];
			} else {
				variants = kirkiFontVariants.standard;
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
		if (1 < variants.length && control.active()) {
			variantControl.activate();
		} else {
			// If there's only 1 variant to choose from, we can hide the control.
			variantControl.deactivate();
		}

		variantControl.params.choices = variants;
		variantControl.formattedOptions = [];
		variantControl.destroy();

		if (!variants.includes(variantValue)) {
			// If the selected font-family doesn't support the currently selected variant, switch to "regular".
			variantControl.doSelectAction("selectOption", "regular");
		} else {
			variantControl.doSelectAction("selectOption", variantValue);
		}
	}

	wp.hooks.addAction(
		"kirki.dynamicControl.initKirkiControl",
		"kirki",
		function (controlInit) {
			if (variantControl && id + "[variant]" === controlInit.id) {
			}
		},
	);
}
