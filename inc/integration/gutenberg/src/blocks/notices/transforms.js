/**
 * WordPress dependencies
 */
import { createBlock } from "@wordpress/blocks";

/**
 * Internal dependencies
 */
import { name } from "../../../blocks/notices/block.json";

const transforms = {
	from: [
		{
			type: "block",
			isMultiBlock: true,
			blocks: ["wpbf/notice"],
			transform: (notices) =>
				// Creates the notices block
				createBlock(
					name,
					{},
					// Loop the selected notices
					notices.map((attributes) =>
						// Create singular notice in the notices block
						createBlock("wpbf/notice", attributes)
					)
				),
		},
		{
			type: "block",
			isMultiBlock: true,
			blocks: ["core/paragraph"],
			transform: (notices) =>
				// Creates the notices block
				createBlock(
					name,
					{},
					// Loop the selected notices
					notices.map((attributes) => {
						// Create singular notice in the notices block
						return createBlock("wpbf/notice", {
							message: attributes.content,
						});
					})
				),
		},
	],
};

export default transforms;
