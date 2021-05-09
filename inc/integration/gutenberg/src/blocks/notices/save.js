/**
 * External dependencies
 */
import classnames from "classnames";

/**
 * WordPress dependencies
 */
import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

function save({
	attributes: { contentJustification, orientation },
	className,
}) {
	const noticesClassName = classnames(
		className,
		"wpbf-block wpbf-block-notices",
		{
			[`wpbf-content-justified-${contentJustification}`]: contentJustification,
			"wpbf-is-vertical": orientation === "vertical",
		}
	);

	return (
		<div
			{...useBlockProps.save({
				className: noticesClassName
			})}
		>
			<InnerBlocks.Content />
		</div>
	);
}

export default save;
