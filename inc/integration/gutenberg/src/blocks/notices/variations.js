/**
 * WordPress dependencies
 */
import { __ } from "@wordpress/i18n";

const variations = [
	{
		name: "notices-horizontal",
		isDefault: true,
		title: __("Horizontal", "page-builder-framework"),
		description: __("Notices shown in a row.", "page-builder-framework"),
		attributes: { orientation: "horizontal" },
		scope: ["transform"],
	},
	{
		name: "notices-vertical",
		title: __("Vertical", "page-builder-framework"),
		description: __("Notices shown in a column.", "page-builder-framework"),
		attributes: { orientation: "vertical" },
		scope: ["transform"],
	},
];

export default variations;
