import _ from "lodash";

import setupControlDependencies from "./control-dependencies";
import { wpbfSetupTooltips } from "./tooltips";
import {
	WpbfCustomizeControl,
	WpbfCustomizeControlParams,
	WpbfCustomizeElement,
} from "./base-interface";

/**
 * This file was taken from Kirki.
 *
 * The majority of the code in this file
 * is derived from the wp-customize-posts plugin
 * and the work of @westonruter to whom I am very grateful.
 *
 * @see https://github.com/xwp/wp-customize-posts
 */

(function (customizer) {
	if (!customizer) return;

	customizer.wpbfDynamicControl = customizer.Control.extend<
		WpbfCustomizeControl<any, WpbfCustomizeControlParams<any>>
	>({
		initialize: function initialize(
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
		_setUpSettingRootLinks: function _setUpSettingRootLinks(
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
		_setUpSettingPropertyLinks: function _setUpSettingPropertyLinks(
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
		ready: function ready() {
			this._setUpSettingRootLinks?.();
			this._setUpSettingPropertyLinks?.();

			customizer.Control.prototype.ready.call(this);

			this.deferred?.embedded.done(() => {
				this.initWpbfControl?.();

				window.wp.hooks.doAction(
					"wpbf.dynamicControl.ready.deferred.embedded.done",
					this,
				);
			});

			window.wp.hooks.doAction("wpbf.dynamicControl.ready.after", this);
		},

		/**
		 * Embed the control in the document.
		 *
		 * Override the embed() method to do nothing,
		 * so that the control isn't embedded on load,
		 * unless the containing section is already expanded.
		 */
		embed: function embed() {
			let sectionId = this.section?.();
			if (!sectionId) return;

			customizer.section(sectionId, (section) => {
				if (
					"wpbf-expanded" === section.params.type ||
					section.expanded() ||
					customizer.settings.autofocus.control === this.id
				) {
					this.actuallyEmbed?.();
				} else {
					section.expanded.bind((expanded) => {
						if (expanded) this.actuallyEmbed?.();
					});
				}
			});

			window.wp.hooks.doAction("wpbf.dynamicControl.embed.after", this);
		},

		/**
		 * Deferred embedding of control when actually
		 *
		 * This function is called in Section.onChangeExpanded() so the control
		 * will only get embedded when the Section is first expanded.
		 */
		actuallyEmbed: function actuallyEmbed() {
			if (this.isEmbedded) {
				return;
			}

			this.renderContent?.();

			// This triggers control.ready().
			this.deferred?.embedded.resolve();
			this.isEmbedded = true;

			window.wp.hooks.doAction("wpbf.dynamicControl.actuallyEmbed.after", this);
		},

		/**
		 * This is not working with autofocus.
		 */
		focus: function focus(args: Record<string, any>) {
			this.actuallyEmbed?.();
			customizer.Control.prototype.focus.call(this, args);
			window.wp.hooks.doAction("wpbf.dynamicControl.focus.after", this);
		},

		/**
		 * Additional actions that run on ready.
		 */
		initWpbfControl: function initWpbfControl(ctrl) {
			window.wp.hooks.doAction("wpbf.dynamicControl.initWpbfControl", this);

			const control = this;

			// Save the value
			this.container?.on("change input paste click", "input", function () {
				control.setting?.set(this.value);
			});
		},

		destroy: function () {
			this.container?.off("change input paste click", "input");
			this.isEmbedded = false;
		},

		updateCustomizerSetting: function updateCustomizerSetting(val) {
			this.setting?.set(val);
		},

		findHtmlEl: function findHtmlEl(elOrSelector, selector) {
			if (!elOrSelector) return undefined;

			if (typeof elOrSelector === "string") {
				const result = document.querySelector(elOrSelector);

				return result instanceof HTMLElement ? result : undefined;
			}

			if (!selector) return undefined;

			const result = elOrSelector.querySelector(selector);

			return result instanceof HTMLElement ? result : undefined;
		},

		findHtmlEls: function findHtmlEls(elOrSelector, selector) {
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

	customizer.bind("ready", () => {
		wpbfSetupTooltips(customizer);
	});

	if (window.wpbfCustomizerControlDependencies) {
		setupControlDependencies(window.wpbfCustomizerControlDependencies);
	}

	/**
	 * Set the value and trigger all bound callbacks.
	 */
	customizer.Value.prototype.set = function (to: any) {
		const from = this._value;

		to = this._setter.apply(this, arguments);
		to = this.validate(to);

		// Bail if the sanitized value is null or unchanged.
		if (null === to || _.isEqual(from, to)) {
			return this;
		}

		/**
		 * This was brought from Kirki.
		 * But this is too much for now.
		 *
		 * Start Kirki mod.
		 */
		/*
		let parentSetting;
		let newVal;
		if (this.id && api.control(this.id) && api.control(this.id).params && api.control(this.id).params.parent_setting) {
			parentSetting = api.control(this.id).params.parent_setting;
			newVal = {};
			newVal[this.id.replace(parentSetting + '[', '').replace(']', '')] = to;
			api.control(parentSetting).setting.set(jQuery.extend({}, api.control(parentSetting).setting._value, newVal));
		}
		*/

		// End Kirki mod.

		this._value = to;
		this._dirty = true;

		this.callbacks.fireWith(this, [to, from]);

		return this;
	};

	/**
	 * Get the value.
	 */
	customizer.Value.prototype.get = function () {
		/**
		 * This was brought from Kirki.
		 * But this is too much for now.
		 *
		 * Start Kirki mod.
		 */
		/*
		let parentSetting;

		if (this.id && api.control(this.id) && api.control(this.id).params && api.control(this.id).params.parent_setting) {
			parentSetting = api.control(this.id).params.parent_setting;
			return api.control(parentSetting).setting.get()[this.id.replace(parentSetting + '[', '').replace(']', '')];
		}
		*/
		// End Kirki mod.

		return this._value;
	};
})(window.wp.customize);
