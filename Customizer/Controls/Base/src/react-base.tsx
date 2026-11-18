/**
 * Shared base for the Customizer controls that render with React.
 *
 * A control family only writes its form component; this file gives it the wp.customize control around it:
 * mounting into the control's container, the notifications area, following the setting, clean-up on removal.
 * React comes from WordPress (`wp.element`, plus its JSX runtime), never bundled.
 *
 *     wp.customize.controlConstructor["wpbf-example"] = createReactControl(ExampleForm);
 *
 *     function ExampleForm({ control }: ReactControlFormProps<string>) {
 *         const [value, setValue] = useSettingValue(control, control.params.value);
 *         ...
 *     }
 */
import type { ComponentType } from "react";
import { createRoot, useEffect, useRef, useState } from "@wordpress/element";
import {
	AnyWpbfCustomizeControl,
	WpbfCustomize,
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
} from "./interface";

declare var wp: {
	customize: WpbfCustomize;
};

export type ReactControl<SV, CP = WpbfCustomizeControlParams<SV>> = WpbfCustomizeControl<SV, CP>;

export type ReactControlFormProps<SV, CP = WpbfCustomizeControlParams<SV>> = {
	control: ReactControl<SV, CP>;
};

/**
 * Make a wp.customize control class that renders `Form` with React.
 *
 * @param Form The control's form. Gets the control; reads its params and setting from there.
 * @return The control class, for `wp.customize.controlConstructor[type]`.
 */
export function createReactControl<SV, CP = WpbfCustomizeControlParams<SV>>(
	Form: ComponentType<ReactControlFormProps<SV, CP>>,
): ReactControl<SV, CP> {
	return wp.customize.Control.extend<ReactControl<SV, CP>>({
		initialize: function (this: ReactControl<SV, CP>, id: string, params: CP) {
			const control = this;

			// Passed to React as a ref callback, so it needs its control.
			control.setNotificationContainer = control.setNotificationContainer?.bind(control);

			wp.customize.Control.prototype.initialize.call(control, id, params);

			// Unmount when the control is removed (core doesn't call destroy(), see https://core.trac.wordpress.org/ticket/31334).
			function onRemoved(removedControl: AnyWpbfCustomizeControl) {
				if (control !== removedControl) return;
				control.destroy?.();
				control.container.remove();
				wp.customize.control.unbind("removed", onRemoved);
			}

			wp.customize.control.bind("removed", onRemoved);
		},

		/**
		 * Show the control's notifications (e.g. validation errors) in the given element.
		 */
		setNotificationContainer: function (this: ReactControl<SV, CP>, el: HTMLElement | null) {
			if (!el) return;

			this.notifications.container = jQuery(el);
			this.notifications.render();
		},

		/**
		 * Render the form into the control's container (called by core when the control is embedded).
		 */
		renderContent: function (this: ReactControl<SV, CP>) {
			const control = this;

			if (!control.root && control.container) {
				control.root = createRoot(control.container[0]);
			}

			control.root?.render(<Form control={control} />);

			if ((control.params as WpbfCustomizeControlParams<SV>).allowCollapse) {
				control.container.addClass("allowCollapse");
			}
		},

		/**
		 * The form follows the setting itself (useSettingValue), nothing to do here.
		 */
		ready: function () {},

		destroy: function (this: ReactControl<SV, CP>) {
			this.root?.unmount();
			this.root = undefined;

			wp.customize.Control.prototype.destroy?.call(this);
		},
	});
}

/**
 * Where the control shows its notifications (e.g. a value the server rejected).
 */
export function Notifications({ control }: { control: ReactControl<any, any> }) {
	// setNotificationContainer is bound to the control and accepts the null React passes on unmount.
	const ref = control.setNotificationContainer as unknown as (el: HTMLDivElement | null) => void;

	return <div className="customize-control-notifications-container" ref={ref}></div>;
}

/**
 * The control's setting value as React state, kept in step with the setting.
 *
 * Changes from anywhere (this form, another control, a reset, a restored draft) re-render the form.
 *
 * @param control The control.
 * @param initial The value to show first (usually `control.params.value`, the value as PHP prepared it).
 * @return [value, setValue]
 */
export function useSettingValue<SV>(control: ReactControl<SV, any>, initial: SV): [SV, (value: SV) => void] {
	const [value, setState] = useState<SV>(initial);

	useEffect(() => {
		const setting = control.setting;
		if (!setting) return;

		const follow = (to: SV) => setState(to);

		setting.bind(follow);

		return () => {
			setting.unbind(follow);
		};
	}, [control]);

	return [value, (to: SV) => control.setting?.set(to)];
}

/**
 * Text someone is typing into a field, kept until the value changes for another reason.
 *
 * A field that shows the value cleaned up (limited to min/max, unit kept) would fight the typing: "1" becomes the
 * minimum before "15" is complete. So the field shows what was typed as long as the value is still the one the typing
 * produced; any other change (slider, reset, another control) shows the value again. Leaving the field does too.
 *
 * @return [textFor(key, value), remember(key, text, value), forget()]
 */
export function useTypedText(): [
	(key: string, value: unknown) => string | undefined,
	(key: string, text: string, value: unknown) => void,
	() => void,
] {
	const typed = useRef<Record<string, { text: string; value: unknown }>>({});
	const [, rerender] = useState(0);

	const textFor = (key: string, value: unknown) => {
		const entry = typed.current[key];
		return entry && entry.value === value ? entry.text : undefined;
	};

	const remember = (key: string, text: string, value: unknown) => {
		typed.current[key] = { text, value };
		rerender((n) => n + 1);
	};

	const forget = () => {
		typed.current = {};
		rerender((n) => n + 1);
	};

	return [textFor, remember, forget];
}
