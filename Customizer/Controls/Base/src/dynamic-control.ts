import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
	WpbfCustomizeElement,
} from "./base-interface";
import jQuery from "jquery";
import _ from "lodash";

/**
 * Content of this file was taken from Kirki.
 *
 * The majority of the code in this file
 * is derived from the wp-customize-posts plugin
 * and the work of @westonruter to whom I am very grateful.
 *
 * @see https://github.com/xwp/wp-customize-posts
 */
export default function setupDynamicControl(customizer: WpbfCustomize) {
	customizer.wpbfDynamicControl = customizer.Control.extend<
		WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>
	>({
		initialize: function (
			this: WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>,
			id: string,
			params: WpbfCustomizeControlParams<any>,
		) {
			const control = this;

			if (!params.type) {
				params.type = "wpbf-generic";
			}

			let className = "";

			if (params.content) {
				let splits = params.content.split('class="');
				splits = splits[1].split('"');
				className = splits[0];
			} else {
				className = "customize-control customize-control-" + params.type;
			}

			if (params.content) {
				const $content = jQuery(params.content);
				$content.attr(
					"id",
					"customize-control-" + id.replace(/]/g, "").replace(/\[/g, "-"),
				);
				$content.attr("class", className);

				const wrapperAttrs = params["wrapperAttrs"] ?? {};

				_.each(wrapperAttrs, function (val: any, key: string) {
					if ("class" === key) {
						val = val.replace("{default_class}", className);
					}

					$content.attr(key, val);
				});

				// Hijack the container to add wrapperAttrs.
				params.content = $content.prop("outerHTML");
			}

			control.propertyElements = [];
			customizer.Control.prototype.initialize.call(control, id, params);
			window.wp.hooks.doAction(
				"wpbf.dynamicControl.init.after",
				id,
				control,
				params,
			);
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting(s).
		 *
		 * This is copied from api.Control.prototype.initialize(). It
		 * should be changed in Core to be applied once the control is embedded.
		 */
		_setUpSettingRootLinks: function (
			this: WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>,
		) {
			const control = this;
			const nodes = control.container.find("[data-customize-setting-link]");

			nodes.each(function (i, el) {
				const node = jQuery(this);
				const settingKey = this.dataset.customizeSettingLink;
				if (!settingKey) return;

				customizer(settingKey, function (setting) {
					// @ts-ignore The `new` operator has TS error (not runtime error).
					const element = new customizer.Element(node);
					control.elements.push(element);
					element.sync(setting);
					element.set(setting());
				});
			});
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting properties.
		 */
		_setUpSettingPropertyLinks: function (
			this: WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>,
		) {
			const control = this;
			let nodes;

			if (!control.setting) {
				return;
			}

			nodes = control.container.find("[data-customize-setting-property-link]");

			nodes.each(function () {
				const node = jQuery(this);
				let element: WpbfCustomizeElement;
				let propertyName = node.data("customizeSettingPropertyLink");

				// @ts-ignore The `new` operator has TS error (not runtime error).
				element = new customizer.Element(node);
				control.propertyElements.push(element);

				if (!control.setting || typeof control.setting !== "function") {
					return;
				}

				element.set(control.setting()[propertyName]);

				element.bind(function (newPropertyValue) {
					if (!control.setting || typeof control.setting !== "function") {
						return;
					}

					let newSetting = control.setting();

					if (newPropertyValue === newSetting[propertyName]) {
						return;
					}

					newSetting = _.clone(newSetting);
					newSetting[propertyName] = newPropertyValue;
					control.setting.set(newSetting);
				});

				control.setting.bind(function (newValue) {
					if (newValue[propertyName] !== element.get()) {
						element.set(newValue[propertyName]);
					}
				});
			});
		},

		/**
		 * @inheritdoc
		 */
		ready: function (
			this: WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>,
		) {
			const control = this;

			control._setUpSettingRootLinks?.();
			control._setUpSettingPropertyLinks?.();

			customizer.Control.prototype.ready.call(control);

			control.deferred.embedded.done(function () {
				control.initWpbfControl?.();
				window.wp.hooks.doAction(
					"wpbf.dynamicControl.ready.deferred.embedded.done",
					control,
				);
			});

			window.wp.hooks.doAction("wpbf.dynamicControl.ready.after", control);
		},

		/**
		 * Embed the control in the document.
		 *
		 * Override the embed() method to do nothing,
		 * so that the control isn't embedded on load,
		 * unless the containing section is already expanded.
		 */
		embed: function (
			this: WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>,
		) {
			const control = this;
			let sectionId = control.section();

			if (!sectionId) {
				return;
			}

			customizer.section(sectionId, function (section) {
				if (
					"wpbf-expanded" === section.params.type ||
					section.expanded() ||
					customizer.settings.autofocus.control === control.id
				) {
					control.actuallyEmbed?.();
				} else {
					section.expanded.bind(function (expanded) {
						if (expanded) {
							control.actuallyEmbed?.();
						}
					});
				}
			});
			window.wp.hooks.doAction("wpbf.dynamicControl.embed.after", control);
		},

		/**
		 * Deferred embedding of control when actually
		 *
		 * This function is called in Section.onChangeExpanded() so the control
		 * will only get embedded when the Section is first expanded.
		 */
		actuallyEmbed: function (
			this: WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>,
		) {
			const control = this;

			if ("resolved" === control.deferred.embedded.state()) {
				return;
			}
			control.renderContent();
			control.deferred.embedded.resolve(); // This triggers control.ready().
			window.wp.hooks.doAction(
				"wpbf.dynamicControl.actuallyEmbed.after",
				control,
			);
		},

		/**
		 * This is not working with autofocus.
		 */
		focus: function (
			this: WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>,
			args: Record<string, any>,
		) {
			const control = this;

			control.actuallyEmbed?.();
			customizer.Control.prototype.focus.call(control, args);
			window.wp.hooks.doAction("wpbf.dynamicControl.focus.after", control);
		},

		/**
		 * Additional actions that run on ready.
		 */
		initWpbfControl: function (
			this: WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>,
			control?: WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>,
		) {
			control = control || this;

			window.wp.hooks.doAction("wpbf.dynamicControl.initWpbfControl", this);

			// Save the value
			control.container.on("change keyup paste click", "input", function () {
				if (!control?.setting || typeof control?.setting !== "function") {
					return;
				}

				control?.setting?.set(jQuery(this).val());
			});
		},

		findHtmlEl: function (elOrSelector, selector) {
			if (!elOrSelector) return undefined;

			if (typeof elOrSelector === "string") {
				const result = document.querySelector(elOrSelector);

				return result instanceof HTMLElement ? result : undefined;
			}

			if (!selector) return undefined;

			const result = elOrSelector.querySelector(selector);

			return result instanceof HTMLElement ? result : undefined;
		},

		findHtmlEls: function (elOrSelector, selector) {
			if (!elOrSelector) return [];

			if (typeof elOrSelector === "string") {
				const result = document.querySelectorAll(elOrSelector);

				return Array.from(result).filter((el) => el instanceof HTMLElement);
			}

			if (!selector) return [];

			const result = elOrSelector.querySelectorAll(selector);

			return Array.from(result).filter((el) => el instanceof HTMLElement);
		},
	});
}
