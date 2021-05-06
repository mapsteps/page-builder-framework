import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';

/**
 * Defines the way in which the different attributes should be combined into the final markup,
 * which is then serialized by the block editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
export default function save({ attributes }) {
	const { type, message, contentAlignment, className, id } = attributes;
	let textAlignClassName;
	
	switch (contentAlignment) {
		case 'left':
			textAlignClassName = 'wpbf-text-left';
			break;

		case 'center':
			textAlignClassName = 'wpbf-text-center';
			break;

		case 'right':
			textAlignClassName = 'wpbf-text-right';
			break;

		case 'justify':
			textAlignClassName = 'wpbf-text-justify';
			break;
	
		default:
			break;
	}

	const defaultClassName = 'wpbf-block wpbf-notice-block wpbf-notice ' + textAlignClassName;

	return (
		<div {...useBlockProps.save()}>
			<div class={defaultClassName}>
				<RichText.Content tagName="" value={message} />
			</div>
		</div>
	);
}
