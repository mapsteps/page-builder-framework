/**
 * The select type (wpbf-select), on the shared React base. The form is SelectForm.tsx.
 *
 * Besides its setting, the control keeps two values the form shows:
 * - `choicesValue`: the options (params.choices; the typography fields swap a variant select's options with setChoices),
 * - `shownValue`: the chosen value shown; it follows the setting, and the typography fields set a variant select's
 *   shown variant with showValue() without changing its setting (as they did on select2's element).
 * Both work before the form is drawn (it's drawn when its section first opens).
 */
import "./select-control.scss";
import { Value } from "wordpress__customize-browser/Value";
import { WpbfCustomize } from "../../Base/src/interface";
import { createReactControl } from "../../Base/src/react-base";
import SelectForm from "./SelectForm";
import { SelectControlChoices, SelectControlParams, SelectControlValue, WpbfCustomizeSelectControl } from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

const ReactSelectControl = createReactControl<SelectControlValue, SelectControlParams>(SelectForm);

const SelectControl = ReactSelectControl.extend<WpbfCustomizeSelectControl>({
	initialize: function (this: WpbfCustomizeSelectControl, id: string, params: SelectControlParams) {
		const control = this;
		const ValueClass = wp.customize.Value as unknown as new <T>(initial: T) => Value<T>;

		control.choicesValue = new ValueClass<SelectControlChoices>(params.choices ?? []);
		control.shownValue = new ValueClass<SelectControlValue>(params.value);

		ReactSelectControl.prototype.initialize.call(control, id, params);

		// The shown value follows the setting.
		const settings = params.settings as unknown as Record<string, string> | undefined;
		const settingId = settings && "string" === typeof settings.default ? settings.default : id;

		wp.customize(settingId, function (setting) {
			control.shownValue?.set(setting.get());
			setting.bind((to: SelectControlValue) => control.shownValue?.set(to));
		});
	},

	/**
	 * Replace the options (the typography fields do this for the font variants of the chosen font).
	 */
	setChoices: function (this: WpbfCustomizeSelectControl, choices: SelectControlChoices) {
		this.choicesValue?.set(choices);
	},

	/**
	 * Show a value without handing it to the setting.
	 */
	showValue: function (this: WpbfCustomizeSelectControl, value: SelectControlValue) {
		this.shownValue?.set(value);
	},
});

wp.customize.controlConstructor["wpbf-select"] = SelectControl;
