import hooks from "@wordpress/hooks";
import _ from "lodash";

import "./base-control.scss";

import { WpbfCustomize } from "./interface";
import setupDynamicControl from "./dynamic-control";
import setupControlDependencies from "./control-dependencies";
import { setupTooltips } from "./tooltips";

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

setupDynamicControl();
setupControlDependencies();
setupTooltips();

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
})(wp.customize);
