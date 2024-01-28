import hooks from "@wordpress/hooks";
import jQuery from "jquery";
import _ from "lodash";
import {Control, Control_Params} from "wordpress__customize-browser/Control";
import {Element} from "wordpress__customize-browser/Element";

import "./base-control.scss";
import {WpbfCustomize, WpbfCustomizeControl} from "./interfaces";

declare var wp: {
	customize: WpbfCustomize;
	hooks: typeof hooks;
};

/**
 * This file was taken from Kirki.
 *
 * The majority of the code in this file
 * is derived from the wp-customize-posts plugin
 * and the work of @westonruter to whom I am very grateful.
 *
 * @see https://github.com/xwp/wp-customize-posts
 */

(function () {
	'use strict';

	wp.customize.wpbfDynamicControl = wp.customize.Control.extend({
		initialize: function (id: string, params: Control_Params) {
			const control: Control = this as WpbfCustomizeControl;

			if (!params.type) {
				params.type = 'wpbf-generic';
			}

			let className = '';

			if (params.content) {
				let splits = params.content.split('class="');
				splits = splits[1].split('"');
				className = splits[0];
			} else {
				className = 'customize-control customize-control-' + params.type;
			}

			if (params.content) {
				const $content = jQuery(params.content);
				$content.attr('id', 'customize-control-' + id.replace(/]/g, '').replace(/\[/g, '-'));
				$content.attr('class', className);

				const wrapperAttrs = params['wrapper_attrs'] ?? {};

				_.each(wrapperAttrs, function (val: any, key: string) {
					if ('class' === key) {
						val = val.replace('{default_class}', className);
					}

					$content.attr(key, val);
				});

				// Hijack the container to add wrapper_attrs.
				params.content = $content.prop('outerHTML');
			}


			control.propertyElements = [];
			wp.customize.Control.prototype.initialize.call(control, id, params);
			wp.hooks.doAction('wpbf.dynamicControl.init.after', id, control, params);
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting(s).
		 *
		 * This is copied from wp.customize.Control.prototype.initialize(). It
		 * should be changed in Core to be applied once the control is embedded.
		 */
		_setUpSettingRootLinks: function () {
			const control = this as WpbfCustomizeControl;
			const nodes = control.container.find('[data-customize-setting-link]');

			nodes.each(function () {
				const node = jQuery(this);

				wp.customize(node.data('customizeSettingLink'), function (setting) {
					const element = wp.customize.Element(node);

					control.elements.push(element);
					element.sync(setting);
					element.set(setting());
				});
			});
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting properties.
		 */
		_setUpSettingPropertyLinks: function () {
			const control = this as WpbfCustomizeControl;
			let nodes;

			if (!control.setting) {
				return;
			}

			nodes = control.container.find('[data-customize-setting-property-link]');

			nodes.each(function () {
				const node = jQuery(this);
				let element: Element;
				let propertyName = node.data('customizeSettingPropertyLink');

				element = wp.customize.Element(node);
				control.propertyElements.push(element);

				if (!control.setting || typeof control.setting !== 'function') {
					return;
				}

				element.set(control.setting()[propertyName]);

				element.bind(function (newPropertyValue) {
					if (!control.setting || typeof control.setting !== 'function') {
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
		ready: function () {
			const control = this as WpbfCustomizeControl;

			control._setUpSettingRootLinks?.();
			control._setUpSettingPropertyLinks?.();

			wp.customize.Control.prototype.ready.call(control);

			control.deferred.embedded.done(function () {
				control.initWpbfControl?.();
				wp.hooks.doAction('wpbf.dynamicControl.ready.deferred.embedded.done', control);
			});

			wp.hooks.doAction('wpbf.dynamicControl.ready.after', control);
		},

		/**
		 * Embed the control in the document.
		 *
		 * Override the embed() method to do nothing,
		 * so that the control isn't embedded on load,
		 * unless the containing section is already expanded.
		 */
		embed: function () {
			const control = this as WpbfCustomizeControl;
			let sectionId = control.section();

			if (!sectionId) {
				return;
			}

			wp.customize.section(sectionId, function (section) {
				if ('wpbf-expanded' === section.params.type || section.expanded() || wp.customize.settings.autofocus.control === control.id) {
					control.actuallyEmbed?.();
				} else {
					section.expanded.bind(function (expanded) {
						if (expanded) {
							control.actuallyEmbed?.();
						}
					});
				}
			});
			wp.hooks.doAction('wpbf.dynamicControl.embed.after', control);
		},

		/**
		 * Deferred embedding of control when actually
		 *
		 * This function is called in Section.onChangeExpanded() so the control
		 * will only get embedded when the Section is first expanded.
		 */
		actuallyEmbed: function () {
			const control = this as WpbfCustomizeControl;

			if ('resolved' === control.deferred.embedded.state()) {
				return;
			}
			control.renderContent();
			control.deferred.embedded.resolve(); // This triggers control.ready().
			wp.hooks.doAction('wpbf.dynamicControl.actuallyEmbed.after', control);
		},

		/**
		 * This is not working with autofocus.
		 */
		focus: function (args: Record<string, any>) {
			const control = this as WpbfCustomizeControl;

			control.actuallyEmbed?.();
			wp.customize.Control.prototype.focus.call(control, args);
			wp.hooks.doAction('wpbf.dynamicControl.focus.after', control);
		},

		/**
		 * Additional actions that run on ready.
		 */
		initWpbfControl: function (control?: Control) {
			control = control ?? this as WpbfCustomizeControl;

			wp.hooks.doAction('wpbf.dynamicControl.initWpbfControl', this);

			// Save the value
			control.container.on('change keyup paste click', 'input', function () {
				if (!control?.setting || typeof control?.setting !== 'function') {
					return;
				}

				control?.setting?.set(jQuery(this).val());
			});
		}
	});
}());

(function (api) {
	/**
	 * Set the value and trigger all bound callbacks.
	 */
	api.Value.prototype.set = function (to: any) {
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
	api.Value.prototype.get = function () {

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
}(wp.customize));
