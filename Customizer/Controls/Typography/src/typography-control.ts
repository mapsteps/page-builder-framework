import hooks from "@wordpress/hooks";
import { WpbfCustomize } from "../../Base/src/interface";
import "./typography-control.scss";
import {
	FontVariantsCollection,
	GoogleFontEntity,
	GoogleFontsCollection,
	LabelValuePair,
	WpbfCustomizeTypographyControlValue,
} from "./interface";

declare var wp: {
	customize: WpbfCustomize;
	hooks: typeof hooks;
};

declare var wpbfTypographyControlIds: string[];
declare var wpbfGoogleFonts: GoogleFontsCollection;
declare var wpbfFontVariants: FontVariantsCollection;
declare var wpbfFieldsFontVariants: Record<string, LabelValuePair[]>;

wp.customize.bind("ready", function () {
	if (!wpbfTypographyControlIds || !wpbfTypographyControlIds.length) {
		return;
	}

	wpbfTypographyControlIds.forEach((id) => {
		compositeControlFontProperties(id);

		wp.customize(id, function (setting) {
			console.log(`"${id}" control initial value is: `, setting.get());

			setting.bind(function (newval) {
				console.log(`"${id}" control updated value is: `, newval);

				compositeControlFontProperties(id, newval);
			});
		});
	});
});

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

function compositeControlFontProperties(
	id: string,
	value?: WpbfCustomizeTypographyControlValue,
) {
	const control = wp.customize.control(id);
	if ("undefined" === typeof control) return;

	value = value || control.setting.get();

	console.log("value from compositeControlFontProperties", value);

	if ("undefined" === typeof value) return;
	if ("string" !== typeof value["font-family"]) return;

	const googleFont = findGoogleFont(value["font-family"]);

	const variantValue =
		"undefined" === typeof value.variant ? "regular" : value.variant;

	const variantControl = wp.customize.control(id + "[variant]");

	let variantChoices: Record<string, string> = {};

	if (googleFont) {
		let googleFontVariants = googleFont.variants;
		googleFontVariants.sort(sortVariants);

		for (const variant in wpbfFontVariants.complete) {
			if (!wpbfFontVariants.complete.hasOwnProperty(variant)) {
				continue;
			}

			if (googleFontVariants.includes(variant)) {
				variantChoices[variant] = wpbfFontVariants.complete[variant];
			}
		}
	} else {
		let fieldVariantKey = id.replace(/]/g, "");
		fieldVariantKey = fieldVariantKey.replace(/\[/g, "_");

		const fieldVariants = wpbfFieldsFontVariants.hasOwnProperty(fieldVariantKey)
			? wpbfFieldsFontVariants[fieldVariantKey]
			: undefined;

		if (fieldVariants && fieldVariants.length) {
			fieldVariants.forEach((fieldVariant) => {
				variantChoices[fieldVariant.value] = fieldVariant.label;
			});
		} else {
			variantChoices = wpbfFontVariants.standard;
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
		if (1 < Object.keys(variantChoices).length && control.active()) {
			variantControl.activate();
		} else {
			// If there's only 1 variant to choose from, we can hide the control.
			variantControl.deactivate();
		}

		variantControl.params.choices = variantChoices;
		variantControl.ungroupedOptions = [];
		variantControl.groupedOptions = [];
		variantControl.destroy?.();

		if (variantChoices[variantValue]) {
			variantControl.doSelectAction?.("selectOption", variantValue);
		} else {
			// If the selected font-family doesn't support the currently selected variant, switch to "regular".
			variantControl.doSelectAction?.("selectOption", "regular");
		}
	}

	wp.hooks.addAction(
		"wpbf.dynamicControl.initKirkiControl",
		"wpbf",
		function (controlInit) {
			if (variantControl && id + "[variant]" === controlInit.id) {
			}
		},
	);
}
