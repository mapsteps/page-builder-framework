import "./radio-control.scss";

declare var wp: {
	customize: WpbfCustomize;
};

wp.customize.controlConstructor["wpbf-radio"] =
	wp.customize.wpbfDynamicControl.extend({});

wp.customize.controlConstructor["wpbf-radio-buttonset"] =
	wp.customize.wpbfDynamicControl.extend({});

wp.customize.controlConstructor["wpbf-radio-image"] =
	wp.customize.wpbfDynamicControl.extend({});
