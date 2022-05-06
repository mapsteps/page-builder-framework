/**
 * WordPress dependencies.
 */
import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";

/**
 * Internal dependencies.
 */
import metadata from "../../../blocks/notices/block.json";
import transforms from "./transforms";
import edit from "./edit";
import save from "./save";
import variations from "./variations";

const { name } = metadata;

export { metadata, name };

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
registerBlockType("wpbf/notices", {
	icon: 'info',

	example: {
		innerBlocks: [
			{
				name: "wpbf/notice",
				attributes: {
					message: __("Sample of notice message", "page-builder-framework"),
				},
			},
			{
				name: "wpbf/notice",
				attributes: {
					message: __("Sample of success message", "page-builder-framework"),
					typeClassName: "wpbf-notice-success",
				},
			},
			{
				name: "wpbf/notice",
				attributes: {
					message: __("Sample of warning message", "page-builder-framework"),
					typeClassName: "wpbf-notice-warning",
				},
			},
			{
				name: "wpbf/notice",
				attributes: {
					message: __("Sample of error message", "page-builder-framework"),
					typeClassName: "wpbf-notice-error",
				},
			},
		],
	},

	/**
	 * @see ./transforms.js
	 */
	transforms,

	/**
	 * @see ./edit.js
	 */
	edit,

	/**
	 * @see ./save.js
	 */
	save,

	/**
	 * @see ./variations.js
	 */
	variations,
});
