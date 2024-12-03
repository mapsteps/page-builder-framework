import { AnyWpbfCustomizeControl } from "../../Base/src/base-interface";
import { WpbfAssocArrayControl } from "./generic-interface";

if (window.wp.customize) {
	setupAssocArrayControl(window.wp.customize);
}

function setupAssocArrayControl(customizer: WpbfCustomize) {
	customizer.controlConstructor["wpbf-assoc-array"] =
		customizer.wpbfDynamicControl.extend<WpbfAssocArrayControl>({
			initWpbfControl: function (
				this: WpbfAssocArrayControl,
				control?: WpbfAssocArrayControl,
			) {
				control = control || this;
				if (!control) return;

				control.setting?.bind((value: Record<string, any>) => {
					control.updateComponentState?.(value);
				});

				// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
				function onRemoved(removedControl: AnyWpbfCustomizeControl) {
					if (control === removedControl) {
						control?.destroy?.();
						control.container?.remove();
						customizer.control.unbind("removed", onRemoved);
					}
				}

				customizer.control.bind("removed", onRemoved);
			},

			updateComponentState: function (
				this: WpbfAssocArrayControl,
				value: Record<string, any>,
			) {
				const fields = this.container[0].querySelectorAll(
					".wpbf-control-form input[data-setting-prop]",
				);
				if (!fields.length) return;

				fields.forEach((field) => {
					if (!(field instanceof HTMLInputElement)) return;
					const prop = field.dataset.settingProp;
					if (!prop || !value[prop]) return;
					field.value = value[prop];
				});
			},

			ready: function () {
				if (!this.container) return;

				this.currentValue = this.setting?.get();

				const fields = this.container[0].querySelectorAll(
					"input[data-setting-prop]",
				);

				fields.forEach((field) => {
					if (!(field instanceof HTMLInputElement)) return;

					field.addEventListener("change", (e) => {
						const values: Record<string, any> = {};

						fields.forEach((field) => {
							if (!(field instanceof HTMLInputElement)) return;
							const prop = field.dataset.settingProp;
							if (!prop) return;
							values[prop] = field.value;
						});

						this.setting?.set(values);
					});
				});

				const control = this;

				this.setting?.bind((val) => {
					control.updateComponentState?.(val);
				});
			},

			destroy: function () {},
		});
}
