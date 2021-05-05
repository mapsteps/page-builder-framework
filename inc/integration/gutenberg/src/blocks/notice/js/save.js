import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Defines the way in which the different attributes should be combined into the final markup,
 * which is then serialized by the block editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
export default function save({ attributes }) {
	return (
		<div {...useBlockProps.save()}>
			<div class="wpbf-notice">
				{attributes.message}
			</div>
		</div>
	);
}
