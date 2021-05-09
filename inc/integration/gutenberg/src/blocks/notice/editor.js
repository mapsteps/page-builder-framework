/**
 * WordPress dependencies.
 */
import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";
import { info as icon } from "@wordpress/icons";

/**
 * Internal dependencies.
 */
import metadata from "../../../blocks/notice/block.json";
import edit from "./edit";
import save from "./save";

const { name } = metadata;

export { metadata, name };

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
registerBlockType("wpbf/notice", {
	icon,

	example: {
		attributes: {
			typeClassName: "wpbf-notice-success",
			message: __("Sample of success message", "page-builder-framework"),
		},
	},

	/**
	 * @see ./edit.js
	 */
	edit,

	/**
	 * @see ./save.js
	 */
	save,
});
