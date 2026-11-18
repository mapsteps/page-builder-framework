/**
 * Shared base for the Customizer controls that render with React.
 *
 * A control family only writes its form component; this file gives it the wp.customize control around it:
 * rendering into the control's container when its section first opens, the notifications area, following the
 * setting and the previewed device, clean-up on removal.
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
import { createRoot, flushSync, useCallback, useEffect, useRef, useState } from "@wordpress/element";
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
 * The form renders when the control's section is first opened (or right away in an always-open section, or when the
 * control is focused), like the controls built on the old dynamic control: a closed section costs nothing.
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
		 * Place the control in its section like core does, but wait with rendering until the section is open
		 * (core renders every control on load).
		 */
		embed: function (this: ReactControl<SV, CP>) {
			const control = this;
			const sectionId = control.section();

			if (!sectionId) return;

			wp.customize.section(sectionId, function (section) {
				section.deferred.embedded.done(function () {
					// The type definition has contentContainer as a string; it's a jQuery object.
					const content = section.contentContainer as unknown as JQuery;
					const parent = content.is("ul") ? content : content.find("ul:first");

					if (!control.container.parent().is(parent)) {
						parent.append(control.container);
					}

					if (
						"wpbf-expanded" === section.params.type ||
						section.expanded() ||
						wp.customize.settings.autofocus.control === control.id
					) {
						control.actuallyEmbed?.();
						return;
					}

					section.expanded.bind(function (expanded) {
						if (expanded) control.actuallyEmbed?.();
					});
				});
			});
		},

		/**
		 * Render the form and resolve `embedded` (which runs core's ready steps), once.
		 */
		actuallyEmbed: function (this: ReactControl<SV, CP>) {
			const control = this;

			if ("resolved" === control.deferred.embedded.state()) return;

			control.renderContent();
			control.deferred.embedded.resolve();
		},

		/**
		 * Focusing a control (e.g. from a link or autofocus) renders it first.
		 */
		focus: function (this: ReactControl<SV, CP>, args?: Record<string, any>) {
			this.actuallyEmbed?.();
			wp.customize.Control.prototype.focus.call(this, args);
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
		 * Render the form into the control's container.
		 *
		 * Synchronously, so the markup is there for whatever runs next on the section opening (e.g. the tooltips).
		 */
		renderContent: function (this: ReactControl<SV, CP>) {
			const control = this;

			if (!control.root && control.container) {
				control.root = createRoot(control.container[0]);
			}

			flushSync(() => {
				control.root?.render(<Form control={control} />);
			});

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
 * The device the preview shows, as React state; one of `devices`.
 *
 * Responsive controls open on the device the preview shows and switch along with it (the Customizer's own device
 * buttons, another control's device buttons). A device the control doesn't have falls back to its first device.
 *
 * @param devices The control's devices.
 * @return The active device.
 */
export function usePreviewedDevice(devices: string[]): string {
	const [device, setDevice] = useState<string>(() => wp.customize.previewedDevice.get());

	useEffect(() => {
		const follow = (to: string) => setDevice(to);

		wp.customize.previewedDevice.bind(follow);

		return () => {
			wp.customize.previewedDevice.unbind(follow);
		};
	}, []);

	return devices.includes(device) ? device : (devices[0] ?? "");
}

/**
 * Show the preview on a device (switches every responsive control along with it).
 */
export function previewDevice(device: string) {
	wp.customize.previewedDevice.set(device);
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

/**
 * The attributes of an attribute string as PHP prints them (`name="value" …`, values HTML-escaped), decoded.
 *
 * @param attrs The attribute string (e.g. the control's `inputAttrs`).
 * @return [name, value] pairs; the first of duplicate names, as the browser takes it.
 */
export function parseAttrs(attrs: string | undefined): [string, string][] {
	if (!attrs || !attrs.trim()) return [];

	const template = document.createElement("template");
	template.innerHTML = `<input ${attrs}>`;

	const input = template.content.firstElementChild;

	return input ? Array.from(input.attributes).map((attr) => [attr.name, attr.value]) : [];
}

/**
 * A ref that puts extra attributes (e.g. the field's `input_attrs`) on an element, exactly as given.
 *
 * Written onto the element rather than through React, so any attribute works the way it did in the old templates
 * (`style` as text, `data-*`, `aria-*` …). Names in `skip` are left out: the old template printed its own before
 * the extra attributes, and the browser keeps the first of duplicate attributes.
 *
 * @param attrs The attribute string.
 * @param skip Attribute names the form sets itself and that win.
 * @return A ref callback.
 */
export function useExtraAttrs(attrs: string | undefined, skip: string[] = []) {
	return useCallback(
		(el: HTMLElement | null) => {
			if (!el) return;

			for (const [name, value] of parseAttrs(attrs)) {
				if (!skip.includes(name)) el.setAttribute(name, value);
			}
		},
		// eslint-disable-next-line react-hooks/exhaustive-deps
		[attrs, skip.join(" ")],
	);
}

/**
 * Whether a value was given ("" and undefined are "not set").
 */
export function isSet(value: unknown): boolean {
	return "undefined" !== typeof value && "" !== value;
}
